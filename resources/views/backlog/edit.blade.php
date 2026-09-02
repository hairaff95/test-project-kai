<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Edit Backlog — KAI Tracker App</title>

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
    <x-navbar active="backlog" />

    {{-- Main Content --}}
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-3.5 sm:px-8 lg:px-10 pt-3 sm:pt-6 pb-28 lg:pb-10 flex flex-col gap-4 sm:gap-6">

        {{-- Page Header & Breadcrumbs & Action Buttons --}}
        <div class="flex items-center justify-between gap-3 shrink-0">
            <div>
                <h1 class="text-lg sm:text-[26px] font-bold tracking-tight text-gray-950 dark:text-white">
                    Edit Backlog
                </h1>
                <div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5">
                    <a href="{{ route('backlog.index') }}" class="hover:text-gray-600 dark:hover:text-white transition">Backlog</a>
                    <span>/</span>
                    <span class="text-[#0066FF] dark:text-[#3B82F6] font-medium">Edit</span>
                </div>
            </div>

            {{-- Top Right Buttons: Simpan & Batal --}}
            <div class="flex items-center gap-2 sm:gap-2.5">
                <button
                    type="submit"
                    form="form-edit-backlog"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#0066FF] hover:bg-blue-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Simpan</span>
                </button>

                <a
                    href="{{ route('backlog.index') }}"
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
        <form id="form-edit-backlog" action="{{ route('backlog.update', $contract->asset_number ?? $contract->contract_number) }}" method="POST" class="w-full">
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
                                    value="{{ old('nama_penyewa', $contract->tenant?->fullname ?? ($contract->tenant?->name ?? 'MARDIYAH')) }}"
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
                                    value="{{ old('status_customer', $contract->tenant?->status_customer ?? 'Aktif') }}"
                                    class="w-full sm:w-48 max-w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                    required
                                >
                            </div>
                        </div>
                    </div>


                    {{-- CARD 2: INFORMASI BACKLOG & KEUANGAN --}}
                    <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3 sm:p-5 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                        <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white mb-2 sm:mb-3.5">
                            Informasi Backlog & Keuangan
                        </h2>

                        <div class="space-y-2 sm:space-y-3">
                            {{-- No Kontrak & Invoice --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        No Kontrak<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="contract_number"
                                        value="{{ old('contract_number', $contract->contract_number ?? '0005/51116/D.4/941/PK/TN/XII/2016') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>

                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        Invoice<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="invoice"
                                        value="{{ old('invoice', $schedule->invoice ?? 'SUDAH TERBIT') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Nilai Backlog & Nilai Backlog2 --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        Nilai Backlog<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="nilai_backlog"
                                        value="{{ old('nilai_backlog', $financial->nilai_backlog ? number_format((float)$financial->nilai_backlog, 1, '.', '.') : '906.378.0') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>

                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        Nilai Backlog2<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="nilai_backlog2"
                                        value="{{ old('nilai_backlog2', ($financial->nilai_backlog2 ?? $financial->sisa_piutang) ? number_format((float)($financial->nilai_backlog2 ?? $financial->sisa_piutang), 1, '.', '.') : '940.281.9') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>
                            </div>

                            {{-- GL Account & Hari 2026 --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        GL Account<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="gl_account"
                                        value="{{ old('gl_account', $financial->gl_account ?? '940.281.9') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>

                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        Hari 2026<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="hari_2026"
                                        value="{{ old('hari_2026', $financial->hari_2026 ?? '365') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Nilai Perhari --}}
                            <div class="flex flex-col w-full">
                                <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                    Nilai Perhari<span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="nilai_perhari"
                                    value="{{ old('nilai_perhari', $financial->nilai_per_hari ? number_format((float)$financial->nilai_per_hari, 0, ',', '.') : '3.102') }}"
                                    class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                </div>


                {{-- Right Column: CARD KUSTOM TABLE (Sesuai Kolom Backlog) --}}
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

                        {{-- 1. No Kontrak --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">No Kontrak</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 2. Nama Penyewa --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Nama Penyewa</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 3. Nilai Backlog --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Nilai Backlog</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 4. Nilai Backlog2 --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Nilai Backlog2</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 5. Invoice --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Invoice</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 6. GL Account --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">GL Account</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 7. Hari 2026 --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Hari 2026</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- 8. Nilai Perhari --}}
                        <div draggable="true" class="dnd-pill touch-none h-7 sm:h-8 w-auto inline-flex items-center gap-1.5 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2 sm:px-2.5 text-[10.5px] sm:text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3 h-3 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Nilai Perhari</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-0.5 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-2.5 w-2.5 sm:h-3 sm:w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </form>

    </main>

    {{-- SORTABLE JS LIBRARY --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

    {{-- SCRIPTS: DRAG & DROP --}}
    <script>
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

        const defaultBacklogColumns = [
            'No Kontrak',
            'Nama Penyewa',
            'Nilai Backlog',
            'Nilai Backlog2',
            'Invoice',
            'GL Account',
            'Hari 2026',
            'Nilai Perhari'
        ];

        function resetTableColumns() {
            const container = document.querySelector('.dnd-container');
            if (!container) return;

            container.innerHTML = defaultBacklogColumns.map(col => `
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

        document.addEventListener('DOMContentLoaded', () => {
            initDragAndDrop();
        });
    </script>

</body>
</html>
