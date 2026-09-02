<?php

namespace App\Http\Controllers;

use App\Models\KaiContract;
use App\Models\ContractFinancial;
use App\Models\MonthlySchedule;
use App\Models\Penyewa;
use Illuminate\Http\Request;

class BacklogController extends Controller
{
    public function index(Request $request)
    {
        $query = KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('contract_number', 'like', "%{$s}%")
                  ->orWhere('asset_number', 'like', "%{$s}%")
                  ->orWhereHas('tenant', fn($q2) => $q2->where('fullname', 'like', "%{$s}%")
                                                        ->orWhere('brand', 'like', "%{$s}%"))
                  ->orWhereHas('asset', fn($q2) => $q2->where('asset_block_name', 'like', "%{$s}%")
                                                       ->orWhere('stasiun', 'like', "%{$s}%"));
            });
        }

        if ($request->filled('status_customer')) {
            $query->whereHas('tenant', fn($q) => $q->where('status_customer', $request->status_customer));
        }

        if ($request->filled('stasiun')) {
            $query->whereHas('asset', fn($q) => $q->where('stasiun', 'like', "%{$request->stasiun}%"));
        }

        $contracts = $query->paginate(50)->withQueryString();

        $items = $contracts->getCollection()->map(function ($c) {
            $fin = $c->financial;
            $sched = $c->monthlySchedules->first();

            $backlog = $fin && is_numeric($fin->nilai_backlog ?? null)
                ? (float)$fin->nilai_backlog
                : 0.0;

            $backlog2 = $fin && is_numeric($fin->nilai_backlog2 ?? null)
                ? (float)$fin->nilai_backlog2
                : 0.0;

            $invoice = $sched->invoice ?? 'SUDAH TERBIT';
            $glAccount = $fin->gl_account ?? '-';
            $hari2026 = $fin->hari_2026 ?? '365';
            $nilaiPerhari = $fin && $fin->nilai_per_hari ? number_format((float)$fin->nilai_per_hari, 0, ',', '.') : '0';

            return [
                'asset_number'   => $c->asset_number ?? $c->contract_number ?? '-',
                'no_kontrak'     => $c->contract_number ?? '-',
                'nama_penyewa'   => $c->tenant->fullname ?? '-',
                'status_customer'=> $c->tenant->status_customer ?? 'Aktif',
                'nilai_backlog'  => number_format($backlog, 0, ',', '.'),
                'nilai_backlog2' => number_format($backlog2, 0, ',', '.'),
                'invoice'        => $invoice,
                'gl_account'     => $glAccount,
                'hari_2026'      => (string)$hari2026,
                'nilai_perhari'  => $nilaiPerhari,
            ];
        })->toArray();

        $statusCustomerOptions = Penyewa::select('status_customer')->distinct()->whereNotNull('status_customer')->where('status_customer', '!=', '')->pluck('status_customer');

        return view('backlog.index', compact('items', 'contracts', 'statusCustomerOptions'));
    }

    public function edit($identifier)
    {
        $contract = KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
            ->where('contract_number', $identifier)
            ->orWhere('asset_number', $identifier)
            ->firstOrFail();

        $asset     = $contract->asset;
        $tenant    = $contract->tenant;
        $financial = $contract->financial ?? new ContractFinancial();
        $schedule  = $contract->monthlySchedules->first() ?? new MonthlySchedule();

        return view('backlog.edit', compact('contract', 'asset', 'tenant', 'financial', 'schedule'));
    }

    public function update(Request $request, $identifier)
    {
        $contract = KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
            ->where('contract_number', $identifier)
            ->orWhere('asset_number', $identifier)
            ->firstOrFail();

        // Update Tenant
        if ($contract->tenant) {
            if ($request->filled('nama_penyewa')) {
                $contract->tenant->fullname = $request->nama_penyewa;
            }
            if ($request->filled('status_customer')) {
                $contract->tenant->status_customer = $request->status_customer;
            }
            $contract->tenant->save();
        }

        // Update Contract
        if ($request->filled('contract_number')) {
            $contract->contract_number = $request->contract_number;
        }
        $contract->save();

        // Update Financial
        $fin = $contract->financial ?: new ContractFinancial(['contract_number' => $contract->contract_number]);
        if ($request->filled('gl_account')) {
            $fin->gl_account = $request->gl_account;
        }
        if ($request->filled('hari_2026')) {
            $fin->hari_2026 = $request->hari_2026;
        }
        if ($request->filled('nilai_perhari')) {
            $fin->nilai_per_hari = preg_replace('/[^\d.]/', '', str_replace(',', '.', $request->nilai_perhari));
        }
        if ($request->filled('nilai_backlog')) {
            $fin->nilai_backlog = preg_replace('/[^\d.]/', '', str_replace(',', '.', $request->nilai_backlog));
        }
        if ($request->filled('nilai_backlog2')) {
            $val = preg_replace('/[^\d.]/', '', str_replace(',', '.', $request->nilai_backlog2));
            $fin->nilai_backlog2 = $val;
            $fin->sisa_piutang = $val;
        }
        $fin->save();

        // Update MonthlySchedule invoice
        if ($request->filled('invoice')) {
            $sched = $contract->monthlySchedules->first() ?: new MonthlySchedule([
                'contract_number' => $contract->contract_number,
                'tahun' => 2026,
            ]);
            $sched->invoice = $request->invoice;
            $sched->save();
        }

        return redirect()->route('backlog.index')->with('success', 'Backlog berhasil diperbarui.');
    }
}
