<?php

namespace App\Http\Controllers;

use App\Models\KaiAsset;
use App\Models\KaiContract;
use App\Models\ContractFinancial;
use App\Models\MonthlySchedule;
use App\Models\Penyewa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExcelImportController extends Controller
{
    /**
     * Handle Import Excel / CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|max:30720', // max 30MB
        ], [
            'excel_file.required' => 'Silakan pilih file Excel (.xlsx, .xls, .csv) terlebih dahulu.',
            'excel_file.file'     => 'File yang diupload tidak valid.',
            'excel_file.max'      => 'Ukuran file maksimal adalah 30 MB.',
        ]);

        $file = $request->file('excel_file');
        $ext  = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext, ['csv', 'txt', 'xlsx', 'xls'])) {
            return back()->with('error', 'Format file tidak didukung. Harap gunakan format .xlsx, .xls, atau .csv');
        }

        try {
            $rows = $this->parseFileRows($file, $ext);

            if (empty($rows)) {
                return back()->with('error', 'File tidak memiliki baris data atau kosong.');
            }

            // Normalisasi header (baris pertama)
            $headerRow = array_shift($rows);
            $normalizedHeaders = array_map(function ($h) {
                return $this->normalizeHeaderName($h);
            }, $headerRow);

            $importedCount = 0;
            $updatedCount  = 0;

            DB::beginTransaction();

            foreach ($rows as $rowIndex => $row) {
                // Lewati baris kosong
                if (empty(array_filter($row, fn($val) => $val !== null && trim((string)$val) !== ''))) {
                    continue;
                }

                $rowNum = $rowIndex + 1;

                // Map header -> value
                $data = [];
                foreach ($normalizedHeaders as $idx => $key) {
                    if ($key !== '') {
                        $data[$key] = isset($row[$idx]) ? trim((string)$row[$idx]) : null;
                    }
                }

                // ── 1. NOMOR KONTRAK & NOMOR ASET ─────────────────────────
                $contractNumber = $this->extractField($data, [
                    'contract_number', 'nomor_kontrak', 'no_kontrak', 'no_perjanjian',
                    'nomor_perjanjian', 'no_surat', 'kode_kontrak', 'contract_no',
                    'id_kontrak', 'no_pks', 'nomor_pks', 'nomor', 'no'
                ]);

                $assetNumber = $this->extractField($data, [
                    'asset_number', 'nomor_aset', 'no_aset', 'no_asset', 'kode_aset',
                    'id_aset', 'nomor_blok', 'asset_no', 'no_peta', 'no_kavling', 'id_asset'
                ]);

                if (!$contractNumber && !$assetNumber) {
                    $contractNumber = 'KTR-' . str_pad($rowNum, 4, '0', STR_PAD_LEFT);
                    $assetNumber    = 'AST-' . str_pad($rowNum, 4, '0', STR_PAD_LEFT);
                } elseif ($contractNumber && !$assetNumber) {
                    $assetNumber    = 'AST-' . $contractNumber;
                } elseif (!$contractNumber && $assetNumber) {
                    $contractNumber = 'KTR-' . $assetNumber;
                }

                // ── 2. PENYEWA (tenants) ──────────────────────────────────
                $fullname = $this->extractField($data, [
                    'fullname', 'nama_penyewa', 'penyewa', 'nama_mitra', 'mitra',
                    'nama_customer', 'customer', 'nama_lengkap', 'nama_instansi',
                    'nama_pt', 'perusahaan', 'nama', 'tenant'
                ]);

                if (!$fullname || trim($fullname) === '' || strtolower(trim($fullname)) === 'kosong') {
                    $fullname = 'Mitra KAI (' . $contractNumber . ')';
                }

                $rawBrand = $this->extractField($data, ['brand', 'merek', 'merk', 'nama_brand', 'usaha', 'nama_usaha']);
                $brand = ($rawBrand && strtolower(trim($rawBrand)) !== 'kosong') ? $rawBrand : null;

                $rawStatus = $this->extractField($data, ['status_customer', 'status_mitra', 'status_penyewa', 'status', 'kategori_customer', 'ket']);
                $statusCustomer = ($rawStatus && strtolower(trim($rawStatus)) !== 'kosong') ? $rawStatus : 'Aktif';

                $rawJenisPerusahaan = $this->extractField($data, ['jenis_perusahaan', 'badan_usaha', 'bentuk_usaha', 'tipe_perusahaan']);
                $jenisPerusahaan = ($rawJenisPerusahaan && strtolower(trim($rawJenisPerusahaan)) !== 'kosong') ? $rawJenisPerusahaan : 'Perorangan';

                $tenant = Penyewa::firstOrCreate(
                    ['fullname' => $fullname],
                    [
                        'brand'            => $brand,
                        'status_customer'  => $statusCustomer,
                        'jenis_perusahaan' => $jenisPerusahaan,
                        'created_at'       => now(),
                    ]
                );

                // Selalu perbarui tenant jika ada perubahan data status/brand/jenis
                $tenantUpdatePayload = [];
                if ($brand !== null && $tenant->brand !== $brand) {
                    $tenantUpdatePayload['brand'] = $brand;
                }
                if ($statusCustomer && $tenant->status_customer !== $statusCustomer) {
                    $tenantUpdatePayload['status_customer'] = $statusCustomer;
                }
                if ($jenisPerusahaan && $tenant->jenis_perusahaan !== $jenisPerusahaan) {
                    $tenantUpdatePayload['jenis_perusahaan'] = $jenisPerusahaan;
                }
                if (!empty($tenantUpdatePayload)) {
                    $tenant->update($tenantUpdatePayload);
                }

                $tenantId = $tenant->id;

                // ── 3. ASET (assets) ──────────────────────────────────────
                $assetBlockName = $this->extractField($data, [
                    'asset_block_name', 'nama_blok_aset', 'nama_aset', 'nama_lokasi',
                    'lokasi', 'alamat', 'nama_objek', 'objek_sewa', 'letak_tanah', 'blok'
                ]);
                if (!$assetBlockName || strtolower(trim($assetBlockName)) === 'kosong') {
                    $assetBlockName = 'Lahan ' . $fullname;
                }

                $sizeArea       = $this->parseNumber($this->extractField($data, ['size_area', 'luas_area', 'luas_tanah', 'luas_bangunan', 'luas_sewa', 'area_kontrak', 'luas', 'volume'])) ?: 100.0;
                
                $rawPeruntukan  = $this->extractField($data, ['peruntukan', 'penggunaan', 'kegunaan', 'tujuan_sewa', 'jenis_usaha', 'keperluan']);
                $peruntukan     = ($rawPeruntukan && strtolower(trim($rawPeruntukan)) !== 'kosong') ? $rawPeruntukan : 'Komersial';

                $rawJenisAset   = $this->extractField($data, ['jenis_aset', 'jenis_asset', 'kategori_aset', 'tipe_aset', 'klasifikasi_aset']);
                $jenisAsset     = ($rawJenisAset && strtolower(trim($rawJenisAset)) !== 'kosong') ? $rawJenisAset : 'Tanah';

                $rawStasiun     = $this->extractField($data, ['stasiun', 'nama_stasiun', 'wilayah_stasiun', 'lintas']);
                $stasiun        = ($rawStasiun && strtolower(trim($rawStasiun)) !== 'kosong') ? $rawStasiun : 'Semarang Tawang';

                $rawWilayah     = $this->extractField($data, ['wilayah_aset', 'wilayah_asset', 'wilayah', 'daop', 'divre', 'unit']);
                $wilayahAsset   = ($rawWilayah && strtolower(trim($rawWilayah)) !== 'kosong') ? $rawWilayah : 'Daop 4 Semarang';

                $description    = $this->extractField($data, ['description', 'deskripsi', 'rincian', 'kondisi']);
                $subTitle       = $this->extractField($data, ['sub_title', 'subtitle', 'keterangan_lokasi', 'kelurahan', 'kecamatan', 'kota']);

                $rawLat = $this->parseCoordinate($this->extractField($data, ['latitude', 'lat', 'lintang', 'titik_koordinat_lat']));
                $rawLng = $this->parseCoordinate($this->extractField($data, ['longitude', 'long', 'lng', 'bujur', 'titik_koordinat_long']));
                [$latitude, $longitude] = $this->resolveCoordinates($rawLat, $rawLng, $stasiun, $wilayahAsset, $rowIndex);

                $existingAsset = KaiAsset::where('asset_number', $assetNumber)->first();
                $assetPayload = [
                    'asset_block_name' => $assetBlockName,
                    'sub_title'        => $subTitle,
                    'description'      => $description,
                    'peruntukan'       => $peruntukan,
                    'jenis_asset'      => $jenisAsset,
                    'stasiun'          => $stasiun,
                    'wilayah_asset'    => $wilayahAsset,
                    'size_area'        => $sizeArea,
                    'latitude'         => $latitude,
                    'longitude'        => $longitude,
                ];

                if ($existingAsset) {
                    $existingAsset->update($assetPayload);
                } else {
                    KaiAsset::create(array_merge([
                        'asset_number' => $assetNumber,
                        'created_at'   => now(),
                    ], $assetPayload));
                }

                // ── 4. KONTRAK (contracts) ────────────────────────────────
                $contractDate = $this->parseDate($this->extractField($data, ['contract_date', 'tanggal_kontrak', 'tgl_kontrak', 'tgl_perjanjian', 'tanggal_perjanjian'])) ?: now()->format('Y-m-d');
                
                $rawJenisKontrak = $this->extractField($data, ['jenis_kontrak', 'tipe_kontrak', 'kategori_kontrak', 'status_kontrak']);
                $jenisKontrak    = ($rawJenisKontrak && strtolower(trim($rawJenisKontrak)) !== 'kosong') ? $rawJenisKontrak : 'Baru';

                $rawAreaKontrak  = $this->extractField($data, ['area_kontrak', 'luas_kontrak', 'luas_sewa', 'wilayah_sewa']);
                $areaKontrak     = ($rawAreaKontrak && strtolower(trim($rawAreaKontrak)) !== 'kosong') ? $rawAreaKontrak : 'Row';

                $startDate = $this->parseDate($this->extractField($data, ['start_datetime', 'jangka_waktu_mulai', 'awal', 'tgl_mulai', 'tanggal_mulai', 'awal_sewa', 'mulai', 'awal_kontrak'])) ?: now()->format('Y-m-d');
                $endDate   = $this->parseDate($this->extractField($data, ['end_datetime', 'jangka_waktu_akhir', 'akhir', 'tgl_akhir', 'tanggal_akhir', 'selesai_kontrak', 'akhir_sewa', 'jatuh_tempo', 'tgl_selesai', 'akhir_kontrak', 'selesai'])) ?: now()->addYear()->format('Y-m-d');

                $startDateBaru = $this->parseDate($this->extractField($data, ['start_datetime_baru', 'awal_baru'])) ?: $startDate;
                $endDateBaru   = $this->parseDate($this->extractField($data, ['end_datetime_baru', 'akhir_baru', 'selesai_kontrak_baru'])) ?: $endDate;

                $price      = $this->parseNumber($this->extractField($data, ['price', 'nilai_perjanjian', 'total_biaya', 'nilai_kontrak', 'harga', 'nilai_sewa', 'tarif', 'jumlah_biaya', 'total_nilai', 'nilai'])) ?: 50000000.0;
                
                $rawSpv     = $this->extractField($data, ['spv', 'supervisor', 'pic', 'penanggung_jawab', 'sales_executive', 'pengawas']);
                $spv        = ($rawSpv && strtolower(trim($rawSpv)) !== 'kosong') ? $rawSpv : 'Sales Executive Area';

                $rawKet     = $this->extractField($data, ['keterangan', 'keterangan_pendapatan', 'ket', 'catatan', 'notes', 'deskripsi']);
                $keterangan = ($rawKet && strtolower(trim($rawKet)) !== 'kosong') ? $rawKet : 'Kawasan aset komersial KAI';

                $existingContract = KaiContract::where('contract_number', $contractNumber)->first();
                $contractPayload = [
                    'tenant_id'            => $tenantId,
                    'asset_number'         => $assetNumber,
                    'contract_date'        => $contractDate,
                    'jenis_kontrak'        => $jenisKontrak,
                    'area_kontrak'         => $areaKontrak,
                    'start_datetime'       => $startDate,
                    'end_datetime'         => $endDate,
                    'start_datetime_baru'  => $startDateBaru,
                    'end_datetime_baru'    => $endDateBaru,
                    'price'                => $price,
                    'spv'                  => $spv,
                    'keterangan'           => $keterangan,
                ];

                if ($existingContract) {
                    $existingContract->update($contractPayload);
                    $updatedCount++;
                } else {
                    KaiContract::create(array_merge([
                        'contract_number' => $contractNumber,
                        'created_at'      => now(),
                    ], $contractPayload));
                    $importedCount++;
                }

                // ── 5. FINANSIAL KONTRAK (contract_financials) ────────────
                $jumlahHari    = $this->parseNumber($this->extractField($data, ['jumlah_hari', 'hari', 'durasi_hari'])) ?: 365;
                $nilaiPerHari  = $this->parseNumber($this->extractField($data, ['nilai_per_hari', 'nilai_perhari', 'tarif_harian'])) ?: ($price / max(1, $jumlahHari));
                $hari2026      = $this->parseNumber($this->extractField($data, ['hari_2026', 'hari2026'])) ?: 365;
                $nilai2026     = $this->parseNumber($this->extractField($data, ['2_026', '2026', 'nilai_2026', 'nilai2026'])) ?: $price;
                $nilaiBacklog  = $this->parseNumber($this->extractField($data, ['nilai_backlog', 'backlog', 'backlog_1', 'nilai_backlog_1'])) ?: 0.0;
                $nilaiBacklog2 = $this->parseNumber($this->extractField($data, ['nilai_backlog2', 'backlog2', 'backlog_2', 'nilai_backlog_2'])) ?: 0.0;
                
                $rawGl         = $this->extractField($data, ['gl_acount', 'gl_account', 'akun_gl', 'no_gl', 'gl', 'rekening_gl']);
                $glAccount     = ($rawGl && strtolower(trim($rawGl)) !== 'kosong') ? $rawGl : '940.281.9';

                $rawRka        = $this->extractField($data, ['form_rka', 'rka', 'kode_rka', 'no_rka']);
                $formRka       = ($rawRka && strtolower(trim($rawRka)) !== 'kosong') ? $rawRka : 'RKA-2026';

                $tahunRka      = $this->extractField($data, ['tahun_rka', 'tahun']) ?: 2026;
                
                $rawPendapatan = $this->extractField($data, ['jenis_pendapatan', 'pendapatan', 'kategori_pendapatan', 'keterangan_pendapatan']);
                $jenisPendapatan = ($rawPendapatan && strtolower(trim($rawPendapatan)) !== 'kosong') ? $rawPendapatan : 'Pendapatan Non Angkutan';

                $persentase    = $this->parseNumber($this->extractField($data, ['persentase_pncapaian', 'persentase', 'persentase_pencapaian'])) ?: 100.0;
                $ketFin        = $this->extractField($data, ['ket', 'keterangan_pendapatan', 'keterangan']);

                ContractFinancial::updateOrCreate(
                    ['contract_number' => $contractNumber],
                    [
                        'jumlah_hari'      => $jumlahHari,
                        'nilai_per_hari'   => $nilaiPerHari,
                        'awal'             => $startDateBaru ?: $startDate,
                        'akhir'            => $endDateBaru ?: $endDate,
                        'hari_2026'        => $hari2026,
                        'nilai_2026'       => $nilai2026,
                        'nilai_backlog'    => $nilaiBacklog,
                        'nilai_backlog2'   => $nilaiBacklog2,
                        'gl_account'       => $glAccount,
                        'form_rka'         => $formRka,
                        'tahun_rka'        => $tahunRka,
                        'jenis_pendapatan' => $jenisPendapatan,
                        'persentase'       => $persentase,
                        'pencapaian'       => $persentase,
                        'ket'              => $ketFin,
                    ]
                );

                // ── 6. LAPORAN BULANAN (monthly_schedules) ────────────────
                $rawInvoice = $this->extractField($data, ['invoice', 'no_invoice', 'nomor_invoice', 'status_invoice']);
                $invoice    = ($rawInvoice && strtolower(trim($rawInvoice)) !== 'kosong') ? $rawInvoice : 'SUDAH TERBIT';

                $jan     = $this->parseNumber($this->extractField($data, ['januari', 'jan'])) ?: ($price / 12);
                $feb     = $this->parseNumber($this->extractField($data, ['februari', 'febuari', 'feb'])) ?: ($price / 12);
                $mar     = $this->parseNumber($this->extractField($data, ['maret', 'mar'])) ?: ($price / 12);
                $apr     = $this->parseNumber($this->extractField($data, ['april', 'apr'])) ?: ($price / 12);
                $mei     = $this->parseNumber($this->extractField($data, ['mei', 'may'])) ?: ($price / 12);
                $jun     = $this->parseNumber($this->extractField($data, ['juni', 'jun'])) ?: ($price / 12);
                $jul     = $this->parseNumber($this->extractField($data, ['juli', 'jul'])) ?: ($price / 12);
                $agu     = $this->parseNumber($this->extractField($data, ['agustus', 'agu', 'aug'])) ?: ($price / 12);
                $sep     = $this->parseNumber($this->extractField($data, ['september', 'sep'])) ?: ($price / 12);
                $okt     = $this->parseNumber($this->extractField($data, ['oktober', 'okt', 'oct'])) ?: ($price / 12);
                $nov     = $this->parseNumber($this->extractField($data, ['november', 'nov'])) ?: ($price / 12);
                $des     = $this->parseNumber($this->extractField($data, ['desember', 'des', 'dec'])) ?: ($price / 12);
                $janDes  = $this->parseNumber($this->extractField($data, ['jan_des', 'jan-des', 'total_jan_des', 'jan_sd_des', 'total'])) ?: $price;

                MonthlySchedule::updateOrCreate(
                    [
                        'contract_number' => $contractNumber,
                        'tahun'           => $tahunRka ?: 2026,
                    ],
                    [
                        'invoice'   => $invoice,
                        'januari'   => $jan,
                        'febuari'   => $feb,
                        'maret'     => $mar,
                        'april'     => $apr,
                        'mei'       => $mei,
                        'juni'      => $jun,
                        'juli'      => $jul,
                        'agustus'   => $agu,
                        'september' => $sep,
                        'oktober'   => $okt,
                        'november'  => $nov,
                        'desember'  => $des,
                        'jan_des'   => $janDes,
                    ]
                );
            }

            DB::commit();

            return back()->with('success', "Berhasil mengimpor data! ({$importedCount} data baru ditambahkan, {$updatedCount} data diperbarui)");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Import Excel Error: " . $e->getMessage());
            return back()->with('error', "Gagal mengimpor data: " . $e->getMessage());
        }
    }

    /**
     * Download CSV Template
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_import_kai_aset.csv"',
        ];

        $columns = [
            'contract_number',
            'contract_date',
            'STATUS_CUSTOMER',
            'JENIS_KONTRAK',
            'WILAYAH',
            'AREA_KONTRAK',
            'JENIS_PERUSAHAAN',
            'fullname',
            'asset_block_name',
            'size_area',
            'PERUNTUKAN',
            'asset_number',
            'JENIS_ASET',
            'STASIUN',
            'WILAYAH_ASET',
            'start_datetime',
            'end_datetime',
            'start_datetime_baru',
            'end_datetime_baru',
            'BRAND',
            'price',
            'JUMLAH HARI',
            'NILAI PER HARI',
            'AWAl',
            'AKHIR',
            'HARI 2026',
            '2,026',
            'januari',
            'februari',
            'maret',
            'april',
            'mei',
            'juni',
            'juli',
            'agustus',
            'september',
            'oktober',
            'november',
            'desember',
            'Jan-Des',
            'NILAI BACKLOG',
            'GL ACOUNT',
            'FORM RKA',
            'INVOICE',
            'KETERANGAN PENDAPATAN',
            'SPV',
            'KETERANGAN',
            'Jenis Pendapatan',
            'TAHUN RKA',
            'PERSENTASE PNCAPAIAN',
            'NILAI BACKLOG2',
            'Ket',
        ];

        $sampleRow = [
            '0005/51116/D.4/941/PK/TN/XII/2016',
            '42710',
            'Swasta',
            'Kontrak Sewa',
            'Daop 4 Semarang',
            'Non Row',
            'Perorangan',
            'MARDIYAH',
            'SEKITAR 2+1/200 LINTAS NON OPERASI - WONOPRINGGO KEL. TEGALREJO RT/RW.01/02 KEC. PEKALONGAN BARAT KOTA PEKALONGAN (5/51116/PK/TN/941)',
            '42',
            'Tanah',
            '04.01.00764',
            'Tanah',
            'Pekalongan',
            'Daop 4 Semarang',
            '01/01/2016',
            '12/31/2017',
            '01/01/2018',
            '12/31/2026',
            '',
            '2.264.394',
            '730',
            '3.102',
            '01/01/2026',
            '12/31/2026',
            '365',
            '1.132.197',
            '105.775',
            '95.539',
            '105.775',
            '102.363',
            '105.775',
            '102.363',
            '105.775',
            '105.775',
            '102.363',
            '105.775',
            '102.363',
            '105.775',
            '1.245.417',
            '9.063.780',
            '3421190010',
            'RKA',
            'SUDAH TERBIT',
            'Non Row',
            'Sales Executive Area 1 Pekalongan',
            'Pendapatan Sewa Tanah Non Row',
            'Pendapatan Non Angkutan',
            '2026',
            '0,9',
            '9.402.819',
            'AKTIF',
        ];

        $callback = function () use ($columns, $sampleRow) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, $sampleRow);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ─── HELPER METHODS ────────────────────────────────────────────────────────

    private function parseFileRows($file, string $ext): array
    {
        $path = $file->getRealPath();
        $rows = [];

        if (in_array($ext, ['csv', 'txt'])) {
            if (($handle = fopen($path, 'r')) !== false) {
                $firstLine = fgets($handle);
                rewind($handle);
                $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

                while (($data = fgetcsv($handle, 10000, $delimiter)) !== false) {
                    $rows[] = $data;
                }
                fclose($handle);
            }
        } elseif (in_array($ext, ['xlsx', 'xls'])) {
            if (class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
                $worksheet   = $spreadsheet->getActiveSheet();
                $rows        = $worksheet->toArray();
            } else {
                $rows = $this->parseXlsxXmlFallback($path);
            }
        }

        return $rows;
    }

    private function parseXlsxXmlFallback(string $path): array
    {
        $rows = [];
        $zip = new \ZipArchive();
        if ($zip->open($path) === true) {
            $sharedStrings = [];
            if (($index = $zip->locateName('xl/sharedStrings.xml')) !== false) {
                $xml = simplexml_load_string($zip->getFromIndex($index));
                foreach ($xml->si as $si) {
                    $sharedStrings[] = (string)($si->t ?? $si->r->t ?? '');
                }
            }

            if (($index = $zip->locateName('xl/worksheets/sheet1.xml')) !== false) {
                $xml = simplexml_load_string($zip->getFromIndex($index));
                foreach ($xml->sheetData->row as $row) {
                    $rowData = [];
                    foreach ($row->c as $cell) {
                        $type = (string)($cell['t'] ?? '');
                        $val  = (string)($cell->v ?? '');
                        if ($type === 's' && isset($sharedStrings[(int)$val])) {
                            $rowData[] = $sharedStrings[(int)$val];
                        } else {
                            $rowData[] = $val;
                        }
                    }
                    $rows[] = $rowData;
                }
            }
            $zip->close();
        }
        return $rows;
    }

    private function normalizeHeaderName(?string $name): string
    {
        if (!$name) return '';
        $name = strtolower(trim($name));
        $name = str_replace(['.', '-', '/', '\\', ','], '_', $name);
        $name = preg_replace('/[^a-z0-9_]/', '_', $name);
        $name = preg_replace('/_+/', '_', $name);
        return trim($name, '_');
    }

    private function extractField(array $data, array $candidateKeys)
    {
        foreach ($candidateKeys as $key) {
            $norm = $this->normalizeHeaderName($key);
            if (isset($data[$norm]) && $data[$norm] !== null && $data[$norm] !== '') {
                return $data[$norm];
            }
        }
        return null;
    }

    private function parseNumber($val): ?float
    {
        if ($val === null || $val === '') return null;
        $val = trim((string)$val);
        if (strtolower($val) === 'kosong' || strtolower($val) === '-') return 0.0;

        $val = str_replace(['Rp', 'rp', 'RP', ' ', '%'], '', $val);

        // Kasus format Indonesia: ribuan titik "2.264.394" atau "105.775" atau "3.102"
        // Jika ada koma, misal "0,9" atau "1.234,56"
        if (strpos($val, ',') !== false) {
            $val = str_replace('.', '', $val);
            $val = str_replace(',', '.', $val);
        } else {
            // Jika ada titik tapi format ribuan Indonesia (misal: 2.264.394 atau 105.775)
            if (preg_match('/\.\d{3}(\.\d{3})*$/', $val)) {
                $val = str_replace('.', '', $val);
            }
        }

        return is_numeric($val) ? (float)$val : null;
    }

    private function parseCoordinate($val): ?float
    {
        if ($val === null || $val === '') return null;
        $val = trim((string)$val);
        if (strtolower($val) === 'kosong' || strtolower($val) === '-') return null;
        $val = str_replace(',', '.', $val);
        return is_numeric($val) ? (float)$val : null;
    }

    private function parseDate($val): ?string
    {
        if ($val === null || $val === '') return null;
        $val = trim((string)$val);
        if (strtolower($val) === 'kosong' || strtolower($val) === '-') return null;

        // Cek jika format serial date dari Excel (misal 42710)
        if (is_numeric($val) && (float)$val > 30000 && (float)$val < 60000) {
            $unixTime = ((float)$val - 25569) * 86400;
            return date('Y-m-d', (int)$unixTime);
        }

        // Format MM/DD/YYYY atau DD/MM/YYYY
        if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $val, $matches)) {
            $p1 = (int)$matches[1];
            $p2 = (int)$matches[2];
            $p3 = (int)$matches[3];

            // Jika p1 > 12 -> pasti DD/MM/YYYY
            if ($p1 > 12) {
                return sprintf('%04d-%02d-%02d', $p3, $p2, $p1);
            }
            // Standar Excel US: MM/DD/YYYY (contoh: 12/31/2017)
            if ($p2 > 12) {
                return sprintf('%04d-%02d-%02d', $p3, $p1, $p2);
            }
            // Default MM/DD/YYYY untuk format Excel
            return sprintf('%04d-%02d-%02d', $p3, $p1, $p2);
        }

        try {
            return Carbon::parse($val)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function resolveCoordinates(?float $lat, ?float $lng, ?string $stasiun, ?string $wilayah, int $rowIndex): array
    {
        if ($lat !== null && $lng !== null && $lat != 0 && $lng != 0) {
            return [$lat, $lng];
        }

        // Koordinat stasiun-stasiun populer KAI
        $stationCoords = [
            'semarang tawang'   => [-6.964287, 110.428612],
            'semarang poncol'   => [-6.969700, 110.413700],
            'semarang'          => [-6.966667, 110.420000],
            'pekalongan'        => [-6.888700, 109.673800],
            'tegal'             => [-6.879000, 109.125000],
            'kudus'             => [-6.804800, 110.840500],
            'cepu'              => [-7.151100, 111.590800],
            'ambarawa'          => [-7.261200, 110.404500],
            'purwokerto'        => [-7.420800, 109.222200],
            'kroya'             => [-7.629400, 109.252200],
            'cirebon'           => [-6.706300, 108.555600],
            'solo'              => [-7.558300, 110.821700],
            'surakarta'         => [-7.558300, 110.821700],
            'yogyakarta'        => [-7.789200, 110.363600],
            'tugu'              => [-7.789200, 110.363600],
            'surabaya'          => [-7.257500, 112.752100],
            'malang'            => [-7.978600, 112.637800],
            'bandung'           => [-6.914700, 107.609800],
            'jakarta'           => [-6.175400, 106.827200],
        ];

        $stasiunLower = strtolower(trim((string)$stasiun));
        $wilayahLower = strtolower(trim((string)$wilayah));

        foreach ($stationCoords as $name => $coord) {
            if ($stasiunLower && str_contains($stasiunLower, $name)) {
                return $this->applyCoordinateJitter($coord[0], $coord[1], $rowIndex);
            }
        }

        foreach ($stationCoords as $name => $coord) {
            if ($wilayahLower && str_contains($wilayahLower, $name)) {
                return $this->applyCoordinateJitter($coord[0], $coord[1], $rowIndex);
            }
        }

        // Default Daop 4 Semarang area dengan penyebaran alami
        return $this->applyCoordinateJitter(-6.966667, 110.416667, $rowIndex);
    }

    private function applyCoordinateJitter(float $baseLat, float $baseLng, int $index): array
    {
        $angle = ($index * 137.5) * (M_PI / 180);
        $distance = 0.0025 * sqrt(($index % 40) + 1);
        $lat = $baseLat + ($distance * cos($angle));
        $lng = $baseLng + ($distance * sin($angle));
        return [round($lat, 8), round($lng, 8)];
    }
}
