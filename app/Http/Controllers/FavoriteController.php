<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $favorites = Favorite::where('user_id', Auth::id())
                ->with('asset.images')
                ->latest()
                ->get();
        } else {
            $ids = session('favorite_ids', []);
            $favorites = collect($ids)->map(function ($id) {
                $asset = Asset::with('images')->find($id);
                if (!$asset) return null;
                return (object) ['asset' => $asset];
            })->filter();
        }

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $request->validate(['asset_id' => 'required|exists:assets,id']);
        $assetId = (int) $request->asset_id;

        if (Auth::check()) {
            $existing = Favorite::where('user_id', Auth::id())
                ->where('asset_id', $assetId)
                ->first();

            if ($existing) {
                $existing->delete();
                $isFavorited = false;
            } else {
                Favorite::create([
                    'user_id'  => Auth::id(),
                    'asset_id' => $assetId,
                ]);
                $isFavorited = true;
            }
        } else {
            $ids = session('favorite_ids', []);

            if (in_array($assetId, $ids)) {
                $ids = array_values(array_diff($ids, [$assetId]));
                $isFavorited = false;
            } else {
                $ids[] = $assetId;
                $isFavorited = true;
            }

            session(['favorite_ids' => $ids]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'is_favorited' => $isFavorited,
                'asset_id'     => $assetId,
            ]);
        }

        return back()->with('success', $isFavorited ? 'Ditambahkan ke favorit.' : 'Dihapus dari favorit.');
    }
}
