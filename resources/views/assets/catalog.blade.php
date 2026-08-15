@extends('layout.app')

@section('title', 'Katalog Aset Properti — KAI Daop 4 Semarang')

@push('head')
<meta name="description" content="Katalog lengkap aset properti PT Kereta Api Indonesia (Persero) Daop 4 Semarang yang siap dijual atau disewakan." />
<style>
    .property-card-img {
        transition: transform 0.4s ease;
    }
    .property-card:hover .property-card-img {
        transform: scale(1.03);
    }
</style>
@endpush

@section('content')
<div class="w-full px-6 sm:px-8 lg:px-10 py-8 pb-32 sm:pb-12">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 mb-8 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold uppercase tracking-wider text-primary">PT Kereta Api Indonesia (Persero) · Daop 4</span>
            </div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-950 tracking-tight">
                Katalog Aset Properti
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Jelajahi aset strategis pergudangan, rumah dinas, dan lahan komersial di wilayah Daop 4 Semarang.
            </p>
        </div>

        <a href="{{ route('assets.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs sm:text-sm font-semibold shadow-xs transition self-start sm:self-auto min-h-[44px]">
            <i data-lucide="map" class="w-5 h-5"></i>
            <span>Buka Peta Interaktif</span>
        </a>
    </div>

    {{-- Catalog Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-10 items-start">
        
        {{-- Filters Sidebar --}}
        <aside class="lg:col-span-1 lg:border-r lg:border-gray-200 lg:pr-8 space-y-6 lg:sticky lg:top-24">
            <form method="GET" action="{{ route('assets.catalog') }}" id="filter-form" class="space-y-6">
                
                {{-- Status Filter --}}
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2.5">Status Penawaran</label>
                    <div class="grid grid-cols-3 gap-1 bg-gray-100 p-1 rounded-xl">
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="" class="sr-only peer" {{ !request('status') ? 'checked' : '' }} onchange="this.form.submit()">
                            <div class="py-1.5 text-center text-xs font-semibold rounded-lg text-gray-600 peer-checked:bg-white peer-checked:text-gray-900 peer-checked:shadow-sm transition">
                                Semua
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="available" class="sr-only peer" {{ request('status') === 'available' ? 'checked' : '' }} onchange="this.form.submit()">
                            <div class="py-1.5 text-center text-xs font-semibold rounded-lg text-gray-600 peer-checked:bg-primary peer-checked:text-white peer-checked:shadow-sm transition">
                                Tersedia
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="reserved" class="sr-only peer" {{ request('status') === 'reserved' ? 'checked' : '' }} onchange="this.form.submit()">
                            <div class="py-1.5 text-center text-xs font-semibold rounded-lg text-gray-600 peer-checked:bg-gray-800 peer-checked:text-white peer-checked:shadow-sm transition">
                                Proses
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Keyword Search --}}
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Cari Kata Kunci</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Nama aset, jalan, daerah..." 
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-3 py-2 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    </div>
                </div>

                {{-- District Filter --}}
                <div class="relative" x-data="{ 
                    open: false, 
                    selected: '{{ request('district', '') }}'
                }" @click.outside="open = false">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Wilayah / Daerah</label>
                    <input type="hidden" name="district" :value="selected">

                    <button type="button" @click="open = !open" 
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-800 flex items-center justify-between focus:bg-white focus:border-primary transition">
                        <div class="flex items-center gap-2 truncate">
                            <i data-lucide="map-pin" class="w-4 h-4 text-primary shrink-0"></i>
                            <span x-text="selected ? selected : 'Semua Wilayah'" class="font-medium text-xs sm:text-sm truncate">
                                {{ request('district') ?: 'Semua Wilayah' }}
                            </span>
                        </div>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-gray-400 shrink-0 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" 
                         x-cloak
                         style="display: none;"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute top-full left-0 right-0 mt-1.5 bg-white border border-gray-200 rounded-2xl shadow-xl p-1.5 z-50 max-h-60 overflow-y-auto">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-3 py-1.5">DAERAH OPERASI 4</p>
                        
                        <button type="button" 
                                @click="selected = ''; open = false; $nextTick(() => document.getElementById('filter-form').submit())"
                                :class="selected === '' ? 'bg-primary-light text-primary font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-xl text-xs transition">
                            <i data-lucide="map" class="w-3.5 h-3.5 text-gray-400"></i>
                            <span>Semua Wilayah</span>
                        </button>

                        @foreach($districts as $d)
                        <button type="button" 
                                @click="selected = '{{ addslashes($d) }}'; open = false; $nextTick(() => document.getElementById('filter-form').submit())"
                                :class="selected === '{{ addslashes($d) }}' ? 'bg-primary-light text-primary font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-xl text-xs transition">
                            <i data-lucide="map-pin" :class="selected === '{{ addslashes($d) }}' ? 'text-primary' : 'text-gray-400'" class="w-3.5 h-3.5"></i>
                            <span>{{ $d }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Property Type Filter --}}
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-3">Tipe Properti</label>
                    <div class="space-y-2.5">
                        @php
                            $types = [
                                'gudang' => 'Gudang Logistik',
                                'rumah'  => 'Rumah Dinas',
                                'lahan'  => 'Lahan Komersial',
                                'kantor' => 'Gedung / Kantor'
                            ];
                        @endphp
                        @foreach($types as $key => $label)
                        <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer hover:text-gray-900 select-none">
                            <input type="checkbox" name="type[]" value="{{ $key }}" 
                                   {{ in_array($key, (array) request('type', [])) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded text-primary focus:ring-primary border-gray-300">
                            <span>{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Filter Actions --}}
                <div class="pt-2 flex flex-col gap-2">
                    <button type="submit" 
                            class="w-full py-2.5 px-4 rounded-xl bg-primary hover:bg-primary-hover text-white text-sm font-semibold shadow-sm transition flex items-center justify-center gap-2">
                        <i data-lucide="filter" class="w-4 h-4"></i>
                        <span>Terapkan Filter</span>
                    </button>

                    @if(request()->hasAny(['search', 'district', 'status', 'type']))
                    <a href="{{ route('assets.catalog') }}" 
                       class="w-full py-2 px-4 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium text-center transition">
                        Reset Semua Filter
                    </a>
                    @endif
                </div>

            </form>
        </aside>

        {{-- Property List Area --}}
        <div class="lg:col-span-3 space-y-6" x-data="{ viewMode: 'grid' }">

            {{-- Toolbar --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-200">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Semua Aset Tersedia</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Menampilkan <span class="font-semibold text-gray-900">{{ $assets->count() }}</span> properti KAI Daop 4</p>
                </div>

                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <div class="text-xs text-gray-500 font-medium">Urutkan:</div>
                    
                    {{-- Sort Dropdown --}}
                    <div class="relative" x-data="{ 
                        open: false, 
                        selected: '{{ request('sort', 'latest') }}',
                        options: {
                            'latest':     { label: 'Terbaru', icon: 'sparkles' },
                            'price_asc':  { label: 'Harga Terendah', icon: 'trending-down' },
                            'price_desc': { label: 'Harga Tertinggi', icon: 'trending-up' },
                            'land_desc':  { label: 'Luas Terbesar', icon: 'maximize-2' }
                        }
                    }" @click.outside="open = false">
                        <button type="button" @click="open = !open" 
                                class="bg-gray-100 hover:bg-gray-200/80 px-3 py-1.5 rounded-xl text-xs font-semibold text-gray-900 flex items-center gap-1.5 transition">
                            <i :data-lucide="options[selected] ? options[selected].icon : 'sparkles'" class="w-3.5 h-3.5 text-primary"></i>
                            <span x-text="options[selected] ? options[selected].label : 'Terbaru'">
                                {{ request('sort') === 'price_asc' ? 'Harga Terendah' : (request('sort') === 'price_desc' ? 'Harga Tertinggi' : (request('sort') === 'land_desc' ? 'Luas Terbesar' : 'Terbaru')) }}
                            </span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="open" 
                             x-cloak
                             style="display: none;"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 top-full mt-1.5 w-44 bg-white border border-gray-200 rounded-2xl shadow-xl p-1.5 z-50">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-3 py-1.5">URUTKAN ASET</p>
                            <template x-for="(opt, key) in options" :key="key">
                                <button type="button" 
                                        @click="selected = key; open = false; $nextTick(() => { 
                                            const url = new URL(window.location.href);
                                            url.searchParams.set('sort', key);
                                            window.location.href = url.toString();
                                        })"
                                        :class="selected === key ? 'bg-primary-light text-primary font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                        class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-xl text-xs transition">
                                    <i :data-lucide="opt.icon" :class="selected === key ? 'text-primary' : 'text-gray-400'" class="w-3.5 h-3.5"></i>
                                    <span x-text="opt.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="h-4 w-px bg-gray-200"></div>
                    
                    {{-- View Mode Toggle --}}
                    <div class="flex items-center gap-1 bg-gray-100 p-0.5 rounded-xl">
                        {{-- Mode List --}}
                        <button type="button" 
                                @click="viewMode = 'list'; $nextTick(() => lucide.createIcons())" 
                                :class="viewMode === 'list' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-gray-700'"
                                class="p-1.5 rounded-lg transition" title="Tampilan List">
                            <i data-lucide="layout-list" class="w-4 h-4"></i>
                        </button>

                        {{-- Mode Grid --}}
                        <button type="button" 
                                @click="viewMode = 'grid'; $nextTick(() => lucide.createIcons())" 
                                :class="viewMode === 'grid' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-gray-700'"
                                class="p-1.5 rounded-lg transition" title="Tampilan Grid">
                            <i data-lucide="layout-grid" class="w-4 h-4"></i>
                        </button>

                        {{-- Mode Map --}}
                        <a href="{{ route('assets.index') }}" 
                           class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 transition" title="Buka di Peta">
                            <i data-lucide="map" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Empty State --}}
            @if($assets->isEmpty())
            <div class="text-center py-20 bg-white border border-gray-200 rounded-2xl p-8">
                <div class="w-12 h-12 rounded-full bg-orange-50 text-primary flex items-center justify-center mx-auto mb-3">
                    <i data-lucide="building-2" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Tidak Ada Properti Ditemukan</h3>
                <p class="text-xs text-gray-500 max-w-sm mx-auto mt-1">Coba sesuaikan kata kunci pencarian atau reset filter untuk melihat katalog lengkap.</p>
                <a href="{{ route('assets.catalog') }}" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-primary text-white text-xs font-semibold hover:bg-primary-hover transition">
                    Reset Filter
                </a>
            </div>
            @else

            {{-- List View --}}
            <div x-show="viewMode === 'list'" x-cloak class="space-y-4">
                @foreach($assets as $asset)
                @php
                    $isFav = in_array($asset->id, $favoriteIds);
                @endphp
                <a href="{{ route('assets.show', $asset->id) }}" 
                   class="property-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md hover:border-primary/40 transition-all duration-300 flex flex-col sm:flex-row group cursor-pointer">
                    
                    {{-- Left Image --}}
                    <div class="relative w-full sm:w-72 h-52 sm:h-auto shrink-0 bg-gray-100 overflow-hidden">
                        <img src="{{ $asset->primary_image_url }}" 
                             alt="{{ $asset->name }}" 
                             class="property-card-img w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold tracking-wide uppercase shadow-sm
                                  {{ $asset->status === 'available' ? 'bg-white text-emerald-700' : ($asset->status === 'reserved' ? 'bg-amber-500 text-white' : 'bg-gray-800 text-white') }}">
                                {{ $asset->status_label }}
                            </span>
                        </div>

                        <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); toggleFavorite(this, {{ $asset->id }})" 
                                data-favorited="{{ $isFav ? 'true' : 'false' }}"
                                class="fav-btn absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm shadow-sm flex items-center justify-center text-gray-400 hover:text-red-500 hover:scale-110 transition z-10">
                            <i data-lucide="heart" class="w-4 h-4 {{ $isFav ? 'text-red-500 fill-red-500' : '' }}"></i>
                        </button>
                    </div>

                    {{-- Right Content: Description & Specs --}}
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <span class="text-xs font-bold text-primary uppercase tracking-wider">
                                    {{ $asset->district_area }} • {{ $asset->asset_code }}
                                </span>
                                <div class="text-lg sm:text-xl font-extrabold text-gray-950 tracking-tight">
                                    {{ $asset->price_formatted }}
                                </div>
                            </div>

                            <h3 class="font-bold text-base text-gray-900 leading-snug mb-1 group-hover:text-primary transition">
                                {{ $asset->name }}
                            </h3>

                            <p class="text-xs text-gray-500 flex items-center gap-1 mb-3">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i>
                                <span>{{ $asset->full_address }}</span>
                            </p>

                            @if($asset->description)
                            <p class="text-xs text-gray-600 line-clamp-2 mb-4 leading-relaxed">
                                {{ $asset->description }}
                            </p>
                            @endif

                            {{-- Technical Specs Grid --}}
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-gray-600 bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="maximize" class="w-3.5 h-3.5 text-primary"></i>
                                    <span>LT: <strong>{{ number_format($asset->land_area, 0, ',', '.') }} m²</strong></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="home" class="w-3.5 h-3.5 text-primary"></i>
                                    <span>LB: <strong>{{ number_format($asset->building_area, 0, ',', '.') }} m²</strong></span>
                                </div>
                                @if($asset->road_access)
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="truck" class="w-3.5 h-3.5 text-primary"></i>
                                    <span>{{ $asset->road_access }}</span>
                                </div>
                                @endif
                                @if($asset->electricity)
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="zap" class="w-3.5 h-3.5 text-primary"></i>
                                    <span>{{ $asset->electricity }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 pt-3.5 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-400">
                                PIC: {{ $asset->contact_person ?? 'Unit Komersialisasi' }}
                            </span>
                            <span class="text-[11px] font-semibold text-primary uppercase tracking-wider">
                                {{ $asset->district_area }}
                            </span>
                        </div>
                    </div>

                </a>
                @endforeach
            </div>

            {{-- 2. GRID VIEW (Gambar di atas, Info Harga & Detail di bawah) --}}
            <div x-show="viewMode === 'grid'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($assets as $asset)
                @php
                    $isFav = in_array($asset->id, $favoriteIds);
                @endphp
                <a href="{{ route('assets.show', $asset->id) }}" 
                   class="property-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md hover:border-primary/40 transition-all duration-300 flex flex-col group cursor-pointer">
                    
                    {{-- Image Container --}}
                    <div class="relative h-56 w-full overflow-hidden bg-gray-100">
                        <img src="{{ $asset->primary_image_url }}" 
                             alt="{{ $asset->name }}" 
                             class="property-card-img w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        
                        {{-- Status Badge --}}
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold tracking-wide uppercase shadow-sm
                                  {{ $asset->status === 'available' ? 'bg-white text-emerald-700' : ($asset->status === 'reserved' ? 'bg-amber-500 text-white' : 'bg-gray-800 text-white') }}">
                                {{ $asset->status_label }}
                            </span>
                        </div>

                        {{-- Favorite Button --}}
                        <button type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); toggleFavorite(this, {{ $asset->id }})" 
                                data-favorited="{{ $isFav ? 'true' : 'false' }}"
                                class="fav-btn absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm shadow-sm flex items-center justify-center text-gray-400 hover:text-red-500 hover:scale-110 transition z-10">
                            <i data-lucide="heart" class="w-4 h-4 {{ $isFav ? 'text-red-500 fill-red-500' : '' }}"></i>
                        </button>
                    </div>

                    {{-- Card Details --}}
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            {{-- Price & Favorite Indicator --}}
                            <div class="flex items-baseline justify-between mb-1.5">
                                <div class="text-xl font-extrabold text-gray-950 tracking-tight">
                                    {{ $asset->price_formatted }}
                                </div>
                            </div>

                            {{-- Specs: Land area, Building area, Access --}}
                            <div class="text-xs text-gray-500 font-medium flex items-center gap-2 mb-3">
                                <span>LT: <strong class="text-gray-800 font-semibold">{{ number_format($asset->land_area, 0, ',', '.') }} m²</strong></span>
                                <span>•</span>
                                <span>LB: <strong class="text-gray-800 font-semibold">{{ number_format($asset->building_area, 0, ',', '.') }} m²</strong></span>
                                @if($asset->road_access)
                                <span>•</span>
                                <span class="truncate max-w-[80px]">{{ $asset->road_access }}</span>
                                @endif
                            </div>

                            {{-- Title & Address --}}
                            <h3 class="font-bold text-sm text-gray-900 leading-snug line-clamp-1 mb-1 group-hover:text-primary transition">
                                {{ $asset->name }}
                            </h3>
                            <p class="text-xs text-gray-500 flex items-center gap-1 line-clamp-1">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i>
                                <span>{{ $asset->full_address }}</span>
                            </p>
                        </div>

                        {{-- Footer Info --}}
                        <div class="mt-4 pt-3.5 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-[11px] font-semibold text-primary uppercase tracking-wider">
                                {{ $asset->district_area }}
                            </span>
                        </div>

                    </div>

                </a>
                @endforeach
            </div>
            @endif

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    // AJAX Toggle Favorite
    function toggleFavorite(btn, assetId) {
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const icon = btn.querySelector('svg') || btn.querySelector('i');

        fetch('{{ route("favorites.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ asset_id: assetId })
        })
        .then(res => res.json())
        .then(data => {
            btn.dataset.favorited = data.is_favorited ? 'true' : 'false';
            if (data.is_favorited) {
                icon.classList.add('text-red-500', 'fill-red-500');
            } else {
                icon.classList.remove('text-red-500', 'fill-red-500');
            }
        })
        .catch(err => console.error(err));
    }
</script>
@endpush
