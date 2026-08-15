<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssetManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::with('images')->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%{$s}%")
                ->orWhere('full_address', 'like', "%{$s}%"));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $assets = $query->get();
        $stats = [
            'total'     => $assets->count(),
            'available' => $assets->where('status', 'available')->count(),
            'reserved'  => $assets->where('status', 'reserved')->count(),
            'sold'      => $assets->where('status', 'sold')->count(),
            'rented'    => $assets->where('status', 'sold')->count(),
        ];

        return view('admin.assets.index', compact('assets', 'stats'));
    }

    public function create()
    {
        return view('admin.assets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_code'     => 'required|string|unique:assets,asset_code',
            'name'           => 'required|string|max:255',
            'district_area'  => 'required|string|max:255',
            'full_address'   => 'required|string',
            'description'    => 'nullable|string',
            'land_area'      => 'required|numeric|min:0',
            'building_area'  => 'required|numeric|min:0',
            'price'          => 'required|numeric|min:0',
            'road_access'    => 'nullable|string|max:255',
            'electricity'    => 'nullable|string|max:255',
            'water_supply'   => 'nullable|string|max:255',
            'security'       => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone'  => 'nullable|string|max:50',
            'latitude'       => 'required|numeric',
            'longitude'      => 'required|numeric',
            'status'         => 'required|in:available,reserved,sold',
            'images.*'       => 'nullable|image|max:4096',
        ]);

        $validated['created_by'] = Auth::id();
        $asset = Asset::create($validated);

        // Upload gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('assets', 'public');
                AssetImage::create([
                    'asset_id'   => $asset->id,
                    'image_path' => $path,
                    'is_primary' => $i === 0,
                ]);
            }
        }

        return redirect()->route('admin.assets.index')
            ->with('success', "Aset «{$asset->name}» berhasil ditambahkan.");
    }

    public function edit(Asset $asset)
    {
        return view('admin.assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'asset_code'     => 'required|string|unique:assets,asset_code,' . $asset->id,
            'name'           => 'required|string|max:255',
            'district_area'  => 'required|string|max:255',
            'full_address'   => 'required|string',
            'description'    => 'nullable|string',
            'land_area'      => 'required|numeric|min:0',
            'building_area'  => 'required|numeric|min:0',
            'price'          => 'required|numeric|min:0',
            'road_access'    => 'nullable|string|max:255',
            'electricity'    => 'nullable|string|max:255',
            'water_supply'   => 'nullable|string|max:255',
            'security'       => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone'  => 'nullable|string|max:50',
            'latitude'       => 'required|numeric',
            'longitude'      => 'required|numeric',
            'status'         => 'required|in:available,reserved,sold',
            'images.*'       => 'nullable|image|max:4096',
        ]);

        $asset->update($validated);

        // Tambah gambar baru jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('assets', 'public');
                AssetImage::create([
                    'asset_id'   => $asset->id,
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        // Hapus gambar yang diminta
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $img = AssetImage::where('id', $imageId)->where('asset_id', $asset->id)->first();
                if ($img) {
                    if (!str_starts_with($img->image_path, 'http')) {
                        Storage::disk('public')->delete($img->image_path);
                    }
                    $img->delete();
                }
            }
        }

        return redirect()->route('admin.assets.index')
            ->with('success', "Aset «{$asset->name}» berhasil diperbarui.");
    }

    public function destroy(Asset $asset)
    {
        // Hapus file gambar dari storage
        foreach ($asset->images as $img) {
            if (!str_starts_with($img->image_path, 'http')) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        $name = $asset->name;
        $asset->delete();

        return redirect()->route('admin.assets.index')
            ->with('success', "Aset «{$name}» berhasil dihapus.");
    }
}
