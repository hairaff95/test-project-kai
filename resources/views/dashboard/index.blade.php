<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Dashboard — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

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

<body
    class="min-h-screen bg-[#F6F7F9] dark:bg-[#282A2C] font-sans antialiased text-gray-900 dark:text-gray-100 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between transition-colors duration-200">

    {{-- Navbar --}}
    <x-navbar active="dashboard" />

    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-5 lg:pt-4 pb-28 lg:pb-5 flex flex-col lg:min-h-0 overflow-y-auto lg:overflow-y-hidden">

        <!-- Page Header -->
        <div class="mb-3 sm:mb-4 lg:mb-3 shrink-0">
            <h1 class="text-xl sm:text-[30px] lg:text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                Halo Admin
            </h1>
        </div>

        <!-- Dashboard Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3.5 sm:gap-4 lg:gap-3.5 lg:items-stretch">

            <!-- Kolom Kiri -->
            <div class="lg:col-span-8 flex flex-col gap-3.5 sm:gap-4 lg:gap-3.5">

                <!-- 4 Kartu Statistik -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3.5 shrink-0">

                    <!-- Kartu 1: Kontrak Aktif -->
                    <div
                        class="rounded-2xl sm:rounded-3xl bg-white dark:bg-[#1F2123] p-3 sm:p-4 lg:p-3.5 shadow-[0_2px_10px_rgba(0,0,0,0.02)] dark:shadow-none border border-gray-100/90 dark:border-white/5 flex flex-col justify-between h-[105px] sm:h-[130px] lg:h-[110px] transition hover:shadow-md dark:hover:border-white/10">
                        <div class="flex items-start justify-between">
                            <div class="flex h-7 w-7 sm:h-9 sm:w-9 lg:h-7 lg:w-7 items-center justify-center">
                                <x-icon name="ds-kontrak-aktif" class="h-7 w-7 sm:h-9 sm:w-9 lg:h-7 lg:w-7" />
                            </div>
                            <div
                                class="flex h-6 w-6 sm:h-8 sm:w-8 lg:h-6 lg:w-6 items-center justify-center rounded-xl bg-gray-50 dark:bg-white/5 hover:bg-gray-100 dark:hover:bg-white/15 text-gray-700 dark:text-white transition cursor-pointer">
                                <x-icon name="ds-icon-panah" class="h-6 w-6 sm:h-8 sm:w-8 lg:h-6 lg:w-6" />
                            </div>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white leading-tight">
                                Kontrak Aktif
                            </p>
                            <p class="text-[11px] sm:text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5 font-medium">
                                {{ $totalContracts }} kontrak
                            </p>
                        </div>
                    </div>

                    <!-- Kartu 2: Total Nilai Kontrak -->
                    <div
                        class="rounded-2xl sm:rounded-3xl bg-white dark:bg-[#1F2123] p-3 sm:p-4 lg:p-3.5 shadow-[0_2px_10px_rgba(0,0,0,0.02)] dark:shadow-none border border-gray-100/90 dark:border-white/5 flex flex-col justify-between h-[105px] sm:h-[130px] lg:h-[110px] transition hover:shadow-md dark:hover:border-white/10">
                        <div class="flex items-start justify-between">
                            <div class="flex h-7 w-7 sm:h-9 sm:w-9 lg:h-7 lg:w-7 items-center justify-center">
                                <x-icon name="ds-total-nilai-kontrak" class="h-7 w-7 sm:h-9 sm:w-9 lg:h-7 lg:w-7" />
                            </div>
                            <div
                                class="flex h-6 w-6 sm:h-8 sm:w-8 lg:h-6 lg:w-6 items-center justify-center rounded-xl bg-gray-50 dark:bg-white/5 hover:bg-gray-100 dark:hover:bg-white/15 text-gray-700 dark:text-white transition cursor-pointer">
                                <x-icon name="ds-icon-panah" class="h-6 w-6 sm:h-8 sm:w-8 lg:h-6 lg:w-6" />
                            </div>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white leading-tight">
                                Total Nilai Kontrak
                            </p>
                            <p class="text-[11px] sm:text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5 font-medium">
                                {{ $totalNilaiKontrakFormatted }}
                            </p>
                        </div>
                    </div>

                    <!-- Kartu 3: Aset Disewakan -->
                    <div
                        class="rounded-2xl sm:rounded-3xl bg-white dark:bg-[#1F2123] p-3 sm:p-4 lg:p-3.5 shadow-[0_2px_10px_rgba(0,0,0,0.02)] dark:shadow-none border border-gray-100/90 dark:border-white/5 flex flex-col justify-between h-[105px] sm:h-[130px] lg:h-[110px] transition hover:shadow-md dark:hover:border-white/10">
                        <div class="flex items-start justify-between">
                            <div class="flex h-7 w-7 sm:h-9 sm:w-9 lg:h-7 lg:w-7 items-center justify-center">
                                <x-icon name="ds-asset-disewakan" class="h-7 w-7 sm:h-9 sm:w-9 lg:h-7 lg:w-7" />
                            </div>
                            <div
                                class="flex h-6 w-6 sm:h-8 sm:w-8 lg:h-6 lg:w-6 items-center justify-center rounded-xl bg-gray-50 dark:bg-white/5 hover:bg-gray-100 dark:hover:bg-white/15 text-gray-700 dark:text-white transition cursor-pointer">
                                <x-icon name="ds-icon-panah" class="h-6 w-6 sm:h-8 sm:w-8 lg:h-6 lg:w-6" />
                            </div>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white leading-tight">
                                Aset Disewakan
                            </p>
                            <p class="text-[11px] sm:text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5 font-medium">
                                {{ $totalAssets }} Aset
                            </p>
                        </div>
                    </div>

                    <!-- Kartu 4: Rata-rata Luas Aset -->
                    <div
                        class="rounded-2xl sm:rounded-3xl bg-white dark:bg-[#1F2123] p-3 sm:p-4 lg:p-3.5 shadow-[0_2px_10px_rgba(0,0,0,0.02)] dark:shadow-none border border-gray-100/90 dark:border-white/5 flex flex-col justify-between h-[105px] sm:h-[130px] lg:h-[110px] transition hover:shadow-md dark:hover:border-white/10">
                        <div class="flex items-start justify-between">
                            <div class="flex h-7 w-7 sm:h-9 sm:w-9 lg:h-7 lg:w-7 items-center justify-center">
                                <x-icon name="ds-rata-rata-luas-aset" class="h-7 w-7 sm:h-9 sm:w-9 lg:h-7 lg:w-7" />
                            </div>
                            <div
                                class="flex h-6 w-6 sm:h-8 sm:w-8 lg:h-6 lg:w-6 items-center justify-center rounded-xl bg-gray-50 dark:bg-white/5 hover:bg-gray-100 dark:hover:bg-white/15 text-gray-700 dark:text-white transition cursor-pointer">
                                <x-icon name="ds-icon-panah" class="h-6 w-6 sm:h-8 sm:w-8 lg:h-6 lg:w-6" />
                            </div>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white leading-tight">
                                Rata-rata Luas Aset
                            </p>
                            <p class="text-[11px] sm:text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5 font-medium">
                                {{ $avgArea }} m²
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Grafik Distribusi Pendapatan & Tabel Jatuh Tempo -->
                <div
                    class="rounded-2xl sm:rounded-3xl bg-white dark:bg-[#1F2123] p-4 sm:p-5.5 lg:p-4.5 shadow-[0_2px_10px_rgba(0,0,0,0.02)] dark:shadow-none border border-gray-100/90 dark:border-white/5 flex flex-col justify-start gap-2.5 sm:gap-3 lg:gap-2.5 flex-1">
                    <div>
                        <h2 class="text-xs sm:text-base font-semibold text-gray-900 dark:text-white mb-2 lg:mb-1.5">
                            Distribusi Pendapatan Jan-Des
                        </h2>

                        <!-- Chart Container -->
                        <div class="relative h-[135px] sm:h-[155px] lg:h-[130px] xl:h-[145px] w-full mb-1">
                            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none pb-4">
                                @foreach($yGridLabels as $yLabel)
                                    <div class="flex items-center gap-2 sm:gap-2.5">
                                        <span
                                            class="w-7 sm:w-8 text-[9px] sm:text-[10px] text-gray-400 dark:text-[#787E87] text-right shrink-0">{{ $yLabel }}</span>
                                        <div class="h-px bg-gray-100 dark:bg-white/10 flex-1"></div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="absolute inset-0 pl-9 sm:pl-11 pb-4">
                                <svg viewBox="0 0 1000 200" preserveAspectRatio="none"
                                    class="w-full h-full overflow-visible">
                                    <defs>
                                        <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#1570EF" stop-opacity="0.28" />
                                            <stop offset="100%" stop-color="#1570EF" stop-opacity="0.0" />
                                        </linearGradient>
                                    </defs>

                                    <!-- Wave Light Blue -->
                                    <path d="{{ $lightWavePath }}" fill="none" stroke="#84ADFF" stroke-width="1.8"
                                        stroke-linecap="round" />

                                    <!-- Gradient Fill -->
                                    <path d="{{ $gradientFillPath }}" fill="url(#chartGradient)" />

                                    <!-- Main Primary Wave -->
                                    <path d="{{ $primaryWavePath }}" fill="none" stroke="#1570EF" stroke-width="2.3"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- Badge Puncak 1 -->
                                <div class="absolute -translate-x-1/2 -translate-y-full pointer-events-none"
                                    style="left: {{ $badge1['leftPct'] }}%; top: {{ $badge1['topPct'] }}%;">
                                    <div class="relative flex flex-col items-center">
                                        <div
                                            class="bg-[#1E293B] dark:bg-[#18202F] dark:border dark:border-[#2D3F63] text-white text-[10px] sm:text-xs font-bold px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg sm:rounded-xl shadow-lg flex items-center justify-center">
                                            {{ $badge1['label'] }}
                                        </div>
                                        <div
                                            class="w-2 sm:w-2.5 h-2 sm:h-2.5 bg-[#1E293B] dark:bg-[#18202F] rotate-45 -mt-1">
                                        </div>
                                    </div>
                                </div>

                                <!-- Badge Puncak 2 -->
                                <div class="absolute -translate-x-1/2 -translate-y-full pointer-events-none"
                                    style="left: {{ $badge2['leftPct'] }}%; top: {{ $badge2['topPct'] }}%;">
                                    <div class="relative flex flex-col items-center">
                                        <div
                                            class="bg-[#1E293B] dark:bg-[#18202F] dark:border dark:border-[#2D3F63] text-white text-[10px] sm:text-xs font-bold px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg sm:rounded-xl shadow-lg flex items-center justify-center">
                                            {{ $badge2['label'] }}
                                        </div>
                                        <div
                                            class="w-2 sm:w-2.5 h-2 sm:h-2.5 bg-[#1E293B] dark:bg-[#18202F] rotate-45 -mt-1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="absolute bottom-0 inset-x-0 pl-9 sm:pl-11 flex justify-between text-[9px] sm:text-[10px] text-gray-400 dark:text-[#787E87] font-medium">
                                <span>Jan</span>
                                <span>Feb</span>
                                <span>Mar</span>
                                <span>Apr</span>
                                <span>Mei</span>
                                <span>Jun</span>
                                <span>Jul</span>
                                <span>Agu</span>
                                <span>Sep</span>
                                <span>Okt</span>
                                <span>Nov</span>
                                <span>Des</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Jatuh Tempo Terdekat -->
                    <div
                        class="pt-2 sm:pt-2.5 border-t border-gray-100/90 dark:border-white/10 flex-1 flex flex-col justify-start">
                        <h3 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white mb-1 sm:mb-1.5">
                            Jatuh Tempo Terdekat
                        </h3>

                        <div class="overflow-x-auto no-scrollbar">
                            <table class="w-full text-left text-[10px] sm:text-xs min-w-full">
                                <thead>
                                    <tr
                                        class="text-gray-400 dark:text-[#787E87] font-normal border-b border-gray-100 dark:border-white/10 whitespace-nowrap">
                                        <th class="pb-1.5 pr-2 font-normal">Jenis Kontrak</th>
                                        <th class="pb-1.5 px-2 font-normal">Nama</th>
                                        <th class="pb-1.5 px-2 font-normal">Jatuh Tempo</th>
                                        <th class="pb-1.5 pl-2 font-normal text-right">Sisa</th>
                                    </tr>
                                </thead>
                                <tbody id="jatuh-tempo-tbody" class="divide-y divide-gray-100 dark:divide-white/10">
                                    @forelse($upcomingContracts as $uc)
                                        <tr class="jatuh-tempo-row whitespace-nowrap">
                                            <td
                                                class="py-1 sm:py-1.5 pr-2 font-semibold text-gray-900 dark:text-white truncate max-w-[130px]">
                                                {{ $uc['jenis_kontrak'] }}
                                            </td>
                                            <td
                                                class="py-1 sm:py-1.5 px-2 text-gray-700 dark:text-gray-300 truncate max-w-[150px]">
                                                {{ $uc['nama'] }}
                                            </td>
                                            <td class="py-1 sm:py-1.5 px-2 text-gray-700 dark:text-gray-300">
                                                {{ $uc['jatuh_tempo'] }}
                                            </td>
                                            <td class="py-1 sm:py-1.5 pl-2 text-right">
                                                <span
                                                    class="inline-block whitespace-nowrap rounded-md bg-[#FFF4E5] dark:bg-[#E5A866] px-1.5 sm:px-2.5 py-0.5 text-[9px] sm:text-xs font-semibold text-[#F79009] dark:text-[#1F2123]">
                                                    {{ $uc['sisa'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-3 text-center text-gray-400 text-xs">Belum ada kontrak
                                                yang terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Jatuh Tempo -->
                        <div id="jatuh-tempo-pagination"
                            class="flex items-center justify-between mt-1.5 pt-1.5 border-t border-gray-100/90 dark:border-white/10">
                            <span id="jatuh-tempo-info" class="text-[10px] text-gray-400 dark:text-[#787E87]"></span>
                            <div class="flex items-center gap-1">
                                <button id="jatuh-tempo-prev" onclick="jtPaginate(-1)"
                                    class="flex items-center justify-center h-5 w-5 rounded-md bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-white/20 disabled:opacity-30 disabled:cursor-not-allowed transition cursor-pointer">
                                    <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button id="jatuh-tempo-next" onclick="jtPaginate(1)"
                                    class="flex items-center justify-center h-5 w-5 rounded-md bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-white/20 disabled:opacity-30 disabled:cursor-not-allowed transition cursor-pointer">
                                    <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Kolom Kanan -->
            <div class="lg:col-span-4 flex flex-col gap-3.5 sm:gap-4 lg:gap-3.5">

                <!-- Distribusi Jenis Pendapatan -->
                <div
                    class="rounded-2xl sm:rounded-3xl bg-white dark:bg-[#1F2123] p-4 sm:p-5.5 lg:p-4.5 shadow-[0_2px_10px_rgba(0,0,0,0.02)] dark:shadow-none border border-gray-100/90 dark:border-white/5 shrink-0">

                    <div class="flex items-center justify-between mb-2.5 sm:mb-3.5">
                        <h2 class="text-xs sm:text-base font-semibold text-gray-950 dark:text-white">
                            Distribusi Jenis Pendapatan
                        </h2>

                        <!-- Dropdown Menu dengan Popup Lihat -->
                        <div class="relative">
                            <button type="button" id="btn-dropdown-toggle" onclick="toggleDropdownLihat(event)"
                                class="flex h-7 w-7 sm:h-[32px] sm:w-[32px] items-center justify-center rounded-[8px] sm:rounded-[10px] bg-[#F5F5F7] dark:bg-[#2D3034] text-gray-600 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-[#3E4247] transition cursor-pointer shadow-xs"
                                title="Menu">
                                <x-icon name="dots-vertical" class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                            </button>

                            <a id="popup-dropdown-lihat" href="{{ route('laporan.index') }}"
                                class="hidden absolute right-0 top-full mt-1.5 w-[100px] h-[56px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 shadow-[0_6px_24px_rgba(0,0,0,0.15)] dark:shadow-[0_6px_24px_rgba(0,0,0,0.6)] rounded-[10px] items-center justify-center gap-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-[#3E4247] active:scale-95 transition z-30 select-none text-[#1C204F] dark:text-white">
                                <x-icon name="icon-lihat" class="w-[20px] h-[20px] text-[#1C204F] dark:text-gray-200" />
                                <span class="text-[14px] font-semibold text-[#1C204F] dark:text-white">Lihat</span>
                            </a>
                        </div>
                    </div>

                    <!-- Diagram Batang -->
                    <div class="flex items-stretch gap-1 mb-3 sm:mb-4 h-[55px] sm:h-[70px]">
                        @foreach($revenueBreakdown as $rb)
                            <div class="flex flex-col justify-between" style="width: {{ $rb['percentage'] }}%;">
                                <span
                                    class="text-xs sm:text-base font-bold text-gray-950 dark:text-white leading-none">{{ $rb['percentage'] }}%</span>
                                <div class="flex-1 w-px bg-gray-200 dark:bg-white/15 my-1 sm:my-1.5"></div>
                                <div class="h-1 sm:h-1.5 rounded-xs w-full" style="background-color: {{ $rb['color'] }};">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Tabel Distribusi -->
                    <div>
                        <div
                            class="flex justify-between items-center px-1 text-[10px] sm:text-xs text-[#7E8B9B] dark:text-[#787E87] font-medium mb-2 pb-1 border-b border-gray-50 dark:border-white/5">
                            <span>Jenis Pendapatan</span>
                            <span>Persentase Pencapaian</span>
                        </div>

                        <div class="space-y-2 sm:space-y-2.5 px-1 pt-0.5">
                            @foreach($revenueBreakdown as $rb)
                                <div class="flex items-center justify-between text-[11px] sm:text-sm">
                                    <span
                                        class="font-semibold text-gray-950 dark:text-white flex items-center gap-2 sm:gap-2.5">
                                        <span class="h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full shrink-0"
                                            style="background-color: {{ $rb['color'] }};"></span>
                                        {{ $rb['name'] }}
                                    </span>
                                    <span class="font-medium text-[#10B981]">{{ $rb['pencapaian'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <!-- Pencapaian RKA (Donut & Stat Buttons) -->
                <div
                    class="rounded-2xl sm:rounded-3xl bg-gradient-to-b from-[#659DF8] via-[#2F7EF8] to-[#0062F5] p-4 sm:p-5 lg:p-4.5 xl:p-6 text-white shadow-[0_4px_20px_rgba(21,112,239,0.2)] flex flex-col justify-between relative flex-1">

                    <div class="flex items-center justify-between mb-2.5 sm:mb-3 relative z-30">
                        <h2 class="text-xs sm:text-base font-semibold text-white tracking-normal">
                            Pencapaian RKA
                        </h2>

                        <!-- Dropdown Menu dengan Popup Lihat (RKA) -->
                        <div class="relative">
                            <button type="button" id="btn-dropdown-rka-toggle" onclick="toggleDropdownRka(event)"
                                class="flex h-7 w-7 sm:h-[32px] sm:w-[32px] items-center justify-center rounded-[8px] sm:rounded-[10px] bg-[#6697E7] hover:bg-[#5889d8] text-white transition cursor-pointer shadow-xs"
                                title="Menu">
                                <x-icon name="dots-vertical" class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                            </button>

                            <a id="popup-dropdown-rka" href="{{ route('backlog.index') }}"
                                class="hidden absolute right-0 top-full mt-1.5 w-[100px] h-[56px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 shadow-[0_6px_24px_rgba(0,0,0,0.18)] dark:shadow-[0_6px_24px_rgba(0,0,0,0.6)] rounded-[10px] items-center justify-center gap-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-[#3E4247] active:scale-95 transition z-40 select-none text-gray-900 dark:text-white">
                                <x-icon name="icon-lihat" class="w-[20px] h-[20px] text-[#1C204F] dark:text-gray-200" />
                                <span class="text-[14px] font-semibold text-[#1C204F] dark:text-white">Lihat</span>
                            </a>
                        </div>
                    </div>

                    <div
                        class="flex flex-col sm:flex-row items-center justify-start gap-3 sm:gap-3.5 lg:gap-2.5 xl:gap-3.5 my-auto w-full">

                        <!-- Donut Chart -->
                        <div
                            class="relative flex h-[140px] w-[140px] sm:h-[160px] sm:w-[160px] lg:h-[150px] lg:w-[150px] xl:h-[185px] xl:w-[185px] 2xl:h-[200px] 2xl:w-[200px] shrink-0 items-center justify-center">
                            <svg viewBox="0 0 100 100" class="h-full w-full overflow-visible">
                                <path id="donut-arc-top" d="M 12 50 A 38 38 0 0 1 88 50" fill="none" stroke="#FFFFFF"
                                    stroke-width="11" class="transition-colors duration-300" />
                                <path id="donut-arc-bottom" d="M 88 50 A 38 38 0 0 1 12 50" fill="none"
                                    stroke="rgba(255, 255, 255, 0.4)" stroke-width="11"
                                    class="transition-colors duration-300" />
                            </svg>

                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <span id="donut-percentage"
                                    class="text-[20px] sm:text-[24px] lg:text-[22px] xl:text-[26px] 2xl:text-[28px] font-semibold tracking-normal text-white transition-all duration-300">
                                    {{ $rkaPercentage }}%
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Statistik -->
                        <div
                            class="flex flex-col gap-2 sm:gap-2.5 lg:gap-2 xl:gap-2.5 w-full sm:flex-1 lg:flex-1 min-w-0">

                            <button type="button" id="btn-stat-blacklog" onclick="switchDonutStat('blacklog')"
                                class="w-full rounded-xl sm:rounded-2xl border-1.5 border-white bg-white/15 p-2.5 sm:px-3 sm:py-2.5 lg:px-2.5 lg:py-2 xl:px-3.5 xl:py-2.5 text-left transition-all duration-200 shadow-sm cursor-pointer hover:bg-white/25 active:scale-[0.98]">
                                <p
                                    class="text-[11px] sm:text-[12px] lg:text-[11px] xl:text-[13px] font-medium text-white flex items-center gap-1.5 leading-snug whitespace-nowrap">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white shrink-0"></span>
                                    Total Backlog
                                </p>
                                <p
                                    class="text-xs sm:text-[13px] lg:text-[12px] xl:text-[14px] font-normal text-white/90 mt-0.5 pl-2.5 xl:pl-3">
                                    {{ $totalBacklogFormatted }}
                                </p>
                            </button>

                            <button type="button" id="btn-stat-pendapatan" onclick="switchDonutStat('pendapatan')"
                                class="w-full rounded-xl sm:rounded-2xl border border-white/60 bg-transparent p-2.5 sm:px-3 sm:py-2.5 lg:px-2.5 lg:py-2 xl:px-3.5 xl:py-2.5 text-left transition-all duration-200 cursor-pointer hover:bg-white/15 active:scale-[0.98] opacity-85 hover:opacity-100">
                                <p
                                    class="text-[11px] sm:text-[12px] lg:text-[11px] xl:text-[13px] font-medium text-white flex items-center gap-1.5 leading-snug whitespace-nowrap">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white shrink-0"></span>
                                    Pendapatan 2026
                                </p>
                                <p
                                    class="text-xs sm:text-[13px] lg:text-[12px] xl:text-[14px] font-normal text-white/90 mt-0.5 pl-2.5 xl:pl-3">
                                    {{ $totalPendapatanFormatted }}
                                </p>
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <script>
        // ── Pagination Jatuh Tempo Terdekat ──────────────────────────────
        (function () {
            const PER_PAGE = 3;
            let currentPage = 1;

            const rows = Array.from(document.querySelectorAll('.jatuh-tempo-row'));
            const totalPages = Math.ceil(rows.length / PER_PAGE);

            const prevBtn = document.getElementById('jatuh-tempo-prev');
            const nextBtn = document.getElementById('jatuh-tempo-next');
            const info = document.getElementById('jatuh-tempo-info');
            const paginationEl = document.getElementById('jatuh-tempo-pagination');

            // Sembunyikan pagination kalau data <= PER_PAGE
            if (rows.length <= PER_PAGE) {
                if (paginationEl) paginationEl.style.display = 'none';
                return;
            }

            function render() {
                const start = (currentPage - 1) * PER_PAGE;
                const end = start + PER_PAGE;

                rows.forEach(function (row, idx) {
                    row.style.display = (idx >= start && idx < end) ? '' : 'none';
                });

                if (info) info.textContent = currentPage + ' / ' + totalPages;
                if (prevBtn) prevBtn.disabled = currentPage === 1;
                if (nextBtn) nextBtn.disabled = currentPage === totalPages;
            }

            window.jtPaginate = function (dir) {
                currentPage = Math.max(1, Math.min(totalPages, currentPage + dir));
                render();
            };

            render();
        })();

        function toggleDropdownLihat(event) {
            event.stopPropagation();
            const popup = document.getElementById('popup-dropdown-lihat');
            const popupRka = document.getElementById('popup-dropdown-rka');
            if (popupRka) {
                popupRka.classList.remove('flex');
                popupRka.classList.add('hidden');
            }
            if (popup) {
                if (popup.classList.contains('hidden')) {
                    popup.classList.remove('hidden');
                    popup.classList.add('flex');
                } else {
                    popup.classList.remove('flex');
                    popup.classList.add('hidden');
                }
            }
        }

        function handleClickLihat() {
            const popup = document.getElementById('popup-dropdown-lihat');
            if (popup) {
                popup.classList.remove('flex');
                popup.classList.add('hidden');
            }
        }

        function toggleDropdownRka(event) {
            event.stopPropagation();
            const popupRka = document.getElementById('popup-dropdown-rka');
            const popup = document.getElementById('popup-dropdown-lihat');
            if (popup) {
                popup.classList.remove('flex');
                popup.classList.add('hidden');
            }
            if (popupRka) {
                if (popupRka.classList.contains('hidden')) {
                    popup.classList.remove('hidden');
                    popup.classList.add('flex');
                } else {
                    popupRka.classList.remove('flex');
                    popupRka.classList.add('hidden');
                }
            }
        }

        function handleClickLihatRka() {
            const popupRka = document.getElementById('popup-dropdown-rka');
            if (popupRka) {
                popupRka.classList.remove('flex');
                popupRka.classList.add('hidden');
            }
        }

        document.addEventListener('click', function (e) {
            const popup = document.getElementById('popup-dropdown-lihat');
            const btn = document.getElementById('btn-dropdown-toggle');
            if (popup && !popup.contains(e.target) && btn && !btn.contains(e.target)) {
                popup.classList.remove('flex');
                popup.classList.add('hidden');
            }

            const popupRka = document.getElementById('popup-dropdown-rka');
            const btnRka = document.getElementById('btn-dropdown-rka-toggle');
            if (popupRka && !popupRka.contains(e.target) && btnRka && !btnRka.contains(e.target)) {
                popupRka.classList.remove('flex');
                popupRka.classList.add('hidden');
            }
        });

        function switchDonutStat(type) {
            const arcTop = document.getElementById('donut-arc-top');
            const arcBottom = document.getElementById('donut-arc-bottom');
            const percentageText = document.getElementById('donut-percentage');
            const btnBlacklog = document.getElementById('btn-stat-blacklog');
            const btnPendapatan = document.getElementById('btn-stat-pendapatan');
            const rkaPct = {{ $rkaPercentage }};
            const invPct = {{ 100 - $rkaPercentage }};

            const activeClasses = ['border-1.5', 'border-white', 'bg-white/15', 'shadow-sm', 'hover:bg-white/25'];
            const inactiveClasses = ['border', 'border-white/60', 'bg-transparent', 'opacity-85', 'hover:opacity-100', 'hover:bg-white/15'];

            function setGroupButtonState(activeBtn, inactiveBtn) {
                activeClasses.forEach(cls => {
                    activeBtn.classList.add(cls);
                    inactiveBtn.classList.remove(cls);
                });
                inactiveClasses.forEach(cls => {
                    activeBtn.classList.remove(cls);
                    inactiveBtn.classList.add(cls);
                });
            }

            if (type === 'blacklog') {
                arcTop.setAttribute('stroke', '#FFFFFF');
                arcBottom.setAttribute('stroke', 'rgba(255, 255, 255, 0.4)');
                percentageText.innerText = rkaPct + '%';
                setGroupButtonState(btnBlacklog, btnPendapatan);
            } else {
                arcBottom.setAttribute('stroke', '#FFFFFF');
                arcTop.setAttribute('stroke', 'rgba(255, 255, 255, 0.4)');
                percentageText.innerText = invPct + '%';
                setGroupButtonState(btnPendapatan, btnBlacklog);
            }
        }
    </script>
</body>

</html>