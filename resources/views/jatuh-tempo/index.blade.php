<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Jatuh Tempo — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Anti-FOUC Auto Theme Script (WIB 17:00 - 07:00 Auto Dark Mode) -->
    <x-theme-script />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-[#F6F7F9] dark:bg-[#282A2C] font-sans antialiased text-gray-900 dark:text-gray-100 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between transition-colors duration-200">

    {{-- Top Navbar --}}
    <x-navbar active="due-dates" />

    {{-- Main Content --}}
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-6 pb-28 lg:pb-8 flex flex-col gap-4 sm:gap-5">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0">
            <h1 class="text-xl sm:text-[30px] font-bold tracking-tight text-gray-950 dark:text-white">
                Jatuh Tempo
            </h1>

            {{-- Header Action Buttons --}}
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <button id="btn-filter-jt" type="button" class="flex items-center gap-1.5 sm:gap-2 rounded-lg lg:rounded-[10px] bg-[#0066FF] hover:bg-blue-700 px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow-xs transition cursor-pointer">
                    <x-icon name="filter-icon" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" />
                    <span>Filter</span>
                </button>

                <a href="{{ route('due-dates.index') }}" class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-lg lg:rounded-[10px] border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] hover:bg-gray-50 dark:hover:bg-white/10 text-gray-700 dark:text-white shadow-xs transition cursor-pointer" title="Reset">
                    <x-icon name="refresh" class="w-4 h-4 sm:w-4.5 sm:h-4.5 text-gray-600 dark:text-white" />
                </a>
            </div>
        </div>

        {{-- Unified Card Container: Filter Bar + Bordered Table --}}
        <div class="rounded-3xl bg-white dark:bg-[#1F2123] p-3 sm:p-5 shadow-[0_2px_12px_rgba(0,0,0,0.02)] border border-gray-100/90 dark:border-white/10 flex flex-col gap-2.5 sm:gap-4 transition-colors">

            {{-- Filter Bar --}}
            <div class="flex flex-wrap items-center justify-between gap-1.5 sm:gap-2.5 w-full">

                <div class="flex flex-wrap items-center gap-1.5 sm:gap-2.5">
                    {{-- Search --}}
                    <div class="relative w-full sm:w-[185px] h-[32px] sm:h-[38px]">
                        <x-icon name="search" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 dark:text-[#9AA0A6] absolute left-2.5 sm:left-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input
                            id="search-jt"
                            type="text"
                            placeholder="Search"
                            class="w-full h-full pl-8 sm:pl-9 pr-3 py-1 text-xs sm:text-sm bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 rounded-lg lg:rounded-[10px] focus:outline-none focus:border-[#0066FF] text-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition"
                        >
                    </div>

                    {{-- Filter Nama Penyewa --}}
                    @php
                        $tenantList = $contracts->map(fn($c) => $c->tenant?->fullname)->filter()->unique()->values();
                    @endphp
                    <div class="relative custom-filter-container">
                        <button type="button" class="filter-dropdown-btn inline-flex items-center h-[30px] sm:h-[38px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3 py-1 transition cursor-pointer">
                            <span id="label-penyewa" class="text-gray-400 dark:text-[#9AA0A6] font-normal text-[11px] sm:text-xs select-none">Nama Penyewa</span>
                            <x-icon name="chevron-down" class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 dark:text-[#9AA0A6] ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                        </button>
                        <div class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] min-w-[160px] max-h-[220px] overflow-y-auto rounded-lg lg:rounded-[10px] bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1.5 flex flex-col gap-0.5">
                            <button type="button" onclick="filterJtClient('penyewa', '', 'Nama Penyewa')" class="flex items-center justify-between w-full px-2.5 py-1.5 text-[11px] sm:text-xs font-semibold bg-blue-50 dark:bg-blue-900/30 text-black dark:text-white rounded-lg lg:rounded-[10px] transition text-left cursor-pointer">
                                <span>Semua Penyewa</span>
                            </button>
                            @foreach($tenantList as $t)
                                <button type="button" onclick="filterJtClient('penyewa', '{{ $t }}', '{{ $t }}')" class="flex items-center justify-between w-full px-2.5 py-1.5 text-[11px] sm:text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-[10px] transition text-left cursor-pointer">
                                    <span>{{ $t }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Filter Status Customer (Dinamis dari database) --}}
                    <div class="relative custom-filter-container">
                        <button type="button" class="filter-dropdown-btn inline-flex items-center h-[30px] sm:h-[38px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3 py-1 transition cursor-pointer">
                            <span id="label-status" class="text-gray-400 dark:text-[#9AA0A6] font-normal text-[11px] sm:text-xs select-none">Status Customer</span>
                            <x-icon name="chevron-down" class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 dark:text-[#9AA0A6] ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                        </button>
                        <div class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] min-w-[160px] max-h-[220px] overflow-y-auto rounded-lg lg:rounded-[10px] bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1.5 flex flex-col gap-0.5">
                            <button type="button" onclick="filterJtClient('status', '', 'Status Customer')" class="flex items-center justify-between w-full px-2.5 py-1.5 text-[11px] sm:text-xs font-semibold bg-blue-50 dark:bg-blue-900/30 text-black dark:text-white rounded-lg lg:rounded-[10px] transition text-left cursor-pointer">
                                <span>Semua Status</span>
                            </button>
                            @foreach($statusCustomerOptions as $opt)
                                <button type="button" onclick="filterJtClient('status', '{{ $opt }}', '{{ $opt }}')" class="flex items-center justify-between w-full px-2.5 py-1.5 text-[11px] sm:text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-[10px] transition text-left cursor-pointer">
                                    <span>{{ $opt }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Filter Semua Jenis Aset --}}
                    <div class="relative custom-filter-container">
                        <button type="button" class="filter-dropdown-btn inline-flex items-center h-[30px] sm:h-[38px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3 py-1 transition cursor-pointer">
                            <span id="label-jenis" class="text-gray-400 dark:text-[#9AA0A6] font-normal text-[11px] sm:text-xs select-none">Semua Jenis Aset</span>
                            <x-icon name="chevron-down" class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 dark:text-[#9AA0A6] ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                        </button>
                        <div class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] min-w-[160px] max-h-[220px] overflow-y-auto rounded-lg lg:rounded-[10px] bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1.5 flex flex-col gap-0.5">
                            <button type="button" onclick="filterJtClient('jenis', '', 'Semua Jenis Aset')" class="flex items-center justify-between w-full px-2.5 py-1.5 text-[11px] sm:text-xs font-semibold bg-blue-50 dark:bg-blue-900/30 text-black dark:text-white rounded-lg lg:rounded-[10px] transition text-left cursor-pointer">
                                <span>Semua Jenis Aset</span>
                            </button>
                            @foreach($jenisAssetOptions as $opt)
                                <button type="button" onclick="filterJtClient('jenis', '{{ $opt }}', '{{ $opt }}')" class="flex items-center justify-between w-full px-2.5 py-1.5 text-[11px] sm:text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-[10px] transition text-left cursor-pointer">
                                    <span>{{ $opt }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Tombol Tambah Aset --}}
                @auth
                <a
                    href="{{ route('contracts.create') }}"
                    class="inline-flex items-center gap-1.5 sm:gap-2 rounded-lg lg:rounded-[10px] bg-[#0066FF] hover:bg-blue-700 px-3 sm:px-4 py-2 sm:py-2.5 text-xs sm:text-sm font-semibold text-white shadow-xs transition active:scale-95 cursor-pointer ml-auto shrink-0"
                >
                    <x-icon name="plus-icon" class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-white fill-white" />
                    <span>Tambah Aset</span>
                </a>
                @endauth

            </div>

            {{-- MOBILE CARD LIST VIEW (sm:hidden - Mobile-First Card View) --}}
            <div id="mobile-cards-jt" class="sm:hidden flex flex-col gap-3">
                @forelse($contracts as $item)
                    @php
                        $penyewa = $item->tenant?->fullname ?? $item->tenant?->name ?? '-';
                        $brand = $item->tenant?->brand ?: '(kosong)';
                        $statusCust = $item->tenant?->status_customer ?? 'Aktif';
                        $jenisAset = $item->asset?->jenis_asset ?? 'Tanah';
                        $selesaiLama = $item->end_datetime ? \Carbon\Carbon::parse($item->end_datetime)->format('d/m/Y') : '-';
                        $selesaiBaru = $item->end_datetime_baru ? \Carbon\Carbon::parse($item->end_datetime_baru)->format('d/m/Y') : '-';
                    @endphp
                    <div class="jt-card-item rounded-xl border border-gray-200/90 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3.5 shadow-2xs flex flex-col gap-2.5 transition-colors"
                         data-penyewa="{{ strtolower($penyewa) }}"
                         data-status="{{ strtolower($statusCust) }}"
                         data-jenis="{{ strtolower($jenisAset) }}"
                         data-price="{{ (float)($item->price ?? 0) }}"
                    >
                        {{-- Card Header: No Aset + Status Badge --}}
                        <div class="flex items-start justify-between gap-2 border-b border-gray-100 dark:border-white/10 pb-2">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-gray-400 dark:text-[#9AA0A6] uppercase tracking-wider">No Aset</span>
                                <span class="text-xs font-bold text-gray-900 dark:text-white leading-snug">{{ $item->asset_number ?? '-' }}</span>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ strtolower($statusCust) === 'aktif' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-800' : 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border border-blue-200/60 dark:border-blue-800' }}">
                                {{ $statusCust }}
                            </span>
                        </div>

                        {{-- Tenant Info & Brand --}}
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white leading-tight">
                                {{ $penyewa }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-[#9AA0A6] font-normal mt-0.5">Brand: {{ $brand }}</p>
                        </div>

                        {{-- 2-Cols Meta Grid --}}
                        <div class="grid grid-cols-2 gap-2 bg-gray-50/90 dark:bg-[#2D3034] rounded-lg p-2.5 text-xs">
                            <div>
                                <span class="text-gray-400 dark:text-[#9AA0A6] block text-[10px]">Selesai Kontrak</span>
                                <span class="font-semibold text-gray-900 dark:text-white text-[11px]">{{ $selesaiLama }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 dark:text-[#9AA0A6] block text-[10px]">Kontrak Baru</span>
                                <span class="font-semibold text-gray-900 dark:text-white text-[11px]">{{ $selesaiBaru }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 dark:text-[#9AA0A6] block text-[10px]">Sisa Masa Sewa</span>
                                <span class="font-medium text-amber-600 dark:text-amber-400 text-[11px]">{{ $item->due_days ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 dark:text-[#9AA0A6] block text-[10px]">Keterangan</span>
                                <span class="font-medium text-gray-800 dark:text-white text-[11px]">{{ $item->keterangan ?? '-' }}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-400 dark:text-[#9AA0A6] block text-[10px]">SPV</span>
                                <span class="font-medium text-gray-800 dark:text-white text-[11px]">{{ $item->spv ?? '-' }}</span>
                            </div>
                        </div>

                        {{-- Card Actions Footer --}}
                        <div class="flex items-center justify-end gap-2 pt-1 border-t border-gray-100 dark:border-white/10">
                            <a href="{{ route('asset.detail', $item->asset_number) }}" class="flex-1 min-h-[40px] inline-flex items-center justify-center gap-1.5 rounded-lg lg:rounded-[10px] border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] hover:bg-gray-50 dark:hover:bg-white/10 text-xs font-semibold text-gray-700 dark:text-white shadow-2xs transition">
                                <x-icon name="icon-lihat" class="w-4 h-4 text-gray-500 dark:text-white" />
                                <span>Lihat Detail</span>
                            </a>
                            @auth
                            <a href="{{ route('due-dates.edit', $item->asset_number) }}" class="flex-1 min-h-[40px] inline-flex items-center justify-center gap-1.5 rounded-lg lg:rounded-[10px] bg-[#0066FF] hover:bg-blue-700 text-xs font-semibold text-white shadow-2xs transition">
                                <x-icon name="icon-edit-detail-peta" class="w-4 h-4 text-white" />
                                <span>Edit</span>
                            </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-gray-400 dark:text-[#9AA0A6] bg-gray-50 dark:bg-[#2D3034] rounded-xl">
                        Tidak ada data jatuh tempo yang tersedia.
                    </div>
                @endforelse
            </div>

            {{-- DESKTOP TABLE VIEW (hidden sm:block) --}}
            <div class="hidden sm:block border border-gray-200 dark:border-white/10 rounded-xl overflow-hidden bg-white dark:bg-[#1F2123]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F8F9FA] dark:bg-[#282A2C] border-b border-gray-200 dark:border-white/10">
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">No Aset</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Nama Penyewa</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Brand</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Selesai Kontrak</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Selesai Kontrak Baru</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Sisa Masa Sewa</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">SPV</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Keterangan</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/10 text-[13px] text-gray-800 dark:text-gray-200">
                            @forelse($contracts as $item)
                                @php
                                    $penyewa = $item->tenant?->fullname ?? $item->tenant?->name ?? '-';
                                    $brand = $item->tenant?->brand ?: '(kosong)';
                                    $statusCust = $item->tenant?->status_customer ?? 'Aktif';
                                    $jenisAset = $item->asset?->jenis_asset ?? 'Tanah';
                                    $selesaiLama = $item->end_datetime ? \Carbon\Carbon::parse($item->end_datetime)->format('d/m/Y') : '-';
                                    $selesaiBaru = $item->end_datetime_baru ? \Carbon\Carbon::parse($item->end_datetime_baru)->format('d/m/Y') : '-';
                                @endphp
                                <tr class="hover:bg-gray-50/60 dark:hover:bg-white/5 transition-colors"
                                    data-penyewa="{{ strtolower($penyewa) }}"
                                    data-status="{{ strtolower($statusCust) }}"
                                    data-jenis="{{ strtolower($jenisAset) }}"
                                    data-price="{{ (float)($item->price ?? 0) }}"
                                 >
                                    <td class="py-3.5 px-4 font-normal text-gray-900 dark:text-white whitespace-nowrap">{{ $item->asset_number ?? '-' }}</td>
                                    <td class="py-3.5 px-4 text-gray-900 dark:text-white font-medium whitespace-nowrap">{{ $penyewa }}</td>
                                    <td class="py-3.5 px-4 text-gray-600 dark:text-[#9AA0A6] whitespace-nowrap font-normal">{{ $brand }}</td>
                                    <td class="py-3.5 px-4 text-gray-700 dark:text-gray-300 whitespace-nowrap font-normal">{{ $selesaiLama }}</td>
                                    <td class="py-3.5 px-4 text-gray-700 dark:text-gray-300 whitespace-nowrap font-normal">{{ $selesaiBaru }}</td>
                                    <td class="py-3.5 px-4 text-gray-700 dark:text-gray-300 whitespace-nowrap font-normal">{{ $item->due_days ?? '-' }}</td>
                                    <td class="py-3.5 px-4 text-gray-700 dark:text-gray-300 whitespace-nowrap font-normal">{{ $item->spv ?? '-' }}</td>
                                    <td class="py-3.5 px-4 text-gray-700 dark:text-gray-300 whitespace-nowrap font-normal">{{ $item->keterangan ?? '-' }}</td>
                                    <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                        <div class="relative inline-block text-left action-menu-wrapper"
                                             data-contract="{{ $item->contract_number }}">
                                            <button
                                                type="button"
                                                class="action-menu-btn flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 dark:bg-[#34383D] hover:bg-gray-200 dark:hover:bg-white/15 text-gray-600 dark:text-white transition cursor-pointer"
                                                title="Aksi"
                                            >
                                                <x-icon name="dots-vertical" class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-8 text-gray-400 dark:text-[#9AA0A6]">
                                        Tidak ada data jatuh tempo yang tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination 50 Data --}}
            <x-pagination :paginator="$contracts" />

        </div>

    </main>

    {{-- Global Dropdown Menu Aksi --}}
    <div id="global-action-dropdown" class="opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-right fixed z-[9999] w-[140px] sm:w-[165px] rounded-xl sm:rounded-2xl bg-white dark:bg-[#1F2123] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.7)] p-1.5 sm:p-2.5 flex flex-col gap-0.5 sm:gap-1">
        <a id="dd-lihat" href="#" class="flex items-center gap-2 sm:gap-2.5 px-2.5 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-xl transition">
            <x-icon name="icon-lihat" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 dark:text-gray-300 shrink-0" />
            <span>Lihat</span>
        </a>
        @auth
        <a id="dd-edit" href="#" class="flex items-center gap-2 sm:gap-2.5 px-2.5 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-xl transition">
            <x-icon name="edit" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 dark:text-gray-300 shrink-0" />
            <span>Edit</span>
        </a>
        <form id="dd-delete-form" method="POST" onsubmit="event.preventDefault(); return window.confirmDelete(this, 'Apakah Anda yakin ingin menghapus data jatuh tempo ini?');">
            @csrf @method('DELETE')
            <button type="submit" class="flex w-full items-center gap-2 sm:gap-2.5 px-2.5 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-[#EF4444] hover:bg-red-50 dark:hover:bg-red-950/30 rounded-xl transition cursor-pointer">
                <x-icon name="delete" class="w-4 h-4 sm:w-5 sm:h-5 text-[#EF4444] shrink-0" />
                <span>Hapus</span>
            </button>
        </form>
        @endauth
    </div>

    <script>
        (function () {
            const dropdown     = document.getElementById('global-action-dropdown');
            const ddLihat      = document.getElementById('dd-lihat');
            const ddEdit       = document.getElementById('dd-edit');
            const ddDeleteForm = document.getElementById('dd-delete-form');

            function openSmoothDropdown(el) {
                if (!el) return;
                el.classList.remove('opacity-0', 'invisible', 'scale-95', 'pointer-events-none');
                el.classList.add('opacity-100', 'visible', 'scale-100', 'pointer-events-auto');
            }
            function closeSmoothDropdown(el) {
                if (!el) return;
                el.classList.add('opacity-0', 'invisible', 'scale-95', 'pointer-events-none');
                el.classList.remove('opacity-100', 'visible', 'scale-100', 'pointer-events-auto');
            }
            function isSmoothDropdownOpen(el) {
                return el && !el.classList.contains('invisible');
            }

            const routes = {};

            @foreach($contracts as $item)
            routes['detail_{{ $item->contract_number }}'] = '{{ route('asset.detail', $item->contract_number) }}';
            routes['edit_{{ $item->contract_number }}']   = '{{ route('due-dates.edit', $item->contract_number) }}';
            routes['delete_{{ $item->contract_number }}'] = '{{ route('admin.assets.destroy', $item->contract_number) }}';
            @endforeach

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.action-menu-btn');

                if (btn) {
                    e.stopPropagation();

                    const wrapper    = btn.closest('.action-menu-wrapper');
                    const contractId = wrapper.dataset.contract;
                    const rect       = btn.getBoundingClientRect();
                    const dropW      = 165;

                    let left = rect.right - dropW;
                    let top  = rect.bottom + 6;

                    if (ddLihat) ddLihat.href = routes[`detail_${contractId}`] || `/asset/${encodeURIComponent(contractId)}`;
                    if (ddEdit) ddEdit.href = routes[`edit_${contractId}`] || `/jatuh-tempo/${encodeURIComponent(contractId)}/edit`;
                    if (ddDeleteForm) ddDeleteForm.action = routes[`delete_${contractId}`] || `/admin/assets/${encodeURIComponent(contractId)}`;

                    if (isSmoothDropdownOpen(dropdown) && dropdown.dataset.open === contractId) {
                        closeSmoothDropdown(dropdown);
                        dropdown.dataset.open = '';
                        return;
                    }

                    dropdown.style.top    = top + 'px';
                    dropdown.style.left   = left + 'px';
                    dropdown.dataset.open = contractId;
                    openSmoothDropdown(dropdown);
                } else if (!e.target.closest('#global-action-dropdown')) {
                    closeSmoothDropdown(dropdown);
                    dropdown.dataset.open = '';
                }
            });

            // Filter state — hanya disimpan, belum diapply sampai klik tombol Filter
            const filters = { search: '', penyewa: '', status: '', jenis: '' };
            const pending = { search: '', penyewa: '', status: '', jenis: '' };

            const labelMap = {
                penyewa: { el: 'label-penyewa', default: 'Nama Penyewa' },
                status:  { el: 'label-status',  default: 'Status Customer' },
                jenis:   { el: 'label-jenis',   default: 'Semua Jenis Aset' },
            };

            function applyFilters() {
                // Commit pending ke filters
                Object.assign(filters, pending);

                const rows = document.querySelectorAll('tbody tr[data-penyewa]');
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = checkMatch(text, row.dataset) ? '' : 'none';
                });

                const cards = document.querySelectorAll('.jt-card-item');
                cards.forEach(card => {
                    const text = card.innerText.toLowerCase();
                    card.style.display = checkMatch(text, card.dataset) ? '' : 'none';
                });

                // Update tombol Filter: tampilkan jumlah hasil
                const visibleRows  = document.querySelectorAll('tbody tr[data-penyewa]:not([style*="none"])').length;
                const hasFilter    = Object.values(filters).some(v => v !== '');
                const btnFilter    = document.getElementById('btn-filter-jt');
                const btnSpan      = btnFilter?.querySelector('span');
                if (btnSpan) btnSpan.textContent = hasFilter ? 'Filter (' + visibleRows + ')' : 'Filter';
            }

            function checkMatch(text, dataset) {
                if (filters.search && !text.includes(filters.search.toLowerCase())) return false;
                if (filters.penyewa && !(dataset.penyewa || '').toLowerCase().includes(filters.penyewa.toLowerCase())) return false;
                if (filters.status && (dataset.status || '').toLowerCase() !== filters.status.toLowerCase()) return false;
                if (filters.jenis  && (dataset.jenis  || '').toLowerCase() !== filters.jenis.toLowerCase())  return false;
                return true;
            }

            // Simpan pilihan ke pending + update label, tapi BELUM apply
            window.filterJtClient = function (type, value, label) {
                pending[type] = value;

                const cfg = labelMap[type];
                if (cfg) {
                    const lbl = document.getElementById(cfg.el);
                    if (lbl) {
                        lbl.textContent = value ? label : cfg.default;
                        lbl.className = value
                            ? 'text-black dark:text-white font-semibold text-[11px] sm:text-xs select-none'
                            : 'text-gray-400 dark:text-[#9AA0A6] font-normal text-[11px] sm:text-xs select-none';
                    }
                }

                // Tutup dropdown setelah pilih
                document.querySelectorAll('.filter-dropdown-menu').forEach(closeSmoothDropdown);
                document.querySelectorAll('.filter-dropdown-arrow').forEach(a => a.classList.remove('rotate-180'));
            };

            // Tombol Filter — apply semua filter sekaligus
            const btnFilter = document.getElementById('btn-filter-jt');
            if (btnFilter) {
                btnFilter.addEventListener('click', function () {
                    pending.search = (document.getElementById('search-jt')?.value || '');
                    applyFilters();
                });
            }

            // Search: simpan ke pending saja, tidak langsung filter
            const searchInput = document.getElementById('search-jt');
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    pending.search = this.value;
                });
                // Enter di search langsung apply
                searchInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') { pending.search = this.value; applyFilters(); }
                });
            }

            document.addEventListener('click', function (e) {
                const filterBtn = e.target.closest('.filter-dropdown-btn');
                const allFilterMenus = document.querySelectorAll('.filter-dropdown-menu');
                const allFilterArrows = document.querySelectorAll('.filter-dropdown-arrow');

                if (filterBtn) {
                    e.stopPropagation();
                    const container = filterBtn.closest('.custom-filter-container');
                    const menu = container ? container.querySelector('.filter-dropdown-menu') : null;
                    const arrow = filterBtn.querySelector('.filter-dropdown-arrow');
                    const wasOpen = isSmoothDropdownOpen(menu);

                    allFilterMenus.forEach(closeSmoothDropdown);
                    allFilterArrows.forEach(a => a.classList.remove('rotate-180'));
                    closeSmoothDropdown(dropdown);

                    if (!wasOpen && menu) {
                        openSmoothDropdown(menu);
                        if (arrow) arrow.classList.add('rotate-180');
                    }
                } else if (!e.target.closest('.filter-dropdown-menu')) {
                    allFilterMenus.forEach(closeSmoothDropdown);
                    allFilterArrows.forEach(a => a.classList.remove('rotate-180'));
                }
            });

            document.addEventListener('scroll', function (e) {
                if (e.target && e.target.closest && (e.target.closest('.filter-dropdown-menu') || e.target.closest('#global-action-dropdown'))) {
                    return;
                }
                closeSmoothDropdown(dropdown);
                dropdown.dataset.open = '';
                document.querySelectorAll('.filter-dropdown-menu').forEach(closeSmoothDropdown);
                document.querySelectorAll('.filter-dropdown-arrow').forEach(a => a.classList.remove('rotate-180'));
            }, true);
        })();
    </script>

</body>

</html>
