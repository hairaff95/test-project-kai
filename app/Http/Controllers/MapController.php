<?php

namespace App\Http\Controllers;

use App\Models\KaiAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MapController extends Controller
{
    public function index()
    {
        // Cache selama 1 jam — data peta jarang berubah, query ini berat (ribuan koordinat + eager load)
        $assetsForMap = Cache::remember('map_assets', 3600, function () {
            return KaiAsset::with('contract.tenant')->get()
                ->keyBy('asset_number')
                ->map(function ($asset) {
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
                })
                ->toArray(); // simpan sebagai plain array agar aman di-serialize ke cache
        });

        return view('map.index', ['assets' => $assetsForMap]);
    }
}
