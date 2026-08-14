<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Aset Baru — Admin KAI Daop 4</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = { theme: { extend: {
            colors: { "primary":"#006948","primary-dark":"#005137","primary-light":"#e6f4ee","background":"#f4f8f5","surface":"#ffffff","on-surface":"#1a201c","on-surface-variant":"#637369","border-subtle":"#e8eee9" },
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
        <h1 class="text-2xl md:text-3xl font-bold text-on-surface">Tambah Aset Baru</h1>
    </div>

    @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.assets.store') }}" enctype="multipart/form-data"
        class="flex flex-col gap-6">
        @csrf

        {{-- Identitas Aset --}}
        <div class="bg-white rounded-2xl border border-border-subtle p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">badge</span> Identitas Aset
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label>Kode Aset *</label>
                    <input type="text" name="asset_code" value="{{ old('asset_code') }}" required
                        placeholder="Contoh: KAI-SMG-004"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Status Aset *</label>
                    <select name="status" required class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary">
                        <option value="available" {{ old('status')=='available'?'selected':'' }}>Tersedia</option>
                        <option value="reserved"  {{ old('status')=='reserved' ?'selected':'' }}>Dalam Proses</option>
                        <option value="sold"      {{ old('status')=='sold'     ?'selected':'' }}>Terjual</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label>Nama Aset *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Eks Gudang Logistik Kaligawe"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Wilayah / Kecamatan *</label>
                    <input type="text" name="district_area" value="{{ old('district_area') }}" required
                        placeholder="Contoh: Genuk - Semarang Timur"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Akses Jalan</label>
                    <input type="text" name="road_access" value="{{ old('road_access') }}"
                        placeholder="Kontainer 40ft / Mobil 2 Arah"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div class="sm:col-span-2">
                    <label>Alamat Lengkap *</label>
                    <input type="text" name="full_address" value="{{ old('full_address') }}" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div class="sm:col-span-2">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary">{{ old('description') }}</textarea>
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
                    <input type="number" name="land_area" value="{{ old('land_area', 0) }}" min="0" step="0.01" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Luas Bangunan (m²) *</label>
                    <input type="number" name="building_area" value="{{ old('building_area', 0) }}" min="0" step="0.01" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="1000000" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Listrik</label>
                    <input type="text" name="electricity" value="{{ old('electricity') }}" placeholder="105.000 VA"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Air</label>
                    <input type="text" name="water_supply" value="{{ old('water_supply') }}" placeholder="PDAM / Sumur"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Keamanan</label>
                    <input type="text" name="security" value="{{ old('security') }}" placeholder="24 Jam"
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
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Nomor Telepon PIC</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone') }}"
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
            </div>
        </div>

        {{-- Koordinat GPS --}}
        <div class="bg-white rounded-2xl border border-border-subtle p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">my_location</span> Koordinat GPS
            </h2>
            <p class="text-xs text-on-surface-variant mb-4">Klik pada peta untuk menentukan titik koordinat, atau isi manual di bawah.</p>
            <div id="map-picker" class="mb-4 border border-border-subtle"></div>
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label>Latitude *</label>
                    <input type="number" id="lat-input" name="latitude" value="{{ old('latitude', -6.9932) }}" step="any" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label>Longitude *</label>
                    <input type="number" id="lng-input" name="longitude" value="{{ old('longitude', 110.4203) }}" step="any" required
                        class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
                </div>
            </div>
        </div>

        {{-- Upload Gambar --}}
        <div class="bg-white rounded-2xl border border-border-subtle p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">photo_library</span> Foto Aset
            </h2>
            <p class="text-xs text-on-surface-variant mb-3">Gambar pertama akan dijadikan gambar utama. Max 4MB per file.</p>
            <input type="file" name="images[]" multiple accept="image/*"
                class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-light file:text-primary hover:file:bg-primary/20 transition" />
        </div>

        {{-- Submit --}}
        <div class="flex gap-3">
            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-full font-semibold text-sm hover:bg-primary-dark transition shadow-md">
                Simpan Aset
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

    const map = L.map('map-picker').setView([parseFloat(latInput.value), parseFloat(lngInput.value)], 13);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', { maxZoom: 19 }).addTo(map);

    let marker = L.marker([parseFloat(latInput.value), parseFloat(lngInput.value)], { draggable: true }).addTo(map);

    function updateInputs(lat, lng) {
        latInput.value = lat.toFixed(7);
        lngInput.value = lng.toFixed(7);
    }

    map.on('click', e => {
        marker.setLatLng(e.latlng);
        updateInputs(e.latlng.lat, e.latlng.lng);
    });

    marker.on('dragend', e => {
        const pos = e.target.getLatLng();
        updateInputs(pos.lat, pos.lng);
    });

    [latInput, lngInput].forEach(inp => {
        inp.addEventListener('change', () => {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                marker.setLatLng([lat, lng]);
                map.panTo([lat, lng]);
            }
        });
    });
</script>
</body>
</html>
