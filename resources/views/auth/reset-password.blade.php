<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Ubah Kata Sandi Baru — KAI Tracker App</title>

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

    <div class="w-full max-w-[430px]">

        {{-- Heading 'Ubah Kata Sandi Baru' --}}
        <h1 class="text-3xl sm:text-[36px] font-bold text-gray-950 dark:text-white tracking-tight text-center mb-8">
            Ubah Kata Sandi Baru
        </h1>

        {{-- Form Ubah Kata Sandi --}}
        <form method="POST" action="{{ route('password.reset.post') }}" class="space-y-4" id="reset-password-form">
            @csrf

            {{-- 1. Kata Sandi Baru --}}
            <div>
                <label for="new-password" class="block text-xs font-semibold text-gray-700 dark:text-white mb-2">
                    Kata Sandi Baru
                </label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none">
                        <x-icon name="icon-kunci-login" class="w-5 h-5" />
                    </span>
                    <input
                        type="password"
                        name="password"
                        id="new-password"
                        placeholder="* * * * * * * *"
                        class="w-full rounded-[10px] border border-gray-300 dark:border-white/10 bg-white dark:bg-[#282A2C] py-3 pl-11 pr-11 text-xs sm:text-sm text-gray-800 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none transition shadow-2xs"
                        oninput="validatePasswordRules()"
                    >
                    <button
                        type="button"
                        onclick="toggleVisibility('new-password', 'eye-new-off', 'eye-new-on')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white transition cursor-pointer p-1"
                        title="Lihat kata sandi"
                    >
                        <span id="eye-new-off">
                            <x-icon name="icon-show-kunci-login" class="w-5 h-5" />
                        </span>
                        <span id="eye-new-on" class="hidden">
                            <x-icon name="off-show-kunci-login" class="w-5 h-5" />
                        </span>
                    </button>
                </div>
                <p id="password-error-msg" class="hidden text-xs text-red-500 mt-1.5 font-medium">
                    Silakan penuhi semua kriteria untuk membuat kata sandi yang aman.
                </p>
            </div>

            {{-- 2. Konfirmasi Kata Sandi --}}
            <div>
                <label for="confirm-password" class="block text-xs font-semibold text-gray-700 dark:text-white mb-2">
                    Konfirmasi Kata Sandi
                </label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none">
                        <x-icon name="icon-kunci-login" class="w-5 h-5" />
                    </span>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="confirm-password"
                        placeholder="* * * * * * * *"
                        class="w-full rounded-[10px] border border-gray-300 dark:border-white/10 bg-white dark:bg-[#282A2C] py-3 pl-11 pr-11 text-xs sm:text-sm text-gray-800 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none transition shadow-2xs"
                        oninput="validatePasswordRules()"
                    >
                    <button
                        type="button"
                        onclick="toggleVisibility('confirm-password', 'eye-confirm-off', 'eye-confirm-on')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white transition cursor-pointer p-1"
                        title="Lihat kata sandi"
                    >
                        <span id="eye-confirm-off">
                            <x-icon name="icon-show-kunci-login" class="w-5 h-5" />
                        </span>
                        <span id="eye-confirm-on" class="hidden">
                            <x-icon name="off-show-kunci-login" class="w-5 h-5" />
                        </span>
                    </button>
                </div>
                <p id="confirm-error-msg" class="hidden text-xs text-red-500 mt-1.5 font-medium">
                    Konfirmasi kata sandi tidak cocok.
                </p>
            </div>

            {{-- 3. Password Rules --}}
            <div class="pt-2">
                <p class="text-xs sm:text-[13px] text-gray-600 dark:text-gray-300 font-normal mb-2.5">
                    Silakan ikuti aturan untuk membuat kata sandi yang aman.
                </p>
                <ul class="space-y-1.5 text-xs text-gray-500 dark:text-[#9AA0A6] font-normal" id="rules-list">
                    <li id="rule-length" class="flex items-center gap-2 transition-colors">
                        <span class="rule-dot w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0"></span>
                        <span class="rule-text">Minimal 8 karakter</span>
                    </li>
                    <li id="rule-number" class="flex items-center gap-2 transition-colors">
                        <span class="rule-dot w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0"></span>
                        <span class="rule-text">Memiliki minimal satu angka</span>
                    </li>
                    <li id="rule-capital" class="flex items-center gap-2 transition-colors">
                        <span class="rule-dot w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0"></span>
                        <span class="rule-text">Memiliki minimal satu huruf kapital</span>
                    </li>
                    <li id="rule-special" class="flex items-center gap-2 transition-colors">
                        <span class="rule-dot w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0"></span>
                        <span class="rule-text">Memiliki minimal satu spesial karakter</span>
                    </li>
                </ul>
            </div>

            {{-- 4. Submit --}}
            <div class="pt-4">
                <button type="submit"
                    class="w-full rounded-xl bg-[#0066FF] hover:bg-blue-700 py-3.5 text-xs sm:text-sm font-semibold text-white transition shadow-sm hover:shadow active:scale-98 cursor-pointer flex items-center justify-center tracking-wide">
                    Ubah Kata Sandi
                </button>
            </div>

            <div class="pt-1 text-center">
                <a href="{{ route('login') }}" class="text-xs text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white transition">
                    &larr; Kembali ke halaman Masuk
                </a>
            </div>

        </form>

    </div>

    <script>
        function toggleVisibility(inputId, offId, onId) {
            const input = document.getElementById(inputId);
            const off = document.getElementById(offId);
            const on = document.getElementById(onId);
            if (input) {
                input.type = input.type === 'password' ? 'text' : 'password';
                off?.classList.toggle('hidden');
                on?.classList.toggle('hidden');
            }
        }

        function validatePasswordRules() {
            const val = document.getElementById('new-password').value;
            const confirmVal = document.getElementById('confirm-password').value;

            const hasLength = val.length >= 8;
            const hasNumber = /\d/.test(val);
            const hasCapital = /[A-Z]/.test(val);
            const hasSpecial = /[^A-Za-z0-9]/.test(val);

            updateRuleItem('rule-length', hasLength, val.length > 0);
            updateRuleItem('rule-number', hasNumber, val.length > 0);
            updateRuleItem('rule-capital', hasCapital, val.length > 0);
            updateRuleItem('rule-special', hasSpecial, val.length > 0);

            const allValid = hasLength && hasNumber && hasCapital && hasSpecial;
            const errorMsg = document.getElementById('password-error-msg');
            const confirmErrorMsg = document.getElementById('confirm-error-msg');

            if (val.length > 0 && !allValid) {
                errorMsg?.classList.remove('hidden');
            } else {
                errorMsg?.classList.add('hidden');
            }

            if (confirmVal.length > 0 && confirmVal !== val) {
                confirmErrorMsg?.classList.remove('hidden');
            } else {
                confirmErrorMsg?.classList.add('hidden');
            }
        }

        function updateRuleItem(elementId, isValid, isDirty) {
            const el = document.getElementById(elementId);
            if (!el) return;
            const dot = el.querySelector('.rule-dot');

            if (isValid) {
                el.className = "flex items-center gap-2 text-xs text-green-600 font-medium transition-colors";
                if (dot) dot.className = "rule-dot w-1.5 h-1.5 rounded-full bg-green-500 shrink-0";
            } else if (isDirty) {
                el.className = "flex items-center gap-2 text-xs text-red-500 font-normal transition-colors";
                if (dot) dot.className = "rule-dot w-1.5 h-1.5 rounded-full bg-red-500 shrink-0";
            } else {
                el.className = "flex items-center gap-2 text-xs text-gray-500 font-normal transition-colors";
                if (dot) dot.className = "rule-dot w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0";
            }
        }
    </script>

</body>
</html>
