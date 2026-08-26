<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Aset — {{ $asset->name }} - KAI Tracker</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
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
                <img src="{{ asset('image/dashboard-logo/kai-logo.svg') }}" alt="KAI" class="mr-1 h-[28px] w-[28px] -skew-x-12 object-contain">
                Tracker<span class="text-blue-600">App</span>
            </div>

            {{-- NAVIGATION --}}
            <ul class="flex items-center gap-1 text-[13px] text-gray-700">
                <li><a href="{{ route('welcome') }}" class="block px-3 py-2 font-semibold text-gray-800">Dashboard</a></li>
                <li><a href="{{ route('map') }}" class="block rounded-lg bg-[#dedede] px-3 py-2 font-semibold text-gray-800">Peta</a></li>
                <li><a href="#" class="block rounded-lg px-3 py-2 hover:bg-[#dedede]">Daftar Kontrak</a></li>
                <li><a href="#" class="block rounded-lg px-3 py-2 hover:bg-[#dedede]">Jatuh Tempo</a></li>
                <li><a href="#" class="block rounded-lg px-3 py-2 hover:bg-[#dedede]">Blacklog</a></li>
                <li><a href="#" class="block rounded-lg px-3 py-2 hover:bg-[#dedede]">Laporan</a></li>
            </ul>

            {{-- USER --}}
            <div class="flex items-center gap-2">
                <button type="button" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white">
                    <img src="{{ asset('image/dashboard-logo/moon.svg') }}" alt="dark" class="h-[19px] w-[19px] object-contain">
                </button>
                <button type="button" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white">
                    <img src="{{ asset('image/dashboard-logo/notification.svg') }}" alt="notification" class="h-[19px] w-[19px] object-contain">
                </button>
                <div class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white">
                    <img src="{{ asset('image/dashboard-logo/profile-circle.svg') }}" alt="profile" class="h-[19px] w-[19px] object-contain">
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

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-[12px] text-red-700">
                <p class="mb-1 font-semibold">Terdapat kesalahan input:</p>
                <ul class="list-inside list-disc space-y-0.5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('admin.assets.update', $asset) }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-[325px_1fr]">


                {{-- =================================================
                     LEFT COLUMN — Foto
                ================================================== --}}

                <div>

                    {{-- BACK BUTTON --}}
                    <a
                        href="{{ route('asset.detail', $asset->id) }}"
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

                    <label
                        for="upload-foto-utama"
                        class="group relative flex h-[256px] w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8] transition hover:bg-[#c8c8c8]"
                    >
                        @if($primaryImage)
                            <img
                                src="{{ $primaryImage->image_path }}"
                                alt="{{ $asset->name }}"
                                class="h-full w-full object-cover"
                                id="preview-utama"
                            >
                        @else
                            <img src="" alt="" class="hidden h-full w-full object-cover" id="preview-utama">
                        @endif
                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/30 opacity-0 transition group-hover:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            <span class="mt-1 text-[11px] font-semibold text-white">Ganti Foto</span>
                        </div>
                        @if(!$primaryImage)
                            <div class="flex flex-col items-center justify-center" id="placeholder-utama">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <span class="mt-2 text-[12px] text-gray-500">Upload Foto Utama</span>
                            </div>
                        @endif
                    </label>
                    <input type="file" id="upload-foto-utama" name="primary_image" accept="image/*" class="hidden" onchange="previewFotoUtama(this)">


                    {{-- THUMBNAIL --}}
                    <div class="mt-3 grid grid-cols-3 gap-1">
                        @for($i = 0; $i < 3; $i++)
                            @php $img = $otherImages->values()->get($i); @endphp
                            <label
                                for="upload-thumb-{{ $i }}"
                                class="group relative flex h-[103px] cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8] transition hover:bg-[#c8c8c8]"
                            >
                                @if($img)
                                    <img
                                        src="{{ $img->image_path }}"
                                        alt=""
                                        class="h-full w-full object-cover"
                                        id="preview-thumb-{{ $i }}"
                                    >
                                    <input type="hidden" name="existing_thumb_{{ $i }}" value="{{ $img->id }}">
                                @else
                                    <img src="" alt="" class="hidden h-full w-full object-cover" id="preview-thumb-{{ $i }}">
                                @endif
                                <div class="absolute inset-0 flex items-center justify-center bg-black/30 opacity-0 transition group-hover:opacity-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                </div>
                                @if(!$img)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" id="placeholder-thumb-{{ $i }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                @endif
                            </label>
                            <input type="file" id="upload-thumb-{{ $i }}" name="thumb_images[]" accept="image/*" class="hidden" onchange="previewThumb(this, {{ $i }})">
                        @endfor
                    </div>


                    {{-- DATA ADMINISTRATIF --}}
                    <div class="mt-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">

                        <h3 class="mb-3 text-[14px] font-semibold text-gray-800">Data Administratif</h3>

                        <div class="grid grid-cols-2 gap-x-4 gap-y-3">

                            <div>
                                <label class="text-[11px] text-gray-400">Kode Aset *</label>
                                <input
                                    type="text"
                                    name="asset_code"
                                    value="{{ old('asset_code', $asset->asset_code) }}"
                                    required
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                            <div>
                                <label class="text-[11px] text-gray-400">Status *</label>
                                <select
                                    name="status"
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                                    <option value="available" {{ old('status', $asset->status) === 'available' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="reserved"  {{ old('status', $asset->status) === 'reserved'  ? 'selected' : '' }}>Dalam Proses</option>
                                    <option value="sold"      {{ old('status', $asset->status) === 'sold'      ? 'selected' : '' }}>Terjual</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[11px] text-gray-400">Kontak Person</label>
                                <input
                                    type="text"
                                    name="contact_person"
                                    value="{{ old('contact_person', $asset->contact_person) }}"
                                    placeholder="Nama PIC..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                            <div>
                                <label class="text-[11px] text-gray-400">Telepon</label>
                                <input
                                    type="text"
                                    name="contact_phone"
                                    value="{{ old('contact_phone', $asset->contact_phone) }}"
                                    placeholder="No. telepon..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                            <div>
                                <label class="text-[11px] text-gray-400">Akses Jalan</label>
                                <input
                                    type="text"
                                    name="road_access"
                                    value="{{ old('road_access', $asset->road_access) }}"
                                    placeholder="Akses jalan..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                            <div>
                                <label class="text-[11px] text-gray-400">Listrik</label>
                                <input
                                    type="text"
                                    name="electricity"
                                    value="{{ old('electricity', $asset->electricity) }}"
                                    placeholder="Daya listrik..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                            <div>
                                <label class="text-[11px] text-gray-400">Air</label>
                                <input
                                    type="text"
                                    name="water_supply"
                                    value="{{ old('water_supply', $asset->water_supply) }}"
                                    placeholder="Pasokan air..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                            <div>
                                <label class="text-[11px] text-gray-400">Keamanan</label>
                                <input
                                    type="text"
                                    name="security"
                                    value="{{ old('security', $asset->security) }}"
                                    placeholder="Keamanan..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     RIGHT COLUMN — Form
                ================================================== --}}

                <div class="pt-[45px]">


                    {{-- HEADER — Judul + Tombol --}}

                    <div class="mb-5 flex items-start justify-between gap-4">

                        <div class="flex-1">

                            {{-- INPUT JUDUL --}}
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $asset->name) }}"
                                placeholder="Input Judul... *"
                                required
                                class="w-full border-0 border-b-2 border-gray-300 bg-transparent pb-1 text-[28px] font-semibold tracking-tight text-gray-900 outline-none placeholder-gray-300 focus:border-blue-500"
                            >

                            {{-- INPUT SUBJUDUL / WILAYAH --}}
                            <input
                                type="text"
                                name="district_area"
                                value="{{ old('district_area', $asset->district_area) }}"
                                placeholder="Wilayah / Jenis Aset..."
                                required
                                class="mt-1 w-full border-0 bg-transparent text-[12px] text-gray-400 outline-none placeholder-gray-300 focus:text-gray-600"
                            >

                        </div>

                        {{-- TOMBOL SIMPAN & BATAL --}}
                        <div class="flex shrink-0 items-center gap-2">

                            <button
                                type="submit"
                                class="inline-flex h-[38px] items-center gap-2 rounded-lg bg-blue-600 px-5 text-[13px] font-semibold text-white shadow-sm transition hover:bg-blue-700 active:scale-95"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                    <polyline points="17 21 17 13 7 13 7 21"/>
                                    <polyline points="7 3 7 8 15 8"/>
                                </svg>
                                Simpan
                            </button>

                            <a
                                href="{{ route('asset.detail', $asset->id) }}"
                                class="inline-flex h-[38px] items-center gap-2 rounded-lg bg-red-500 px-5 text-[13px] font-semibold text-white shadow-sm transition hover:bg-red-600 active:scale-95"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"/>
                                    <line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                                Batal
                            </a>

                        </div>

                    </div>


                    {{-- DESKRIPSI --}}
                    <textarea
                        name="description"
                        rows="3"
                        placeholder="Deskripsi..."
                        class="mb-5 w-full max-w-[680px] rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-[13px] leading-[1.6] text-gray-500 outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                    >{{ old('description', $asset->description) }}</textarea>


                    {{-- =================================================
                         ALAMAT
                    ================================================== --}}

                    <h3 class="mb-3 text-[14px] font-semibold">
                        Alamat <span class="text-red-500">*</span>
                    </h3>

                    <div class="overflow-hidden rounded-[14px] border border-[#cfcfcf]">
                        <div class="grid grid-cols-3">

                            {{-- WILAYAH ASET --}}
                            <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                    Wilayah Aset <span class="text-red-500">*</span>
                                </div>
                                <div class="flex w-[50%] items-center px-2">
                                    <input
                                        type="text"
                                        name="district_area_table"
                                        value="{{ old('district_area', $asset->district_area) }}"
                                        placeholder="Wilayah..."
                                        class="w-full bg-transparent text-right text-[11px] outline-none placeholder-gray-300 focus:text-gray-800"
                                        oninput="document.querySelector('[name=district_area]').value=this.value"
                                    >
                                </div>
                            </div>

                            {{-- JENIS ASET --}}
                            <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                    Jenis Aset <span class="text-red-500">*</span>
                                </div>
                                <div class="flex w-[50%] items-center px-2">
                                    <select
                                        name="asset_type_display"
                                        class="w-full bg-transparent text-right text-[11px] outline-none focus:text-gray-800"
                                    >
                                        <option value="">Select...</option>
                                        <option value="Tanah">Tanah</option>
                                        <option value="Bangunan Dinas">Bangunan Dinas</option>
                                        <option value="Gudang">Gudang</option>
                                        <option value="Ruko">Ruko</option>
                                        <option value="Lahan Komersial">Lahan Komersial</option>
                                    </select>
                                </div>
                            </div>

                            {{-- ALAMAT ASET --}}
                            <div class="row-span-2 flex items-start border-b border-[#d5d5d5]">
                                <div class="w-[35%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                    Alamat Aset <span class="text-red-500">*</span>
                                </div>
                                <div class="flex w-[65%] px-2 py-2">
                                    <textarea
                                        name="full_address"
                                        rows="3"
                                        placeholder="Alamat lengkap..."
                                        required
                                        class="w-full bg-transparent text-[11px] leading-[1.45] outline-none placeholder-gray-300 focus:text-gray-800 resize-none"
                                    >{{ old('full_address', $asset->full_address) }}</textarea>
                                </div>
                            </div>

                            {{-- STASIUN --}}
                            <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                    Stasiun <span class="text-red-500">*</span>
                                </div>
                                <div class="flex w-[50%] items-center px-2">
                                    <select class="w-full bg-transparent text-right text-[11px] outline-none focus:text-gray-800" name="station_display">
                                        <option value="">Select...</option>
                                        <option value="Semarang Tawang">Semarang Tawang</option>
                                        <option value="Semarang Poncol">Semarang Poncol</option>
                                        <option value="Pekalongan">Pekalongan</option>
                                        <option value="Tegal">Tegal</option>
                                        <option value="Weleri">Weleri</option>
                                    </select>
                                </div>
                            </div>

                            {{-- LUAS AREA --}}
                            <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                    Luas Area <span class="text-red-500">*</span>
                                </div>
                                <div class="flex w-[50%] items-center px-2">
                                    <input
                                        type="number"
                                        step="any"
                                        name="land_area"
                                        value="{{ old('land_area', $asset->land_area) }}"
                                        placeholder="0"
                                        required
                                        class="w-full bg-transparent text-right text-[11px] outline-none placeholder-gray-300"
                                    >
                                </div>
                            </div>

                            {{-- TIPE LAHAN --}}
                            <div class="flex min-h-[52px] items-center border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                    Tipe Lahan <span class="text-red-500">*</span>
                                </div>
                                <div class="flex w-[50%] items-center px-2">
                                    <select class="w-full bg-transparent text-right text-[11px] outline-none focus:text-gray-800" name="land_type_display">
                                        <option value="">Select...</option>
                                        <option value="Row">Row</option>
                                        <option value="Non Row">Non Row</option>
                                    </select>
                                </div>
                            </div>

                            {{-- JENIS KONTRAK --}}
                            <div class="flex min-h-[52px] items-center border-t border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                    Jenis Kontrak <span class="text-red-500">*</span>
                                </div>
                                <div class="flex w-[50%] items-center px-2">
                                    <select class="w-full bg-transparent text-right text-[11px] outline-none focus:text-gray-800" name="contract_type_display">
                                        <option value="">Select...</option>
                                        <option value="Baru">Baru</option>
                                        <option value="Perpanjangan">Perpanjangan</option>
                                        <option value="Pembaruan">Pembaruan</option>
                                    </select>
                                </div>
                            </div>

                            {{-- PERUNTUKAN --}}
                            <div class="col-span-1 flex items-center border-t border-[#d5d5d5]">
                                <div class="w-[35%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">
                                    Peruntukan
                                </div>
                                <div class="flex w-[65%] px-2 py-2">
                                    <textarea
                                        name="peruntukan_display"
                                        rows="2"
                                        placeholder="Peruntukan aset..."
                                        class="w-full bg-transparent text-[11px] leading-[1.45] outline-none placeholder-gray-300 resize-none"
                                    ></textarea>
                                </div>
                            </div>

                        </div>
                    </div>


                    {{-- =================================================
                         DATA FINANSIAL
                    ================================================== --}}

                    <div class="mt-7">

                        <h3 class="mb-3 text-[14px] font-semibold">
                            Data Finansial <span class="text-red-500">*</span>
                        </h3>

                        <div class="grid grid-cols-3 gap-x-8 gap-y-5">

                            <div>
                                <p class="text-[11px] text-gray-400">Nilai Kontrak <span class="text-red-500">*</span></p>
                                <input
                                    type="number"
                                    step="any"
                                    name="price"
                                    value="{{ old('price', $asset->price) }}"
                                    placeholder="Rp..."
                                    required
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">Jumlah Hari <span class="text-red-500">*</span></p>
                                <input
                                    type="number"
                                    name="total_days"
                                    placeholder="Hari..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">Nilai Per Hari <span class="text-red-500">*</span></p>
                                <input
                                    type="number"
                                    name="value_per_day"
                                    placeholder="Rp..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">Hari Berjalan <span class="text-red-500">*</span></p>
                                <input
                                    type="text"
                                    name="running_days"
                                    placeholder="Hari..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">Nilai Tahun Berjalan <span class="text-red-500">*</span></p>
                                <input
                                    type="number"
                                    name="value_current_year"
                                    placeholder="Rp..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">Total Jan–Des <span class="text-red-500">*</span></p>
                                <input
                                    type="number"
                                    name="total_jan_des"
                                    placeholder="Rp..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                                >
                            </div>

                        </div>


                        {{-- NILAI PER BULAN --}}
                        <div class="mt-5">

                            <p class="mb-2 text-[11px] text-gray-400">Nilai Per Bulan</p>

                            <div class="overflow-hidden rounded-[14px] border border-[#cfcfcf]">
                                <div class="grid grid-cols-4">

                                    @php
                                        $months = [
                                            ['Jan','jan'],['Apr','apr'],['Jul','jul'],['Okt','okt'],
                                            ['Feb','feb'],['Mei','mei'],['Agu','agu'],['Nov','nov'],
                                            ['Mar','mar'],['Jun','jun'],['Sep','sep'],['Des','des'],
                                        ];
                                    @endphp

                                    @foreach($months as $idx => [$label, $key])
                                        @php
                                            $isLastRow = $idx >= 8;
                                            $col = $idx % 4;
                                            $isLastCol = $col === 3;
                                            $borderB = !$isLastRow ? 'border-b' : '';
                                            $borderR = !$isLastCol ? 'border-r' : '';
                                        @endphp
                                        <div class="flex {{ $borderB }} {{ $borderR }} border-[#d5d5d5]">
                                            <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">{{ $label }}</div>
                                            <div class="flex flex-1 items-center px-2">
                                                <input
                                                    type="number"
                                                    name="month_{{ $key }}"
                                                    placeholder="0"
                                                    class="w-full bg-transparent text-right text-[11px] outline-none placeholder-gray-300"
                                                >
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                        </div>

                    </div>


                    {{-- KOORDINAT (tersembunyi tapi tetap terkirim) --}}
                    <input type="hidden" name="latitude"  value="{{ old('latitude',  $asset->latitude)  }}">
                    <input type="hidden" name="longitude" value="{{ old('longitude', $asset->longitude) }}">
                    <input type="hidden" name="building_area" value="{{ old('building_area', $asset->building_area) }}">

                </div>

            </div>

        </form>

    </main>


    <script>
        // Preview foto utama
        function previewFotoUtama(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.getElementById('preview-utama');
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    const ph = document.getElementById('placeholder-utama');
                    if (ph) ph.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Preview thumbnail
        function previewThumb(input, idx) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.getElementById('preview-thumb-' + idx);
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    const ph = document.getElementById('placeholder-thumb-' + idx);
                    if (ph) ph.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Sync wilayah aset dari tabel ke input header
        document.querySelector('[name=district_area_table]')?.addEventListener('input', function() {
            document.querySelector('[name=district_area]').value = this.value;
        });
    </script>

</body>

</html>
