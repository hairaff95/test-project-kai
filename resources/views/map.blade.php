<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'KAI Tracker') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite([
            'resources/css/app.css',
        ])
    @endif

    <script src="{{ asset('js/mapdata.js') }}"></script>
    <script src="{{ asset('js/countrymap.js') }}"></script>

    <style>
        #map {
            height: calc(100vh - 75px);
            width: 100%;
        }

        /* ================= FILTER BUTTON ================= */

        #filterButton {
            position: fixed;
            top: 95px;
            right: 25px;
            z-index: 30;
        }

        /* ================= OVERLAY ================= */

        #filterOverlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.15);
            z-index: 40;

            opacity: 0;
            visibility: hidden;
            transition: all 0.25s ease;
        }

        #filterOverlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* ================= FILTER MODAL ================= */

        #filterModal {
            position: fixed;
            top: 75px;
            right: 0;

            width: 360px;
            height: calc(100vh - 75px);

            background: white;
            z-index: 50;

            padding: 24px;

            box-shadow: -5px 0 20px rgba(0, 0, 0, 0.08);

            transform: translateX(100%);
            transition: transform 0.3s ease;

            overflow-y: auto;
        }

        #filterModal.active {
            transform: translateX(0);
        }

        /* ================= FILTER HEADER ================= */

        .filter-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .filter-title {
            font-size: 16px;
            font-weight: 700;
            color: #171717;
        }

        #closeFilter {
            width: 32px;
            height: 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background: #f3f3f3;
            color: #666;

            cursor: pointer;

            transition: 0.2s;
        }

        #closeFilter:hover {
            background: #e5e5e5;
        }

        /* ================= FILTER GRID ================= */

        .filter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px 18px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .filter-label {
            display: flex;
            align-items: center;
            gap: 6px;

            font-size: 12px;
            font-weight: 600;
            color: #666;
        }

        .filter-select {
            width: 100%;
            height: 42px;

            padding: 0 12px;

            border: 1px solid #d5d5d5;
            border-radius: 9px;

            background: white;

            font-size: 12px;
            color: #555;

            outline: none;

            cursor: pointer;

            transition: 0.2s;
        }

        .filter-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }

        /* ================= BUTTON ================= */

        .filter-actions {
            display: flex;
            gap: 12px;

            margin-top: 28px;
        }

        #applyFilter {
            flex: 1;

            height: 42px;

            border: none;
            border-radius: 8px;

            background: #2563eb;
            color: white;

            font-size: 12px;
            font-weight: 600;

            cursor: pointer;

            transition: 0.2s;
        }

        #applyFilter:hover {
            background: #1d4ed8;
        }

        #resetFilter {
            width: 100px;

            height: 42px;

            border: 1px solid #d5d5d5;
            border-radius: 8px;

            background: white;
            color: #333;

            font-size: 12px;
            font-weight: 600;

            cursor: pointer;

            transition: 0.2s;
        }

        #resetFilter:hover {
            background: #f3f3f3;
        }

        /* ================= MOBILE ================= */

        @media (max-width: 640px) {

            #filterModal {
                width: 100%;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="h-screen overflow-hidden bg-[#f3f3f3] font-sans font-semibold text-[#171717]">

    <!-- ================= NAV ================= -->

    <header class="w-full border-t bg-[#f3f3f3]">

        <nav class="mx-auto flex h-[75px] w-full items-center justify-between px-6">

            <!-- Logo -->
            <div class="flex items-center justify-center whitespace-nowrap text-[15px] font-semibold italic">

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
                        class="block px-3 py-2 font-semibold text-gray-800"
                    >
                        Dashboard
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('map') }}"
                        class="block rounded-lg bg-[#dedede] px-3 py-2 font-semibold text-gray-800"
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


    <!-- ================= MAP ================= -->

    <div id="map"></div>


    <!-- ================= FILTER BUTTON ================= -->

    <button
        id="filterButton"
        class="flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-[12px] font-semibold text-gray-700 shadow-md hover:bg-gray-50"
    >

        <!-- Filter Icon -->
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <line x1="4" y1="21" x2="4" y2="14"></line>
            <line x1="4" y1="10" x2="4" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12" y2="3"></line>
            <line x1="20" y1="21" x2="20" y2="16"></line>
            <line x1="20" y1="12" x2="20" y2="3"></line>

            <line x1="1" y1="14" x2="7" y2="14"></line>
            <line x1="9" y1="8" x2="15" y2="8"></line>
            <line x1="17" y1="16" x2="23" y2="16"></line>
        </svg>

        Filter
    </button>


    <!-- ================= OVERLAY ================= -->

    <div id="filterOverlay"></div>


    <!-- ================= FILTER MODAL ================= -->

    <aside id="filterModal">

        <!-- Header -->
        <div class="filter-header">

            <h2 class="filter-title">
                Filter Peta
            </h2>

            <button id="closeFilter">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>

            </button>

        </div>


        <!-- Filter -->
        <div class="filter-grid">

            <!-- Stasiun -->
            <div class="filter-group">

                <label class="filter-label">

                    <span>▣</span>
                    Stasiun

                </label>

                <select id="stasiun" class="filter-select">

                    <option value="">
                        Semua Stasiun
                    </option>

                    <option value="gambir">
                        Gambir
                    </option>

                    <option value="bandung">
                        Bandung
                    </option>

                    <option value="surabaya">
                        Surabaya
                    </option>

                </select>

            </div>


            <!-- Wilayah -->
            <div class="filter-group">

                <label class="filter-label">

                    <span>●</span>
                    Wilayah

                </label>

                <select id="wilayah" class="filter-select">

                    <option value="">
                        Semua Wilayah
                    </option>

                    <option value="row1">
                        Row 1
                    </option>

                    <option value="row2">
                        Row 2
                    </option>

                    <option value="row3">
                        Row 3
                    </option>

                </select>

            </div>


            <!-- Aset -->
            <div class="filter-group">

                <label class="filter-label">

                    <span>⌂</span>
                    Aset

                </label>

                <select id="aset" class="filter-select">

                    <option value="">
                        Semua Aset
                    </option>

                    <option value="tanah">
                        Tanah
                    </option>

                    <option value="bangunan">
                        Bangunan
                    </option>

                </select>

            </div>


            <!-- Jenis Kontrak -->
            <div class="filter-group">

                <label class="filter-label">

                    <span>▤</span>
                    Jenis Kontrak

                </label>

                <select id="jenis_kontrak" class="filter-select">

                    <option value="">
                        Semua Kontrak
                    </option>

                    <option value="sewa">
                        Sewa
                    </option>

                    <option value="kerjasama">
                        Kerja Sama
                    </option>

                </select>

            </div>


            <!-- Jenis Pendapatan -->
            <div class="filter-group">

                <label class="filter-label">

                    <span>◉</span>
                    Jenis Pendapatan

                </label>

                <select id="jenis_pendapatan" class="filter-select">

                    <option value="">
                        Semua Pendapatan
                    </option>

                    <option value="sewa">
                        Sewa
                    </option>

                    <option value="iklan">
                        Iklan
                    </option>

                    <option value="lainnya">
                        Lainnya
                    </option>

                </select>

            </div>


            <!-- SPV -->
            <div class="filter-group">

                <label class="filter-label">

                    <span>♙</span>
                    SPV

                </label>

                <select id="spv" class="filter-select">

                    <option value="">
                        Semua SPV
                    </option>

                    <option value="spv1">
                        SPV 1
                    </option>

                    <option value="spv2">
                        SPV 2
                    </option>

                </select>

            </div>

        </div>


        <!-- Action -->
        <div class="filter-actions">

            <button id="applyFilter">
                Terapkan Filter
            </button>

            <button id="resetFilter">
                Reset
            </button>

        </div>

    </aside>


    <!-- ================= JAVASCRIPT ================= -->

    <script>

        const filterButton = document.getElementById('filterButton');
        const filterModal = document.getElementById('filterModal');
        const filterOverlay = document.getElementById('filterOverlay');
        const closeFilter = document.getElementById('closeFilter');

        const applyFilter = document.getElementById('applyFilter');
        const resetFilter = document.getElementById('resetFilter');


        // ================= OPEN FILTER =================

        function openFilter() {

            filterModal.classList.add('active');
            filterOverlay.classList.add('active');

        }


        // ================= CLOSE FILTER =================

        function closeFilterModal() {

            filterModal.classList.remove('active');
            filterOverlay.classList.remove('active');

        }


        // ================= EVENTS =================

        filterButton.addEventListener('click', openFilter);

        closeFilter.addEventListener('click', closeFilterModal);

        filterOverlay.addEventListener('click', closeFilterModal);


        // ================= APPLY FILTER =================

        applyFilter.addEventListener('click', function () {

            const stasiun =
                document.getElementById('stasiun').value;

            const wilayah =
                document.getElementById('wilayah').value;

            const aset =
                document.getElementById('aset').value;

            const jenisKontrak =
                document.getElementById('jenis_kontrak').value;

            const jenisPendapatan =
                document.getElementById('jenis_pendapatan').value;

            const spv =
                document.getElementById('spv').value;


            console.log({
                stasiun,
                wilayah,
                aset,
                jenisKontrak,
                jenisPendapatan,
                spv
            });


            closeFilterModal();

        });


        // ================= RESET =================

        resetFilter.addEventListener('click', function () {

            document.getElementById('stasiun').value = '';
            document.getElementById('wilayah').value = '';
            document.getElementById('aset').value = '';
            document.getElementById('jenis_kontrak').value = '';
            document.getElementById('jenis_pendapatan').value = '';
            document.getElementById('spv').value = '';

        });

    </script>

</body>

</html>