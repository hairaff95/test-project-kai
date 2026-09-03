<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Tambah Aset & Kontrak — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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

    {{-- Leaflet JS & CSS for Google Maps Interactive Preview --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="min-h-screen bg-[#F6F7F9] dark:bg-[#282A2C] font-sans antialiased text-gray-900 dark:text-gray-100 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between transition-colors duration-200">

    {{-- Top Navbar --}}
    <x-navbar active="contracts" />

    {{-- Main Content --}}
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-3.5 sm:px-8 lg:px-10 pt-3 sm:pt-6 pb-28 lg:pb-10 flex flex-col gap-4 sm:gap-6">

        {{-- Page Header & Breadcrumbs & Action Buttons --}}
        <div class="flex items-center justify-between gap-3 shrink-0">
            <div>
                <h1 class="text-lg sm:text-[26px] font-bold tracking-tight text-gray-950 dark:text-white">
                    Tambah Aset & Kontrak Baru
                </h1>
                <div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5">
                    <a href="{{ route('contracts.index') }}" class="hover:text-gray-600 dark:hover:text-white transition">Daftar Kontrak</a>
                    <span>/</span>
                    <span class="text-[#0066FF] dark:text-[#3B82F6] font-medium">Tambah Aset</span>
                </div>
            </div>

            {{-- Top Right Buttons: Simpan & Batal --}}
            <div class="flex items-center gap-2 sm:gap-2.5">
                <button
                    type="submit"
                    form="form-create-contract"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#0066FF] hover:bg-blue-700 px-3.5 sm:px-5 py-2 text-xs sm:text-sm font-semibold text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Simpan Aset</span>
                </button>

                <a
                    href="{{ route('contracts.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#E60000] hover:bg-red-700 px-3.5 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    <span>Batal</span>
                </a>
            </div>
        </div>

        {{-- Form Container: Full Width Unified Layout --}}
        <form id="form-create-contract" action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data" class="w-full flex flex-col gap-4 sm:gap-6">
            @csrf

            {{-- Validation Errors Alert --}}
            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 dark:bg-red-950/40 p-4 text-red-700 dark:text-red-300 text-xs sm:text-sm">
                    <p class="font-bold mb-1">Terjadi kesalahan pada pengisian form:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- CARD 1: INFORMASI PENYEWA --}}
            <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-4 sm:p-6 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                <div class="mb-3.5 sm:mb-4 border-b border-gray-100 dark:border-white/10 pb-2.5">
                    <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white">
                        1. Informasi Penyewa (Tenant)
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    {{-- Nama Penyewa --}}
                    <div class="flex flex-col sm:col-span-2">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Nama Penyewa / Customer (Fullname)<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nama_penyewa"
                            value="{{ old('nama_penyewa') }}"
                            placeholder="Contoh: ARIF KHUZAINI / MARDIYAH"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
                        >
                    </div>

                    {{-- Status Customer --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Status Customer<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="status_customer"
                            id="input_status_customer"
                            list="list_status_customer"
                            value="{{ old('status_customer', 'Swasta') }}"
                            placeholder="Pilih atau ketik status..."
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
                        >
                        <datalist id="list_status_customer">
                            <option value="Swasta"></option>
                            <option value="BUMN"></option>
                            <option value="Individu"></option>
                            <option value="Pemerintah"></option>
                        </datalist>
                    </div>

                    {{-- Jenis Perusahaan --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Jenis Perusahaan
                        </label>
                        <input
                            type="text"
                            name="jenis_perusahaan"
                            list="list_jenis_perusahaan"
                            value="{{ old('jenis_perusahaan', '-') }}"
                            placeholder="Contoh: - / PT / CV"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                        <datalist id="list_jenis_perusahaan">
                            <option value="-"></option>
                            <option value="PT"></option>
                            <option value="CV"></option>
                            <option value="Yayasan"></option>
                            <option value="Koperasi"></option>
                            <option value="BUMN"></option>
                            <option value="BUMD"></option>
                        </datalist>
                    </div>

                    {{-- Brand / Merek --}}
                    <div class="flex flex-col sm:col-span-2 lg:col-span-4">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Brand / Usaha
                        </label>
                        <input
                            type="text"
                            name="brand"
                            value="{{ old('brand') }}"
                            placeholder="Jika kosong, sistem akan otomatis mencatat (kosong)"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>
                </div>
            </div>

            {{-- CARD 2: INFORMASI ASET --}}
            <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-4 sm:p-6 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                <div class="mb-3.5 sm:mb-4 border-b border-gray-100 dark:border-white/10 pb-2.5">
                    <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white">
                        2. Informasi Aset KAI
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    {{-- Nomor Aset --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Nomor / Kode Aset<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="asset_number"
                            value="{{ old('asset_number') }}"
                            placeholder="Contoh: 04.01.00764"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
                        >
                    </div>

                    {{-- Jenis Aset --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Jenis Aset<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="jenis_asset"
                            id="input_jenis_asset"
                            list="list_jenis_asset"
                            value="{{ old('jenis_asset', 'Tanah') }}"
                            placeholder="Pilih atau ketik jenis aset..."
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
                        >
                        <datalist id="list_jenis_asset">
                            <option value="Tanah"></option>
                            <option value="Bangunan"></option>
                            <option value="Fasilitas"></option>
                            <option value="Rumah Perusahaan"></option>
                        </datalist>
                    </div>

                    {{-- Luas Aset --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Luas Aset (m²)
                        </label>
                        <input
                            type="text"
                            name="size_area"
                            value="{{ old('size_area', '43.5') }}"
                            placeholder="Contoh: 42 / 43.5"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Peruntukan --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Peruntukan
                        </label>
                        <input
                            type="text"
                            name="peruntukan"
                            id="input_peruntukan"
                            list="list_peruntukan"
                            value="{{ old('peruntukan', 'RUMAH TINGGAL') }}"
                            placeholder="Contoh: RUMAH TINGGAL / -"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                        <datalist id="list_peruntukan">
                            <option value="RUMAH TINGGAL"></option>
                            <option value="KANTOR"></option>
                            <option value="USAHA / BISNIS"></option>
                            <option value="GUDANG"></option>
                            <option value="TAMAN"></option>
                            <option value="-"></option>
                        </datalist>
                    </div>

                    {{-- Stasiun Terdekat --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Stasiun Terdekat
                        </label>
                        <input
                            type="text"
                            name="stasiun"
                            id="input_stasiun"
                            list="list_stasiun"
                            value="{{ old('stasiun', 'Pekalongan') }}"
                            placeholder="Pilih atau ketik stasiun..."
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                        <datalist id="list_stasiun">
                            <option value="Pekalongan"></option>
                            <option value="Semarang Tawang"></option>
                            <option value="Semarang Poncol"></option>
                            <option value="Tegal"></option>
                            <option value="Pekalongan Barat"></option>
                        </datalist>
                    </div>

                    {{-- Wilayah Aset --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Wilayah Aset
                        </label>
                        <input
                            type="text"
                            name="wilayah_asset"
                            id="input_wilayah_asset"
                            list="list_wilayah"
                            value="{{ old('wilayah_asset', 'Daop 4 Semarang') }}"
                            placeholder="Pilih atau ketik wilayah..."
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Nama Blok Aset (Full Width) --}}
                    <div class="flex flex-col sm:col-span-2 lg:col-span-2">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Nama Blok Aset / Lokasi Lengkap<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="asset_block_name"
                            value="{{ old('asset_block_name') }}"
                            placeholder="Contoh: SEKITAR KM. 2+533 S.D KM. 3+533 KEL. PRINGREJO KEC. PEKALONGAN BARAT"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
                        >
                    </div>
                </div>
            </div>

            {{-- CARD: TAMBAH GAMBAR ASET --}}
            <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-4 sm:p-6 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                <div class="flex items-center justify-between mb-3.5 sm:mb-4 border-b border-gray-100 dark:border-white/10 pb-2.5">
                    <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white">
                        Tambah Gambar<span class="text-red-500">*</span>
                    </h2>
                    <div class="flex items-center gap-1.5">
                        <button type="button" class="flex h-6 w-6 items-center justify-center rounded-[6px] bg-[#7F7F7F] dark:bg-[#383C40] text-white hover:bg-gray-600 dark:hover:bg-[#4A4E54] transition cursor-pointer shadow-xs" title="Sebelumnya">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </button>
                        <button type="button" class="flex h-6 w-6 items-center justify-center rounded-[6px] bg-[#7F7F7F] dark:bg-[#383C40] text-white hover:bg-gray-600 dark:hover:bg-[#4A4E54] transition cursor-pointer shadow-xs" title="Selanjutnya">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-4 text-left">
                    {{-- Upload Box Dashed --}}
                    <div onclick="document.getElementById('file-upload-input').click()" class="rounded-2xl border-2 border-dashed border-gray-300 dark:border-white/20 bg-transparent hover:bg-gray-50/70 dark:hover:bg-white/5 py-8 px-5 flex flex-col items-center justify-center text-center transition cursor-pointer">
                        <input type="file" name="asset_images[]" id="file-upload-input" class="hidden" accept="image/jpeg,image/png,image/webp,image/jpg" onchange="handleFileUpload(event)" multiple>
                        <x-icon name="icon-upload-gambar" class="w-16 h-16 mb-2.5 text-[#4F4F4F] dark:text-[#9AA0A6]" />
                        <p class="text-xs sm:text-[13px] font-medium text-black dark:text-white">Klik ikon untuk tambah gambar dibawah 10 MB</p>
                        <p class="text-[11px] text-gray-400 dark:text-[#9AA0A6] mt-0.5 font-normal">pilih dalam format JPEG, JPG, PNG, WEBP</p>
                    </div>

                    {{-- Container List Gambar DnD --}}
                    <div id="image-dnd-wrapper" class="space-y-3">
                        {{-- Slot Utama --}}
                        <div>
                            <label class="block text-xs font-medium text-black dark:text-white mb-1.5">Utama</label>
                            <div id="image-slot-utama" class="image-drop-target">
                                {{-- Rendered dynamically by renderImageList() --}}
                            </div>
                        </div>

                        {{-- Grid Gambar Lainnya (2 Kolom) --}}
                        <div id="image-grid-secondary" class="grid grid-cols-1 sm:grid-cols-2 gap-3 image-drop-target">
                            {{-- Rendered dynamically by renderImageList() --}}
                        </div>
                    </div>

                    {{-- Titik Koordinat G Maps (Google Maps Asli & Sinkronisasi Realtime) --}}
                    <div class="pt-3 border-t border-gray-100 dark:border-white/10 mt-4">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-950 dark:text-white mb-2">
                            Titik Koordinat G Maps<span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-[200px_1fr] gap-3.5 items-center">
                            <div class="h-[145px] sm:h-[160px] w-full rounded-2xl overflow-hidden border border-gray-200 dark:border-white/10 bg-gray-100 dark:bg-[#282A2C] relative shadow-2xs">
                                <div id="edit-map-preview" class="w-full h-full z-0"></div>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-white mb-1">Latitude</label>
                                    <input
                                        type="text"
                                        id="input-edit-latitude"
                                        name="latitude"
                                        value="{{ old('latitude', '-6.8887') }}"
                                        oninput="handleCoordinateInputChange()"
                                        placeholder="-6.8887"
                                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                    >
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-white mb-1">Longtitude</label>
                                    <input
                                        type="text"
                                        id="input-edit-longitude"
                                        name="longitude"
                                        value="{{ old('longitude', '109.6738') }}"
                                        oninput="handleCoordinateInputChange()"
                                        placeholder="109.6738"
                                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD 3: INFORMASI KONTRAK & PERIODE SEWA --}}
            <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-4 sm:p-6 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                <div class="mb-3.5 sm:mb-4 border-b border-gray-100 dark:border-white/10 pb-2.5">
                    <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white">
                        3. Informasi Kontrak & Periode Sewa
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    {{-- Nomor Kontrak --}}
                    <div class="flex flex-col sm:col-span-2">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Nomor Kontrak<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="contract_number"
                            value="{{ old('contract_number') }}"
                            placeholder="Contoh: 0004/51116/D.4/941/PK/TN/XI/2016"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
                        >
                    </div>

                    {{-- Jenis Kontrak --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Jenis Kontrak<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="jenis_kontrak"
                            id="input_jenis_kontrak"
                            list="list_jenis_kontrak"
                            value="{{ old('jenis_kontrak', 'Kontrak Sewa') }}"
                            placeholder="Pilih atau ketik jenis kontrak..."
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
                        >
                        <datalist id="list_jenis_kontrak">
                            <option value="Kontrak Sewa"></option>
                            <option value="Perjanjian Kerjasama"></option>
                            <option value="Addendum"></option>
                            <option value="Sewa Tanah"></option>
                            <option value="Sewa Bangunan"></option>
                        </datalist>
                    </div>

                    {{-- Area Kontrak --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Area Kontrak
                        </label>
                        <input
                            type="text"
                            name="area_kontrak"
                            id="input_area_kontrak"
                            list="list_wilayah"
                            value="{{ old('area_kontrak', 'Daop 4 Semarang') }}"
                            placeholder="Pilih atau ketik area..."
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Nilai Kontrak / Harga --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Nilai Kontrak / Harga (Rp)<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="price"
                            id="input-price-main"
                            oninput="syncPriceToRevenue(this.value)"
                            value="{{ old('price') }}"
                            placeholder="Contoh: 1.887.604"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
                        >
                    </div>

                    {{-- Tanggal Kontrak --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Tanggal Kontrak
                        </label>
                        <div class="relative">
                            <button
                                type="button"
                                onclick="openCalendarPicker(event, 'input-contract-date')"
                                class="absolute left-2.5 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-600 transition cursor-pointer z-10"
                            >
                                <x-icon name="icon-calendar" class="h-3.5 w-3.5 text-[#0066FF] dark:text-[#3B82F6]" />
                            </button>
                            <input
                                type="text"
                                id="input-contract-date"
                                name="contract_date"
                                value="{{ old('contract_date', date('d/m/y')) }}"
                                placeholder="DD/MM/YY"
                                class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-8 pr-2.5 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            >
                        </div>
                    </div>

                    {{-- PIC / SPV --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            SPV / Penanggung Jawab
                        </label>
                        <input
                            type="text"
                            name="spv"
                            value="{{ old('spv', 'PIC Daop 4 Semarang') }}"
                            placeholder="Nama SPV"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Keterangan --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Keterangan
                        </label>
                        <input
                            type="text"
                            name="keterangan"
                            list="list_keterangan"
                            value="{{ old('keterangan', 'RKA') }}"
                            placeholder="Contoh: RKA / Non RKA"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                        <datalist id="list_keterangan">
                            <option value="RKA"></option>
                            <option value="Non RKA"></option>
                        </datalist>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Tanggal Mulai Awal
                        </label>
                        <div class="relative">
                            <button
                                type="button"
                                onclick="openCalendarPicker(event, 'input-start-date')"
                                class="absolute left-2.5 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-600 transition cursor-pointer z-10"
                            >
                                <x-icon name="icon-calendar" class="h-3.5 w-3.5 text-[#0066FF] dark:text-[#3B82F6]" />
                            </button>
                            <input
                                type="text"
                                id="input-start-date"
                                name="start_datetime"
                                value="{{ old('start_datetime', '01/01/' . date('y')) }}"
                                placeholder="DD/MM/YY"
                                class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-8 pr-2.5 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            >
                        </div>
                    </div>

                    {{-- Tanggal Selesai (Jatuh Tempo) --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Tanggal Selesai (Jatuh Tempo)<span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <button
                                type="button"
                                onclick="openCalendarPicker(event, 'input-end-date')"
                                class="absolute left-2.5 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-600 transition cursor-pointer z-10"
                            >
                                <x-icon name="icon-calendar" class="h-3.5 w-3.5 text-[#0066FF] dark:text-[#3B82F6]" />
                            </button>
                            <input
                                type="text"
                                id="input-end-date"
                                name="end_datetime"
                                value="{{ old('end_datetime', '31/12/' . date('y')) }}"
                                placeholder="DD/MM/YY"
                                class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-8 pr-2.5 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                required
                            >
                        </div>
                    </div>

                    {{-- Tanggal Mulai Baru (Addendum/Perpanjangan) --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Tanggal Mulai Baru (Addendum)
                        </label>
                        <div class="relative">
                            <button
                                type="button"
                                onclick="openCalendarPicker(event, 'input-start-date-baru')"
                                class="absolute left-2.5 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-600 transition cursor-pointer z-10"
                            >
                                <x-icon name="icon-calendar" class="h-3.5 w-3.5 text-[#0066FF] dark:text-[#3B82F6]" />
                            </button>
                            <input
                                type="text"
                                id="input-start-date-baru"
                                name="start_datetime_baru"
                                value="{{ old('start_datetime_baru') }}"
                                placeholder="DD/MM/YY"
                                class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-8 pr-2.5 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            >
                        </div>
                    </div>

                    {{-- Tanggal Selesai Baru (Addendum/Perpanjangan) --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Tanggal Selesai Baru (Addendum)
                        </label>
                        <div class="relative">
                            <button
                                type="button"
                                onclick="openCalendarPicker(event, 'input-end-date-baru')"
                                class="absolute left-2.5 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-600 transition cursor-pointer z-10"
                            >
                                <x-icon name="icon-calendar" class="h-3.5 w-3.5 text-[#0066FF] dark:text-[#3B82F6]" />
                            </button>
                            <input
                                type="text"
                                id="input-end-date-baru"
                                name="end_datetime_baru"
                                value="{{ old('end_datetime_baru') }}"
                                placeholder="DD/MM/YY"
                                class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-8 pr-2.5 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            >
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD 4: INFORMASI KEUANGAN & RKA --}}
            <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-4 sm:p-6 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                <div class="mb-3.5 sm:mb-4 border-b border-gray-100 dark:border-white/10 pb-2.5">
                    <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white">
                        4. Informasi Keuangan, Backlog & RKA
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    {{-- Jenis Pendapatan --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Jenis Pendapatan / Wilayah
                        </label>
                        <input
                            type="text"
                            name="jenis_pendapatan"
                            id="input_jenis_pendapatan"
                            list="list_jenis_pendapatan"
                            value="{{ old('jenis_pendapatan', 'Non Row') }}"
                            placeholder="Pilih atau ketik jenis..."
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                        <datalist id="list_jenis_pendapatan">
                            <option value="Non Row"></option>
                            <option value="Row"></option>
                            <option value="Rumah Perusahaan"></option>
                            <option value="Utilitas Pengawasan"></option>
                            <option value="Iklan / Lainnya"></option>
                        </datalist>
                    </div>

                    {{-- Akun GL --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Akun GL
                        </label>
                        <input
                            type="text"
                            name="akun_gl"
                            value="{{ old('akun_gl', '3421190010') }}"
                            placeholder="Contoh: 3421190010"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Form RKA --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Form RKA
                        </label>
                        <input
                            type="text"
                            name="form_rka"
                            value="{{ old('form_rka', '-') }}"
                            placeholder="Contoh: - / RKA 2026"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Tahun RKA --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Tahun RKA
                        </label>
                        <input
                            type="text"
                            name="tahun_rka"
                            value="{{ old('tahun_rka', '0') }}"
                            placeholder="Contoh: 0 / 1 / 2026"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Nilai Pendapatan 2026 --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Pendapatan 2026 (Rp)
                        </label>
                        <input
                            type="text"
                            name="nilai_2026"
                            id="input-nilai-2026"
                            value="{{ old('nilai_2026') }}"
                            placeholder="Contoh: 781.151"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Persentase Pencapaian --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Persentase Pencapaian
                        </label>
                        <input
                            type="text"
                            name="persentase"
                            value="{{ old('persentase', '0.9') }}"
                            placeholder="Contoh: 0.9 / 90%"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Nilai Backlog 1 --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Nilai Backlog 1 (Rp)
                        </label>
                        <input
                            type="text"
                            name="nilai_backlog"
                            value="{{ old('nilai_backlog', '0') }}"
                            placeholder="0"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Nilai Backlog 2 --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Nilai Backlog 2 (Rp)
                        </label>
                        <input
                            type="text"
                            name="nilai_backlog2"
                            value="{{ old('nilai_backlog2', '0') }}"
                            placeholder="0"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>
                </div>
            </div>

            {{-- CARD 5: JADWAL PENDAPATAN BULANAN (JANUARI - DESEMBER) --}}
            <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-4 sm:p-6 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                <div class="flex items-center justify-between gap-2 mb-3.5 sm:mb-4 border-b border-gray-100 dark:border-white/10 pb-2.5">
                    <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white">
                        5. Distribusi Pendapatan Bulanan (Januari - Desember)
                    </h2>

                    <button
                        type="button"
                        onclick="autoDistributeMonthly()"
                        class="text-[11px] sm:text-xs font-semibold text-[#0066FF] dark:text-[#3B82F6] hover:underline cursor-pointer"
                    >
                        Bagi Rata 12 Bulan
                    </button>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-2.5 sm:gap-3">
                    @php
                        $months = [
                            'januari' => 'Januari',
                            'febuari' => 'Februari',
                            'maret' => 'Maret',
                            'april' => 'April',
                            'mei' => 'Mei',
                            'juni' => 'Juni',
                            'juli' => 'Juli',
                            'agustus' => 'Agustus',
                            'september' => 'September',
                            'oktober' => 'Oktober',
                            'november' => 'November',
                            'desember' => 'Desember',
                        ];
                    @endphp

                    @foreach($months as $mKey => $mName)
                        <div class="flex flex-col">
                            <label class="block text-[10px] sm:text-[11px] font-semibold text-gray-500 dark:text-[#9AA0A6] mb-0.5">
                                {{ $mName }}
                            </label>
                            <input
                                type="text"
                                name="{{ $mKey }}"
                                id="month-{{ $mKey }}"
                                value="{{ old($mKey, 0) }}"
                                class="month-input w-full h-[32px] sm:h-[34px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            >
                        </div>
                    @endforeach
                </div>
            </div>
        </form>

    </main>

    {{-- POPUP CALENDAR PICKER (Dropdown Style) --}}
    <div id="popup-calendar-picker" class="hidden absolute z-[150] w-[290px] rounded-2xl bg-white dark:bg-[#1F2123] border border-gray-100 dark:border-white/10 shadow-[0_15px_40px_rgba(0,0,0,0.16)] dark:shadow-[0_15px_40px_rgba(0,0,0,0.7)] p-4 select-none">
        {{-- Header: < [Jun ⌵] [2025 ⌵] > --}}
        <div class="flex items-center justify-between mb-3.5">
            <button type="button" onclick="calPrevMonth()" class="p-1 text-gray-500 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white transition cursor-pointer">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <div class="flex items-center gap-2">
                <div class="inline-flex items-center gap-1 border border-gray-200 dark:border-white/10 rounded-xl px-2.5 py-1 text-xs sm:text-sm font-semibold text-gray-800 dark:text-white">
                    <span id="cal-month-name">Jun</span>
                    <svg class="h-3.5 w-3.5 text-gray-500 dark:text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </div>
                <div class="inline-flex items-center gap-1 border border-gray-200 dark:border-white/10 rounded-xl px-2.5 py-1 text-xs sm:text-sm font-semibold text-gray-800 dark:text-white">
                    <span id="cal-year-val">2026</span>
                    <svg class="h-3.5 w-3.5 text-gray-500 dark:text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </div>
            </div>
            <button type="button" onclick="calNextMonth()" class="p-1 text-gray-500 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white transition cursor-pointer">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>

        {{-- Weekdays header: Ming Sen Sel Rab Kam Jum Sa --}}
        <div class="grid grid-cols-7 text-center text-xs font-semibold text-slate-500 dark:text-[#9AA0A6] mb-2">
            <div>Ming</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sa</div>
        </div>

        {{-- Days grid --}}
        <div id="cal-days-grid" class="grid grid-cols-7 text-center text-xs font-medium gap-y-1">
            {{-- Rendered via JS --}}
        </div>
    </div>

    {{-- Footer Copyright --}}
    <footer class="w-full text-center py-4 text-xs text-gray-400 dark:text-[#787E87] border-t border-gray-100 dark:border-white/5">
        &copy; {{ date('Y') }} PT Kereta Api Indonesia (Persero) Daop 4 Semarang. All rights reserved.
    </footer>

    <script>
        // ================= IMAGE LIST & DRAG-DROP SYSTEM =================
        let uploadedImages = [
            { id: 'img-1', name: 'gambar-utama.jpg', size: '10 MB' },
            { id: 'img-2', name: 'gambar-1.jpg', size: '10 MB' },
            { id: 'img-3', name: 'gambar-2.jpg', size: '10 MB' },
            { id: 'img-4', name: 'gambar-3.jpg', size: '10 MB' }
        ];

        let draggedImageIdx = null;

        function renderImageList() {
            const utamaSlot = document.getElementById('image-slot-utama');
            const secondaryGrid = document.getElementById('image-grid-secondary');
            if (!utamaSlot || !secondaryGrid) return;

            if (uploadedImages.length === 0) {
                utamaSlot.innerHTML = `<div class="text-xs text-gray-400 dark:text-[#9AA0A6] p-4 border border-dashed border-gray-300 dark:border-white/10 rounded-xl text-center">Belum ada gambar yang ditambahkan</div>`;
                secondaryGrid.innerHTML = '';
                return;
            }

            // 1. Render Utama (Index 0) - Large card layout
            const mainImg = uploadedImages[0];
            utamaSlot.innerHTML = `
                <div draggable="true" 
                     ondragstart="handleImageDragStart(event, 0)" 
                     ondragover="handleImageDragOver(event)" 
                     ondrop="handleImageDrop(event, 0)" 
                     class="image-dnd-card rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] p-3 flex items-center justify-between shadow-2xs cursor-grab active:cursor-grabbing hover:border-blue-400 transition select-none">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-12 sm:w-14 h-12 sm:h-14 rounded-lg bg-[#d8d8d8] dark:bg-[#383C40] shrink-0 flex items-center justify-center text-gray-400">
                            <svg class="h-5 sm:h-6 w-5 sm:w-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                        <div class="truncate">
                            <p class="text-xs sm:text-sm font-medium text-black dark:text-white truncate">${mainImg.name}</p>
                            <p class="text-[10px] sm:text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5">${mainImg.size}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="removeUploadedImage(0)" class="text-gray-400 hover:text-red-500 p-1 transition cursor-pointer" title="Hapus gambar">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                        </button>
                        <div class="text-gray-400 hover:text-gray-600 pl-1 shrink-0 cursor-grab">
                            <svg class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.6169 6.92501C15.7491 6.92501 16.6669 6.0072 16.6669 4.87501C16.6669 3.74283 15.7491 2.82501 14.6169 2.82501C13.4847 2.82501 12.5669 3.74283 12.5669 4.87501C12.5669 6.0072 13.4847 6.92501 14.6169 6.92501Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path opacity="0.4" d="M5.3835 6.92501C6.51569 6.92501 7.43349 6.0072 7.43349 4.87501C7.43349 3.74283 6.51569 2.82501 5.3835 2.82501C4.25132 2.82501 3.3335 3.74283 3.3335 4.87501C3.3335 6.0072 4.25132 6.92501 5.3835 6.92501Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path opacity="0.4" d="M14.6169 17.175C15.7491 17.175 16.6669 16.2572 16.6669 15.125C16.6669 13.9928 15.7491 13.075 14.6169 13.075C13.4847 13.075 12.5669 13.9928 12.5669 15.125C12.5669 16.2572 13.4847 17.175 14.6169 17.175Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5.3835 17.175C6.51569 17.175 7.43349 16.2572 7.43349 15.125C7.43349 13.9928 6.51569 13.075 5.3835 13.075C4.25132 13.075 3.3335 13.9928 3.3335 15.125C3.3335 16.2572 4.25132 17.175 5.3835 17.175Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </div>
            `;

            // 2. Render Secondary (Index 1 .. N) - 2 columns grid layout
            secondaryGrid.innerHTML = uploadedImages.slice(1).map((img, idx) => {
                const actualIndex = idx + 1;
                return `
                    <div draggable="true" 
                         ondragstart="handleImageDragStart(event, ${actualIndex})" 
                         ondragover="handleImageDragOver(event)" 
                         ondrop="handleImageDrop(event, ${actualIndex})" 
                         class="image-dnd-card rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] p-2.5 flex items-center justify-between shadow-2xs cursor-grab active:cursor-grabbing hover:border-blue-400 transition select-none">
                        <div class="flex items-center gap-2.5 overflow-hidden">
                            <div class="w-10 sm:w-11 h-10 sm:h-11 rounded-lg bg-[#d8d8d8] dark:bg-[#383C40] shrink-0 flex items-center justify-center text-gray-400">
                                <svg class="h-4 sm:h-5 w-4 sm:w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                            <div class="truncate">
                                <p class="text-xs font-medium text-black dark:text-white truncate">${img.name}</p>
                                <p class="text-[10px] text-gray-400 dark:text-[#9AA0A6] mt-0.5">${img.size}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <button type="button" onclick="removeUploadedImage(${actualIndex})" class="text-gray-400 hover:text-red-500 p-1 transition cursor-pointer" title="Hapus gambar">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                            <div class="text-gray-400 hover:text-gray-600 pl-1 shrink-0 cursor-grab">
                                <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.6169 6.92501C15.7491 6.92501 16.6669 6.0072 16.6669 4.87501C16.6669 3.74283 15.7491 2.82501 14.6169 2.82501C13.4847 2.82501 12.5669 3.74283 12.5669 4.87501C12.5669 6.0072 13.4847 6.92501 14.6169 6.92501Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path opacity="0.4" d="M5.3835 6.92501C6.51569 6.92501 7.43349 6.0072 7.43349 4.87501C7.43349 3.74283 6.51569 2.82501 5.3835 2.82501C4.25132 2.82501 3.3335 3.74283 3.3335 4.87501C3.3335 6.0072 4.25132 6.92501 5.3835 6.92501Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path opacity="0.4" d="M14.6169 17.175C15.7491 17.175 16.6669 16.2572 16.6669 15.125C16.6669 13.9928 15.7491 13.075 14.6169 13.075C13.4847 13.075 12.5669 13.9928 12.5669 15.125C12.5669 16.2572 13.4847 17.175 14.6169 17.175Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M5.3835 17.175C6.51569 17.175 7.43349 16.2572 7.43349 15.125C7.43349 13.9928 6.51569 13.075 5.3835 13.075C4.25132 13.075 3.3335 13.9928 3.3335 15.125C3.3335 16.2572 4.25132 17.175 5.3835 17.175Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function handleImageDragStart(e, index) {
            draggedImageIdx = index;
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', index);
            setTimeout(() => {
                if (e.target) e.target.classList.add('opacity-40');
            }, 0);
        }

        function handleImageDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
        }

        function handleImageDrop(e, targetIndex) {
            e.preventDefault();
            if (draggedImageIdx === null || draggedImageIdx === targetIndex) return;

            const movedItem = uploadedImages.splice(draggedImageIdx, 1)[0];
            uploadedImages.splice(targetIndex, 0, movedItem);
            draggedImageIdx = null;
            renderImageList();
        }

        function handleFileUpload(e) {
            const files = Array.from(e.target.files);
            files.forEach((file, i) => {
                uploadedImages.push({
                    id: 'img-' + Date.now() + '-' + i,
                    name: file.name,
                    size: (file.size / (1024 * 1024)).toFixed(1) + ' MB'
                });
            });
            renderImageList();
        }

        function removeUploadedImage(index) {
            uploadedImages.splice(index, 1);
            renderImageList();
        }

        // ================= GOOGLE MAPS INTERACTIVE PREVIEW & SYNC =================
        let editMapInstance = null;
        let editMapMarker = null;

        function initEditMapPreview() {
            const mapContainer = document.getElementById('edit-map-preview');
            if (!mapContainer || typeof L === 'undefined') return;

            const latInput = document.getElementById('input-edit-latitude');
            const lngInput = document.getElementById('input-edit-longitude');

            let initialLat = latInput ? parseFloat(latInput.value) : -6.8887;
            let initialLng = lngInput ? parseFloat(lngInput.value) : 109.6738;

            if (isNaN(initialLat)) initialLat = -6.8887;
            if (isNaN(initialLng)) initialLng = 109.6738;

            if (!editMapInstance) {
                editMapInstance = L.map('edit-map-preview', {
                    zoomControl: false,
                    attributionControl: false
                }).setView([initialLat, initialLng], 14);

                // Google Maps Layer
                L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }).addTo(editMapInstance);

                // Custom Red Pin Marker
                const pinIcon = L.divIcon({
                    className: 'bg-transparent border-0',
                    html: `
                        <div style="transform: translate(-14px, -28px); width: 28px; height: 28px; cursor: grab;">
                            <svg class="w-7 h-7 drop-shadow-md" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.62 8.45C19.57 3.83 15.54 1.75 12 1.75C12 1.75 12 1.75 11.99 1.75C8.45997 1.75 4.41997 3.82 3.36997 8.44C2.19997 13.6 5.35997 17.97 8.21997 20.72C9.27997 21.74 10.64 22.25 12 22.25C13.36 22.25 14.72 21.74 15.77 20.72C18.63 17.97 21.79 13.61 20.62 8.45Z" fill="#E52500"/>
                                <circle cx="12" cy="10.5" r="3.2" fill="white"/>
                            </svg>
                        </div>
                    `,
                    iconSize: [0, 0]
                });

                editMapMarker = L.marker([initialLat, initialLng], {
                    draggable: true,
                    icon: pinIcon
                }).addTo(editMapInstance);

                // Marker drag events
                editMapMarker.on('drag', function(e) {
                    const pos = e.target.getLatLng();
                    if (latInput) latInput.value = pos.lat.toFixed(6);
                    if (lngInput) lngInput.value = pos.lng.toFixed(6);
                });

                editMapMarker.on('dragend', function(e) {
                    const pos = e.target.getLatLng();
                    if (latInput) latInput.value = pos.lat.toFixed(6);
                    if (lngInput) lngInput.value = pos.lng.toFixed(6);
                    editMapInstance.panTo(pos);
                });

                // Map click event
                editMapInstance.on('click', function(e) {
                    const pos = e.latlng;
                    editMapMarker.setLatLng(pos);
                    if (latInput) latInput.value = pos.lat.toFixed(6);
                    if (lngInput) lngInput.value = pos.lng.toFixed(6);
                    editMapInstance.panTo(pos);
                });
            } else {
                editMapInstance.setView([initialLat, initialLng], 14);
                editMapMarker.setLatLng([initialLat, initialLng]);
            }

            setTimeout(() => {
                if (editMapInstance) {
                    editMapInstance.invalidateSize();
                }
            }, 200);
        }

        function handleCoordinateInputChange() {
            const latInput = document.getElementById('input-edit-latitude');
            const lngInput = document.getElementById('input-edit-longitude');
            if (!latInput || !lngInput || !editMapInstance || !editMapMarker) return;

            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);

            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                const newPos = [lat, lng];
                editMapMarker.setLatLng(newPos);
                editMapInstance.panTo(newPos);
            }
        }

        // Initialize Image List and Maps on Load
        document.addEventListener('DOMContentLoaded', function() {
            renderImageList();
            initEditMapPreview();
        });

        function syncPriceToRevenue(val) {
            const inputRev = document.getElementById('input-nilai-2026');
            if (inputRev && (!inputRev.value || inputRev.value === val)) {
                inputRev.value = val;
            }
        }

        function autoDistributeMonthly() {
            const mainPrice = document.getElementById('input-price-main').value;
            const cleanNum = parseFloat(mainPrice.replace(/[^\d]/g, '')) || 0;
            const portion = Math.round(cleanNum / 12);
            const formatted = portion.toLocaleString('id-ID');

            const monthInputs = document.querySelectorAll('.month-input');
            monthInputs.forEach(input => {
                input.value = formatted;
            });
        }

        // ================= POPUP CALENDAR LOGIC =================
        let calTargetInputId = null;
        let calCurrentYear = new Date().getFullYear();
        let calCurrentMonth = new Date().getMonth();

        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        function renderCalendar() {
            const monthNameEl = document.getElementById('cal-month-name');
            const yearValEl = document.getElementById('cal-year-val');
            const daysGridEl = document.getElementById('cal-days-grid');

            if (!monthNameEl || !daysGridEl) return;

            monthNameEl.textContent = monthNames[calCurrentMonth];
            yearValEl.textContent = calCurrentYear;

            daysGridEl.innerHTML = '';

            const firstDayIndex = new Date(calCurrentYear, calCurrentMonth, 1).getDay();
            const totalDaysInMonth = new Date(calCurrentYear, calCurrentMonth + 1, 0).getDate();
            const prevMonthTotalDays = new Date(calCurrentYear, calCurrentMonth, 0).getDate();

            // Previous month overflow days
            for (let i = firstDayIndex - 1; i >= 0; i--) {
                const dayNum = prevMonthTotalDays - i;
                const cell = document.createElement('div');
                cell.className = 'py-1 text-gray-400 dark:text-gray-600 text-center pointer-events-none select-none';
                cell.textContent = dayNum;
                daysGridEl.appendChild(cell);
            }

            // Current month days
            for (let d = 1; d <= totalDaysInMonth; d++) {
                const cell = document.createElement('button');
                cell.type = 'button';

                let isSelected = false;
                if (calTargetInputId) {
                    const inputEl = document.getElementById(calTargetInputId);
                    if (inputEl && inputEl.value) {
                        const parts = inputEl.value.split('/');
                        if (parts.length === 3) {
                            const selD = parseInt(parts[0], 10);
                            const selM = parseInt(parts[1], 10) - 1;
                            let selY = parseInt(parts[2], 10);
                            if (selY < 100) selY += 2000;
                            if (selD === d && selM === calCurrentMonth && selY === calCurrentYear) {
                                isSelected = true;
                            }
                        }
                    }
                }

                if (isSelected) {
                    cell.className = 'h-7 w-7 mx-auto flex items-center justify-center rounded-full bg-[#0066FF] text-white font-semibold shadow-xs cursor-pointer';
                } else {
                    cell.className = 'h-7 w-7 mx-auto flex items-center justify-center rounded-full text-gray-800 dark:text-white hover:bg-blue-50 dark:hover:bg-white/10 hover:text-[#0066FF] dark:hover:text-[#3B82F6] font-medium transition cursor-pointer';
                }

                cell.textContent = d;
                cell.onclick = function () {
                    selectCalendarDate(d, calCurrentMonth, calCurrentYear);
                };
                daysGridEl.appendChild(cell);
            }

            // Next month overflow days
            const totalRendered = firstDayIndex + totalDaysInMonth;
            const remainingCells = (totalRendered % 7 === 0) ? 0 : 7 - (totalRendered % 7);
            for (let n = 1; n <= remainingCells; n++) {
                const cell = document.createElement('div');
                cell.className = 'py-1 text-gray-400 dark:text-gray-600 text-center pointer-events-none select-none';
                cell.textContent = n;
                daysGridEl.appendChild(cell);
            }
        }

        function calPrevMonth() {
            calCurrentMonth--;
            if (calCurrentMonth < 0) {
                calCurrentMonth = 11;
                calCurrentYear--;
            }
            renderCalendar();
        }

        function calNextMonth() {
            calCurrentMonth++;
            if (calCurrentMonth > 11) {
                calCurrentMonth = 0;
                calCurrentYear++;
            }
            renderCalendar();
        }

        function openCalendarPicker(e, targetInputId) {
            e.stopPropagation();
            calTargetInputId = targetInputId;
            const picker = document.getElementById('popup-calendar-picker');
            const targetBtn = e.currentTarget;
            const container = targetBtn.closest('.relative') || targetBtn.parentElement;

            // Pre-set month and year if target input has a valid date
            const inputEl = document.getElementById(targetInputId);
            if (inputEl && inputEl.value) {
                const parts = inputEl.value.split('/');
                if (parts.length === 3) {
                    const selM = parseInt(parts[1], 10) - 1;
                    let selY = parseInt(parts[2], 10);
                    if (selY < 100) selY += 2000;
                    if (!isNaN(selM) && !isNaN(selY) && selM >= 0 && selM <= 11) {
                        calCurrentMonth = selM;
                        calCurrentYear = selY;
                    }
                }
            }

            renderCalendar();

            // Pindahkan picker langsung ke dalam container input (.relative) agar menempel persis seperti dropdown
            container.appendChild(picker);
            picker.classList.remove('hidden');

            const containerRect = container.getBoundingClientRect();
            const popupHeight = picker.offsetHeight || 315;
            const spaceBelow = window.innerHeight - containerRect.bottom;
            const spaceAbove = containerRect.top;

            picker.style.position = 'absolute';
            picker.style.zIndex = '150';

            // Vertikal: Buka di ATAS jika mepet bawah layar, atau di BAWAH secara default
            if (spaceBelow < popupHeight && spaceAbove > spaceBelow) {
                picker.style.top = 'auto';
                picker.style.bottom = 'calc(100% + 4px)';
            } else {
                picker.style.bottom = 'auto';
                picker.style.top = 'calc(100% + 4px)';
            }

            // Horizontal: Menempel di sisi kiri input (atau sisi kanan jika mentok layar)
            if (containerRect.left + 295 > window.innerWidth) {
                picker.style.left = 'auto';
                picker.style.right = '0';
            } else {
                picker.style.left = '0';
                picker.style.right = 'auto';
            }
        }

        function closeCalendarPicker() {
            const picker = document.getElementById('popup-calendar-picker');
            if (picker) {
                picker.classList.add('hidden');
            }
        }

        function selectCalendarDate(day, monthIndex, year) {
            if (calTargetInputId) {
                const targetInput = document.getElementById(calTargetInputId);
                if (targetInput) {
                    const dd = String(day).padStart(2, '0');
                    const mm = String(monthIndex + 1).padStart(2, '0');
                    const yy = String(year).slice(-2);
                    targetInput.value = `${dd}/${mm}/${yy}`;
                }
            }
            closeCalendarPicker();
        }

        // ================= CUSTOM DROPDOWN LOGIC (MATCHING TABLE FILTER) =================
        window.selectCustomDropdown = function(fieldName, value) {
            const input = document.getElementById('input_' + fieldName);
            if (input) {
                input.value = value;
            }
            const container = input ? input.closest('.custom-filter-container') : null;
            if (container) {
                const labelSpan = container.querySelector('.filter-selected-label');
                if (labelSpan) {
                    labelSpan.textContent = value;
                }
                const options = container.querySelectorAll('.filter-option-btn');
                options.forEach(btn => {
                    if (btn.querySelector('span')?.textContent.trim() === value.trim()) {
                        btn.className = "filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6] rounded-lg transition text-left cursor-pointer";
                    } else {
                        btn.className = "filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer";
                    }
                });
                const menu = container.querySelector('.filter-dropdown-menu');
                if (menu) closeSmoothDropdown(menu);
                const arrow = container.querySelector('.filter-dropdown-arrow');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        };

        function openSmoothDropdown(el) {
            if (!el) return;
            el.classList.remove('opacity-0', 'invisible', 'scale-95', 'pointer-events-none');
            el.classList.add('opacity-100', 'visible', 'scale-100', 'pointer-events-auto');
        }
        function closeSmoothDropdown(el) {
            if (!el) return;
            el.classList.add('opacity-0', 'invisible', 'scale-95', 'pointer-events-none');
            el.classList.remove('opacity-100', 'visible', 'scale-100', 'pointer-events-auto');
        }
        function isSmoothDropdownOpen(el) {
            return el && !el.classList.contains('invisible');
        }

        document.addEventListener('click', function (e) {
            const dropdownBtn = e.target.closest('.filter-dropdown-btn');
            const allDropdownMenus = document.querySelectorAll('.filter-dropdown-menu');
            const allDropdownArrows = document.querySelectorAll('.filter-dropdown-arrow');

            if (dropdownBtn) {
                e.stopPropagation();
                const container = dropdownBtn.closest('.custom-filter-container');
                const menu = container ? container.querySelector('.filter-dropdown-menu') : null;
                const arrow = dropdownBtn.querySelector('.filter-dropdown-arrow');
                const wasOpen = isSmoothDropdownOpen(menu);

                allDropdownMenus.forEach(closeSmoothDropdown);
                allDropdownArrows.forEach(a => a.classList.remove('rotate-180'));

                if (!wasOpen && menu) {
                    openSmoothDropdown(menu);
                    if (arrow) arrow.classList.add('rotate-180');
                }
            } else if (!e.target.closest('.filter-dropdown-menu')) {
                allDropdownMenus.forEach(closeSmoothDropdown);
                allDropdownArrows.forEach(a => a.classList.remove('rotate-180'));
            }

            if (!e.target.closest('#popup-calendar-picker') && !e.target.closest('[onclick*="openCalendarPicker"]')) {
                closeCalendarPicker();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeCalendarPicker();
                document.querySelectorAll('.filter-dropdown-menu').forEach(closeSmoothDropdown);
                document.querySelectorAll('.filter-dropdown-arrow').forEach(a => a.classList.remove('rotate-180'));
            }
        });
    {{-- Global Shared Datalists --}}
    <datalist id="list_wilayah">
        <option value="Daop 4 Semarang"></option>
        <option value="Daop 1 Jakarta"></option>
        <option value="Daop 2 Bandung"></option>
        <option value="Daop 3 Cirebon"></option>
        <option value="Daop 5 Purwokerto"></option>
        <option value="Daop 6 Yogyakarta"></option>
        <option value="Daop 7 Madiun"></option>
        <option value="Daop 8 Surabaya"></option>
        <option value="Daop 9 Jember"></option>
    </datalist>

    <x-temp-password-guard />
</body>
</html>
