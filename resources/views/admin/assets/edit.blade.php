<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Aset — {{ $asset->name }} — Admin KAI Daop 4</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = { theme: { extend: {
            colors: { "primary":"#006948","primary-dark":"#005137","primary-light":"#e6f4ee","background":"#f4f8f5","surface":"#ffffff","on-surface":"#1a201c","on-surface-variant":"#637369","border-subtle":"#e8eee9","danger":"#dc2626","danger-light":"#fee2e2" },
            fontFamily: { "jakarta":["Plus Jakarta Sans","sans-serif"] }
        }}}
    </script>
    <style>
        body { font-family:"Plus Jakarta Sans",sans-serif; }
        .material-symbols-outlined { font-variation-settings:"FILL" 0,"wght" 400,"GRAD" 0,"opsz" 24; line-height:1; }
        #map-picker { height: 260px; border-radius: 1rem; z-index: 1; }
        label { font-size: 0.8rem; font-weight: 600; color: #3d4a42; display:block; margin-bottom:0.3rem; }
    </style>
</head>
<body class="bg-background min-h-screen">

<x-sidebar />

<main class="pl-4 pr-4 sm:pl-28 sm:pr-6 md:pl-32 md:pr-8 pt-8 pb-16 max-w-4xl mx-auto">

    <div class="mb-8">
        <a href="{{ route('admin.assets.index') }}" class="inline-flex items-center gap-1 text-sm text-on-surface-variant hover:text-primary mb-4 transition">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-on-surface">Edit Aset</h1>
        <p class="text-sm text-on-surface-variant mt-1">{{ $asset->asset_code }} — {{ $asset->name }}</p>
    </div>

    @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.assets.update', $asset) }}" enctype="multipart/form-data" class="flex flex-col gap-6">
        @csrf @method('PUT')

        {{-- Identitas Aset --}}
        <div class="bg-white rounded-2xl border border-border-subtle p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">badge</span> Identitas Aset
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label>Kode Aset *</label>
                    <input type="text" name="asset_code" value="{{ old('asset_code', $asset->asset_code) }}" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Status Aset *</label>
                    <select name="status" required class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary">
                        <option value="available" {{ old('status',$asset->status)=='available'?'selected':'' }}>Tersedia</option>
                        <option value="reserved"  {{ old('status',$asset->status)=='reserved' ?'selected':'' }}>Dalam Proses</option>
                        <option value="sold"      {{ old('status',$asset->status)=='sold'     ?'selected':'' }}>Terjual</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label>Nama Aset *</label>
                    <input type="text" name="name" value="{{ old('name', $asset->name) }}" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Wilayah / Kecamatan *</label>
                    <input type="text" name="district_area" value="{{ old('district_area', $asset->district_area) }}" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Akses Jalan</label>
                    <input type="text" name="road_access" value="{{ old('road_access', $asset->road_access) }}"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div class="sm:col-span-2">
                    <label>Alamat Lengkap *</label>
                    <input type="text" name="full_address" value="{{ old('full_address', $asset->full_address) }}" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div class="sm:col-span-2">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary">{{ old('description', $asset->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Spesifikasi --}}
        <div class="bg-white rounded-2xl border border-border-subtle p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">straighten</span> Spesifikasi
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label>Luas Tanah (m²) *</label>
                    <input type="number" name="land_area" value="{{ old('land_area', $asset->land_area) }}" min="0" step="0.01" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Luas Bangunan (m²) *</label>
                    <input type="number" name="building_area" value="{{ old('building_area', $asset->building_area) }}" min="0" step="0.01" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price', $asset->price) }}" min="0" step="1000000" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Listrik</label>
                    <input type="text" name="electricity" value="{{ old('electricity', $asset->electricity) }}"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Air</label>
                    <input type="text" name="water_supply" value="{{ old('water_supply', $asset->water_supply) }}"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Keamanan</label>
                    <input type="text" name="security" value="{{ old('security', $asset->security) }}"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
            </div>
        </div>

        {{-- Kontak PIC --}}
        <div class="bg-white rounded-2xl border border-border-subtle p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">contact_phone</span> Kontak PIC
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label>Nama PIC</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person', $asset->contact_person) }}"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Nomor Telepon PIC</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $asset->contact_phone) }}"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
            </div>
        </div>

        {{-- Koordinat --}}
        <div class="bg-white rounded-2xl border border-border-subtle p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">my_location</span> Koordinat GPS
            </h2>
            <p class="text-xs text-on-surface-variant mb-4">Klik pada peta atau seret marker untuk mengubah posisi.</p>
            <div id="map-picker" class="mb-4 border border-border-subtle"></div>
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label>Latitude *</label>
                    <input type="number" id="lat-input" name="latitude" value="{{ old('latitude', $asset->latitude) }}" step="any" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Longitude *</label>
                    <input type="number" id="lng-input" name="longitude" value="{{ old('longitude', $asset->longitude) }}" step="any" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
            </div>
        </div>

        {{-- Foto Existing --}}
        @if($asset->images->isNotEmpty())
        <div class="bg-white rounded-2xl border border-border-subtle p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">photo_library</span> Foto Saat Ini
            </h2>
            <div class="flex flex-wrap gap-3">
                @foreach($asset->images as $img)
                <div class="relative group">
                    <img src="{{ $img->url }}" alt="" class="w-28 h-20 rounded-xl object-cover border border-border-subtle" />
                    <label class="absolute top-1 right-1 flex items-center gap-1 bg-red-500/90 text-white text-[10px] rounded-full px-1.5 py-0.5 cursor-pointer opacity-0 group-hover:opacity-100 transition">
                        <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="sr-only" />
                        <span class="material-symbols-outlined text-xs">delete</span>
                    </label>
                    @if($img->is_primary)
                    <span class="absolute bottom-1 left-1 bg-primary text-white text-[9px] px-1.5 py-0.5 rounded-full">Utama</span>
                    @endif
                </div>
                @endforeach
            </div>
            <p class="text-xs text-on-surface-variant mt-3">Hover foto dan centang tanda silang merah untuk menghapus foto tersebut saat menyimpan.</p>
        </div>
        @endif

        {{-- Upload Foto Baru --}}
        <div class="bg-white rounded-2xl border border-border-subtle p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">add_photo_alternate</span> Tambah Foto Baru
            </h2>
            <input type="file" name="images[]" multiple accept="image/*"
                class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-light file:text-primary hover:file:bg-primary/20 transition" />
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-full font-semibold text-sm hover:bg-primary-dark transition shadow-md">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.assets.index') }}" class="px-8 py-3 rounded-full font-semibold text-sm border border-border-subtle hover:bg-background transition text-on-surface-variant">
                Batal
            </a>
        </div>
    </form>
</main>

<script>
    const latInput = document.getElementById('lat-input');
    const lngInput = document.getElementById('lng-input');
    const initLat = parseFloat(latInput.value);
    const initLng = parseFloat(lngInput.value);

    const map = L.map('map-picker').setView([initLat, initLng], 15);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', { maxZoom: 19 }).addTo(map);

    let marker = L.marker([initLat, initLng], { draggable: true }).addTo(map);

    map.on('click', e => {
        marker.setLatLng(e.latlng);
        latInput.value = e.latlng.lat.toFixed(7);
        lngInput.value = e.latlng.lng.toFixed(7);
    });

    marker.on('dragend', e => {
        const pos = e.target.getLatLng();
        latInput.value = pos.lat.toFixed(7);
        lngInput.value = pos.lng.toFixed(7);
    });
</script>
</body>
</html>
