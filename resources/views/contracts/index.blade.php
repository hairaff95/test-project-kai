<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Kontrak — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-[#F6F7F9] font-sans antialiased text-gray-900 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between">

    {{-- Top Navbar --}}
    <x-navbar active="contracts" />

    {{-- Main Content --}}
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-6 pb-24 lg:pb-8 flex flex-col gap-4 sm:gap-5">

        {{-- Page Header: Title & Action Buttons --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0">
            <h1 class="text-2xl sm:text-[30px] font-bold tracking-tight text-gray-950">
                Daftar Kontrak
            </h1>

            <div class="flex items-center gap-2 self-start sm:self-auto">
                {{-- Terapkan Filter --}}
                <button id="btn-apply-filter" type="button" style="background-color: #0066FF;" class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:opacity-95 transition cursor-pointer">
                    <x-icon name="filter" class="w-4 h-4 text-white" />
                    <span>Terapkan Filter</span>
                </button>

                {{-- Reset Filter --}}
                <a href="{{ route('contracts.index') }}" class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 shadow-xs transition cursor-pointer" title="Reset Filter">
                    <x-icon name="refresh" class="w-4.5 h-4.5 text-gray-600" />
                </a>
            </div>
        </div>

        {{-- Filter Form --}}
        <form id="filter-form" method="GET" action="{{ route('contracts.index') }}">
            <div class="rounded-2xl sm:rounded-3xl bg-white p-3.5 sm:p-4 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90">
                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">

                    {{-- Search --}}
                    <div class="relative flex-1 min-w-[200px] sm:min-w-[260px]">
                        <x-icon name="search" class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input
                            type="text"
                            name="search"
                            id="input-search"
                            value="{{ request('search') }}"
                            placeholder="Cari no. kontrak, nama, brand, aset..."
                            class="w-full pl-10 pr-3.5 py-2 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#0066FF] text-gray-800 placeholder-gray-400 transition"
                        >
                    </div>

                    {{-- Filter Jenis Aset --}}
                    <div class="relative">
                        <select name="jenis_asset" id="filter-jenis-asset" class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition min-w-[150px]">
                            <option value="">Semua Jenis Aset</option>
                            @foreach($jenisAssetOptions as $opt)
                                <option value="{{ $opt }}" {{ request('jenis_asset') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                    </div>

                    {{-- Filter Status Customer --}}
                    <div class="relative">
                        <select name="status_customer" id="filter-status" class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition min-w-[160px]">
                            <option value="">Semua Status Customer</option>
                            @foreach($statusCustomerOptions as $opt)
                                <option value="{{ $opt }}" {{ request('status_customer') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                    </div>

                    {{-- Filter Harga --}}
                    <div class="relative">
                        <select name="harga" id="filter-harga" class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition min-w-[190px]">
                            <option value="">Semua Harga</option>
                            <option value="lt_5jt"   {{ request('harga') === 'lt_5jt'   ? 'selected' : '' }}>Harga &lt; Rp 5.000.000</option>
                            <option value="gt_5jt"   {{ request('harga') === 'gt_5jt'   ? 'selected' : '' }}>Harga &gt; Rp 5.000.000</option>
                            <option value="gt_50jt"  {{ request('harga') === 'gt_50jt'  ? 'selected' : '' }}>Harga &gt; Rp 50.000.000</option>
                            <option value="gt_100jt" {{ request('harga') === 'gt_100jt' ? 'selected' : '' }}>Harga &gt; Rp 100.000.000</option>
                            <option value="gt_500jt" {{ request('harga') === 'gt_500jt' ? 'selected' : '' }}>Harga &gt; Rp 500.000.000</option>
                            <option value="gt_1m"    {{ request('harga') === 'gt_1m'    ? 'selected' : '' }}>Harga &gt; Rp 1.000.000.000</option>
                        </select>
                        <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                    </div>

                    {{-- Filter Waktu --}}
                    <div class="relative">
                        <select name="waktu" id="filter-waktu" class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition min-w-[180px]">
                            <option value="">Semua Waktu</option>
                            <option value="1bulan"  {{ request('waktu') === '1bulan'  ? 'selected' : '' }}>1 Bulan Terakhir</option>
                            <option value="3bulan"  {{ request('waktu') === '3bulan'  ? 'selected' : '' }}>3 Bulan Terakhir</option>
                            <option value="6bulan"  {{ request('waktu') === '6bulan'  ? 'selected' : '' }}>6 Bulan Terakhir</option>
                            <option value="1tahun"  {{ request('waktu') === '1tahun'  ? 'selected' : '' }}>1 Tahun Terakhir</option>
                        </select>
                        <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                    </div>

                </div>
            </div>
        </form>

        {{-- Table Container --}}
        <div class="rounded-2xl sm:rounded-3xl bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 overflow-hidden flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">No. Kontrak</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Waktu Kontrak</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Nama Penyewa</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Brand</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Nama Blok Aset</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Jenis Aset</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Awal Kontrak</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Selesai Kontrak</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Harga</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Status Customer</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-[13px] text-gray-700">
                        @forelse($contracts as $item)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="py-3.5 px-4 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $item->contract_number }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                    {{ $item->contract_date?->format('d-m-Y') ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-700 font-medium whitespace-nowrap">
                                    {{ $item->tenant?->fullname ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                    {{ $item->tenant?->brand ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 font-normal max-w-[180px] leading-snug text-justify">
                                    {{ $item->asset?->asset_block_name ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                    {{ $item->asset?->jenis_asset ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                    {{ $item->start_datetime?->format('d-m-Y') ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                    {{ $item->end_datetime_baru?->format('d-m-Y') ?? $item->end_datetime?->format('d-m-Y') ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-900 font-semibold whitespace-nowrap">
                                    {{ $item->price_formatted }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @php
                                        $status = $item->tenant?->status_customer;
                                        $statusColor = match($status) {
                                            'Aktif'       => 'bg-blue-50 text-blue-700',
                                            'Tidak Aktif' => 'bg-red-50 text-red-600',
                                            default       => 'bg-gray-100 text-gray-500',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $statusColor }}">
                                        {{ $status ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                    <div class="relative inline-block text-left action-menu-wrapper"
                                         data-asset="{{ $item->asset_number }}">
                                        <button
                                            type="button"
                                            class="action-menu-btn flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition cursor-pointer"
                                            title="Aksi"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="5" r="1.5"/>
                                                <circle cx="12" cy="12" r="1.5"/>
                                                <circle cx="12" cy="19" r="1.5"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-8 text-gray-400">
                                    Tidak ada data kontrak yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    {{-- Global dropdown — di luar tabel, pakai position fixed agar tidak terpotong overflow --}}
    <div id="global-action-dropdown" class="hidden fixed z-[9999] w-40 rounded-xl bg-white border border-gray-200 shadow-lg py-1">
        <a id="dd-lihat" href="#" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
            <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke-width="2"/></svg>
            <span>Lihat</span>
        </a>
        <a id="dd-edit" href="#" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition">
            <svg class="w-4 h-4 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M11 4H4C3.47 4 2.96 4.21 2.59 4.59C2.21 4.96 2 5.47 2 6V20C2 20.53 2.21 21.04 2.59 21.41C2.96 21.79 3.47 22 4 22H18C18.53 22 19.04 21.79 19.41 21.41C19.79 21.04 20 20.53 20 20V13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5C18.9 2.1 19.44 1.88 20 1.88C20.56 1.88 21.1 2.1 21.5 2.5C21.9 2.9 22.12 3.44 22.12 4C22.12 4.56 21.9 5.1 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span class="text-blue-600 font-medium">Edit</span>
        </a>
        <form id="dd-delete-form" method="POST" onsubmit="return confirm('Hapus aset ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="flex w-full items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-red-50 transition">
                <svg class="w-4 h-4 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="3 6 5 6 21 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 6V4h6v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="text-red-500">Hapus</span>
            </button>
        </form>
    </div>

    <script>
        // Tombol Terapkan Filter — submit form filter
        document.getElementById('btn-apply-filter').addEventListener('click', function () {
            document.getElementById('filter-form').submit();
        });

        (function () {
            const dropdown   = document.getElementById('global-action-dropdown');
            const ddLihat    = document.getElementById('dd-lihat');
            const ddEdit     = document.getElementById('dd-edit');
            const ddDeleteForm = document.getElementById('dd-delete-form');

            // Routes dari Blade — dirender server-side
            const routes = {
                detail: (id) => `/asset/${id}`,
                edit:   (id) => `/admin/assets/${id}/edit`,
                delete: (id) => `/admin/assets/${id}`,
            };

            // Override routes dengan nilai dari Blade jika tersedia
            @foreach($contracts as $item)
            routes['detail_{{ $item->asset_number }}'] = '{{ route('asset.detail', $item->asset_number) }}';
            routes['edit_{{ $item->asset_number }}']   = '{{ route('admin.assets.edit', $item->asset_number) }}';
            routes['delete_{{ $item->asset_number }}'] = '{{ route('admin.assets.destroy', $item->asset_number) }}';
            @endforeach

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.action-menu-btn');

                if (btn) {
                    e.stopPropagation();

                    const wrapper    = btn.closest('.action-menu-wrapper');
                    const assetId    = wrapper.dataset.asset;
                    const rect       = btn.getBoundingClientRect();
                    const dropW      = 160;

                    // Rata kanan dengan tombol, geser ke atas layar jika terlalu bawah
                    let left = rect.right - dropW;
                    let top  = rect.bottom + 4;

                    // Isi href & action sesuai baris
                    ddLihat.href          = routes[`detail_${assetId}`];
                    ddEdit.href           = routes[`edit_${assetId}`];
                    ddDeleteForm.action   = routes[`delete_${assetId}`];

                    // Jika dropdown sedang terbuka di baris yang sama, tutup
                    if (!dropdown.classList.contains('hidden') && dropdown.dataset.open === assetId) {
                        dropdown.classList.add('hidden');
                        dropdown.dataset.open = '';
                        return;
                    }

                    dropdown.style.top    = top + 'px';
                    dropdown.style.left   = left + 'px';
                    dropdown.dataset.open = assetId;
                    dropdown.classList.remove('hidden');
                } else if (!e.target.closest('#global-action-dropdown')) {
                    dropdown.classList.add('hidden');
                    dropdown.dataset.open = '';
                }
            });

            // Tutup dropdown saat scroll
            document.addEventListener('scroll', function () {
                dropdown.classList.add('hidden');
                dropdown.dataset.open = '';
            }, true);
        })();
    </script>

</body>

</html>
