<?php

namespace App\Http\Controllers;

use App\Models\KaiAsset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display the full interactive detail page for a KAI Asset.
     */
    public function showKai(string $asset_number)
    {
        $asset = KaiAsset::with(['contract.tenant', 'contract.financial', 'contract.monthlySchedules'])
            ->where('asset_number', $asset_number)
            ->firstOrFail();

        return view('assets.detail', compact('asset'));
    }

    /**
     * Delete a KAI Asset and redirect back.
     */
    public function destroy(string $asset_number)
    {
        $asset = KaiAsset::where('asset_number', $asset_number)->first();
        if ($asset) {
            $asset->delete();
        }

        return redirect()->back()->with('success', 'Aset berhasil dihapus.');
    }
}