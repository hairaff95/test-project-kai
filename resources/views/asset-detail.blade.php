<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $asset->name }} - KAI Tracker</title>

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
                    <a href="#" class="block rounded-lg px-3 py-2 hover:bg-[#dedede]">Daftar Kontrak</a>
                </li>

                <li>
                    <a href="#" class="block rounded-lg px-3 py-2 hover:bg-[#dedede]">Jatuh Tempo</a>
                </li>

                <li>
                    <a href="#" class="block rounded-lg px-3 py-2 hover:bg-[#dedede]">Blacklog</a>
                </li>

                <li>
                    <a href="#" class="block rounded-lg px-3 py-2 hover:bg-[#dedede]">Laporan</a>
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

                <div class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white">
                    <img
                        src="{{ asset('image/dashboard-logo/profile-circle.svg') }}"
                        alt="profile"
                        class="h-[19px] w-[19px] object-contain"
                    >
                </div>

                @auth
                    <div class="leading-tight">
                        <p class="text-[13px] font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-[12px] text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                @endauth

            </div>

        </nav>

    </header>



    {{-- =====================================================
         CONTENT
    ====================================================== --}}

    <main class="mx-auto px-10 py-4">

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
                    @if(file_exists(public_path('image/modal-popup-map/detail-map/back-square.svg')))
                        {!! file_get_contents(public_path('image/modal-popup-map/detail-map/back-square.svg')) !!}
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                    @endif
                    <span class="ml-1.5">Kembali</span>
                </a>


                {{-- FOTO UTAMA --}}

                @php
                    $primaryImage = $asset->images->where('is_primary', true)->first() ?? $asset->images->first();
                    $otherImages  = $asset->images->where('is_primary', false)->take(3);
                @endphp

                <div class="flex h-[256px] w-full items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8]">
                    @if($primaryImage)
                        <img
                            src="{{ $primaryImage->image_path }}"
                            alt="{{ $primaryImage->caption ?? $asset->name }}"
                            class="h-full w-full object-cover"
                            id="main-photo"
                        >
                    @else
                        <div class="text-[13px] text-gray-500">Foto Aset</div>
                    @endif
                </div>


                {{-- THUMBNAIL --}}

                <div class="mt-3 grid grid-cols-3 gap-1">

                    @forelse($otherImages as $img)
                        <div
                            class="flex h-[103px] cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8]"
                            onclick="document.getElementById('main-photo').src='{{ $img->image_path }}'"
                        >
                            <img
                                src="{{ $img->image_path }}"
                                alt="{{ $img->caption ?? '' }}"
                                class="h-full w-full object-cover transition hover:opacity-80"
                            >
                        </div>
                    @empty
                        @for($i = 0; $i < 3; $i++)
                            <div class="flex h-[103px] items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8]"></div>
                        @endfor
                    @endforelse

                </div>


                {{-- DATA ADMINISTRATIF --}}

                <div class="mt-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">

                    <h3 class="mb-3 text-[14px] font-semibold text-gray-800">
                        Data Administratif
                    </h3>

                    <div class="grid grid-cols-2 gap-x-5 gap-y-3">

                        <div>
                            <p class="text-[11px] text-gray-400">Kode Aset</p>
                            <p class="mt-[3px] text-[11px] font-semibold text-gray-700">{{ $asset->asset_code }}</p>
                        </div>

                        <div>
                            <p class="text-[11px] text-gray-400">Status</p>
                            <p class="mt-[3px] text-[11px] font-semibold" style="color: {{ $asset->status_color }}">
                                {{ $asset->status_label }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[11px] text-gray-400">Kontak Person</p>
                            <p class="mt-[3px] text-[11px] font-semibold text-gray-700">
                                {{ $asset->contact_person ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[11px] text-gray-400">Telepon</p>
                            <p class="mt-[3px] text-[11px] font-semibold text-gray-700">
                                {{ $asset->contact_phone ?? '-' }}
                            </p>
                        </div>

                        @if($asset->road_access)
                            <div>
                                <p class="text-[11px] text-gray-400">Akses Jalan</p>
                                <p class="mt-[3px] text-[11px] font-semibold text-gray-700">{{ $asset->road_access }}</p>
                            </div>
                        @endif

                        @if($asset->electricity)
                            <div>
                                <p class="text-[11px] text-gray-400">Listrik</p>
                                <p class="mt-[3px] text-[11px] font-semibold text-gray-700">{{ $asset->electricity }}</p>
                            </div>
                        @endif

                        @if($asset->water_supply)
                            <div>
                                <p class="text-[11px] text-gray-400">Air</p>
                                <p class="mt-[3px] text-[11px] font-semibold text-gray-700">{{ $asset->water_supply }}</p>
                            </div>
                        @endif

                        @if($asset->security)
                            <div>
                                <p class="text-[11px] text-gray-400">Keamanan</p>
                                <p class="mt-[3px] text-[11px] font-semibold text-gray-700">{{ $asset->security }}</p>
                            </div>
                        @endif

                        @if($asset->description)
                            <div class="col-span-2">
                                <p class="text-[11px] text-gray-400">Keterangan</p>
                                <p class="mt-[3px] text-[11px] font-semibold leading-[1.4] text-gray-700">
                                    {{ Str::limit($asset->description, 120) }}
                                </p>
                            </div>
                        @endif

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
                            {{ $asset->name }}
                        </h1>
                        <p class="mt-1 text-[12px] text-gray-400">
                            {{ $asset->district_area }}
                        </p>
                    </div>


                    {{-- ACTION BUTTON --}}

                    <div class="flex shrink-0 items-center gap-2">

                        {{-- TOMBOL EDIT --}}
                        <a
                            href="{{ route('admin.assets.edit', $asset->id) }}"
                            class="inline-flex h-[38px] items-center gap-2 rounded-lg bg-blue-600 px-5 text-[13px] font-semibold text-white shadow-sm transition hover:bg-blue-700 active:scale-95"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            Edit
                        </a>

                        {{-- TOMBOL HAPUS --}}
                        <form
                            action="{{ route('admin.assets.destroy', $asset->id) }}"
                            method="POST"
                            id="form-hapus-aset"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="button"
                                onclick="document.getElementById('modal-hapus').classList.remove('hidden')"
                                class="inline-flex h-[38px] items-center gap-2 rounded-lg bg-red-500 px-5 text-[13px] font-semibold text-white shadow-sm transition hover:bg-red-600 active:scale-95"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                                Hapus
                            </button>
                        </form>

                    </div>

                </div>


                {{-- DESCRIPTION --}}

                @if($asset->description)
                    <p class="mb-5 max-w-[680px] text-[13px] leading-[1.6] text-gray-500">
                        {{ $asset->description }}
                    </p>
                @endif


                {{-- =================================================
                     INFORMASI ASET
                ================================================== --}}

                <h3 class="mb-3 text-[14px] font-semibold">Informasi Aset</h3>

                <div class="overflow-hidden rounded-[14px] border border-[#cfcfcf]">

                    <div class="grid grid-cols-3">

                        {{-- WILAYAH --}}

                        <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Wilayah Aset</div>
                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">
                                {{ $asset->district_area }}
                            </div>
                        </div>

                        {{-- STATUS --}}

                        <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Status</div>
                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px] font-semibold" style="color: {{ $asset->status_color }}">
                                {{ $asset->status_label }}
                            </div>
                        </div>

                        {{-- ALAMAT --}}

                        <div class="row-span-2 flex items-center border-b border-[#d5d5d5]">
                            <div class="w-[35%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Alamat Aset</div>
                            <div class="flex w-[65%] items-center px-3 py-2 text-[11px] leading-[1.45]">
                                {{ $asset->full_address }}
                            </div>
                        </div>

                        {{-- KODE ASET --}}

                        <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Kode Aset</div>
                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">
                                {{ $asset->asset_code }}
                            </div>
                        </div>

                        {{-- LUAS TANAH --}}

                        <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Luas Tanah</div>
                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">
                                {{ number_format($asset->land_area, 2, ',', '.') }} m²
                            </div>
                        </div>

                        {{-- LUAS BANGUNAN --}}

                        @if($asset->building_area > 0)
                            <div class="flex min-h-[52px] items-center border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Luas Bangunan</div>
                                <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">
                                    {{ number_format($asset->building_area, 2, ',', '.') }} m²
                                </div>
                            </div>
                        @endif

                        {{-- AKSES JALAN --}}

                        @if($asset->road_access)
                            <div class="flex min-h-[52px] items-center border-t border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Akses Jalan</div>
                                <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">
                                    {{ $asset->road_access }}
                                </div>
                            </div>
                        @endif

                        {{-- LISTRIK --}}

                        @if($asset->electricity)
                            <div class="flex min-h-[52px] items-center border-t border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Listrik</div>
                                <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">
                                    {{ $asset->electricity }}
                                </div>
                            </div>
                        @endif

                        {{-- AIR --}}

                        @if($asset->water_supply)
                            <div class="flex min-h-[52px] items-center border-t border-[#d5d5d5]">
                                <div class="w-[35%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Air</div>
                                <div class="flex w-[65%] items-center px-3 py-2 text-[11px]">
                                    {{ $asset->water_supply }}
                                </div>
                            </div>
                        @endif

                    </div>

                </div>


                {{-- =================================================
                     DATA FINANSIAL
                ================================================== --}}

                <div class="mt-7">

                    <h3 class="mb-3 text-[14px] font-semibold">Data Finansial</h3>

                    <div class="grid grid-cols-3 gap-x-8 gap-y-5">

                        <div>
                            <p class="text-[11px] text-gray-400">Nilai Aset</p>
                            <p class="mt-1 text-[12px] font-medium">{{ $asset->price_formatted }}</p>
                        </div>

                        <div>
                            <p class="text-[11px] text-gray-400">Luas Tanah</p>
                            <p class="mt-1 text-[12px] font-medium">
                                {{ number_format($asset->land_area, 2, ',', '.') }} m²
                            </p>
                        </div>

                        @if($asset->building_area > 0)
                            <div>
                                <p class="text-[11px] text-gray-400">Luas Bangunan</p>
                                <p class="mt-1 text-[12px] font-medium">
                                    {{ number_format($asset->building_area, 2, ',', '.') }} m²
                                </p>
                            </div>
                        @endif

                        @if($asset->contact_person)
                            <div>
                                <p class="text-[11px] text-gray-400">Kontak Person</p>
                                <p class="mt-1 text-[12px] font-medium">{{ $asset->contact_person }}</p>
                            </div>
                        @endif

                        @if($asset->contact_phone)
                            <div>
                                <p class="text-[11px] text-gray-400">Telepon</p>
                                <p class="mt-1 text-[12px] font-medium">{{ $asset->contact_phone }}</p>
                            </div>
                        @endif

                        <div>
                            <p class="text-[11px] text-gray-400">Ditambahkan</p>
                            <p class="mt-1 text-[12px] font-medium">{{ $asset->created_at->format('d/m/Y') }}</p>
                        </div>

                    </div>

                </div>


                {{-- LOKASI --}}

                @if($asset->latitude && $asset->longitude)
                    <div class="mt-7">

                        <h3 class="mb-3 text-[14px] font-semibold">Lokasi</h3>

                        <a
                            href="https://www.google.com/maps?q={{ $asset->latitude }},{{ $asset->longitude }}"
                            target="_blank"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[12px] font-medium text-gray-700 transition hover:bg-gray-50"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            Buka di Google Maps ({{ $asset->latitude }}, {{ $asset->longitude }})
                        </a>

                    </div>
                @endif

            </div>

        </div>

    </main>

    {{-- =====================================================
         MODAL KONFIRMASI HAPUS
    ====================================================== --}}

    <div
        id="modal-hapus"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
    >
        <div class="w-[380px] rounded-2xl bg-white p-6 shadow-xl">

            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
            </div>

            <h3 class="mb-1 text-[16px] font-semibold text-gray-900">Hapus Aset</h3>
            <p class="mb-6 text-[13px] text-gray-500">
                Yakin ingin menghapus <span class="font-semibold text-gray-700">{{ $asset->name }}</span>?
                Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex gap-3">
                <button
                    type="button"
                    onclick="document.getElementById('modal-hapus').classList.add('hidden')"
                    class="flex-1 rounded-lg border border-gray-200 bg-white py-2.5 text-[13px] font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Batal
                </button>
                <button
                    type="button"
                    onclick="document.getElementById('form-hapus-aset').submit()"
                    class="flex-1 rounded-lg bg-red-500 py-2.5 text-[13px] font-semibold text-white transition hover:bg-red-600"
                >
                    Ya, Hapus
                </button>
            </div>

        </div>
    </div>

</body>

</html>
