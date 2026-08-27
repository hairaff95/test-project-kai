<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Backlog — KAI Tracker App</title>
    <meta name="description" content="Halaman Backlog untuk memantau kontrak yang belum terbayar atau bermasalah pada KAI Tracker App.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        /* ──── Status Badge ──── */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 999px;
            white-space: nowrap;
        }
        .status-normal  { background-color: #EFF6FF; color: #1D4ED8; }
        .status-warning { background-color: #FEF9C3; color: #A16207; }
        .status-danger  { background-color: #FEF2F2; color: #B91C1C; }

        .dot { width: 6px; height: 6px; border-radius: 50%; }
        .dot-normal  { background-color: #3B82F6; }
        .dot-warning { background-color: #EAB308; }
        .dot-danger  { background-color: #EF4444; }

        /* ──── Row highlight untuk baris backlog / danger ──── */
        tr.row-danger td { background-color: #FFF5F5; }
        tr.row-danger:hover td { background-color: #FEE2E2 !important; }
        tr.row-warning td { background-color: #FFFBEB; }
        tr.row-warning:hover td { background-color: #FEF3C7 !important; }

        /* ──── Custom Scrollbar ──── */
        .table-wrap::-webkit-scrollbar { height: 5px; }
        .table-wrap::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .table-wrap::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        .table-wrap::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

        /* ──── Summary Cards ──── */
        .summary-card {
            background: #fff;
            border: 1px solid #F3F4F6;
            border-radius: 20px;
            padding: 18px 22px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }
        .summary-card .label {
            font-size: 12px;
            font-weight: 500;
            color: #9CA3AF;
        }
        .summary-card .value {
            font-size: 22px;
            font-weight: 700;
            color: #111827;
        }
        .summary-card .sub {
            font-size: 11.5px;
            font-weight: 500;
        }
    </style>
</head>

<body class="min-h-screen bg-[#F6F7F9] font-sans antialiased text-gray-900 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between">

    {{-- Top Navbar --}}
    <x-navbar active="blacklog" />

    {{-- Main Content --}}
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-6 pb-24 lg:pb-8 flex flex-col gap-4 sm:gap-5">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0">
            <h1 class="text-2xl sm:text-[30px] font-bold tracking-tight text-gray-950">
                Backlog
            </h1>

            {{-- Header Action Buttons --}}
            <div class="flex items-center gap-2 self-start sm:self-auto">
                {{-- Tampilan Filter Button --}}
                <button id="btn-filter-bl" type="button" style="background-color: #0066FF;" class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:opacity-95 transition cursor-pointer">
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 5H17.5M5.83333 10H14.1667M9.16667 15H10.8333" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Tampilan Filter</span>
                </button>

                {{-- Export Button --}}
                <button id="btn-export-bl" type="button" class="flex items-center gap-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 px-3.5 py-2.5 text-sm font-medium text-gray-700 shadow-xs transition cursor-pointer">
                    <svg class="w-4 h-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="7 10 12 15 17 10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="12" y1="15" x2="12" y2="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Export</span>
                </button>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
            {{-- Total Backlog --}}
            <div class="summary-card">
                <span class="label">Total Backlog</span>
                <span class="value text-[#EF4444]">{{ count(array_filter($items, fn($i) => $i['status_class'] === 'danger')) }}</span>
                <span class="sub text-[#EF4444]">Kontrak Bermasalah</span>
            </div>
            {{-- Peringatan --}}
            <div class="summary-card">
                <span class="label">Peringatan</span>
                <span class="value text-[#EAB308]">{{ count(array_filter($items, fn($i) => $i['status_class'] === 'warning')) }}</span>
                <span class="sub text-[#EAB308]">Perlu Perhatian</span>
            </div>
            {{-- Aktif --}}
            <div class="summary-card">
                <span class="label">Aktif</span>
                <span class="value text-[#3B82F6]">{{ count(array_filter($items, fn($i) => $i['status_class'] === 'normal')) }}</span>
                <span class="sub text-[#3B82F6]">Kontrak Berjalan</span>
            </div>
            {{-- Total Kontrak --}}
            <div class="summary-card">
                <span class="label">Total Data</span>
                <span class="value">{{ count($items) }}</span>
                <span class="sub text-gray-400">Semua Kontrak</span>
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
                        id="search-bl"
                        type="text"
                        placeholder="Search"
                        class="w-full pl-10 pr-3.5 py-2 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#0066FF] text-gray-800 placeholder-gray-400 transition"
                    >
                </div>

                {{-- Status --}}
                <div class="relative">
                    <select id="filter-status-bl" class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition min-w-[140px]">
                        <option>Semua Status</option>
                        <option>Aktif</option>
                        <option>Backlog</option>
                        <option>Peringatan</option>
                    </select>
                    <svg class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                {{-- Unit --}}
                <div class="relative">
                    <select id="filter-unit-bl" class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition min-w-[130px]">
                        <option>Semua Unit</option>
                        <option>Properti</option>
                        <option>Logistik</option>
                    </select>
                    <svg class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                {{-- Daop --}}
                <div class="relative">
                    <select id="filter-daop-bl" class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition min-w-[130px]">
                        <option>Semua Daop</option>
                        <option>Daop 1</option>
                        <option>Daop 2</option>
                        <option>Daop 3</option>
                        <option>Daop 4</option>
                        <option>Daop 5</option>
                        <option>Daop 6</option>
                        <option>Daop 7</option>
                        <option>Daop 8</option>
                        <option>Daop 9</option>
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
                <table class="w-full text-left border-collapse" style="min-width: 1400px;">
                    <thead>
                        <tr class="border-b border-gray-100 bg-[#FAFAFA]">
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">No Aset</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">Nama Penyewa</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">Daop</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">Unit</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">NM</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">MR</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">No Kontrak</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">Tgl Mulai</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">Tgl Akhir</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">NM2</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">Luas</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">Harga Satuan</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">Nilai Kontrak</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">Uang Muka</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">Sisa</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">Status</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap">Keterangan</th>
                            <th scope="col" class="py-3 px-3.5 text-[11px] font-semibold text-gray-400 whitespace-nowrap text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-[12px] text-gray-700">
                        @forelse($items as $item)
                            @php
                                $statusClass = match($item['status_class']) {
                                    'warning' => 'status-warning',
                                    'danger'  => 'status-danger',
                                    default   => 'status-normal',
                                };
                                $dotClass = match($item['status_class']) {
                                    'warning' => 'dot-warning',
                                    'danger'  => 'dot-danger',
                                    default   => 'dot-normal',
                                };
                                $rowClass = match($item['status_class']) {
                                    'danger'  => 'row-danger',
                                    'warning' => 'row-warning',
                                    default   => '',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50/70 transition-colors {{ $rowClass }}">
                                {{-- No Aset --}}
                                <td class="py-3 px-3.5 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $item['no_aset'] }}
                                </td>
                                {{-- Nama Penyewa --}}
                                <td class="py-3 px-3.5 text-gray-700 whitespace-nowrap font-medium">
                                    {{ $item['nama_penyewa'] }}
                                </td>
                                {{-- Daop --}}
                                <td class="py-3 px-3.5 text-gray-600 whitespace-nowrap">
                                    {{ $item['daop'] }}
                                </td>
                                {{-- Unit --}}
                                <td class="py-3 px-3.5 text-gray-600 whitespace-nowrap">
                                    {{ $item['unit'] }}
                                </td>
                                {{-- NM --}}
                                <td class="py-3 px-3.5 text-gray-600 whitespace-nowrap">
                                    {{ $item['nm'] }}
                                </td>
                                {{-- MR --}}
                                <td class="py-3 px-3.5 text-gray-600 whitespace-nowrap">
                                    {{ $item['mr'] }}
                                </td>
                                {{-- No Kontrak --}}
                                <td class="py-3 px-3.5 text-gray-700 whitespace-nowrap font-medium">
                                    {{ $item['no_kontrak'] }}
                                </td>
                                {{-- Tgl Mulai --}}
                                <td class="py-3 px-3.5 text-gray-600 whitespace-nowrap">
                                    {{ $item['tgl_mulai'] }}
                                </td>
                                {{-- Tgl Akhir --}}
                                <td class="py-3 px-3.5 text-gray-600 whitespace-nowrap">
                                    {{ $item['tgl_akhir'] }}
                                </td>
                                {{-- NM2 --}}
                                <td class="py-3 px-3.5 text-gray-600 whitespace-nowrap">
                                    {{ $item['nm2'] }}
                                </td>
                                {{-- Luas --}}
                                <td class="py-3 px-3.5 text-gray-600 whitespace-nowrap">
                                    {{ $item['luas'] }}
                                </td>
                                {{-- Harga Satuan --}}
                                <td class="py-3 px-3.5 text-gray-700 whitespace-nowrap font-medium">
                                    {{ $item['harga_satuan'] }}
                                </td>
                                {{-- Nilai Kontrak --}}
                                <td class="py-3 px-3.5 text-gray-900 font-semibold whitespace-nowrap">
                                    {{ $item['nilai_kontrak'] }}
                                </td>
                                {{-- Uang Muka --}}
                                <td class="py-3 px-3.5 text-gray-700 whitespace-nowrap font-medium">
                                    {{ $item['uang_muka'] }}
                                </td>
                                {{-- Sisa --}}
                                <td class="py-3 px-3.5 whitespace-nowrap font-semibold {{ $item['status_class'] === 'danger' ? 'text-red-600' : ($item['status_class'] === 'warning' ? 'text-yellow-600' : 'text-gray-900') }}">
                                    {{ $item['sisa'] }}
                                </td>
                                {{-- Status --}}
                                <td class="py-3 px-3.5 whitespace-nowrap">
                                    <span class="status-badge {{ $statusClass }}">
                                        <span class="dot {{ $dotClass }}"></span>
                                        {{ $item['status'] }}
                                    </span>
                                </td>
                                {{-- Keterangan --}}
                                <td class="py-3 px-3.5 text-gray-500 whitespace-nowrap text-[11.5px]">
                                    {{ $item['keterangan'] }}
                                </td>
                                {{-- Aksi --}}
                                <td class="py-3 px-3.5 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- View --}}
                                        <button type="button" style="background-color: #212529;" class="flex h-7 w-7 items-center justify-center rounded-lg text-white hover:opacity-90 transition cursor-pointer" title="Lihat Detail">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="12" cy="12" r="3" stroke-width="2"/>
                                            </svg>
                                        </button>
                                        {{-- Edit --}}
                                        <button type="button" style="background-color: #0066FF;" class="flex h-7 w-7 items-center justify-center rounded-lg text-white hover:opacity-90 transition cursor-pointer" title="Edit">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M18.5 2.5C18.8978 2.10217 19.4374 1.87868 20 1.87868C20.5626 1.87868 21.1022 2.10217 21.5 2.5C21.8978 2.89783 22.1213 3.43739 22.1213 4C22.1213 4.56261 21.8978 5.10217 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                        {{-- Delete --}}
                                        <button type="button" style="background-color: #EF4444;" class="flex h-7 w-7 items-center justify-center rounded-lg text-white hover:opacity-90 transition cursor-pointer" title="Hapus">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 6H5H21" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="18" class="text-center py-12 text-gray-400">
                                    Tidak ada data backlog yang tersedia.
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
