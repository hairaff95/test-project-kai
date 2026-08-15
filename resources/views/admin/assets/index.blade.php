@extends('layout.app')

@section('title', 'Manajemen Aset — Admin KAI Daop 4')

@section('content')
    <div class="w-full px-6 py-8 pb-32 sm:pb-12 space-y-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">Panel Administrator</span>
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-950 tracking-tight">
                    Kelola Aset Properti
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Inventarisasi aset PT Kereta Api Indonesia (Persero) Daerah Operasi 4 Semarang
                </p>
            </div>

            <a href="{{ route('admin.assets.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs sm:text-sm font-semibold transition self-start sm:self-auto min-h-[44px]">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                <span>Tambah Aset Baru</span>
            </a>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 sm:p-5 rounded-xl bg-white border border-gray-200 space-y-1">
                <div class="flex items-center justify-between text-slate-500">
                    <span class="text-xs font-semibold">Total Aset</span>
                    <i data-lucide="building" class="w-4 h-4 text-primary"></i>
                </div>
                <div class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                <p class="text-[11px] text-gray-400">Terdata di Daop 4</p>
            </div>

            <div class="p-4 sm:p-5 rounded-xl bg-white border border-gray-200 space-y-1">
                <div class="flex items-center justify-between text-slate-500">
                    <span class="text-xs font-semibold">Tersedia</span>
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                </div>
                <div class="text-xl sm:text-2xl font-bold text-emerald-600">{{ $stats['available'] }}</div>
                <p class="text-[11px] text-gray-400">Siap dikerjasamakan</p>
            </div>

            <div class="p-4 sm:p-5 rounded-xl bg-white border border-gray-200 space-y-1">
                <div class="flex items-center justify-between text-slate-500">
                    <span class="text-xs font-semibold">Dalam Proses</span>
                    <i data-lucide="clock" class="w-4 h-4 text-amber-500"></i>
                </div>
                <div class="text-xl sm:text-2xl font-bold text-amber-500">{{ $stats['reserved'] }}</div>
                <p class="text-[11px] text-gray-400">Negosiasi / verifikasi</p>
            </div>

            <div class="p-4 sm:p-5 rounded-xl bg-white border border-gray-200 space-y-1">
                <div class="flex items-center justify-between text-slate-500">
                    <span class="text-xs font-semibold">Terjual</span>
                    <i data-lucide="x-circle" class="w-4 h-4 text-slate-500"></i>
                </div>
                <div class="text-xl sm:text-2xl font-bold text-gray-700">{{ $stats['sold'] ?? ($stats['rented'] ?? 0) }}
                </div>
                <p class="text-[11px] text-gray-400">Aset telah terjual</p>
            </div>
        </div>

        {{-- Filter --}}
        <form method="GET" action="{{ route('admin.assets.index') }}" id="admin-filter-form" class="space-y-4">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama aset, kode, jalan, atau daerah..."
                        class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition min-h-[44px]">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                </div>

                <div class="relative min-w-[180px]" x-data="{ 
                    open: false, 
                    selected: '{{ request('status', '') }}',
                    options: {
                        '': 'Semua Status',
                        'available': 'Tersedia',
                        'reserved': 'Dalam Proses',
                        'sold': 'Terjual'
                    }
                }" @click.outside="open = false">
                    <input type="hidden" name="status" :value="selected">
                    <button type="button" @click="open = !open"
                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 flex items-center justify-between focus:border-primary transition min-h-[44px]">
                        <span x-text="options[selected] || 'Semua Status'" class="font-medium truncate"></span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 shrink-0 transition-transform"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-cloak style="display: none;" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="absolute right-0 top-full mt-1.5 w-full bg-white border border-gray-200 rounded-xl shadow-lg p-1.5 z-50">
                        <template x-for="(label, key) in options" :key="key">
                            <button type="button"
                                @click="selected = key; open = false; $nextTick(() => document.getElementById('admin-filter-form').submit())"
                                :class="selected === key ? 'bg-primary-light text-primary font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left flex items-center justify-between px-3 py-2 rounded-lg text-xs transition">
                                <span x-text="label"></span>
                                <i data-lucide="check" x-show="selected === key" class="w-3.5 h-3.5 text-primary"></i>
                            </button>
                        </template>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-sm font-semibold transition min-h-[44px] shrink-0">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'district']))
                        <a href="{{ route('admin.assets.index') }}"
                            class="px-4 py-2.5 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 text-sm font-medium transition min-h-[44px] shrink-0 flex items-center justify-center"
                            title="Reset Filter">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Assets Container --}}
        <div class="space-y-4 w-full">

            {{-- Desktop Table --}}
            <div class="hidden md:block border-t border-b border-gray-200 bg-white overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead
                        class="bg-gray-50/80 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <tr>
                            <th class="pl-6 pr-4 py-4">Properti</th>
                            <th class="px-5 py-4">Wilayah</th>
                            <th class="px-5 py-4">Spesifikasi (LT / LB)</th>
                            <th class="px-5 py-4">Nilai Penawaran</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="pl-4 pr-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($assets as $asset)
                            <tr class="hover:bg-gray-50/60 transition">

                                {{-- Properti Thumbnail & Name --}}
                                <td class="pl-6 pr-4 py-4.5">
                                    <div class="flex items-center gap-3.5">
                                        <img src="{{ $asset->primary_image_url }}" alt="{{ $asset->name }}"
                                            class="w-12 h-12 rounded-xl object-cover bg-gray-100 border border-gray-200 shrink-0">
                                        <div>
                                            <div class="font-bold text-gray-900 hover:text-primary transition leading-snug">
                                                <a href="{{ route('assets.show', $asset->id) }}">{{ $asset->name }}</a>
                                            </div>
                                            <div class="text-xs text-gray-400 font-mono mt-0.5">{{ $asset->asset_code }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Wilayah --}}
                                <td class="px-5 py-4.5 text-xs font-medium text-gray-700">
                                    {{ $asset->district_area }}
                                </td>

                                {{-- Specs --}}
                                <td class="px-5 py-4.5 text-xs text-gray-700">
                                    <span class="font-bold text-gray-900">{{ number_format($asset->land_area, 0, ',', '.') }}
                                        m²</span>
                                    <span class="text-gray-400">/</span>
                                    <span>{{ number_format($asset->building_area, 0, ',', '.') }} m²</span>
                                </td>

                                {{-- Price --}}
                                <td class="px-5 py-4.5 font-bold text-gray-900 text-xs">
                                    {{ $asset->price_formatted }}
                                </td>

                                {{-- Status Badge --}}
                                <td class="px-5 py-4.5">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold tracking-wide uppercase
                                          {{ $asset->status === 'available' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($asset->status === 'reserved' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-gray-100 text-gray-700 border border-gray-200') }}">
                                        {{ $asset->status_label }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="pl-4 pr-6 py-4.5 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('assets.show', $asset->id) }}"
                                            class="p-2 rounded-lg bg-gray-50 hover:bg-orange-50 text-gray-600 hover:text-primary border border-gray-200 transition"
                                            title="Lihat Halaman Publik">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </a>

                                        <a href="{{ route('admin.assets.edit', $asset) }}"
                                            class="p-2 rounded-lg bg-gray-50 hover:bg-orange-50 text-gray-600 hover:text-primary border border-gray-200 transition"
                                            title="Edit Aset">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>

                                        <form method="POST" action="{{ route('admin.assets.destroy', $asset) }}"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data aset {{ $asset->name }}?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 rounded-lg bg-gray-50 hover:bg-red-50 text-gray-600 hover:text-red-600 border border-gray-200 transition"
                                                title="Hapus Aset">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-gray-300"></i>
                                    <p class="font-semibold text-gray-600 text-sm">Tidak ada aset ditemukan</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Coba sesuaikan kata kunci pencarian atau filter
                                        status.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Flat List (Clean Typography Hierarchy with Generous Padding) --}}
            <div class="md:hidden divide-y divide-gray-200 border-t border-b border-gray-200 bg-white">
                @forelse($assets as $asset)
                    <div class="px-5 sm:px-6 py-5 space-y-3">

                        {{-- Header: Image + Code + Name + Status --}}
                        <div class="flex items-start gap-3">
                            <img src="{{ $asset->primary_image_url }}" alt="{{ $asset->name }}"
                                class="w-14 h-14 rounded-lg object-cover bg-gray-100 border border-gray-200 shrink-0">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-1 mb-0.5">
                                    <span
                                        class="text-[11px] font-mono text-gray-400 uppercase tracking-wider">{{ $asset->asset_code }}</span>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider shrink-0
                                          {{ $asset->status === 'available' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($asset->status === 'reserved' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-gray-100 text-gray-700 border border-gray-200') }}">
                                        {{ $asset->status_label }}
                                    </span>
                                </div>
                                <h3 class="font-bold text-gray-950 text-sm leading-snug">
                                    <a href="{{ route('assets.show', $asset->id) }}" class="hover:text-primary transition">
                                        {{ $asset->name }}
                                    </a>
                                </h3>
                                <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                    <i data-lucide="map-pin" class="w-3 h-3 text-primary shrink-0"></i>
                                    <span class="truncate">{{ $asset->district_area }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- Specs & Price: Pure Typography (No visual box wrapper) --}}
                        <div class="flex items-baseline justify-between text-xs pt-1 border-t border-gray-100">
                            <div>
                                <span class="text-gray-400">Luas: </span>
                                <span class="font-bold text-gray-900">{{ number_format($asset->land_area, 0, ',', '.') }}
                                    m²</span>
                                <span class="text-gray-400 font-normal"> /
                                    {{ number_format($asset->building_area, 0, ',', '.') }} m²</span>
                            </div>
                            <div>
                                <span class="font-bold text-primary text-sm">{{ $asset->price_formatted }}</span>
                            </div>
                        </div>

                        {{-- Action Bar: Spacious & Clean --}}
                        <div class="flex items-center justify-between pt-2">
                            <a href="{{ route('assets.show', $asset->id) }}"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 hover:text-primary transition py-1">
                                <i data-lucide="external-link" class="w-3.5 h-3.5 text-gray-400"></i>
                                <span>Lihat Publik</span>
                            </a>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.assets.edit', $asset) }}"
                                    class="px-3.5 py-1.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold transition inline-flex items-center gap-1.5">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    <span>Edit</span>
                                </a>

                                <form method="POST" action="{{ route('admin.assets.destroy', $asset) }}"
                                    onsubmit="return confirm('Hapus aset {{ $asset->name }}?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-1.5 rounded-lg bg-gray-50 hover:bg-red-50 text-gray-400 hover:text-red-600 border border-gray-200 transition flex items-center justify-center"
                                        title="Hapus Aset">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-400">
                        <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-gray-300"></i>
                        <p class="font-semibold text-gray-600 text-sm">Tidak ada aset ditemukan</p>
                    </div>
                @endforelse
            </div>

        </div>

    </div>
@endsection