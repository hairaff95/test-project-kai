<?php

namespace App\Http\Controllers;

use App\Models\KaiAsset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class NotificationController extends Controller
{
    /**
     * Ambil aset baru yang ditambahkan dalam 1 hari terakhir.
     * Digunakan oleh tombol notifikasi bell di navbar.
     *
     * Di-cache 60 detik agar polling dari navbar tidak membebani DB.
     * Cache di-invalidasi dari forgetContractCache() setiap kali ada aset/kontrak baru dibuat.
     */
    public function newAssets(): JsonResponse
    {
        $data = Cache::remember('notification_new_assets', 60, function () {
            $since = Carbon::now()->subDay(); // 24 jam terakhir

            $assets = KaiAsset::where('created_at', '>=', $since)
                ->orderBy('created_at', 'desc')
                ->get(['asset_number', 'asset_block_name', 'stasiun', 'jenis_asset', 'created_at']);

            $items = $assets->map(function ($asset) {
                return [
                    'asset_number'     => $asset->asset_number,
                    'asset_block_name' => $asset->asset_block_name ?? '-',
                    'stasiun'          => $asset->stasiun ?? '-',
                    'jenis_asset'      => $asset->jenis_asset ?? '-',
                    'created_at'       => $asset->created_at
                        ? $asset->created_at->diffForHumans()
                        : '-',
                    'created_at_ts'    => $asset->created_at
                        ? $asset->created_at->timestamp
                        : 0,
                    'url'              => route('asset.detail', $asset->asset_number),
                ];
            })->values()->all();

            return [
                'count' => count($items),
                'items' => $items,
            ];
        });

        return response()->json($data);
    }
}
