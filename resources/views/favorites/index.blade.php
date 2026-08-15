@extends('layout.app')

@section('title', 'Favorit Saya — KAI Daop 4 Semarang')

@section('content')
<div class="w-full px-6 sm:px-8 lg:px-10 py-8 pb-32 sm:pb-12">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 mb-8 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold uppercase tracking-wider text-primary">Koleksi Tersimpan</span>
            </div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-950 tracking-tight flex items-center gap-2.5">
                <i data-lucide="heart" class="w-6 h-6 text-red-500 fill-rose-500"></i>
                <span>Properti Favorit Saya</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Menyimpan <strong class="text-gray-900 font-semibold">{{ $favorites->count() }}</strong> aset pilihan untuk ditinjau kembali
            </p>
        </div>

        <a href="{{ route('assets.catalog') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-sm font-semibold text-gray-700 transition min-h-[44px] self-start sm:self-auto">
            <i data-lucide="plus" class="w-5 h-5 text-primary"></i>
            <span>Cari Properti Lain</span>
        </a>
    </div>

    {{-- Empty State --}}
    @if($favorites->isEmpty())
    <div class="text-center py-16 sm:py-20 max-w-lg mx-auto">
        <div class="w-14 h-14 rounded-full bg-orange-50 text-primary flex items-center justify-center mx-auto mb-3">
            <i data-lucide="heart" class="w-7 h-7"></i>
        </div>
        <h2 class="font-semibold text-gray-900 text-base sm:text-lg">Belum Ada Properti Favorit</h2>
        <p class="text-xs text-slate-500 mt-1.5 mb-6 flex items-center justify-center gap-1 flex-wrap">
            <span>Klik ikon</span>
            <span class="inline-flex items-center text-red-500 mx-0.5"><i data-lucide="heart" class="w-3.5 h-3.5 fill-red-500"></i></span>
            <span>pada kartu properti di katalog atau peta untuk menyimpannya di sini.</span>
        </p>
        <a href="{{ route('assets.catalog') }}" 
           class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-sm font-semibold transition min-h-[44px]">
            <i data-lucide="building-2" class="w-5 h-5"></i>
            <span>Jelajahi Katalog Aset</span>
        </a>
    </div>
    @else
    {{-- Favorites Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($favorites as $fav)
        @php $asset = $fav->asset; @endphp
        @if($asset)
        <a href="{{ route('assets.show', $asset->id) }}" 
           class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md hover:border-primary/40 transition-all duration-300 flex flex-col justify-between group cursor-pointer">
            <div>
                {{-- Image Container --}}
                <div class="relative h-52 w-full overflow-hidden bg-gray-100">
                    <img src="{{ $asset->primary_image_url }}" 
                         alt="{{ $asset->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

                    <form method="POST" action="{{ route('favorites.toggle') }}" class="absolute top-3 right-3 z-10" onclick="event.stopPropagation()">
                        @csrf
                        <input type="hidden" name="asset_id" value="{{ $asset->id }}">
                        <button type="submit" title="Hapus dari favorit"
                                class="w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm shadow-sm flex items-center justify-center text-red-500 hover:scale-110 transition">
                            <i data-lucide="heart" class="w-4 h-4 fill-red-500"></i>
                        </button>
                    </form>

                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold tracking-wide uppercase shadow-sm
                              {{ $asset->status === 'available' ? 'bg-white text-emerald-700' : ($asset->status === 'reserved' ? 'bg-amber-500 text-white' : 'bg-gray-800 text-white') }}">
                            {{ $asset->status_label }}
                        </span>
                    </div>
                </div>

                {{-- Content Details --}}
                <div class="p-5">
                    <div class="text-xl font-extrabold text-gray-950 tracking-tight mb-1.5">
                        {{ $asset->price_formatted }}
                    </div>

                    <div class="text-xs text-gray-500 font-medium flex items-center gap-2 mb-3">
                        <span>LT: <strong class="text-gray-800">{{ number_format($asset->land_area, 0, ',', '.') }} m²</strong></span>
                        <span>•</span>
                        <span>LB: <strong class="text-gray-800">{{ number_format($asset->building_area, 0, ',', '.') }} m²</strong></span>
                    </div>

                    <h3 class="font-bold text-sm text-gray-900 leading-snug line-clamp-1 mb-1 group-hover:text-primary transition">
                        {{ $asset->name }}
                    </h3>
                    <p class="text-xs text-gray-500 flex items-center gap-1 line-clamp-1">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i>
                        <span>{{ $asset->full_address }}</span>
                    </p>
                </div>
            </div>

            <div class="p-5 pt-0 border-t border-gray-100 mt-4 flex items-center justify-between">
                <span class="text-[11px] font-semibold text-primary uppercase">
                    {{ $asset->district_area }}
                </span>
            </div>

        </a>
        @endif
        @endforeach
    </div>
    @endif

</div>
@endsection
