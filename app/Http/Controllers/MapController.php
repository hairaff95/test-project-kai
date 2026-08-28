<?php

namespace App\Http\Controllers;

use App\Models\KaiAsset;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $assets = KaiAsset::with('contract.tenant')->get();

        // Format data untuk JavaScript di view — key by asset_number
        $assetsForMap = $assets->keyBy('asset_number')->map(function ($asset) {
            $contract = $asset->contract;
            $tenant   = $contract?->tenant;

            return [
                'name'      => $asset->asset_block_name,
                'code'      => $asset->asset_number,
                'location'  => $asset->stasiun,
                'address'   => $asset->wilayah_asset,
                'area'      => $asset->size_area_formatted,
                'type'      => $asset->jenis_asset . ' — ' . $asset->peruntukan,
                'value'     => $contract ? 'Rp ' . number_format((float) $contract->price, 0, ',', '.') : '-',
                'period'    => $contract
                    ? $contract->start_datetime->format('d/m/Y') . ' – ' . $contract->end_datetime->format('d/m/Y')
                    : '',
                'tenant'    => $tenant?->fullname ?? '-',
                'latitude'  => (string) $asset->latitude,
                'longitude' => (string) $asset->longitude,
            ];
        });

        return view('map.index', ['assets' => $assetsForMap]);
    }
}
