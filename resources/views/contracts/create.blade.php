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
        <form id="form-create-contract" action="{{ route('contracts.store') }}" method="POST" class="w-full flex flex-col gap-4 sm:gap-6">
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
                            Nama Penyewa / Customer<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nama_penyewa"
                            value="{{ old('nama_penyewa') }}"
                            placeholder="Contoh: PT Kargo Cepat Pantura / Drs. Bambang"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
                        >
                    </div>

                    {{-- Status Customer --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Status Customer<span class="text-red-500">*</span>
                        </label>
                        <div class="relative custom-filter-container w-full">
                            <input type="hidden" name="status_customer" id="input_status_customer" value="{{ old('status_customer', 'Swasta') }}">
                            <button type="button" class="filter-dropdown-btn flex items-center justify-between w-full h-[36px] bg-white dark:bg-[#282A2C] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-lg px-3 py-1.5 transition cursor-pointer">
                                <span class="filter-selected-label text-gray-800 dark:text-white font-normal text-xs select-none truncate">
                                    {{ old('status_customer', 'Swasta') }}
                                </span>
                                <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 dark:text-[#9AA0A6] ml-1 shrink-0 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                            </button>
                            <div class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[160px] max-h-[220px] overflow-y-auto rounded-lg bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1.5 flex flex-col gap-0.5">
                                <button type="button" onclick="selectCustomDropdown('status_customer', 'Swasta')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('status_customer', 'Swasta') == 'Swasta' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>Swasta</span>
                                </button>
                                <button type="button" onclick="selectCustomDropdown('status_customer', 'BUMN')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('status_customer') == 'BUMN' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>BUMN</span>
                                </button>
                                <button type="button" onclick="selectCustomDropdown('status_customer', 'Individu')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('status_customer') == 'Individu' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>Individu</span>
                                </button>
                                <button type="button" onclick="selectCustomDropdown('status_customer', 'Pemerintah')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('status_customer') == 'Pemerintah' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>Pemerintah</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Brand / Merek --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Brand / Usaha
                        </label>
                        <input
                            type="text"
                            name="brand"
                            value="{{ old('brand') }}"
                            placeholder="Contoh: Kargo Cepat / Indomaret"
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
                        <div class="relative custom-filter-container w-full">
                            <input type="hidden" name="jenis_asset" id="input_jenis_asset" value="{{ old('jenis_asset', 'Tanah') }}">
                            <button type="button" class="filter-dropdown-btn flex items-center justify-between w-full h-[36px] bg-white dark:bg-[#282A2C] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-lg px-3 py-1.5 transition cursor-pointer">
                                <span class="filter-selected-label text-gray-800 dark:text-white font-normal text-xs select-none truncate">
                                    {{ old('jenis_asset', 'Tanah') }}
                                </span>
                                <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 dark:text-[#9AA0A6] ml-1 shrink-0 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                            </button>
                            <div class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[160px] max-h-[220px] overflow-y-auto rounded-lg bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1.5 flex flex-col gap-0.5">
                                <button type="button" onclick="selectCustomDropdown('jenis_asset', 'Tanah')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('jenis_asset', 'Tanah') == 'Tanah' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>Tanah</span>
                                </button>
                                <button type="button" onclick="selectCustomDropdown('jenis_asset', 'Bangunan')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('jenis_asset') == 'Bangunan' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>Bangunan</span>
                                </button>
                                <button type="button" onclick="selectCustomDropdown('jenis_asset', 'Fasilitas')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('jenis_asset') == 'Fasilitas' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>Fasilitas</span>
                                </button>
                                <button type="button" onclick="selectCustomDropdown('jenis_asset', 'Rumah Perusahaan')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('jenis_asset') == 'Rumah Perusahaan' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>Rumah Perusahaan</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Luas Aset --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Luas Aset (m²)
                        </label>
                        <input
                            type="number"
                            step="any"
                            name="size_area"
                            value="{{ old('size_area', 50) }}"
                            placeholder="Contoh: 120"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Stasiun Terdekat --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Stasiun Terdekat
                        </label>
                        <input
                            type="text"
                            name="stasiun"
                            value="{{ old('stasiun', 'Semarang') }}"
                            placeholder="Contoh: Pekalongan / Tegal / Semarang"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Nama Blok Aset (Full Width) --}}
                    <div class="flex flex-col sm:col-span-2 lg:col-span-3">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Nama Blok Aset / Lokasi Lengkap<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="asset_block_name"
                            value="{{ old('asset_block_name') }}"
                            placeholder="Contoh: SEKITAR KM 2+1/200 LINTAS NON OPERASI KEL. TEGALREJO PEKALONGAN"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
                        >
                    </div>

                    {{-- Wilayah Aset --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Wilayah Aset
                        </label>
                        <input
                            type="text"
                            name="wilayah_asset"
                            value="{{ old('wilayah_asset', 'Daop 4 Semarang') }}"
                            placeholder="Daop 4 Semarang"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
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
                            placeholder="Contoh: 0005/51116/D.4/941/PK/TN/XII/2026"
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
                            value="{{ old('jenis_kontrak', 'Kontrak Sewa') }}"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
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
                            placeholder="Contoh: 15.000.000"
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
                        4. Informasi Keuangan & RKA
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    {{-- Jenis Pendapatan --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Jenis Pendapatan
                        </label>
                        <div class="relative custom-filter-container w-full">
                            <input type="hidden" name="jenis_pendapatan" id="input_jenis_pendapatan" value="{{ old('jenis_pendapatan', 'Row') }}">
                            <button type="button" class="filter-dropdown-btn flex items-center justify-between w-full h-[36px] bg-white dark:bg-[#282A2C] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-lg px-3 py-1.5 transition cursor-pointer">
                                <span class="filter-selected-label text-gray-800 dark:text-white font-normal text-xs select-none truncate">
                                    {{ old('jenis_pendapatan', 'Row') }}
                                </span>
                                <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 dark:text-[#9AA0A6] ml-1 shrink-0 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                            </button>
                            <div class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[180px] max-h-[220px] overflow-y-auto rounded-lg bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1.5 flex flex-col gap-0.5">
                                <button type="button" onclick="selectCustomDropdown('jenis_pendapatan', 'Row')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('jenis_pendapatan', 'Row') == 'Row' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>Row</span>
                                </button>
                                <button type="button" onclick="selectCustomDropdown('jenis_pendapatan', 'Non Row')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('jenis_pendapatan') == 'Non Row' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>Non Row</span>
                                </button>
                                <button type="button" onclick="selectCustomDropdown('jenis_pendapatan', 'Rumah Perusahaan')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('jenis_pendapatan') == 'Rumah Perusahaan' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>Rumah Perusahaan</span>
                                </button>
                                <button type="button" onclick="selectCustomDropdown('jenis_pendapatan', 'Utilitas Pengawasan')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('jenis_pendapatan') == 'Utilitas Pengawasan' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>Utilitas Pengawasan</span>
                                </button>
                                <button type="button" onclick="selectCustomDropdown('jenis_pendapatan', 'Iklan / Lainnya')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg transition text-left cursor-pointer {{ old('jenis_pendapatan') == 'Iklan / Lainnya' ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                                    <span>Iklan / Lainnya</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Akun GL --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Akun GL
                        </label>
                        <input
                            type="text"
                            name="akun_gl"
                            value="{{ old('akun_gl', '40110000') }}"
                            placeholder="40110000"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Nilai Pendapatan 2026 --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Target Pendapatan 2026 (Rp)
                        </label>
                        <input
                            type="text"
                            name="nilai_2026"
                            id="input-nilai-2026"
                            value="{{ old('nilai_2026') }}"
                            placeholder="Otomatis dari Nilai Kontrak"
                            class="w-full h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Persentase Pencapaian --}}
                    <div class="flex flex-col">
                        <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-1">
                            Persentase Pencapaian (%)
                        </label>
                        <input
                            type="text"
                            name="persentase"
                            value="{{ old('persentase', '100') }}"
                            placeholder="100%"
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

            {{-- Bottom Submit Buttons --}}
            <div class="flex items-center justify-end gap-2.5 pt-2 pb-6">
                <a
                    href="{{ route('contracts.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-gray-200 dark:bg-[#34383D] hover:bg-gray-300 dark:hover:bg-[#43484E] px-4 py-2.5 text-xs sm:text-sm font-semibold text-gray-700 dark:text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#0066FF] hover:bg-blue-700 px-5 sm:px-6 py-2.5 text-xs sm:text-sm font-semibold text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Simpan & Tambah Aset</span>
                </button>
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
    </script>
<x-temp-password-guard />
</body>
</html>
