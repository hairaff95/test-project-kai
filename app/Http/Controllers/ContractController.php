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

        $contracts = $query->get();

        // Ambil opsi unik untuk dropdown
        $jenisAssetOptions    = \App\Models\KaiAsset::select('jenis_asset')->distinct()->whereNotNull('jenis_asset')->pluck('jenis_asset');
        $statusCustomerOptions = \App\Models\Penyewa::select('status_customer')->distinct()->whereNotNull('status_customer')->pluck('status_customer');

        return view('contracts.index', compact('contracts', 'jenisAssetOptions', 'statusCustomerOptions'));
    }

    public function edit($identifier)
    {
        $contract = KaiContract::with(['tenant', 'asset', 'financial'])
            ->where('contract_number', $identifier)
            ->orWhere('asset_number', $identifier)
            ->firstOrFail();

        $asset = $contract->asset;
        $tenant = $contract->tenant;
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

        return redirect()->route('contracts.index')->with('success', 'Kontrak berhasil diperbarui.');
    }
}
