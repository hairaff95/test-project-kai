<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Verifikasi Kode — KAI Tracker App</title>

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

    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } } }</script>
</head>

<body class="min-h-screen bg-white dark:bg-[#1F2123] font-sans antialiased text-gray-900 dark:text-white selection:bg-blue-100 selection:text-[#0066FF] flex flex-col justify-center items-center px-4 py-12 transition-colors duration-200">

    <div class="w-full max-w-[420px] text-center">

        {{-- Logo --}}
        <div class="text-center mb-8 flex items-center justify-center">
            <x-icon name="kai-logo" class="h-[19px] sm:h-5 lg:h-[24px] w-auto shrink-0" />
            <p class="text-black font-bold italic">Tracker<span class="text-[#0066FF]">App</span></p>
        </div>

        {{-- Error messages --}}
        @if($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm text-left">
                {{ $errors->first() }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm text-left">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm text-left">
                {{ session('success') }}
            </div>
        @endif

        {{-- Heading 'Verifikasi Kode' --}}
        <h1 class="text-3xl sm:text-[36px] font-bold text-gray-950 dark:text-white tracking-tight mb-3">
            Verifikasi Kode
        </h1>

        {{-- Subtitle --}}
        <p class="text-xs sm:text-[13px] text-gray-500 dark:text-[#9AA0A6] font-normal leading-relaxed mb-8">
            Masukan kode 6 digit yang di kirimkan di email admin
        </p>

        {{-- Form Verifikasi Kode --}}
        <form method="POST" action="{{ route('password.verify.post') }}" class="space-y-6" id="otp-form">
            @csrf

            {{-- Hidden input untuk OTP yang dikumpulkan dari 6 kotak --}}
            <input type="hidden" name="otp" id="otp-combined">

            {{-- 6 Digit OTP Inputs --}}
            <div class="flex items-center justify-center gap-2.5 sm:gap-3">
                @for ($i = 1; $i <= 6; $i++)
                    <input
                        type="text"
                        maxlength="1"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        id="otp-{{ $i }}"
                        class="otp-input w-11 h-13 sm:w-13 sm:h-15 text-center text-lg sm:text-xl font-semibold text-gray-900 dark:text-white rounded-[14px] border border-gray-300 dark:border-white/10 bg-white dark:bg-[#282A2C] focus:border-[#0066FF] dark:focus:border-[#3B82F6] focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/40 focus:outline-none transition shadow-2xs"
                        autocomplete="off"
                    >
                @endfor
            </div>

            {{-- Resend Code --}}
            <div class="text-xs text-gray-500 dark:text-[#9AA0A6] font-normal">
                Tidak mendapat kode?
                <form method="POST" action="{{ route('password.resend-otp') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-[#0066FF] dark:text-[#3B82F6] font-medium hover:underline transition cursor-pointer">
                        kirim ulang
                    </button>
                </form>
            </div>

            {{-- Submit Button 'Verifikasi' --}}
            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full rounded-xl bg-[#0066FF] hover:bg-blue-700 py-3.5 text-xs sm:text-sm font-semibold text-white transition shadow-sm hover:shadow active:scale-98 cursor-pointer flex items-center justify-center tracking-wide"
                >
                    Verifikasi
                </button>
            </div>

            {{-- Back to Login Link --}}
            <div class="pt-2">
                <a href="{{ route('login') }}" class="text-xs text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white transition">
                    Kembali ke halaman Masuk
                </a>
            </div>

        </form>

    </div>

    {{-- Script for OTP Inputs Auto Focus & Paste --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.otp-input');
            const combined = document.getElementById('otp-combined');

            function updateCombined() {
                combined.value = Array.from(inputs).map(i => i.value).join('');
            }

            inputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const value = e.target.value;
                    if (value.length >= 1) {
                        e.target.value = value[0];
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    }
                    updateCombined();
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim();
                    if (/^\d+$/.test(pasteData)) {
                        const digits = pasteData.slice(0, inputs.length).split('');
                        digits.forEach((digit, i) => {
                            if (inputs[i]) inputs[i].value = digit;
                        });
                        const nextFocus = Math.min(digits.length, inputs.length - 1);
                        inputs[nextFocus].focus();
                        updateCombined();
                    }
                });
            });

            const firstInput = document.getElementById('otp-1');
            if (firstInput) firstInput.focus();
        });
    </script>

</body>
</html>
