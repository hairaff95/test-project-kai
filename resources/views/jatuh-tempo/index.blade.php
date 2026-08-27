<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jatuh Tempo — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 999px;
        }
        .status-normal { background-color: #EFF6FF; color: #1D4ED8; }
        .status-warning { background-color: #FEF9C3; color: #A16207; }
        .status-danger  { background-color: #FEF2F2; color: #B91C1C; }

        .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }
        .dot-normal  { background-color: #3B82F6; }
        .dot-warning { background-color: #EAB308; }
        .dot-danger  { background-color: #EF4444; }

        /* Scrollbar for table */
        .table-wrap::-webkit-scrollbar { height: 4px; }
        .table-wrap::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .table-wrap::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        .table-wrap::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    </style>
</head>

<body class="min-h-screen bg-[#F6F7F9] font-sans antialiased text-gray-900 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between">

    {{-- Top Navbar --}}
    <x-navbar active="due-dates" />

    {{-- Main Content --}}
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-6 pb-24 lg:pb-8 flex flex-col gap-4 sm:gap-5">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0">
            <h1 class="text-2xl sm:text-[30px] font-bold tracking-tight text-gray-950">
                Jatuh Tempo
            </h1>

            {{-- Header Action Buttons --}}
            <div class="flex items-center gap-2 self-start sm:self-auto">
                {{-- Filter Button --}}
                <button id="btn-filter-jt" type="button" style="background-color: #0066FF;" class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:opacity-95 transition cursor-pointer">
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 5H17.5M5.83333 10H14.1667M9.16667 15H10.8333" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Filter</span>
                </button>

                {{-- Sort Order Button --}}
                <button id="btn-sort-jt" type="button" class="flex items-center gap-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 px-3.5 py-2.5 text-sm font-medium text-gray-700 shadow-xs transition cursor-pointer">
                    <svg class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.33333 5.83333H16.6667M5.83333 10H14.1667M8.33333 14.1667H11.6667" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Sort Order</span>
                    <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="rounded-2xl sm:rounded-3xl bg-white p-3.5 sm:p-4 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90">
            <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">

                {{-- Search --}}
                <div class="relative flex-1 min-w-[180px] sm:min-w-[220px]">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input
                        id="search-jt"
                        type="text"
                        placeholder="Search"
                        class="w-full pl-10 pr-3.5 py-2 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#0066FF] text-gray-800 placeholder-gray-400 transition"
                    >
                </div>

                {{-- Semua Kontrak --}}
                <div class="relative">
                    <select id="filter-kontrak-jt" class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition min-w-[140px]">
                        <option>Semua Kontrak</option>
                        <option>Aktif</option>
                        <option>Tidak Aktif</option>
                        <option>Akan Jatuh Tempo</option>
                        <option>Sudah Berakhir</option>
                    </select>
                    <svg class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                {{-- Hari Kontrak --}}
                <div class="relative">
                    <select id="filter-hari-jt" class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition min-w-[130px]">
                        <option>Hari Kontrak</option>
                        <option>&lt; 30 Hari</option>
                        <option>30 - 90 Hari</option>
                        <option>90 - 180 Hari</option>
                        <option>&gt; 180 Hari</option>
                    </select>
                    <svg class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                {{-- Semua Jenis Aset --}}
                <div class="relative">
                    <select id="filter-jenis-jt" class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition min-w-[160px]">
                        <option>Semua Jenis Aset</option>
                        <option>Bangunan Dinas</option>
                        <option>Tanah Lapang</option>
                        <option>Gudang</option>
                        <option>Kios / Ruko</option>
                        <option>Lahan</option>
                    </select>
                    <svg class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

            </div>
        </div>

        {{-- Table Container --}}
        <div class="rounded-2xl sm:rounded-3xl bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 overflow-hidden flex flex-col">
            <div class="table-wrap overflow-x-auto">
                <table class="w-full text-left border-collapse" style="min-width: 900px;">
                    <thead>
                        <tr class="border-b border-gray-100 bg-white">
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">No Aset</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Nama</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Jenis Aset</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Tgl Mulai</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Tgl Akhir</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Nilai Kontrak</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Jatuh Tempo</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Kondisi Kontrak</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-[13px] text-gray-700">
                        @forelse($contracts as $index => $item)
                            @php
                                $daysLeft = $item->end_datetime_baru
                                    ? now()->diffInDays($item->end_datetime_baru, false)
                                    : null;
                                $statusClass = match(true) {
                                    $daysLeft === null        => 'status-normal',
                                    $daysLeft < 0             => 'status-danger',
                                    $daysLeft <= 30           => 'status-danger',
                                    $daysLeft <= 90           => 'status-warning',
                                    default                   => 'status-normal',
                                };
                                $dotClass = match(true) {
                                    $daysLeft === null        => 'dot-normal',
                                    $daysLeft < 0             => 'dot-danger',
                                    $daysLeft <= 30           => 'dot-danger',
                                    $daysLeft <= 90           => 'dot-warning',
                                    default                   => 'dot-normal',
                                };
                                $kondisi = match(true) {
                                    $daysLeft === null        => 'Tidak diketahui',
                                    $daysLeft < 0             => 'Sudah berakhir',
                                    $daysLeft <= 30           => 'Segera berakhir',
                                    $daysLeft <= 90           => 'Perlu perhatian',
                                    default                   => 'Aktif',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="py-3.5 px-4 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $item->asset_number }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap font-medium">
                                    {{ $item->penyewa?->fullnama ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                    {{ $item->asset?->jenis_aset ?? '-' }}
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
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                    {{ $item->due_days }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="status-badge {{ $statusClass }}">
                                        <span class="dot {{ $dotClass }}"></span>
                                        {{ $kondisi }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('asset.detail', $item->asset_number) }}"
                                            style="background-color: #212529;"
                                            class="flex h-7 w-7 items-center justify-center rounded-lg text-white hover:opacity-90 transition" title="Lihat Detail">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke-width="2"/></svg>
                                        </a>
                                        <a href="{{ route('admin.assets.edit', $item->asset_number) }}"
                                            style="background-color: #0066FF;"
                                            class="flex h-7 w-7 items-center justify-center rounded-lg text-white hover:opacity-90 transition" title="Edit">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M11 4H4C3.47 4 2.96 4.21 2.59 4.59C2.21 4.96 2 5.47 2 6V20C2 20.53 2.21 21.04 2.59 21.41C2.96 21.79 3.47 22 4 22H18C18.53 22 19.04 21.79 19.41 21.41C19.79 21.04 20 20.53 20 20V13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5C18.9 2.1 19.44 1.88 20 1.88C20.56 1.88 21.1 2.1 21.5 2.5C21.9 2.9 22.12 3.44 22.12 4C22.12 4.56 21.9 5.1 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-10 text-gray-400">
                                    Tidak ada data jatuh tempo yang tersedia.
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
