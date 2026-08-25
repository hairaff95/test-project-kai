@props(['active' => 'dashboard'])

<header id="mainNavbar" class="sticky top-0 z-40 w-full bg-[#F6F7F9]/90 backdrop-blur-md transition-all duration-200 border-b border-transparent">
    <nav class="max-w-[1600px] mx-auto px-5 sm:px-8 lg:px-10 h-20 flex items-center justify-between gap-6">

        <!-- Logo KAI TrackerApp -->
        <a href="{{ route('welcome') }}" class="flex items-center whitespace-nowrap text-[16px] sm:text-[17px] font-bold italic tracking-tight text-gray-950 shrink-0 transition hover:opacity-90">
            <x-icon name="kai-logo" class="h-6 sm:h-[26px] w-auto -skew-x-12 mr-1.5" />
            Tracker<span class="text-[#0066FF]">App</span>
        </a>

        <!-- Menu Navigasi -->
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
                    href="#"
                    class="inline-block py-2 transition {{ $active === 'contracts' ? 'rounded-xl bg-[#DCDCDC] px-4 font-semibold text-[#171717] shadow-none' : 'hover:text-[#171717]' }}"
                >
                    Daftar Kontrak
                </a>
            </li>
            <li>
                <a
                    href="#"
                    class="inline-block py-2 transition {{ $active === 'due-dates' ? 'rounded-xl bg-[#DCDCDC] px-4 font-semibold text-[#171717] shadow-none' : 'hover:text-[#171717]' }}"
                >
                    Jatuh Tempo
                </a>
            </li>
            <li>
                <a
                    href="#"
                    class="inline-block py-2 transition {{ $active === 'blacklog' ? 'rounded-xl bg-[#DCDCDC] px-4 font-semibold text-[#171717] shadow-none' : 'hover:text-[#171717]' }}"
                >
                    Blacklog
                </a>
            </li>
            <li>
                <a
                    href="#"
                    class="inline-block py-2 transition {{ $active === 'reports' ? 'rounded-xl bg-[#DCDCDC] px-4 font-semibold text-[#171717] shadow-none' : 'hover:text-[#171717]' }}"
                >
                    Laporan
                </a>
            </li>
        </ul>

        <!-- Profil & Aksi Kanan -->
        <div class="flex items-center gap-[3px] shrink-0">
            <button type="button" class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-300/80 bg-transparent text-gray-700 hover:bg-gray-200/70 transition shadow-none cursor-pointer" title="Toggle Theme">
                <x-icon name="moon" class="h-[19px] w-[19px] text-[#262626]" />
            </button>

            <button type="button" class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-300/80 bg-transparent text-gray-700 hover:bg-gray-200/70 transition shadow-none cursor-pointer" title="Notifikasi">
                <x-icon name="notification" class="h-[19px] w-[19px] text-[#262626]" />
            </button>

            <div class="flex items-center gap-2 pl-0.5">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-200/80 text-gray-600 shrink-0">
                    <x-icon name="profile-circle" class="h-6 w-6" />
                </div>
                
                <div class="hidden sm:block leading-tight text-left pl-0.5">
                    <p class="text-sm font-bold text-[#171717]">
                        Haidar R.
                    </p>
                    <p class="text-xs text-gray-400 font-normal mt-0.5">
                        Admin
                    </p>
                </div>
            </div>
        </div>

    </nav>
</header>

<script>
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (!navbar) return;
        if (window.scrollY > 20) {
            navbar.classList.add('bg-white/95', 'shadow-xs', 'border-gray-100');
            navbar.classList.remove('bg-[#F6F7F9]/90', 'border-transparent');
        } else {
            navbar.classList.remove('bg-white/95', 'shadow-xs', 'border-gray-100');
            navbar.classList.add('bg-[#F6F7F9]/90', 'border-transparent');
        }
    });
</script>
