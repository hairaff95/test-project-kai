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
<div id="mobileMenuBackdrop" class="hidden lg:hidden fixed inset-0 z-[110] bg-black/25 backdrop-blur-[2px] transition-opacity duration-200" onclick="closeMobileSubMenu()"></div>

<!-- ===== BOTTOM MOBILE NAVIGATION (Sleek Floating Bar, hidden on lg+) ===== -->
<div class="lg:hidden fixed bottom-0 inset-x-0 z-[120] pointer-events-none select-none px-4 pb-4" style="padding-bottom: max(1rem, env(safe-area-inset-bottom, 1rem));">
    <nav id="mobileBottomNav" class="pointer-events-auto relative mx-auto bg-white/95 dark:bg-[#1F2123]/95 backdrop-blur-xl rounded-[32px] px-3.5 sm:px-5 py-2 flex items-center justify-between shadow-[0_8px_40px_rgba(0,0,0,0.12),0_2px_10px_rgba(0,0,0,0.06)] dark:shadow-[0_8px_40px_rgba(0,0,0,0.6)] w-full max-w-[340px] sm:max-w-[360px] border border-gray-200/80 dark:border-white/10 transition-all duration-300">

        <!-- 1. Home / Dashboard (Kiri) -->
        <a href="{{ route('welcome') }}" class="mobile-nav-item flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-full transition {{ in_array($active, ['dashboard', 'home', 'welcome']) ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-400 dark:text-[#9AA0A6] hover:text-[#171717] dark:hover:text-white hover:bg-gray-100 dark:hover:bg-white/5 active:scale-95' }}" title="Dashboard">
            <x-icon name="nav-home" class="h-5 w-5 sm:h-[22px] sm:w-[22px]" />
        </a>

        <!-- 2. Peta / Map -->
        <a href="{{ route('map') }}" class="mobile-nav-item flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-full transition {{ in_array($active, ['map', 'peta', 'asset']) ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-400 dark:text-[#9AA0A6] hover:text-[#171717] dark:hover:text-white hover:bg-gray-100 dark:hover:bg-white/5 active:scale-95' }}" title="Peta">
            <x-icon name="nav-map" class="h-5 w-5 sm:h-[22px] sm:w-[22px]" />
        </a>

        <!-- 3. Tengah: FAB Menu (Daftar Kontrak, Jatuh Tempo, Backlog, Laporan) -->
        <div class="relative flex items-center justify-center">
            <!-- FAB Action Button -->
            <button
                id="mobileMenuFab"
                type="button"
                onclick="toggleMobileSubMenu()"
                class="flex h-11 w-11 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-full bg-[#0066FF] hover:bg-blue-700 active:scale-95 text-white p-0 shadow-[0_4px_16px_rgba(0,102,255,0.45)] transition-all duration-200 cursor-pointer {{ in_array($active, ['contracts', 'due-dates', 'backlog', 'blacklog', 'reports', 'laporan']) ? 'ring-3 ring-blue-300 dark:ring-blue-800 shadow-[0_0_20px_rgba(0,102,255,0.6)]' : '' }}"
                title="Kelola Data"
            >
                <span id="fabIconOpen" class="flex items-center justify-center w-full h-full pointer-events-none">
                    <x-icon name="nav-add" class="h-5 w-5 sm:h-[22px] sm:w-[22px]" />
                </span>
                <span id="fabIconClose" class="hidden items-center justify-center w-full h-full pointer-events-none">
                    <x-icon name="x-mark" class="h-5 w-5 sm:h-[22px] sm:w-[22px]" />
                </span>
            </button>

            <!-- Popup Menu Modal Melayang (Persis Gambar 2) -->
            <div
                id="mobileSubMenu"
                class="hidden absolute bottom-full mb-3.5 left-1/2 -translate-x-1/2 min-w-[215px] sm:min-w-[230px] rounded-[24px] bg-[#0066FF] text-white p-2 sm:p-2.5 shadow-[0_16px_40px_rgba(0,102,255,0.55)] flex-col gap-1 z-[120]"
            >
                <!-- 1. Daftar Kontrak -->
                <a
                    href="{{ route('contracts.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-[16px] text-xs sm:text-sm font-semibold transition {{ $active === 'contracts' ? 'bg-white/25 text-white shadow-xs' : 'text-white/90 hover:bg-white/15 active:bg-white/20' }}"
                >
                    <x-icon name="nav-contract" class="w-5 h-5 text-white shrink-0" />
                    <span>Daftar Kontrak</span>
                </a>

                <!-- 2. Jatuh Tempo -->
                <a
                    href="{{ route('due-dates.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-[16px] text-xs sm:text-sm font-semibold transition {{ $active === 'due-dates' ? 'bg-white/25 text-white shadow-xs' : 'text-white/90 hover:bg-white/15 active:bg-white/20' }}"
                >
                    <x-icon name="nav-card" class="w-5 h-5 text-white shrink-0" />
                    <span>Jatuh Tempo</span>
                </a>

                <!-- 3. Backlog -->
                <a
                    href="{{ route('backlog.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-[16px] text-xs sm:text-sm font-semibold transition {{ in_array($active, ['backlog', 'blacklog']) ? 'bg-white/25 text-white shadow-xs' : 'text-white/90 hover:bg-white/15 active:bg-white/20' }}"
                >
                    <x-icon name="nav-scan" class="w-5 h-5 text-white shrink-0" />
                    <span>Backlog</span>
                </a>

                <!-- 4. Laporan -->
                <a
                    href="{{ route('laporan.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-[16px] text-xs sm:text-sm font-semibold transition {{ in_array($active, ['reports', 'laporan']) ? 'bg-white/25 text-white shadow-xs' : 'text-white/90 hover:bg-white/15 active:bg-white/20' }}"
                >
                    <x-icon name="nav-report" class="w-5 h-5 text-white shrink-0" />
                    <span>Laporan</span>
                </a>
            </div>
        </div>

        <!-- 4. Profil / Pengaturan (Kanan) -->
        <button
            type="button"
            onclick="toggleMobileProfileSheet()"
            class="mobile-nav-item flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-full transition {{ in_array($active, ['settings', 'pengaturan', 'admin', 'profile', 'akun']) ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-400 dark:text-[#9AA0A6] hover:text-[#171717] dark:hover:text-white hover:bg-gray-100 dark:hover:bg-white/5 active:scale-95' }}"
            title="Profil & Pengaturan"
        >
            <x-icon name="nav-user" class="h-5 w-5 sm:h-[22px] sm:w-[22px]" />
        </button>

    </nav>
</div>


<!-- ===== MOBILE PROFILE SHEET (hidden on lg+) ===== -->
<div id="mobileProfileBackdrop" class="hidden lg:hidden fixed inset-0 z-[130] bg-black/30 backdrop-blur-[2px]" onclick="closeMobileProfileSheet()"></div>
<div
    id="mobileProfileSheet"
    class="hidden lg:hidden fixed bottom-0 inset-x-0 z-[140] px-4 pb-6 transition-all duration-200"
    style="padding-bottom: max(1.5rem, env(safe-area-inset-bottom, 1.5rem));"
>
    <div class="mx-auto max-w-[400px] rounded-[24px] bg-white dark:bg-[#1F2123] border border-gray-100 dark:border-white/10 shadow-[0_-8px_40px_rgba(0,0,0,0.15)] dark:shadow-[0_-8px_40px_rgba(0,0,0,0.6)] p-3 flex flex-col gap-1">

        <!-- Info Profil -->
        <div class="flex items-center gap-3 px-3 py-2.5 mb-1 border-b border-gray-100 dark:border-white/10">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 dark:bg-[#43484E] text-gray-600 dark:text-white shrink-0">
                <x-icon name="profile-circle" class="w-6 h-6" />
            </div>
            <div class="leading-tight">
                <p class="text-sm font-bold text-[#171717] dark:text-white">
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
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-xl transition whitespace-nowrap"
                >
                    <x-icon name="setting" class="w-5 h-5 text-gray-500 dark:text-gray-300 shrink-0" />
                    <span class="whitespace-nowrap">Panel Super Admin</span>
                </a>
            @else
                <a
                    href="{{ route('settings.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-xl transition whitespace-nowrap"
                >
                    <x-icon name="setting" class="w-5 h-5 text-gray-500 dark:text-gray-300 shrink-0" />
                    <span class="whitespace-nowrap">Pengaturan Akun</span>
                </a>
            @endif

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="flex w-full items-center gap-3 px-3 py-2.5 text-sm font-semibold text-[#EF4444] hover:bg-red-50 dark:hover:bg-red-950/30 rounded-xl transition cursor-pointer whitespace-nowrap"
                >
                    <x-icon name="logout" class="w-5 h-5 text-[#EF4444] shrink-0" />
                    <span class="whitespace-nowrap">Keluar</span>
                </button>
            </form>
        @else
            <a
                href="{{ route('settings.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-xl transition whitespace-nowrap"
            >
                <x-icon name="setting" class="w-5 h-5 text-gray-500 dark:text-gray-300 shrink-0" />
                <span class="whitespace-nowrap">Pengaturan Akun</span>
            </a>
            <a
                href="{{ route('login') }}"
                class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-[#0066FF] dark:text-[#3B82F6] hover:bg-blue-50 dark:hover:bg-blue-950/30 rounded-xl transition whitespace-nowrap"
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

    // Mobile FAB Submenu Toggle Functions
    function toggleMobileSubMenu() {
        const menu = document.getElementById('mobileSubMenu');
        const backdrop = document.getElementById('mobileMenuBackdrop');
        const iconOpen = document.getElementById('fabIconOpen');
        const iconClose = document.getElementById('fabIconClose');
        if (!menu) return;

        const isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            menu.classList.remove('hidden');
            menu.classList.add('flex');
            backdrop?.classList.remove('hidden');
            iconOpen?.classList.add('hidden');
            iconOpen?.classList.remove('flex');
            iconClose?.classList.remove('hidden');
            iconClose?.classList.add('flex');
        } else {
            menu.classList.add('hidden');
            menu.classList.remove('flex');
            backdrop?.classList.add('hidden');
            iconOpen?.classList.remove('hidden');
            iconOpen?.classList.add('flex');
            iconClose?.classList.add('hidden');
            iconClose?.classList.remove('flex');
        }
    }

    function closeMobileSubMenu() {
        const menu = document.getElementById('mobileSubMenu');
        const backdrop = document.getElementById('mobileMenuBackdrop');
        const iconOpen = document.getElementById('fabIconOpen');
        const iconClose = document.getElementById('fabIconClose');
        if (!menu) return;

        menu.classList.add('hidden');
        menu.classList.remove('flex');
        backdrop?.classList.add('hidden');
        iconOpen?.classList.remove('hidden');
        iconOpen?.classList.add('flex');
        iconClose?.classList.add('hidden');
        iconClose?.classList.remove('flex');
    }

    // Mobile Profile Sheet
    function toggleMobileProfileSheet() {
        const sheet = document.getElementById('mobileProfileSheet');
        const backdrop = document.getElementById('mobileProfileBackdrop');
        if (!sheet) return;
        const isHidden = sheet.classList.contains('hidden');
        if (isHidden) {
            sheet.classList.remove('hidden');
            backdrop?.classList.remove('hidden');
            // Tutup FAB submenu jika terbuka
            closeMobileSubMenu();
        } else {
            closeMobileProfileSheet();
        }
    }

    function closeMobileProfileSheet() {
        document.getElementById('mobileProfileSheet')?.classList.add('hidden');
        document.getElementById('mobileProfileBackdrop')?.classList.add('hidden');
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
