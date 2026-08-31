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
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-6 pb-28 lg:pb-8 flex flex-col gap-4 sm:gap-5">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0">
            <h1 class="text-xl sm:text-[30px] font-bold tracking-tight text-gray-950">
                Daftar Kontrak
            </h1>

            {{-- Header Action Buttons --}}
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <button id="btn-filter-contracts" type="button" class="flex items-center gap-1.5 sm:gap-2 rounded-lg lg:rounded-[10px] bg-[#0066FF] hover:bg-blue-700 px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow-xs transition cursor-pointer">
                    <x-icon name="filter-icon" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" />
                    <span>Filter</span>
                </button>

                <a href="{{ route('contracts.index') }}" class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-lg lg:rounded-[10px] border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 shadow-xs transition cursor-pointer" title="Reset">
                    <x-icon name="refresh" class="w-4 h-4 sm:w-4.5 sm:h-4.5 text-gray-600" />
                </a>
            </div>
        </div>

        {{-- Satu Kesatuan Card: Filter Bar + Tabel Berstroke --}}
        <div class="rounded-3xl bg-white p-3 sm:p-5 shadow-[0_2px_12px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col gap-2.5 sm:gap-4">

            {{-- Filter Bar Form --}}
            <form id="filter-form" method="GET" action="{{ route('contracts.index') }}" class="flex flex-wrap items-center gap-1.5 sm:gap-2.5">

                {{-- Search No Kontrak --}}
                <div class="relative w-full sm:w-[185px] h-[32px] sm:h-[38px]">
                    <x-icon name="search" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 absolute left-2.5 sm:left-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                    <input
                        type="text"
                        name="search"
                        id="input-search"
                        value="{{ request('search') }}"
                        placeholder="Search No Kontrak"
                        class="w-full h-full pl-8 sm:pl-9 pr-3 py-1 text-xs sm:text-sm bg-white border border-gray-200 rounded-lg lg:rounded-[10px] focus:outline-none focus:border-[#0066FF] text-gray-700 placeholder-gray-400 transition"
                    >
                </div>

                {{-- Hidden Inputs for form submit --}}
                <input type="hidden" name="jenis_asset" id="input-jenis-asset" value="{{ request('jenis_asset') }}">
                <input type="hidden" name="status_customer" id="input-status-customer" value="{{ request('status_customer') }}">
                <input type="hidden" name="harga" id="input-harga" value="{{ request('harga') }}">
                <input type="hidden" name="waktu" id="input-waktu" value="{{ request('waktu') }}">

                {{-- Filter Jenis Aset --}}
                <div class="relative custom-filter-container">
                    <button type="button" class="filter-dropdown-btn inline-flex items-center h-[30px] sm:h-[38px] bg-white border border-gray-200 hover:border-gray-300 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3 py-1 transition cursor-pointer">
                        <span class="{{ request('jenis_asset') ? 'text-gray-800 font-semibold' : 'text-gray-400 font-normal' }} text-[11px] sm:text-xs select-none">
                            {{ request('jenis_asset') ?: 'Jenis Aset' }}
                        </span>
                        <x-icon name="chevron-down" class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 ml-1 pointer-events-none" />
                    </button>
                    <div class="filter-dropdown-menu hidden absolute left-0 top-full mt-1 z-[100] min-w-[160px] max-h-[220px] overflow-y-auto rounded-lg lg:rounded-[10px] bg-white border border-gray-100 shadow-[0_10px_35px_rgba(0,0,0,0.14)] p-1.5 flex flex-col gap-0.5">
                        <button type="button" onclick="selectFilterOption('jenis_asset', '')" class="flex items-center justify-between w-full px-2.5 py-1.5 text-[11px] sm:text-xs font-semibold {{ !request('jenis_asset') ? 'bg-blue-50 text-[#0066FF]' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg lg:rounded-[10px] transition text-left cursor-pointer">
                            <span>Semua Jenis Aset</span>
                        </button>
                        @foreach($jenisAssetOptions as $opt)
                            <button type="button" onclick="selectFilterOption('jenis_asset', '{{ $opt }}')" class="flex items-center justify-between w-full px-2.5 py-1.5 text-[11px] sm:text-xs font-semibold {{ request('jenis_asset') === $opt ? 'bg-blue-50 text-[#0066FF]' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg lg:rounded-[10px] transition text-left cursor-pointer">
                                <span>{{ $opt }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Filter Status Customer --}}
                <div class="relative custom-filter-container">
                    <button type="button" class="filter-dropdown-btn inline-flex items-center h-[30px] sm:h-[38px] bg-white border border-gray-200 hover:border-gray-300 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3 py-1 transition cursor-pointer">
                        <span class="{{ request('status_customer') ? 'text-gray-800 font-semibold' : 'text-gray-400 font-normal' }} text-[11px] sm:text-xs select-none">
                            {{ request('status_customer') ?: 'Status Customer' }}
                        </span>
                        <x-icon name="chevron-down" class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 ml-1 pointer-events-none" />
                    </button>
                    <div class="filter-dropdown-menu hidden absolute left-0 top-full mt-1 z-[100] min-w-[160px] max-h-[220px] overflow-y-auto rounded-lg lg:rounded-[10px] bg-white border border-gray-100 shadow-[0_10px_35px_rgba(0,0,0,0.14)] p-1.5 flex flex-col gap-0.5">
                        <button type="button" onclick="selectFilterOption('status_customer', '')" class="flex items-center justify-between w-full px-2.5 py-1.5 text-[11px] sm:text-xs font-semibold {{ !request('status_customer') ? 'bg-blue-50 text-[#0066FF]' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg lg:rounded-[10px] transition text-left cursor-pointer">
                            <span>Semua Status</span>
                        </button>
                        @foreach($statusCustomerOptions as $opt)
                            <button type="button" onclick="selectFilterOption('status_customer', '{{ $opt }}')" class="flex items-center justify-between w-full px-2.5 py-1.5 text-[11px] sm:text-xs font-semibold {{ request('status_customer') === $opt ? 'bg-blue-50 text-[#0066FF]' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg lg:rounded-[10px] transition text-left cursor-pointer">
                                <span>{{ $opt }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Filter Harga --}}
                @php
                    $hargaLabels = [
                        ''         => '> Rp 5 jt',
                        'lt_5jt'   => '< Rp 5 jt',
                        'gt_50jt'  => '> Rp 50 jt',
                        'gt_100jt' => '> Rp 100 jt',
                        'gt_500jt' => '> Rp 500 jt',
                        'gt_1m'    => '> Rp 1 M',
                    ];
                    $currentHargaLabel = $hargaLabels[request('harga', '')] ?? '> Rp 5 jt';
                @endphp
                <div class="relative custom-filter-container">
                    <button type="button" class="filter-dropdown-btn inline-flex items-center gap-1 h-[30px] sm:h-[38px] bg-white border border-gray-200 hover:border-gray-300 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3 py-1 transition cursor-pointer">
                        <span class="text-gray-400 font-normal text-[11px] sm:text-xs select-none">Harga:</span>
                        <span class="text-gray-800 font-semibold text-[11px] sm:text-xs select-none">{{ $currentHargaLabel }}</span>
                        <x-icon name="chevron-down" class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 ml-0.5 pointer-events-none" />
                    </button>
                    <div class="filter-dropdown-menu hidden absolute left-0 top-full mt-1 z-[100] min-w-[160px] max-h-[220px] overflow-y-auto rounded-lg lg:rounded-[10px] bg-white border border-gray-100 shadow-[0_10px_35px_rgba(0,0,0,0.14)] p-1.5 flex flex-col gap-0.5">
                        @foreach($hargaLabels as $val => $lbl)
                            <button type="button" onclick="selectFilterOption('harga', '{{ $val }}')" class="flex items-center justify-between w-full px-2.5 py-1.5 text-[11px] sm:text-xs font-semibold {{ request('harga', '') === (string)$val ? 'bg-blue-50 text-[#0066FF]' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg lg:rounded-[10px] transition text-left cursor-pointer">
                                <span>{{ $lbl }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Filter Waktu --}}
                @php
                    $waktuLabels = [
                        ''        => '6 bulan Terakhir',
                        '1bulan'  => '1 Bulan Terakhir',
                        '3bulan'  => '3 Bulan Terakhir',
                        '6bulan'  => '6 Bulan Terakhir',
                        '1tahun'  => '1 Tahun Terakhir',
                    ];
                    $currentWaktuLabel = $waktuLabels[request('waktu', '')] ?? '6 bulan Terakhir';
                @endphp
                <div class="relative custom-filter-container">
                    <button type="button" class="filter-dropdown-btn inline-flex items-center gap-1 h-[30px] sm:h-[38px] bg-white border border-gray-200 hover:border-gray-300 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3 py-1 transition cursor-pointer">
                        <span class="text-gray-400 font-normal text-[11px] sm:text-xs select-none">Waktu:</span>
                        <span class="text-gray-800 font-semibold text-[11px] sm:text-xs select-none">{{ $currentWaktuLabel }}</span>
                        <x-icon name="chevron-down" class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 ml-0.5 pointer-events-none" />
                    </button>
                    <div class="filter-dropdown-menu hidden absolute left-0 top-full mt-1 z-[100] min-w-[160px] max-h-[220px] overflow-y-auto rounded-lg lg:rounded-[10px] bg-white border border-gray-100 shadow-[0_10px_35px_rgba(0,0,0,0.14)] p-1.5 flex flex-col gap-0.5">
                        @foreach($waktuLabels as $val => $lbl)
                            <button type="button" onclick="selectFilterOption('waktu', '{{ $val }}')" class="flex items-center justify-between w-full px-2.5 py-1.5 text-[11px] sm:text-xs font-semibold {{ request('waktu', '') === (string)$val ? 'bg-blue-50 text-[#0066FF]' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg lg:rounded-[10px] transition text-left cursor-pointer">
                                <span>{{ $lbl }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

            </form>

            {{-- MOBILE CARD LIST VIEW (sm:hidden - Mengikuti Prinsip Mobile-First UX) --}}
            <div class="sm:hidden flex flex-col gap-3">
                @forelse($contracts as $item)
                    <div class="rounded-xl border border-gray-200/90 bg-white p-3.5 shadow-2xs flex flex-col gap-2.5">
                        {{-- Card Header: No Kontrak + Status Badge --}}
                        <div class="flex items-start justify-between gap-2 border-b border-gray-100 pb-2">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">No Kontrak</span>
                                <span class="text-xs font-bold text-gray-900 leading-snug">{{ $item->contract_number ?? '-' }}</span>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ ($item->tenant?->status_customer ?? '') === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-blue-50 text-blue-700 border border-blue-200/60' }}">
                                {{ $item->tenant?->status_customer ?? 'Swasta' }}
                            </span>
                        </div>

                        {{-- Tenant & Asset Info --}}
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 leading-tight">
                                {{ $item->tenant?->fullname ?? $item->tenant?->name ?? 'Drs. Bambang Sudarsono' }}
                            </h3>
                            @if($item->tenant?->brand)
                                <p class="text-xs text-[#0066FF] font-semibold mt-0.5">Brand: {{ $item->tenant->brand }}</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2 leading-relaxed">
                                {{ $item->asset?->asset_block_name ?? 'JL. SLAMET 17 KEL. BENDAN KEC. PEKALONGAN BARAT KAB. PEKALONGAN' }}
                            </p>
                        </div>

                        {{-- 2-Cols Meta Grid --}}
                        <div class="grid grid-cols-2 gap-2 bg-gray-50/90 rounded-lg p-2.5 text-xs">
                            <div>
                                <span class="text-gray-400 block text-[10px]">Jenis Aset</span>
                                <span class="font-semibold text-gray-800">{{ $item->asset?->jenis_asset ?? 'Tanah' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[10px]">Waktu Kontrak</span>
                                <span class="font-semibold text-gray-800">{{ $item->contract_duration ?? '12 Bulan' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[10px]">Periode</span>
                                <span class="font-medium text-gray-800 text-[11px]">{{ $item->start_datetime ? $item->start_datetime->format('d/m/y') : '01/01/16' }} - {{ $item->end_datetime_baru ? $item->end_datetime_baru->format('d/m/y') : ($item->end_datetime ? $item->end_datetime->format('d/m/y') : '31/12/26') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[10px]">Nilai Kontrak</span>
                                <span class="font-bold text-gray-950 text-[11px]">{{ is_numeric($item->price) ? 'Rp ' . number_format((float)$item->price, 0, ',', '.') : ($item->price_formatted ?? 'Rp 2.264.394') }}</span>
                            </div>
                        </div>

                        {{-- Card Actions Footer (Thumb-friendly buttons) --}}
                        <div class="flex items-center justify-end gap-2 pt-1 border-t border-gray-100">
                            <a href="{{ route('asset.detail', $item->asset_number) }}" class="flex-1 min-h-[40px] inline-flex items-center justify-center gap-1.5 rounded-lg lg:rounded-[10px] border border-gray-200 bg-white hover:bg-gray-50 text-xs font-semibold text-gray-700 shadow-2xs transition">
                                <x-icon name="icon-lihat" class="w-4 h-4 text-gray-500" />
                                <span>Lihat Detail</span>
                            </a>
                            <a href="{{ route('contracts.edit', $item->asset_number) }}" class="flex-1 min-h-[40px] inline-flex items-center justify-center gap-1.5 rounded-lg lg:rounded-[10px] bg-[#0066FF] hover:bg-blue-700 text-xs font-semibold text-white shadow-2xs transition">
                                <x-icon name="icon-edit-detail-peta" class="w-4 h-4 text-white" />
                                <span>Edit</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-gray-400 bg-gray-50 rounded-xl">
                        Tidak ada data kontrak yang tersedia.
                    </div>
                @endforelse
            </div>

            {{-- DESKTOP TABLE VIEW (hidden sm:block) --}}
            <div class="hidden sm:block border border-gray-200 rounded-xl overflow-hidden bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F8F9FA] border-b border-gray-200">
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">No Kontrak</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Waktu Kontrak</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Nama Penyewa</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Brand</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Nama Blok Aset</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Jenis Aset</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Awal Kontrak</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Selesai Kontrak</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Harga</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Status Customer</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-[13px] text-gray-800">
                            @forelse($contracts as $item)
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <td class="py-3.5 px-4 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $item->contract_number ?? '-' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $item->contract_duration ?? ($item->contract_date ? $item->contract_date->format('Y') : '42710') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-900 font-medium whitespace-nowrap">
                                        {{ $item->tenant?->fullname ?? $item->tenant?->name ?? 'Drs. Bambang Sudarsono' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                        {{ $item->tenant?->brand ?: '(kosong)' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-700 font-normal max-w-[280px] leading-snug">
                                        {{ $item->asset?->asset_block_name ?? 'JL. SLAMET 17 KEL. BENDAN KEC. PEKALONGAN BARAT KAB. PEKALONGAN' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $item->asset?->jenis_asset ?? 'Tanah' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $item->start_datetime ? $item->start_datetime->format('d/m/y') : '01/01/16' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $item->end_datetime_baru ? $item->end_datetime_baru->format('m/d/Y') : ($item->end_datetime ? $item->end_datetime->format('m/d/Y') : '12/31/2026') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-900 font-normal whitespace-nowrap">
                                        {{ is_numeric($item->price) ? number_format((float)$item->price, 0, ',', '.') : ($item->price_formatted ?? '2.264.394') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $item->tenant?->status_customer ?? 'Swasta' }}
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                        <div class="relative inline-block text-left action-menu-wrapper"
                                             data-asset="{{ $item->asset_number }}">
                                            <button
                                                type="button"
                                                class="action-menu-btn flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition cursor-pointer"
                                                title="Aksi"
                                            >
                                                <x-icon name="dots-vertical" class="w-4 h-4" />
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

        </div>

    </main>

    {{-- Global Dropdown Menu Aksi --}}
    <div id="global-action-dropdown" class="hidden fixed z-[9999] w-[140px] sm:w-[165px] rounded-xl sm:rounded-2xl bg-white border border-gray-100 shadow-[0_10px_35px_rgba(0,0,0,0.14)] p-1.5 sm:p-2.5 flex flex-col gap-0.5 sm:gap-1">
        <a id="dd-lihat" href="#" class="flex items-center gap-2 sm:gap-2.5 px-2.5 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition">
            <x-icon name="icon-lihat" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 shrink-0" />
            <span>Lihat</span>
        </a>
        <a id="dd-edit" href="#" class="flex items-center gap-2 sm:gap-2.5 px-2.5 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition">
            <x-icon name="edit" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 shrink-0" />
            <span>Edit</span>
        </a>
        <form id="dd-delete-form" method="POST" onsubmit="return confirm('Hapus kontrak aset ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="flex w-full items-center gap-2 sm:gap-2.5 px-2.5 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-[#EF4444] hover:bg-red-50 rounded-xl transition cursor-pointer">
                <x-icon name="delete" class="w-4 h-4 sm:w-5 sm:h-5 text-[#EF4444] shrink-0" />
                <span>Hapus</span>
            </button>
        </form>
    </div>

    <script>
        (function () {
            const dropdown     = document.getElementById('global-action-dropdown');
            const ddLihat      = document.getElementById('dd-lihat');
            const ddEdit       = document.getElementById('dd-edit');
            const ddDeleteForm = document.getElementById('dd-delete-form');

            const routes = {
                detail: (id) => `/asset/${id}`,
                edit:   (id) => `/daftar-kontrak/${id}/edit`,
                delete: (id) => `/admin/assets/${id}`,
            };

            @foreach($contracts as $item)
            routes['detail_{{ $item->asset_number }}'] = '{{ route('asset.detail', $item->asset_number) }}';
            routes['edit_{{ $item->asset_number }}']   = '{{ route('contracts.edit', $item->asset_number) }}';
            routes['delete_{{ $item->asset_number }}'] = '{{ route('admin.assets.destroy', $item->asset_number) }}';
            @endforeach

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.action-menu-btn');

                if (btn) {
                    e.stopPropagation();

                    const wrapper = btn.closest('.action-menu-wrapper');
                    const assetId = wrapper.dataset.asset;
                    const rect    = btn.getBoundingClientRect();
                    const dropW   = 165;

                    let left = rect.right - dropW;
                    let top  = rect.bottom + 6;

                    ddLihat.href        = routes[`detail_${assetId}`] || `/asset/${assetId}`;
                    ddEdit.href         = routes[`edit_${assetId}`] || `/daftar-kontrak/${assetId}/edit`;
                    ddDeleteForm.action = routes[`delete_${assetId}`] || `/admin/assets/${assetId}`;

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

            // Custom Filter Dropdown Logic
            window.selectFilterOption = function (name, value) {
                const map = {
                    'jenis_asset': 'input-jenis-asset',
                    'status_customer': 'input-status-customer',
                    'harga': 'input-harga',
                    'waktu': 'input-waktu',
                };
                const el = document.getElementById(map[name]);
                if (el) {
                    el.value = value;
                    document.getElementById('filter-form').submit();
                }
            };

            document.addEventListener('click', function (e) {
                const filterBtn = e.target.closest('.filter-dropdown-btn');
                const allFilterMenus = document.querySelectorAll('.filter-dropdown-menu');

                if (filterBtn) {
                    e.stopPropagation();
                    const container = filterBtn.closest('.custom-filter-container');
                    const menu = container.querySelector('.filter-dropdown-menu');
                    const wasHidden = menu.classList.contains('hidden');

                    // Close all other filter menus
                    allFilterMenus.forEach(m => m.classList.add('hidden'));
                    dropdown.classList.add('hidden');

                    if (wasHidden) {
                        menu.classList.remove('hidden');
                    }
                } else if (!e.target.closest('.filter-dropdown-menu')) {
                    allFilterMenus.forEach(m => m.classList.add('hidden'));
                }
            });

            document.addEventListener('scroll', function (e) {
                if (e.target && e.target.closest && (e.target.closest('.filter-dropdown-menu') || e.target.closest('#global-action-dropdown'))) {
                    return;
                }
                dropdown.classList.add('hidden');
                dropdown.dataset.open = '';
                document.querySelectorAll('.filter-dropdown-menu').forEach(m => m.classList.add('hidden'));
            }, true);
        })();
    </script>

</body>

</html>
