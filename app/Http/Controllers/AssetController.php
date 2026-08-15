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
        $assets = Asset::with(['images', 'favorites'])->withCount('favorites')->get();

        $kpi = [
            'total_assets'    => $assets->count(),
            'total_valuation' => $this->formatPrice($assets->sum('price')),
            'average_age'     => '12Y',
        ];

        $assetsForMap = $assets->map(function($a) {
            $priceVal = (float) $a->price;
            if ($priceVal >= 1000000000) {
                $shortPrice = 'Rp ' . rtrim(rtrim(number_format($priceVal / 1000000000, 1, ',', '.'), '0'), ',') . ' M';
            } elseif ($priceVal >= 1000000) {
                $shortPrice = 'Rp ' . number_format($priceVal / 1000000, 0, ',', '.') . ' Jt';
            } else {
                $shortPrice = 'Rp ' . number_format($priceVal, 0, ',', '.');
            }

            return [
                'id'            => $a->id,
                'title'         => $a->name,
                'asset_code'    => $a->asset_code,
                'address'       => $a->full_address,
                'district'      => $a->district_area ?? 'Semarang',
                'lat'           => (float) $a->latitude,
                'lng'           => (float) $a->longitude,
                'land_area'     => number_format($a->land_area, 0, ',', '.') . ' m²',
                'building_area' => number_format($a->building_area, 0, ',', '.') . ' m²',
                'road_access'   => $a->road_access ?? 'Akses Aspal',
                'electricity'   => $a->electricity ?? '33.000 VA',
                'description'   => $a->description ?? 'Aset strategis PT KAI Daop 4 Semarang siap dikerjasamakan.',
                'price'         => $a->price_formatted,
                'short_price'   => $shortPrice,
                'status'        => $a->status_label,
                'raw_status'    => $a->status,
                'status_color'  => $a->status_color,
                'image'         => $a->primary_image_url,
                'likes_count'   => $a->favorites_count ?? 0,
                'contact_phone' => $a->contact_phone ?? '6281234567890',
            ];
        });

        return view('assets.explorer', compact('kpi', 'assetsForMap'));
    }

    public function catalog(Request $request)
    {
        $query = Asset::with('images')->withCount('favorites');

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

        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'land_desc'  => $query->orderBy('land_area', 'desc'),
            default      => $query->latest(),
        };

        $assets = $query->get();
        $districts = Asset::select('district_area')->distinct()->pluck('district_area');
        $favoriteIds = $this->getFavoriteIds();

        return view('assets.catalog', compact('assets', 'districts', 'favoriteIds'));
    }

    public function show(int $id)
    {
        $asset = Asset::with('images')->withCount('favorites')->findOrFail($id);
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

    public function settings()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
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