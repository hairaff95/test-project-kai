@extends('layout.app')

@section('title', 'Tambah Aset Baru — Admin KAI Daop 4')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush

@section('content')
<div class="w-full max-w-full overflow-x-hidden px-4 sm:px-6 py-6 sm:py-8 pb-32 sm:pb-12 space-y-6 sm:space-y-8">

    {{-- Breadcrumb & Header --}}
    <div class="pb-6 border-b border-gray-200">
        <a href="{{ route('admin.assets.index') }}" 
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-gray-900 mb-3 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Manajemen Aset</span>
        </a>
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-950 tracking-tight">
            Tambah Data Aset Baru
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Lengkapi data properti PT KAI Daop 4 beserta titik koordinat peta (GIS).
        </p>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700">
        <div class="font-bold mb-1 flex items-center gap-1.5">
            <i data-lucide="alert-triangle" class="w-4 h-4 text-red-500"></i>
            <span>Terdapat beberapa kesalahan input:</span>
        </div>
        <ul class="list-disc list-inside space-y-0.5 pl-5">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.assets.store') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        {{-- Section 1: Basic Info & Location --}}
        <div class="space-y-4 pb-8 border-b border-gray-200">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Bagian 1</span>
                <h2 class="text-base sm:text-lg font-bold text-gray-950 flex items-center gap-2 mt-0.5">
                    <i data-lucide="info" class="w-4 h-4 text-primary"></i>
                    <span>Informasi Dasar & Lokasi</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Kode Aset *</label>
                    <input type="text" name="asset_code" value="{{ old('asset_code') }}" required
                           placeholder="Contoh: KAI-SMG-004"
                           class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>

                {{-- Status Dropdown --}}
                <div class="relative" x-data="{ 
                    open: false, 
                    selected: '{{ old('status', 'available') }}',
                    options: {
                        'available': { label: 'Tersedia (Available)', icon: 'check-circle', color: 'text-emerald-600' },
                        'reserved':  { label: 'Dalam Proses (Reserved)', icon: 'clock', color: 'text-amber-500' },
                        'sold':      { label: 'Terjual (Sold)', icon: 'tag', color: 'text-gray-500' }
                    }
                }" @click.outside="open = false">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Status Ketersediaan *</label>
                    <input type="hidden" name="status" :value="selected">

                    <button type="button" @click="open = !open" 
                            class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-900 flex items-center justify-between focus:border-primary focus:ring-1 focus:ring-primary transition">
                        <div class="flex items-center gap-2">
                            <i :data-lucide="options[selected].icon" :class="options[selected].color" class="w-4 h-4"></i>
                            <span x-text="options[selected].label" class="font-medium">
                                {{ old('status') === 'reserved' ? 'Dalam Proses (Reserved)' : (old('status') === 'sold' ? 'Terjual (Sold)' : 'Tersedia (Available)') }}
                            </span>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" 
                         x-cloak
                         style="display: none;"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute top-full left-0 right-0 mt-1.5 bg-white border border-gray-200 rounded-xl shadow-lg p-1.5 z-50">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-3 py-1.5">STATUS KETERSEDIAAN</p>
                        
                        <template x-for="(opt, key) in options" :key="key">
                            <button type="button" 
                                    @click="selected = key; open = false; $nextTick(() => lucide.createIcons())"
                                    :class="selected === key ? 'bg-primary-light text-primary font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                    class="w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs sm:text-sm transition">
                                <i :data-lucide="opt.icon" :class="opt.color" class="w-4 h-4"></i>
                                <span x-text="opt.label"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Nama Aset / Properti *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="Contoh: Lahan Komersial Stasiun Poncol"
                           class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Wilayah / District Area *</label>
                    <input type="text" name="district_area" value="{{ old('district_area') }}" required
                           placeholder="Contoh: Genuk - Semarang Timur"
                           class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>
            </div>

            <div>
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Alamat Lengkap *</label>
                <textarea name="full_address" rows="2" required
                          placeholder="Alamat jalan, nomor bangunan, kelurahan, kecamatan..."
                          class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">{{ old('full_address') }}</textarea>
            </div>

            <div>
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Deskripsi Properti</label>
                <textarea name="description" rows="3"
                          placeholder="Keunggulan lokasi, potensi bisnis, kondisi fisik bangunan..."
                          class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">{{ old('description') }}</textarea>
            </div>
        </div>

        {{-- Section 2: Dimensions & Specs --}}
        <div class="space-y-4 pb-8 border-b border-gray-200">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Bagian 2</span>
                <h2 class="text-base sm:text-lg font-bold text-gray-950 flex items-center gap-2 mt-0.5">
                    <i data-lucide="tag" class="w-4 h-4 text-primary"></i>
                    <span>Nilai Penawaran & Spesifikasi Teknis</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Luas Tanah (m²) *</label>
                    <input type="number" step="any" name="land_area" value="{{ old('land_area', 0) }}" required
                           class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Luas Bangunan (m²) *</label>
                    <input type="number" step="any" name="building_area" value="{{ old('building_area', 0) }}" required
                           class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Harga Penawaran (Rp) *</label>
                    <input type="number" step="any" name="price" value="{{ old('price') }}" required
                           placeholder="Contoh: 12500000000"
                           class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Akses Jalan</label>
                    <input type="text" name="road_access" value="{{ old('road_access') }}" placeholder="Kontainer 40ft / 2 Arah"
                           class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:border-primary outline-none transition">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Daya Listrik</label>
                    <input type="text" name="electricity" value="{{ old('electricity') }}" placeholder="105.000 VA"
                           class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:border-primary outline-none transition">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Pasokan Air</label>
                    <input type="text" name="water_supply" value="{{ old('water_supply') }}" placeholder="PDAM / Sumur"
                           class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:border-primary outline-none transition">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Keamanan</label>
                    <input type="text" name="security" value="{{ old('security') }}" placeholder="24 Jam / Pos Jaga"
                           class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:border-primary outline-none transition">
                </div>
            </div>
        </div>

        {{-- Section 3: Contact & Coordinates --}}
        <div class="space-y-4 pb-8 border-b border-gray-200">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Bagian 3</span>
                <h2 class="text-base sm:text-lg font-bold text-gray-950 flex items-center gap-2 mt-0.5">
                    <i data-lucide="map-pin" class="w-4 h-4 text-primary"></i>
                    <span>Titik Koordinat GIS & Kontak PIC</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Nama PIC Unit</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="Bpk. Arif Santoso"
                           class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-900 focus:border-primary outline-none transition">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">Nomor Telepon / WhatsApp PIC</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" placeholder="081234567890"
                           class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-900 focus:border-primary outline-none transition">
                </div>
            </div>

            {{-- Google Maps Paste --}}
            <div class="p-4 rounded-xl bg-orange-50/60 border border-primary-border space-y-2.5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <label class="text-xs font-bold text-gray-900 flex items-center gap-1.5">
                        <i data-lucide="clipboard-paste" class="w-4 h-4 text-primary shrink-0"></i>
                        <span>Tempel Koordinat dari Google Maps</span>
                    </label>
                    <span class="text-[10px] sm:text-[11px] text-gray-500">Mendukung: Lat, Lng / Link Maps</span>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" id="gmaps-paste-input" 
                           placeholder="Contoh: -6.9553, 110.4561 atau link Google Maps..." 
                           class="w-full flex-1 bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-gray-900 placeholder-gray-400 focus:border-primary outline-none transition">
                    <button type="button" onclick="applyGmapsInput()" 
                            class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-semibold transition flex items-center justify-center gap-1.5 shrink-0">
                        <i data-lucide="locate-fixed" class="w-3.5 h-3.5"></i>
                        <span>Terapkan Titik</span>
                    </button>
                </div>
                <p id="paste-msg" class="text-[11px] text-emerald-700 font-medium hidden flex items-center gap-1">
                    <i data-lucide="check" class="w-3.5 h-3.5"></i> <span>Koordinat berhasil diterapkan ke peta!</span>
                </p>
            </div>

            <div>
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1.5">
                    Pilih Titik di Peta (Bisa Diklik atau Digeser Langsung)
                </label>
                <div id="map-picker" class="w-full h-64 rounded-xl border border-gray-200 overflow-hidden mb-3 relative z-0"></div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs text-gray-500 font-semibold mb-1 block">Latitude *</label>
                        <input type="number" step="any" id="lat-input" name="latitude" value="{{ old('latitude', -6.9932) }}" required
                               class="w-full bg-white border border-gray-200 rounded-xl px-3 py-2 text-xs font-mono text-gray-800 focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 font-semibold mb-1 block">Longitude *</label>
                        <input type="number" step="any" id="lng-input" name="longitude" value="{{ old('longitude', 110.4203) }}" required
                               class="w-full bg-white border border-gray-200 rounded-xl px-3 py-2 text-xs font-mono text-gray-800 focus:border-primary outline-none">
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 4: Upload Photos --}}
        <div class="space-y-3 pb-8 border-b border-gray-200">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Bagian 4</span>
                <h2 class="text-base sm:text-lg font-bold text-gray-950 flex items-center gap-2 mt-0.5">
                    <i data-lucide="image" class="w-4 h-4 text-primary"></i>
                    <span>Unggah Foto Properti</span>
                </h2>
            </div>
            <p class="text-xs text-gray-500">Pilih satu atau beberapa file foto (JPG, PNG, WebP). Foto pertama akan otomatis menjadi foto utama.</p>
            <input type="file" name="images[]" multiple accept="image/*"
                   class="block w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-primary hover:file:bg-orange-100 file:cursor-pointer transition">
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" 
                    class="px-6 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-sm font-semibold transition flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Simpan Properti Aset</span>
            </button>
            <a href="{{ route('admin.assets.index') }}" 
               class="px-5 py-3 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold transition">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
    let map, marker;
    const latInput = document.getElementById('lat-input');
    const lngInput = document.getElementById('lng-input');

    document.addEventListener('DOMContentLoaded', () => {
        const initialLat = parseFloat(latInput.value) || -6.9932;
        const initialLng = parseFloat(lngInput.value) || 110.4203;

        map = L.map('map-picker').setView([initialLat, initialLng], 13);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', { maxZoom: 19 }).addTo(map);

        marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

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
            inp.addEventListener('input', () => {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);
                if (!isNaN(lat) && !isNaN(lng)) {
                    marker.setLatLng([lat, lng]);
                    map.panTo([lat, lng]);
                }
            });
        });
    });

    // Helper to parse Google Maps Coordinates / URLs
    function applyGmapsInput() {
        const raw = document.getElementById('gmaps-paste-input').value.trim();
        const msg = document.getElementById('paste-msg');
        if (!raw) return;

        let lat = null, lng = null;

        const coordRegex = /(-?\d+\.\d+)[,\s]+(-?\d+\.\d+)/;
        const coordMatch = raw.match(coordRegex);

        const urlCoordRegex = /@(-?\d+\.\d+),(-?\d+\.\d+)/;
        const urlQRegex = /[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/;

        if (raw.match(urlCoordRegex)) {
            const m = raw.match(urlCoordRegex);
            lat = parseFloat(m[1]);
            lng = parseFloat(m[2]);
        } else if (raw.match(urlQRegex)) {
            const m = raw.match(urlQRegex);
            lat = parseFloat(m[1]);
            lng = parseFloat(m[2]);
        } else if (coordMatch) {
            lat = parseFloat(coordMatch[1]);
            lng = parseFloat(coordMatch[2]);
        }

        if (lat !== null && lng !== null && !isNaN(lat) && !isNaN(lng)) {
            latInput.value = lat.toFixed(7);
            lngInput.value = lng.toFixed(7);

            if (marker && map) {
                marker.setLatLng([lat, lng]);
                map.flyTo([lat, lng], 15, { duration: 1.2 });
            }

            msg.classList.remove('hidden');
            setTimeout(() => msg.classList.add('hidden'), 3500);
        } else {
            alert('Format koordinat tidak dikenali. Silakan masukkan format contoh: -6.9553000, 110.4561000 atau link Google Maps.');
        }
    }
</script>
@endpush
