@extends('layout.app')

@section('title', $asset->name . ' — Detail Properti KAI Daop 4')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush

@section('content')
<div class="w-full px-6 sm:px-8 lg:px-10 py-8 pb-32 sm:pb-16 space-y-8">

    {{-- Breadcrumb Navigation --}}
    <nav class="flex items-center gap-2 text-xs font-medium text-slate-500">
        <a href="{{ route('assets.index') }}" class="hover:text-gray-900 transition">Beranda</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-gray-400"></i>
        <a href="{{ route('assets.catalog') }}" class="hover:text-gray-900 transition">Katalog Properti</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-gray-400"></i>
        <span class="text-gray-900 font-semibold truncate max-w-xs sm:max-w-md">{{ $asset->name }}</span>
    </nav>

    {{-- Hero Image --}}
    <div class="relative h-72 sm:h-[420px] lg:h-[480px] w-full rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 group">
        
        {{-- Photo --}}
        <img id="main-hero-photo" 
             src="{{ $asset->primary_image_url }}" 
             alt="{{ $asset->name }}" 
             class="w-full h-full object-cover transition-all duration-500">
        
        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent pointer-events-none"></div>

        {{-- Status Badge --}}
        <div class="absolute top-4 left-4 z-10 flex items-center gap-2">
            <div class="bg-white/95 backdrop-blur-md rounded-xl p-1.5 flex items-center gap-2 border border-white/60">
                <div class="w-8 h-8 rounded-lg bg-orange-50 text-primary flex items-center justify-center">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                </div>
                <div class="pr-3 text-left">
                    <span class="text-[10px] font-bold text-gray-400 uppercase block leading-none">Status Aset</span>
                    <span class="text-xs font-bold text-gray-900">{{ $asset->status_label }} · Verified KAI</span>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="absolute top-4 right-4 z-10 flex items-center gap-2">
            {{-- Favorite Button --}}
            <form method="POST" action="{{ route('favorites.toggle') }}" class="inline">
                @csrf
                <input type="hidden" name="asset_id" value="{{ $asset->id }}">
                <button type="submit" 
                        title="{{ $isFavorited ? 'Hapus dari Favorit' : 'Simpan ke Favorit' }}"
                        class="w-10 h-10 rounded-full bg-white/90 backdrop-blur-md hover:bg-white text-gray-700 shadow-md flex items-center justify-center transition hover:scale-105">
                    <i data-lucide="heart" class="w-5 h-5 {{ $isFavorited ? 'text-red-500 fill-red-500' : 'text-gray-600' }}"></i>
                </button>
            </form>

            {{-- Google Maps Button --}}
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $asset->latitude }},{{ $asset->longitude }}" 
               target="_blank"
               title="Petunjuk Arah Google Maps"
               class="w-10 h-10 rounded-full bg-white/90 backdrop-blur-md hover:bg-white text-gray-700 shadow-md flex items-center justify-center transition hover:scale-105">
                <i data-lucide="navigation" class="w-5 h-5 text-primary"></i>
            </a>
        </div>

        {{-- Photo Caption --}}
        <div class="absolute bottom-5 left-5 z-10 max-w-lg">
            <span class="text-[11px] font-bold tracking-wider text-orange-400 uppercase drop-shadow-sm block mb-0.5">
                {{ $asset->district_area }} · Kode {{ $asset->asset_code }}
            </span>
            <h2 id="hero-photo-caption" class="text-xl sm:text-2xl lg:text-3xl font-black text-white tracking-tight drop-shadow-md">
                {{ $asset->images->first()?->caption ?? 'Tampak Utama Properti' }}
            </h2>
        </div>

        {{-- Gallery Button --}}
        <div class="absolute bottom-5 right-5 z-10">
            <button onclick="openGalleryModal()" 
                    class="bg-black/60 hover:bg-black/80 backdrop-blur-md text-white border border-white/20 rounded-2xl px-4 py-2.5 flex items-center gap-2.5 shadow-xl transition group/btn">
                <i data-lucide="image" class="w-4 h-4 text-orange-400 group-hover/btn:scale-110 transition"></i>
                <span class="text-xs font-semibold">Lihat Semua ({{ $asset->images->count() }} Foto)</span>
            </button>
        </div>

    </div>

    {{-- Detail Info & Sidebar --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {{-- Left Column: Info & Specs --}}
        <div class="lg:col-span-8 space-y-6">
            
            {{-- Title & Likes --}}
            <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-2 pb-4 border-b border-gray-200">
                <div class="space-y-1">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-950 tracking-tight">
                        {{ $asset->name }}
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 flex items-center gap-1.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-primary shrink-0"></i>
                        <span>{{ $asset->full_address }}</span>
                    </p>
                </div>

                {{-- Likes Pill --}}
                <div class="flex items-center gap-2 self-start sm:self-auto bg-rose-50 border border-rose-200/80 px-3.5 py-1.5 rounded-[18px] shrink-0 text-rose-600 font-bold text-xs shadow-xs">
                    <i data-lucide="heart" class="w-4 h-4 fill-rose-500 text-rose-500"></i>
                    <span>{{ $asset->favorites_count }} Orang Menyukai</span>
                </div>
            </div>

            {{-- Description --}}
            <div class="space-y-2">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Deskripsi Properti</h3>
                <p class="text-sm sm:text-base text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $asset->description }}
                </p>
            </div>

            {{-- Photo Gallery Thumbnails --}}
            <div class="space-y-3 pt-2">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">
                        Galeri Foto Detail Aset
                    </h3>
                    <span class="text-xs text-slate-500 font-medium">Klik foto untuk pratinjau</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach($asset->images as $index => $img)
                    <div onclick="switchHeroPhoto('{{ $img->url }}', '{{ addslashes($img->caption ?? 'Foto Aset ' . ($index + 1)) }}', this)"
                         class="gallery-thumb group cursor-pointer bg-white rounded-[20px] overflow-hidden border {{ $index === 0 ? 'border-primary ring-2 ring-primary/20' : 'border-gray-200' }} hover:border-primary/60 transition shadow-xs">
                        
                        <div class="relative h-28 sm:h-32 w-full overflow-hidden bg-gray-100">
                            <img src="{{ $img->url }}" alt="{{ $img->caption ?? $asset->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <span class="absolute bottom-1.5 left-1.5 right-1.5 px-2 py-0.5 rounded-[10px] text-[10px] font-semibold bg-black/60 backdrop-blur-xs text-white truncate block">
                                {{ $img->caption ?? 'Foto ' . ($index + 1) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Location Map Section --}}
            <div class="space-y-3 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">
                        Lokasi & Peta GIS (Daop 4 Semarang)
                    </h3>
                    <span class="text-xs font-mono text-slate-500">{{ $asset->latitude }}, {{ $asset->longitude }}</span>
                </div>

                <div class="relative h-64 sm:h-80 w-full rounded-[24px] overflow-hidden border border-gray-200 shadow-sm">
                    <div id="detail-map" class="w-full h-full"></div>
                </div>
            </div>

        </div>

        {{-- Right Column: Sticky Info Panel --}}
        <div class="lg:col-span-4">
            
            <div class="bg-white rounded-[32px] p-6 sm:p-7 border border-gray-200 shadow-sm space-y-6 lg:sticky lg:top-24">
                
                {{-- Header --}}
                <div class="border-b border-gray-100 pb-4">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Informasi Pokok</span>
                    <h2 class="text-base font-bold text-gray-950 mt-0.5">Brief Information</h2>
                    <p class="text-xs text-primary font-semibold mt-1">
                        Pengelola: PT KAI Daop 4 Semarang
                    </p>
                </div>

                {{-- Key Specs --}}
                <div class="grid grid-cols-2 gap-2.5">
                    <div class="p-3 rounded-[20px] bg-gray-50 border border-gray-100 space-y-0.5">
                        <div class="flex items-center gap-1.5 text-slate-500 text-xs">
                            <i data-lucide="maximize" class="w-3.5 h-3.5 text-primary"></i>
                            <span>Luas Tanah</span>
                        </div>
                        <div class="text-xs sm:text-sm font-bold text-gray-900">
                            {{ number_format($asset->land_area, 0, ',', '.') }} m²
                        </div>
                    </div>

                    <div class="p-3 rounded-[20px] bg-gray-50 border border-gray-100 space-y-0.5">
                        <div class="flex items-center gap-1.5 text-slate-500 text-xs">
                            <i data-lucide="home" class="w-3.5 h-3.5 text-primary"></i>
                            <span>Bangunan</span>
                        </div>
                        <div class="text-xs sm:text-sm font-bold text-gray-900">
                            {{ number_format($asset->building_area, 0, ',', '.') }} m²
                        </div>
                    </div>

                    <div class="p-3 rounded-[20px] bg-gray-50 border border-gray-100 space-y-0.5">
                        <div class="flex items-center gap-1.5 text-slate-500 text-xs">
                            <i data-lucide="truck" class="w-3.5 h-3.5 text-primary"></i>
                            <span>Akses Jalan</span>
                        </div>
                        <div class="text-xs sm:text-sm font-bold text-gray-900 truncate">
                            {{ $asset->road_access ?? 'Akses Aspal' }}
                        </div>
                    </div>

                    <div class="p-3 rounded-[20px] bg-gray-50 border border-gray-100 space-y-0.5">
                        <div class="flex items-center gap-1.5 text-slate-500 text-xs">
                            <i data-lucide="zap" class="w-3.5 h-3.5 text-primary"></i>
                            <span>Listrik</span>
                        </div>
                        <div class="text-xs sm:text-sm font-bold text-gray-900 truncate">
                            {{ $asset->electricity ?? 'Tersedia' }}
                        </div>
                    </div>
                </div>

                {{-- Pricing --}}
                <div class="p-4 rounded-[22px] bg-orange-50/60 border border-primary-border space-y-1">
                    <span class="text-[10px] font-bold text-primary uppercase tracking-wider block">Nilai Penawaran Sewa</span>
                    <div class="text-xl sm:text-2xl font-black text-gray-950 tracking-tight">
                        {{ $asset->price_formatted }}
                    </div>
                    <span class="text-[11px] text-slate-500 block">
                        * Bersifat negotiable / dapat dinegosiasikan
                    </span>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-2.5 pt-1">
                    @php
                        $waNumber = $asset->contact_phone ? preg_replace('/[^0-9]/', '', $asset->contact_phone) : '6281234567890';
                        $waText = urlencode("Halo Unit Komersialisasi KAI Daop 4, saya berminat untuk menyewa / mengajukan penawaran aset: " . $asset->name . " (" . $asset->asset_code . ").");
                    @endphp

                    <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank"
                       class="w-full h-12 rounded-[20px] bg-gray-900 hover:bg-black text-white text-xs sm:text-sm font-semibold shadow-md transition flex items-center justify-center gap-2 min-h-[48px]">
                        <i data-lucide="message-circle" class="w-5 h-5 text-emerald-400"></i>
                        <span>Hubungi Kontak WhatsApp</span>
                    </a>

                    <a href="tel:02476541000"
                       class="w-full h-11 rounded-[20px] bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs sm:text-sm font-semibold border border-gray-200 transition flex items-center justify-center gap-2 min-h-[44px]">
                        <i data-lucide="phone" class="w-4 h-4 text-gray-500"></i>
                        <span>Telepon Kantor (024) 7654-1000</span>
                    </a>
                </div>

                {{-- PIC Unit --}}
                <div class="pt-3 border-t border-gray-100 text-xs text-slate-500 flex items-center justify-between">
                    <span>PIC: {{ $asset->contact_person ?? 'Unit Komersialisasi' }}</span>
                    <span class="font-mono">{{ $asset->asset_code }}</span>
                </div>

            </div>

        </div>

    </div>

</div>

{{-- Fullscreen Photo Gallery Modal --}}
<div id="gallery-modal" class="hidden fixed inset-0 z-50 bg-black/90 backdrop-blur-md flex flex-col justify-between p-4 sm:p-8">
    <div class="flex items-center justify-between text-white pb-4 border-b border-white/20">
        <div>
            <h3 class="font-bold text-sm sm:text-base">{{ $asset->name }}</h3>
            <p class="text-xs text-gray-400">Semua Foto Dokumentasi Aset</p>
        </div>
        <button onclick="closeGalleryModal()" class="p-2 rounded-full bg-white/10 hover:bg-white/20 text-white transition">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
    </div>

    <div class="flex-1 flex items-center justify-center my-4 relative">
        <img id="modal-active-img" src="{{ $asset->primary_image_url }}" class="max-h-[65vh] max-w-full rounded-2xl object-contain shadow-2xl">
        <div id="modal-caption" class="absolute bottom-3 bg-black/70 px-4 py-1.5 rounded-full text-white text-xs font-semibold">
            {{ $asset->images->first()?->caption ?? 'Foto Properti' }}
        </div>
    </div>

    <div class="flex gap-2.5 overflow-x-auto pb-2 justify-center">
        @foreach($asset->images as $img)
        <button onclick="document.getElementById('modal-active-img').src = '{{ $img->url }}'; document.getElementById('modal-caption').textContent = '{{ addslashes($img->caption ?? 'Foto Properti') }}'"
                class="w-16 h-12 sm:w-20 sm:h-14 rounded-xl overflow-hidden border border-white/40 hover:border-primary focus:border-primary shrink-0 transition">
            <img src="{{ $img->url }}" class="w-full h-full object-cover">
        </button>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Switch Hero Photo and Caption on Thumbnail Click
    function switchHeroPhoto(url, caption, el) {
        const heroImg = document.getElementById('main-hero-photo');
        const captionEl = document.getElementById('hero-photo-caption');

        if (heroImg) {
            heroImg.style.opacity = '0.5';
            heroImg.src = url;
            setTimeout(() => { heroImg.style.opacity = '1'; }, 150);
        }

        if (captionEl && caption) {
            captionEl.textContent = caption;
        }

        document.querySelectorAll('.gallery-thumb').forEach(t => {
            t.classList.remove('border-primary', 'ring-2', 'ring-primary/20');
            t.classList.add('border-gray-200');
        });
        if (el) {
            el.classList.remove('border-gray-200');
            el.classList.add('border-primary', 'ring-2', 'ring-primary/20');
        }
    }

    function openGalleryModal() {
        document.getElementById('gallery-modal').classList.remove('hidden');
    }

    function closeGalleryModal() {
        document.getElementById('gallery-modal').classList.add('hidden');
    }

    // Initialize Detail Leaflet Map
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();

        const lat = {{ $asset->latitude }};
        const lng = {{ $asset->longitude }};

        const map = L.map('detail-map', { 
            zoomControl: true, 
            attributionControl: true 
        }).setView([lat, lng], 15);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://carto.com/">CARTO</a> | PT KAI Daop 4'
        }).addTo(map);

        const customPin = L.divIcon({
            className: 'custom-leaflet-pin',
            html: `
                <div style="background: #F37021; color: white; width: 38px; height: 38px; border-radius: 50%; border: 3px solid white; box-shadow: 0 4px 14px rgba(243,112,33,0.5); display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
            `,
            iconSize: [38, 38],
            iconAnchor: [19, 38]
        });

        L.marker([lat, lng], { icon: customPin }).addTo(map)
            .bindPopup(`<strong>{{ $asset->name }}</strong><br>{{ $asset->district_area }}`)
            .openPopup();
    });
</script>
@endpush
