<?php

namespace App\Http\Controllers;

use App\Models\KaiAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AssetController extends Controller
{
    /**
     * Display the full interactive detail page for a KAI Asset / Contract.
     */
    public function showKai(string $identifier, Request $request)
    {
        $contractNumber = $request->query('contract');

        $contract = null;
        if ($contractNumber) {
            $contract = \App\Models\KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
                ->where('contract_number', $contractNumber)
                ->first();
        }

        if (!$contract) {
            $contract = \App\Models\KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
                ->where('contract_number', $identifier)
                ->first();
        }

        if ($contract) {
            $asset = $contract->asset
                ?: \App\Models\KaiAsset::where('asset_number', $contract->asset_number)->first()
                ?: new \App\Models\KaiAsset(['asset_number' => $contract->asset_number]);
            $asset->setRelation('contract', $contract);
        } else {
            $asset = KaiAsset::with(['contract.tenant', 'contract.financial', 'contract.monthlySchedules'])
                ->where('asset_number', $identifier)
                ->firstOrFail();
        }

        return view('assets.detail', compact('asset'));
    }

    /**
     * Update Asset, Contract, Tenant, Financial, and Schedule from Detail Lanjutan.
     */
    public function update(Request $request, string $identifier)
    {
        $contract = \App\Models\KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
            ->where('contract_number', $identifier)
            ->first();

        if (!$contract) {
            $contract = \App\Models\KaiContract::with(['tenant', 'asset', 'financial', 'monthlySchedules'])
                ->where('asset_number', $identifier)
                ->first();
        }

        $asset = null;
        if ($contract) {
            $asset = $contract->asset ?: KaiAsset::where('asset_number', $contract->asset_number)->first();
        } else {
            $asset = KaiAsset::where('asset_number', $identifier)->firstOrFail();
        }

        // 1. Update Contract if exists
        if ($contract) {
            if ($request->filled('asset_block_name')) {
                $contract->asset_block_name = $request->asset_block_name;
            }
            if ($request->filled('peruntukan')) {
                $contract->peruntukan = $request->peruntukan;
            }
            if ($request->filled('jenis_kontrak')) {
                $contract->jenis_kontrak = $request->jenis_kontrak;
            }
            if ($request->filled('spv')) {
                $contract->spv = $request->spv;
            }
            if ($request->filled('size_area')) {
                $contract->size_area = (float) preg_replace('/[^\d.]/', '', str_replace(',', '.', $request->size_area));
            }
            if ($request->has('price')) {
                $contract->price = $this->cleanNumeric($request->price);
            }
            $contract->save();

            // 2. Update Tenant
            if ($contract->tenant) {
                if ($request->filled('nama_penyewa')) {
                    $contract->tenant->fullname = $request->nama_penyewa;
                }
                $contract->tenant->save();
            }

            // 3. Update Financial
            $fin = $contract->financial ?: new \App\Models\ContractFinancial(['contract_number' => $contract->contract_number]);
            if ($request->filled('gl_account')) {
                $fin->gl_account = $request->gl_account;
            }
            if ($request->filled('form_rka')) {
                $fin->form_rka = $request->form_rka;
            }
            if ($request->filled('tahun_rka')) {
                $fin->tahun_rka = $request->tahun_rka;
            }
            if ($request->filled('jenis_pendapatan')) {
                $fin->jenis_pendapatan = $request->jenis_pendapatan;
            }
            if ($request->filled('ket_pendapatan')) {
                $fin->keterangan_pendapatan = $request->ket_pendapatan;
            }
            if ($request->has('jumlah_hari')) {
                $fin->jumlah_hari = (int) preg_replace('/[^\d]/', '', $request->jumlah_hari);
            }
            if ($request->has('nilai_per_hari')) {
                $fin->nilai_per_hari = $this->cleanNumeric($request->nilai_per_hari);
            }
            if ($request->has('hari_berjalan')) {
                $fin->hari_2026 = (int) preg_replace('/[^\d]/', '', $request->hari_berjalan);
            }
            if ($request->has('nilai_tahun_berjalan')) {
                $fin->nilai_2026 = $this->cleanNumeric($request->nilai_tahun_berjalan);
            }
            $fin->save();

            // 4. Update MonthlySchedule
            $sched = $contract->monthlySchedules->first() ?: new \App\Models\MonthlySchedule([
                'contract_number' => $contract->contract_number,
                'tahun'           => 2026,
            ]);

            $months = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
            $sum = 0.0;
            foreach ($months as $m) {
                $dbCol = ($m === 'februari') ? 'febuari' : $m;
                if ($request->has($m) && $request->input($m) !== null && $request->input($m) !== '') {
                    $sched->$dbCol = $this->cleanNumeric($request->input($m));
                }
                $sum += (float) $sched->$dbCol;
            }
            if ($request->has('total_jandes') && $request->input('total_jandes') !== '') {
                $sched->jan_des = $this->cleanNumeric($request->total_jandes);
            } else {
                $sched->jan_des = $sum;
            }
            $sched->save();
        }

        // 5. Update Asset
        if ($asset) {
            if ($request->filled('asset_block_name')) {
                $asset->asset_block_name = $request->asset_block_name;
            }
            if ($request->filled('wilayah_asset')) {
                $asset->wilayah_asset = $request->wilayah_asset;
            }
            if ($request->filled('jenis_asset')) {
                $asset->jenis_asset = $request->jenis_asset;
            }
            if ($request->filled('stasiun')) {
                $asset->stasiun = $request->stasiun;
            }
            if ($request->filled('peruntukan')) {
                $asset->peruntukan = $request->peruntukan;
            }
            if ($request->filled('size_area')) {
                $asset->size_area = (float) preg_replace('/[^\d.]/', '', str_replace(',', '.', $request->size_area));
            }
            if ($request->filled('latitude')) {
                $asset->latitude = (float) $request->latitude;
            }
            if ($request->filled('longitude')) {
                $asset->longitude = (float) $request->longitude;
            }

            // Image uploads
            if ($request->hasFile('images')) {
                $imgPaths = is_array($asset->images) ? $asset->images : [];
                foreach ($request->file('images') as $file) {
                    if ($file->isValid()) {
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/assets'), $filename);
                        $imgPaths[] = 'uploads/assets/' . $filename;
                    }
                }
                $asset->images = $imgPaths;
            }

            $asset->save();
        }

        // Invalidasi cache karena data aset/kontrak/keuangan berubah
        Cache::forget('map_assets');
        Cache::forget('dropdown_jenis_asset');
        Cache::forget('dropdown_status_customer');
        DashboardController::forgetDashboardCache();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Sukses update data aset terbaru!',
            ]);
        }

        return redirect()->back()->with('success', 'Sukses update data aset terbaru!');
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

        if (substr_count($clean, '.') > 1) {
            $parts = explode('.', $clean);
            $last  = array_pop($parts);
            if (strlen($last) <= 2 && !str_contains($clean, ',')) {
                $clean = implode('', $parts) . '.' . $last;
            } else {
                $clean = implode('', $parts) . $last;
            }
        } elseif (substr_count($clean, '.') === 1 && str_contains($clean, ',')) {
            $clean = str_replace('.', '', $clean);
            $clean = str_replace(',', '.', $clean);
        } elseif (substr_count($clean, '.') === 1 && !str_contains($clean, ',')) {
            $parts = explode('.', $clean);
            if (strlen($parts[1]) === 3) {
                $clean = $parts[0] . $parts[1];
            }
        } elseif (str_contains($clean, ',')) {
            $clean = str_replace(',', '.', $clean);
        }

        return (float) $clean;
    }

    /**
     * Delete a KAI Contract or Asset and redirect back.
     */
    public function destroy(string $identifier)
    {
        $contract = \App\Models\KaiContract::where('contract_number', $identifier)->first();
        if ($contract) {
            $assetNumber = $contract->asset_number;
            $contract->delete();
            // Hapus aset juga jika tidak ada kontrak lain yang mereferensikannya
            if ($assetNumber && \App\Models\KaiContract::where('asset_number', $assetNumber)->count() === 0) {
                \App\Models\KaiAsset::where('asset_number', $assetNumber)->delete();
            }
        } else {
            $asset = KaiAsset::where('asset_number', $identifier)->first();
            if ($asset) {
                $asset->delete();
            }
        }

        // Invalidasi cache karena aset/kontrak dihapus
        Cache::forget('map_assets');
        Cache::forget('dropdown_jenis_asset');
        Cache::forget('dropdown_status_customer');
        DashboardController::forgetDashboardCache();

        return redirect()->back()->with('success', 'Sukses menghapus data!');
    }
}
