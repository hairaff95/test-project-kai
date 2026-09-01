<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Pengaturan — Profil Admin</title>

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

    {{-- Navbar --}}
    <x-navbar active="pengaturan" />

    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-5 sm:pt-8 pb-28 lg:pb-12">

        {{-- Main 2-Column Layout (Sidebar Kiri & Konten Kanan) --}}
        <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-5 lg:gap-14 items-start">

            {{-- ================= SIDEBAR KIRI ================= --}}
            <div class="space-y-4 lg:space-y-6">
                <h1 class="text-[24px] sm:text-[30px] lg:text-[34px] font-bold text-gray-950 dark:text-white tracking-tight">
                    Pengaturan
                </h1>

                {{-- Desktop: vertical nav, Mobile: horizontal tab pills --}}
                <nav class="flex flex-row lg:flex-col gap-2 lg:gap-3 overflow-x-auto pb-1 lg:pb-0">
                    {{-- 1. Tab Profil Saya --}}
                    <button
                        type="button"
                        onclick="switchAdminTab('profil')"
                        id="tab-btn-profil"
                        class="shrink-0 text-left text-sm font-semibold transition cursor-pointer text-[#0066FF] dark:text-[#3B82F6] px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-blue-50 dark:bg-blue-900/30 lg:bg-transparent lg:dark:bg-transparent"
                    >
                        Profil Saya
                    </button>

                    {{-- 2. Tab Pengajuan Reset Sandi --}}
                    <button
                        type="button"
                        onclick="switchAdminTab('reset-sandi')"
                        id="tab-btn-reset-sandi"
                        class="shrink-0 text-left text-sm font-medium transition cursor-pointer text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-gray-100/80 dark:bg-[#2D3034] lg:bg-transparent lg:dark:bg-transparent"
                    >
                        Pengajuan Reset Sandi
                    </button>

                    {{-- 3. Tab Import Data Excel --}}
                    <button
                        type="button"
                        onclick="switchAdminTab('import-excel')"
                        id="tab-btn-import-excel"
                        class="shrink-0 text-left text-sm font-medium transition cursor-pointer text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-gray-100/80 dark:bg-[#2D3034] lg:bg-transparent lg:dark:bg-transparent"
                    >
                        Import Data Excel
                    </button>
                </nav>
            </div>


            {{-- ================= KONTEN KANAN ================= --}}
            <div class="w-full">

                {{-- ------------------- TAB 1: PROFIL SAYA ------------------- --}}
                <div id="panel-profil" class="space-y-6">

                    {{-- Card 1: Avatar & Nama --}}
                    <div class="rounded-3xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 transition-colors">
                        <div class="flex items-center gap-5 sm:gap-6">
                            {{-- Avatar circle --}}
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#D9D9D9] dark:bg-[#34383D] flex items-center justify-center text-gray-400 dark:text-gray-300 shrink-0 select-none overflow-hidden">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>

                            <div>
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-snug" id="display-fullname">
                                    @auth {{ auth()->user()->name }} @else Haidar Rafi Kosong Enam @endauth
                                </h2>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-[#9AA0A6] font-medium mt-1">
                                    @auth
                                        @if(auth()->user()->isSuperAdmin()) Super Admin
                                        @elseif(auth()->user()->isAdmin()) Admin KAI Aset
                                        @else User @endif
                                    @else
                                        Admin KAI Aset
                                    @endauth
                                </p>
                            </div>
                        </div>

                        <div>
                            <button
                                type="button"
                                onclick="openEditProfileModal()"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-medium text-white shadow-xs transition cursor-pointer"
                            >
                                <x-icon name="edit-detail-peta" class="w-4 h-4" />
                                <span>Edit</span>
                            </button>
                        </div>
                    </div>

                    {{-- Card 2: Informasi Profil --}}
                    <div class="rounded-3xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-xs space-y-6 transition-colors">
                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/10 pb-4">
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                                Informasi Profil
                            </h3>
                            <button
                                type="button"
                                onclick="openEditProfileModal()"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-medium text-white shadow-xs transition cursor-pointer"
                            >
                                <x-icon name="edit-detail-peta" class="w-4 h-4" />
                                <span>Edit</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8 pt-2">
                            {{-- Nama Lengkap / Awal --}}
                            <div>
                                <span class="block text-xs font-medium text-gray-400 dark:text-[#9AA0A6] mb-1.5">Nama</span>
                                <span class="block text-sm sm:text-[15px] font-semibold text-gray-900 dark:text-white" id="display-first-name">
                                    @auth {{ auth()->user()->name }} @else Haidar Rafi @endauth
                                </span>
                            </div>

                            {{-- Username --}}
                            <div>
                                <span class="block text-xs font-medium text-gray-400 dark:text-[#9AA0A6] mb-1.5">Username</span>
                                <span class="block text-sm sm:text-[15px] font-semibold text-gray-900 dark:text-white" id="display-last-name">
                                    @auth {{ auth()->user()->username }} @else admin.daop4 @endauth
                                </span>
                            </div>

                            {{-- Alamat Email --}}
                            <div class="sm:col-span-2">
                                <span class="block text-xs font-medium text-gray-400 dark:text-[#9AA0A6] mb-1.5">Alamat Email</span>
                                <span class="block text-sm sm:text-[15px] font-semibold text-gray-900 dark:text-white" id="display-email">
                                    @auth {{ auth()->user()->email }} @else admin.kai@daop4.com @endauth
                                </span>
                            </div>
                        </div>
                    </div>

                </div>


                {{-- ------------------- TAB 2: PENGAJUAN RESET SANDI ------------------- --}}
                <div id="panel-reset-sandi" class="hidden">
                    <div class="rounded-3xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-6 sm:p-10 shadow-xs space-y-6 max-w-3xl transition-colors">
                        
                        {{-- Title --}}
                        <h2 class="text-2xl sm:text-[30px] font-bold text-gray-950 dark:text-white tracking-tight leading-tight">
                            Pengajuan Ubah Kata Sandi
                        </h2>

                        {{-- Description per Desain Figma --}}
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 font-normal leading-relaxed">
                            Ajukan Reset Kata Sandi login aplikasi Tracker APP, ingat pengajuan kata sandi menunggu persetujuan dari superadmin selama 1x24 jam, jika belum di setujui silahkan cek email untuk mendapatkan kata sandi sementara untuk login dan untuk pengubahan kata sandi
                        </p>

                        {{-- Buttons: Batal & Ajukan Perubahan Kata Sandi --}}
                        <div class="flex items-center gap-3 pt-4">
                            {{-- Tombol Batal --}}
                            <button
                                type="button"
                                onclick="switchAdminTab('profil')"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-[8px] bg-[#E00000] hover:bg-red-700 text-xs sm:text-sm font-medium text-white transition shadow-xs cursor-pointer"
                            >
                                <span>✕</span>
                                <span>Batal</span>
                            </button>

                            {{-- Tombol Ajukan Perubahan Kata Sandi --}}
                            <a
                                href="{{ route('password.request') }}"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-medium text-white transition shadow-xs cursor-pointer"
                            >
                                <span>✓</span>
                                <span>Ajukan Perubahan Kata Sandi</span>
                            </a>
                        </div>

                    </div>
                </div>


                {{-- ------------------- TAB 3: IMPORT DATA EXCEL ------------------- --}}
                <div id="panel-import-excel" class="hidden space-y-6">
                    
                    {{-- Alert Messages --}}
                    @if(session('success'))
                        <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 p-4 rounded-2xl text-xs sm:text-sm shadow-xs">
                            <span class="text-base">✅</span>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="flex items-center gap-3 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 p-4 rounded-2xl text-xs sm:text-sm shadow-xs">
                            <span class="text-base">❌</span>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 p-4 rounded-2xl text-xs sm:text-sm shadow-xs">
                            <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Card 1: Form Upload File --}}
                    <div class="rounded-3xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-6 sm:p-10 shadow-xs space-y-6 max-w-4xl transition-colors">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-100 dark:border-white/10 pb-6">
                            <div>
                                <h2 class="text-xl sm:text-[26px] font-bold text-gray-950 dark:text-white tracking-tight leading-tight">
                                    Import Data Excel / CSV
                                </h2>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-[#9AA0A6] font-normal mt-1">
                                    Unggah file spreadsheet untuk otomatis mengisi database aset, penyewa, kontrak, backlog, dan laporan.
                                </p>
                            </div>

                            <a
                                href="{{ route('settings.download-template') }}"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 text-xs sm:text-sm font-semibold text-[#0066FF] dark:text-[#3B82F6] transition shrink-0"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                <span>Unduh Template CSV</span>
                            </a>
                        </div>

                        {{-- Upload Form --}}
                        <form method="POST" action="{{ route('settings.import-excel') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            {{-- Drag & Drop Upload Zone --}}
                            <div
                                id="dropzone-area"
                                onclick="document.getElementById('excel-file-input').click()"
                                class="relative border-2 border-dashed border-gray-300 dark:border-white/20 hover:border-[#0066FF] dark:hover:border-[#3B82F6] bg-gray-50/60 dark:bg-[#282A2C]/60 hover:bg-blue-50/30 dark:hover:bg-blue-900/10 rounded-2xl p-8 sm:p-12 text-center transition cursor-pointer group"
                            >
                                <input
                                    type="file"
                                    name="excel_file"
                                    id="excel-file-input"
                                    accept=".csv, .xlsx, .xls, .txt"
                                    class="hidden"
                                    onchange="handleFileSelected(this)"
                                    required
                                >

                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/40 text-[#0066FF] dark:text-[#3B82F6] flex items-center justify-center group-hover:scale-105 transition">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            Klik untuk memilih file atau seret file ke area ini
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-[#9AA0A6] mt-1">
                                            Mendukung format: <strong class="text-gray-700 dark:text-gray-300">.CSV, .XLSX, .XLS</strong> (Maksimal 20MB)
                                        </p>
                                    </div>
                                </div>

                                {{-- Selected File Name Display --}}
                                <div id="selected-file-info" class="hidden mt-4 pt-4 border-t border-gray-200 dark:border-white/10 flex items-center justify-center gap-2 text-xs font-semibold text-blue-600 dark:text-blue-400">
                                    <span>📄</span>
                                    <span id="selected-file-name">-</span>
                                    <span id="selected-file-size" class="text-gray-400 dark:text-gray-500 font-normal">(-)</span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex items-center justify-end gap-3 pt-2">
                                <button
                                    type="button"
                                    onclick="switchAdminTab('profil')"
                                    class="px-5 py-2.5 rounded-[10px] border border-gray-200 dark:border-white/10 text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/10 transition cursor-pointer"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    id="btn-submit-import"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-[10px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-semibold text-white transition shadow-sm hover:shadow active:scale-98 cursor-pointer"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    <span>Mulai Import Data</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Card 2: Panduan & Informasi Pemetaan Otomatis --}}
                    <div class="rounded-3xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-xs space-y-4 max-w-4xl transition-colors">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>💡</span>
                            <span>Informasi Pemetaan Kolom Otomatis</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                            Sistem secara cerdas akan memetakan kolom dari 1 baris spreadsheet ke 5 tabel database sekaligus:
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 pt-2 text-xs">
                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-[#282A2C] border border-gray-100 dark:border-white/5 space-y-1">
                                <span class="font-bold text-gray-900 dark:text-white block">1. Master Aset</span>
                                <span class="text-gray-500 dark:text-[#9AA0A6] block">No Aset, Nama Blok, Luas, Stasiun, Wilayah, Koordinat Peta</span>
                            </div>
                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-[#282A2C] border border-gray-100 dark:border-white/5 space-y-1">
                                <span class="font-bold text-gray-900 dark:text-white block">2. Data Penyewa</span>
                                <span class="text-gray-500 dark:text-[#9AA0A6] block">Nama Penyewa, Brand Usaha, Status Customer, Jenis PT</span>
                            </div>
                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-[#282A2C] border border-gray-100 dark:border-white/5 space-y-1">
                                <span class="font-bold text-gray-900 dark:text-white block">3. Kontrak & Jatuh Tempo</span>
                                <span class="text-gray-500 dark:text-[#9AA0A6] block">No Kontrak, Tgl Mulai & Akhir, Nilai Kontrak (Harga), SPV</span>
                            </div>
                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-[#282A2C] border border-gray-100 dark:border-white/5 space-y-1">
                                <span class="font-bold text-gray-900 dark:text-white block">4. Data Backlog</span>
                                <span class="text-gray-500 dark:text-[#9AA0A6] block">Nilai Backlog 1 & 2, Akun GL, Hari 2026, Nilai Perhari, RKA</span>
                            </div>
                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-[#282A2C] border border-gray-100 dark:border-white/5 space-y-1 sm:col-span-2">
                                <span class="font-bold text-gray-900 dark:text-white block">5. Laporan Bulanan</span>
                                <span class="text-gray-500 dark:text-[#9AA0A6] block">Invoice, Alokasi Nilai Januari s/d Desember, Total Jan-Des</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </main>

    {{-- ================= MODAL EDIT INFORMASI PROFIL ================= --}}
    <div id="modal-edit-profile" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
        <div class="w-full max-w-md rounded-3xl bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-2xl border border-gray-100 dark:border-white/10 space-y-5 animate-in fade-in zoom-in-95 duration-200 transition-colors">
            
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/10 pb-3">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Informasi Profil</h3>
                <button type="button" onclick="closeEditProfileModal()" class="text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white text-lg cursor-pointer">✕</button>
            </div>

            <form id="form-edit-profile" onsubmit="saveProfileChanges(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Nama Awal</label>
                    <input
                        type="text"
                        id="input-first-name"
                        value="Haidar Rafi"
                        class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#0066FF] focus:outline-none transition"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Nama Akhir</label>
                    <input
                        type="text"
                        id="input-last-name"
                        value="Kosong Enam"
                        class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#0066FF] focus:outline-none transition"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Alamat Email</label>
                    <input
                        type="email"
                        id="input-email"
                        value="admin.kai@daop4.com"
                        class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#0066FF] focus:outline-none transition"
                        required
                    >
                </div>

                <div class="flex items-center justify-end gap-3 pt-3">
                    <button
                        type="button"
                        onclick="closeEditProfileModal()"
                        class="px-5 py-2.5 rounded-[8px] border border-gray-200 dark:border-white/10 text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/10 transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-medium text-white transition shadow-xs cursor-pointer"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- Scripts untuk Tab Switching & Modal --}}
    <script>
        function switchAdminTab(tabName) {
            const btnProfil = document.getElementById('tab-btn-profil');
            const btnReset = document.getElementById('tab-btn-reset-sandi');
            const btnImport = document.getElementById('tab-btn-import-excel');
            const panelProfil = document.getElementById('panel-profil');
            const panelReset = document.getElementById('panel-reset-sandi');
            const panelImport = document.getElementById('panel-import-excel');

            const activeClass = "shrink-0 text-left text-sm font-semibold transition cursor-pointer text-[#0066FF] dark:text-[#3B82F6] px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-blue-50 dark:bg-blue-900/30 lg:bg-transparent lg:dark:bg-transparent";
            const inactiveClass = "shrink-0 text-left text-sm font-medium transition cursor-pointer text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-gray-100/80 dark:bg-[#2D3034] lg:bg-transparent lg:dark:bg-transparent";

            // Sembunyikan semua panel
            if (panelProfil) panelProfil.classList.add('hidden');
            if (panelReset) panelReset.classList.add('hidden');
            if (panelImport) panelImport.classList.add('hidden');

            // Reset tab button styles
            if (btnProfil) btnProfil.className = inactiveClass;
            if (btnReset) btnReset.className = inactiveClass;
            if (btnImport) btnImport.className = inactiveClass;

            if (tabName === 'profil') {
                if (btnProfil) btnProfil.className = activeClass;
                if (panelProfil) panelProfil.classList.remove('hidden');
            } else if (tabName === 'reset-sandi') {
                if (btnReset) btnReset.className = activeClass;
                if (panelReset) panelReset.classList.remove('hidden');
            } else if (tabName === 'import-excel') {
                if (btnImport) btnImport.className = activeClass;
                if (panelImport) panelImport.classList.remove('hidden');
            }
        }

        function handleFileSelected(input) {
            const infoBox = document.getElementById('selected-file-info');
            const nameEl = document.getElementById('selected-file-name');
            const sizeEl = document.getElementById('selected-file-size');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                nameEl.textContent = file.name;
                const sizeKb = (file.size / 1024).toFixed(1);
                sizeEl.textContent = `(${sizeKb} KB)`;
                infoBox.classList.remove('hidden');
            } else {
                infoBox.classList.add('hidden');
            }
        }

        // Support Drag & Drop visuals
        const dropzone = document.getElementById('dropzone-area');
        if (dropzone) {
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dropzone.classList.add('border-[#0066FF]', 'bg-blue-50/50');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dropzone.classList.remove('border-[#0066FF]', 'bg-blue-50/50');
                });
            });

            dropzone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    const input = document.getElementById('excel-file-input');
                    input.files = files;
                    handleFileSelected(input);
                }
            });
        }

        // Auto switch ke tab import jika ada session success atau error
        @if(session('success') || session('error') || $errors->any())
            document.addEventListener('DOMContentLoaded', () => {
                switchAdminTab('import-excel');
            });
        @endif

        function openEditProfileModal() {
            const modal = document.getElementById('modal-edit-profile');
            if (modal) modal.classList.remove('hidden');
        }

        function closeEditProfileModal() {
            const modal = document.getElementById('modal-edit-profile');
            if (modal) modal.classList.add('hidden');
        }

        function saveProfileChanges(e) {
            e.preventDefault();
            const firstName = document.getElementById('input-first-name').value.trim();
            const lastName = document.getElementById('input-last-name').value.trim();
            const email = document.getElementById('input-email').value.trim();

            document.getElementById('display-first-name').textContent = firstName;
            document.getElementById('display-last-name').textContent = lastName;
            document.getElementById('display-fullname').textContent = `${firstName} ${lastName}`;
            document.getElementById('display-email').textContent = email;

            closeEditProfileModal();
        }

        function submitResetRequest() {
            // Frontend prototype without toast per design request
        }
    </script>

</body>
</html>
