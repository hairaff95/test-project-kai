<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Edit Daftar Kontrak — KAI Tracker App</title>

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
                    Edit Daftar Kontrak
                </h1>
                <div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5">
                    <a href="{{ route('contracts.index') }}" class="hover:text-gray-600 dark:hover:text-white transition">Daftar Kontrak</a>
                    <span>/</span>
                    <span class="text-[#0066FF] dark:text-[#3B82F6] font-medium">Edit</span>
                </div>
            </div>

            {{-- Top Right Buttons: Simpan & Batal --}}
            <div class="flex items-center gap-2 sm:gap-2.5">
                <button
                    type="submit"
                    form="form-edit-contract"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#0066FF] hover:bg-blue-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Simpan</span>
                </button>

                <a
                    href="{{ route('contracts.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#E60000] hover:bg-red-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    <span>Batal</span>
                </a>
            </div>
        </div>

        {{-- Form & Grid Container --}}
        <form id="form-edit-contract" action="{{ route('contracts.update', $contract->asset_number ?? $contract->contract_number) }}" method="POST" class="w-full">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_380px] xl:grid-cols-[1fr_420px] gap-3.5 sm:gap-6 items-start">

                {{-- Left Column: 2 White Cards --}}
                <div class="flex flex-col gap-3.5 sm:gap-6">

                    {{-- CARD 1: INFORMASI PENYEWA --}}
                    <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3 sm:p-5 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                        <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white mb-2 sm:mb-3.5">
                            Informasi Penyewa
                        </h2>

                        <div class="space-y-2 sm:space-y-3">
                            {{-- Nama Penyewa --}}
                            <div class="flex flex-col w-full">
                                <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                    Nama Penyewa<span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="nama_penyewa"
                                    value="{{ old('nama_penyewa', $contract->tenant?->fullname ?? 'PT Kargo Cepat Pantura') }}"
                                    class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                    required
                                >
                            </div>

                            {{-- Status Customer --}}
                            <div class="flex flex-col w-full">
                                <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                    Status Customer<span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="status_customer"
                                    value="{{ old('status_customer', $contract->tenant?->status_customer ?? 'Tidak Aktif') }}"
                                    class="w-full sm:w-48 max-w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                    required
                                >
                            </div>
                        </div>
                    </div>


                    {{-- CARD 2: INFORMASI KONTRAK --}}
                    <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3 sm:p-5 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                        <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white mb-2 sm:mb-3.5">
                            Informasi Kontrak
                        </h2>

                        <div class="space-y-2 sm:space-y-3">
                            {{-- No Kontrak & Waktu Kontrak --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        No Kontrak<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="contract_number"
                                        value="{{ old('contract_number', $contract->contract_number ?? 'KTR-2026-SMG-PCL-001') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>

                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        Waktu Kontrak<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="waktu_kontrak"
                                        value="{{ old('waktu_kontrak', $contract->contract_duration ? $contract->contract_duration . ' Bulan' : '12 Bulan') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Nama Blok Aset --}}
                            <div class="flex flex-col w-full">
                                <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                    Nama Blok Aset<span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    name="asset_block_name"
                                    rows="2"
                                    class="w-full min-h-[44px] sm:min-h-[60px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 py-1.5 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition resize-none leading-relaxed font-normal"
                                    required
                                >{{ old('asset_block_name', $contract->asset?->asset_block_name ?? 'PT Kargo Cepat Pantura') }}</textarea>
                            </div>

                            {{-- Brand & Nilai Kontrak --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        Brand<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="brand"
                                        value="{{ old('brand', $contract->tenant?->brand ?? 'Kargo Cepat') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>

                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        Nilai Kontrak<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="nilai_kontrak"
                                        value="{{ old('nilai_kontrak', $contract->price_formatted ?? 'Rp 45.000.000') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Tanggal Kontrak: Mulai & Selesai --}}
                            <div>
                                <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                    Tanggal Kontrak<span class="text-red-500">*</span>
                                </label>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                    {{-- Mulai --}}
                                    <div class="flex flex-col w-full">
                                        <label class="block text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6] mb-0.5">Mulai</label>
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
                                                name="start_date"
                                                value="{{ $contract->contract_date ? \Carbon\Carbon::parse($contract->contract_date)->format('d/m/y') : '01/01/25' }}"
                                                placeholder="DD/MM/YY"
                                                class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-8 pr-2.5 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                            >
                                        </div>
                                    </div>

                                    {{-- Selesai --}}
                                    <div class="flex flex-col w-full">
                                        <label class="block text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6] mb-0.5">Selesai</label>
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
                                                name="end_date"
                                                value="{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d/m/y') : '31/12/25' }}"
                                                placeholder="DD/MM/YY"
                                                class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-8 pr-2.5 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                {{-- Right Column: CARD KUSTOM TABLE --}}
                <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3 sm:p-5 shadow-[0_4px_25px_rgba(0,0,0,0.03)] h-fit transition-colors">
                    <div class="flex items-center justify-between mb-2 sm:mb-3">
                        <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white">
                            Kustom Table
                        </h2>
                        <button
                            type="button"
                            onclick="resetTableColumns()"
                            class="text-[11px] sm:text-xs font-medium text-[#0066FF] dark:text-[#3B82F6] hover:text-blue-700 transition cursor-pointer"
                        >
                            Reset
                        </button>
                    </div>

                    <h3 class="text-[11px] sm:text-xs font-semibold text-gray-800 dark:text-white mb-0.5">
                        Ubah Urutan Kolom
                    </h3>
                    <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6] mb-2.5 sm:mb-3.5 leading-relaxed">
                        Ubah urutan kolom dengan geser pada icon, dan sesuaikan untuk tampilan urutannya.
                    </p>

                    {{-- DRAG AND DROP CONTAINER --}}
                    <div class="dnd-container min-h-[120px] sm:min-h-[150px] rounded-lg sm:rounded-[10px] border border-gray-200 dark:border-white/10 bg-[#EFEFEF] dark:bg-[#282A2C] p-2 sm:p-2.5 flex flex-wrap content-start gap-1.5 shadow-2xs">

                        {{-- 1. Nama Penyewa --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Nama Penyewa</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 2. Waktu Kontrak --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Waktu Kontrak</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 3. Nilai Kontrak --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Nilai Kontrak</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 4. Status Costumer --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Status Costumer</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 5. Nama Blok Aset --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Nama Blok Aset</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 6. Brand --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Brand</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 7. No Kontrak --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">No Kontrak</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 8. Jarak Waktu Kontrak --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Jarak Waktu Kontrak</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                    </div>
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
                    <span id="cal-year-val">2025</span>
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


    {{-- SORTABLE JS LIBRARY --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

    {{-- SCRIPTS: DRAG & DROP & CALENDAR PICKER --}}
    <script>
        // ================= DRAG AND DROP SYSTEM (SORTABLE JS) =================
        let sortableInstances = [];

        function initDragAndDrop() {
            const containers = document.querySelectorAll('.dnd-container');
            
            sortableInstances.forEach(inst => inst.destroy());
            sortableInstances = [];

            containers.forEach(container => {
                if (typeof Sortable !== 'undefined') {
                    const sortable = new Sortable(container, {
                        animation: 150,
                        ghostClass: 'opacity-30',
                        chosenClass: 'scale-105',
                        dragClass: 'shadow-xl',
                        touchStartThreshold: 2,
                        delayOnTouchOnly: true,
                        delay: 0,
                    });
                    sortableInstances.push(sortable);
                }
            });
        }

        function removeDndPill(button) {
            const pill = button.closest('.dnd-pill');
            if (pill) {
                pill.classList.add('scale-75', 'opacity-0');
                setTimeout(() => pill.remove(), 150);
            }
        }

        const defaultContractColumns = [
            'Nama Penyewa',
            'Waktu Kontrak',
            'Nilai Kontrak',
            'Status Costumer',
            'Nama Blok Aset',
            'Brand',
            'No Kontrak',
            'Jarak Waktu Kontrak'
        ];

        function resetTableColumns() {
            const container = document.querySelector('.dnd-container');
            if (!container) return;

            container.innerHTML = defaultContractColumns.map(col => `
                <div class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                    <svg class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.6169 6.92501C15.7491 6.92501 16.6669 6.0072 16.6669 4.87501C16.6669 3.74283 15.7491 2.82501 14.6169 2.82501C13.4847 2.82501 12.5669 3.74283 12.5669 4.87501C12.5669 6.0072 13.4847 6.92501 14.6169 6.92501Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path opacity="0.4" d="M5.3835 6.92501C6.51569 6.92501 7.43349 6.0072 7.43349 4.87501C7.43349 3.74283 6.51569 2.82501 5.3835 2.82501C4.25132 2.82501 3.3335 3.74283 3.3335 4.87501C3.3335 6.0072 4.25132 6.92501 5.3835 6.92501Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path opacity="0.4" d="M14.6169 17.175C15.7491 17.175 16.6669 16.2572 16.6669 15.125C16.6669 13.9928 15.7491 13.075 14.6169 13.075C13.4847 13.075 12.5669 13.9928 12.5669 15.125C12.5669 16.2572 13.4847 17.175 14.6169 17.175Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5.3835 17.175C6.51569 17.175 7.43349 16.2572 7.43349 15.125C7.43349 13.9928 6.51569 13.075 5.3835 13.075C4.25132 13.075 3.3335 13.9928 3.3335 15.125C3.3335 16.2572 4.25132 17.175 5.3835 17.175Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="font-medium">${col}</span>
                    <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                        <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            `).join('');

            initDragAndDrop();
        }

        // ================= POPUP CALENDAR LOGIC =================
        let calTargetInputId = null;
        let calCurrentYear = 2025;
        let calCurrentMonth = 5; // 0-indexed: 5 = June (Jun)

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

            // Next month overflow days to complete rows (up to 35 or 42 cells)
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

        document.addEventListener('DOMContentLoaded', initDragAndDrop);

        document.addEventListener('click', function (e) {
            if (!e.target.closest('#popup-calendar-picker') && !e.target.closest('[onclick*="openCalendarPicker"]')) {
                closeCalendarPicker();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeCalendarPicker();
            }
        });
    </script>
<x-temp-password-guard />
</body>

</html>
