<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Aset — {{ $asset->name }} - KAI Tracker</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @endif
</head>

<body class="min-h-screen bg-[#f3f3f3] font-sans text-[#171717]">

    {{-- =====================================================
         NAVBAR
    ====================================================== --}}
    <x-navbar active="dashboard" />


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

                            <div class="relative" id="datepicker-wrapper">
                                <p class="text-[11px] text-gray-400">Hari Berjalan <span class="text-red-500">*</span></p>
                                {{-- Hidden real input for form submit --}}
                                <input type="hidden" name="running_days" id="running_days_value">
                                {{-- Display trigger --}}
                                <button
                                    type="button"
                                    id="datepicker-trigger"
                                    onclick="toggleDatepicker()"
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none text-gray-400 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 cursor-pointer text-left flex items-center justify-between"
                                >
                                    <span id="datepicker-display">Pilih tanggal...</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>

                                {{-- Custom Calendar Popup --}}
                                <div
                                    id="custom-datepicker"
                                    class="hidden absolute z-50 mt-1 left-0 bg-white rounded-2xl shadow-xl border border-gray-100 p-4 select-none"
                                    style="min-width: 260px;"
                                >
                                    {{-- Header: prev / Month dropdown / Year dropdown / next --}}
                                    <div class="flex items-center justify-between mb-3">
                                        <button type="button" onclick="changeMonth(-1)" class="h-7 w-7 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-500 transition cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                        </button>

                                        <div class="flex items-center gap-1">
                                            <select id="dp-month" onchange="onMonthChange()" class="text-sm font-semibold text-gray-800 bg-transparent border-none outline-none cursor-pointer appearance-none pr-4 relative">
                                                <option value="0">Jan</option><option value="1">Feb</option><option value="2">Mar</option>
                                                <option value="3">Apr</option><option value="4">Mei</option><option value="5">Jun</option>
                                                <option value="6">Jul</option><option value="7">Agu</option><option value="8">Sep</option>
                                                <option value="9">Okt</option><option value="10">Nov</option><option value="11">Des</option>
                                            </select>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-500 -ml-3 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>

                                            <select id="dp-year" onchange="onYearChange()" class="text-sm font-semibold text-gray-800 bg-transparent border-none outline-none cursor-pointer appearance-none pr-4 ml-1">
                                            </select>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-500 -ml-3 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </div>

                                        <button type="button" onclick="changeMonth(1)" class="h-7 w-7 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-500 transition cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </button>
                                    </div>

                                    {{-- Day headers --}}
                                    <div class="grid grid-cols-7 mb-1">
                                        @foreach(['Ming','Sen','Sel','Rab','Kam','Jum','Sa'] as $day)
                                            <div class="text-center text-[11px] font-medium text-gray-400 py-1">{{ $day }}</div>
                                        @endforeach
                                    </div>

                                    {{-- Date grid --}}
                                    <div id="dp-grid" class="grid grid-cols-7 gap-y-0.5">
                                        {{-- Filled by JS --}}
                                    </div>
                                </div>
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

        // =====================
        // Custom Date Picker
        // =====================
        const MONTHS_ID = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        const MONTHS_SHORT = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        let dpDate = new Date();
        let dpSelected = null;

        // Populate year dropdown (10 years back, 10 ahead)
        function initYearDropdown() {
            const sel = document.getElementById('dp-year');
            const cur = new Date().getFullYear();
            for (let y = cur - 10; y <= cur + 10; y++) {
                const opt = document.createElement('option');
                opt.value = y;
                opt.textContent = y;
                sel.appendChild(opt);
            }
            sel.value = dpDate.getFullYear();
        }

        function renderCalendar() {
            const grid = document.getElementById('dp-grid');
            grid.innerHTML = '';

            const year  = dpDate.getFullYear();
            const month = dpDate.getMonth();

            document.getElementById('dp-month').value = month;
            document.getElementById('dp-year').value  = year;

            // First day of month (0=Sun)
            const firstDay = new Date(year, month, 1).getDay();
            // Total days in month
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            // Days in prev month
            const daysInPrev  = new Date(year, month, 0).getDate();

            const today = new Date();

            let cells = [];

            // Prev month trailing days
            for (let i = firstDay - 1; i >= 0; i--) {
                cells.push({ day: daysInPrev - i, month: month - 1, year: month === 0 ? year - 1 : year, other: true });
            }
            // Current month
            for (let d = 1; d <= daysInMonth; d++) {
                cells.push({ day: d, month, year, other: false });
            }
            // Next month leading days
            let next = 1;
            while (cells.length % 7 !== 0) {
                cells.push({ day: next++, month: month + 1, year: month === 11 ? year + 1 : year, other: true });
            }

            cells.forEach(c => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = c.day;

                const isToday = !c.other && c.day === today.getDate() && month === today.getMonth() && year === today.getFullYear();
                const isSelected = dpSelected && !c.other &&
                    c.day === dpSelected.getDate() &&
                    month === dpSelected.getMonth() &&
                    year === dpSelected.getFullYear();

                let cls = 'w-full aspect-square flex items-center justify-center rounded-full text-[12px] transition cursor-pointer ';

                if (isSelected) {
                    cls += 'bg-blue-500 text-white font-semibold ';
                } else if (isToday) {
                    cls += 'border border-blue-400 text-blue-500 font-semibold hover:bg-blue-50 ';
                } else if (c.other) {
                    cls += 'text-gray-300 hover:bg-gray-50 ';
                } else {
                    cls += 'text-gray-700 hover:bg-gray-100 ';
                }

                btn.className = cls;

                btn.addEventListener('click', () => {
                    dpSelected = new Date(c.year, c.month, c.day);
                    dpDate = new Date(c.year, c.month, 1);

                    // Format display: DD/MM/YYYY
                    const dd = String(dpSelected.getDate()).padStart(2,'0');
                    const mm = String(dpSelected.getMonth()+1).padStart(2,'0');
                    const yyyy = dpSelected.getFullYear();

                    document.getElementById('datepicker-display').textContent = `${dd}/${mm}/${yyyy}`;
                    document.getElementById('datepicker-display').classList.remove('text-gray-400');
                    document.getElementById('datepicker-display').classList.add('text-gray-800');
                    document.getElementById('running_days_value').value = `${yyyy}-${mm}-${dd}`;

                    closeDatepicker();
                });

                grid.appendChild(btn);
            });
        }

        function toggleDatepicker() {
            const dp = document.getElementById('custom-datepicker');
            dp.classList.toggle('hidden');
            if (!dp.classList.contains('hidden')) renderCalendar();
        }

        function closeDatepicker() {
            document.getElementById('custom-datepicker').classList.add('hidden');
        }

        function changeMonth(delta) {
            dpDate.setMonth(dpDate.getMonth() + delta);
            renderCalendar();
        }

        function onMonthChange() {
            dpDate.setMonth(parseInt(document.getElementById('dp-month').value));
            renderCalendar();
        }

        function onYearChange() {
            dpDate.setFullYear(parseInt(document.getElementById('dp-year').value));
            renderCalendar();
        }

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('datepicker-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                closeDatepicker();
            }
        });

        // Init year dropdown on load
        initYearDropdown();
    </script>

</body>

</html>
