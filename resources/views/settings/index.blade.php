<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Pengaturan — Super Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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

    {{-- Flash Toast --}}
    @if(session('success'))
        <div id="flash-toast" class="fixed top-[calc(5rem+env(safe-area-inset-top,0px))] right-6 z-50 flex items-center gap-3 bg-white dark:bg-[#1F2123] border border-green-200 dark:border-green-800 text-green-800 dark:text-green-400 px-4 py-3 rounded-xl shadow-lg text-sm font-medium">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div id="flash-toast" class="fixed top-[calc(5rem+env(safe-area-inset-top,0px))] right-6 z-50 flex items-center gap-3 bg-white dark:bg-[#1F2123] border border-red-200 dark:border-red-800 text-red-800 dark:text-red-400 px-4 py-3 rounded-xl shadow-lg text-sm font-medium">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-5 sm:pt-8 pb-28 lg:pb-12">

        {{-- 2-Column Layout: Sidebar Kiri + Konten Kanan --}}
        <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-5 lg:gap-14 items-start">

            {{-- ================= SIDEBAR KIRI ================= --}}
            <div class="space-y-4 lg:space-y-6">
                <h1 class="text-[24px] sm:text-[30px] lg:text-[34px] font-bold text-gray-950 dark:text-white tracking-tight">
                    Pengaturan
                </h1>

                {{-- Desktop: vertical nav | Mobile: horizontal tab pills --}}
                <nav class="flex flex-row lg:flex-col gap-2 lg:gap-3 overflow-x-auto pb-1 lg:pb-0">

                    {{-- Tab: Profil Saya --}}
                    <button
                        type="button"
                        onclick="switchSuperTab('profil-saya')"
                        id="tab-btn-profil"
                        class="shrink-0 text-left text-sm transition cursor-pointer px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none"
                    >
                        Profil Saya
                    </button>

                    {{-- Tab: Manajemen Admin --}}
                    <button
                        type="button"
                        onclick="switchSuperTab('manajemen-admin')"
                        id="tab-btn-manajemen"
                        class="shrink-0 text-left text-sm transition cursor-pointer px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none"
                    >
                        Manajemen Admin
                    </button>

                    {{-- Tab: Persetujuan Reset Sandi --}}
                    <button
                        type="button"
                        onclick="switchSuperTab('persetujuan-sandi')"
                        id="tab-btn-persetujuan"
                        class="shrink-0 text-left text-sm transition cursor-pointer px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none flex items-center gap-2"
                    >
                        <span>Persetujuan Reset Sandi</span>
                        @if($pendingCount > 0)
                            <span id="badge-pending-count" class="px-2 py-0.5 text-[11px] font-bold bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 rounded-full">{{ $pendingCount }}</span>
                        @endif
                    </button>

                </nav>
            </div>

            {{-- ================= KONTEN KANAN ================= --}}
            <div class="w-full">

                {{-- ─── TAB 1: PROFIL SAYA ─── --}}
                <div id="panel-profil-saya" class="space-y-5">

                    {{-- Card Avatar & Nama --}}
                    <div class="rounded-3xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 transition-colors">
                        <div class="flex items-center gap-5 sm:gap-6">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gray-200 dark:bg-[#34383D] flex items-center justify-center shrink-0">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-snug">
                                    {{ auth()->user()->name }}
                                </h2>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-[#9AA0A6] font-medium mt-1">
                                    {{ auth()->user()->isSuperAdmin() ? 'Super Admin KAI' : 'Admin KAI Aset' }}
                                </p>
                            </div>
                        </div>
                        <button
                            type="button"
                            onclick="openEditProfileModal()"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-sm font-medium text-white shadow-xs transition cursor-pointer"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <span>Edit</span>
                        </button>
                    </div>

                    {{-- Card Informasi Profil --}}
                    <div class="rounded-3xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-xs space-y-6 transition-colors">
                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/10 pb-4">
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Informasi Profil</h3>
                            <button
                                type="button"
                                onclick="openEditProfileModal()"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-sm font-medium text-white shadow-xs transition cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>Edit</span>
                            </button>
                        </div>

                        @php
                            $nameParts = explode(' ', auth()->user()->name, 2);
                            $firstName = $nameParts[0] ?? '';
                            $lastName  = $nameParts[1] ?? '';
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8 pt-2">
                            <div>
                                <span class="block text-xs font-medium text-gray-400 dark:text-[#9AA0A6] mb-1.5">Nama Awal</span>
                                <span class="block text-sm sm:text-[15px] font-semibold text-gray-900 dark:text-white" id="display-first-name">{{ $firstName }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-medium text-gray-400 dark:text-[#9AA0A6] mb-1.5">Nama Akhir</span>
                                <span class="block text-sm sm:text-[15px] font-semibold text-gray-900 dark:text-white" id="display-last-name">{{ $lastName }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-medium text-gray-400 dark:text-[#9AA0A6] mb-1.5">Username</span>
                                <span class="block text-sm sm:text-[15px] font-semibold text-gray-900 dark:text-white">{{ auth()->user()->username }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-medium text-gray-400 dark:text-[#9AA0A6] mb-1.5">Alamat Email</span>
                                <span class="block text-sm sm:text-[15px] font-semibold text-gray-900 dark:text-white" id="display-email">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ─── TAB 2: MANAJEMEN ADMIN ─── --}}
                <div id="panel-manajemen-admin" class="space-y-6">
                    <div class="rounded-3xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-xs space-y-6 transition-colors">

                        {{-- Header Controls --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2.5 sm:gap-4">
                            <div class="flex items-center gap-2 sm:gap-3 flex-1 max-w-md">
                                {{-- Search --}}
                                <div class="relative flex-1 h-[36px] sm:h-[40px]">
                                    <span class="absolute left-2.5 sm:left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </span>
                                    <input
                                        type="text"
                                        placeholder="Search"
                                        id="search-admin-input"
                                        onkeyup="filterAdminTable()"
                                        class="w-full h-full rounded-lg sm:rounded-[10px] border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] pl-8 sm:pl-10 pr-3 sm:pr-4 text-[11px] sm:text-sm text-gray-800 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#0066FF] focus:outline-none transition shadow-2xs"
                                    >
                                </div>

                                {{-- Role Filter --}}
                                <div class="relative h-[36px] sm:h-[40px]">
                                    <select
                                        id="filter-role-select"
                                        onchange="filterAdminTable()"
                                        class="h-full rounded-lg sm:rounded-[10px] border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] py-1 pl-2.5 sm:pl-3.5 pr-7 sm:pr-8 text-[11px] sm:text-sm text-gray-600 dark:text-gray-200 focus:border-[#0066FF] focus:outline-none transition shadow-2xs appearance-none cursor-pointer"
                                    >
                                        <option value="">Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="superadmin">SuperAdmin</option>
                                    </select>
                                    <span class="absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            {{-- Tambah Admin --}}
                            <button
                                type="button"
                                onclick="openAddAdminModal()"
                                class="inline-flex items-center gap-1.5 px-3.5 sm:px-5 py-1.5 sm:py-2.5 rounded-lg sm:rounded-[10px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-semibold text-white shadow-xs transition cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Tambah Admin</span>
                            </button>
                        </div>

                        {{-- Admin Table --}}
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs sm:text-sm text-gray-700 dark:text-gray-300" id="admin-table">
                                <thead class="text-xs font-semibold text-gray-400 dark:text-[#9AA0A6] border-b border-gray-100 dark:border-white/10">
                                    <tr>
                                        <th class="py-3 px-4">Email</th>
                                        <th class="py-3 px-4">Nama Akun</th>
                                        <th class="py-3 px-4">Role</th>
                                        <th class="py-3 px-4">Terakhir Aktif ↑↓</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-white/10" id="admin-tbody">
                                    @forelse($admins as $user)
                                        <tr class="hover:bg-gray-50/70 dark:hover:bg-white/5 transition admin-row" data-role="{{ $user->role }}">
                                            <td class="py-4 px-4 text-gray-700 dark:text-gray-300 email-col">{{ $user->email }}</td>
                                            <td class="py-4 px-4 font-semibold text-gray-950 dark:text-white name-col">{{ $user->name }}</td>
                                            <td class="py-4 px-4 role-col">
                                                @if($user->role === 'superadmin')
                                                    <span class="inline-block px-3 py-0.5 rounded-full text-xs font-medium text-[#0066FF] dark:text-[#3B82F6] bg-blue-50 dark:bg-blue-900/30 border border-blue-200/80 dark:border-blue-800">SuperAdmin</span>
                                                @else
                                                    <span class="inline-block px-3 py-0.5 rounded-full text-xs font-medium text-green-700 dark:text-emerald-400 bg-green-50 dark:bg-emerald-900/30 border border-green-200/80 dark:border-emerald-800">Admin</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-4 text-xs text-gray-500 dark:text-[#9AA0A6]">
                                                {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y \a\t H.i A') : ($user->updated_at ? $user->updated_at->format('d/m/Y \a\t H.i A') : '-') }}
                                            </td>
                                            <td class="py-4 px-4 text-center relative">
                                                <button
                                                    type="button"
                                                    onclick="toggleAdminActionDropdown('drop-{{ $user->id }}')"
                                                    class="p-1 text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white transition cursor-pointer text-lg leading-none select-none"
                                                >
                                                    ⋮
                                                </button>

                                                {{-- Action Dropdown --}}
                                                <div id="drop-{{ $user->id }}" class="admin-dropdown absolute right-4 top-10 w-52 bg-white dark:bg-[#1F2123] rounded-2xl shadow-xl border border-gray-100 dark:border-white/10 py-2 z-30 text-left text-xs" style="display:none">

                                                    {{-- Toggle Aktif / Nonaktif --}}
                                                    <form action="{{ route('settings.admins.toggle', $user) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 transition cursor-pointer">
                                                            <span>👤</span>
                                                            <span>{{ $user->is_active ? 'Non Aktif Profil' : 'Aktifkan Profil' }}</span>
                                                        </button>
                                                    </form>

                                                    {{-- Reset Sandi Sementara (hanya admin, bukan superadmin) --}}
                                                    @if($user->role === 'admin')
                                                        {{-- Tombol ini trigger POST reset password sementara --}}
                                                        <button
                                                            type="button"
                                                            onclick="confirmResetSandi({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                            class="w-full flex items-center gap-2.5 px-4 py-2 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 transition cursor-pointer"
                                                        >
                                                            <span>🔑</span>
                                                            <span>Reset Sandi Sementara</span>
                                                        </button>
                                                    @endif

                                                    {{-- Hapus Admin (hanya admin, bukan superadmin, bukan diri sendiri) --}}
                                                    @if($user->role === 'admin' && $user->id !== auth()->id())
                                                        <form action="{{ route('settings.admins.destroy', $user) }}" method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus admin {{ addslashes($user->name) }}? Tindakan ini tidak bisa dibatalkan.')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 hover:bg-red-50 dark:hover:bg-red-950/30 text-red-600 dark:text-red-400 transition cursor-pointer">
                                                                <span>🗑️</span>
                                                                <span>Hapus Admin</span>
                                                            </button>
                                                        </form>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-12 text-center text-gray-400 dark:text-[#9AA0A6] text-sm">
                                                <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                Belum ada akun terdaftar.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if($admins->hasPages())
                            <div class="pt-2 border-t border-gray-100 dark:border-white/10">
                                {{ $admins->links() }}
                            </div>
                        @endif

                    </div>
                </div>


                {{-- ─── TAB 2: PERSETUJUAN RESET SANDI ─── --}}
                <div id="panel-persetujuan-sandi" class="hidden space-y-6">
                    <div class="rounded-3xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-xs space-y-6 transition-colors">

                        {{-- Header Controls --}}
                        <div class="flex items-center gap-3 max-w-md">
                            <div class="relative flex-1">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    placeholder="Search"
                                    id="search-request-input"
                                    onkeyup="filterRequestCards()"
                                    class="w-full rounded-[10px] border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] py-2.5 pl-10 pr-4 text-sm text-gray-800 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#0066FF] focus:outline-none transition shadow-2xs"
                                >
                            </div>

                            <div class="relative">
                                <select
                                    id="filter-status-select"
                                    onchange="filterRequestCards()"
                                    class="rounded-[10px] border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] py-2.5 pl-3.5 pr-8 text-sm text-gray-600 dark:text-gray-200 focus:border-[#0066FF] focus:outline-none transition shadow-2xs appearance-none cursor-pointer"
                                >
                                    <option value="">Semua Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="rejected">Ditolak</option>
                                    <option value="completed">Selesai</option>
                                </select>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        {{-- Request Cards --}}
                        <div class="space-y-4" id="requests-list-container">
                            @forelse($requests as $req)
                                <div
                                    class="request-card rounded-2xl border border-gray-200/90 dark:border-white/10 bg-white dark:bg-[#1F2123] p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:border-gray-300 dark:hover:border-white/20"
                                    data-name="{{ strtolower($req->user->name ?? '') }}"
                                    data-email="{{ strtolower($req->user->email ?? '') }}"
                                    data-status="{{ $req->status }}"
                                >
                                    <div class="flex items-center gap-4">
                                        <div class="w-11 h-11 rounded-full bg-gray-200 dark:bg-[#34383D] flex items-center justify-center shrink-0 text-gray-400 dark:text-gray-300">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $req->user->name ?? '-' }}</h4>
                                            <p class="text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5">{{ $req->user->email ?? '-' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4 sm:gap-6 justify-between sm:justify-end">
                                        {{-- Waktu --}}
                                        <span class="text-xs text-gray-500 dark:text-[#9AA0A6]">
                                            {{ $req->created_at->format('d/m/Y \a\t H.i A') }}
                                        </span>

                                        {{-- Status badge atau tombol aksi --}}
                                        @if($req->isPending())
                                            <div class="flex items-center gap-2">
                                                {{-- Tolak --}}
                                                <form action="{{ route('settings.reset-requests.reject', $req) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Tolak request reset password dari {{ addslashes($req->user->name ?? '') }}?')"
                                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-[8px] bg-[#E00000] hover:bg-red-700 text-xs font-medium text-white shadow-xs transition cursor-pointer"
                                                    >
                                                        <span>✕</span>
                                                        <span>Tolak</span>
                                                    </button>
                                                </form>
                                                {{-- Setuju --}}
                                                <form action="{{ route('settings.reset-requests.approve', $req) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Setujui request dan kirim OTP ke email {{ addslashes($req->user->email ?? '') }}?')"
                                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-xs font-medium text-white shadow-xs transition cursor-pointer"
                                                    >
                                                        <span>✓</span>
                                                        <span>Setuju</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            @php
                                                $statusMap = [
                                                    'approved'   => ['bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400', 'Disetujui'],
                                                    'rejected'   => ['bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400', 'Ditolak'],
                                                    'completed'  => ['bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400', 'Selesai'],
                                                    'auto_reset' => ['bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400', 'Auto Reset'],
                                                ];
                                                [$cls, $label] = $statusMap[$req->status] ?? ['bg-gray-100 text-gray-600', $req->status];
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $cls }}">
                                                {{ $label }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 text-center text-gray-400 dark:text-[#9AA0A6] text-sm">
                                    <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"/></svg>
                                    Tidak ada request reset password.
                                </div>
                            @endforelse
                        </div>

                        {{-- Pagination --}}
                        @if($requests->hasPages())
                            <div class="pt-2 border-t border-gray-100 dark:border-white/10">
                                {{ $requests->links() }}
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </main>


    {{-- ================= MODAL EDIT PROFIL ================= --}}
    <div id="modal-edit-profile" style="display:none" class="fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="w-full max-w-md rounded-3xl bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-2xl border border-gray-100 dark:border-white/10 space-y-5 transition-colors">

            <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/10 pb-3">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Informasi Profil</h3>
                <button type="button" onclick="closeEditProfileModal()" class="text-gray-400 hover:text-gray-700 dark:hover:text-white text-lg cursor-pointer">✕</button>
            </div>

            <form action="{{ route('settings.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Nama Awal</label>
                        <input type="text" name="first_name" value="{{ explode(' ', auth()->user()->name, 2)[0] ?? '' }}"
                            class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white focus:border-[#0066FF] focus:outline-none transition" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Nama Akhir</label>
                        <input type="text" name="last_name" value="{{ explode(' ', auth()->user()->name, 2)[1] ?? '' }}"
                            class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white focus:border-[#0066FF] focus:outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Username</label>
                    <input type="text" name="username" value="{{ auth()->user()->username }}"
                        class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white focus:border-[#0066FF] focus:outline-none transition" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Alamat Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}"
                        class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white focus:border-[#0066FF] focus:outline-none transition" required>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3">
                    <button type="button" onclick="closeEditProfileModal()"
                        class="px-5 py-2.5 rounded-[8px] border border-gray-200 dark:border-white/10 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/10 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-sm font-medium text-white transition shadow-xs cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= MODAL TAMBAH ADMIN ================= --}}
    <div id="modal-tambah-admin" style="display:none" class="fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="w-full max-w-md rounded-3xl bg-white dark:bg-[#1F2123] p-6 sm:p-8 shadow-2xl border border-gray-100 dark:border-white/10 space-y-5 transition-colors">

            <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/10 pb-3">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tambah Akun Admin Baru</h3>
                <button type="button" onclick="closeAddAdminModal()" class="text-gray-400 hover:text-gray-700 dark:hover:text-white text-lg cursor-pointer">✕</button>
            </div>

            <form action="{{ route('settings.admins.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Contoh: Budi Santoso"
                        class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-[#0066FF] focus:outline-none transition" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Username</label>
                    <input type="text" name="username" placeholder="Contoh: budi.santoso"
                        class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-[#0066FF] focus:outline-none transition" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Alamat Email Dinas</label>
                    <input type="email" name="email" placeholder="nama@daop4.com"
                        class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-[#0066FF] focus:outline-none transition" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Password</label>
                    <input type="password" name="password" placeholder="Min. 8 karakter"
                        class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-[#0066FF] focus:outline-none transition" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password"
                        class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-white dark:bg-[#2D3034] px-3.5 py-2.5 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-[#0066FF] focus:outline-none transition" required>
                </div>

                {{-- Validation errors --}}
                @if($errors->any() && old('_form') === 'tambah-admin')
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <input type="hidden" name="_form" value="tambah-admin">

                <div class="flex items-center justify-end gap-3 pt-3">
                    <button type="button" onclick="closeAddAdminModal()"
                        class="px-5 py-2.5 rounded-[8px] border border-gray-200 dark:border-white/10 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/10 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-sm font-medium text-white transition shadow-xs cursor-pointer">
                        Simpan Admin
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // ─── Helpers modal (pakai style.display bukan class hidden agar tidak konflik dengan Tailwind CDN) ───
        function openModal(id)  { const el = document.getElementById(id); if(el) el.style.display = 'flex'; }
        function closeModal(id) { const el = document.getElementById(id); if(el) el.style.display = 'none'; }

        function openAddAdminModal()    { openModal('modal-tambah-admin'); }
        function closeAddAdminModal()   { closeModal('modal-tambah-admin'); }
        function openEditProfileModal() { openModal('modal-edit-profile'); }
        function closeEditProfileModal(){ closeModal('modal-edit-profile'); }

        // ─── Tab aktif dari server ────────────────────────────────────────────────
        const initialTab = '{{ $activeTab }}';

        function switchSuperTab(tabName) {
            const tabs = {
                'profil-saya':       { btn: 'tab-btn-profil',     panel: 'panel-profil-saya' },
                'manajemen-admin':   { btn: 'tab-btn-manajemen',  panel: 'panel-manajemen-admin' },
                'persetujuan-sandi': { btn: 'tab-btn-persetujuan',panel: 'panel-persetujuan-sandi' },
            };

            const activeBase   = 'shrink-0 text-left text-sm font-semibold transition cursor-pointer px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none text-[#0066FF] dark:text-[#3B82F6] bg-blue-50 dark:bg-blue-900/30 lg:bg-transparent lg:dark:bg-transparent';
            const inactiveBase = 'shrink-0 text-left text-sm font-medium transition cursor-pointer px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white bg-gray-100/80 dark:bg-[#2D3034] lg:bg-transparent lg:dark:bg-transparent';

            Object.entries(tabs).forEach(([name, { btn, panel }]) => {
                const btnEl   = document.getElementById(btn);
                const panelEl = document.getElementById(panel);
                const isActive = name === tabName;
                if (btnEl) {
                    const extra = (btn === 'tab-btn-persetujuan') ? ' flex items-center gap-2' : '';
                    btnEl.className = (isActive ? activeBase : inactiveBase) + extra;
                }
                if (panelEl) panelEl.style.display = isActive ? 'block' : 'none';
            });
        }

        // ─── Dropdown Three-Dots per row ──────────────────────────────────────────
        function toggleAdminActionDropdown(dropId) {
            document.querySelectorAll('.admin-dropdown').forEach(d => {
                if (d.id !== dropId) d.style.display = 'none';
            });
            const current = document.getElementById(dropId);
            if (current) current.style.display = current.style.display === 'none' ? 'block' : 'none';
        }

        // ─── Reset Sandi Sementara ────────────────────────────────────────────────
        function confirmResetSandi(userId, name) {
            if (confirm(`Reset sandi sementara untuk ${name}? Password baru akan dikirim ke email mereka.`)) {
                alert('Fitur ini belum tersedia.');
            }
        }

        // ─── Filter Tabel Admin ───────────────────────────────────────────────────
        function filterAdminTable() {
            const query = document.getElementById('search-admin-input').value.toLowerCase();
            const role  = document.getElementById('filter-role-select').value.toLowerCase();
            document.querySelectorAll('.admin-row').forEach(row => {
                const email = row.querySelector('.email-col')?.textContent.toLowerCase() ?? '';
                const name  = row.querySelector('.name-col')?.textContent.toLowerCase() ?? '';
                const rRole = (row.dataset.role ?? '').toLowerCase();
                const matchQuery = !query || email.includes(query) || name.includes(query);
                const matchRole  = !role  || rRole === role;
                row.style.display = (matchQuery && matchRole) ? '' : 'none';
            });
        }

        // ─── Filter Cards Reset Requests ──────────────────────────────────────────
        function filterRequestCards() {
            const query  = document.getElementById('search-request-input').value.toLowerCase();
            const status = document.getElementById('filter-status-select').value.toLowerCase();
            document.querySelectorAll('.request-card').forEach(card => {
                const name    = card.dataset.name  ?? '';
                const email   = card.dataset.email ?? '';
                const cStatus = card.dataset.status ?? '';
                const matchQuery  = !query  || name.includes(query) || email.includes(query);
                const matchStatus = !status || cStatus === status;
                card.style.display = (matchQuery && matchStatus) ? '' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Init semua panel tersembunyi dulu
            ['panel-profil-saya', 'panel-manajemen-admin', 'panel-persetujuan-sandi'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });

            // Init semua dropdown tersembunyi
            document.querySelectorAll('.admin-dropdown').forEach(d => d.style.display = 'none');

            // Aktifkan tab
            switchSuperTab(initialTab);

            // Auto-buka modal tambah admin jika ada validation error dari form itu
            @if($errors->any() && old('_form') === 'tambah-admin')
                switchSuperTab('manajemen-admin');
                openAddAdminModal();
            @endif

            // Auto-hide flash toast
            const toast = document.getElementById('flash-toast');
            if (toast) {
                setTimeout(() => {
                    toast.style.transition = 'opacity 0.3s';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 4000);
            }

            // Tutup modal jika klik backdrop
            ['modal-tambah-admin', 'modal-edit-profile'].forEach(id => {
                document.getElementById(id)?.addEventListener('click', function(e) {
                    if (e.target === this) closeModal(id);
                });
            });

            // Tutup dropdown jika klik di luar
            document.addEventListener('click', (e) => {
                if (!e.target.closest('td')) {
                    document.querySelectorAll('.admin-dropdown').forEach(d => d.style.display = 'none');
                }
            });
        });
    </script>

</body>
</html>
