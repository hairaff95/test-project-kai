@props(['active' => 'dashboard'])

<!-- Top Navigation Bar -->
<header id="mainNavbar" class="sticky top-0 z-40 w-full bg-[#F6F7F9]/95 backdrop-blur-md transition-all duration-200 border-b border-transparent">
    <nav class="max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 h-16 sm:h-20 flex items-center justify-between gap-3">

        <!-- Logo KAI TrackerApp -->
        <a href="{{ route('welcome') }}" class="flex items-center gap-1.5 text-[17px] sm:text-[18px] font-bold italic tracking-tight text-gray-950 shrink-0 transition hover:opacity-90">
            <x-icon name="kai-logo" class="h-6 sm:h-[26px] w-auto shrink-0" />
            <span class="leading-none select-none">Tracker<span class="text-[#0066FF]">App</span></span>
        </a>

        <!-- Menu Navigasi Desktop -->
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
        <div class="flex items-center gap-1 sm:gap-1.5 shrink-0">
            <button type="button" class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-xl border border-gray-300/80 bg-transparent text-gray-700 hover:bg-gray-200/70 transition shadow-none cursor-pointer" title="Toggle Theme">
                <x-icon name="moon" class="h-[18px] w-[18px] sm:h-[19px] sm:w-[19px] text-[#262626]" />
            </button>

            <button type="button" class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-xl border border-gray-300/80 bg-transparent text-gray-700 hover:bg-gray-200/70 transition shadow-none cursor-pointer" title="Notifikasi">
                <x-icon name="notification" class="h-[18px] w-[18px] sm:h-[19px] sm:w-[19px] text-[#262626]" />
            </button>

            <div class="flex items-center gap-2 pl-0.5">
                <div class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-xl bg-gray-200/80 text-gray-600 shrink-0">
                    <x-icon name="profile-circle" class="h-5 w-5 sm:h-6 sm:w-6" />
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

<!-- Bottom Mobile Navigation Bar Sesuai Desain -->
<div class="lg:hidden fixed bottom-0 inset-x-0 z-50 pointer-events-none select-none">
    <nav class="pointer-events-auto bg-[#1E2228] rounded-t-[28px] sm:rounded-t-[32px] px-6 sm:px-10 pt-3 pb-6 flex items-center justify-between shadow-[0_-8px_30px_rgba(0,0,0,0.35)] w-full max-w-[480px] mx-auto">
        
        <!-- Home / Dashboard (Active Blue Pill) -->
        @if($active === 'dashboard')
            <a href="{{ route('welcome') }}" class="flex items-center gap-2 rounded-full bg-[#0066FF] px-5 py-2.5 text-sm font-medium text-white shadow-md transition">
                <x-icon name="nav-home" class="h-4.5 w-4.5" />
                <span>Home</span>
            </a>
        @else
            <a href="{{ route('welcome') }}" class="flex h-10 w-10 items-center justify-center rounded-full text-white/70 hover:text-white transition" title="Dashboard">
                <x-icon name="nav-home" class="h-5 w-5" />
            </a>
        @endif

        <!-- Daftar Kontrak (Receipt Icon) -->
        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full {{ $active === 'contracts' ? 'text-white bg-[#0066FF]' : 'text-white/70 hover:text-white' }} transition" title="Daftar Kontrak">
            <x-icon name="nav-contract" class="h-5 w-5" />
        </a>

        <!-- Blacklog (Scan Icon) -->
        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full {{ $active === 'blacklog' ? 'text-white bg-[#0066FF]' : 'text-white/70 hover:text-white' }} transition" title="Blacklog">
            <x-icon name="nav-scan" class="h-5 w-5" />
        </a>

        <!-- Jatuh Tempo (Card Icon) -->
        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full {{ $active === 'due-dates' ? 'text-white bg-[#0066FF]' : 'text-white/70 hover:text-white' }} transition" title="Jatuh Tempo">
            <x-icon name="nav-card" class="h-5 w-5" />
        </a>

        <!-- Profil / User Icon -->
        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full {{ $active === 'reports' ? 'text-white bg-[#0066FF]' : 'text-white/70 hover:text-white' }} transition" title="Profil">
            <x-icon name="nav-user" class="h-5 w-5" />
        </a>

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
</script>
