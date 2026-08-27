<?php

namespace App\Http\Controllers;

use App\Models\KaiAsset;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $assets = KaiAsset::with('contract.penyewa')->get();

        // Format data untuk JavaScript di view — key by asset_number
        $assetsForMap = $assets->keyBy('asset_number')->map(function ($asset) {
            $contract = $asset->contract;
            $penyewa  = $contract?->penyewa;

            return [
                'name'      => $asset->asset_block_name,
                'code'      => $asset->asset_number,
                'location'  => $asset->stasiun,
                'address'   => $asset->wilayah_aset,
                'area'      => $asset->size_area_formatted,
                'type'      => $asset->jenis_aset . ' — ' . $asset->peruntukan,
                'value'     => $contract ? 'Rp ' . number_format((float) $contract->price, 0, ',', '.') : '-',
                'period'    => $contract
                    ? $contract->start_datetime->format('d/m/Y') . ' – ' . $contract->end_datetime->format('d/m/Y')
                    : '',
                'tenant'    => $penyewa?->fullnama ?? '-',
                'latitude'  => (string) $asset->latitude,
                'longitude' => (string) $asset->longitude,
            ];
        });

        return view('map.index', ['assets' => $assetsForMap]);
    }
}
