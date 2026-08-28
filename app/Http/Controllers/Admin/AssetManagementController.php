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
        // Cari KaiAsset berdasarkan asset_number
        $kaiAsset = \App\Models\KaiAsset::with('contract.financial', 'contract.monthlySchedules')
            ->where('asset_number', $asset->asset_number ?? $asset->getKey())
            ->first();

        // Jika tidak ketemu di KaiAsset, buat objek dummy dari Asset lama
        return view('asset-edit', ['asset' => $kaiAsset ?? $asset]);
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

        return redirect()->route('asset.detail', $asset->id)
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

        return redirect()->route('map')
            ->with('success', "Aset «{$name}» berhasil dihapus.");
    }

    // ── KaiAsset update & destroy (schema baru) ───────────────

    public function editKai(string $asset_number)
    {
        $asset = \App\Models\KaiAsset::with('contract.financial', 'contract.monthlySchedules')
            ->where('asset_number', $asset_number)
            ->firstOrFail();

        return view('assets.edit', compact('asset'));
    }

    public function updateKai(Request $request, string $asset_number)
    {
        $asset = \App\Models\KaiAsset::where('asset_number', $asset_number)->firstOrFail();

        $validated = $request->validate([
            'asset_block_name' => 'required|string|max:255',
            'size_area'        => 'required|numeric|min:0',
            'peruntukan'       => 'nullable|string|max:100',
            'jenis_asset'       => 'nullable|string|max:100',
            'stasiun'          => 'nullable|string|max:100',
            'wilayah_asset'     => 'nullable|string|max:100',
            'latitude'         => 'nullable|numeric',
            'longitude'        => 'nullable|numeric',
        ]);

        $asset->update($validated);

        return redirect()->route('asset.detail', $asset->asset_number)
            ->with('success', "Aset «{$asset->asset_block_name}» berhasil diperbarui.");
    }

    public function destroyKai(string $asset_number)
    {
        $asset = \App\Models\KaiAsset::where('asset_number', $asset_number)->firstOrFail();
        $name  = $asset->asset_block_name;
        $asset->delete();

        return redirect()->route('map')
            ->with('success', "Aset «{$name}» berhasil dihapus.");
    }
}
