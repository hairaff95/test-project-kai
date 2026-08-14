<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manajemen Aset — Admin KAI Daop 4</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />
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
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen">

<x-sidebar />

<main class="pl-4 pr-4 sm:pl-28 sm:pr-6 md:pl-32 md:pr-8 pt-8 pb-16 min-h-screen max-w-[1400px] mx-auto">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-primary mb-1">Panel Admin · KAI Daop 4</p>
            <h1 class="text-2xl md:text-3xl font-bold">Manajemen Aset</h1>
        </div>
        <a href="{{ route('admin.assets.create') }}"
            class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-full font-semibold text-sm hover:bg-primary-dark transition shadow-md">
            <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">add_circle</span>
            Tambah Aset Baru
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-base">check_circle</span>{{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 bg-danger-light border border-red-200 text-danger rounded-xl px-4 py-3 text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-base">error</span>{{ session('error') }}
    </div>
    @endif

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @foreach([['Total Aset','inventory_2',$stats['total'],'bg-primary/10 text-primary'],['Tersedia','check_circle',$stats['available'],'bg-emerald-100 text-emerald-700'],['Dalam Proses','schedule',$stats['reserved'],'bg-amber-100 text-amber-700'],['Terjual','sell',$stats['sold'],'bg-gray-100 text-gray-600']] as [$label,$icon,$count,$colors])
        <div class="bg-white rounded-2xl border border-border-subtle p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl {{ $colors }} flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">{{ $icon }}</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-on-surface">{{ $count }}</p>
                    <p class="text-xs text-on-surface-variant font-medium">{{ $label }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filter & Search --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-5 bg-white border border-border-subtle rounded-2xl p-4 shadow-sm">
        <div class="flex items-center gap-2 bg-background rounded-full px-4 py-2 flex-1 min-w-[180px] border border-border-subtle">
            <span class="material-symbols-outlined text-on-surface-variant text-lg">search</span>
            <input name="search" value="{{ request('search') }}" placeholder="Cari nama atau alamat..." type="text"
                class="bg-transparent border-none focus:ring-0 text-sm w-full outline-none" />
        </div>
        <select name="status" class="bg-background border border-border-subtle rounded-full px-4 py-2 text-sm outline-none">
            <option value="">Semua Status</option>
            <option value="available" {{ request('status')=='available'?'selected':'' }}>Tersedia</option>
            <option value="reserved"  {{ request('status')=='reserved' ?'selected':'' }}>Dalam Proses</option>
            <option value="sold"      {{ request('status')=='sold'     ?'selected':'' }}>Terjual</option>
        </select>
        <button type="submit" class="bg-primary text-white rounded-full px-5 py-2 text-sm font-semibold hover:bg-primary-dark transition">Filter</button>
        @if(request()->hasAny(['search','status']))
        <a href="{{ route('admin.assets.index') }}" class="flex items-center gap-1 text-sm text-on-surface-variant border border-border-subtle rounded-full px-4 py-2 hover:text-primary transition">
            <span class="material-symbols-outlined text-base">close</span> Reset
        </a>
        @endif
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-border-subtle shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-background border-b border-border-subtle">
                    <tr>
                        <th class="text-left px-5 py-3.5 font-semibold text-on-surface-variant text-xs uppercase tracking-wide">Aset</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-on-surface-variant text-xs uppercase tracking-wide hidden md:table-cell">Wilayah</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-on-surface-variant text-xs uppercase tracking-wide hidden lg:table-cell">Luas</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-on-surface-variant text-xs uppercase tracking-wide">Harga</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-on-surface-variant text-xs uppercase tracking-wide">Status</th>
                        <th class="text-right px-5 py-3.5 font-semibold text-on-surface-variant text-xs uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle">
                    @forelse($assets as $asset)
                    @php
                        $sc = match($asset->status) {
                            'available' => 'bg-emerald-100 text-emerald-700',
                            'reserved'  => 'bg-amber-100 text-amber-700',
                            'sold'      => 'bg-gray-100 text-gray-500',
                            default     => 'bg-gray-100 text-gray-500',
                        };
                    @endphp
                    <tr class="hover:bg-background/60 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $asset->primary_image_url }}" alt="" class="w-10 h-10 rounded-xl object-cover" />
                                <div>
                                    <p class="font-semibold text-on-surface leading-tight">{{ $asset->name }}</p>
                                    <p class="text-xs text-on-surface-variant mt-0.5">{{ $asset->asset_code }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-on-surface-variant hidden md:table-cell">{{ $asset->district_area }}</td>
                        <td class="px-4 py-4 text-on-surface-variant hidden lg:table-cell">
                            {{ number_format($asset->land_area,0,',','.') }} m²
                        </td>
                        <td class="px-4 py-4 font-semibold text-primary">{{ $asset->price_formatted }}</td>
                        <td class="px-4 py-4">
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full {{ $sc }}">{{ $asset->status_label }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('assets.show', $asset->id) }}" title="Lihat" class="p-1.5 rounded-lg hover:bg-primary-light text-on-surface-variant hover:text-primary transition">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                                <a href="{{ route('admin.assets.edit', $asset) }}" title="Edit" class="p-1.5 rounded-lg hover:bg-primary-light text-on-surface-variant hover:text-primary transition">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.assets.destroy', $asset) }}"
                                    onsubmit="return confirm('Hapus aset «{{ $asset->name }}»? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus" class="p-1.5 rounded-lg hover:bg-danger-light text-on-surface-variant hover:text-danger transition">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl block mb-2">inventory_2</span>
                            Belum ada aset. <a href="{{ route('admin.assets.create') }}" class="text-primary font-semibold hover:underline">Tambah sekarang.</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>
