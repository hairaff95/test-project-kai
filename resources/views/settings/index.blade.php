<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Pengaturan — Super Admin</title>

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

        {{-- Main 2-Column Layout (Sidebar Kiri & Konten Kanan) persis Figma --}}
        <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-5 lg:gap-14 items-start">

            {{-- ================= SIDEBAR KIRI ================= --}}
            <div class="space-y-4 lg:space-y-6">
                <h1 class="text-[24px] sm:text-[30px] lg:text-[34px] font-bold text-gray-950 dark:text-white tracking-tight">
                    Pengaturan
                </h1>

                {{-- Desktop: vertical nav, Mobile: horizontal tab pills --}}
                <nav class="flex flex-row lg:flex-col gap-2 lg:gap-3 overflow-x-auto pb-1 lg:pb-0">
                    {{-- 1. Tab Manajemen Admin --}}
                    <button
                        type="button"
                        onclick="switchSuperTab('manajemen-admin')"
                        id="tab-btn-manajemen"
                        class="shrink-0 text-left text-sm font-semibold transition cursor-pointer text-[#0066FF] dark:text-[#3B82F6] px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-blue-50 dark:bg-blue-900/30 lg:bg-transparent lg:dark:bg-transparent"
                    >
                        Manajemen Admin
                    </button>

                    {{-- 2. Tab Persetujuan Reset Sandi --}}
                    <button
                        type="button"
                        onclick="switchSuperTab('persetujuan-sandi')"
                        id="tab-btn-persetujuan"
                        class="shrink-0 text-left text-sm font-medium transition cursor-pointer text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-gray-100/80 dark:bg-[#2D3034] lg:bg-transparent lg:dark:bg-transparent flex items-center gap-2"
                    >
                        <span>Persetujuan Reset Sandi</span>
                        <span id="badge-pending-count" class="px-2 py-0.5 text-[11px] font-bold bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 rounded-full">2</span>
                    </button>
                </nav>
            </div>



            {{-- ================= KONTEN KANAN ================= --}}
            <div class="w-full">

                {{-- ------------------- TAB 1: MANAJEMEN ADMIN (TABLE) ------------------- --}}
                <div id="panel-manajemen-admin" class="space-y-6">
                    <div class="rounded-3xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-xs space-y-6 transition-colors">
                        
                        {{-- Header Controls: Search, Role Filter, + Tambah Admin Button --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2.5 sm:gap-4">
                            <div class="flex items-center gap-2 sm:gap-3 flex-1 max-w-md">
                                {{-- Search Input --}}
                                <div class="relative flex-1 h-[32px] sm:h-[40px]">
                                    <span class="absolute left-2.5 sm:left-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-[#9AA0A6] pointer-events-none">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </span>
                                    <input
                                        type="text"
                                        placeholder="Search"
                                        id="search-admin-input"
                                        onkeyup="filterAdminTable()"
                                        class="w-full h-full rounded-lg sm:rounded-[10px] border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] py-1 sm:py-2.5 pl-8 sm:pl-10 pr-3 sm:pr-4 text-[11px] sm:text-sm text-gray-800 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#0066FF] focus:outline-none transition shadow-2xs"
                                    >
                                </div>

                                {{-- Role Filter Dropdown --}}
                                <div class="relative h-[32px] sm:h-[40px]">
                                    <select
                                        id="filter-role-select"
                                        onchange="filterAdminTable()"
                                        class="h-full rounded-lg sm:rounded-[10px] border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] py-1 sm:py-2.5 pl-2.5 sm:pl-3.5 pr-7 sm:pr-8 text-[11px] sm:text-sm text-gray-600 dark:text-gray-200 focus:border-[#0066FF] focus:outline-none transition shadow-2xs appearance-none cursor-pointer"
                                    >
                                        <option value="">Role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="SuperAdmin">SuperAdmin</option>
                                    </select>
                                    <span class="absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-[#9AA0A6] pointer-events-none">
                                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            {{-- + Tambah Admin Button --}}
                            <div>
                                <button
                                    type="button"
                                    onclick="openAddAdminModal()"
                                    class="inline-flex items-center gap-1.5 px-3.5 sm:px-5 py-1.5 sm:py-2.5 rounded-lg sm:rounded-[10px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-semibold text-white shadow-xs transition cursor-pointer"
                                >
                                    <span>+</span>
                                    <span>Tambah Admin</span>
                                </button>
                            </div>
                        </div>

                        {{-- Admin Table --}}
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs sm:text-sm text-gray-700 dark:text-gray-300" id="admin-table">
                                <thead class="bg-transparent text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] border-b border-gray-100 dark:border-white/10">
                                <tr>
                                    <th class="py-3 px-4">Email</th>
                                    <th class="py-3 px-4">Nama Akun</th>
                                    <th class="py-3 px-4">Role</th>
                                    <th class="py-3 px-4">
                                        <div class="flex items-center gap-1 cursor-pointer">
                                            <span>Terakhir Aktif</span>
                                            <span class="text-[11px] text-gray-400 dark:text-[#9AA0A6]">↑↓</span>
                                        </div>
                                    </th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-white/10" id="admin-tbody">
                                {{-- Row 1 --}}
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-white/5 transition admin-row">
                                    <td class="py-4 px-4 font-normal text-gray-700 dark:text-gray-300 email-col">admin.kai@daop4.com</td>
                                    <td class="py-4 px-4 font-semibold text-gray-950 dark:text-white name-col">Haidar Rafi kosong enam</td>
                                    <td class="py-4 px-4 role-col">
                                        <span class="inline-block px-3 py-0.5 rounded-full text-xs font-medium text-green-700 dark:text-emerald-400 bg-green-50 dark:bg-emerald-900/30 border border-green-200/80 dark:border-emerald-800">Admin</span>
                                    </td>
                                    <td class="py-4 px-4 text-xs text-gray-500 dark:text-[#9AA0A6]">30/08/2026 at 15.30 PM</td>
                                    <td class="py-4 px-4 text-center relative">
                                        <button type="button" onclick="toggleAdminActionDropdown('drop-1')" class="p-1 text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white transition cursor-pointer">
                                            ⋮
                                        </button>
                                        {{-- Action Dropdown Menu --}}
                                        <div id="drop-1" class="admin-dropdown hidden absolute right-4 top-10 w-48 bg-white dark:bg-[#1F2123] rounded-2xl shadow-xl border border-gray-100 dark:border-white/10 py-2 z-30 text-left text-xs">
                                            <button type="button" onclick="actionNonaktif('Haidar Rafi kosong enam')" class="w-full flex items-center gap-2.5 px-4 py-2 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 transition cursor-pointer">
                                                <span>👤</span>
                                                <span>Non Aktif Profil</span>
                                            </button>
                                            <button type="button" onclick="actionResetSandi('Haidar Rafi kosong enam', 'admin.kai@daop4.com')" class="w-full flex items-center gap-2.5 px-4 py-2 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 transition cursor-pointer">
                                                <span>🔑</span>
                                                <span>Reset Sandi Sementara</span>
                                            </button>
                                            <button type="button" onclick="actionHapusAdmin(this, 'Haidar Rafi kosong enam')" class="w-full flex items-center gap-2.5 px-4 py-2 hover:bg-red-50 dark:hover:bg-red-950/30 text-red-600 dark:text-red-400 transition cursor-pointer">
                                                <span>🗑️</span>
                                                <span>Hapus Admin</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Row 2 (SuperAdmin) --}}
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-white/5 transition admin-row">
                                    <td class="py-4 px-4 font-normal text-gray-700 dark:text-gray-300 email-col">superadmin.kai@daop4.com</td>
                                    <td class="py-4 px-4 font-semibold text-gray-950 dark:text-white name-col">Haidar Rafi kosong satu</td>
                                    <td class="py-4 px-4 role-col">
                                        <span class="inline-block px-3 py-0.5 rounded-full text-xs font-medium text-[#0066FF] dark:text-[#3B82F6] bg-blue-50 dark:bg-blue-900/30 border border-blue-200/80 dark:border-blue-800">SuperAdmin</span>
                                    </td>
                                    <td class="py-4 px-4 text-xs text-gray-500 dark:text-[#9AA0A6]">01/08/2026 at 14.30 PM</td>
                                    <td class="py-4 px-4 text-center relative">
                                        <button type="button" onclick="toggleAdminActionDropdown('drop-2')" class="p-1 text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white transition cursor-pointer">
                                            ⋮
                                        </button>
                                        <div id="drop-2" class="admin-dropdown hidden absolute right-4 top-10 w-48 bg-white dark:bg-[#1F2123] rounded-2xl shadow-xl border border-gray-100 dark:border-white/10 py-2 z-30 text-left text-xs">
                                            <button type="button" onclick="actionNonaktif('Haidar Rafi kosong satu')" class="w-full flex items-center gap-2.5 px-4 py-2 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 transition cursor-pointer">
                                                <span>👤</span>
                                                <span>Non Aktif Profil</span>
                                            </button>
                                            <button type="button" onclick="actionResetSandi('Haidar Rafi kosong satu', 'superadmin.kai@daop4.com')" class="w-full flex items-center gap-2.5 px-4 py-2 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 transition cursor-pointer">
                                                <span>🔑</span>
                                                <span>Reset Sandi Sementara</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Row 3 --}}
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-white/5 transition admin-row">
                                    <td class="py-4 px-4 font-normal text-gray-700 dark:text-gray-300 email-col">admin.kai@daop4.com</td>
                                    <td class="py-4 px-4 font-semibold text-gray-950 dark:text-white name-col">Bambang Sudarsono</td>
                                    <td class="py-4 px-4 role-col">
                                        <span class="inline-block px-3 py-0.5 rounded-full text-xs font-medium text-green-700 dark:text-emerald-400 bg-green-50 dark:bg-emerald-900/30 border border-green-200/80 dark:border-emerald-800">Admin</span>
                                    </td>
                                    <td class="py-4 px-4 text-xs text-gray-500 dark:text-[#9AA0A6]">12/08/2026 at 01.30 AM</td>
                                    <td class="py-4 px-4 text-center relative">
                                        <button type="button" onclick="toggleAdminActionDropdown('drop-3')" class="p-1 text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white transition cursor-pointer">
                                            ⋮
                                        </button>
                                        <div id="drop-3" class="admin-dropdown hidden absolute right-4 top-10 w-48 bg-white dark:bg-[#1F2123] rounded-2xl shadow-xl border border-gray-100 dark:border-white/10 py-2 z-30 text-left text-xs">
                                            <button type="button" onclick="actionNonaktif('Bambang Sudarsono')" class="w-full flex items-center gap-2.5 px-4 py-2 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 transition cursor-pointer">
                                                <span>👤</span>
                                                <span>Non Aktif Profil</span>
                                            </button>
                                            <button type="button" onclick="actionResetSandi('Bambang Sudarsono', 'bambang@daop4.com')" class="w-full flex items-center gap-2.5 px-4 py-2 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 transition cursor-pointer">
                                                <span>🔑</span>
                                                <span>Reset Sandi Sementara</span>
                                            </button>
                                            <button type="button" onclick="actionHapusAdmin(this, 'Bambang Sudarsono')" class="w-full flex items-center gap-2.5 px-4 py-2 hover:bg-red-50 dark:hover:bg-red-950/30 text-red-600 dark:text-red-400 transition cursor-pointer">
                                                <span>🗑️</span>
                                                <span>Hapus Admin</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


            {{-- ------------------- TAB 2: PERSETUJUAN RESET SANDI (CARDS) ------------------- --}}
            <div id="panel-persetujuan-sandi" class="hidden space-y-6">
                <div class="rounded-3xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-xs space-y-6 transition-colors">
                    
                    {{-- Header Controls: Search & Waktu Pengajuan Filter --}}
                    <div class="flex items-center gap-3 max-w-md">
                        <div class="relative flex-1">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-[#9AA0A6] pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </span>
                            <input
                                type="text"
                                placeholder="Search"
                                class="w-full rounded-[10px] border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] py-2.5 pl-10 pr-4 text-xs sm:text-sm text-gray-800 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#0066FF] focus:outline-none transition shadow-2xs"
                            >
                        </div>

                        <div class="relative">
                            <select class="rounded-[10px] border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] py-2.5 pl-3.5 pr-8 text-xs sm:text-sm text-gray-600 dark:text-gray-200 focus:border-[#0066FF] focus:outline-none transition shadow-2xs appearance-none cursor-pointer">
                                <option>Waktu Pengajuan</option>
                                <option>Terbaru</option>
                                <option>Terlama</option>
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-[#9AA0A6] pointer-events-none">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    {{-- Cards List of Reset Password Requests per Figma --}}
                    <div class="space-y-4" id="requests-list-container">
                        
                        {{-- Card 1 --}}
                        <div class="rounded-2xl border border-gray-200/90 dark:border-white/10 bg-white dark:bg-[#1F2123] p-4.5 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:border-gray-300 dark:hover:border-white/20" id="req-card-1">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-[#D9D9D9] dark:bg-[#34383D] flex items-center justify-center shrink-0 text-gray-400 dark:text-gray-300">
                                    <svg class="w-6 h-6 text-gray-400 dark:text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white leading-snug">Haidar Rafi kosong enam</h4>
                                    <p class="text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5">admin.kai@daop4.com</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 sm:gap-6 justify-between sm:justify-end">
                                <span class="text-xs text-gray-500 dark:text-[#9AA0A6]">30/08/2026 at 15.30 PM</span>
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        onclick="rejectApprovalCard(1)"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-[8px] bg-[#E00000] hover:bg-red-700 text-xs font-medium text-white shadow-xs transition cursor-pointer"
                                    >
                                        <span>✕</span>
                                        <span>Tolak</span>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="approveApprovalCard(1, 'admin.kai@daop4.com')"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-xs font-medium text-white shadow-xs transition cursor-pointer"
                                    >
                                        <span>✓</span>
                                        <span>Setuju</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Card 2 --}}
                        <div class="rounded-2xl border border-gray-200/90 dark:border-white/10 bg-white dark:bg-[#1F2123] p-4.5 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:border-gray-300 dark:hover:border-white/20" id="req-card-2">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-[#D9D9D9] dark:bg-[#34383D] flex items-center justify-center shrink-0 text-gray-400 dark:text-gray-300">
                                    <svg class="w-6 h-6 text-gray-400 dark:text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white leading-snug">Siti Rahmawati</h4>
                                    <p class="text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5">siti.rahmawati@daop1.com</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 sm:gap-6 justify-between sm:justify-end">
                                <span class="text-xs text-gray-500 dark:text-[#9AA0A6]">30/08/2026 at 11.20 AM</span>
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        onclick="rejectApprovalCard(2)"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-[8px] bg-[#E00000] hover:bg-red-700 text-xs font-medium text-white shadow-xs transition cursor-pointer"
                                    >
                                        <span>✕</span>
                                        <span>Tolak</span>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="approveApprovalCard(2, 'siti.rahmawati@daop1.com')"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-xs font-medium text-white shadow-xs transition cursor-pointer"
                                    >
                                        <span>✓</span>
                                        <span>Setuju</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </main>

    {{-- ================= MODAL TAMBAH ADMIN ================= --}}
    <div id="modal-tambah-admin" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
        <div class="w-full max-w-md rounded-3xl bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-2xl border border-gray-100 dark:border-white/10 space-y-5 animate-in fade-in zoom-in-95 duration-200 transition-colors">
            
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/10 pb-3">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tambah Akun Admin Baru</h3>
                <button type="button" onclick="closeAddAdminModal()" class="text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white text-lg cursor-pointer">✕</button>
            </div>

            <form id="form-tambah-admin" onsubmit="saveNewAdmin(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Nama Lengkap</label>
                    <input
                        type="text"
                        id="new-admin-name"
                        placeholder="Contoh: Haidar Rafi"
                        class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#0066FF] focus:outline-none transition"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Alamat Email Dinas</label>
                    <input
                        type="email"
                        id="new-admin-email"
                        placeholder="nama@daop4.com"
                        class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#0066FF] focus:outline-none transition"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Role Pengguna</label>
                    <select id="new-admin-role" class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white focus:border-[#0066FF] focus:outline-none transition">
                        <option value="Admin">Admin</option>
                        <option value="SuperAdmin">SuperAdmin</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3">
                    <button
                        type="button"
                        onclick="closeAddAdminModal()"
                        class="px-5 py-2.5 rounded-[8px] border border-gray-200 dark:border-white/10 text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/10 transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-medium text-white transition shadow-xs cursor-pointer"
                    >
                        Simpan Admin
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        // Tab switching SuperAdmin
        function switchSuperTab(tabName) {
            const btnManajemen = document.getElementById('tab-btn-manajemen');
            const btnPersetujuan = document.getElementById('tab-btn-persetujuan');
            const panelManajemen = document.getElementById('panel-manajemen-admin');
            const panelPersetujuan = document.getElementById('panel-persetujuan-sandi');

            const activeClass = "shrink-0 text-left text-sm font-semibold transition cursor-pointer text-[#0066FF] dark:text-[#3B82F6] px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-blue-50 dark:bg-blue-900/30 lg:bg-transparent lg:dark:bg-transparent";
            const inactiveClass = "shrink-0 text-left text-sm font-medium transition cursor-pointer text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-gray-100/80 dark:bg-[#2D3034] lg:bg-transparent lg:dark:bg-transparent flex items-center gap-2";

            if (tabName === 'manajemen-admin') {
                btnManajemen.className = activeClass;
                btnPersetujuan.className = inactiveClass;
                panelManajemen.classList.remove('hidden');
                panelPersetujuan.classList.add('hidden');
            } else {
                btnManajemen.className = inactiveClass;
                btnPersetujuan.className = activeClass + " flex items-center gap-2";
                panelManajemen.classList.add('hidden');
                panelPersetujuan.classList.remove('hidden');
            }
        }

        // Modal Tambah Admin
        function openAddAdminModal() {
            document.getElementById('modal-tambah-admin').classList.remove('hidden');
        }
        function closeAddAdminModal() {
            document.getElementById('modal-tambah-admin').classList.add('hidden');
        }
        function saveNewAdmin(e) {
            e.preventDefault();
            const name = document.getElementById('new-admin-name').value;
            const email = document.getElementById('new-admin-email').value;
            const role = document.getElementById('new-admin-role').value;

            const tbody = document.getElementById('admin-tbody');
            const tr = document.createElement('tr');
            tr.className = "hover:bg-gray-50/70 transition admin-row";
            tr.innerHTML = `
                <td class="py-4 px-4 font-normal text-gray-700 email-col">${email}</td>
                <td class="py-4 px-4 font-semibold text-gray-950 name-col">${name}</td>
                <td class="py-4 px-4 role-col">
                    <span class="inline-block px-3 py-0.5 rounded-full text-xs font-medium ${role === 'SuperAdmin' ? 'text-[#0066FF] bg-blue-50 border border-blue-200/80' : 'text-green-700 bg-green-50 border border-green-200/80'}">${role}</span>
                </td>
                <td class="py-4 px-4 text-xs text-gray-500">Baru saja</td>
                <td class="py-4 px-4 text-center">
                    <span class="text-xs text-gray-400">Aktif</span>
                </td>
            `;
            tbody.prepend(tr);
            closeAddAdminModal();
        }

        // Dropdown Aksi Three-Dots
        function toggleAdminActionDropdown(dropId) {
            const dropdowns = document.querySelectorAll('.admin-dropdown');
            dropdowns.forEach(d => {
                if (d.id !== dropId) d.classList.add('hidden');
            });
            const current = document.getElementById(dropId);
            if (current) current.classList.toggle('hidden');
        }

        // Close dropdowns on outside click
        document.addEventListener('click', (e) => {
            if (!e.target.closest('td')) {
                document.querySelectorAll('.admin-dropdown').forEach(d => d.classList.add('hidden'));
            }
        });

        function actionNonaktif(name) {
            // Frontend action without toast per design request
        }

        function actionResetSandi(name, email) {
            // Frontend action without toast per design request
        }

        function actionHapusAdmin(btn, name) {
            if (confirm(`Apakah Anda yakin ingin menghapus akun admin ${name}?`)) {
                const tr = btn.closest('tr');
                if (tr) tr.remove();
            }
        }

        // Persetujuan Cards Actions
        function approveApprovalCard(id, email) {
            const card = document.getElementById(`req-card-${id}`);
            if (card) {
                card.remove();
            }
            decrementBadge();
        }

        function rejectApprovalCard(id) {
            const card = document.getElementById(`req-card-${id}`);
            if (card) {
                card.remove();
            }
            decrementBadge();
        }

        function decrementBadge() {
            const badge = document.getElementById('badge-pending-count');
            if (badge) {
                const count = Math.max(0, parseInt(badge.textContent) - 1);
                badge.textContent = count;
                if (count === 0) badge.classList.add('hidden');
            }
        }

        // Filter Table Search & Role
        function filterAdminTable() {
            const query = document.getElementById('search-admin-input').value.toLowerCase();
            const role = document.getElementById('filter-role-select').value.toLowerCase();
            const rows = document.querySelectorAll('.admin-row');

            rows.forEach(r => {
                const email = r.querySelector('.email-col').textContent.toLowerCase();
                const name = r.querySelector('.name-col').textContent.toLowerCase();
                const rRole = r.querySelector('.role-col').textContent.toLowerCase();

                const matchQuery = email.includes(query) || name.includes(query);
                const matchRole = !role || rRole.includes(role);

                r.style.display = (matchQuery && matchRole) ? '' : 'none';
            });
        }
    </script>

</body>
</html>
