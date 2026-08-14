<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with('images')->get();

        $kpi = [
            'total_assets'    => $assets->count(),
            'total_valuation' => $this->formatPrice($assets->sum('price')),
            'average_age'     => '12Y',
        ];

        $assetsForMap = $assets->map(fn($a) => [
            'id'            => $a->id,
            'title'         => $a->name,
            'address'       => $a->full_address,
            'lat'           => (float) $a->latitude,
            'lng'           => (float) $a->longitude,
            'land_area'     => number_format($a->land_area, 0, ',', '.') . ' m²',
            'building_area' => number_format($a->building_area, 0, ',', '.') . ' m²',
            'road_access'   => $a->road_access,
            'price'         => $a->price_formatted,
            'status'        => $a->status_label,
            'status_color'  => $a->status_color,
            'image'         => $a->primary_image_url,
        ]);

        return view('assets.explorer', compact('kpi', 'assetsForMap'));
    }

    public function catalog(Request $request)
    {
        $query = Asset::with('images');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('full_address', 'like', "%{$search}%")
                  ->orWhere('district_area', 'like', "%{$search}%");
            });
        }

        if ($request->filled('district')) {
            $query->where('district_area', 'like', '%' . $request->district . '%');
        }

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $assets = $query->latest()->get();
        $districts = Asset::select('district_area')->distinct()->pluck('district_area');
        $favoriteIds = $this->getFavoriteIds();

        return view('assets.catalog', compact('assets', 'districts', 'favoriteIds'));
    }

    public function show(int $id)
    {
        $asset = Asset::with('images')->findOrFail($id);
        $favoriteIds = $this->getFavoriteIds();
        $isFavorited = in_array($asset->id, $favoriteIds);

        return view('assets.show', compact('asset', 'isFavorited'));
    }

    public function manage()
    {
        return redirect()->route('admin.assets.index');
    }

    public function faq()
    {
        $role = Auth::check() ? Auth::user()->role : 'user';
        return view('faq.index', compact('role'));
    }

    private function formatPrice(float $total): string
    {
        if ($total >= 1_000_000_000) {
            return 'Rp ' . number_format($total / 1_000_000_000, 2) . ' M';
        }
        return 'Rp ' . number_format($total / 1_000_000, 2) . ' Jt';
    }

    private function getFavoriteIds(): array
    {
        if (Auth::check()) {
            return Favorite::where('user_id', Auth::id())->pluck('asset_id')->toArray();
        }
        return session('favorite_ids', []);
    }
}