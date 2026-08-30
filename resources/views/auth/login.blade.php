<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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

<body class="min-h-screen bg-white font-sans antialiased text-gray-900 selection:bg-blue-100 selection:text-[#3285FF] overflow-x-hidden">

    {{-- SVG CLIP-PATH DEFINITION FOR EXACT GEOMETRIC BLUE SILHOUETTE --}}
    <svg class="absolute w-0 h-0 pointer-events-none" aria-hidden="true">
        <defs>
            <clipPath id="blue-curve-clip" clipPathUnits="objectBoundingBox">
                <path d="M 0,0 L 0.72,0 C 0.80,0 0.86,0.07 0.86,0.20 L 0.86,0.82 C 0.86,0.93 0.92,1 1,1 L 0,1 Z" />
            </clipPath>
        </defs>
    </svg>

    <div class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-[1.12fr_0.88fr] xl:grid-cols-[1.18fr_0.82fr]">

        {{-- LEFT SIDE: #3285FF BACKGROUND WITH EXACT SILHOUETTE & 2 #5197FF CIRCLES --}}
        <div class="blue-curved-banner relative bg-[#3285FF] text-white p-8 sm:p-12 lg:p-14 lg:pr-24 flex flex-col justify-between overflow-hidden min-h-[520px] lg:min-h-screen">
            
            {{-- 1. LINGKARAN ATAS KANAN: WARNA #5197FF --}}
            <div class="absolute -top-12 right-2 lg:right-12 w-[420px] sm:w-[480px] h-[420px] sm:h-[480px] rounded-full bg-[#5197FF] pointer-events-none"></div>

            {{-- 2. LINGKARAN KIRI BAWAH: WARNA #5197FF --}}
            <div class="absolute -bottom-20 -left-16 w-[400px] sm:w-[450px] h-[400px] sm:h-[450px] rounded-full bg-[#5197FF] pointer-events-none"></div>

            {{-- Top Left: KAI Tracker App Official White Logo (Geser 10px ke kanan) --}}
            <div class="relative z-20 flex items-center select-none translate-x-[10px]">
                <x-icon name="logo-login-page" class="h-9 sm:h-11 w-auto" />
            </div>

            {{-- Center: Exact Security Illustration from public/image/aset-gambar-login-page.svg (Presisi Pas di Tengah Biru) --}}
            <div class="relative z-20 my-auto w-full lg:max-w-[86%] flex items-center justify-center py-6">
                <img
                    src="{{ asset('image/aset-gambar-login-page.svg') }}"
                    alt="KAI Login Illustration"
                    class="w-full max-w-[460px] sm:max-w-[500px] h-auto object-contain select-none pointer-events-none drop-shadow-2xl mx-auto"
                >
            </div>

            {{-- Bottom Footer Text --}}
            <div class="relative z-20 text-xs text-white/70 select-none">
                &copy; {{ date('Y') }} PT Kereta Api Indonesia (Persero). All rights reserved.
            </div>

        </div>


        {{-- RIGHT SIDE: CLEAN WHITE LOGIN FORM --}}
        <div class="flex flex-col justify-center items-center px-6 sm:px-12 lg:px-16 py-12 lg:py-8 bg-white z-20">
            
            <div class="w-full max-w-[380px]">

                {{-- Heading 'Masuk' --}}
                <h1 class="text-3xl sm:text-[34px] font-bold text-gray-950 tracking-tight mb-8">
                    Masuk
                </h1>

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf

                    {{-- 1. Alamat Email --}}
                    <div>
                        <label for="email-input" class="block text-xs font-semibold text-gray-700 mb-2">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                                <x-icon name="icon-email-login" class="w-5 h-5" />
                            </span>
                            <input
                                type="text"
                                name="login"
                                id="email-input"
                                placeholder="masukan alamat email"
                                class="w-full rounded-[10px] border border-gray-300 bg-white py-3 pl-11 pr-4 text-xs sm:text-sm text-gray-800 placeholder:text-gray-400 focus:border-[#3285FF] focus:outline-none transition shadow-2xs"
                            >
                        </div>
                    </div>

                    {{-- 2. Kata Sandi --}}
                    <div>
                        <label for="password-input" class="block text-xs font-semibold text-gray-700 mb-2">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                                <x-icon name="icon-kunci-login" class="w-5 h-5" />
                            </span>
                            <input
                                type="password"
                                name="password"
                                id="password-input"
                                placeholder="* * * * * * * *"
                                class="w-full rounded-[10px] border border-gray-300 bg-white py-3 pl-11 pr-11 text-xs sm:text-sm text-gray-800 placeholder:text-gray-400 focus:border-[#3285FF] focus:outline-none transition shadow-2xs"
                            >
                            <button
                                type="button"
                                onclick="togglePasswordVisibility()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-800 transition cursor-pointer p-1"
                                title="Lihat kata sandi"
                            >
                                <span id="icon-eye-off">
                                    <x-icon name="icon-show-kunci-login" class="w-5 h-5" />
                                </span>
                                <span id="icon-eye-on" class="hidden">
                                    <x-icon name="off-show-kunci-login" class="w-5 h-5" />
                                </span>
                            </button>
                        </div>
                    </div>

                    {{-- Ubah kata sandi link --}}
                    <div class="pt-1">
                        <a href="{{ route('password.verify') }}" class="text-xs text-gray-500 hover:text-[#0066FF] underline transition inline-block cursor-pointer">
                            Ubah kata sandi
                        </a>
                    </div>

                    {{-- 3. Submit Button 'Masuk' --}}
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full rounded-[10px] bg-[#0066FF] hover:bg-blue-700 py-3.5 text-xs sm:text-sm font-semibold text-white transition shadow-sm hover:shadow active:scale-98 cursor-pointer flex items-center justify-center tracking-wide"
                        >
                            Masuk
                        </button>
                    </div>

                </form>

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