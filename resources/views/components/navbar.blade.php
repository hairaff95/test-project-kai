@props(['active' => 'dashboard'])

<!-- ===== TOP NAVIGATION BAR (Sticky, for all screens) ===== -->
<header id="mainNavbar" class="sticky top-0 z-[100] w-full bg-[#F6F7F9]/95 backdrop-blur-md transition-all duration-200 border-b border-transparent">
    <nav class="max-w-[1600px] mx-auto px-3 sm:px-6 lg:px-10 h-11 sm:h-14 lg:h-20 flex items-center justify-between gap-2 sm:gap-3">

        <!-- Logo KAI TrackerApp -->
        <a href="{{ route('welcome') }}" class="flex items-center gap-1 sm:gap-1.5 text-[11px] sm:text-[15px] lg:text-[18px] font-bold italic tracking-tight text-gray-950 shrink-0 transition hover:opacity-90">
            <x-icon name="kai-logo" class="h-[14px] sm:h-5 lg:h-[24px] w-auto shrink-0" />
            <span class="leading-none select-none">Tracker<span class="text-[#0066FF]">App</span></span>
        </a>

        <!-- Menu Navigasi Desktop (lg and above only) -->
        <ul class="hidden lg:flex items-center gap-7 xl:gap-8 text-sm font-medium text-[#4A4A4A]">
            <li>
                <a
                    href="{{ route('welcome') }}"
                    class="inline-block py-2 transition {{ $active === 'dashboard' ? 'rounded-xl bg-[#DCDCDC] px-4 font-semibold text-[#171717] shadow-none' : 'hover:text-[#171717]' }}"
                >
                    Dashboard
                </a>
            </li>
            <li>
                <a
                    href="{{ route('map') }}"
                    class="inline-block py-2 transition {{ $active === 'map' ? 'rounded-xl bg-[#DCDCDC] px-4 font-semibold text-[#171717] shadow-none' : 'hover:text-[#171717]' }}"
                >
                    Peta
                </a>
            </li>
            <li>
                <a
                    href="{{ route('contracts.index') }}"
                    class="inline-block py-2 transition {{ $active === 'contracts' ? 'rounded-xl bg-[#DCDCDC] px-4 font-semibold text-[#171717] shadow-none' : 'hover:text-[#171717]' }}"
                >
                    Daftar Kontrak
                </a>
            </li>
            <li>
                <a
                    href="{{ route('due-dates.index') }}"
                    class="inline-block py-2 transition {{ $active === 'due-dates' ? 'rounded-xl bg-[#DCDCDC] px-4 font-semibold text-[#171717] shadow-none' : 'hover:text-[#171717]' }}"
                >
                    Jatuh Tempo
                </a>
            </li>
            <li>
                <a
                    href="{{ route('backlog.index') }}"
                    class="inline-block py-2 transition {{ in_array($active, ['backlog', 'blacklog']) ? 'rounded-xl bg-[#DCDCDC] px-4 font-semibold text-[#171717] shadow-none' : 'hover:text-[#171717]' }}"
                >
                    Backlog
                </a>
            </li>
            <li>
                <a
                    href="{{ route('laporan.index') }}"
                    class="inline-block py-2 transition {{ $active === 'reports' ? 'rounded-xl bg-[#DCDCDC] px-4 font-semibold text-[#171717] shadow-none' : 'hover:text-[#171717]' }}"
                >
                    Laporan
                </a>
            </li>
        </ul>

        <!-- Profil & Aksi Kanan -->
        <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">

            <!-- Ganti Mode / Theme Toggle (Tampil di Mobile & Desktop) -->
            <button
                type="button"
                id="themeToggleBtn"
                class="flex h-7 w-7 sm:h-9 sm:w-9 lg:h-10 lg:w-10 items-center justify-center rounded-lg lg:rounded-[10px] border border-gray-300/80 bg-transparent text-gray-700 hover:bg-gray-200/70 active:scale-95 transition shadow-none cursor-pointer"
                title="Ganti Mode"
            >
                <x-icon name="moon" class="h-3.5 w-3.5 sm:h-4 sm:w-4 lg:h-[19px] lg:w-[19px] text-[#262626]" />
            </button>

            <!-- Notifikasi Bell (mobile & desktop) -->
            <button
                type="button"
                class="flex h-7 w-7 sm:h-9 sm:w-9 lg:h-10 lg:w-10 items-center justify-center rounded-lg lg:rounded-[10px] border border-gray-300/80 bg-transparent text-gray-700 hover:bg-gray-200/70 active:scale-95 transition shadow-none cursor-pointer"
                title="Notifikasi"
            >
                <x-icon name="notification" class="h-3.5 w-3.5 sm:h-4 sm:w-4 lg:h-[19px] lg:w-[19px] text-[#262626]" />
            </button>

            <!-- Profile -->
            <div class="relative">

                <!-- Profile Button -->
                <button
                    id="profileButton"
                    type="button"
                    class="flex items-center gap-1.5 sm:gap-2 rounded-lg lg:rounded-[10px] hover:opacity-90 transition cursor-pointer"
                >
                    <div class="flex h-7 w-7 sm:h-9 sm:w-9 lg:h-10 lg:w-10 items-center justify-center rounded-lg lg:rounded-[10px] bg-gray-200/80 text-gray-600 shrink-0">
                        <x-icon name="profile-circle" class="w-3.5 h-3.5 sm:w-5 sm:h-5 lg:w-6 lg:h-6" />
                    </div>

                    <div class="hidden sm:block leading-tight text-left pl-0.5">
                        <p class="text-sm font-bold text-[#171717]">
                            Haidar R.
                        </p>

                        <p class="text-xs text-gray-400 font-normal mt-0.5">
                            Admin
                        </p>
                    </div>

                    <!-- Arrow -->
                    <x-icon
                        name="chevron-down"
                        class="hidden sm:block h-4 w-4 text-gray-400 transition-transform duration-200"
                        id="profileArrow"
                    />
                </button>


                <!-- Dropdown -->
                <div
                    id="profileDropdown"
                    class="absolute right-0 top-full mt-1.5 sm:mt-2 w-44 sm:w-52 origin-top-right rounded-lg lg:rounded-[10px] p-1.5 sm:p-2 shadow-[0_12px_36px_rgba(0,0,0,0.12)] opacity-0 invisible scale-95 transition-all duration-200 bg-white border border-gray-100/90 z-[110]"
                >

                    <!-- User Info Mini (Khusus mobile karena di header disembunyikan) -->
                    <div class="sm:hidden px-2.5 py-1.5 mb-1 border-b border-gray-100">
                        <p class="text-xs font-bold text-[#171717] truncate leading-tight">Haidar R.</p>
                        <p class="text-[10px] text-gray-400 font-medium leading-tight mt-0.5">Admin</p>
                    </div>

                    <!-- Pengaturan Akun -->
                    <a
                        href="{{ route('settings.index') }}"
                        class="flex items-center gap-2 sm:gap-2.5 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11.5px] sm:text-xs font-medium text-gray-700 hover:bg-gray-50 active:bg-gray-100 transition"
                    >
                        <x-icon name="setting" class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-gray-500 shrink-0" />
                        <span>Pengaturan Akun</span>
                    </a>

                    <!-- Logout -->
                    <a
                        href="{{ route('logout') }}"
                        class="flex w-full items-center gap-2 sm:gap-2.5 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11.5px] sm:text-xs font-medium text-gray-700 hover:bg-gray-50 active:bg-gray-100 transition cursor-pointer"
                    >
                        <x-icon name="logout" class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-gray-500 shrink-0" />
                        <span>Keluar</span>
                    </a>

                </div>

            </div>
        </div>

    </nav>
</header>

<!-- ===== BOTTOM MOBILE NAVIGATION (floating pill style, hidden on lg+) ===== -->
<div class="lg:hidden fixed bottom-0 inset-x-0 z-50 pointer-events-none select-none px-3 pb-4" style="padding-bottom: max(1rem, env(safe-area-inset-bottom, 1rem));">
    <nav id="mobileBottomNav" class="pointer-events-auto mx-auto bg-white/95 backdrop-blur-xl rounded-[28px] px-2.5 sm:px-3.5 py-1.5 sm:py-2 flex items-center justify-between shadow-[0_8px_40px_rgba(0,0,0,0.12),0_2px_10px_rgba(0,0,0,0.06)] w-full max-w-[430px] border border-gray-200/80 transition-all duration-300">

        <!-- Home / Dashboard -->
        @if($active === 'dashboard')
            <a href="{{ route('welcome') }}" class="mobile-nav-item flex items-center gap-1.5 sm:gap-2 rounded-full bg-[#0066FF] px-3 sm:px-4 py-1.5 sm:py-2 text-[12px] sm:text-[13px] font-semibold text-white shadow-[0_4px_14px_rgba(0,102,255,0.35)]">
                <x-icon name="nav-home" class="h-4 w-4 sm:h-[18px] sm:w-[18px] shrink-0" />
                <span>Home</span>
            </a>
        @else
            <a href="{{ route('welcome') }}" class="mobile-nav-item flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100" title="Dashboard">
                <x-icon name="nav-home" class="h-[19px] w-[19px] sm:h-[20px] sm:w-[20px]" />
            </a>
        @endif

        <!-- Peta / Map -->
        @if($active === 'map')
            <a href="{{ route('map') }}" class="mobile-nav-item flex items-center gap-1.5 sm:gap-2 rounded-full bg-[#0066FF] px-3 sm:px-4 py-1.5 sm:py-2 text-[12px] sm:text-[13px] font-semibold text-white shadow-[0_4px_14px_rgba(0,102,255,0.35)]">
                <x-icon name="nav-map" class="h-4 w-4 sm:h-[18px] sm:w-[18px] shrink-0" />
                <span>Peta</span>
            </a>
        @else
            <a href="{{ route('map') }}" class="mobile-nav-item flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100" title="Peta">
                <x-icon name="nav-map" class="h-[19px] w-[19px] sm:h-[20px] sm:w-[20px]" />
            </a>
        @endif

        <!-- Daftar Kontrak -->
        @if($active === 'contracts')
            <a href="{{ route('contracts.index') }}" class="mobile-nav-item flex items-center gap-1.5 sm:gap-2 rounded-full bg-[#0066FF] px-3 sm:px-4 py-1.5 sm:py-2 text-[12px] sm:text-[13px] font-semibold text-white shadow-[0_4px_14px_rgba(0,102,255,0.35)]">
                <x-icon name="nav-contract" class="h-4 w-4 sm:h-[18px] sm:w-[18px] shrink-0" />
                <span>Kontrak</span>
            </a>
        @else
            <a href="{{ route('contracts.index') }}" class="mobile-nav-item flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100" title="Daftar Kontrak">
                <x-icon name="nav-contract" class="h-[19px] w-[19px] sm:h-[20px] sm:w-[20px]" />
            </a>
        @endif

        <!-- Jatuh Tempo -->
        @if($active === 'due-dates')
            <a href="{{ route('due-dates.index') }}" class="mobile-nav-item flex items-center gap-1.5 sm:gap-2 rounded-full bg-[#0066FF] px-3 sm:px-4 py-1.5 sm:py-2 text-[12px] sm:text-[13px] font-semibold text-white shadow-[0_4px_14px_rgba(0,102,255,0.35)]">
                <x-icon name="nav-card" class="h-4 w-4 sm:h-[18px] sm:w-[18px] shrink-0" />
                <span>Tempo</span>
            </a>
        @else
            <a href="{{ route('due-dates.index') }}" class="mobile-nav-item flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100" title="Jatuh Tempo">
                <x-icon name="nav-card" class="h-[19px] w-[19px] sm:h-[20px] sm:w-[20px]" />
            </a>
        @endif

        <!-- Backlog -->
        @if(in_array($active, ['backlog', 'blacklog']))
            <a href="{{ route('backlog.index') }}" class="mobile-nav-item flex items-center gap-1.5 sm:gap-2 rounded-full bg-[#0066FF] px-3 sm:px-4 py-1.5 sm:py-2 text-[12px] sm:text-[13px] font-semibold text-white shadow-[0_4px_14px_rgba(0,102,255,0.35)]">
                <x-icon name="nav-scan" class="h-4 w-4 sm:h-[18px] sm:w-[18px] shrink-0" />
                <span>Backlog</span>
            </a>
        @else
            <a href="{{ route('backlog.index') }}" class="mobile-nav-item flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100" title="Backlog">
                <x-icon name="nav-scan" class="h-[19px] w-[19px] sm:h-[20px] sm:w-[20px]" />
            </a>
        @endif

        <!-- Laporan -->
        @if(in_array($active, ['reports', 'laporan']))
            <a href="{{ route('laporan.index') }}" class="mobile-nav-item flex items-center gap-1.5 sm:gap-2 rounded-full bg-[#0066FF] px-3 sm:px-4 py-1.5 sm:py-2 text-[12px] sm:text-[13px] font-semibold text-white shadow-[0_4px_14px_rgba(0,102,255,0.35)]">
                <x-icon name="nav-report" class="h-4 w-4 sm:h-[18px] sm:w-[18px] shrink-0" />
                <span>Laporan</span>
            </a>
        @else
            <a href="{{ route('laporan.index') }}" class="mobile-nav-item flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100" title="Laporan">
                <x-icon name="nav-report" class="h-[19px] w-[19px] sm:h-[20px] sm:w-[20px]" />
            </a>
        @endif

    </nav>
</div>


<script>
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (!navbar) return;
        if (window.scrollY > 20) {
            navbar.classList.add('bg-white/95', 'shadow-xs', 'border-gray-100');
            navbar.classList.remove('bg-[#F6F7F9]/95', 'border-transparent');
        } else {
            navbar.classList.remove('bg-white/95', 'shadow-xs', 'border-gray-100');
            navbar.classList.add('bg-[#F6F7F9]/95', 'border-transparent');
        }
    });

    const profileButton = document.getElementById('profileButton');
    const profileDropdown = document.getElementById('profileDropdown');
    const profileArrow = document.getElementById('profileArrow');

    if (profileButton && profileDropdown) {

        profileButton.addEventListener('click', function (event) {
            event.stopPropagation();

            const isOpen = !profileDropdown.classList.contains('invisible');

            if (isOpen) {
                // Tutup
                profileDropdown.classList.add(
                    'opacity-0',
                    'invisible',
                    'scale-95'
                );

                profileDropdown.classList.remove(
                    'opacity-100',
                    'visible',
                    'scale-100'
                );

                profileArrow?.classList.remove('rotate-180');

            } else {
                // Buka
                profileDropdown.classList.remove(
                    'opacity-0',
                    'invisible',
                    'scale-95'
                );

                profileDropdown.classList.add(
                    'opacity-100',
                    'visible',
                    'scale-100'
                );

                profileArrow?.classList.add('rotate-180');
            }
        });


        // Klik di luar dropdown → tutup
        document.addEventListener('click', function (event) {

            if (
                !profileButton.contains(event.target) &&
                !profileDropdown.contains(event.target)
            ) {

                profileDropdown.classList.add(
                    'opacity-0',
                    'invisible',
                    'scale-95'
                );

                profileDropdown.classList.remove(
                    'opacity-100',
                    'visible',
                    'scale-100'
                );

                profileArrow?.classList.remove('rotate-180');
            }

        });

    }
</script>
