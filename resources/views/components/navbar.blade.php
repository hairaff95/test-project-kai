@props(['active' => 'dashboard'])

<!-- ===== TOP NAVIGATION BAR (Sticky, for all screens) ===== -->
<header id="mainNavbar" class="sticky top-0 z-[100] w-full bg-[#F6F7F9]/95 dark:bg-[#282A2C]/95 backdrop-blur-md transition-all duration-200 border-b border-transparent">
    <nav class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-10 h-14 sm:h-16 lg:h-20 flex items-center justify-between gap-3">

        <!-- Logo KAI TrackerApp -->
        <a href="{{ route('welcome') }}" class="flex items-center gap-1.5 sm:gap-2 text-[15px] sm:text-[16px] lg:text-[18px] font-bold italic tracking-tight text-gray-950 dark:text-white shrink-0 transition hover:opacity-90">
            <x-icon name="kai-logo" class="h-[19px] sm:h-5 lg:h-[24px] w-auto shrink-0" />
            <span class="leading-none select-none text-gray-950 dark:text-white">Tracker<span class="text-[#0066FF]">App</span></span>
        </a>

        <!-- Menu Navigasi Desktop (lg and above only) -->
        <ul class="hidden lg:flex items-center gap-7 xl:gap-8 text-sm font-medium text-[#4A4A4A] dark:text-[#9AA0A6]">
            <li>
                <a
                    href="{{ route('welcome') }}"
                    class="inline-block py-2 transition {{ $active === 'dashboard' ? 'rounded-xl bg-[#DCDCDC] dark:bg-[#43484E] px-4 font-semibold text-[#171717] dark:text-white shadow-none' : 'hover:text-[#171717] dark:hover:text-white' }}"
                >
                    Dashboard
                </a>
            </li>
            <li>
                <a
                    href="{{ route('map') }}"
                    class="inline-block py-2 transition {{ $active === 'map' ? 'rounded-xl bg-[#DCDCDC] dark:bg-[#43484E] px-4 font-semibold text-[#171717] dark:text-white shadow-none' : 'hover:text-[#171717] dark:hover:text-white' }}"
                >
                    Peta
                </a>
            </li>
            <li>
                <a
                    href="{{ route('contracts.index') }}"
                    class="inline-block py-2 transition {{ $active === 'contracts' ? 'rounded-xl bg-[#DCDCDC] dark:bg-[#43484E] px-4 font-semibold text-[#171717] dark:text-white shadow-none' : 'hover:text-[#171717] dark:hover:text-white' }}"
                >
                    Daftar Kontrak
                </a>
            </li>
            <li>
                <a
                    href="{{ route('due-dates.index') }}"
                    class="inline-block py-2 transition {{ $active === 'due-dates' ? 'rounded-xl bg-[#DCDCDC] dark:bg-[#43484E] px-4 font-semibold text-[#171717] dark:text-white shadow-none' : 'hover:text-[#171717] dark:hover:text-white' }}"
                >
                    Jatuh Tempo
                </a>
            </li>
            <li>
                <a
                    href="{{ route('backlog.index') }}"
                    class="inline-block py-2 transition {{ in_array($active, ['backlog', 'blacklog']) ? 'rounded-xl bg-[#DCDCDC] dark:bg-[#43484E] px-4 font-semibold text-[#171717] dark:text-white shadow-none' : 'hover:text-[#171717] dark:hover:text-white' }}"
                >
                    Backlog
                </a>
            </li>
            <li>
                <a
                    href="{{ route('laporan.index') }}"
                    class="inline-block py-2 transition {{ $active === 'reports' ? 'rounded-xl bg-[#DCDCDC] dark:bg-[#43484E] px-4 font-semibold text-[#171717] dark:text-white shadow-none' : 'hover:text-[#171717] dark:hover:text-white' }}"
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
            <button
                type="button"
                class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-[10px] border border-gray-300/80 dark:border-white/15 bg-transparent text-gray-700 dark:text-white hover:bg-gray-200/70 dark:hover:bg-white/10 active:scale-95 transition shadow-none cursor-pointer"
                title="Notifikasi"
            >
                <x-icon name="notification" class="h-4.5 w-4.5 sm:h-5 sm:w-5 lg:h-[19px] lg:w-[19px] text-[#262626] dark:text-white" />
            </button>

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
                            Haidar R.
                        </p>

                        <p class="text-xs text-gray-400 dark:text-[#9AA0A6] font-normal mt-0.5">
                            Admin
                        </p>
                    </div>

                    <!-- Arrow -->
                    <x-icon
                        name="chevron-down"
                        class="hidden sm:block h-4 w-4 text-gray-400 dark:text-[#9AA0A6] transition-transform duration-200"
                        id="profileArrow"
                    />
                </button>


                <!-- Dropdown Desktop -->
                <div
                    id="profileDropdown"
                    class="absolute right-0 top-full mt-1.5 sm:mt-2 w-44 sm:w-52 origin-top-right rounded-lg lg:rounded-[10px] p-1.5 sm:p-2 shadow-[0_12px_36px_rgba(0,0,0,0.12)] dark:shadow-[0_12px_36px_rgba(0,0,0,0.6)] opacity-0 invisible scale-95 transition-all duration-200 bg-white dark:bg-[#1F2123] border border-gray-100/90 dark:border-white/10 z-[110]"
                >

                    <!-- Pengaturan Akun -->
                    <a
                        href="{{ route('settings.index') }}"
                        class="flex items-center gap-2 sm:gap-2.5 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11.5px] sm:text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 active:bg-gray-100 dark:active:bg-white/10 transition"
                    >
                        <x-icon name="setting" class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-gray-500 dark:text-gray-400 shrink-0" />
                        <span>Pengaturan Akun</span>
                    </a>

                    <!-- Logout -->
                    <a
                        href="{{ route('logout') }}"
                        class="flex w-full items-center gap-2 sm:gap-2.5 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11.5px] sm:text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 active:bg-gray-100 dark:active:bg-white/10 transition cursor-pointer"
                    >
                        <x-icon name="logout" class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-gray-500 dark:text-gray-400 shrink-0" />
                        <span>Keluar</span>
                    </a>

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
        <div class="relative">
            <!-- FAB Action Button -->
            <button
                id="mobileMenuFab"
                type="button"
                onclick="toggleMobileSubMenu()"
                class="flex h-11 w-11 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-[#0066FF] hover:bg-blue-700 active:scale-95 text-white shadow-[0_4px_16px_rgba(0,102,255,0.45)] transition-all duration-200 cursor-pointer {{ in_array($active, ['contracts', 'due-dates', 'backlog', 'blacklog', 'reports', 'laporan']) ? 'ring-3 ring-blue-300 dark:ring-blue-800 shadow-[0_0_20px_rgba(0,102,255,0.6)]' : '' }}"
                title="Kelola Data"
            >
                <span id="fabIconOpen">
                    <x-icon name="nav-add" class="h-5 w-5 sm:h-[22px] sm:w-[22px]" />
                </span>
                <span id="fabIconClose" class="hidden">
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
        <a href="{{ route('settings.index') }}" class="mobile-nav-item flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-full transition {{ in_array($active, ['settings', 'pengaturan', 'admin', 'profile', 'akun']) ? 'bg-blue-50 dark:bg-blue-900/30 text-[#0066FF] dark:text-[#3B82F6]' : 'text-gray-400 dark:text-[#9AA0A6] hover:text-[#171717] dark:hover:text-white hover:bg-gray-100 dark:hover:bg-white/5 active:scale-95' }}" title="Profil & Pengaturan">
            <x-icon name="nav-user" class="h-5 w-5 sm:h-[22px] sm:w-[22px]" />
        </a>

    </nav>
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
            iconClose?.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
            menu.classList.remove('flex');
            backdrop?.classList.add('hidden');
            iconOpen?.classList.remove('hidden');
            iconClose?.classList.add('hidden');
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
        iconClose?.classList.add('hidden');
    }

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
