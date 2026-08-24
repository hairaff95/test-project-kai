<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'KAI Tracker') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="h-screen overflow-hidden bg-[#f3f3f3] font-sans font-semibold text-[#171717]">

    <!-- ================= NAV ================= -->
    <header class="w-full border-t bg-[#f3f3f3]">

        <nav class="mx-auto flex h-[75px] w-full items-center justify-between px-6">

            <!-- Logo -->
            <div class="whitespace-nowrap text-[15px] font-semibold italic flex items-center justify-center">
                <img
                        src="{{ asset('image/dashboard-logo/kai-logo.svg') }}"
                        alt="dark"
                        class="h-[27px] w-[27px] -skew-x-12 object-contain"
                >
                Tracker<span class="text-blue-600">App</span>
            </div>


            <!-- Navigation -->
            <ul class="flex items-center gap-1 text-[12px] text-gray-700">

                <li>
                    <a
                        href="{{ route('welcome') }}"
                        class="block rounded-lg bg-[#dedede] px-3 py-2 font-semibold text-gray-800"
                    >
                        Dashboard
                    </a>
                </li>

                <li>
                    <a
                        href="{{route('map')}}"
                        class="block rounded-lg px-3 py-2 hover:bg-[#dedede]"
                    >
                        Peta
                    </a>
                </li>

                <li>
                    <a
                        href="#"
                        class="block rounded-lg px-3 py-2 hover:bg-[#dedede]"
                    >
                        Daftar Kontrak
                    </a>
                </li>

                <li>
                    <a
                        href="#"
                        class="block rounded-lg px-3 py-2 hover:bg-[#dedede]"
                    >
                        Jatuh Tempo
                    </a>
                </li>

                <li>
                    <a
                        href="#"
                        class="block rounded-lg px-3 py-2 hover:bg-[#dedede]"
                    >
                        Blacklog
                    </a>
                </li>

                <li>
                    <a
                        href="#"
                        class="block rounded-lg px-3 py-2 hover:bg-[#dedede]"
                    >
                        Laporan
                    </a>
                </li>

            </ul>


            <!-- User -->
            <div class="flex items-center gap-2">

                <!-- Dark mode -->
                <button
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-600"
                >
                    <img
                        src="{{ asset('image/dashboard-logo/moon.svg') }}"
                        alt="dark"
                        class="h-[18px] w-[18px] object-contain"
                    >
                </button>


                <!-- Notification -->
                <button
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-600"
                >
                    <img
                        src="{{ asset('image/dashboard-logo/notification.svg') }}"
                        alt="notification"
                        class="h-[18px] w-[18px] object-contain"
                    >
                </button>


                <!-- Avatar -->
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-600"
                >
                    <img
                        src="{{ asset('image/dashboard-logo/profile-circle.svg') }}"
                        alt="profile"
                        class="h-[18px] w-[18px] object-contain"
                    >
                </div>


                <div class="leading-tight">

                    <p class="text-[12px] font-medium">
                        Haidar R.
                    </p>

                    <p class="text-[11px] text-gray-500">
                        Admin
                    </p>

                </div>

            </div>

        </nav>

    </header>


    <!-- ================= MAIN ================= -->

    <main class="mx-auto w-full px-6">

        <!-- Header Dashboard -->
        <div class="mb-3 flex items-center justify-between">

            <h1 class="text-[27px] font-semibold tracking-tight">
                Halo Admin
            </h1>


            <button
                class="flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-[12px] font-medium text-white shadow-sm hover:bg-blue-700"
            >

                <span
                    class="flex h-4 w-4 items-center justify-center rounded border border-white text-[10px]"
                >
                    +
                </span>

                Tambah Kontrak

            </button>

        </div>


        <!-- ================= DASHBOARD GRID ================= -->

        <div class="grid grid-cols-12 gap-2.5">


            <!-- ================= LEFT CONTENT ================= -->

            <div class="col-span-8 space-y-1.5">


                <!-- ================= STAT CARDS ================= -->

                <div class="grid grid-cols-4 gap-2.5">


                    <!-- Card 1 -->
                    <div class="h-[140px] rounded-xl bg-white p-3 shadow-sm">

                        <div class="flex items-center justify-between">

                            <!-- Icon -->
                            <div class="flex h-6 w-6 items-center justify-center">

                                <img
                                    src="{{ asset('image/dashboard-logo/fi-ss-folder.svg') }}"
                                    alt="folder"
                                    class="h-[18px] w-[18px] object-contain"
                                >

                            </div>


                            <!-- Arrow -->
                            <div
                                class="flex h-6 w-6 items-center justify-center rounded bg-gray-100 text-[12px] text-gray-600"
                            >
                                ↗
                            </div>

                        </div>


                        <!-- Content -->
                        <div class="mt-6">

                            <p class="text-[12px] font-medium">
                                Kontrak Aktif
                            </p>

                            <p class="text-[11px] text-gray-400">
                                100 kontrak
                            </p>

                        </div>

                    </div>


                    <!-- Card 2 -->
                    <div class="h-[140px] rounded-xl bg-white p-3 shadow-sm">

                        <div class="flex items-center justify-between">

                            <div class="flex h-6 w-6 items-center justify-center">

                                <img
                                    src="{{ asset('image/dashboard-logo/fi-ss-folder.svg') }}"
                                    alt="folder"
                                    class="h-[18px] w-[18px] object-contain"
                                >

                            </div>


                            <div
                                class="flex h-6 w-6 items-center justify-center rounded bg-gray-100 text-[12px] text-gray-600"
                            >
                                ↗
                            </div>

                        </div>

                    </div>


                    <!-- Card 3 -->
                    <div class="h-[140px] rounded-xl bg-white p-3 shadow-sm">

                        <div class="flex items-center justify-between">

                            <div class="flex h-6 w-6 items-center justify-center">

                                <img
                                    src="{{ asset('image/dashboard-logo/fi-ss-folder.svg') }}"
                                    alt="folder"
                                    class="h-[18px] w-[18px] object-contain"
                                >

                            </div>


                            <div
                                class="flex h-6 w-6 items-center justify-center rounded bg-gray-100 text-[12px] text-gray-600"
                            >
                                ↗
                            </div>

                        </div>

                    </div>


                    <!-- Card 4 -->
                    <div class="h-[140px] rounded-xl bg-white p-3 shadow-sm">

                        <div class="flex items-center justify-between">

                            <div class="flex h-6 w-6 items-center justify-center">

                                <img
                                    src="{{ asset('image/dashboard-logo/fi-ss-folder.svg') }}"
                                    alt="folder"
                                    class="h-[18px] w-[18px] object-contain"
                                >

                            </div>


                            <div
                                class="flex h-6 w-6 items-center justify-center rounded bg-gray-100 text-[12px] text-gray-600"
                            >
                                ↗
                            </div>

                        </div>

                    </div>

                </div>


                <!-- ================= REVENUE ================= -->

                <div class="h-[417px] rounded-xl bg-white p-3 shadow-sm">

                    <h2 class="mb-2 text-[12px] font-medium">
                        Pendapatan 2026
                    </h2>


                    <div class="relative h-[175px] overflow-hidden">


                        <!-- Grid -->

                        <div class="absolute inset-x-0 top-8 border-t border-gray-200"></div>
                        <div class="absolute inset-x-0 top-[58px] border-t border-gray-200"></div>
                        <div class="absolute inset-x-0 top-[88px] border-t border-gray-200"></div>
                        <div class="absolute inset-x-0 top-[118px] border-t border-gray-200"></div>
                        <div class="absolute inset-x-0 top-[148px] border-t border-gray-200"></div>


                        <!-- Y Axis -->

                        <div class="absolute left-0 top-6 text-[9px] text-gray-500">
                            1,000
                        </div>

                        <div class="absolute left-0 top-[54px] text-[9px] text-gray-500">
                            900
                        </div>

                        <div class="absolute left-0 top-[84px] text-[9px] text-gray-500">
                            800
                        </div>

                        <div class="absolute left-0 top-[114px] text-[9px] text-gray-500">
                            700
                        </div>

                        <div class="absolute left-0 top-[144px] text-[9px] text-gray-500">
                            500
                        </div>


                        <!-- Chart -->

                        <svg
                            viewBox="0 0 900 180"
                            preserveAspectRatio="none"
                            class="absolute left-7 right-0 top-0 h-full w-[calc(100%-28px)]"
                        >

                            <defs>

                                <linearGradient
                                    id="chartFill"
                                    x1="0"
                                    y1="0"
                                    x2="0"
                                    y2="1"
                                >
                                    <stop
                                        offset="0%"
                                        stop-opacity="0.25"
                                    />

                                    <stop
                                        offset="100%"
                                        stop-opacity="0"
                                    />

                                </linearGradient>

                            </defs>


                            <!-- Area -->

                            <path
                                d="M0,110
                                   C50,95 70,65 115,65
                                   C150,65 160,120 200,115
                                   C235,110 250,30 285,40
                                   C330,50 330,115 390,125
                                   C450,135 470,95 515,70
                                   C560,45 575,95 620,80
                                   C665,65 690,55 735,80
                                   C790,110 820,100 900,85
                                   L900,180 L0,180 Z"
                                fill="url(#chartFill)"
                            />


                            <!-- Line -->

                            <path
                                d="M0,110
                                   C50,95 70,65 115,65
                                   C150,65 160,120 200,115
                                   C235,110 250,30 285,40
                                   C330,50 330,115 390,125
                                   C450,135 470,95 515,70
                                   C560,45 575,95 620,80
                                   C665,65 690,55 735,80
                                   C790,110 820,100 900,85"
                                fill="none"
                                stroke="#1264e8"
                                stroke-width="2"
                            />

                        </svg>


                        <!-- Tooltip 700 -->

                        <div class="absolute left-[17%] top-[47px]">

                            <div class="relative h-8 w-8">

                                <img
                                    src="{{ asset('image/dashboard-logo/Tooltip.svg') }}"
                                    alt=""
                                    class="absolute inset-0 h-8 w-8 object-contain"
                                >

                                <span
                                    class="absolute left-1/2 top-[30%] -translate-x-1/2 -translate-y-1/2 whitespace-nowrap text-[8px] font-semibold text-white"
                                >
                                    700
                                </span>

                            </div>

                        </div>


                        <!-- Tooltip 948 -->

                        <div class="absolute left-[69%] top-[25px]">

                            <div class="relative h-8 w-8">

                                <img
                                    src="{{ asset('image/dashboard-logo/Tooltip.svg') }}"
                                    alt=""
                                    class="absolute inset-0 h-8 w-8 object-contain"
                                >

                                <span
                                    class="absolute left-1/2 top-[30%] -translate-x-1/2 -translate-y-1/2 whitespace-nowrap text-[8px] font-semibold text-white"
                                >
                                    948
                                </span>

                            </div>

                        </div>


                        <!-- X Axis -->

                        <div
                            class="absolute bottom-0 left-7 right-0 flex justify-between text-[9px] text-gray-500"
                        >

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


                    <!-- ================= DUE DATE ================= -->

                    <div class="mt-7">

                        <h3 class="text-[11px] font-semibold">
                            Jatuh Tempo Terdekat
                        </h3>

                        <p class="mb-2 text-[9px] text-gray-400">
                            Jenis Kontrak
                        </p>


                        <table class="w-full text-left text-[9px]">

                            <thead class="text-gray-400">

                                <tr>

                                    <th class="pb-1 font-normal">
                                        Jenis Kontrak
                                    </th>

                                    <th class="pb-1 font-normal">
                                        Nama
                                    </th>

                                    <th class="pb-1 font-normal">
                                        Jatuh Tempo
                                    </th>

                                    <th class="pb-1 font-normal">
                                        Sisa
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <tr class="border-t border-gray-200">

                                    <td class="py-2">
                                        Kontrak Sewa
                                    </td>

                                    <td>
                                        Mardiyah
                                    </td>

                                    <td>
                                        24 - 10 - 2026
                                    </td>

                                    <td>
                                        <span class="rounded-sm bg-red-100 px-2 py-1 text-red-500">
                                            10h
                                        </span>
                                    </td>

                                </tr>


                                <tr class="border-t border-gray-200">

                                    <td class="py-2">
                                        Kontrak Sewa
                                    </td>

                                    <td>
                                        Mardiyah
                                    </td>

                                    <td>
                                        24 - 10 - 2026
                                    </td>

                                    <td>
                                        <span class="rounded-sm bg-red-100 px-2 py-1 text-red-500">
                                            90h
                                        </span>
                                    </td>

                                </tr>


                                <tr class="border-t border-gray-200">

                                    <td class="py-2">
                                        Kontrak Sewa
                                    </td>

                                    <td>
                                        Mardiyah
                                    </td>

                                    <td>
                                        24 - 10 - 2026
                                    </td>

                                    <td>
                                        <span class="rounded-sm bg-green-100 px-2 py-1 text-green-600">
                                            100h
                                        </span>
                                    </td>

                                </tr>


                                <tr class="border-t border-gray-200">

                                    <td class="py-2">
                                        Kontrak Sewa
                                    </td>

                                    <td>
                                        Mardiyah
                                    </td>

                                    <td>
                                        24 - 10 - 2026
                                    </td>

                                    <td>
                                        <span class="rounded-sm bg-yellow-100 px-2 py-1 text-yellow-600">
                                            40h
                                        </span>
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            <!-- ================= RIGHT CONTENT ================= -->

            <div class="col-span-4 space-y-2.5">


                <!-- ================= DISTRIBUTION ================= -->

                <div class="h-[320px] rounded-xl bg-white p-3 shadow-sm">

                    <div class="mb-4 flex items-center justify-between">

                        <h2 class="text-[12px] font-medium">
                            Distribusi Jenis Pendapatan
                        </h2>


                        <button
                            class="flex h-6 w-6 items-center justify-center rounded bg-gray-100 text-[13px] text-gray-500"
                        >
                            ⋮
                        </button>

                    </div>


                    <!-- Percentage -->

                    <div class="grid grid-cols-4 text-[10px] text-gray-600">

                        <span>20%</span>
                        <span>10%</span>
                        <span>19%</span>
                        <span>30%</span>

                    </div>


                    <!-- Distribution bar -->

                    <div class="mt-3 flex h-1.5 gap-1">

                        <div class="w-[28%] bg-blue-600"></div>
                        <div class="w-[12%] bg-blue-300"></div>
                        <div class="w-[30%] bg-red-500"></div>
                        <div class="flex-1 bg-orange-400"></div>

                    </div>


                    <!-- Table -->

                    <div class="mt-4">


                        <!-- Header -->

                        <div
                            class="grid grid-cols-3 bg-gray-50 px-2 py-1.5 text-[9px] text-gray-400"
                        >

                            <span>
                                Page Name
                            </span>

                            <span>
                                Total Users
                            </span>

                            <span>
                                Bounce Rate
                            </span>

                        </div>


                        <!-- Content -->

                        <div class="space-y-2 px-3 pt-2 text-[10px]">

                            <div class="grid grid-cols-3">
                                <span>🔵 Row</span>
                                <span>547,914</span>
                                <span class="text-green-500">
                                    81.94%
                                </span>
                            </div>


                            <div class="grid grid-cols-3">
                                <span>🔵 Non Row</span>
                                <span>547,914</span>
                                <span class="text-green-500">
                                    81.94%
                                </span>
                            </div>


                            <div class="grid grid-cols-3">
                                <span>🔴 Rumah Perusahaan</span>
                                <span>547,914</span>
                                <span class="text-green-500">
                                    81.94%
                                </span>
                            </div>


                            <div class="grid grid-cols-3">
                                <span>🟠 Iklan</span>
                                <span>547,914</span>
                                <span class="text-green-500">
                                    81.94%
                                </span>
                            </div>

                        </div>

                    </div>

                </div>


                <!-- ================= BLACKLOG ================= -->

                <div
                    class="min-h-[235px] rounded-xl bg-gradient-to-br from-[#6da3f8] to-[#0867ed] p-3 text-white shadow-sm"
                >

                    <div class="flex items-center justify-between">

                        <h2 class="text-[12px] font-medium">
                            Blacklog dan Pendapatan
                        </h2>


                        <button
                            class="flex h-6 w-6 items-center justify-center rounded bg-white/20 text-[13px]"
                        >
                            ⋮
                        </button>

                    </div>


                    <div class="mt-3 flex items-center gap-3">


                        <!-- Donut -->

                        <div
                            class="relative flex h-[105px] w-[105px] shrink-0 items-center justify-center rounded-full border-[14px] border-white/60"
                        >

                            <div
                                class="absolute inset-[-14px] rotate-[45deg] rounded-full border-[14px] border-blue-500 border-r-white border-t-white"
                            >
                            </div>


                            <span class="relative text-[21px] font-medium">
                                45%
                            </span>

                        </div>


                        <!-- Statistics -->

                        <div class="flex flex-1 flex-col gap-2">


                            <div class="rounded-lg border border-white/50 px-2 py-2">

                                <p class="text-[10px]">
                                    • Total Blacklog
                                </p>

                                <p class="text-[10px] text-white/70">
                                    Rp 15.0M
                                </p>

                            </div>


                            <div class="rounded-lg border border-white/50 px-2 py-2">

                                <p class="text-[10px]">
                                    • Total Pendapatan
                                </p>

                                <p class="text-[10px] text-white/70">
                                    Rp 622.9M
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

</body>

</html>