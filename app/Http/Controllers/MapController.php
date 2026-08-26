<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $assets = Asset::all();

        // Format data untuk JavaScript di view
        $assetsForMap = $assets->keyBy('id')->map(function ($asset) {
            return [
                'name'      => $asset->name,
                'code'      => $asset->asset_code ?? '',
                'location'  => $asset->district_area ?? '',
                'address'   => $asset->full_address ?? '',
                'area'      => number_format((float) $asset->land_area, 2, ',', '.') . ' m²',
                'type'      => $asset->description ?? '',
                'value'     => $asset->price_formatted,
                'period'    => '',
                'latitude'  => (string) $asset->latitude,
                'longitude' => (string) $asset->longitude,
            ];
        });

        return view('map', ['assets' => $assetsForMap]);
    }
}
