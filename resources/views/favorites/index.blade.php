<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Favorit Saya — KAI Daop 4 Semarang</title>
    <meta name="description" content="Daftar aset properti KAI Daop 4 Semarang yang Anda simpan sebagai favorit." />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />
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
        .ms-filled { font-variation-settings:"FILL" 1,"wght" 400,"GRAD" 0,"opsz" 24; }
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen">

<x-sidebar />

<main class="pl-4 pr-4 sm:pl-28 sm:pr-6 md:pl-32 md:pr-8 pt-8 pb-16 min-h-screen max-w-[1200px] mx-auto">

    <div class="mb-8">
        <p class="text-xs font-semibold uppercase tracking-widest text-primary mb-1">Koleksi Saya</p>
        <h1 class="text-2xl md:text-3xl font-bold text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined ms-filled text-red-500 text-3xl">favorite</span>
            Favorit Saya
        </h1>
        <p class="text-sm text-on-surface-variant mt-1">{{ $favorites->count() }} aset tersimpan</p>
    </div>

    @if(session('success'))
    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm">{{ session('success') }}</div>
    @endif

    @if($favorites->isEmpty())
    <div class="text-center py-24 text-on-surface-variant">
        <span class="material-symbols-outlined text-6xl mb-4 block text-gray-300">favorite_border</span>
        <p class="font-semibold text-lg mb-2">Belum ada aset favorit</p>
        <p class="text-sm mb-6">Kunjungi katalog dan klik ikon ❤️ pada aset yang menarik perhatian Anda.</p>
        <a href="{{ route('assets.catalog') }}" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-primary-dark transition">
            <span class="material-symbols-outlined text-base">apartment</span>
            Lihat Katalog
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($favorites as $fav)
        @php $asset = $fav->asset; @endphp
        @if($asset)
        <article class="bg-white rounded-2xl border border-border-subtle shadow-sm overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="relative h-44 overflow-hidden">
                <img class="w-full h-full object-cover" src="{{ $asset->primary_image_url }}" alt="{{ $asset->name }}" />
                {{-- Remove favorite button --}}
                <form method="POST" action="{{ route('favorites.toggle') }}" class="absolute top-3 right-3">
                    @csrf
                    <input type="hidden" name="asset_id" value="{{ $asset->id }}" />
                    <button type="submit" title="Hapus dari favorit"
                        class="w-8 h-8 rounded-full bg-white/80 backdrop-blur flex items-center justify-center hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined ms-filled text-red-500 text-lg">favorite</span>
                    </button>
                </form>
            </div>
            <div class="p-4">
                <p class="text-[10px] font-bold uppercase tracking-widest text-primary mb-1">{{ $asset->district_area }}</p>
                <h2 class="font-bold text-on-surface text-base leading-snug mb-1">{{ $asset->name }}</h2>
                <p class="text-xs text-on-surface-variant flex items-center gap-1 mb-3">
                    <span class="material-symbols-outlined text-sm">location_on</span>
                    {{ Str::limit($asset->full_address, 55) }}
                </p>
                <div class="flex justify-between items-center">
                    <span class="font-bold text-primary text-lg">{{ $asset->price_formatted }}</span>
                    <a href="{{ route('assets.show', $asset->id) }}"
                        class="bg-primary text-white text-xs font-semibold px-4 py-2 rounded-full hover:bg-primary-dark transition flex items-center gap-1">
                        Detail <span class="material-symbols-outlined text-xs">arrow_forward</span>
                    </a>
                </div>
            </div>
        </article>
        @endif
        @endforeach
    </div>
    @endif
</main>
</body>
</html>
