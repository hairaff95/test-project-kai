<?php

namespace App\Http\Controllers;

use App\Models\KaiContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContractController extends Controller
{
    // Cache TTL untuk dropdown options yang jarang berubah
    private const CACHE_DROPDOWN_TTL = 3600; // 1 jam

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

        // Cache dropdown options — data ini jarang berubah, query distinct bisa berat
        $jenisAssetOptions     = collect(Cache::remember('dropdown_jenis_asset', self::CACHE_DROPDOWN_TTL,
            fn() => \App\Models\KaiAsset::select('jenis_asset')->distinct()->whereNotNull('jenis_asset')->pluck('jenis_asset')->toArray()
        ));
        $statusCustomerOptions = collect(Cache::remember('dropdown_status_customer', self::CACHE_DROPDOWN_TTL,
            fn() => \App\Models\Penyewa::select('status_customer')->distinct()->whereNotNull('status_customer')->pluck('status_customer')->toArray()
        ));

        return view('contracts.index', compact('contracts', 'jenisAssetOptions', 'statusCustomerOptions'));
    }

    public function create()
    {
        $jenisAssetOptions = collect(Cache::remember('dropdown_jenis_asset', self::CACHE_DROPDOWN_TTL,
            fn() => \App\Models\KaiAsset::select('jenis_asset')->distinct()->whereNotNull('jenis_asset')->pluck('jenis_asset')->toArray()
        ));
        $statusCustomerOptions = collect(Cache::remember('dropdown_status_customer', self::CACHE_DROPDOWN_TTL,
            fn() => \App\Models\Penyewa::select('status_customer')->distinct()->whereNotNull('status_customer')->pluck('status_customer')->toArray()
        ));
        $stasiunOptions = collect(Cache::remember('dropdown_stasiun', self::CACHE_DROPDOWN_TTL,
            fn() => \App\Models\KaiAsset::select('stasiun')->distinct()->whereNotNull('stasiun')->pluck('stasiun')->toArray()
        ));
        $jenisPendapatanOptions = collect(Cache::remember('dropdown_jenis_pendapatan', self::CACHE_DROPDOWN_TTL,
            fn() => \App\Models\ContractFinancial::select('jenis_pendapatan')->distinct()->whereNotNull('jenis_pendapatan')->pluck('jenis_pendapatan')->toArray()
        ));

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
        $tenant = \App\Models\Penyewa::firstOrCreate(
            ['fullname' => $request->nama_penyewa],
            [
                'status_customer' => $request->status_customer ?? 'Swasta',
                'jenis_perusahaan'=> $request->jenis_perusahaan ?? '-',
                'brand'           => $request->brand ?? '',
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
            ]
        );

        // Clean Price
        $cleanedPrice = (float) preg_replace('/[^\d]/', '', $request->price ?? $request->nilai_kontrak ?? '0');

        // Dates parsing helper (supports DD/MM/YY, DD/MM/YYYY, and standard formats)
        $parseDate = function ($dateStr) {
            if (!$dateStr) return null;
            $dateStr = trim($dateStr);
            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/', $dateStr, $matches)) {
                $day   = (int) $matches[1];
                $month = (int) $matches[2];
                $year  = (int) $matches[3];
                if ($year < 100) $year += 2000;
                return \Carbon\Carbon::create($year, $month, $day);
            }
            try {
                return \Carbon\Carbon::parse($dateStr);
            } catch (\Exception $e) {
                return now();
            }
        };

        $contractDate  = $parseDate($request->contract_date) ?? now();
        $startDate     = $parseDate($request->start_datetime) ?? now();
        $endDate       = $parseDate($request->end_datetime) ?? now()->addYear();
        $startDateBaru = $parseDate($request->start_datetime_baru);
        $endDateBaru   = $parseDate($request->end_datetime_baru);

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
            'keterangan'          => $request->keterangan ?? '',
        ]);

        // 4. Create Financial
        $nilai2026     = (float) preg_replace('/[^\d]/', '', $request->nilai_2026 ?? $cleanedPrice);
        $nilaiBacklog1 = (float) preg_replace('/[^\d]/', '', $request->nilai_backlog ?? 0);
        $nilaiBacklog2 = (float) preg_replace('/[^\d]/', '', $request->nilai_backlog2 ?? 0);
        $persentase    = (float) str_replace(',', '.', preg_replace('/[^\d.,]/', '', $request->persentase ?? '0.9'));

        \App\Models\ContractFinancial::create([
            'contract_number'  => $contract->contract_number,
            'asset_number'     => $asset->asset_number,
            'jenis_pendapatan' => $request->jenis_pendapatan ?? 'Row',
            'akun_gl'          => $request->akun_gl ?? '40110000',
            'form_rka'         => $request->form_rka ?? 'RKA 2026',
            'tahun_rka'        => $request->tahun_rka ?? '2026',
            'nilai_2026'       => $nilai2026,
            'nilai_backlog'    => $nilaiBacklog1,
            'nilai_backlog2'   => $nilaiBacklog2,
            'persentase'       => $persentase,
        ]);

        // 5. Create Monthly Schedules
        $monthlyPortion = $nilai2026 > 0 ? round($nilai2026 / 12) : 0;
        \App\Models\MonthlySchedule::create([
            'contract_number' => $contract->contract_number,
            'asset_number'    => $asset->asset_number,
            'januari'         => (float) preg_replace('/[^\d]/', '', $request->januari ?? $monthlyPortion),
            'febuari'         => (float) preg_replace('/[^\d]/', '', $request->febuari ?? $monthlyPortion),
            'maret'           => (float) preg_replace('/[^\d]/', '', $request->maret ?? $monthlyPortion),
            'april'           => (float) preg_replace('/[^\d]/', '', $request->april ?? $monthlyPortion),
            'mei'             => (float) preg_replace('/[^\d]/', '', $request->mei ?? $monthlyPortion),
            'juni'            => (float) preg_replace('/[^\d]/', '', $request->juni ?? $monthlyPortion),
            'juli'            => (float) preg_replace('/[^\d]/', '', $request->juli ?? $monthlyPortion),
            'agustus'         => (float) preg_replace('/[^\d]/', '', $request->agustus ?? $monthlyPortion),
            'september'       => (float) preg_replace('/[^\d]/', '', $request->september ?? $monthlyPortion),
            'oktober'         => (float) preg_replace('/[^\d]/', '', $request->oktober ?? $monthlyPortion),
            'november'        => (float) preg_replace('/[^\d]/', '', $request->november ?? $monthlyPortion),
            'desember'        => (float) preg_replace('/[^\d]/', '', $request->desember ?? $monthlyPortion),
            'jan_des'         => $nilai2026,
        ]);

        // Invalidasi cache peta & dropdown karena aset/kontrak baru mungkin menambah opsi baru
        Cache::forget('map_assets');
        Cache::forget('dropdown_jenis_asset');
        Cache::forget('dropdown_status_customer');
        Cache::forget('dropdown_stasiun');
        Cache::forget('dropdown_jenis_pendapatan');

        return redirect()->route('contracts.index')->with('success', 'Aset & Kontrak baru berhasil ditambahkan.');
    }

    public function edit($identifier)
    {
        $contract = KaiContract::with(['tenant', 'asset', 'financial'])
            ->where('contract_number', $identifier)
            ->orWhere('asset_number', $identifier)
            ->firstOrFail();

        $asset     = $contract->asset;
        $tenant    = $contract->tenant;
        $financial = $contract->financial;

        return view('contracts.edit', compact('contract', 'asset', 'tenant', 'financial'));
    }

    public function update(Request $request, $identifier)
    {
        $contract = KaiContract::with(['tenant', 'asset', 'financial'])
            ->where('contract_number', $identifier)
            ->orWhere('asset_number', $identifier)
            ->firstOrFail();

        if ($contract->tenant) {
            if ($request->filled('nama_penyewa')) {
                $contract->tenant->fullname = $request->nama_penyewa;
            }
            if ($request->filled('status_customer')) {
                $contract->tenant->status_customer = $request->status_customer;
            }
            if ($request->filled('brand')) {
                $contract->tenant->brand = $request->brand;
            }
            $contract->tenant->save();
        }

        if ($contract->asset && $request->filled('asset_block_name')) {
            $contract->asset->asset_block_name = $request->asset_block_name;
            $contract->asset->save();
        }

        if ($request->filled('nilai_kontrak')) {
            $cleanedPrice = preg_replace('/[^\d]/', '', $request->nilai_kontrak);
            if ($cleanedPrice) {
                $contract->price = $cleanedPrice;
            }
        }

        $contract->save();

        // Invalidasi cache peta karena data kontrak/aset berubah
        Cache::forget('map_assets');
        Cache::forget('dropdown_status_customer');

        return redirect()->route('contracts.index')->with('success', 'Kontrak berhasil diperbarui.');
    }
}
