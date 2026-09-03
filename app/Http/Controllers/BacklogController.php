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

            $nilai2026 = $fin && $fin->nilai_2026 ? number_format((float)$fin->nilai_2026, 0, ',', '.') : '0';
            $jumlahHari = $fin && $fin->jumlah_hari ? (string)$fin->jumlah_hari : '-';

            return [
                'asset_number'   => $c->asset_number ?? $c->contract_number ?? '-',
                'no_kontrak'     => $c->contract_number ?? '-',
                'nama_penyewa'   => $c->tenant->fullname ?? '-',
                'status_customer'=> $c->tenant->status_customer ?? 'Aktif',
                'nilai_2026'     => $nilai2026,
                'jumlah_hari'    => $jumlahHari,
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

        return view('backlog.edit', compact('contract', 'asset', 'tenant', 'financial', 'schedule'));
    }

    public function update(Request $request, $identifier)
    {
        $contract = KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
            ->where('contract_number', $identifier)
            ->first();

        if (!$contract) {
            $contract = KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
                ->where('asset_number', $identifier)
                ->firstOrFail();
        }

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
            $fin->hari_2026 = (int) preg_replace('/[^\d]/', '', $request->hari_2026);
        }
        if ($request->has('nilai_perhari')) {
            $fin->nilai_per_hari = $this->cleanNumeric($request->nilai_perhari);
        }
        if ($request->has('nilai_backlog')) {
            $fin->nilai_backlog = $this->cleanNumeric($request->nilai_backlog);
        }
        if ($request->has('nilai_backlog2')) {
            $val = $this->cleanNumeric($request->nilai_backlog2);
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

        // Update Asset coordinates
        if ($contract->asset) {
            if ($request->filled('latitude')) {
                $contract->asset->latitude = (float)$request->latitude;
            }
            if ($request->filled('longitude')) {
                $contract->asset->longitude = (float)$request->longitude;
            }
            $contract->asset->save();
        }

        return redirect()->route('backlog.index')->with('success', 'Sukses update data backlog terbaru!');
    }

    /**
     * Clean and parse numeric input safely
     */
    private function cleanNumeric($value): float
    {
        if ($value === null || trim((string)$value) === '') {
            return 0.0;
        }
        
        $clean = trim((string)$value);
        $clean = preg_replace('/[^\d.,]/', '', $clean);
        
        if (substr_count($clean, '.') > 1) {
            $parts = explode('.', $clean);
            $last = array_pop($parts);
            if (strlen($last) <= 2 && !str_contains($clean, ',')) {
                $clean = implode('', $parts) . '.' . $last;
            } else {
                $clean = implode('', $parts) . $last;
            }
        } elseif (str_contains($clean, '.') && str_contains($clean, ',')) {
            $clean = str_replace('.', '', $clean);
            $clean = str_replace(',', '.', $clean);
        } elseif (str_contains($clean, ',')) {
            $clean = str_replace(',', '.', $clean);
        }
        
        return is_numeric($clean) ? (float) $clean : 0.0;
    }
}
