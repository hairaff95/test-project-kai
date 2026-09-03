<?php

namespace App\Http\Controllers;

use App\Models\KaiAsset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    /**
     * Ambil aset baru yang ditambahkan dalam 1 hari terakhir.
     * Digunakan oleh tombol notifikasi bell di navbar.
     */
    public function newAssets(): JsonResponse
    {
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
                'url'              => route('asset.detail', $asset->asset_number),
            ];
        });

        return response()->json([
            'count' => $items->count(),
            'items' => $items,
        ]);
    }
}
