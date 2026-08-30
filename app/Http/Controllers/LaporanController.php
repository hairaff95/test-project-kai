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

        $contracts = $query->get();

        $items = $contracts->map(function ($c) {
            $fin = $c->financial;
            $sched = $c->monthlySchedules->first();

            return [
                'asset_number' => $c->asset_number ?? $c->contract_number ?? '-',
                'januari'      => $sched && $sched->januari ? (string)(int)$sched->januari : '9402819',
                'februari'     => $sched && $sched->febuari ? (string)(int)$sched->febuari : '9402819',
                'maret'        => $sched && $sched->maret ? (string)(int)$sched->maret : '9402819',
                'april'        => $sched && $sched->april ? (string)(int)$sched->april : '9402819',
                'mei'          => $sched && $sched->mei ? (string)(int)$sched->mei : '9402819',
                'juni'         => $sched && $sched->juni ? (string)(int)$sched->juni : '9402819',
                'juli'         => $sched && $sched->juli ? (string)(int)$sched->juli : '9402819',
                'agustus'      => $sched && $sched->agustus ? (string)(int)$sched->agustus : '9402819',
                'september'    => $sched && $sched->september ? (string)(int)$sched->september : '9402819',
                'oktober'      => $sched && $sched->oktober ? (string)(int)$sched->oktober : '9402819',
                'november'     => $sched && $sched->november ? (string)(int)$sched->november : '9402819',
                'desember'     => $sched && $sched->desember ? (string)(int)$sched->desember : '9402819',
                'form_rka'     => $fin && $fin->form_rka !== null ? (string)$fin->form_rka : '0',
                'tahun_rka'    => $fin && $fin->tahun_rka !== null ? (string)$fin->tahun_rka : '0',
                'akun_gl'      => $fin && $fin->gl_account ? (string)$fin->gl_account : '3421190010',
            ];
        })->toArray();

        return view('laporan.index', compact('items'));
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
