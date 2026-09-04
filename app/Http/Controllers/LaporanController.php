<?php

namespace App\Http\Controllers;

use App\Models\KaiContract;
use App\Models\ContractFinancial;
use App\Models\MonthlySchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
                  ->orWhereHas('financial', fn($q2) => $q2->where('gl_account', 'like', "%{$s}%")
                                                          ->orWhere('form_rka', 'like', "%{$s}%")
                                                          ->orWhere('tahun_rka', 'like', "%{$s}%"));
            });
        }

        $contracts = $query->paginate(50)->withQueryString();

        $items = $contracts->getCollection()->map(function ($c) {
            $fin   = $c->financial;
            $sched = $c->monthlySchedules->first();

            $formatNum = function ($val) {
                if ($val === null) return '0';
                return number_format((float) $val, 0, ',', '.');
            };

            return [
                'contract_number'  => $c->contract_number,
                'raw_contract_number' => $c->contract_number,
                'asset_number'     => $c->asset_number ?? $c->contract_number ?? '-',
                'januari'          => $sched ? $formatNum($sched->januari) : '0',
                'februari'         => $sched ? $formatNum($sched->febuari) : '0',
                'maret'            => $sched ? $formatNum($sched->maret) : '0',
                'april'            => $sched ? $formatNum($sched->april) : '0',
                'mei'              => $sched ? $formatNum($sched->mei) : '0',
                'juni'             => $sched ? $formatNum($sched->juni) : '0',
                'juli'             => $sched ? $formatNum($sched->juli) : '0',
                'agustus'          => $sched ? $formatNum($sched->agustus) : '0',
                'september'        => $sched ? $formatNum($sched->september) : '0',
                'oktober'          => $sched ? $formatNum($sched->oktober) : '0',
                'november'         => $sched ? $formatNum($sched->november) : '0',
                'desember'         => $sched ? $formatNum($sched->desember) : '0',
                'jan_des'          => $sched ? $formatNum($sched->jan_des) : '0',
                'pencapaian'       => $fin && $fin->pencapaian !== null ? str_replace('.', ',', (string) $fin->pencapaian) : '-',
                'jenis_pendapatan' => $fin && $fin->jenis_pendapatan ? (string) $fin->jenis_pendapatan : '-',
                'form_rka'         => $fin && $fin->form_rka !== null && $fin->form_rka !== '' ? (string) $fin->form_rka : '-',
                'tahun_rka'        => $fin && $fin->tahun_rka !== null ? (string) $fin->tahun_rka : '-',
                'akun_gl'          => $fin && $fin->gl_account ? (string) $fin->gl_account : '-',
            ];
        })->toArray();

        return view('laporan.index', compact('items', 'contracts'));
    }

    public function edit($identifier)
    {
        $contract = KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
            ->where('contract_number', $identifier)
            ->first();

        if (!$contract) {
            $contract = KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
                ->where('asset_number', $identifier)
                ->firstOrFail();
        }

        $asset     = $contract->asset;
        $tenant    = $contract->tenant;
        $financial = $contract->financial ?? new ContractFinancial();
        $schedule  = $contract->monthlySchedules->first() ?? new MonthlySchedule();

        return view('laporan.edit', compact('contract', 'asset', 'tenant', 'financial', 'schedule'));
    }

    public function update(Request $request, $identifier)
    {
        if ($request->has('contract_number') && trim((string)$request->contract_number) === '') {
            return back()->with('warning', 'Field Nomor Kontrak wajib diisi dan tidak boleh kosong!');
        }
        if ($request->has('asset_number') && trim((string)$request->asset_number) === '') {
            return back()->with('warning', 'Field Nomor Aset wajib diisi dan tidak boleh kosong!');
        }

        $contract = KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
            ->where('contract_number', $identifier)
            ->first();

        if (!$contract) {
            $contract = KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
                ->where('asset_number', $identifier)
                ->firstOrFail();
        }

        if ($request->filled('contract_number')) {
            $contract->contract_number = trim((string)$request->contract_number);
            $contract->save();
        }
        if ($request->filled('asset_number')) {
            $contract->asset_number = trim((string)$request->asset_number);
            $contract->save();
        }

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

        // Update MonthlySchedule (Januari s/d Desember), hitung jan_des otomatis
        $sched = $contract->monthlySchedules->first() ?: new MonthlySchedule([
            'contract_number' => $contract->contract_number,
            'tahun'           => 2026,
        ]);

        $months = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
        $sum    = 0.0;
        foreach ($months as $m) {
            $dbCol = ($m === 'februari') ? 'febuari' : $m;
            if ($request->has($m)) {
                $sched->$dbCol = $this->cleanNumeric($request->input($m));
            }
            $sum += (float) ($sched->$dbCol ?? 0);
        }
        $sched->jan_des = $sum;
        $sched->save();

        // Update Asset coordinates
        if ($contract->asset) {
            if ($request->filled('latitude')) {
                $contract->asset->latitude = (float) $request->latitude;
            }
            if ($request->filled('longitude')) {
                $contract->asset->longitude = (float) $request->longitude;
            }
            $contract->asset->save();
        }

        // Invalidasi cache dashboard karena data monthly schedule berubah (mempengaruhi chart bulanan & RKA)
        Cache::forget('map_assets');
        DashboardController::forgetDashboardCache();

        return redirect()->route('laporan.index')->with('success', 'Sukses update data laporan terbaru!');
    }

    /**
     * Clean and parse numeric input safely (supports "105775", "105.775", "1.245.417,00")
     */
    private function cleanNumeric($value): float
    {
        if ($value === null || trim((string) $value) === '') {
            return 0.0;
        }

        $clean = trim((string) $value);
        $clean = preg_replace('/[^\d.,]/', '', $clean);

        if (str_contains($clean, '.') && str_contains($clean, ',')) {
            $clean = str_replace('.', '', $clean);
            $clean = str_replace(',', '.', $clean);
        } elseif (str_contains($clean, '.')) {
            if (substr_count($clean, '.') > 1 || preg_match('/\.\d{3}$/', $clean)) {
                $clean = str_replace('.', '', $clean);
            }
        } elseif (str_contains($clean, ',')) {
            if (preg_match('/,\d{3}$/', $clean)) {
                $clean = str_replace(',', '', $clean);
            } else {
                $clean = str_replace(',', '.', $clean);
            }
        }

        return is_numeric($clean) ? (float) $clean : 0.0;
    }
}
