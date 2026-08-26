<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-5 pb-24 lg:pb-5 flex flex-col lg:justify-between lg:min-h-0">

        <!-- Page Header -->
        <div class="mb-4 lg:mb-3 shrink-0">
            <h1 class="text-2xl sm:text-[30px] font-bold tracking-tight text-gray-950">
                Halo Admin
            </h1>
        </div>

        <!-- Dashboard Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-3.5 items-stretch lg:flex-1 lg:min-h-0">

            <!-- Kolom Kiri -->
            <div class="lg:col-span-8 flex flex-col gap-4 lg:gap-3.5 lg:min-h-0">

                <!-- 4 Kartu Statistik -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-3.5 shrink-0">

                    <!-- Kartu 1 -->
                    <div class="rounded-2xl sm:rounded-3xl bg-white p-4 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col justify-between h-[120px] sm:h-[130px] transition hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div class="flex h-9 w-9 items-center justify-center">
                                <x-icon name="folder" class="h-8 w-8" />
                            </div>
                            <div class="flex h-[32px] w-[32px] items-center justify-center rounded-[10px] bg-[#F5F5F5] text-[#333333] transition hover:bg-[#EBEBEB]">
                                <x-icon name="arrow-up-right" class="h-4.5 w-4.5" />
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 leading-tight">
                                Kontrak Aktif
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5 font-medium">
                                100 kontrak
                            </p>
                        </div>
                    </div>

                    <!-- Kartu 2 -->
                    <div class="rounded-2xl sm:rounded-3xl bg-white p-4 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col justify-between h-[120px] sm:h-[130px] transition hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div class="flex h-9 w-9 items-center justify-center">
                                <x-icon name="folder" class="h-8 w-8" />
                            </div>
                            <div class="flex h-[32px] w-[32px] items-center justify-center rounded-[10px] bg-[#F5F5F5] text-[#333333] transition hover:bg-[#EBEBEB]">
                                <x-icon name="arrow-up-right" class="h-4.5 w-4.5" />
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 leading-tight">&nbsp;</p>
                            <p class="text-xs text-gray-400 mt-0.5">&nbsp;</p>
                        </div>
                    </div>

                    <!-- Kartu 3 -->
                    <div class="rounded-2xl sm:rounded-3xl bg-white p-4 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col justify-between h-[120px] sm:h-[130px] transition hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div class="flex h-9 w-9 items-center justify-center">
                                <x-icon name="folder" class="h-8 w-8" />
                            </div>
                            <div class="flex h-[32px] w-[32px] items-center justify-center rounded-[10px] bg-[#F5F5F5] text-[#333333] transition hover:bg-[#EBEBEB]">
                                <x-icon name="arrow-up-right" class="h-4.5 w-4.5" />
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 leading-tight">&nbsp;</p>
                            <p class="text-xs text-gray-400 mt-0.5">&nbsp;</p>
                        </div>
                    </div>

                    <!-- Kartu 4 -->
                    <div class="rounded-2xl sm:rounded-3xl bg-white p-4 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col justify-between h-[120px] sm:h-[130px] transition hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div class="flex h-9 w-9 items-center justify-center">
                                <x-icon name="folder" class="h-8 w-8" />
                            </div>
                            <div class="flex h-[32px] w-[32px] items-center justify-center rounded-[10px] bg-[#F5F5F5] text-[#333333] transition hover:bg-[#EBEBEB]">
                                <x-icon name="arrow-up-right" class="h-4.5 w-4.5" />
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 leading-tight">&nbsp;</p>
                            <p class="text-xs text-gray-400 mt-0.5">&nbsp;</p>
                        </div>
                    </div>

                </div>

                <!-- Grafik Pendapatan & Tabel Jatuh Tempo -->
                <div class="rounded-2xl sm:rounded-3xl bg-white p-5 sm:p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col justify-between lg:flex-1 lg:min-h-0">
                    <div>
                        <h2 class="text-sm sm:text-base font-semibold text-gray-900 mb-3">
                            Pendapatan 2026
                        </h2>

                        <!-- Chart Container -->
                        <div class="relative h-[180px] sm:h-[190px] lg:h-[155px] xl:h-[170px] w-full mb-2">
                            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none pb-4">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 text-[10px] text-gray-400 text-right shrink-0">1,000</span>
                                    <div class="h-px bg-gray-100 flex-1"></div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 text-[10px] text-gray-400 text-right shrink-0">900</span>
                                    <div class="h-px bg-gray-100 flex-1"></div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 text-[10px] text-gray-400 text-right shrink-0">800</span>
                                    <div class="h-px bg-gray-100 flex-1"></div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 text-[10px] text-gray-400 text-right shrink-0">700</span>
                                    <div class="h-px bg-gray-100 flex-1"></div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 text-[10px] text-gray-400 text-right shrink-0">600</span>
                                    <div class="h-px bg-gray-100 flex-1"></div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 text-[10px] text-gray-400 text-right shrink-0">500</span>
                                    <div class="h-px bg-gray-100 flex-1"></div>
                                </div>
                            </div>

                            <div class="absolute inset-0 pl-10 pb-4">
                                <svg viewBox="0 0 1000 200" preserveAspectRatio="none" class="w-full h-full overflow-visible">
                                    <defs>
                                        <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#1570EF" stop-opacity="0.22"/>
                                            <stop offset="100%" stop-color="#1570EF" stop-opacity="0.0"/>
                                        </linearGradient>
                                    </defs>

                                    <path
                                        d="M 0,90 C 80,105 140,140 230,135 C 310,130 360,95 440,120 C 510,140 590,130 670,85 C 750,55 830,120 920,110 L 1000,105"
                                        fill="none"
                                        stroke="#84ADFF"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                    />

                                    <path
                                        d="M 0,190 C 60,150 110,105 180,105 C 260,105 290,175 360,170 C 440,165 480,40 550,50 C 620,60 660,150 740,145 C 810,140 850,75 920,75 L 1000,90 L 1000,200 L 0,200 Z"
                                        fill="url(#chartGradient)"
                                    />

                                    <path
                                        d="M 0,190 C 60,150 110,105 180,105 C 260,105 290,175 360,170 C 440,165 480,40 550,50 C 620,60 660,150 740,145 C 810,140 850,75 920,75 L 1000,90"
                                        fill="none"
                                        stroke="#1570EF"
                                        stroke-width="2.3"
                                        stroke-linecap="round"
                                    />
                                </svg>

                                <div class="absolute left-[18%] top-[45%] -translate-x-1/2 -translate-y-full pointer-events-none">
                                    <div class="relative flex flex-col items-center">
                                        <div class="bg-[#1E293B] text-white text-[10px] font-semibold px-2.5 py-1.5 rounded-xl shadow-md flex items-center justify-center">
                                            &nbsp;
                                        </div>
                                        <div class="w-2.5 h-2.5 bg-[#1E293B] rotate-45 -mt-1"></div>
                                    </div>
                                </div>

                                <div class="absolute left-[70%] top-[26%] -translate-x-1/2 -translate-y-full pointer-events-none">
                                    <div class="relative flex flex-col items-center">
                                        <div class="bg-[#1E293B] text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-lg flex items-center justify-center">
                                            948
                                        </div>
                                        <div class="w-2.5 h-2.5 bg-[#1E293B] rotate-45 -mt-1"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="absolute bottom-0 inset-x-0 pl-10 flex justify-between text-[10px] text-gray-400 font-medium">
                                <span>2</span>
                                <span>4</span>
                                <span>6</span>
                                <span>8</span>
                                <span>10</span>
                                <span>12</span>
                                <span>14</span>
                                <span>16</span>
                                <span>18</span>
                                <span>20</span>
                                <span>22</span>
                                <span>24</span>
                                <span>26</span>
                                <span>28</span>
                                <span>30</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Jatuh Tempo -->
                    <div class="mt-4 pt-3 border-t border-gray-100/90">
                        <h3 class="text-xs sm:text-sm font-bold text-gray-900 mb-2">
                            Jatuh Tempo Terdekat
                        </h3>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs min-w-[320px]">
                                <thead>
                                    <tr class="text-gray-400 font-normal border-b border-gray-100">
                                        <th class="pb-1.5 font-normal">Jenis Kontrak</th>
                                        <th class="pb-1.5 font-normal">Nama</th>
                                        <th class="pb-1.5 font-normal">Jatuh Tempo</th>
                                        <th class="pb-1.5 font-normal text-right">Sisa</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr>
                                        <td class="py-2 font-semibold text-gray-900">Kontrak Sewa</td>
                                        <td class="py-2 text-gray-700">Mardiyah</td>
                                        <td class="py-2 text-gray-700">24 - 10 - 2026</td>
                                        <td class="py-2 text-right">
                                            <span class="inline-block rounded-md bg-[#FEECEC] px-2.5 py-0.5 text-xs font-semibold text-[#F04438]">
                                                10h
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 font-semibold text-gray-900">Kontrak Sewa</td>
                                        <td class="py-2 text-gray-700">Mardiyah</td>
                                        <td class="py-2 text-gray-700">24 - 10 - 2026</td>
                                        <td class="py-2 text-right">
                                            <span class="inline-block rounded-md bg-[#FFF4E5] px-2.5 py-0.5 text-xs font-semibold text-[#F79009]">
                                                90h
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 font-semibold text-gray-900">Kontrak Sewa</td>
                                        <td class="py-2 text-gray-700">Mardiyah</td>
                                        <td class="py-2 text-gray-700">24 - 10 - 2026</td>
                                        <td class="py-2 text-right">
                                            <span class="inline-block rounded-md bg-[#EBFDF2] px-2.5 py-0.5 text-xs font-semibold text-[#12B76A]">
                                                100h
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 font-semibold text-gray-900">Kontrak Sewa</td>
                                        <td class="py-2 text-gray-700">Mardiyah</td>
                                        <td class="py-2 text-gray-700">24 - 10 - 2026</td>
                                        <td class="py-2 text-right">
                                            <span class="inline-block rounded-md bg-[#FEF6EE] px-2.5 py-0.5 text-xs font-semibold text-[#F79009]">
                                                40h
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
            <div class="lg:col-span-4 flex flex-col gap-4 lg:gap-3.5 lg:min-h-0">

                <!-- Distribusi Jenis Pendapatan -->
                <div class="rounded-2xl sm:rounded-3xl bg-white p-5 sm:p-5.5 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 shrink-0">
                    
                    <div class="flex items-center justify-between mb-3.5">
                        <h2 class="text-sm sm:text-base font-semibold text-gray-950">
                            Distribusi Jenis Pendapatan
                        </h2>
                        <button type="button" class="flex h-[32px] w-[32px] items-center justify-center rounded-[10px] bg-[#F5F5F7] text-gray-400 hover:text-gray-600 transition cursor-pointer shadow-xs" title="Menu">
                            <x-icon name="dots-vertical" class="w-4 h-4" />
                        </button>
                    </div>

                    <!-- Diagram Batang -->
                    <div class="flex items-stretch gap-1 mb-4 h-[70px]">
                        <div class="w-[25%] flex flex-col justify-between">
                            <span class="text-sm sm:text-base font-bold text-gray-950 leading-none">20%</span>
                            <div class="flex-1 w-px bg-gray-200 my-1.5"></div>
                            <div class="h-1.5 rounded-xs bg-[#0D63E5] w-full"></div>
                        </div>

                        <div class="w-[12%] flex flex-col justify-between">
                            <span class="text-sm sm:text-base font-bold text-gray-950 leading-none">10%</span>
                            <div class="flex-1 w-px bg-gray-200 my-1.5"></div>
                            <div class="h-1.5 rounded-xs bg-[#94B4FF] w-full"></div>
                        </div>

                        <div class="w-[25%] flex flex-col justify-between">
                            <span class="text-sm sm:text-base font-bold text-gray-950 leading-none">19%</span>
                            <div class="flex-1 w-px bg-gray-200 my-1.5"></div>
                            <div class="h-1.5 rounded-xs bg-[#EB4D4B] w-full"></div>
                        </div>

                        <div class="w-[38%] flex flex-col justify-between">
                            <span class="text-sm sm:text-base font-bold text-gray-950 leading-none">30%</span>
                            <div class="flex-1 w-px bg-gray-200 my-1.5"></div>
                            <div class="h-1.5 rounded-xs bg-[#F99827] w-full"></div>
                        </div>
                    </div>

                    <!-- Tabel Distribusi -->
                    <div>
                        <div class="grid grid-cols-12 bg-[#F8F9FA] rounded-md px-3.5 py-1.5 text-xs text-[#7E8B9B] font-medium mb-2">
                            <span class="col-span-6">Page Name</span>
                            <span class="col-span-3 text-center">Total Users</span>
                            <span class="col-span-3 text-right">Bounce Rate</span>
                        </div>

                        <div class="space-y-2.5 px-1 pt-0.5">
                            <div class="grid grid-cols-12 items-center text-xs sm:text-sm">
                                <span class="col-span-6 font-semibold text-gray-950 flex items-center gap-2.5">
                                    <span class="h-2 w-2 rounded-full bg-[#0D63E5] shrink-0"></span>
                                    Row
                                </span>
                                <span class="col-span-3 text-center font-normal text-gray-600">547,914</span>
                                <span class="col-span-3 text-right font-medium text-[#10B981]">81.94%</span>
                            </div>

                            <div class="grid grid-cols-12 items-center text-xs sm:text-sm">
                                <span class="col-span-6 font-semibold text-gray-950 flex items-center gap-2.5">
                                    <span class="h-2 w-2 rounded-full bg-[#94B4FF] shrink-0"></span>
                                    Non Row
                                </span>
                                <span class="col-span-3 text-center font-normal text-gray-600">547,914</span>
                                <span class="col-span-3 text-right font-medium text-[#10B981]">81.94%</span>
                            </div>

                            <div class="grid grid-cols-12 items-center text-xs sm:text-sm">
                                <span class="col-span-6 font-semibold text-gray-950 flex items-center gap-2.5">
                                    <span class="h-2 w-2 rounded-full bg-[#EB4D4B] shrink-0"></span>
                                    Rumah Perusahaan
                                </span>
                                <span class="col-span-3 text-center font-normal text-gray-600">547,914</span>
                                <span class="col-span-3 text-right font-medium text-[#10B981]">81.94%</span>
                            </div>

                            <div class="grid grid-cols-12 items-center text-xs sm:text-sm">
                                <span class="col-span-6 font-semibold text-gray-950 flex items-center gap-2.5">
                                    <span class="h-2 w-2 rounded-full bg-[#F99827] shrink-0"></span>
                                    Iklan
                                </span>
                                <span class="col-span-3 text-center font-normal text-gray-600">547,914</span>
                                <span class="col-span-3 text-right font-medium text-[#10B981]">81.94%</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Blacklog dan Pendapatan -->
                <div class="rounded-2xl sm:rounded-3xl bg-gradient-to-b from-[#659DF8] via-[#2F7EF8] to-[#0062F5] p-5 sm:p-6 text-white shadow-[0_4px_20px_rgba(21,112,239,0.2)] flex flex-col justify-between relative overflow-hidden lg:flex-1 lg:min-h-0">
                    
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-sm sm:text-base font-semibold text-white tracking-normal">
                            Blacklog dan Pendapatan
                        </h2>
                        <button type="button" class="flex h-[32px] w-[32px] items-center justify-center rounded-[10px] bg-[#6697E7] hover:bg-[#5889d8] text-[#D4FCFF] transition cursor-pointer shadow-xs" title="Menu">
                            <x-icon name="dots-vertical" class="w-4 h-4" />
                        </button>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-start gap-3.5 my-auto w-full">

                        <!-- Donut Chart -->
                        <div class="relative flex h-[180px] w-[180px] sm:h-[195px] sm:w-[195px] xl:h-[205px] xl:w-[205px] shrink-0 items-center justify-center">
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
                                <span id="donut-percentage" class="text-[24px] sm:text-[28px] font-semibold tracking-normal text-white transition-all duration-300">
                                    45%
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Statistik (Mepet ke Lingkaran & Teks 1 Baris) -->
                        <div class="flex flex-col gap-2.5 w-full sm:w-[160px] xl:w-[170px] shrink-0">
                            
                            <button
                                type="button"
                                id="btn-stat-blacklog"
                                onclick="switchDonutStat('blacklog')"
                                class="w-full rounded-2xl border-1.5 border-white bg-white/15 px-3.5 py-2.5 text-left transition-all duration-200 shadow-sm cursor-pointer hover:bg-white/25 active:scale-[0.98]"
                            >
                                <p class="text-xs sm:text-[13px] font-medium text-white flex items-center gap-1.5 leading-snug whitespace-nowrap">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white shrink-0"></span>
                                    Total Blacklog
                                </p>
                                <p class="text-sm sm:text-[14px] font-normal text-white/90 mt-0.5 pl-3">
                                    Rp 15.0M
                                </p>
                            </button>

                            <button
                                type="button"
                                id="btn-stat-pendapatan"
                                onclick="switchDonutStat('pendapatan')"
                                class="w-full rounded-2xl border border-white/60 bg-transparent px-3.5 py-2.5 text-left transition-all duration-200 cursor-pointer hover:bg-white/15 active:scale-[0.98] opacity-85 hover:opacity-100"
                            >
                                <p class="text-xs sm:text-[13px] font-medium text-white flex items-center gap-1.5 leading-snug whitespace-nowrap">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white shrink-0"></span>
                                    Total Pendapatan
                                </p>
                                <p class="text-sm sm:text-[14px] font-normal text-white/90 mt-0.5 pl-3">
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