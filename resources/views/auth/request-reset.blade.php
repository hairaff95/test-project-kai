<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request Reset Password — KAI Tracker App</title>
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

<body class="min-h-screen bg-white dark:bg-[#1F2123] font-sans antialiased text-gray-900 dark:text-white flex flex-col justify-center items-center px-4 py-12 transition-colors duration-200">

    <div class="w-full max-w-[420px]">

        {{-- Logo --}}
        <div class="text-center mb-8 flex items-center justify-center gap-1.5">
            <x-icon name="kai-logo" class="h-[19px] sm:h-5 lg:h-[24px] w-auto shrink-0" />
            <p class="text-gray-900 dark:text-white font-bold italic text-lg">Tracker<span class="text-[#0066FF] dark:text-[#3B82F6]">App</span></p>
        </div>

        {{-- Heading --}}
        <h1 class="text-3xl font-bold text-gray-950 dark:text-white tracking-tight mb-3">
            Lupa Kata Sandi
        </h1>
        <p class="text-sm text-gray-500 dark:text-[#9AA0A6] mb-8 leading-relaxed">
            Masukkan email akun Anda. Permintaan reset akan dikirimkan ke Super Admin untuk disetujui.
        </p>

        <form action="{{ route('password.request.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Email Input --}}
            <div>
                <label for="email" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                    Email Terdaftar
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <x-icon name="mail" class="w-5 h-5" />
                    </div>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="contoh: admin@kai.id"
                        class="w-full rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-10 pr-4 py-3 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-[#0066FF] focus:outline-none focus:ring-2 focus:ring-[#0066FF]/20 transition"
                    >
                </div>
                @error('email')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Info alur --}}
            <div class="bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800/60 rounded-xl p-4 text-xs text-blue-800 dark:text-blue-200">
                <p class="font-semibold mb-1.5 text-blue-900 dark:text-blue-300 flex items-center gap-1.5">
                    <x-icon name="toast-peringatan" class="w-4 h-4" /> Informasi Proses:
                </p>
                <ol class="list-decimal pl-4 space-y-1 text-blue-700 dark:text-blue-300/90">
                    <li>Masukkan email &mdash; request dikirim ke Super Admin</li>
                    <li>Super Admin menyetujui &mdash; kode OTP dikirim ke email Anda</li>
                    <li>Masukkan OTP &mdash; atur password baru</li>
                    <li>Jika tidak direspon 24 jam &mdash; password sementara otomatis dikirim</li>
                </ol>
            </div>

            <div class="pt-1">
                <button type="submit"
                    class="w-full rounded-xl bg-[#0066FF] hover:bg-blue-700 py-3.5 text-xs sm:text-sm font-semibold text-white transition shadow-sm cursor-pointer">
                    Kirim Request Reset Password
                </button>
            </div>
        </form>

        <div class="mt-5 text-center">
            <a href="{{ route('login') }}" class="text-xs text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white transition">
                &larr; Kembali ke halaman Masuk
            </a>
        </div>

    </div>

    <x-toast />
</body>
</html>
