<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Dashboard — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen lg:h-screen lg:overflow-hidden bg-[#F6F7F9] font-sans antialiased text-gray-900 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between">

    {{-- Navbar --}}
    <x-navbar active="dashboard" />

    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-5 pb-28 lg:pb-5 flex flex-col lg:justify-between lg:min-h-0">

        <!-- Page Header -->
        <div class="mb-3 sm:mb-4 lg:mb-3 shrink-0">
            <h1 class="text-xl sm:text-[30px] font-bold tracking-tight text-gray-950">
                Halo Admin
            </h1>
        </div>

        <!-- Dashboard Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3.5 sm:gap-4 lg:gap-3.5 items-stretch lg:flex-1 lg:min-h-0">

            <!-- Kolom Kiri -->
            <div class="lg:col-span-8 flex flex-col gap-3.5 sm:gap-4 lg:gap-3.5 lg:min-h-0">

                <!-- 4 Kartu Statistik -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3.5 shrink-0">

                    <!-- Kartu 1: Kontrak Aktif -->
                    <div class="rounded-2xl sm:rounded-3xl bg-white p-3 sm:p-4 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col justify-between h-[105px] sm:h-[130px] transition hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div class="flex h-7 w-7 sm:h-9 sm:w-9 items-center justify-center">
                                <x-icon name="ds-kontrak-aktif" class="h-7 w-7 sm:h-9 sm:w-9" />
                            </div>
                            <div class="flex h-6 w-6 sm:h-8 sm:w-8 items-center justify-center rounded-xl bg-transparent text-gray-700 transition hover:bg-gray-100">
                                <x-icon name="ds-icon-panah" class="h-6 w-6 sm:h-8 sm:w-8" />
                            </div>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 leading-tight">
                                Kontrak Aktif
                            </p>
                            <p class="text-[11px] sm:text-xs text-gray-400 mt-0.5 font-medium">
                                100 kontrak
                            </p>
                        </div>
                    </div>

                    <!-- Kartu 2: Total Nilai Kontrak -->
                    <div class="rounded-2xl sm:rounded-3xl bg-white p-3 sm:p-4 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col justify-between h-[105px] sm:h-[130px] transition hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div class="flex h-7 w-7 sm:h-9 sm:w-9 items-center justify-center">
                                <x-icon name="ds-total-nilai-kontrak" class="h-7 w-7 sm:h-9 sm:w-9" />
                            </div>
                            <div class="flex h-6 w-6 sm:h-8 sm:w-8 items-center justify-center rounded-xl bg-transparent text-gray-700 transition hover:bg-gray-100">
                                <x-icon name="ds-icon-panah" class="h-6 w-6 sm:h-8 sm:w-8" />
                            </div>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 leading-tight">
                                Total Nilai Kontrak
                            </p>
                            <p class="text-[11px] sm:text-xs text-gray-400 mt-0.5 font-medium">
                                Rp 1.5 M
                            </p>
                        </div>
                    </div>

                    <!-- Kartu 3: Aset Disewakan -->
                    <div class="rounded-2xl sm:rounded-3xl bg-white p-3 sm:p-4 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col justify-between h-[105px] sm:h-[130px] transition hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div class="flex h-7 w-7 sm:h-9 sm:w-9 items-center justify-center">
                                <x-icon name="ds-asset-disewakan" class="h-7 w-7 sm:h-9 sm:w-9" />
                            </div>
                            <div class="flex h-6 w-6 sm:h-8 sm:w-8 items-center justify-center rounded-xl bg-transparent text-gray-700 transition hover:bg-gray-100">
                                <x-icon name="ds-icon-panah" class="h-6 w-6 sm:h-8 sm:w-8" />
                            </div>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 leading-tight">
                                Aset Disewakan
                            </p>
                            <p class="text-[11px] sm:text-xs text-gray-400 mt-0.5 font-medium">
                                300 Aset
                            </p>
                        </div>
                    </div>

                    <!-- Kartu 4: Rata-rata Luas Aset -->
                    <div class="rounded-2xl sm:rounded-3xl bg-white p-3 sm:p-4 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col justify-between h-[105px] sm:h-[130px] transition hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div class="flex h-7 w-7 sm:h-9 sm:w-9 items-center justify-center">
                                <x-icon name="ds-rata-rata-luas-aset" class="h-7 w-7 sm:h-9 sm:w-9" />
                            </div>
                            <div class="flex h-6 w-6 sm:h-8 sm:w-8 items-center justify-center rounded-xl bg-transparent text-gray-700 transition hover:bg-gray-100">
                                <x-icon name="ds-icon-panah" class="h-6 w-6 sm:h-8 sm:w-8" />
                            </div>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-gray-900 leading-tight">
                                Rata-rata Luas Aset
                            </p>
                            <p class="text-[11px] sm:text-xs text-gray-400 mt-0.5 font-medium">
                                2000 m²
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Grafik Distribusi Pendapatan & Tabel Jatuh Tempo -->
                <div class="rounded-2xl sm:rounded-3xl bg-white p-4 sm:p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col justify-between lg:flex-1 lg:min-h-0">
                    <div>
                        <h2 class="text-xs sm:text-base font-semibold text-gray-900 mb-2.5 sm:mb-3">
                            Distribusi Pendapatan Jan-Des
                        </h2>

                        <!-- Chart Container -->
                        <div class="relative h-[150px] sm:h-[190px] lg:h-[155px] xl:h-[170px] w-full mb-2">
                            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none pb-4">
                                <div class="flex items-center gap-2 sm:gap-2.5">
                                    <span class="w-7 sm:w-8 text-[9px] sm:text-[10px] text-gray-400 text-right shrink-0">1M</span>
                                    <div class="h-px bg-gray-100 flex-1"></div>
                                </div>
                                <div class="flex items-center gap-2 sm:gap-2.5">
                                    <span class="w-7 sm:w-8 text-[9px] sm:text-[10px] text-gray-400 text-right shrink-0">900jt</span>
                                    <div class="h-px bg-gray-100 flex-1"></div>
                                </div>
                                <div class="flex items-center gap-2 sm:gap-2.5">
                                    <span class="w-7 sm:w-8 text-[9px] sm:text-[10px] text-gray-400 text-right shrink-0">800jt</span>
                                    <div class="h-px bg-gray-100 flex-1"></div>
                                </div>
                                <div class="flex items-center gap-2 sm:gap-2.5">
                                    <span class="w-7 sm:w-8 text-[9px] sm:text-[10px] text-gray-400 text-right shrink-0">700jt</span>
                                    <div class="h-px bg-gray-100 flex-1"></div>
                                </div>
                                <div class="flex items-center gap-2 sm:gap-2.5">
                                    <span class="w-7 sm:w-8 text-[9px] sm:text-[10px] text-gray-400 text-right shrink-0">600jt</span>
                                    <div class="h-px bg-gray-100 flex-1"></div>
                                </div>
                                <div class="flex items-center gap-2 sm:gap-2.5">
                                    <span class="w-7 sm:w-8 text-[9px] sm:text-[10px] text-gray-400 text-right shrink-0">500jt</span>
                                    <div class="h-px bg-gray-100 flex-1"></div>
                                </div>
                            </div>

                            <div class="absolute inset-0 pl-9 sm:pl-11 pb-4">
                                <svg viewBox="0 0 1000 200" preserveAspectRatio="none" class="w-full h-full overflow-visible">
                                    <defs>
                                        <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#1570EF" stop-opacity="0.22"/>
                                            <stop offset="100%" stop-color="#1570EF" stop-opacity="0.0"/>
                                        </linearGradient>
                                    </defs>

                                    <!-- Wave Light Blue -->
                                    <path
                                        d="M 0,110 C 80,120 140,150 220,140 C 300,130 350,90 430,115 C 500,135 580,125 660,75 C 750,45 830,110 920,100 L 1000,95"
                                        fill="none"
                                        stroke="#84ADFF"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                    />

                                    <!-- Gradient Fill -->
                                    <path
                                        d="M 0,190 C 60,150 110,105 180,105 C 260,105 290,175 360,170 C 440,165 480,40 550,50 C 620,60 660,150 740,145 C 810,140 850,75 920,75 L 1000,90 L 1000,200 L 0,200 Z"
                                        fill="url(#chartGradient)"
                                    />

                                    <!-- Main Primary Wave -->
                                    <path
                                        d="M 0,190 C 60,150 110,105 180,105 C 260,105 290,175 360,170 C 440,165 480,40 550,50 C 620,60 660,150 740,145 C 810,140 850,75 920,75 L 1000,90"
                                        fill="none"
                                        stroke="#1570EF"
                                        stroke-width="2.3"
                                        stroke-linecap="round"
                                    />
                                </svg>

                                <!-- Badge 700 pada Mar -->
                                <div class="absolute left-[18%] top-[45%] -translate-x-1/2 -translate-y-full pointer-events-none">
                                    <div class="relative flex flex-col items-center">
                                        <div class="bg-[#1E293B] text-white text-[10px] sm:text-xs font-bold px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg sm:rounded-xl shadow-lg flex items-center justify-center">
                                            700
                                        </div>
                                        <div class="w-2 sm:w-2.5 h-2 sm:h-2.5 bg-[#1E293B] rotate-45 -mt-1"></div>
                                    </div>
                                </div>

                                <!-- Badge 948 pada Okt -->
                                <div class="absolute left-[73%] top-[25%] -translate-x-1/2 -translate-y-full pointer-events-none">
                                    <div class="relative flex flex-col items-center">
                                        <div class="bg-[#1E293B] text-white text-[10px] sm:text-xs font-bold px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg sm:rounded-xl shadow-lg flex items-center justify-center">
                                            948
                                        </div>
                                        <div class="w-2 sm:w-2.5 h-2 sm:h-2.5 bg-[#1E293B] rotate-45 -mt-1"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="absolute bottom-0 inset-x-0 pl-9 sm:pl-11 flex justify-between text-[9px] sm:text-[10px] text-gray-400 font-medium">
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
                    <div class="mt-3 sm:mt-4 pt-2.5 sm:pt-3 border-t border-gray-100/90">
                        <h3 class="text-xs sm:text-sm font-bold text-gray-900 mb-1.5 sm:mb-2">
                            Jatuh Tempo Terdekat
                        </h3>

                        <div class="overflow-x-auto no-scrollbar">
                            <table class="w-full text-left text-[10px] sm:text-xs min-w-full">
                                <thead>
                                    <tr class="text-gray-400 font-normal border-b border-gray-100 whitespace-nowrap">
                                        <th class="pb-1.5 pr-2 font-normal">Jenis Kontrak</th>
                                        <th class="pb-1.5 px-2 font-normal">Nama</th>
                                        <th class="pb-1.5 px-2 font-normal">Jatuh Tempo</th>
                                        <th class="pb-1.5 pl-2 font-normal text-right">Sisa</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr class="whitespace-nowrap">
                                        <td class="py-1.5 sm:py-2 pr-2 font-semibold text-gray-900">Kontrak Sewa</td>
                                        <td class="py-1.5 sm:py-2 px-2 text-gray-700">Mardiyah</td>
                                        <td class="py-1.5 sm:py-2 px-2 text-gray-700">24-10-2026</td>
                                        <td class="py-1.5 sm:py-2 pl-2 text-right">
                                            <span class="inline-block whitespace-nowrap rounded-md bg-[#FEECEC] px-1.5 sm:px-2.5 py-0.5 text-[9px] sm:text-xs font-semibold text-[#F04438]">
                                                4 bulan 10 hari
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="whitespace-nowrap">
                                        <td class="py-1.5 sm:py-2 pr-2 font-semibold text-gray-900">Kontrak Sewa</td>
                                        <td class="py-1.5 sm:py-2 px-2 text-gray-700">Mardiyah</td>
                                        <td class="py-1.5 sm:py-2 px-2 text-gray-700">24-10-2026</td>
                                        <td class="py-1.5 sm:py-2 pl-2 text-right">
                                            <span class="inline-block whitespace-nowrap rounded-md bg-[#FFF4E5] px-1.5 sm:px-2.5 py-0.5 text-[9px] sm:text-xs font-semibold text-[#F79009]">
                                                9 bulan 3 hari
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="whitespace-nowrap">
                                        <td class="py-1.5 sm:py-2 pr-2 font-semibold text-gray-900">Kontrak Sewa</td>
                                        <td class="py-1.5 sm:py-2 px-2 text-gray-700">Mardiyah</td>
                                        <td class="py-1.5 sm:py-2 px-2 text-gray-700">24-10-2026</td>
                                        <td class="py-1.5 sm:py-2 pl-2 text-right">
                                            <span class="inline-block whitespace-nowrap rounded-md bg-[#EBFDF2] px-1.5 sm:px-2.5 py-0.5 text-[9px] sm:text-xs font-semibold text-[#12B76A]">
                                                46 bulan 5 hari
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Kolom Kanan -->
            <div class="lg:col-span-4 flex flex-col gap-3.5 sm:gap-4 lg:gap-3.5 lg:min-h-0">

                <!-- Distribusi Jenis Pendapatan -->
                <div class="rounded-2xl sm:rounded-3xl bg-white p-4 sm:p-5.5 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 shrink-0">
                    
                    <div class="flex items-center justify-between mb-2.5 sm:mb-3.5">
                        <h2 class="text-xs sm:text-base font-semibold text-gray-950">
                            Distribusi Jenis Pendapatan
                        </h2>
                        
                        <!-- Dropdown Menu dengan Popup Lihat (W 100 H 56 Radius 10 On Click) -->
                        <div class="relative">
                            <button
                                type="button"
                                id="btn-dropdown-toggle"
                                onclick="toggleDropdownLihat(event)"
                                class="flex h-7 w-7 sm:h-[32px] sm:w-[32px] items-center justify-center rounded-[8px] sm:rounded-[10px] bg-[#F5F5F7] text-gray-400 hover:text-gray-600 transition cursor-pointer shadow-xs"
                                title="Menu"
                            >
                                <x-icon name="dots-vertical" class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                            </button>
                            
                            <div
                                id="popup-dropdown-lihat"
                                class="hidden absolute right-0 top-full mt-1.5 w-[100px] h-[56px] bg-white border border-gray-100 shadow-[0_6px_24px_rgba(0,0,0,0.12)] rounded-[10px] items-center justify-center gap-2 cursor-pointer hover:bg-gray-50/80 transition z-30 select-none"
                                onclick="handleClickLihat()"
                            >
                                <x-icon name="icon-lihat" class="w-[20px] h-[20px] text-[#5A607F]" />
                                <span class="text-[14px] font-semibold text-[#1C204F]">Lihat</span>
                            </div>
                        </div>
                    </div>

                    <!-- Diagram Batang -->
                    <div class="flex items-stretch gap-1 mb-3 sm:mb-4 h-[55px] sm:h-[70px]">
                        <div class="w-[24%] flex flex-col justify-between">
                            <span class="text-xs sm:text-base font-bold text-gray-950 leading-none">20%</span>
                            <div class="flex-1 w-px bg-gray-200 my-1 sm:my-1.5"></div>
                            <div class="h-1 sm:h-1.5 rounded-xs bg-[#0D63E5] w-full"></div>
                        </div>

                        <div class="w-[12%] flex flex-col justify-between">
                            <span class="text-xs sm:text-base font-bold text-gray-950 leading-none">10%</span>
                            <div class="flex-1 w-px bg-gray-200 my-1 sm:my-1.5"></div>
                            <div class="h-1 sm:h-1.5 rounded-xs bg-[#94B4FF] w-full"></div>
                        </div>

                        <div class="w-[20%] flex flex-col justify-between">
                            <span class="text-xs sm:text-base font-bold text-gray-950 leading-none">19%</span>
                            <div class="flex-1 w-px bg-gray-200 my-1 sm:my-1.5"></div>
                            <div class="h-1 sm:h-1.5 rounded-xs bg-[#EB4D4B] w-full"></div>
                        </div>

                        <div class="w-[24%] flex flex-col justify-between">
                            <span class="text-xs sm:text-base font-bold text-gray-950 leading-none">30%</span>
                            <div class="flex-1 w-px bg-gray-200 my-1 sm:my-1.5"></div>
                            <div class="h-1 sm:h-1.5 rounded-xs bg-[#F99827] w-full"></div>
                        </div>

                        <div class="w-[20%] flex flex-col justify-between">
                            <span class="text-xs sm:text-base font-bold text-gray-950 leading-none opacity-0">&nbsp;</span>
                            <div class="flex-1 w-px bg-gray-200 my-1 sm:my-1.5"></div>
                            <div class="h-1 sm:h-1.5 rounded-xs bg-[#00C49F] w-full"></div>
                        </div>
                    </div>

                    <!-- Tabel Distribusi -->
                    <div>
                        <div class="flex justify-between items-center px-1 text-[10px] sm:text-xs text-[#7E8B9B] font-medium mb-2 pb-1 border-b border-gray-50">
                            <span>Jenis Pendapatan</span>
                            <span>Bounce Rate</span>
                        </div>

                        <div class="space-y-2 sm:space-y-2.5 px-1 pt-0.5">
                            <div class="flex items-center justify-between text-[11px] sm:text-sm">
                                <span class="font-semibold text-gray-950 flex items-center gap-2 sm:gap-2.5">
                                    <span class="h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-[#0D63E5] shrink-0"></span>
                                    Row
                                </span>
                                <span class="font-medium text-[#10B981]">81.94%</span>
                            </div>

                            <div class="flex items-center justify-between text-[11px] sm:text-sm">
                                <span class="font-semibold text-gray-950 flex items-center gap-2 sm:gap-2.5">
                                    <span class="h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-[#94B4FF] shrink-0"></span>
                                    Non Row
                                </span>
                                <span class="font-medium text-[#10B981]">81.94%</span>
                            </div>

                            <div class="flex items-center justify-between text-[11px] sm:text-sm">
                                <span class="font-semibold text-gray-950 flex items-center gap-2 sm:gap-2.5">
                                    <span class="h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-[#EB4D4B] shrink-0"></span>
                                    Rumah Perusahaan
                                </span>
                                <span class="font-medium text-[#10B981]">81.94%</span>
                            </div>

                            <div class="flex items-center justify-between text-[11px] sm:text-sm">
                                <span class="font-semibold text-gray-950 flex items-center gap-2 sm:gap-2.5">
                                    <span class="h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-[#F99827] shrink-0"></span>
                                    Utilitas Pengawasan
                                </span>
                                <span class="font-medium text-[#10B981]">81.94%</span>
                            </div>

                            <div class="flex items-center justify-between text-[11px] sm:text-sm">
                                <span class="font-semibold text-gray-950 flex items-center gap-2 sm:gap-2.5">
                                    <span class="h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-[#00C49F] shrink-0"></span>
                                    Iklan
                                </span>
                                <span class="font-medium text-[#10B981]">81.94%</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Pencapaian RKA (Donut & Stat Buttons) -->
                <div class="rounded-2xl sm:rounded-3xl bg-gradient-to-b from-[#659DF8] via-[#2F7EF8] to-[#0062F5] p-4 sm:p-6 text-white shadow-[0_4px_20px_rgba(21,112,239,0.2)] flex flex-col justify-between relative lg:flex-1 lg:min-h-0">
                    
                    <div class="flex items-center justify-between mb-2.5 sm:mb-3 relative z-30">
                        <h2 class="text-xs sm:text-base font-semibold text-white tracking-normal">
                            Pencapaian RKA
                        </h2>
                        
                        <!-- Dropdown Menu dengan Popup Lihat (W 100 H 56 Radius 10 On Click) -->
                        <div class="relative">
                            <button
                                type="button"
                                id="btn-dropdown-rka-toggle"
                                onclick="toggleDropdownRka(event)"
                                class="flex h-7 w-7 sm:h-[32px] sm:w-[32px] items-center justify-center rounded-[8px] sm:rounded-[10px] bg-[#6697E7] hover:bg-[#5889d8] text-[#D4FCFF] transition cursor-pointer shadow-xs"
                                title="Menu"
                            >
                                <x-icon name="dots-vertical" class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                            </button>

                            <div
                                id="popup-dropdown-rka"
                                class="hidden absolute right-0 top-full mt-1.5 w-[100px] h-[56px] bg-white border border-gray-100 shadow-[0_6px_24px_rgba(0,0,0,0.18)] rounded-[10px] items-center justify-center gap-2 cursor-pointer hover:bg-gray-50/90 transition z-40 select-none text-gray-900"
                                onclick="handleClickLihatRka()"
                            >
                                <x-icon name="icon-lihat" class="w-[20px] h-[20px] text-[#5A607F]" />
                                <span class="text-[14px] font-semibold text-[#1C204F]">Lihat</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-start gap-3 sm:gap-3.5 my-auto w-full">

                        <!-- Donut Chart -->
                        <div class="relative flex h-[140px] w-[140px] sm:h-[195px] sm:w-[195px] xl:h-[205px] xl:w-[205px] shrink-0 items-center justify-center">
                            <svg viewBox="0 0 100 100" class="h-full w-full overflow-visible">
                                <path
                                    id="donut-arc-top"
                                    d="M 12 50 A 38 38 0 0 1 88 50"
                                    fill="none"
                                    stroke="#FFFFFF"
                                    stroke-width="11"
                                    class="transition-colors duration-300"
                                />
                                <path
                                    id="donut-arc-bottom"
                                    d="M 88 50 A 38 38 0 0 1 12 50"
                                    fill="none"
                                    stroke="rgba(255, 255, 255, 0.4)"
                                    stroke-width="11"
                                    class="transition-colors duration-300"
                                />
                            </svg>

                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <span id="donut-percentage" class="text-[20px] sm:text-[28px] font-semibold tracking-normal text-white transition-all duration-300">
                                    45%
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Statistik -->
                        <div class="flex flex-col gap-2 sm:gap-2.5 w-full sm:w-[160px] xl:w-[170px] shrink-0">
                            
                            <button
                                type="button"
                                id="btn-stat-blacklog"
                                onclick="switchDonutStat('blacklog')"
                                class="w-full rounded-xl sm:rounded-2xl border-1.5 border-white bg-white/15 p-2.5 sm:px-3.5 sm:py-2.5 text-left transition-all duration-200 shadow-sm cursor-pointer hover:bg-white/25 active:scale-[0.98]"
                            >
                                <p class="text-[11px] sm:text-[13px] font-medium text-white flex items-center gap-1.5 leading-snug whitespace-nowrap">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white shrink-0"></span>
                                    Total Backlog
                                </p>
                                <p class="text-xs sm:text-[14px] font-normal text-white/90 mt-0.5 pl-3">
                                    Rp 15.0M
                                </p>
                            </button>

                            <button
                                type="button"
                                id="btn-stat-pendapatan"
                                onclick="switchDonutStat('pendapatan')"
                                class="w-full rounded-xl sm:rounded-2xl border border-white/60 bg-transparent p-2.5 sm:px-3.5 sm:py-2.5 text-left transition-all duration-200 cursor-pointer hover:bg-white/15 active:scale-[0.98] opacity-85 hover:opacity-100"
                            >
                                <p class="text-[11px] sm:text-[13px] font-medium text-white flex items-center gap-1.5 leading-snug whitespace-nowrap">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white shrink-0"></span>
                                    Total Backlog 2
                                </p>
                                <p class="text-xs sm:text-[14px] font-normal text-white/90 mt-0.5 pl-3">
                                    Rp 622.9M
                                </p>
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <script>
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
                    popupRka.classList.remove('hidden');
                    popupRka.classList.add('flex');
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

        document.addEventListener('click', function(e) {
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

            if (type === 'blacklog') {
                arcTop.setAttribute('stroke', '#FFFFFF');
                arcBottom.setAttribute('stroke', 'rgba(255, 255, 255, 0.4)');
                percentageText.innerText = '45%';

                btnBlacklog.className = 'w-full rounded-2xl border-1.5 border-white bg-white/15 px-3.5 py-2.5 text-left transition-all duration-200 shadow-sm cursor-pointer hover:bg-white/25 active:scale-[0.98]';
                btnPendapatan.className = 'w-full rounded-2xl border border-white/60 bg-transparent px-3.5 py-2.5 text-left transition-all duration-200 cursor-pointer hover:bg-white/15 active:scale-[0.98] opacity-85 hover:opacity-100';
            } else {
                arcBottom.setAttribute('stroke', '#FFFFFF');
                arcTop.setAttribute('stroke', 'rgba(255, 255, 255, 0.4)');
                percentageText.innerText = '55%';

                btnPendapatan.className = 'w-full rounded-2xl border-1.5 border-white bg-white/15 px-3.5 py-2.5 text-left transition-all duration-200 shadow-sm cursor-pointer hover:bg-white/25 active:scale-[0.98]';
                btnBlacklog.className = 'w-full rounded-2xl border border-white/60 bg-transparent px-3.5 py-2.5 text-left transition-all duration-200 cursor-pointer hover:bg-white/15 active:scale-[0.98] opacity-85 hover:opacity-100';
            }
        }
    </script>
</body>
</html>