@props(['active' => 'dashboard'])

<!-- ===== TOP NAVIGATION BAR (Sticky, for all screens) ===== -->
<header id="mainNavbar" class="sticky top-0 z-[100] w-full bg-[#F6F7F9]/95 dark:bg-[#282A2C]/95 backdrop-blur-md transition-all duration-200 border-b border-transparent">
    <nav class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-10 h-14 sm:h-16 lg:h-20 flex items-center justify-between gap-3">

        <!-- Logo KAI TrackerApp -->
        <a href="{{ route('welcome') }}" class="flex items-center sm:gap-2 text-[15px] sm:text-[16px] lg:text-[18px] font-bold italic tracking-tight text-gray-950 dark:text-white shrink-0 transition hover:opacity-90">
            <x-icon name="kai-logo" class="h-[19px] sm:h-5 lg:h-[24px] w-auto shrink-0" />
            <span class="leading-none select-none text-gray-950 dark:text-white">Tracker<span class="text-[#0066FF]">App</span></span>
        </a>

        <!-- Menu Navigasi Desktop (lg and above only) -->
        <ul class="hidden lg:flex items-center gap-6 xl:gap-8 text-sm text-[#4A4A4A] dark:text-[#9AA0A6]">
            <li>
                <a
                    href="{{ route('welcome') }}"
                    class="inline-block py-1 pb-1.5 transition-all duration-150 {{ $active === 'dashboard' ? 'font-semibold text-[#0066FF] dark:text-[#3B82F6] border-b-2 border-[#0066FF] dark:border-[#3B82F6]' : 'font-medium text-[#4A4A4A] dark:text-[#9AA0A6] hover:text-gray-950 dark:hover:text-white border-b-2 border-transparent' }}"
                >
                    Dashboard
                </a>
            </li>
            <li>
                <a
                    href="{{ route('map') }}"
                    class="inline-block py-1 pb-1.5 transition-all duration-150 {{ $active === 'map' ? 'font-semibold text-[#0066FF] dark:text-[#3B82F6] border-b-2 border-[#0066FF] dark:border-[#3B82F6]' : 'font-medium text-[#4A4A4A] dark:text-[#9AA0A6] hover:text-gray-950 dark:hover:text-white border-b-2 border-transparent' }}"
                >
                    Peta
                </a>
            </li>
            <li>
                <a
                    href="{{ route('contracts.index') }}"
                    class="inline-block py-1 pb-1.5 transition-all duration-150 {{ $active === 'contracts' ? 'font-semibold text-[#0066FF] dark:text-[#3B82F6] border-b-2 border-[#0066FF] dark:border-[#3B82F6]' : 'font-medium text-[#4A4A4A] dark:text-[#9AA0A6] hover:text-gray-950 dark:hover:text-white border-b-2 border-transparent' }}"
                >
                    Daftar Kontrak
                </a>
            </li>
            <li>
                <a
                    href="{{ route('due-dates.index') }}"
                    class="inline-block py-1 pb-1.5 transition-all duration-150 {{ $active === 'due-dates' ? 'font-semibold text-[#0066FF] dark:text-[#3B82F6] border-b-2 border-[#0066FF] dark:border-[#3B82F6]' : 'font-medium text-[#4A4A4A] dark:text-[#9AA0A6] hover:text-gray-950 dark:hover:text-white border-b-2 border-transparent' }}"
                >
                    Jatuh Tempo
                </a>
            </li>
            <li>
                <a
                    href="{{ route('backlog.index') }}"
                    class="inline-block py-1 pb-1.5 transition-all duration-150 {{ in_array($active, ['backlog', 'blacklog']) ? 'font-semibold text-[#0066FF] dark:text-[#3B82F6] border-b-2 border-[#0066FF] dark:border-[#3B82F6]' : 'font-medium text-[#4A4A4A] dark:text-[#9AA0A6] hover:text-gray-950 dark:hover:text-white border-b-2 border-transparent' }}"
                >
                    Backlog
                </a>
            </li>
            <li>
                <a
                    href="{{ route('laporan.index') }}"
                    class="inline-block py-1 pb-1.5 transition-all duration-150 {{ in_array($active, ['reports', 'laporan']) ? 'font-semibold text-[#0066FF] dark:text-[#3B82F6] border-b-2 border-[#0066FF] dark:border-[#3B82F6]' : 'font-medium text-[#4A4A4A] dark:text-[#9AA0A6] hover:text-gray-950 dark:hover:text-white border-b-2 border-transparent' }}"
                >
                    Laporan
                </a>
            </li>
        </ul>

        <!-- Profil & Aksi Kanan -->
        <div class="flex items-center gap-2 shrink-0">

            <!-- Ganti Mode / Theme Toggle (Tampil di Mobile & Desktop) -->
            <button
                type="button"
                id="themeToggleBtn"
                onclick="toggleTheme()"
                class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-[10px] border border-gray-300/80 dark:border-white/15 bg-transparent text-gray-700 dark:text-white hover:bg-gray-200/70 dark:hover:bg-white/10 active:scale-95 transition shadow-none cursor-pointer"
                title="Ganti Mode"
            >
                <x-icon name="moon" class="theme-icon-moon h-4.5 w-4.5 sm:h-5 sm:w-5 lg:h-[19px] lg:w-[19px] text-[#262626] dark:text-white" />
                <x-icon name="sun" class="theme-icon-sun hidden h-4.5 w-4.5 sm:h-5 sm:w-5 lg:h-[19px] lg:w-[19px] text-white" />
            </button>

            <!-- Notifikasi Bell (mobile & desktop) -->
            <div class="relative" id="notifWrapper">
                <button
                    type="button"
                    id="notifBtn"
                    onclick="toggleNotifDropdown()"
                    class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-[10px] border border-gray-300/80 dark:border-white/15 bg-transparent text-gray-700 dark:text-white hover:bg-gray-200/70 dark:hover:bg-white/10 active:scale-95 transition shadow-none cursor-pointer"
                    title="Notifikasi"
                >
                    <x-icon name="notification" class="h-4.5 w-4.5 sm:h-5 sm:w-5 lg:h-[19px] lg:w-[19px] text-[#262626] dark:text-white" />
                    <!-- Badge jumlah notifikasi -->
                    <span
                        id="notifBadge"
                        class="hidden absolute -top-1 -right-1 flex items-center justify-center min-w-[17px] h-[17px] px-[3px] rounded-full bg-red-500 text-white text-[10px] font-bold leading-none"
                    ></span>
                </button>

                <!-- Dropdown Notifikasi -->
                <div
                    id="notifDropdown"
                    class="absolute right-0 top-full mt-2 w-[300px] sm:w-[340px] origin-top-right rounded-2xl shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.7)] opacity-0 invisible scale-95 transition-all duration-200 bg-white dark:bg-[#1F2123] border border-gray-100 dark:border-white/10 z-[110] overflow-hidden"
                >
                    <!-- Header -->
                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-white/10">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Notifikasi</h3>
                        <span class="text-xs text-gray-400 dark:text-gray-500">Aset baru (24 jam terakhir)</span>
                    </div>

                    <!-- List Notifikasi -->
                    <div id="notifList" class="max-h-[340px] overflow-y-auto">
                        <!-- Skeleton / loading state -->
                        <div id="notifLoading" class="flex items-center justify-center py-8 text-gray-400 dark:text-gray-500 text-xs gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                            Memuat notifikasi...
                        </div>
                        <div id="notifEmpty" class="hidden flex-col items-center justify-center py-8 text-center px-4">
                            <svg class="h-10 w-10 text-gray-300 dark:text-gray-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tidak ada aset baru</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Belum ada aset yang ditambahkan dalam 24 jam terakhir</p>
                        </div>
                        <ul id="notifItems" class="hidden divide-y divide-gray-50 dark:divide-white/5"></ul>
                    </div>
                </div>
            </div>

            <!-- Profile (Desktop Only - On Mobile it is moved to the bottom floating navbar) -->
            <div class="relative hidden lg:block">

                <!-- Profile Button -->
                <button
                    id="profileButton"
                    type="button"
                    class="flex items-center gap-1.5 sm:gap-2 rounded-lg lg:rounded-[10px] hover:opacity-90 transition cursor-pointer"
                >
                    <div class="flex h-7 w-7 sm:h-9 sm:w-9 lg:h-10 lg:w-10 items-center justify-center rounded-lg lg:rounded-[10px] bg-gray-200/80 dark:bg-[#43484E] text-gray-600 dark:text-white shrink-0">
                        <x-icon name="profile-circle" class="w-3.5 h-3.5 sm:w-5 sm:h-5 lg:w-6 lg:w-6" />
                    </div>

                    <div class="hidden sm:block leading-tight text-left pl-0.5">
                        <p class="text-sm font-bold text-[#171717] dark:text-white">
                            @auth {{ auth()->user()->name }} @else Tamu @endauth
                        </p>

                        <p class="text-xs text-gray-400 dark:text-[#9AA0A6] font-normal mt-0.5">
                            @auth
                                @if(auth()->user()->isSuperAdmin()) Super Admin
                                @elseif(auth()->user()->isAdmin()) Admin
                                @else User @endif
                            @else
                                Tamu
                            @endauth
                        </p>
                    </div>

                    <!-- Arrow -->
                    <x-icon
                        name="chevron-down"
                        class="hidden sm:block h-4 w-4 text-gray-400 dark:text-[#9AA0A6] transition-transform duration-200"
                        id="profileArrow"
                    />
                </button>


                <!-- Dropdown Desktop (Ukuran dan style persis sama dengan dropdown aksi) -->
                <div
                    id="profileDropdown"
                    class="absolute right-0 top-full mt-2 w-max min-w-[200px] sm:min-w-[215px] origin-top-right rounded-2xl p-2 sm:p-2.5 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.7)] opacity-0 invisible scale-95 transition-all duration-200 bg-white dark:bg-[#1F2123] border border-gray-100 dark:border-white/10 z-[110] flex flex-col gap-1"
                >
                    @auth
                        @if(auth()->user()->isSuperAdmin())
                            <!-- Panel Super Admin -->
                            <a
                                href="{{ route('settings.superadmin') }}"
                                class="flex items-center gap-2.5 px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-xl transition whitespace-nowrap"
                            >
                                <x-icon name="setting" class="w-5 h-5 text-gray-500 dark:text-gray-300 shrink-0" />
                                <span class="whitespace-nowrap">Panel Super Admin</span>
                            </a>
                        @else
                            <!-- Pengaturan Akun (Admin) -->
                            <a
                                href="{{ route('settings.index') }}"
                                class="flex items-center gap-2.5 px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-xl transition whitespace-nowrap"
                            >
                                <x-icon name="setting" class="w-5 h-5 text-gray-500 dark:text-gray-300 shrink-0" />
                                <span class="whitespace-nowrap">Pengaturan Akun</span>
                            </a>
                        @endif

                        <!-- Logout -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="flex w-full items-center gap-2.5 px-3 py-2 text-xs sm:text-sm font-semibold text-[#EF4444] hover:bg-red-50 dark:hover:bg-red-950/30 rounded-xl transition cursor-pointer whitespace-nowrap"
                            >
                                <x-icon name="logout" class="w-5 h-5 text-[#EF4444] shrink-0" />
                                <span class="whitespace-nowrap">Keluar</span>
                            </button>
                        </form>
                    @else
                        <!-- Pengaturan Akun (Tamu) -->
                        <a
                            href="{{ route('settings.index') }}"
                            class="flex items-center gap-2.5 px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-xl transition whitespace-nowrap"
                        >
                            <x-icon name="setting" class="w-5 h-5 text-gray-500 dark:text-gray-300 shrink-0" />
                            <span class="whitespace-nowrap">Pengaturan Akun</span>
                        </a>

                        <!-- Login (Tamu) -->
                        <a
                            href="{{ route('login') }}"
                            class="flex w-full items-center gap-2.5 px-3 py-2 text-xs sm:text-sm font-semibold text-[#0066FF] dark:text-[#3B82F6] hover:bg-blue-50 dark:hover:bg-blue-950/30 rounded-xl transition cursor-pointer whitespace-nowrap"
                        >
                            <x-icon name="icon-masuk" class="w-5 h-5 text-[#0066FF] dark:text-[#3B82F6] shrink-0" />
                            <span class="whitespace-nowrap">Masuk</span>
                        </a>
                    @endauth
                </div>

            </div>
        </div>

    </nav>
</header>

<!-- ===== MOBILE MENU BACKDROP OVERLAY ===== -->
<div id="mobileMenuBackdrop" class="hidden lg:hidden fixed inset-0 z-[110] bg-black/40 backdrop-blur-[2px] opacity-0 transition-opacity duration-300 pointer-events-none" onclick="closeMobileSubMenu()"></div>

<!-- ===== EXPANDABLE NAVBAR MODAL PANEL (Persis Desain Gambar 1 & 2) ===== -->
<div
    id="mobileSubMenu"
    class="hidden lg:hidden fixed z-[120] max-w-[340px] sm:max-w-[360px] w-[calc(100%-2rem)] mx-auto opacity-0 scale-90 translate-y-4 pointer-events-none transition-all duration-300 ease-out origin-bottom-right"
    style="bottom: max(5.25rem, calc(4.75rem + env(safe-area-inset-bottom, 0px))); left: 0; right: 0;"
>
    <div class="rounded-[28px] sm:rounded-[32px] bg-white/95 dark:bg-[#1F2123]/95 backdrop-blur-xl border border-gray-200/80 dark:border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.6)] p-3.5 sm:p-4">
        
        <!-- Grid 4 Menu Utama (Persis Gambar 2: Icon dalam kotak squircle + Label di bawah) -->
        <div class="grid grid-cols-4 gap-2 sm:gap-2.5">
            
            <!-- 1. Daftar Kontrak -->
            <a
                href="{{ route('contracts.index') }}"
                class="flex flex-col items-center text-center transition active:scale-95 group select-none"
            >
                <div class="w-full aspect-square max-w-[62px] rounded-[20px] {{ $active === 'contracts' ? 'bg-[#0066FF] text-white shadow-[0_4px_16px_rgba(0,102,255,0.45)]' : 'bg-gray-100/90 dark:bg-[#2D3034] text-gray-700 dark:text-gray-200 hover:bg-gray-200/90 dark:hover:bg-[#383C40] active:bg-gray-300 dark:active:bg-[#43484E] border border-gray-200/50 dark:border-white/5' }} flex items-center justify-center transition-all duration-200">
                    <x-icon name="nav-contract" class="w-6 h-6" />
                </div>
                <span class="text-[11px] {{ $active === 'contracts' ? 'text-[#0066FF] dark:text-white font-bold' : 'text-gray-600 dark:text-gray-300 font-medium' }} mt-1.5 leading-tight truncate">Kontrak</span>
            </a>

            <!-- 2. Jatuh Tempo -->
            <a
                href="{{ route('due-dates.index') }}"
                class="flex flex-col items-center text-center transition active:scale-95 group select-none"
            >
                <div class="w-full aspect-square max-w-[62px] rounded-[20px] {{ $active === 'due-dates' ? 'bg-[#0066FF] text-white shadow-[0_4px_16px_rgba(0,102,255,0.45)]' : 'bg-gray-100/90 dark:bg-[#2D3034] text-gray-700 dark:text-gray-200 hover:bg-gray-200/90 dark:hover:bg-[#383C40] active:bg-gray-300 dark:active:bg-[#43484E] border border-gray-200/50 dark:border-white/5' }} flex items-center justify-center transition-all duration-200">
                    <x-icon name="nav-card" class="w-6 h-6" />
                </div>
                <span class="text-[11px] {{ $active === 'due-dates' ? 'text-[#0066FF] dark:text-white font-bold' : 'text-gray-600 dark:text-gray-300 font-medium' }} mt-1.5 leading-tight truncate">Tempo</span>
            </a>

            <!-- 3. Backlog -->
            <a
                href="{{ route('backlog.index') }}"
                class="flex flex-col items-center text-center transition active:scale-95 group select-none"
            >
                <div class="w-full aspect-square max-w-[62px] rounded-[20px] {{ in_array($active, ['backlog', 'blacklog']) ? 'bg-[#0066FF] text-white shadow-[0_4px_16px_rgba(0,102,255,0.45)]' : 'bg-gray-100/90 dark:bg-[#2D3034] text-gray-700 dark:text-gray-200 hover:bg-gray-200/90 dark:hover:bg-[#383C40] active:bg-gray-300 dark:active:bg-[#43484E] border border-gray-200/50 dark:border-white/5' }} flex items-center justify-center transition-all duration-200">
                    <x-icon name="nav-scan" class="w-6 h-6" />
                </div>
                <span class="text-[11px] {{ in_array($active, ['backlog', 'blacklog']) ? 'text-[#0066FF] dark:text-white font-bold' : 'text-gray-600 dark:text-gray-300 font-medium' }} mt-1.5 leading-tight truncate">Backlog</span>
            </a>

            <!-- 4. Laporan -->
            <a
                href="{{ route('laporan.index') }}"
                class="flex flex-col items-center text-center transition active:scale-95 group select-none"
            >
                <div class="w-full aspect-square max-w-[62px] rounded-[20px] {{ in_array($active, ['reports', 'laporan']) ? 'bg-[#0066FF] text-white shadow-[0_4px_16px_rgba(0,102,255,0.45)]' : 'bg-gray-100/90 dark:bg-[#2D3034] text-gray-700 dark:text-gray-200 hover:bg-gray-200/90 dark:hover:bg-[#383C40] active:bg-gray-300 dark:active:bg-[#43484E] border border-gray-200/50 dark:border-white/5' }} flex items-center justify-center transition-all duration-200">
                    <x-icon name="nav-report" class="w-6 h-6" />
                </div>
                <span class="text-[11px] {{ in_array($active, ['reports', 'laporan']) ? 'text-[#0066FF] dark:text-white font-bold' : 'text-gray-600 dark:text-gray-300 font-medium' }} mt-1.5 leading-tight truncate">Laporan</span>
            </a>

        </div>
    </div>
</div>

<!-- ===== BOTTOM MOBILE NAVIGATION (Expandable Navbar, hidden on lg+) ===== -->
<div class="lg:hidden fixed bottom-0 inset-x-0 z-[120] pointer-events-none select-none px-4 pb-4" style="padding-bottom: max(1rem, env(safe-area-inset-bottom, 1rem));">
    <div class="flex items-center justify-center gap-2.5 max-w-[340px] sm:max-w-[360px] mx-auto pointer-events-auto">
        
        <!-- 1. Grup Pill Kapsul Navbar: [Dashboard] [Peta] [Profil] (Persis Gambar 3 dengan Oval Active Highlight) -->
        <nav id="mobileBottomNav" class="flex-1 bg-white/95 dark:bg-[#1F2123]/95 backdrop-blur-xl rounded-full p-1.5 flex items-center justify-between shadow-[0_8px_35px_rgba(0,0,0,0.12)] dark:shadow-[0_8px_35px_rgba(0,0,0,0.6)] border border-gray-200/80 dark:border-white/10 transition-all duration-300">
            
            <!-- Dashboard (Home) -->
            <a
                id="mobileNavHome"
                href="{{ route('welcome') }}"
                class="mobile-nav-item flex-1 h-11 flex items-center justify-center rounded-[22px] transition-all duration-200 {{ in_array($active, ['dashboard', 'home', 'welcome']) ? 'bg-gray-100 dark:bg-[#2D3034] text-[#0066FF] dark:text-white shadow-xs font-semibold' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-white/5 active:scale-95' }}"
                title="Dashboard"
            >
                <x-icon name="nav-home" class="h-5 w-5 sm:h-[22px] sm:w-[22px]" />
            </a>

            <!-- Peta (Map) -->
            <a
                id="mobileNavMap"
                href="{{ route('map') }}"
                class="mobile-nav-item flex-1 h-11 flex items-center justify-center rounded-[22px] transition-all duration-200 {{ in_array($active, ['map', 'peta', 'asset']) ? 'bg-gray-100 dark:bg-[#2D3034] text-[#0066FF] dark:text-white shadow-xs font-semibold' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-white/5 active:scale-95' }}"
                title="Peta"
            >
                <x-icon name="nav-map" class="h-5 w-5 sm:h-[22px] sm:w-[22px]" />
            </a>

            <!-- Profil / Pengaturan Akun -->
            <button
                id="mobileNavProfile"
                type="button"
                onclick="toggleMobileProfileSheet()"
                class="mobile-nav-item flex-1 h-11 flex items-center justify-center rounded-[22px] transition-all duration-200 cursor-pointer {{ in_array($active, ['settings', 'pengaturan', 'admin', 'profile', 'akun']) ? 'bg-gray-100 dark:bg-[#2D3034] text-[#0066FF] dark:text-white shadow-xs font-semibold' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-white/5 active:scale-95' }}"
                title="Profil & Pengaturan"
            >
                <x-icon name="nav-user" class="h-5 w-5 sm:h-[22px] sm:w-[22px]" />
            </button>
        </nav>

        <!-- 2. Tombol FAB Lingkaran Terpisah (+) di Samping Grup Navbar (Background Putih di Mode Terang, Gelap di Mode Gelap) -->
        <button
            id="mobileMenuFab"
            type="button"
            onclick="toggleMobileSubMenu()"
            class="h-14 w-14 sm:h-14 sm:w-14 shrink-0 flex items-center justify-center rounded-full bg-white/95 dark:bg-[#1F2123]/95 text-[#171717] dark:text-white border border-gray-200/80 dark:border-white/10 shadow-[0_8px_35px_rgba(0,0,0,0.12)] dark:shadow-[0_8px_35px_rgba(0,0,0,0.6)] backdrop-blur-xl transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer {{ in_array($active, ['contracts', 'due-dates', 'backlog', 'blacklog', 'reports', 'laporan']) ? 'ring-2 ring-[#0066FF]' : '' }}"
            title="Menu Tambahan"
            aria-label="Menu Tambahan"
        >
            <div id="fabIconPlus" class="transition-transform duration-300 transform">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </div>
        </button>

    </div>
</div>


<!-- ===== MOBILE PROFILE POPUP PANEL (Expandable di atas Navbar) ===== -->
<div id="mobileProfileBackdrop" class="hidden lg:hidden fixed inset-0 z-[110] bg-black/40 backdrop-blur-[2px] opacity-0 transition-opacity duration-300 pointer-events-none" onclick="closeMobileProfileSheet()"></div>
<div
    id="mobileProfileSheet"
    class="hidden lg:hidden fixed z-[120] max-w-[340px] sm:max-w-[360px] w-[calc(100%-2rem)] mx-auto opacity-0 scale-90 translate-y-4 pointer-events-none transition-all duration-300 ease-out origin-bottom"
    style="bottom: max(5.25rem, calc(4.75rem + env(safe-area-inset-bottom, 0px))); left: 0; right: 0;"
>
    <div class="rounded-[28px] sm:rounded-[32px] bg-white/95 dark:bg-[#1F2123]/95 backdrop-blur-xl border border-gray-200/80 dark:border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.6)] p-3.5 sm:p-4 flex flex-col gap-1.5">

        <!-- Info Profil -->
        <div class="flex items-center gap-3 px-2 py-2 mb-1 border-b border-gray-100 dark:border-white/10">
            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6] shrink-0 font-bold">
                <x-icon name="profile-circle" class="w-6 h-6" />
            </div>
            <div class="leading-tight">
                <p class="text-sm font-bold text-gray-900 dark:text-white">
                    @auth {{ auth()->user()->name }} @else Tamu @endauth
                </p>
                <p class="text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5">
                    @auth
                        @if(auth()->user()->isSuperAdmin()) Super Admin
                        @elseif(auth()->user()->isAdmin()) Admin
                        @else User @endif
                    @else
                        Tamu
                    @endauth
                </p>
            </div>
        </div>

        @auth
            @if(auth()->user()->isSuperAdmin())
                <a
                    href="{{ route('settings.superadmin') }}"
                    class="flex items-center gap-3 px-3 py-2.5 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-white/10 rounded-2xl transition whitespace-nowrap"
                >
                    <x-icon name="setting" class="w-5 h-5 text-gray-500 dark:text-gray-300 shrink-0" />
                    <span class="whitespace-nowrap">Panel Super Admin</span>
                </a>
            @else
                <a
                    href="{{ route('settings.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-white/10 rounded-2xl transition whitespace-nowrap"
                >
                    <x-icon name="setting" class="w-5 h-5 text-gray-500 dark:text-gray-300 shrink-0" />
                    <span class="whitespace-nowrap">Pengaturan Akun</span>
                </a>
            @endif

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="flex w-full items-center gap-3 px-3 py-2.5 text-xs sm:text-sm font-semibold text-[#EF4444] hover:bg-red-50 dark:hover:bg-red-950/30 rounded-2xl transition cursor-pointer whitespace-nowrap"
                >
                    <x-icon name="logout" class="w-5 h-5 text-[#EF4444] shrink-0" />
                    <span class="whitespace-nowrap">Keluar</span>
                </button>
            </form>
        @else
            <a
                href="{{ route('settings.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-white/10 rounded-2xl transition whitespace-nowrap"
            >
                <x-icon name="setting" class="w-5 h-5 text-gray-500 dark:text-gray-300 shrink-0" />
                <span class="whitespace-nowrap">Pengaturan Akun</span>
            </a>
            <a
                href="{{ route('login') }}"
                class="flex items-center gap-3 px-3 py-2.5 text-xs sm:text-sm font-semibold text-[#0066FF] dark:text-[#3B82F6] hover:bg-blue-50 dark:hover:bg-blue-950/30 rounded-2xl transition whitespace-nowrap"
            >
                <x-icon name="icon-masuk" class="w-5 h-5 text-[#0066FF] dark:text-[#3B82F6] shrink-0" />
                <span class="whitespace-nowrap">Masuk</span>
            </a>
        @endauth
    </div>
</div>

<script>
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (!navbar) return;
        if (window.scrollY > 10) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });

    // Mobile Expandable Submenu Toggle Functions (Smooth Spring Transition)
    function toggleMobileSubMenu() {
        const menu = document.getElementById('mobileSubMenu');
        const backdrop = document.getElementById('mobileMenuBackdrop');
        const fabPlus = document.getElementById('fabIconPlus');
        const fabBtn = document.getElementById('mobileMenuFab');
        if (!menu) return;

        const isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            closeMobileProfileSheet();

            menu.classList.remove('hidden');
            backdrop?.classList.remove('hidden');
            backdrop?.classList.remove('pointer-events-none');
            menu.classList.remove('pointer-events-none');

            requestAnimationFrame(() => {
                menu.classList.remove('opacity-0', 'scale-90', 'translate-y-4');
                menu.classList.add('opacity-100', 'scale-100', 'translate-y-0');
                backdrop?.classList.remove('opacity-0');
                backdrop?.classList.add('opacity-100');
                if (fabPlus) {
                    fabPlus.style.transform = 'rotate(45deg)';
                }
                if (fabBtn) {
                    fabBtn.classList.remove('bg-white/95', 'dark:bg-[#1F2123]/95', 'text-[#171717]', 'dark:text-white');
                    fabBtn.classList.add('bg-[#0066FF]', 'text-white', 'dark:bg-[#0066FF]');
                }
            });
        } else {
            closeMobileSubMenu();
        }
    }

    function closeMobileSubMenu() {
        const menu = document.getElementById('mobileSubMenu');
        const backdrop = document.getElementById('mobileMenuBackdrop');
        const fabPlus = document.getElementById('fabIconPlus');
        const fabBtn = document.getElementById('mobileMenuFab');
        if (!menu || menu.classList.contains('hidden')) return;

        menu.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
        menu.classList.add('opacity-0', 'scale-90', 'translate-y-4');
        backdrop?.classList.remove('opacity-100');
        backdrop?.classList.add('opacity-0');
        backdrop?.classList.add('pointer-events-none');
        menu.classList.add('pointer-events-none');

        if (fabPlus) {
            fabPlus.style.transform = 'rotate(0deg)';
        }
        if (fabBtn) {
            fabBtn.classList.remove('bg-[#0066FF]', 'dark:bg-[#0066FF]', 'text-white');
            fabBtn.classList.add('bg-white/95', 'dark:bg-[#1F2123]/95', 'text-[#171717]', 'dark:text-white');
        }

        setTimeout(() => {
            menu.classList.add('hidden');
            backdrop?.classList.add('hidden');
        }, 250);
    }

    const navActiveClasses = ['bg-gray-100', 'dark:bg-[#2D3034]', 'text-[#0066FF]', 'dark:text-white', 'shadow-xs', 'font-semibold'];
    const navInactiveClasses = ['text-gray-500', 'dark:text-gray-400', 'hover:text-gray-900', 'dark:hover:text-white', 'hover:bg-gray-50', 'dark:hover:bg-white/5'];

    // Mobile Expandable Profile Sheet Toggle
    function toggleMobileProfileSheet() {
        const sheet = document.getElementById('mobileProfileSheet');
        const backdrop = document.getElementById('mobileProfileBackdrop');
        const profileBtn = document.getElementById('mobileNavProfile');
        if (!sheet) return;
        const isHidden = sheet.classList.contains('hidden');
        if (isHidden) {
            closeMobileSubMenu();

            sheet.classList.remove('hidden');
            backdrop?.classList.remove('hidden');
            backdrop?.classList.remove('pointer-events-none');
            sheet.classList.remove('pointer-events-none');

            // Aktifkan highlight oval pada tombol profil navbar
            if (profileBtn) {
                profileBtn.classList.remove(...navInactiveClasses);
                profileBtn.classList.add(...navActiveClasses);
            }

            // Nonaktifkan sementara highlight pada menu aktif lain (misal Dashboard / Peta)
            const currentActive = document.querySelector('#mobileBottomNav .mobile-nav-item:not(#mobileNavProfile).font-semibold');
            if (currentActive) {
                currentActive.setAttribute('data-was-active', 'true');
                currentActive.classList.remove(...navActiveClasses);
                currentActive.classList.add(...navInactiveClasses);
            }

            requestAnimationFrame(() => {
                sheet.classList.remove('opacity-0', 'scale-90', 'translate-y-4');
                sheet.classList.add('opacity-100', 'scale-100', 'translate-y-0');
                backdrop?.classList.remove('opacity-0');
                backdrop?.classList.add('opacity-100');
            });
        } else {
            closeMobileProfileSheet();
        }
    }

    function closeMobileProfileSheet() {
        const sheet = document.getElementById('mobileProfileSheet');
        const backdrop = document.getElementById('mobileProfileBackdrop');
        const profileBtn = document.getElementById('mobileNavProfile');
        if (!sheet || sheet.classList.contains('hidden')) return;

        sheet.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
        sheet.classList.add('opacity-0', 'scale-90', 'translate-y-4');
        backdrop?.classList.remove('opacity-100');
        backdrop?.classList.add('opacity-0');
        backdrop?.classList.add('pointer-events-none');
        sheet.classList.add('pointer-events-none');

        // Kembalikan highlight aktif ke menu halaman semula jika sebelumnya aktif
        const prevActive = document.querySelector('#mobileBottomNav [data-was-active="true"]');
        if (prevActive) {
            prevActive.removeAttribute('data-was-active');
            prevActive.classList.remove(...navInactiveClasses);
            prevActive.classList.add(...navActiveClasses);

            if (profileBtn) {
                profileBtn.classList.remove(...navActiveClasses);
                profileBtn.classList.add(...navInactiveClasses);
            }
        }

        setTimeout(() => {
            sheet.classList.add('hidden');
            backdrop?.classList.add('hidden');
        }, 250);
    }

    // ===== NOTIFIKASI =====
    let notifLoaded = false;
    const NOTIF_READ_TS_KEY = 'kai_notif_read_at'; // unix timestamp (detik) terakhir user buka notif

    /** Ambil timestamp terakhir baca (detik). Default 0 = belum pernah buka. */
    function getReadAt() {
        try { return parseInt(localStorage.getItem(NOTIF_READ_TS_KEY) || '0', 10); } catch { return 0; }
    }

    /** Simpan timestamp sekarang sebagai "sudah dibaca". */
    function saveReadAt() {
        try { localStorage.setItem(NOTIF_READ_TS_KEY, Math.floor(Date.now() / 1000)); } catch {}
    }

    /** Hitung aset yang created_at_ts > readAt (belum dibaca saat terakhir buka) */
    function countUnread(items) {
        const readAt = getReadAt();
        return items.filter(item => (item.created_at_ts || 0) > readAt).length;
    }

    /** Update tampilan badge */
    function updateBadge(items) {
        const badgeEl = document.getElementById('notifBadge');
        if (!badgeEl) return;
        const unread = countUnread(items);
        if (unread > 0) {
            badgeEl.textContent = unread > 99 ? '99+' : unread;
            badgeEl.classList.remove('hidden');
            badgeEl.classList.add('flex');
        } else {
            badgeEl.classList.add('hidden');
            badgeEl.classList.remove('flex');
        }
    }

    // Cache data terakhir dari server
    let lastNotifItems = [];

    function toggleNotifDropdown() {
        const dropdown = document.getElementById('notifDropdown');
        if (!dropdown) return;

        const isOpen = !dropdown.classList.contains('invisible');

        if (isOpen) {
            // Tutup dropdown
            dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
            dropdown.classList.remove('opacity-100', 'visible', 'scale-100');
        } else {
            // Buka dropdown — catat waktu baca sekarang
            saveReadAt();
            dropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
            dropdown.classList.add('opacity-100', 'visible', 'scale-100');

            // Hilangkan badge setelah dibuka
            const badgeEl = document.getElementById('notifBadge');
            if (badgeEl) { badgeEl.classList.add('hidden'); badgeEl.classList.remove('flex'); }

            if (!notifLoaded) {
                fetchNotifications();
            }
        }
    }

    function fetchNotifications() {
        const loadingEl = document.getElementById('notifLoading');
        const emptyEl   = document.getElementById('notifEmpty');
        const itemsEl   = document.getElementById('notifItems');

        fetch('{{ route("notifications.new-assets") }}')
            .then(res => res.json())
            .then(data => {
                notifLoaded = true;
                lastNotifItems = data.items || [];
                loadingEl?.classList.add('hidden');

                if (data.count === 0) {
                    emptyEl?.classList.remove('hidden');
                    emptyEl?.classList.add('flex');
                } else {
                    itemsEl?.classList.remove('hidden');
                    itemsEl.innerHTML = data.items.map(item => `
                        <li>
                            <a href="${item.url}" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-white/5 transition">
                                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30 text-[#0066FF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">${item.asset_block_name}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">${item.stasiun} · ${item.jenis_asset}</p>
                                    <p class="text-xs text-blue-500 dark:text-blue-400 mt-0.5">${item.created_at}</p>
                                </div>
                            </a>
                        </li>
                    `).join('');
                }
            })
            .catch(() => {
                notifLoaded = true;
                if (loadingEl) {
                    loadingEl.textContent = 'Gagal memuat notifikasi.';
                }
            });
    }

    // Polling otomatis setiap 60 detik — hanya update badge
    function pollNotifications() {
        fetch('{{ route("notifications.new-assets") }}')
            .then(res => res.json())
            .then(data => {
                lastNotifItems = data.items || [];

                const dropdown = document.getElementById('notifDropdown');
                const isOpen = dropdown && !dropdown.classList.contains('invisible');
                if (!isOpen) {
                    updateBadge(lastNotifItems);
                }
                // Reset agar list di-render ulang saat dibuka lagi
                notifLoaded = false;
            })
            .catch(() => {});
    }

    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function (e) {
        const wrapper = document.getElementById('notifWrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            const dropdown = document.getElementById('notifDropdown');
            if (dropdown) {
                dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                dropdown.classList.remove('opacity-100', 'visible', 'scale-100');
            }
        }
    });

    // Fetch awal + polling setiap 60 detik
    pollNotifications();
    setInterval(pollNotifications, 60000);

    // Desktop Profile Dropdown
    const profileButton = document.getElementById('profileButton');
    const profileDropdown = document.getElementById('profileDropdown');
    const profileArrow = document.getElementById('profileArrow');

    if (profileButton && profileDropdown) {
        profileButton.addEventListener('click', function (event) {
            event.stopPropagation();
            const isOpen = !profileDropdown.classList.contains('invisible');

            if (isOpen) {
                profileDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                profileDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                profileArrow?.classList.remove('rotate-180');
            } else {
                profileDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                profileDropdown.classList.add('opacity-100', 'visible', 'scale-100');
                profileArrow?.classList.add('rotate-180');
            }
        });

        document.addEventListener('click', function (event) {
            if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                profileDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                profileArrow?.classList.remove('rotate-180');
            }
        });
    }
</script>

<x-toast />
