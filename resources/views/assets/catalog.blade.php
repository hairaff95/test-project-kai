<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Katalog Aset — KAI Daop 4 Semarang</title>
    <meta name="description" content="Katalog lengkap aset properti PT KAI Daop 4 Semarang yang tersedia untuk dijual dan disewakan." />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: { extend: {
                colors: {
                    "primary":"#006948","primary-dark":"#005137","primary-light":"#e6f4ee",
                    "background":"#f4f8f5","surface":"#ffffff","on-surface":"#1a201c",
                    "on-surface-variant":"#637369","border-subtle":"#e8eee9",
                },
                fontFamily: { "jakarta":["Plus Jakarta Sans","sans-serif"],"inter":["Inter","sans-serif"] }
            }}
        }
    </script>
    <style>
        body { font-family: "Plus Jakarta Sans", sans-serif; }
        .material-symbols-outlined { font-variation-settings:"FILL" 0,"wght" 400,"GRAD" 0,"opsz" 24; line-height:1; }
        .ms-filled { font-variation-settings:"FILL" 1,"wght" 400,"GRAD" 0,"opsz" 24; }
        .asset-card:hover .card-image { transform: scale(1.04); }
        .card-image { transition: transform 0.4s ease; }
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen overflow-x-hidden">

<x-sidebar />

<main class="pl-4 pr-4 sm:pl-28 sm:pr-6 md:pl-32 md:pr-8 pt-8 pb-16 min-h-screen max-w-[1400px] mx-auto">

    {{-- Header --}}
    <div class="mb-8">
        <p class="text-xs font-semibold uppercase tracking-widest text-primary mb-1">PT Kereta Api Indonesia · Daop 4</p>
        <h1 class="text-2xl md:text-3xl font-bold text-on-surface">Katalog Aset Properti</h1>
        <p class="text-sm text-on-surface-variant mt-1">{{ $assets->count() }} aset tersedia di wilayah Daop 4 Semarang</p>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('assets.catalog') }}" class="flex flex-wrap gap-3 mb-8 bg-white border border-border-subtle rounded-2xl p-4 shadow-sm">
        <div class="flex items-center gap-2 bg-background rounded-full px-4 py-2 flex-1 min-w-[180px] border border-border-subtle">
            <span class="material-symbols-outlined text-on-surface-variant text-xl">search</span>
            <input name="search" value="{{ request('search') }}" placeholder="Cari nama atau lokasi..." type="text"
                class="bg-transparent border-none focus:ring-0 text-sm w-full outline-none placeholder:text-on-surface-variant/60" />
        </div>
        <select name="district" class="bg-background border border-border-subtle rounded-full px-4 py-2 text-sm text-on-surface-variant focus:ring-primary focus:border-primary outline-none">
            <option value="">Semua Wilayah</option>
            @foreach($districts as $d)
            <option value="{{ $d }}" {{ request('district') == $d ? 'selected' : '' }}>{{ $d }}</option>
            @endforeach
        </select>
        <select name="status" class="bg-background border border-border-subtle rounded-full px-4 py-2 text-sm text-on-surface-variant focus:ring-primary focus:border-primary outline-none">
            <option value="">Semua Status</option>
            <option value="available" {{ request('status')=='available'?'selected':'' }}>Tersedia</option>
            <option value="reserved"  {{ request('status')=='reserved' ?'selected':'' }}>Dalam Proses</option>
            <option value="sold"      {{ request('status')=='sold'     ?'selected':'' }}>Terjual</option>
        </select>
        <button type="submit" class="bg-primary text-white rounded-full px-6 py-2 text-sm font-semibold hover:bg-primary-dark transition">Filter</button>
        @if(request()->hasAny(['search','district','status']))
        <a href="{{ route('assets.catalog') }}" class="flex items-center gap-1 text-sm text-on-surface-variant hover:text-primary rounded-full px-4 py-2 border border-border-subtle transition">
            <span class="material-symbols-outlined text-base">close</span> Reset
        </a>
        @endif
    </form>

    {{-- Grid Aset --}}
    @if($assets->isEmpty())
    <div class="text-center py-24 text-on-surface-variant">
        <span class="material-symbols-outlined text-5xl mb-3 block">search_off</span>
        <p class="font-semibold">Tidak ada aset yang cocok dengan filter ini.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($assets as $asset)
        @php
            $isFav = in_array($asset->id, $favoriteIds);
            $statusClr = match($asset->status) {
                'available' => 'bg-emerald-100 text-emerald-700',
                'reserved'  => 'bg-amber-100 text-amber-700',
                'sold'      => 'bg-gray-100 text-gray-500',
                default     => 'bg-gray-100 text-gray-500',
            };
        @endphp
        <article class="asset-card bg-white rounded-2xl border border-border-subtle shadow-sm overflow-hidden hover:shadow-lg transition-shadow duration-300">
            {{-- Image --}}
            <div class="relative h-48 overflow-hidden">
                <img class="card-image w-full h-full object-cover" src="{{ $asset->primary_image_url }}" alt="{{ $asset->name }}" />
                <span class="absolute top-3 left-3 text-[11px] font-bold px-2.5 py-0.5 rounded-full {{ $statusClr }}">
                    {{ $asset->status_label }}
                </span>
                {{-- Favorite button --}}
                <button onclick="toggleFav(this, {{ $asset->id }})"
                    class="favorite-btn absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur flex items-center justify-center hover:scale-110 transition-transform"
                    data-favorited="{{ $isFav ? 'true' : 'false' }}">
                    <span class="material-symbols-outlined text-lg {{ $isFav ? 'ms-filled text-red-500' : 'text-gray-400' }}">favorite</span>
                </button>
            </div>
            {{-- Body --}}
            <div class="p-4">
                <p class="text-[10px] font-bold uppercase tracking-widest text-primary mb-1">{{ $asset->district_area }}</p>
                <h2 class="font-bold text-on-surface text-base leading-snug mb-1">{{ $asset->name }}</h2>
                <p class="text-xs text-on-surface-variant flex items-center gap-1 mb-3">
                    <span class="material-symbols-outlined text-sm">location_on</span>
                    {{ Str::limit($asset->full_address, 55) }}
                </p>
                <div class="flex gap-3 text-xs text-on-surface-variant border-t border-border-subtle pt-3 mb-4">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">domain</span>{{ number_format($asset->land_area,0,',','.') }} m²</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">warehouse</span>{{ number_format($asset->building_area,0,',','.') }} m²</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-bold text-primary text-lg">{{ $asset->price_formatted }}</span>
                    <a href="{{ route('assets.show', $asset->id) }}"
                        class="bg-primary text-white text-xs font-semibold px-4 py-2 rounded-full hover:bg-primary-dark transition flex items-center gap-1">
                        Detail <span class="material-symbols-outlined text-xs">arrow_forward</span>
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    @endif
</main>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function toggleFav(btn, assetId) {
        const icon = btn.querySelector('.material-symbols-outlined');
        const isFav = btn.dataset.favorited === 'true';

        fetch('/favorites/toggle', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ asset_id: assetId })
        })
        .then(r => r.json())
        .then(data => {
            btn.dataset.favorited = data.is_favorited ? 'true' : 'false';
            if (data.is_favorited) {
                icon.classList.add('ms-filled', 'text-red-500');
                icon.classList.remove('text-gray-400');
            } else {
                icon.classList.remove('ms-filled', 'text-red-500');
                icon.classList.add('text-gray-400');
            }
        });
    }
</script>
</body>
</html>
