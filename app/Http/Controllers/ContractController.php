<?php

namespace App\Http\Controllers;

use App\Models\KaiContract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $query = KaiContract::with(['tenant', 'asset', 'financial'])->latest('created_at');

        // Search — cari di semua kolom relevan
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('contract_number', 'like', "%{$s}%")
                  ->orWhereHas('tenant', fn($q2) => $q2->where('fullname', 'like', "%{$s}%")
                                                        ->orWhere('brand', 'like', "%{$s}%"))
                  ->orWhereHas('asset', fn($q2) => $q2->where('asset_block_name', 'like', "%{$s}%")
                                                       ->orWhere('jenis_asset', 'like', "%{$s}%"));
            });
        }

        // Filter jenis aset
        if ($request->filled('jenis_asset')) {
            $query->whereHas('asset', fn($q) => $q->where('jenis_asset', $request->jenis_asset));
        }

        // Filter status customer
        if ($request->filled('status_customer')) {
            $query->whereHas('tenant', fn($q) => $q->where('status_customer', $request->status_customer));
        }

        // Filter harga
        if ($request->filled('harga')) {
            match ($request->harga) {
                'lt_5jt'    => $query->where('price', '<', 5_000_000),
                'gt_5jt'    => $query->where('price', '>', 5_000_000),
                'gt_50jt'   => $query->where('price', '>', 50_000_000),
                'gt_100jt'  => $query->where('price', '>', 100_000_000),
                'gt_500jt'  => $query->where('price', '>', 500_000_000),
                'gt_1m'     => $query->where('price', '>', 1_000_000_000),
                default     => null,
            };
        }

        // Filter waktu kontrak
        if ($request->filled('waktu')) {
            match ($request->waktu) {
                '1bulan'  => $query->where('contract_date', '>=', now()->subMonth()),
                '3bulan'  => $query->where('contract_date', '>=', now()->subMonths(3)),
                '6bulan'  => $query->where('contract_date', '>=', now()->subMonths(6)),
                '1tahun'  => $query->where('contract_date', '>=', now()->subYear()),
                default   => null,
            };
        }

        $contracts = $query->paginate(50)->withQueryString();

        // Ambil opsi unik untuk dropdown
        $jenisAssetOptions    = \App\Models\KaiAsset::select('jenis_asset')->distinct()->whereNotNull('jenis_asset')->pluck('jenis_asset');
        $statusCustomerOptions = \App\Models\Penyewa::select('status_customer')->distinct()->whereNotNull('status_customer')->pluck('status_customer');

        return view('contracts.index', compact('contracts', 'jenisAssetOptions', 'statusCustomerOptions'));
    }

    public function create()
    {
        $jenisAssetOptions = \App\Models\KaiAsset::select('jenis_asset')->distinct()->whereNotNull('jenis_asset')->pluck('jenis_asset');
        $statusCustomerOptions = \App\Models\Penyewa::select('status_customer')->distinct()->whereNotNull('status_customer')->pluck('status_customer');
        $stasiunOptions = \App\Models\KaiAsset::select('stasiun')->distinct()->whereNotNull('stasiun')->pluck('stasiun');
        $jenisPendapatanOptions = \App\Models\ContractFinancial::select('jenis_pendapatan')->distinct()->whereNotNull('jenis_pendapatan')->pluck('jenis_pendapatan');

        return view('contracts.create', compact('jenisAssetOptions', 'statusCustomerOptions', 'stasiunOptions', 'jenisPendapatanOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contract_number' => 'required|string|unique:contracts,contract_number',
            'nama_penyewa'    => 'required|string',
            'asset_number'    => 'required|string',
        ]);

        // 1. Create or Find Tenant
        $brandInput = trim((string)$request->brand);
        $tenant = \App\Models\Penyewa::firstOrCreate(
            ['fullname' => $request->nama_penyewa],
            [
                'status_customer' => $request->status_customer ?? 'Swasta',
                'jenis_perusahaan'=> $request->jenis_perusahaan ?? '-',
                'brand'           => ($brandInput === '' || strtolower($brandInput) === 'kosong') ? '(kosong)' : $brandInput,
                'alamat'          => $request->alamat ?? '',
            ]
        );

        // 2. Create or Find Asset
        $asset = \App\Models\KaiAsset::firstOrCreate(
            ['asset_number' => $request->asset_number],
            [
                'asset_block_name' => $request->asset_block_name ?? $request->nama_penyewa,
                'jenis_asset'      => $request->jenis_asset ?? 'Tanah',
                'size_area'        => (float) str_replace(',', '.', preg_replace('/[^\d.,]/', '', $request->size_area ?? '0')),
                'stasiun'          => $request->stasiun ?? 'Semarang',
                'wilayah_asset'    => $request->wilayah_asset ?? 'Daop 4 Semarang',
                'peruntukan'       => $request->peruntukan ?? '',
                'latitude'         => $request->filled('latitude') ? (float)$request->latitude : -6.8887,
                'longitude'        => $request->filled('longitude') ? (float)$request->longitude : 109.6738,
            ]
        );

        if ($request->filled('latitude') || $request->filled('longitude')) {
            if ($request->filled('latitude')) $asset->latitude = (float)$request->latitude;
            if ($request->filled('longitude')) $asset->longitude = (float)$request->longitude;
            $asset->save();
        }

        // Clean Price & Size Area
        $cleanedPrice = (float) preg_replace('/[^\d]/', '', $request->price ?? $request->nilai_kontrak ?? '0');
        $cleanSizeArea = (float) str_replace(',', '.', preg_replace('/[^\d.,]/', '', $request->size_area ?? '0'));

        // Dates parsing helper (supports DD/MM/YY, DD/MM/YYYY, and standard formats)
        $parseDate = function ($dateStr) {
            if (!$dateStr) return null;
            $dateStr = trim($dateStr);
            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/', $dateStr, $matches)) {
                $day = (int)$matches[1];
                $month = (int)$matches[2];
                $year = (int)$matches[3];
                if ($year < 100) $year += 2000;
                return \Carbon\Carbon::create($year, $month, $day);
            }
            try {
                return \Carbon\Carbon::parse($dateStr);
            } catch (\Exception $e) {
                return null;
            }
        };

        $contractDate = $request->contract_date ?: '42710';
        $startDate = $parseDate($request->start_datetime) ?? now();
        $endDate = $parseDate($request->end_datetime) ?? now()->addYear();
        $startDateBaru = $parseDate($request->start_datetime_baru);
        $endDateBaru = $parseDate($request->end_datetime_baru);

        // 3. Create Contract
        $contract = \App\Models\KaiContract::create([
            'contract_number'     => $request->contract_number,
            'tenant_id'           => $tenant->id,
            'asset_number'        => $asset->asset_number,
            'contract_date'       => $contractDate,
            'jenis_kontrak'       => $request->jenis_kontrak ?? 'Kontrak Sewa',
            'area_kontrak'        => $request->area_kontrak ?? 'Daop 4 Semarang',
            'start_datetime'      => $startDate,
            'end_datetime'        => $endDate,
            'start_datetime_baru' => $startDateBaru,
            'end_datetime_baru'   => $endDateBaru,
            'price'               => $cleanedPrice,
            'spv'                 => $request->spv ?? 'PIC Daop 4',
            'asset_block_name'    => $request->asset_block_name ?? $request->nama_penyewa,
            'size_area'           => $cleanSizeArea,
            'peruntukan'          => $request->peruntukan ?? '',
            'keterangan'          => $request->keterangan ?? 'RKA',
        ]);

        // 4. Create Financial
        $cleanNum = function($val, $default = 0.0) {
            if ($val === null || trim((string)$val) === '') return (float)$default;
            $c = trim((string)$val);
            $c = preg_replace('/[^\d.,]/', '', $c);
            if (substr_count($c, '.') > 1 || preg_match('/\.\d{3}$/', $c)) {
                $c = str_replace('.', '', $c);
            }
            if (str_contains($c, ',')) {
                $c = (preg_match('/,\d{3}$/', $c)) ? str_replace(',', '', $c) : str_replace(',', '.', $c);
            }
            return is_numeric($c) ? (float)$c : (float)$default;
        };

        $nilai2026 = $cleanNum($request->nilai_2026, $cleanedPrice);
        $nilaiBacklog1 = $cleanNum($request->nilai_backlog, 0);
        $nilaiBacklog2 = $cleanNum($request->nilai_backlog2, 0);
        $pencapaian = $cleanNum($request->pencapaian ?? $request->persentase, 0.9);
        $jumlahHari = (int) preg_replace('/[^\d]/', '', $request->jumlah_hari ?? 730);
        $nilaiPerHari = $cleanNum($request->nilai_per_hari, 0);
        $hari2026 = (int) preg_replace('/[^\d]/', '', $request->hari_2026 ?? 365);

        \App\Models\ContractFinancial::create([
            'contract_number'  => $contract->contract_number,
            'asset_number'     => $asset->asset_number,
            'jenis_pendapatan' => $request->jenis_pendapatan ?? 'Non Row',
            'gl_account'       => $request->akun_gl ?? '3421190010',
            'form_rka'         => $request->form_rka ?? '-',
            'tahun_rka'        => $request->tahun_rka ?? '0',
            'nilai_2026'       => $nilai2026,
            'nilai_backlog'    => $nilaiBacklog1,
            'nilai_backlog2'   => $nilaiBacklog2,
            'pencapaian'       => $pencapaian,
            'jumlah_hari'      => $jumlahHari,
            'nilai_per_hari'   => $nilaiPerHari,
            'hari_2026'        => $hari2026,
        ]);

        // 5. Create Monthly Schedules
        $monthlyPortion = $nilai2026 > 0 ? round($nilai2026 / 12) : 0;
        $jan = $cleanNum($request->januari, $monthlyPortion);
        $feb = $cleanNum($request->febuari, $monthlyPortion);
        $mar = $cleanNum($request->maret, $monthlyPortion);
        $apr = $cleanNum($request->april, $monthlyPortion);
        $mei = $cleanNum($request->mei, $monthlyPortion);
        $jun = $cleanNum($request->juni, $monthlyPortion);
        $jul = $cleanNum($request->juli, $monthlyPortion);
        $agu = $cleanNum($request->agustus, $monthlyPortion);
        $sep = $cleanNum($request->september, $monthlyPortion);
        $okt = $cleanNum($request->oktober, $monthlyPortion);
        $nov = $cleanNum($request->november, $monthlyPortion);
        $des = $cleanNum($request->desember, $monthlyPortion);
        $janDes = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $agu + $sep + $okt + $nov + $des;

        \App\Models\MonthlySchedule::create([
            'contract_number' => $contract->contract_number,
            'asset_number'    => $asset->asset_number,
            'tahun'           => 2026,
            'januari'         => $jan,
            'febuari'         => $feb,
            'maret'           => $mar,
            'april'           => $apr,
            'mei'             => $mei,
            'juni'            => $jun,
            'juli'            => $jul,
            'agustus'         => $agu,
            'september'       => $sep,
            'oktober'         => $okt,
            'november'        => $nov,
            'desember'        => $des,
            'jan_des'         => $janDes,
        ]);

        return redirect()->route('contracts.index')
            ->with('success', 'Aset dan kontrak baru berhasil ditambahkan!')
            ->with('created_asset_number', $asset->asset_number)
            ->with('created_asset_url', route('asset.detail', urlencode($asset->asset_number)));
    }

    public function edit($identifier)
    {
        $contract = KaiContract::with(['tenant', 'asset', 'financial'])
            ->where('contract_number', $identifier)
            ->first();

        if (!$contract) {
            $contract = KaiContract::with(['tenant', 'asset', 'financial'])
                ->where('asset_number', $identifier)
                ->firstOrFail();
        }

        $asset = $contract->asset;
        $tenant = $contract->tenant;
        $financial = $contract->financial;

        return view('contracts.edit', compact('contract', 'asset', 'tenant', 'financial'));
    }

    public function update(Request $request, $identifier)
    {
        $contract = KaiContract::with(['tenant', 'asset', 'financial'])
            ->where('contract_number', $identifier)
            ->first();

        if (!$contract) {
            $contract = KaiContract::with(['tenant', 'asset', 'financial'])
                ->where('asset_number', $identifier)
                ->firstOrFail();
        }

        if ($contract->tenant) {
            if ($request->filled('nama_penyewa')) {
                $contract->tenant->fullname = $request->nama_penyewa;
            }
            if ($request->filled('status_customer')) {
                $contract->tenant->status_customer = $request->status_customer;
            }
            if ($request->has('brand')) {
                $b = trim((string)$request->brand);
                $contract->tenant->brand = ($b === '' || strtolower($b) === 'kosong') ? '(kosong)' : $b;
            }
            $contract->tenant->save();
        }

        if ($contract->asset) {
            if ($request->filled('asset_block_name')) {
                $contract->asset->asset_block_name = $request->asset_block_name;
            }
            if ($request->filled('latitude')) {
                $contract->asset->latitude = (float)$request->latitude;
            }
            if ($request->filled('longitude')) {
                $contract->asset->longitude = (float)$request->longitude;
            }
            $contract->asset->save();
        }

        if ($request->filled('nilai_kontrak')) {
            $cleanedPrice = preg_replace('/[^\d]/', '', $request->nilai_kontrak);
            if ($cleanedPrice) {
                $contract->price = $cleanedPrice;
            }
        }

        $contract->save();

        return redirect()->route('contracts.index')->with('success', 'Sukses update data kontrak terbaru!');
    }
}
