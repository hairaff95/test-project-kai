<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Masuk — KAI Tracker App</title>

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

    <style>
        @media (min-width: 1024px) {
            .blue-curved-banner {
                clip-path: url(#blue-curve-clip);
                -webkit-clip-path: url(#blue-curve-clip);
            }
        }
    </style>
</head>

<body class="min-h-[100dvh] h-[100dvh] bg-white dark:bg-[#1F2123] font-sans antialiased text-gray-900 dark:text-white selection:bg-blue-100 selection:text-[#3285FF] overflow-hidden transition-colors duration-200">

    {{-- SVG CLIP-PATH DEFINITION FOR EXACT GEOMETRIC BLUE SILHOUETTE (Desktop) --}}
    <svg class="absolute w-0 h-0 pointer-events-none" aria-hidden="true">
        <defs>
            <clipPath id="blue-curve-clip" clipPathUnits="objectBoundingBox">
                <path d="M 0,0 L 0.72,0 C 0.80,0 0.86,0.07 0.86,0.20 L 0.86,0.82 C 0.86,0.93 0.92,1 1,1 L 0,1 Z" />
            </clipPath>
        </defs>
    </svg>

    <div class="h-full min-h-[100dvh] w-full flex flex-col lg:grid lg:grid-cols-[1.12fr_0.88fr] xl:grid-cols-[1.18fr_0.82fr] overflow-hidden">

        {{-- BLUE BANNER: HERO HEADER DI MOBILE (Gambar Besar & Jelas), FULL CURVED SPLIT-SCREEN DI DESKTOP --}}
        <div class="blue-curved-banner relative bg-[#3285FF] text-white px-5 pt-3.5 pb-2.5 sm:px-8 sm:pt-5 sm:pb-3 lg:p-14 lg:pr-24 flex flex-col justify-between overflow-hidden h-[40dvh] sm:h-[42dvh] lg:h-full shrink-0 rounded-b-[28px] sm:rounded-b-[36px] lg:rounded-none shadow-sm lg:shadow-none z-10">
            
            {{-- Lingkaran Aksen #5197FF --}}
            <div class="absolute -top-10 -right-10 lg:-top-12 lg:right-12 w-40 h-40 sm:w-56 sm:h-56 lg:w-[480px] lg:h-[480px] rounded-full bg-[#5197FF] pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 lg:-bottom-20 lg:-left-16 w-36 h-36 sm:w-48 sm:h-48 lg:w-[450px] lg:h-[450px] rounded-full bg-[#5197FF] pointer-events-none"></div>

            {{-- Top: KAI Tracker App Official White Logo --}}
            <div class="relative z-20 flex items-center select-none lg:translate-x-[10px] shrink-0">
                <x-icon name="logo-login-page" class="h-6 sm:h-7 lg:h-11 w-auto" />
            </div>

            {{-- Center: Security Illustration dari public/image/aset-gambar-login-page.svg (Besar, Jelas & Proporsional) --}}
            <div class="relative z-20 my-auto w-full lg:max-w-[86%] flex items-center justify-center py-1 lg:py-6 overflow-hidden">
                <img
                    src="{{ asset('image/aset-gambar-login-page.svg') }}"
                    alt="KAI Login Illustration"
                    class="h-[140px] sm:h-[175px] lg:h-auto w-auto max-w-[85%] sm:max-w-[340px] lg:max-w-[500px] object-contain select-none pointer-events-none drop-shadow-md lg:drop-shadow-2xl mx-auto transition-transform"
                >
            </div>

            {{-- Bottom Footer Text (Desktop only) --}}
            <div class="hidden lg:block relative z-20 text-xs text-white/70 select-none shrink-0">
                &copy; {{ date('Y') }} PT Kereta Api Indonesia (Persero). All rights reserved.
            </div>

        </div>


        {{-- RIGHT / BOTTOM SIDE: FORM LOGIN (Mobile & Desktop) --}}
        <div class="flex-1 flex flex-col justify-between items-center px-6 sm:px-12 lg:px-16 py-4 sm:py-6 lg:py-8 bg-white dark:bg-[#1F2123] z-20 transition-colors h-full overflow-hidden">
            
            <div class="w-full max-w-[360px] lg:max-w-[380px] my-auto">

                {{-- Heading 'Masuk' --}}
                <h1 class="text-2xl sm:text-[28px] lg:text-[34px] font-bold text-gray-950 dark:text-white tracking-tight mb-3.5 sm:mb-5 lg:mb-8">
                    Masuk
                </h1>

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login.post') }}" class="space-y-3 sm:space-y-4 lg:space-y-5">
                    @csrf

                    {{-- 1. Alamat Email --}}
                    <div>
                        <label for="email-input" class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5 lg:mb-2">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none">
                                <x-icon name="icon-email-login" class="w-4.5 h-4.5 lg:w-5 lg:h-5" />
                            </span>
                            <input
                                type="text"
                                name="login"
                                id="email-input"
                                placeholder="masukan alamat email"
                                class="w-full rounded-[10px] border border-gray-300 dark:border-white/10 bg-white dark:bg-[#282A2C] py-2.5 sm:py-3 pl-10 lg:pl-11 pr-4 text-xs sm:text-sm text-gray-800 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#3285FF] focus:outline-none transition shadow-2xs"
                            >
                        </div>
                    </div>

                    {{-- 2. Kata Sandi --}}
                    <div>
                        <label for="password-input" class="block text-xs font-semibold text-gray-700 dark:text-white mb-1.5 lg:mb-2">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none">
                                <x-icon name="icon-kunci-login" class="w-4.5 h-4.5 lg:w-5 lg:h-5" />
                            </span>
                            <input
                                type="password"
                                name="password"
                                id="password-input"
                                placeholder="* * * * * * * *"
                                class="w-full rounded-[10px] border border-gray-300 dark:border-white/10 bg-white dark:bg-[#282A2C] py-2.5 sm:py-3 pl-10 lg:pl-11 pr-10 lg:pr-11 text-xs sm:text-sm text-gray-800 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#3285FF] focus:outline-none transition shadow-2xs"
                            >
                            <button
                                type="button"
                                onclick="togglePasswordVisibility()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white transition cursor-pointer p-1"
                                title="Lihat kata sandi"
                            >
                                <span id="icon-eye-off">
                                    <x-icon name="icon-show-kunci-login" class="w-4.5 h-4.5 lg:w-5 lg:h-5" />
                                </span>
                                <span id="icon-eye-on" class="hidden">
                                    <x-icon name="off-show-kunci-login" class="w-4.5 h-4.5 lg:w-5 lg:h-5" />
                                </span>
                            </button>
                        </div>
                    </div>

                    {{-- Ubah kata sandi link --}}
                    <div class="pt-0.5">
                        <a href="{{ route('password.verify') }}" class="text-xs text-gray-500 dark:text-[#9AA0A6] hover:text-[#0066FF] dark:hover:text-[#3B82F6] underline transition inline-block cursor-pointer">
                            Ubah kata sandi
                        </a>
                    </div>

                    {{-- 3. Submit Button 'Masuk' --}}
                    <div class="pt-1.5 sm:pt-2">
                        <button
                            type="submit"
                            class="w-full rounded-[10px] bg-[#0066FF] hover:bg-blue-700 py-3 sm:py-3.5 text-xs sm:text-sm font-semibold text-white transition shadow-sm hover:shadow active:scale-98 cursor-pointer flex items-center justify-center tracking-wide"
                        >
                            Masuk
                        </button>
                    </div>

                </form>

            </div>

            {{-- Mobile Bottom Copyright Footer (Hidden on Desktop) --}}
            <div class="lg:hidden text-center text-[10px] text-gray-400 dark:text-[#9AA0A6] pb-1 select-none">
                &copy; {{ date('Y') }} PT Kereta Api Indonesia (Persero). All rights reserved.
            </div>

        </div>

    </div>

    {{-- Script for Password Visibility Toggle --}}
    <script>
        function togglePasswordVisibility() {
            const pwd = document.getElementById('password-input');
            const iconOff = document.getElementById('icon-eye-off');
            const iconOn = document.getElementById('icon-eye-on');

            if (pwd) {
                if (pwd.type === 'password') {
                    pwd.type = 'text';
                    if (iconOff) iconOff.classList.add('hidden');
                    if (iconOn) iconOn.classList.remove('hidden');
                } else {
                    pwd.type = 'password';
                    if (iconOff) iconOff.classList.remove('hidden');
                    if (iconOn) iconOn.classList.add('hidden');
                }
            }
        }
    </script>

</body>
</html>