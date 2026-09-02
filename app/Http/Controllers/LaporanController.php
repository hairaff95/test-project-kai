<?php

namespace App\Http\Controllers;

use App\Models\KaiContract;
use App\Models\ContractFinancial;
use App\Models\MonthlySchedule;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('contract_number', 'like', "%{$s}%")
                  ->orWhere('asset_number', 'like', "%{$s}%")
                  ->orWhereHas('tenant', fn($q2) => $q2->where('fullname', 'like', "%{$s}%"))
                  ->orWhereHas('financial', fn($q2) => $q2->where('gl_account', 'like', "%{$s}%"));
            });
        }

        $contracts = $query->paginate(50)->withQueryString();

        $items = $contracts->getCollection()->map(function ($c) {
            $fin = $c->financial;
            $sched = $c->monthlySchedules->first();

            return [
                'asset_number' => $c->asset_number ?? $c->contract_number ?? '-',
                'januari'      => $sched && $sched->januari !== null ? (string)(int)$sched->januari : '0',
                'februari'     => $sched && $sched->febuari !== null ? (string)(int)$sched->febuari : '0',
                'maret'        => $sched && $sched->maret !== null ? (string)(int)$sched->maret : '0',
                'april'        => $sched && $sched->april !== null ? (string)(int)$sched->april : '0',
                'mei'          => $sched && $sched->mei !== null ? (string)(int)$sched->mei : '0',
                'juni'         => $sched && $sched->juni !== null ? (string)(int)$sched->juni : '0',
                'juli'         => $sched && $sched->juli !== null ? (string)(int)$sched->juli : '0',
                'agustus'      => $sched && $sched->agustus !== null ? (string)(int)$sched->agustus : '0',
                'september'    => $sched && $sched->september !== null ? (string)(int)$sched->september : '0',
                'oktober'      => $sched && $sched->oktober !== null ? (string)(int)$sched->oktober : '0',
                'november'     => $sched && $sched->november !== null ? (string)(int)$sched->november : '0',
                'desember'     => $sched && $sched->desember !== null ? (string)(int)$sched->desember : '0',
                'form_rka'     => $fin && $fin->form_rka !== null && $fin->form_rka !== '' ? (string)$fin->form_rka : '-',
                'tahun_rka'    => $fin && $fin->tahun_rka !== null ? (string)$fin->tahun_rka : '2026',
                'akun_gl'      => $fin && $fin->gl_account ? (string)$fin->gl_account : '-',
            ];
        })->toArray();

        return view('laporan.index', compact('items', 'contracts'));
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

        return view('laporan.edit', compact('contract', 'asset', 'tenant', 'financial', 'schedule'));
    }

    public function update(Request $request, $identifier)
    {
        $contract = KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
            ->where('contract_number', $identifier)
            ->orWhere('asset_number', $identifier)
            ->firstOrFail();

        // Update Financial (Akun GL, Form RKA, Tahun RKA)
        $fin = $contract->financial ?: new ContractFinancial(['contract_number' => $contract->contract_number]);
        if ($request->filled('akun_gl')) {
            $fin->gl_account = $request->akun_gl;
        }
        if ($request->has('form_rka')) {
            $fin->form_rka = $request->form_rka;
        }
        if ($request->has('tahun_rka')) {
            $fin->tahun_rka = $request->tahun_rka;
        }
        $fin->save();

        // Update MonthlySchedule (Januari s/d Desember)
        $sched = $contract->monthlySchedules->first() ?: new MonthlySchedule([
            'contract_number' => $contract->contract_number,
            'tahun' => 2026,
        ]);

        $months = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
        foreach ($months as $m) {
            if ($request->has($m)) {
                $dbCol = ($m === 'februari') ? 'febuari' : $m;
                $cleanVal = preg_replace('/[^\d.]/', '', str_replace(',', '.', $request->input($m)));
                $sched->$dbCol = $cleanVal;
            }
        }
        $sched->save();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }
}
