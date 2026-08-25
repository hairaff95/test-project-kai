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


    {{-- =====================================================
         SIMPLEMAPS DATA
    ====================================================== --}}

    <script src="{{ asset('js/mapdata.js') }}"></script>


    {{-- =====================================================
         MATIKAN POPUP BAWAAN SIMPLEMAPS
    ====================================================== --}}

    <script>

        /*
         * SimpleMaps menggunakan:
         *
         * popups = "off"
         *
         * BUKAN:
         *
         * pop_ups = "none"
         */

        if (
            typeof simplemaps_countrymap_mapdata !== 'undefined' &&
            simplemaps_countrymap_mapdata.main_settings
        ) {

            simplemaps_countrymap_mapdata.main_settings.auto_load = "no";

            simplemaps_countrymap_mapdata.main_settings.popups = "off";

        }

    </script>


    {{-- =====================================================
         SIMPLEMAPS ENGINE
    ====================================================== --}}

    <script src="{{ asset('js/countrymap.js') }}"></script>


    {{-- =====================================================
         TAMBAHAN CSS
    ====================================================== --}}

    <style>

        /*
         * Jaga-jaga jika SimpleMaps masih membuat
         * popup internal.
         *
         * Popup bawaan SimpleMaps menggunakan class:
         * .tt_sm
         */

        .tt_sm,
        #tt_sm {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }


        /*
         * Popup custom kita
         */

        #assetPopup {
            box-sizing: border-box;
        }


        /*
         * Supaya text tidak terlalu besar
         */

        #assetPopup * {
            box-sizing: border-box;
        }


        /*
         * Mobile
         */

        @media (max-width: 640px) {

            #assetPopup {

                right: 15px !important;
                left: 15px !important;

                top: 90px !important;

                width: auto !important;

            }

        }

    </style>

</head>


<body class="h-screen overflow-hidden bg-[#f3f3f3] font-sans text-[#171717]">


    {{-- =====================================================
         NAVBAR
    ====================================================== --}}

    <header class="w-full border-t bg-[#f3f3f3]">

        <nav class="mx-auto flex h-[75px] w-full items-center justify-between px-6">


            {{-- LOGO --}}

            <div class="flex items-center justify-center whitespace-nowrap text-[15px] font-semibold italic">

                <img
                    src="{{ asset('image/dashboard-logo/kai-logo.svg') }}"
                    alt="KAI"
                    class="h-[27px] w-[27px] -skew-x-12 object-contain"
                >

                Tracker<span class="text-blue-600">App</span>

            </div>


            {{-- NAVIGATION --}}

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


            {{-- USER --}}

            <div class="flex items-center gap-2">


                <button
                    type="button"
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white"
                >

                    <img
                        src="{{ asset('image/dashboard-logo/moon.svg') }}"
                        alt="dark"
                        class="h-[18px] w-[18px] object-contain"
                    >

                </button>


                <button
                    type="button"
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white"
                >

                    <img
                        src="{{ asset('image/dashboard-logo/notification.svg') }}"
                        alt="notification"
                        class="h-[18px] w-[18px] object-contain"
                    >

                </button>


                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white"
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



    {{-- =====================================================
         MAP
    ====================================================== --}}

    <div
        id="map"
        class="h-[calc(100vh-75px)] w-full"
    ></div>



    {{-- =====================================================
         CUSTOM ASSET POPUP
    ====================================================== --}}

    <div
        id="assetPopup"
        class="invisible fixed z-[1000] w-[330px] rounded-xl border border-gray-200 bg-white p-5 opacity-0 shadow-2xl transition-all duration-200"
        style="left: 0; top: 0;"
    >


        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="mb-[25px] flex items-start justify-between">


            <div class="flex min-w-0 items-start gap-[9px]">


                {{-- ICON --}}

                <div
                    class="flex h-[25px] w-[25px] shrink-0 items-center justify-center"
                >
                    <img
                        src="{{ asset('image/modal-popup-map/corporate_fare.svg') }}"
                        alt="dark"
                        class="object-contain"
                    >
                </div>


                {{-- TITLE --}}

                <div class="min-w-0">

                    <h3
                        id="popupAssetName"
                        class="m-0 truncate text-[17px] font-semibold leading-[1.2] text-[#111111]"
                    >
                        -
                    </h3>


                    <p
                        id="popupAssetCode"
                        class="mt-[6px] truncate text-[11px] font-medium leading-[1.3] text-[#999999]"
                    >
                        -
                    </p>

                </div>

            </div>


            {{-- CLOSE --}}

            <button
                type="button"
                id="closeAssetPopup"
                aria-label="Tutup"
                class="ml-3 flex h-[27px] w-[27px] shrink-0 items-center justify-center rounded-[6px] border-0 bg-[#f3f3f3] text-[17px] font-normal leading-none text-[#666666] transition hover:bg-[#e5e5e5]"
            >
                ×
            </button>

        </div>



        {{-- =================================================
             INFORMATION
        ================================================== --}}

        <div class="grid grid-cols-2 gap-x-[20px] gap-y-[19px]">


            {{-- ALAMAT --}}

            <div class="flex min-w-0 items-start gap-[8px]">


                <div
                    class="flex h-[21px] w-[21px] shrink-0 justify-center"
                >

                    <img
                        src="{{ asset('image/modal-popup-map/alamat.svg') }}"
                        alt="dark"
                        class="object-contain"
                    >

                </div>


                <div class="flex min-w-0 flex-col">

                    <span
                        class="mb-[3px] text-[9px] font-semibold leading-[1.2] text-[#555555]"
                    >
                        Alamat
                    </span>


                    <span
                        id="popupAddress"
                        class="break-words text-[9px] font-normal leading-[1.45] text-[#777777]"
                    >
                        -
                    </span>

                </div>

            </div>



            {{-- LUAS --}}

            <div class="flex min-w-0 items-start gap-[8px]">


                <div
                    class="flex h-[21px] w-[21px] shrink-0 justify-center"
                >

                    <img
                        src="{{ asset('image/modal-popup-map/luas.svg') }}"
                        alt="dark"
                        class="object-contain"
                    >

                </div>


                <div class="flex min-w-0 flex-col">

                    <span
                        class="mb-[3px] text-[9px] font-semibold leading-[1.2] text-[#555555]"
                    >
                        Luas
                    </span>


                    <span
                        id="popupArea"
                        class="text-[9px] font-normal leading-[1.45] text-[#777777]"
                    >
                        -
                    </span>

                </div>

            </div>



            {{-- JENIS ASET --}}

            <div class="flex min-w-0 items-start gap-[8px]">


                <div
                    class="flex h-[21px] w-[21px] shrink-0 justify-center"
                >

                    <img
                        src="{{ asset('image/modal-popup-map/jenis-asset.svg') }}"
                        alt="dark"
                        class="object-contain"
                    >

                </div>


                <div class="flex min-w-0 flex-col">

                    <span
                        class="mb-[3px] text-[9px] font-semibold leading-[1.2] text-[#555555]"
                    >
                        Jenis Aset
                    </span>


                    <span
                        id="popupAssetType"
                        class="break-words text-[9px] font-normal leading-[1.45] text-[#777777]"
                    >
                        -
                    </span>

                </div>

            </div>



            {{-- NILAI ASET --}}

            <div class="flex min-w-0 items-start gap-[8px]">


                <div
                    class="flex h-[21px] w-[21px] shrink-0 justify-center"
                >

                    <img
                        src="{{ asset('image/modal-popup-map/nilai-asset.svg') }}"
                        alt="dark"
                        class="object-contain"
                    >

                </div>


                <div class="flex min-w-0 flex-col">

                    <span
                        class="mb-[3px] text-[9px] font-semibold leading-[1.2] text-[#555555]"
                    >
                        Nilai Aset
                    </span>


                    <span
                        id="popupAssetValue"
                        class="break-words text-[9px] font-normal leading-[1.45] text-[#777777]"
                    >
                        -
                    </span>

                </div>

            </div>



            {{-- PERIODE --}}

            <div class="col-span-2 flex min-w-0 items-start gap-[8px]">


                <div
                    class="flex h-[21px] w-[21px] shrink-0 justify-center"
                >

                    <img
                        src="{{ asset('image/modal-popup-map/periode.svg') }}"
                        alt="dark"
                        class="object-contain"
                    >

                </div>


                <div class="flex min-w-0 flex-col">

                    <span
                        class="mb-[3px] text-[9px] font-semibold leading-[1.2] text-[#555555]"
                    >
                        Periode
                    </span>


                    <span
                        id="popupPeriod"
                        class="text-[9px] font-normal leading-[1.45] text-[#777777]"
                    >
                        -
                    </span>

                </div>

            </div>

        </div>



        {{-- =================================================
             FOOTER
        ================================================== --}}

        <div class="mt-[23px] flex gap-[6px]">


            <button
                type="button"
                id="detailAssetButton"
                class="h-[27px] flex-1 cursor-pointer rounded-[6px] border-0 bg-[#0d6efd] text-[10px] font-semibold text-white transition hover:bg-[#0958c9]"
            >
                Detail Lanjutan
            </button>


            <button
                type="button"
                id="openMapsButton"
                class="h-[27px] w-[108px] cursor-pointer rounded-[6px] border border-[#cccccc] bg-white text-[10px] font-medium text-[#999999] transition hover:bg-[#f7f7f7] hover:text-[#555555]"
            >
                Buka Maps
            </button>

        </div>

    </div>



    {{-- =====================================================
         FILTER BUTTON
    ====================================================== --}}

    <button
        id="filterButton"
        type="button"
        class="fixed right-[25px] top-[95px] z-[30] flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-[12px] font-semibold text-gray-700 shadow-md transition hover:bg-gray-50"
    >

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



    {{-- =====================================================
         FILTER OVERLAY
    ====================================================== --}}

    <div
        id="filterOverlay"
        class="invisible fixed inset-0 z-40 bg-black/[0.15] opacity-0 transition-all duration-200"
    ></div>



    {{-- =====================================================
         FILTER MODAL
    ====================================================== --}}

    <aside
        id="filterModal"
        class="fixed right-0 top-[75px] z-50 h-[calc(100vh-75px)] w-full translate-x-full overflow-y-auto bg-white p-6 shadow-[-5px_0_20px_rgba(0,0,0,0.08)] transition-transform duration-300 sm:w-[360px]"
    >


        {{-- HEADER --}}

        <div class="mb-[25px] flex items-center justify-between">

            <h2 class="text-[16px] font-bold text-[#171717]">
                Filter Peta
            </h2>


            <button
                id="closeFilter"
                type="button"
                class="flex h-8 w-8 items-center justify-center rounded-lg border-0 bg-[#f3f3f3] text-[#666666] transition hover:bg-[#e5e5e5]"
            >

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



        {{-- FILTER GRID --}}

        <div class="grid grid-cols-1 gap-[18px] sm:grid-cols-2">


            {{-- STASIUN --}}

            <div class="flex flex-col gap-[7px]">

                <label class="flex items-center gap-[6px] text-[12px] font-semibold text-[#666666]">
                    <span>▣</span>
                    Stasiun
                </label>

                <select
                    id="stasiun"
                    class="h-[42px] w-full cursor-pointer rounded-[9px] border border-[#d5d5d5] bg-white px-3 text-[12px] text-[#555555] outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10"
                >

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



            {{-- WILAYAH --}}

            <div class="flex flex-col gap-[7px]">

                <label class="flex items-center gap-[6px] text-[12px] font-semibold text-[#666666]">
                    <span>●</span>
                    Wilayah
                </label>

                <select
                    id="wilayah"
                    class="h-[42px] w-full cursor-pointer rounded-[9px] border border-[#d5d5d5] bg-white px-3 text-[12px] text-[#555555] outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10"
                >

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



            {{-- ASET --}}

            <div class="flex flex-col gap-[7px]">

                <label class="flex items-center gap-[6px] text-[12px] font-semibold text-[#666666]">
                    <span>⌂</span>
                    Aset
                </label>

                <select
                    id="aset"
                    class="h-[42px] w-full cursor-pointer rounded-[9px] border border-[#d5d5d5] bg-white px-3 text-[12px] text-[#555555] outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10"
                >

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



            {{-- JENIS KONTRAK --}}

            <div class="flex flex-col gap-[7px]">

                <label class="flex items-center gap-[6px] text-[12px] font-semibold text-[#666666]">
                    <span>▤</span>
                    Jenis Kontrak
                </label>

                <select
                    id="jenis_kontrak"
                    class="h-[42px] w-full cursor-pointer rounded-[9px] border border-[#d5d5d5] bg-white px-3 text-[12px] text-[#555555] outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10"
                >

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



            {{-- JENIS PENDAPATAN --}}

            <div class="flex flex-col gap-[7px]">

                <label class="flex items-center gap-[6px] text-[12px] font-semibold text-[#666666]">
                    <span>◉</span>
                    Jenis Pendapatan
                </label>

                <select
                    id="jenis_pendapatan"
                    class="h-[42px] w-full cursor-pointer rounded-[9px] border border-[#d5d5d5] bg-white px-3 text-[12px] text-[#555555] outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10"
                >

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



            {{-- SPV --}}

            <div class="flex flex-col gap-[7px]">

                <label class="flex items-center gap-[6px] text-[12px] font-semibold text-[#666666]">
                    <span>♙</span>
                    SPV
                </label>

                <select
                    id="spv"
                    class="h-[42px] w-full cursor-pointer rounded-[9px] border border-[#d5d5d5] bg-white px-3 text-[12px] text-[#555555] outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10"
                >

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



        {{-- ACTION --}}

        <div class="mt-7 flex gap-3">

            <button
                id="applyFilter"
                type="button"
                class="h-[42px] flex-1 rounded-lg border-0 bg-blue-600 text-[12px] font-semibold text-white transition hover:bg-blue-700"
            >
                Terapkan Filter
            </button>


            <button
                id="resetFilter"
                type="button"
                class="h-[42px] w-[100px] rounded-lg border border-[#d5d5d5] bg-white text-[12px] font-semibold text-[#333333] transition hover:bg-[#f3f3f3]"
            >
                Reset
            </button>

        </div>

    </aside>



    {{-- =====================================================
         JAVASCRIPT
    ====================================================== --}}

 <script>

/* =====================================================
   DATA ASSET
===================================================== */

const assets = {

    "0": {
        name: "PT Kargo Cepat Pantura",
        code: "AST-SMG-PCL-005",
        location: "Semarang Poncol",
        address: "Jl. Imam Bonjol No. 115, Purwosari, Kec. Semarang Utara, Kota Semarang",
        area: "850,00 m²",
        type: "Tanah — Depo Logistik & Kantor Ekspedisi",
        value: "Rp 380.000.000",
        period: "01/01/2026 – 31/12/2027",
        latitude: "-6.174444",
        longitude: "106.829444"
    },

    "1": {
        name: "Bangunan Bandung",
        code: "AST-BDG-002",
        location: "Stasiun Bandung",
        address: "Jl. Kebon Kawung, Bandung",
        area: "1.250,00 m²",
        type: "Bangunan — Area Komersial",
        value: "Rp 750.000.000",
        period: "01/01/2026 – 31/12/2028",
        latitude: "-6.914744",
        longitude: "107.609810"
    },

    "2": {
        name: "Tanah Surabaya",
        code: "AST-SBY-003",
        location: "Stasiun Surabaya",
        address: "Jl. Gubeng, Surabaya",
        area: "1.500,00 m²",
        type: "Tanah — Area Operasional",
        value: "Rp 950.000.000",
        period: "01/01/2026 – 31/12/2029",
        latitude: "-7.257472",
        longitude: "112.752090"
    }

};


/* =====================================================
   ELEMENT POPUP
===================================================== */

const assetPopup =
    document.getElementById('assetPopup');

const closeAssetPopup =
    document.getElementById('closeAssetPopup');


/* =====================================================
   MENYIMPAN POSISI KLIK TERAKHIR PADA MAP
===================================================== */

let lastMapClickPosition = null;

const mapElement =
    document.getElementById('map');

if (mapElement) {

    mapElement.addEventListener(
        'click',
        function(event) {

            lastMapClickPosition = {
                x: event.clientX,
                y: event.clientY
            };

            console.log(
                'Posisi klik map:',
                lastMapClickPosition
            );

        },
        true
    );

}


/* =====================================================
   HIDE SIMPLEMAPS POPUP
===================================================== */

function hideSimpleMapsPopup() {

    const popupElements =
        document.querySelectorAll(
            '.tt_sm, #tt_sm'
        );

    popupElements.forEach(
        function(element) {

            element.style.display = 'none';
            element.style.visibility = 'hidden';
            element.style.opacity = '0';

        }
    );

}


/* =====================================================
   POSISIKAN POPUP BERDASARKAN TITIK KLIK
===================================================== */

function positionAssetPopup() {

    if (!lastMapClickPosition) {

        console.warn(
            'Posisi klik map belum tersedia.'
        );

        return;

    }


    /* =================================================
       UKURAN POPUP
    ================================================= */

    const popupRect =
        assetPopup.getBoundingClientRect();

    const popupWidth =
        popupRect.width;

    const popupHeight =
        popupRect.height;


    /* =================================================
       POSISI KLIK
    ================================================= */

    const clickX =
        lastMapClickPosition.x;

    const clickY =
        lastMapClickPosition.y;


    /* =================================================
       JARAK POPUP DARI TITIK KLIK
    ================================================= */

    const gap = 15;


    /* =================================================
       UKURAN LAYAR
    ================================================= */

    const viewportWidth =
        window.innerWidth;

    const viewportHeight =
        window.innerHeight;


    /* =================================================
       DEFAULT:
       POPUP MUNCUL DI SEBELAH KANAN TITIK KLIK
    ================================================= */

    let left =
        clickX + gap;

    let top =
        clickY - (popupHeight / 2);


    /* =================================================
       JIKA TERLALU DEKAT SISI KANAN
       PINDAHKAN KE KIRI TITIK KLIK
    ================================================= */

    if (
        left + popupWidth >
        viewportWidth - 15
    ) {

        left =
            clickX -
            popupWidth -
            gap;

    }


    /* =================================================
       JIKA TERLALU DEKAT SISI KIRI
    ================================================= */

    if (left < 15) {

        left = 15;

    }


    /* =================================================
       JIKA POPUP TERLALU KE BAWAH
    ================================================= */

    if (
        top + popupHeight >
        viewportHeight - 15
    ) {

        top =
            viewportHeight -
            popupHeight -
            15;

    }


    /* =================================================
       JIKA POPUP TERLALU KE ATAS
    ================================================= */

    const minimumTop = 85;

    if (top < minimumTop) {

        top = minimumTop;

    }


    /* =================================================
       TERAPKAN POSISI
    ================================================= */

    assetPopup.style.left =
        left + 'px';

    assetPopup.style.top =
        top + 'px';


    console.log(
        'Popup position:',
        {
            clickX,
            clickY,
            left,
            top
        }
    );

}


/* =====================================================
   SHOW CUSTOM POPUP
===================================================== */

function showAssetPopup(
    asset,
    locationId
) {

    if (!asset) {

        return;

    }


    /* =================================================
       HILANGKAN POPUP SIMPLEMAPS
    ================================================= */

    hideSimpleMapsPopup();


    /* =================================================
       ISI DATA POPUP
    ================================================= */

    document.getElementById(
        'popupAssetName'
    ).textContent =
        asset.name;


    document.getElementById(
        'popupAssetCode'
    ).textContent =
        asset.code +
        " • " +
        asset.location;


    document.getElementById(
        'popupAddress'
    ).textContent =
        asset.address;


    document.getElementById(
        'popupArea'
    ).textContent =
        asset.area;


    document.getElementById(
        'popupAssetType'
    ).textContent =
        asset.type;


    document.getElementById(
        'popupAssetValue'
    ).textContent =
        asset.value;


    document.getElementById(
        'popupPeriod'
    ).textContent =
        asset.period;


    /* =================================================
       RESET POSISI
    ================================================= */

    assetPopup.style.left = '0px';
    assetPopup.style.top = '0px';


    /* =================================================
       TAMPILKAN POPUP
    ================================================= */

    assetPopup.classList.remove(
        'invisible',
        'opacity-0',
        'translate-y-[-8px]'
    );

    assetPopup.classList.add(
        'visible',
        'opacity-100',
        'translate-y-0'
    );


    /* =================================================
       POSISIKAN BERDASARKAN TITIK KLIK
    ================================================= */

    requestAnimationFrame(
        function() {

            positionAssetPopup();

        }
    );


    /* =================================================
       GOOGLE MAPS
    ================================================= */

    document.getElementById(
        'openMapsButton'
    ).onclick =
        function() {

            const url =
                'https://www.google.com/maps?q=' +
                asset.latitude +
                ',' +
                asset.longitude;

            window.open(
                url,
                '_blank'
            );

        };


    /* =================================================
       DETAIL
    ================================================= */

    document.getElementById(
        'detailAssetButton'
    ).onclick =
        function() {

            window.location.href =
                '/asset/' + locationId;

        };

}


/* =====================================================
   HIDE CUSTOM POPUP
===================================================== */

function hideAssetPopup() {

    assetPopup.classList.remove(
        'visible',
        'opacity-100',
        'translate-y-0'
    );

    assetPopup.classList.add(
        'invisible',
        'opacity-0',
        'translate-y-[-8px]'
    );

}


/* =====================================================
   CLOSE POPUP BUTTON
===================================================== */

closeAssetPopup.addEventListener(
    'click',
    function(event) {

        event.stopPropagation();

        hideAssetPopup();

    }
);


/* =====================================================
   SIMPLEMAPS SETUP
===================================================== */

function setupSimpleMaps() {

    if (
        typeof simplemaps_countrymap ===
        'undefined'
    ) {

        console.error(
            'SimpleMaps countrymap tidak ditemukan.'
        );

        return;

    }


    /* =================================================
       PASTIKAN HOOK TERSEDIA
    ================================================= */

    simplemaps_countrymap.hooks =
        simplemaps_countrymap.hooks ||
        {};


    /* =================================================
       KETIKA MARKER / LOCATION DIKLIK
    ================================================= */

    simplemaps_countrymap.hooks.click_location =
        function(id) {

            console.log(
                'SimpleMaps location clicked:',
                id
            );


            /* =========================================
               HILANGKAN POPUP BAWAAN
            ========================================= */

            hideSimpleMapsPopup();


            /* =========================================
               AMBIL DATA ASSET
            ========================================= */

            const asset =
                assets[String(id)];


            if (!asset) {

                console.warn(
                    'Asset tidak ditemukan:',
                    id
                );

                return;

            }


            /* =========================================
               TAMPILKAN POPUP
               POSISI MENGGUNAKAN TITIK KLIK TERAKHIR
            ========================================= */

            showAssetPopup(
                asset,
                String(id)
            );

        };


    /* =================================================
       LOAD MAP
    ================================================= */

    simplemaps_countrymap.load();

}


/* =====================================================
   LOAD MAP
===================================================== */

setupSimpleMaps();


/* =====================================================
   FILTER ELEMENT
===================================================== */

const filterButton =
    document.getElementById(
        'filterButton'
    );

const filterModal =
    document.getElementById(
        'filterModal'
    );

const filterOverlay =
    document.getElementById(
        'filterOverlay'
    );

const closeFilter =
    document.getElementById(
        'closeFilter'
    );

const applyFilter =
    document.getElementById(
        'applyFilter'
    );

const resetFilter =
    document.getElementById(
        'resetFilter'
    );


/* =====================================================
   OPEN FILTER
===================================================== */

function openFilter() {

    filterModal.classList.remove(
        'translate-x-full'
    );

    filterModal.classList.add(
        'translate-x-0'
    );

    filterOverlay.classList.remove(
        'invisible',
        'opacity-0'
    );

    filterOverlay.classList.add(
        'visible',
        'opacity-100'
    );

}


/* =====================================================
   CLOSE FILTER
===================================================== */

function closeFilterModal() {

    filterModal.classList.remove(
        'translate-x-0'
    );

    filterModal.classList.add(
        'translate-x-full'
    );

    filterOverlay.classList.remove(
        'visible',
        'opacity-100'
    );

    filterOverlay.classList.add(
        'invisible',
        'opacity-0'
    );

}


/* =====================================================
   FILTER EVENTS
===================================================== */

filterButton.addEventListener(
    'click',
    openFilter
);

closeFilter.addEventListener(
    'click',
    closeFilterModal
);

filterOverlay.addEventListener(
    'click',
    closeFilterModal
);


/* =====================================================
   APPLY FILTER
===================================================== */

applyFilter.addEventListener(
    'click',
    function() {

        const stasiun =
            document.getElementById(
                'stasiun'
            ).value;

        const wilayah =
            document.getElementById(
                'wilayah'
            ).value;

        const aset =
            document.getElementById(
                'aset'
            ).value;

        const jenisKontrak =
            document.getElementById(
                'jenis_kontrak'
            ).value;

        const jenisPendapatan =
            document.getElementById(
                'jenis_pendapatan'
            ).value;

        const spv =
            document.getElementById(
                'spv'
            ).value;


        console.log({

            stasiun,
            wilayah,
            aset,
            jenisKontrak,
            jenisPendapatan,
            spv

        });


        closeFilterModal();

    }
);


/* =====================================================
   RESET FILTER
===================================================== */

resetFilter.addEventListener(
    'click',
    function() {

        document.getElementById(
            'stasiun'
        ).value = '';

        document.getElementById(
            'wilayah'
        ).value = '';

        document.getElementById(
            'aset'
        ).value = '';

        document.getElementById(
            'jenis_kontrak'
        ).value = '';

        document.getElementById(
            'jenis_pendapatan'
        ).value = '';

        document.getElementById(
            'spv'
        ).value = '';

    }
);


/* =====================================================
   ESC KEY
===================================================== */

document.addEventListener(
    'keydown',
    function(event) {

        if (
            event.key === 'Escape'
        ) {

            hideAssetPopup();

            closeFilterModal();

        }

    }
);


/* =====================================================
   CLICK OUTSIDE
===================================================== */

document.addEventListener(
    'click',
    function(event) {

        /* =============================================
           JIKA KLIK DI POPUP
        ============================================= */

        if (
            assetPopup.contains(
                event.target
            )
        ) {

            return;

        }


        /* =============================================
           JIKA KLIK MAP
           
           JANGAN TUTUP POPUP.
           KLIK MARKER AKAN DITANGANI SIMPLEMAPS.
        ============================================= */

        if (
            event.target.closest(
                '#map'
            )
        ) {

            return;

        }


        /* =============================================
           JIKA KLIK FILTER
        ============================================= */

        if (
            event.target.closest(
                '#filterButton'
            )
        ) {

            return;

        }


        hideAssetPopup();

    }
);


/* =====================================================
   UPDATE POSISI SAAT WINDOW RESIZE
===================================================== */

window.addEventListener(
    'resize',
    function() {

        if (
            assetPopup.classList.contains(
                'visible'
            )
        ) {

            /*
             * Popup tetap berada
             * di dekat titik klik terakhir.
             */

            positionAssetPopup();

        }

    }
);


/* =====================================================
   SIMPLEMAPS MUTATION OBSERVER
   HILANGKAN POPUP BAWAAN
===================================================== */

const simpleMapsObserver =
    new MutationObserver(
        function() {

            hideSimpleMapsPopup();

        }
    );


simpleMapsObserver.observe(
    document.body,
    {
        childList: true,
        subtree: true
    }
);

</script>


</body>

</html>