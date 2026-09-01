<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ExcelImportController extends Controller
{
    /**
     * Handle upload dan import file CSV / Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|max:20480', // Maks 20MB
        ], [
            'excel_file.required' => 'Silakan pilih file spreadsheet yang ingin diimpor.',
            'excel_file.file'     => 'File yang diunggah tidak valid.',
            'excel_file.max'      => 'Ukuran file maksimal adalah 20MB.',
        ]);

        $file = $request->file('excel_file');
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, ['csv', 'txt', 'xlsx', 'xls'])) {
            return back()->with('error', 'Format file tidak didukung. Harap unggah file berformat .csv atau .txt.');
        }

        $realPath = $file->getRealPath();

        // Deteksi delimiter (koma atau titik koma)
        $firstLine = file_get_contents($realPath, false, null, 0, 2048);
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

        $handle = fopen($realPath, 'r');
        if (!$handle) {
            return back()->with('error', 'Gagal membuka file yang diunggah.');
        }

        // Baca baris header
        $rawHeaders = fgetcsv($handle, 0, $delimiter);
        if (!$rawHeaders) {
            fclose($handle);
            return back()->with('error', 'File kosong atau baris header tidak ditemukan.');
        }

        // Normalisasi nama header: hilangkan UTF-8 BOM, trim, lowercase, ganti spasi ganda
        $headers = array_map(function ($h) {
            $h = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h); // Hapus BOM
            $h = strtolower(trim($h));
            $h = preg_replace('/\s+/', ' ', $h);
            return $h;
        }, $rawHeaders);

        $rowCount = 0;
        $errorsCount = 0;

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                // Abaikan baris kosong
                if (empty(array_filter($row))) {
                    continue;
                }

                // Cocokkan data dengan header
                $rowCombined = [];
                foreach ($headers as $index => $headerName) {
                    $rowCombined[$headerName] = isset($row[$index]) ? trim($row[$index]) : '';
                }

                // ── 1. Ekstraksi Data Tenant ──────────────────────────────────
                $tenantName = $this->getValue($rowCombined, ['nama penyewa', 'nama mitra', 'penyewa', 'mitra', 'fullname'], 'Penyewa Default');
                $brand = $this->getValue($rowCombined, ['brand', 'merek', 'nama usaha', 'nama toko']);
                $statusCustomer = $this->getValue($rowCombined, ['status customer', 'status', 'status mitra'], 'Aktif');
                $jenisPerusahaan = $this->getValue($rowCombined, ['jenis perusahaan', 'bentuk usaha', 'tipe perusahaan'], 'PT');

                // Cari atau buat tenant
                $existingTenant = DB::table('tenants')->where('fullname', $tenantName)->first();
                if ($existingTenant) {
                    $tenantId = $existingTenant->id;
                    DB::table('tenants')->where('id', $tenantId)->update([
                        'brand'            => $brand ?: $existingTenant->brand,
                        'status_customer'  => $statusCustomer ?: $existingTenant->status_customer,
                        'jenis_perusahaan' => $jenisPerusahaan ?: $existingTenant->jenis_perusahaan,
                    ]);
                } else {
                    $tenantId = DB::table('tenants')->insertGetId([
                        'fullname'         => $tenantName,
                        'brand'            => $brand,
                        'status_customer'  => $statusCustomer,
                        'jenis_perusahaan' => $jenisPerusahaan,
                        'created_at'       => now(),
                    ]);
                }

                // ── 2. Ekstraksi Data Aset ────────────────────────────────────
                $assetNumber = $this->getValue($rowCombined, ['no aset', 'kode aset', 'nomor aset', 'asset_number', 'no_aset']);
                if (!$assetNumber) {
                    $assetNumber = 'AST-' . strtoupper(substr(md5($tenantName . $rowCount), 0, 8));
                }

                $assetBlockName = $this->getValue($rowCombined, ['nama blok aset', 'nama aset', 'blok aset', 'lokasi aset', 'asset_block_name'], $assetNumber);
                $jenisAsset = $this->getValue($rowCombined, ['jenis aset', 'jenis asset', 'jenis_asset', 'tipe aset'], 'Tanah');
                $stasiun = $this->getValue($rowCombined, ['stasiun', 'lokasi stasiun'], 'Semarang Poncol');
                $wilayah = $this->getValue($rowCombined, ['wilayah aset', 'wilayah', 'daop', 'wilayah_asset'], 'Daop 4 Semarang');
                $sizeArea = $this->cleanNumber($this->getValue($rowCombined, ['luas area', 'luas', 'size_area', 'luas m2']));
                $peruntukan = $this->getValue($rowCombined, ['peruntukan', 'kegunaan', 'fungsi lahan']);
                $latitude = $this->cleanCoordinate($this->getValue($rowCombined, ['latitude', 'lat']));
                $longitude = $this->cleanCoordinate($this->getValue($rowCombined, ['longitude', 'long', 'lng']));

                DB::table('assets')->updateOrInsert(
                    ['asset_number' => $assetNumber],
                    [
                        'asset_block_name' => $assetBlockName,
                        'jenis_asset'      => $jenisAsset,
                        'stasiun'          => $stasiun,
                        'wilayah_asset'    => $wilayah,
                        'size_area'        => $sizeArea ?: null,
                        'peruntukan'       => $peruntukan,
                        'latitude'         => $latitude ?: null,
                        'longitude'        => $longitude ?: null,
                        'created_at'       => now(),
                    ]
                );

                // ── 3. Ekstraksi Data Kontrak ─────────────────────────────────
                $contractNumber = $this->getValue($rowCombined, ['no kontrak', 'nomor kontrak', 'contract_number', 'no_kontrak']);
                if (!$contractNumber) {
                    $contractNumber = 'KTR-' . date('Y') . '-' . sprintf('%04d', $rowCount + 1);
                }

                $contractDate = $this->parseDate($this->getValue($rowCombined, ['tgl kontrak', 'tanggal kontrak', 'contract_date']));
                $jenisKontrak = $this->getValue($rowCombined, ['jenis kontrak', 'jenis_kontrak'], 'Sewa');
                $areaKontrak = $this->getValue($rowCombined, ['area kontrak', 'area_kontrak'], 'Non Row');
                $startDatetime = $this->parseDate($this->getValue($rowCombined, ['awal kontrak', 'tgl mulai', 'start date', 'mulai kontrak', 'start_datetime']));
                $endDatetime = $this->parseDate($this->getValue($rowCombined, ['selesai kontrak', 'tgl akhir', 'end date', 'akhir kontrak', 'end_datetime']));
                $startDatetimeBaru = $this->parseDate($this->getValue($rowCombined, ['awal kontrak baru', 'start_datetime_baru']));
                $endDatetimeBaru = $this->parseDate($this->getValue($rowCombined, ['selesai kontrak baru', 'end_datetime_baru']));
                $price = $this->cleanNumber($this->getValue($rowCombined, ['harga', 'nilai kontrak', 'nilai sewa', 'price', 'total harga']));
                $spv = $this->getValue($rowCombined, ['spv', 'supervisor', 'pengawas']);
                $keterangan = $this->getValue($rowCombined, ['keterangan', 'catatan', 'notes']);

                DB::table('contracts')->updateOrInsert(
                    ['contract_number' => $contractNumber],
                    [
                        'tenant_id'           => $tenantId,
                        'asset_number'        => $assetNumber,
                        'contract_date'       => $contractDate,
                        'jenis_kontrak'       => $jenisKontrak,
                        'area_kontrak'        => $areaKontrak,
                        'start_datetime'      => $startDatetime,
                        'end_datetime'        => $endDatetime,
                        'start_datetime_baru' => $startDatetimeBaru,
                        'end_datetime_baru'   => $endDatetimeBaru,
                        'price'               => $price ?: 0,
                        'spv'                 => $spv,
                        'keterangan'          => $keterangan,
                        'created_at'          => now(),
                    ]
                );

                // ── 4. Ekstraksi Data Financial / Backlog ──────────────────────
                $nilaiBacklog = $this->cleanNumber($this->getValue($rowCombined, ['nilai backlog', 'backlog 1', 'nilai_backlog']));
                $nilaiBacklog2 = $this->cleanNumber($this->getValue($rowCombined, ['nilai backlog 2', 'nilai backlog2', 'backlog 2', 'nilai_backlog2']));
                $glAccount = $this->getValue($rowCombined, ['akun gl', 'gl account', 'gl_account', 'kode akun']);
                $hari2026 = (int) $this->cleanNumber($this->getValue($rowCombined, ['hari 2026', 'hari_2026', 'jumlah hari 2026']));
                $nilaiPerHari = $this->cleanNumber($this->getValue($rowCombined, ['nilai perhari', 'nilai per hari', 'nilai_per_hari']));
                $formRka = $this->getValue($rowCombined, ['form rka', 'form_rka', 'nomor rka']);
                $tahunRka = (int) $this->getValue($rowCombined, ['tahun rka', 'tahun_rka'], 2026);
                $jenisPendapatan = $this->getValue($rowCombined, ['jenis pendapatan', 'jenis_pendapatan'], 'Pendapatan Sewa Non Angkutan');

                DB::table('contract_financials')->updateOrInsert(
                    ['contract_number' => $contractNumber],
                    [
                        'nilai_backlog'    => $nilaiBacklog ?: 0,
                        'nilai_backlog2'   => $nilaiBacklog2 ?: 0,
                        'gl_account'       => $glAccount,
                        'hari_2026'        => $hari2026 ?: 0,
                        'nilai_per_hari'   => $nilaiPerHari ?: 0,
                        'form_rka'         => $formRka,
                        'tahun_rka'        => $tahunRka ?: 2026,
                        'jenis_pendapatan' => $jenisPendapatan,
                    ]
                );

                // ── 5. Ekstraksi Data Monthly Schedules (Jan - Des) ───────────
                $invoice = $this->getValue($rowCombined, ['invoice', 'no invoice', 'nomor invoice']);
                $jan = $this->cleanNumber($this->getValue($rowCombined, ['januari', 'jan']));
                $feb = $this->cleanNumber($this->getValue($rowCombined, ['februari', 'febuari', 'feb']));
                $mar = $this->cleanNumber($this->getValue($rowCombined, ['maret', 'mar']));
                $apr = $this->cleanNumber($this->getValue($rowCombined, ['april', 'apr']));
                $mei = $this->cleanNumber($this->getValue($rowCombined, ['mei', 'may']));
                $jun = $this->cleanNumber($this->getValue($rowCombined, ['juni', 'jun']));
                $jul = $this->cleanNumber($this->getValue($rowCombined, ['juli', 'jul']));
                $agu = $this->cleanNumber($this->getValue($rowCombined, ['agustus', 'agu', 'agt']));
                $sep = $this->cleanNumber($this->getValue($rowCombined, ['september', 'sep', 'sept']));
                $okt = $this->cleanNumber($this->getValue($rowCombined, ['oktober', 'okt', 'oct']));
                $nov = $this->cleanNumber($this->getValue($rowCombined, ['november', 'nov']));
                $des = $this->cleanNumber($this->getValue($rowCombined, ['desember', 'des', 'dec']));
                $janDes = $this->cleanNumber($this->getValue($rowCombined, ['total jan-des', 'jan-des', 'jan_des', 'total tahunan']));

                if (!$janDes && ($jan || $feb || $mar || $apr || $mei || $jun || $jul || $agu || $sep || $okt || $nov || $des)) {
                    $janDes = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $agu + $sep + $okt + $nov + $des;
                }

                DB::table('monthly_schedules')->updateOrInsert(
                    ['contract_number' => $contractNumber, 'tahun' => 2026],
                    [
                        'invoice'   => $invoice,
                        'januari'   => $jan ?: 0,
                        'febuari'   => $feb ?: 0,
                        'maret'     => $mar ?: 0,
                        'april'     => $apr ?: 0,
                        'mei'       => $mei ?: 0,
                        'juni'      => $jun ?: 0,
                        'juli'      => $jul ?: 0,
                        'agustus'   => $agu ?: 0,
                        'september' => $sep ?: 0,
                        'oktober'   => $okt ?: 0,
                        'november'  => $nov ?: 0,
                        'desember'  => $des ?: 0,
                        'jan_des'   => $janDes ?: 0,
                    ]
                );

                $rowCount++;
            }

            DB::commit();
            fclose($handle);

            return back()->with('success', "Berhasil mengimpor dan memperbarui {$rowCount} data kontrak ke seluruh tabel database!");

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Gagal memproses data: ' . $e->getMessage());
        }
    }

    /**
     * Download template CSV standar siap isi.
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_import_kai.csv"',
        ];

        $columns = [
            'No Kontrak', 'Nama Penyewa', 'Brand', 'Status Customer', 'Jenis Perusahaan',
            'No Aset', 'Nama Blok Aset', 'Jenis Aset', 'Stasiun', 'Wilayah', 'Luas Area', 'Peruntukan', 'Latitude', 'Longitude',
            'Awal Kontrak', 'Selesai Kontrak', 'Awal Kontrak Baru', 'Selesai Kontrak Baru', 'Harga', 'SPV', 'Keterangan',
            'Nilai Backlog', 'Nilai Backlog 2', 'Akun GL', 'Hari 2026', 'Nilai Perhari', 'Form RKA', 'Tahun RKA', 'Jenis Pendapatan',
            'Invoice', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Total Jan-Des'
        ];

        $sampleRow = [
            'HK.201/XI/1/SM.2023', 'PT Kargo Cepat Pantura', 'KCP Logistics', 'Aktif', 'PT',
            'AST-SMG-PCL-005', 'Depo Logistik Poncol', 'Tanah & Bangunan', 'Semarang Poncol', 'Daop 4 Semarang', '850.00', 'Logistik', '-6.969700', '110.413700',
            '2026-01-01', '2027-12-31', '2026-01-01', '2027-12-31', '380000000', 'SPV Komersial Daop 4', 'Aset lahan pergudangan sisi timur',
            '15000000', '7500000', '411101', '365', '1041095', 'RKA-2026-LOG', '2026', 'Pendapatan Sewa Non Angkutan',
            'INV-2026-001', '31666666', '31666666', '31666666', '31666666', '31666666', '31666666', '31666666', '31666666', '31666666', '31666666', '31666666', '31666674', '380000000'
        ];

        $callback = function () use ($columns, $sampleRow) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';');
            fputcsv($file, $sampleRow, ';');
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Ambil nilai dari array berdasarkan beberapa kemungkinan nama key alias.
     */
    private function getValue(array $row, array $aliases, $default = null)
    {
        foreach ($aliases as $alias) {
            if (isset($row[$alias]) && $row[$alias] !== '') {
                return $row[$alias];
            }
        }
        return $default;
    }

    /**
     * Bersihkan format angka/nominal (hapus Rp, titik, spasi, koma).
     */
    private function cleanNumber(?string $value): float
    {
        if (empty($value)) return 0;
        // Ganti koma pecahan menjadi titik jika ada
        $clean = preg_replace('/[^0-9,\.]/', '', $value);
        // Jika format Indonesia: 10.000.000,50 -> 10000000.50
        if (substr_count($clean, '.') > 0 && substr_count($clean, ',') === 1) {
            $clean = str_replace('.', '', $clean);
            $clean = str_replace(',', '.', $clean);
        } else {
            $clean = str_replace(',', '', $clean);
        }
        return (float) $clean;
    }

    /**
     * Bersihkan koordinat peta (tetap simpan tanda minus - dan titik).
     */
    private function cleanCoordinate(?string $value): ?float
    {
        if (empty($value)) return null;
        $clean = preg_replace('/[^0-9\.\-]/', '', $value);
        return is_numeric($clean) ? (float) $clean : null;
    }

    /**
     * Parse tanggal dari berbagai format (DD/MM/YYYY, YYYY-MM-DD, Excel format).
     */
    private function parseDate(?string $dateStr): ?string
    {
        if (empty($dateStr)) return null;
        try {
            return Carbon::parse(str_replace('/', '-', $dateStr))->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
