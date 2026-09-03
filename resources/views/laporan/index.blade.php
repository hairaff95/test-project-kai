<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Laporan — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Anti-FOUC Theme Script -->
    <script>
        if (localStorage.getItem('kai_theme') === 'dark' || (!('kai_theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-[#F6F7F9] dark:bg-[#282A2C] font-sans antialiased text-gray-900 dark:text-gray-100 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between transition-colors duration-200">

    {{-- Top Navbar --}}
    <x-navbar active="reports" />

    {{-- Main Content --}}
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-6 pb-28 lg:pb-8 flex flex-col gap-4 sm:gap-5">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0">
            <h1 class="text-2xl sm:text-[30px] font-bold tracking-tight text-gray-950 dark:text-white">
                Laporan
            </h1>

            {{-- Header Action Buttons --}}
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <button id="btn-filter-lap" type="button" class="flex items-center gap-1.5 sm:gap-2 rounded-lg lg:rounded-[10px] bg-[#0066FF] hover:bg-blue-700 px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow-xs transition cursor-pointer">
                    <x-icon name="filter-icon" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" />
                    <span>Filter</span>
                </button>

                <a href="{{ route('laporan.index') }}" class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-lg lg:rounded-[10px] border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] hover:bg-gray-50 dark:hover:bg-white/10 text-gray-700 dark:text-white shadow-xs transition cursor-pointer" title="Reset">
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
                            id="search-lap"
                            type="text"
                            placeholder="Search"
                            class="w-full h-full pl-8 sm:pl-9 pr-3 py-1 text-xs sm:text-sm bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 rounded-lg lg:rounded-[10px] focus:outline-none focus:border-[#0066FF] text-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 transition"
                        >
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

            {{-- MOBILE CARD LIST VIEW (sm:hidden - Mobile-First UX Konsisten dengan Halaman Lain) --}}
            <div id="mobile-cards-lap" class="sm:hidden flex flex-col gap-3">
                @forelse($items as $row)
                    <div class="lap-card-item rounded-xl border border-gray-200/90 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3.5 shadow-2xs flex flex-col gap-2.5 transition-colors"
                         data-search="{{ strtolower($row['asset_number'] . ' ' . $row['form_rka'] . ' ' . $row['tahun_rka'] . ' ' . $row['akun_gl']) }}"
                    >
                        {{-- Card Header: No Aset / Kontrak + Akun GL Badge --}}
                        <div class="flex items-start justify-between gap-2 border-b border-gray-100 dark:border-white/10 pb-2">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-gray-400 dark:text-[#9AA0A6] uppercase tracking-wider">No Aset / Kontrak</span>
                                <span class="text-xs font-bold text-gray-900 dark:text-white leading-snug">{{ $row['asset_number'] }}</span>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6] border border-blue-200/60 dark:border-blue-800">
                                Akun GL: {{ $row['akun_gl'] }}
                            </span>
                        </div>

                        {{-- RKA Info --}}
                        <div class="flex items-center justify-between text-xs">
                            <div>
                                <span class="text-[10px] text-gray-400 dark:text-[#9AA0A6] block">Form RKA</span>
                                <span class="font-semibold text-gray-900 dark:text-white text-xs">{{ $row['form_rka'] }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] text-gray-400 dark:text-[#9AA0A6] block">Tahun RKA</span>
                                <span class="font-semibold text-gray-900 dark:text-white text-xs">{{ $row['tahun_rka'] }}</span>
                            </div>
                        </div>

                        {{-- 12-Month Financial Breakdown Grid --}}
                        <div class="bg-gray-50/90 dark:bg-[#2D3034] rounded-lg p-2.5">
                            <span class="text-[10px] font-semibold text-gray-400 dark:text-[#9AA0A6] uppercase tracking-wider block mb-1.5">Rincian Pendapatan Bulanan</span>
                            <div class="grid grid-cols-3 gap-2 text-xs">
                                <div>
                                    <span class="text-gray-400 dark:text-[#9AA0A6] block text-[9.5px]">Januari</span>
                                    <span class="font-medium text-gray-900 dark:text-white text-[11px]">{{ $row['januari'] }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 dark:text-[#9AA0A6] block text-[9.5px]">Februari</span>
                                    <span class="font-medium text-gray-900 dark:text-white text-[11px]">{{ $row['februari'] }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 dark:text-[#9AA0A6] block text-[9.5px]">Maret</span>
                                    <span class="font-medium text-gray-900 dark:text-white text-[11px]">{{ $row['maret'] }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 dark:text-[#9AA0A6] block text-[9.5px]">April</span>
                                    <span class="font-medium text-gray-900 dark:text-white text-[11px]">{{ $row['april'] }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 dark:text-[#9AA0A6] block text-[9.5px]">Mei</span>
                                    <span class="font-medium text-gray-900 dark:text-white text-[11px]">{{ $row['mei'] }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 dark:text-[#9AA0A6] block text-[9.5px]">Juni</span>
                                    <span class="font-medium text-gray-900 dark:text-white text-[11px]">{{ $row['juni'] }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 dark:text-[#9AA0A6] block text-[9.5px]">Juli</span>
                                    <span class="font-medium text-gray-900 dark:text-white text-[11px]">{{ $row['juli'] }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 dark:text-[#9AA0A6] block text-[9.5px]">Agustus</span>
                                    <span class="font-medium text-gray-900 dark:text-white text-[11px]">{{ $row['agustus'] }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 dark:text-[#9AA0A6] block text-[9.5px]">September</span>
                                    <span class="font-medium text-gray-900 dark:text-white text-[11px]">{{ $row['september'] }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 dark:text-[#9AA0A6] block text-[9.5px]">Oktober</span>
                                    <span class="font-medium text-gray-900 dark:text-white text-[11px]">{{ $row['oktober'] }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 dark:text-[#9AA0A6] block text-[9.5px]">November</span>
                                    <span class="font-medium text-gray-900 dark:text-white text-[11px]">{{ $row['november'] }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 dark:text-[#9AA0A6] block text-[9.5px]">Desember</span>
                                    <span class="font-medium text-gray-900 dark:text-white text-[11px]">{{ $row['desember'] }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Card Actions Footer (Thumb-friendly buttons) --}}
                        <div class="flex items-center justify-end gap-2 pt-1 border-t border-gray-100 dark:border-white/10">
                            <a href="{{ route('asset.detail', $row['asset_number']) }}" class="flex-1 min-h-[40px] inline-flex items-center justify-center gap-1.5 rounded-lg lg:rounded-[10px] border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] hover:bg-gray-50 dark:hover:bg-white/10 text-xs font-semibold text-gray-700 dark:text-white shadow-2xs transition">
                                <x-icon name="icon-lihat" class="w-4 h-4 text-gray-500 dark:text-white" />
                                <span>Lihat Detail</span>
                            </a>
                            @auth
                            <a href="{{ route('laporan.edit', $row['asset_number']) }}" class="flex-1 min-h-[40px] inline-flex items-center justify-center gap-1.5 rounded-lg lg:rounded-[10px] bg-[#0066FF] hover:bg-blue-700 text-xs font-semibold text-white shadow-2xs transition">
                                <x-icon name="icon-edit-detail-peta" class="w-4 h-4 text-white" />
                                <span>Edit</span>
                            </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-gray-400 dark:text-[#9AA0A6] bg-gray-50 dark:bg-[#2D3034] rounded-xl">
                        Tidak ada data laporan yang tersedia.
                    </div>
                @endforelse
            </div>

            {{-- DESKTOP TABLE VIEW (hidden sm:block) --}}
            <div class="hidden sm:block border border-gray-200 dark:border-white/10 rounded-xl overflow-hidden bg-white dark:bg-[#1F2123]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F8F9FA] dark:bg-[#282A2C] border-b border-gray-200 dark:border-white/10">
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">No Kontrak</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">No Aset</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Januari</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Februari</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Maret</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">April</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Mei</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Juni</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Juli</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Agustus</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">September</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Oktober</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">November</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Desember</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Jan-Des</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Jenis Pendapatan</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Pencapaian</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Form RKA</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Tahun RKA</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap">Akun GL</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-lap" class="divide-y divide-gray-100 dark:divide-white/10 text-xs sm:text-[13px] text-gray-800 dark:text-gray-200">
                            @forelse($items as $row)
                                <tr class="lap-row-item hover:bg-gray-50/60 dark:hover:bg-white/5 transition-colors">
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['contract_number'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['asset_number'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['januari'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['februari'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['maret'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['april'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['mei'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['juni'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['juli'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['agustus'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['september'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['oktober'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['november'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['desember'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['jan_des'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 text-gray-700 dark:text-gray-300 whitespace-nowrap font-normal">
                                        {{ $row['jenis_pendapatan'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 text-gray-700 dark:text-gray-300 whitespace-nowrap font-normal">
                                        {{ $row['pencapaian'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 text-gray-700 dark:text-gray-300 whitespace-nowrap font-normal">
                                        {{ $row['form_rka'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 text-gray-700 dark:text-gray-300 whitespace-nowrap font-normal">
                                        {{ $row['tahun_rka'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 text-gray-700 dark:text-gray-300 whitespace-nowrap font-normal">
                                        {{ $row['akun_gl'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 whitespace-nowrap text-center">
                                        <div class="relative inline-block text-left action-menu-wrapper"
                                             data-contract="{{ $row['contract_number'] }}">
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
                                    <td colspan="18" class="text-center py-8 text-gray-400 dark:text-[#9AA0A6]">
                                        Tidak ada data laporan yang tersedia.
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

    {{-- Global Dropdown Menu Aksi (Diperbesar 1.5x) --}}
    <div id="global-action-dropdown" class="hidden fixed z-[9999] w-[155px] sm:w-[165px] rounded-2xl bg-white dark:bg-[#1F2123] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.7)] p-2 sm:p-2.5 flex flex-col gap-1">
        <a id="dd-lihat" href="#" class="flex items-center gap-2.5 px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-xl transition">
            <x-icon name="icon-lihat" class="w-5 h-5 text-gray-500 dark:text-gray-300 shrink-0" />
            <span>Lihat</span>
        </a>
        @auth
        <a id="dd-edit" href="#" class="flex items-center gap-2.5 px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-xl transition">
            <x-icon name="edit" class="w-5 h-5 text-gray-500 dark:text-gray-300 shrink-0" />
            <span>Edit</span>
        </a>
        <form id="dd-delete-form" method="POST" onsubmit="event.preventDefault(); return window.confirmDelete(this, 'Apakah Anda yakin ingin menghapus data laporan aset ini?');">
            @csrf @method('DELETE')
            <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 text-xs sm:text-sm font-semibold text-[#EF4444] hover:bg-red-50 dark:hover:bg-red-950/30 rounded-xl transition cursor-pointer">
                <x-icon name="delete" class="w-5 h-5 text-[#EF4444] shrink-0" />
                <span>Hapus</span>
            </button>
        </form>
        @endauth
    </div>

    <script>
        (function () {
            // Live Search Filter for Desktop Table Rows & Mobile Cards
            const searchInput = document.getElementById('search-lap');
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    const query = this.value.toLowerCase().trim();

                    // Filter Desktop Table Rows
                    const rows = document.querySelectorAll('.lap-row-item');
                    rows.forEach(row => {
                        const text = row.innerText.toLowerCase();
                        row.style.display = (!query || text.includes(query)) ? '' : 'none';
                    });

                    // Filter Mobile Cards
                    const cards = document.querySelectorAll('.lap-card-item');
                    cards.forEach(card => {
                        const text = (card.dataset.search || card.innerText).toLowerCase();
                        card.style.display = (!query || text.includes(query)) ? '' : 'none';
                    });
                });
            }

            const dropdown     = document.getElementById('global-action-dropdown');
            const ddLihat      = document.getElementById('dd-lihat');
            const ddEdit       = document.getElementById('dd-edit');
            const ddDeleteForm = document.getElementById('dd-delete-form');

            const routes = {};

            @foreach($items as $row)
            routes['detail_{{ $row['contract_number'] }}'] = '{{ route('asset.detail', $row['contract_number']) }}';
            routes['edit_{{ $row['contract_number'] }}']   = '{{ route('laporan.edit', $row['contract_number']) }}';
            routes['delete_{{ $row['contract_number'] }}'] = '{{ route('admin.assets.destroy', $row['contract_number']) }}';
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
                    if (ddEdit) ddEdit.href = routes[`edit_${contractId}`] || `/laporan/${encodeURIComponent(contractId)}/edit`;
                    if (ddDeleteForm) ddDeleteForm.action = routes[`delete_${contractId}`] || `/admin/assets/${encodeURIComponent(contractId)}`;

                    if (!dropdown.classList.contains('hidden') && dropdown.dataset.open === contractId) {
                        dropdown.classList.add('hidden');
                        dropdown.dataset.open = '';
                        return;
                    }

                    dropdown.style.top    = top + 'px';
                    dropdown.style.left   = left + 'px';
                    dropdown.dataset.open = contractId;
                    dropdown.classList.remove('hidden');
                } else if (!e.target.closest('#global-action-dropdown')) {
                    if (dropdown) {
                        dropdown.classList.add('hidden');
                        dropdown.dataset.open = '';
                    }
                }
            });

            document.addEventListener('scroll', function (e) {
                if (e.target && e.target.closest && e.target.closest('#global-action-dropdown')) {
                    return;
                }
                dropdown.classList.add('hidden');
                dropdown.dataset.open = '';
            }, true);
        })();
    </script>

</body>

</html>
