<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Detail Aset - KAI Tracker</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite([
            'resources/css/app.css',
        ])
    @endif
</head>

<body class="min-h-screen bg-[#f3f3f3] font-sans text-[#171717]">

    {{-- =====================================================
         NAVBAR
    ====================================================== --}}

    <header class="w-full border-t bg-[#f3f3f3]">

        <nav class="mx-auto flex h-[75px] w-full items-center justify-between px-6">

            {{-- LOGO --}}

            <div class="flex items-center whitespace-nowrap text-[16px] font-semibold italic">

                <img
                    src="{{ asset('image/dashboard-logo/kai-logo.svg') }}"
                    alt="KAI"
                    class="mr-1 h-[28px] w-[28px] -skew-x-12 object-contain"
                >

                Tracker<span class="text-blue-600">App</span>

            </div>


            {{-- NAVIGATION --}}

            <ul class="flex items-center gap-1 text-[13px] text-gray-700">

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
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white"
                >
                    <img
                        src="{{ asset('image/dashboard-logo/moon.svg') }}"
                        alt="dark"
                        class="h-[19px] w-[19px] object-contain"
                    >
                </button>

                <button
                    type="button"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white"
                >
                    <img
                        src="{{ asset('image/dashboard-logo/notification.svg') }}"
                        alt="notification"
                        class="h-[19px] w-[19px] object-contain"
                    >
                </button>

                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white"
                >
                    <img
                        src="{{ asset('image/dashboard-logo/profile-circle.svg') }}"
                        alt="profile"
                        class="h-[19px] w-[19px] object-contain"
                    >
                </div>

                <div class="leading-tight">

                    <p class="text-[13px] font-medium">
                        Haidar R.
                    </p>

                    <p class="text-[12px] text-gray-500">
                        Admin
                    </p>

                </div>

            </div>

        </nav>

    </header>



    {{-- =====================================================
         CONTENT
    ====================================================== --}}

    <main class="mx-auto px-10 py-4">


        {{-- =================================================
             MAIN CONTENT
             Tombol Kembali sekarang menyatu dengan content
        ================================================== --}}

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[325px_1fr]">


            {{-- =================================================
                 LEFT COLUMN
            ================================================== --}}

            <div>

                {{-- BACK BUTTON --}}

                <a
                    href="{{ route('map') }}"
                    class="mb-4 inline-flex items-center text-[15px] font-semibold text-black transition hover:text-blue-600"
                >

                    {!! file_get_contents(public_path('image/modal-popup-map/detail-map/back-square.svg')) !!}

                    <span class="ml-1.5">
                        Kembali
                    </span>

                </a>


                {{-- FOTO UTAMA --}}

                <div
                    class="flex h-[256px] w-full items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8]"
                >

                    <div class="text-[13px] text-gray-500">
                        Foto Aset
                    </div>

                </div>



                {{-- THUMBNAIL --}}

                <div class="mt-3 grid grid-cols-3 gap-1">

                    <div
                        class="flex h-[103px] items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8]"
                    >
                    </div>

                    <div
                        class="flex h-[103px] items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8]"
                    >
                    </div>

                    <div
                        class="flex h-[103px] items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8]"
                    >
                    </div>

                </div>



                {{-- DATA ADMINISTRATIF --}}

                <div
                    class="mt-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm"
                >

                    <h3 class="mb-3 text-[14px] font-semibold text-gray-800">
                        Data Administratif
                    </h3>


                    <div class="grid grid-cols-2 gap-x-5 gap-y-3">


                        {{-- GL ACCOUNT --}}

                        <div>

                            <p class="text-[11px] text-gray-400">
                                GL Account
                            </p>

                            <p class="mt-[3px] text-[11px] font-semibold text-gray-700">
                                411101 - Sewa Tanah ROW
                            </p>

                        </div>


                        {{-- FORM RKA --}}

                        <div>

                            <p class="text-[11px] text-gray-400">
                                Form RKA
                            </p>

                            <p class="mt-[3px] text-[11px] font-semibold text-gray-700">
                                RKA
                            </p>

                        </div>


                        {{-- JENIS PENDAPATAN --}}

                        <div>

                            <p class="text-[11px] text-gray-400">
                                Jenis Pendapatan
                            </p>

                            <p class="mt-[3px] text-[11px] font-semibold text-gray-700">
                                Row
                            </p>

                        </div>


                        {{-- SPV --}}

                        <div>

                            <p class="text-[11px] text-gray-400">
                                SPV / Sales Executive
                            </p>

                            <p class="mt-[3px] text-[11px] font-semibold text-gray-700">
                                SPV Komersial & Non Angkutan Daop 4
                            </p>

                        </div>


                        {{-- TAHUN RKA --}}

                        <div>

                            <p class="text-[11px] text-gray-400">
                                Tahun RKA
                            </p>

                            <p class="mt-[3px] text-[11px] font-semibold text-gray-700">
                                2026
                            </p>

                        </div>


                        {{-- KETERANGAN PENDAPATAN --}}

                        <div>

                            <p class="text-[11px] text-gray-400">
                                Ket. Pendapatan
                            </p>

                            <p class="mt-[3px] text-[11px] leading-[1.4] font-semibold text-gray-700">
                                Aset lahan pergudangan sisi timur
                                stasiun Poncol
                            </p>

                        </div>


                        {{-- KETERANGAN --}}

                        <div class="col-span-2">

                            <p class="text-[11px] text-gray-400">
                                Keterangan
                            </p>

                            <p class="mt-[3px] text-[11px] font-semibold text-gray-700">
                                Kawasan strategis dekat pusat niaga Semarang
                            </p>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =================================================
                 RIGHT COLUMN
            ================================================== --}}

            <div class="pt-[45px]">


                {{-- HEADER --}}

                <div class="mb-5 flex items-start justify-between gap-4">

                    <div>

                        <h1 class="text-[30px] font-semibold leading-tight tracking-[-0.5px]">
                            PT Kargo Cepat Pantura
                        </h1>

                        <p class="mt-1 text-[12px] text-gray-400">
                            Depo Logistik & Kantor Ekspedisi
                        </p>

                    </div>


                    {{-- ACTION BUTTON --}}

                    <div class="flex shrink-0 gap-3">

                        <button
                            type="button"
                            class="flex h-[36px] items-center gap-2 rounded-lg bg-blue-600 px-4 text-[12px] font-semibold text-white transition hover:bg-blue-700"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="15"
                                height="15"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                            </svg>

                            Edit

                        </button>


                        <button
                            type="button"
                            class="flex h-[36px] items-center gap-2 rounded-lg bg-red-600 px-4 text-[12px] font-semibold text-white transition hover:bg-red-700"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="15"
                                height="15"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                            </svg>

                            Hapus

                        </button>

                    </div>

                </div>



                {{-- DESCRIPTION --}}

                <p class="mb-5 max-w-[680px] text-[13px] leading-[1.6] text-gray-500">

                    Lorem ipsum dolor sit amet consectetur. Nisi vitae dolor
                    lectus velit enim lorem. Nam mauris non egestas vitae
                    blandit ultrices hendrerit nunc donec. Amet tellus
                    tristique tortor fringilla enim vitae at. Ornare fermentum
                    morbi ullamcorper ut tortor at aenean tellus.
                    Vestibulum suspendisse dapibus orci lectus.

                </p>



                {{-- =================================================
                     INFORMASI ASET
                ================================================== --}}

                <h3 class="mb-3 text-[14px] font-semibold">
                    Alamat
                </h3>


                <div
                    class="overflow-hidden rounded-[14px] border border-[#cfcfcf]"
                >

                    <div class="grid grid-cols-3">


                        {{-- WILAYAH --}}

                        <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">

                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                Wilayah Aset
                            </div>

                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">
                                Daop 4 Semarang
                            </div>

                        </div>


                        {{-- JENIS ASET --}}

                        <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">

                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                Jenis Aset
                            </div>

                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">
                                Bangunan Dinas
                            </div>

                        </div>


                        {{-- ALAMAT --}}

                        <div class="row-span-2 flex border-b items-center border-[#d5d5d5]">

                            <div class="w-[35%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                Alamat Aset
                            </div>

                            <div class="flex w-[65%] items-center px-3 py-2 text-[11px] leading-[1.45]">
                                Jl. Pamung Timur No. 13, Kel. Panggung,
                                Kec. Tegal Timur, Kota Tegal, Jawa Tengah
                                (Lintas Non Op Tegal - Pelabuhan)
                            </div>

                        </div>


                        {{-- STASIUN --}}

                        <div class="flex items-center min-h-[52px] border-b border-r border-[#d5d5d5]">

                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                Stasiun
                            </div>

                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">
                                Pekalongan
                            </div>

                        </div>


                        {{-- LUAS --}}

                        <div class="flex min-h-[52px] border-b border-r border-[#d5d5d5]">

                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                Luas Area
                            </div>

                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">
                                2.462,00 m²
                            </div>

                        </div>


                        {{-- TIPE LAHAN --}}

                        <div class="flex items-center min-h-[52px] border-r border-[#d5d5d5]">

                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                Tipe Lahan
                            </div>

                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">
                                Non Row
                            </div>

                        </div>


                        {{-- JENIS KONTRAK --}}

                        <div class="flex items-center min-h-[52px] border-r border-[#d5d5d5]">

                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                Jenis Kontrak
                            </div>

                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">
                                Baru
                            </div>

                        </div>


                        {{-- PERUNTUKAN --}}

                        <div class="flex items-center min-h-[52px]">

                            <div class="w-[35%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                Peruntukan
                            </div>

                            <div class="flex w-[65%] items-center px-3 py-2 text-[11px] leading-[1.45]">
                                Gudang Logistik Komersial &
                                Pergudangan Pelabuhan
                            </div>

                        </div>

                    </div>

                </div>



                {{-- =================================================
                     DATA FINANSIAL
                ================================================== --}}

                <div class="mt-7">

                    <h3 class="mb-3 text-[14px] font-semibold">
                        Data Finansial
                    </h3>


                    {{-- FINANCIAL SUMMARY --}}

                    <div class="grid grid-cols-3 gap-x-8 gap-y-5">


                        {{-- NILAI KONTRAK --}}

                        <div>

                            <p class="text-[11px] text-gray-400">
                                Nilai Kontrak
                            </p>

                            <p class="mt-1 text-[12px] font-medium">
                                Rp 970.028.000
                            </p>

                        </div>


                        {{-- JUMLAH HARI --}}

                        <div>

                            <p class="text-[11px] text-gray-400">
                                Jumlah Hari
                            </p>

                            <p class="mt-1 text-[12px] font-medium">
                                1.096 hari
                            </p>

                        </div>


                        {{-- NILAI PER HARI --}}

                        <div>

                            <p class="text-[11px] text-gray-400">
                                Nilai Per Hari
                            </p>

                            <p class="mt-1 text-[12px] font-medium">
                                Rp 885.062
                            </p>

                        </div>


                        {{-- HARI BERJALAN --}}

                        <div>

                            <p class="text-[11px] text-gray-400">
                                Hari Berjalan
                            </p>

                            <p class="mt-1 text-[12px] font-medium">
                                365 hari
                            </p>

                        </div>


                        {{-- NILAI TAHUN BERJALAN --}}

                        <div>

                            <p class="text-[11px] text-gray-400">
                                Nilai Tahun Berjalan
                            </p>

                            <p class="mt-1 text-[12px] font-medium">
                                Rp 323.047.645
                            </p>

                        </div>


                        {{-- TOTAL JAN-DES --}}

                        <div>

                            <p class="text-[11px] text-gray-400">
                                Total Jan–Des
                            </p>

                            <p class="mt-1 text-[12px] font-medium">
                                Rp 323.047.645
                            </p>

                        </div>

                    </div>



                    {{-- NILAI PER BULAN --}}

                    <div class="mt-5">

                        <p class="mb-2 text-[11px] text-gray-400">
                            Nilai Per Bulan
                        </p>


                        <div
                            class="overflow-hidden rounded-[14px] border border-[#cfcfcf]"
                        >

                            <div class="grid grid-cols-4">


                                {{-- JAN --}}

                                <div class="flex border-b border-r border-[#d5d5d5]">

                                    <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">
                                        Jan
                                    </div>

                                    <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                        26.920.637
                                    </div>

                                </div>


                                {{-- APR --}}

                                <div class="flex border-b border-r border-[#d5d5d5]">

                                    <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">
                                        Apr
                                    </div>

                                    <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                        26.920.637
                                    </div>

                                </div>


                                {{-- JUL --}}

                                <div class="flex border-b border-r border-[#d5d5d5]">

                                    <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">
                                        Jul
                                    </div>

                                    <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                        26.920.637
                                    </div>

                                </div>


                                {{-- OKT --}}

                                <div class="flex border-b border-[#d5d5d5]">

                                    <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">
                                        Okt
                                    </div>

                                    <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                        26.920.637
                                    </div>

                                </div>


                                {{-- FEB --}}

                                <div class="flex border-r border-[#d5d5d5]">

                                    <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">
                                        Feb
                                    </div>

                                    <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                        26.920.637
                                    </div>

                                </div>


                                {{-- MEI --}}

                                <div class="flex border-r border-[#d5d5d5]">

                                    <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">
                                        Mei
                                    </div>

                                    <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                        26.920.637
                                    </div>

                                </div>


                                {{-- AGU --}}

                                <div class="flex border-r border-[#d5d5d5]">

                                    <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">
                                        Agu
                                    </div>

                                    <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                        26.920.637
                                    </div>

                                </div>


                                {{-- NOV --}}

                                <div class="flex">

                                    <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">
                                        Nov
                                    </div>

                                    <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                        26.920.637
                                    </div>

                                </div>


                                {{-- MAR --}}

                                <div class="flex border-t border-r border-[#d5d5d5]">

                                    <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">
                                        Mar
                                    </div>

                                    <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                        26.920.637
                                    </div>

                                </div>


                                {{-- JUN --}}

                                <div class="flex border-t border-r border-[#d5d5d5]">

                                    <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">
                                        Jun
                                    </div>

                                    <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                        26.920.637
                                    </div>

                                </div>


                                {{-- SEP --}}

                                <div class="flex border-t border-r border-[#d5d5d5]">

                                    <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">
                                        Sep
                                    </div>

                                    <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                        26.920.637
                                    </div>

                                </div>


                                {{-- DES --}}

                                <div class="flex border-t border-[#d5d5d5]">

                                    <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">
                                        Des
                                    </div>

                                    <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                        26.920.637
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

</body>

</html>