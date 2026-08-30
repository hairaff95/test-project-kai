<?php

namespace App\Http\Controllers;

use App\Models\KaiContract;
use App\Models\KaiAsset;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JatuhTempoController extends Controller
{
    public function index(Request $request)
    {
        $query = KaiContract::with(['tenant', 'asset', 'financial'])
            ->whereNotNull('end_datetime_baru')
            ->where('end_datetime_baru', '>=', now())
            ->where('end_datetime_baru', '<=', now()->addMonths(6))
            ->orderBy('end_datetime_baru', 'asc');

        // Search
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('contract_number', 'like', "%{$s}%")
                  ->orWhere('asset_number', 'like', "%{$s}%")
                  ->orWhere('spv', 'like', "%{$s}%")
                  ->orWhere('keterangan', 'like', "%{$s}%")
                  ->orWhereHas('tenant', fn($q2) => $q2->where('fullname', 'like', "%{$s}%")
                                                        ->orWhere('brand', 'like', "%{$s}%"))
                  ->orWhereHas('asset', fn($q2) => $q2->where('asset_block_name', 'like', "%{$s}%")
                                                       ->orWhere('jenis_asset', 'like', "%{$s}%"));
            });
        }

        // Filter status customer
        if ($request->filled('status_customer')) {
            $query->whereHas('tenant', fn($q) => $q->where('status_customer', $request->status_customer));
        }

        // Filter jenis aset
        if ($request->filled('jenis_asset')) {
            $query->whereHas('asset', fn($q) => $q->where('jenis_asset', $request->jenis_asset));
        }

        $contracts = $query->get();

        // Jika belum ada data jatuh tempo 6 bulan, ambil semua kontrak
        if ($contracts->isEmpty() && !$request->filled('search') && !$request->filled('status_customer') && !$request->filled('jenis_asset')) {
            $contracts = KaiContract::with(['tenant', 'asset', 'financial'])
                ->orderBy('end_datetime_baru', 'asc')
                ->get();
        }

        $statusCustomerOptions = Penyewa::select('status_customer')->distinct()->whereNotNull('status_customer')->where('status_customer', '!=', '')->pluck('status_customer');
        $jenisAssetOptions     = KaiAsset::select('jenis_asset')->distinct()->whereNotNull('jenis_asset')->where('jenis_asset', '!=', '')->pluck('jenis_asset');

        return view('jatuh-tempo.index', compact('contracts', 'statusCustomerOptions', 'jenisAssetOptions'));
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

        return view('jatuh-tempo.edit', compact('contract', 'asset', 'tenant', 'financial'));
    }

    public function update(Request $request, $identifier)
    {
        $contract = KaiContract::with(['tenant', 'asset', 'financial'])
            ->where('contract_number', $identifier)
            ->orWhere('asset_number', $identifier)
            ->firstOrFail();

        // Update Penyewa
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

        // Update Jatuh Tempo fields on Contract
        if ($request->filled('spv')) {
            $contract->spv = $request->spv;
        }
        if ($request->filled('keterangan')) {
            $contract->keterangan = $request->keterangan;
        }
        if ($request->filled('end_datetime')) {
            try {
                $contract->end_datetime = Carbon::createFromFormat('d/m/y', $request->end_datetime)->format('Y-m-d');
            } catch (\Exception $e) {
                // fallback if already Y-m-d
                $contract->end_datetime = $request->end_datetime;
            }
        }
        if ($request->filled('end_datetime_baru')) {
            try {
                $contract->end_datetime_baru = Carbon::createFromFormat('d/m/y', $request->end_datetime_baru)->format('Y-m-d');
            } catch (\Exception $e) {
                $contract->end_datetime_baru = $request->end_datetime_baru;
            }
        }

        $contract->save();

        return redirect()->route('due-dates.index')->with('success', 'Data jatuh tempo berhasil diperbarui.');
    }
}
