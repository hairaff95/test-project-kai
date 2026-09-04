<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Status Permintaan — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Anti-FOUC Auto Theme Script (WIB 17:00 - 07:00 Auto Dark Mode) -->
    <x-theme-script />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } } }</script>
</head>

<body class="min-h-screen bg-white dark:bg-[#1F2123] font-sans antialiased text-gray-900 dark:text-white selection:bg-blue-100 selection:text-[#0066FF] flex flex-col justify-center items-center px-4 py-8 sm:py-12 transition-colors duration-200">

    <div class="w-full max-w-[360px] sm:max-w-[380px]">

        {{-- Illustration Asset Status Permintaan (Centralized Icon & Public Asset) --}}
        <div class="flex justify-center mb-6 sm:mb-8">
            <x-icon name="asset-status-permintaan" class="w-full max-w-[280px] sm:max-w-[320px] h-auto" />
        </div>

        {{-- Heading 'Status Permintaan' --}}
        <h1 class="text-2xl sm:text-[28px] font-bold text-gray-950 dark:text-white tracking-tight mb-2 sm:mb-2.5">
            Status Permintaan
        </h1>

        {{-- Subtitle --}}
        <p class="text-xs sm:text-sm text-gray-500 dark:text-[#9AA0A6] font-normal leading-relaxed mb-6 sm:mb-8">
            Permintaan Anda sedang dalam antrian. Super Admin akan mereview dan menyetujui permintaan ini.
        </p>

        {{-- Action Button: Verifikasi Sekarang --}}
        <div>
            <a href="{{ route('password.verify', array_filter(['email' => request('email')])) }}"
                class="w-full inline-flex items-center justify-center rounded-lg bg-[#0066FF] hover:bg-blue-700 py-3 sm:py-3.5 text-xs sm:text-sm font-semibold text-white transition active:scale-98 cursor-pointer tracking-wide shadow-sm mb-5 sm:mb-6">
                Verifikasi Sekarang
            </a>
        </div>

        {{-- Ajukan Permintaan Ulang Link --}}
        <p class="text-center text-xs text-gray-500 dark:text-[#9AA0A6]">
            Tidak mendapatkan kode? <a href="{{ route('password.request') }}" class="text-[#0066FF] dark:text-[#3B82F6] hover:underline font-medium transition">Ajukan Permintaan ulang</a>
        </p>

    </div>

    {{-- Global Toast Notification --}}
    <x-toast />

    {{-- Auto-polling background script --}}
    <script>
        const pollInterval = setInterval(async () => {
            try {
                const res  = await fetch('{{ route('password.request.poll') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();

                if (data.status === 'approved' && data.redirect_url) {
                    clearInterval(pollInterval);
                    if (window.showToast) {
                        window.showToast('Permintaan disetujui! Mengalihkan ke halaman verifikasi...', 'success', 3000);
                    }
                    setTimeout(() => window.location.href = data.redirect_url, 1200);
                    return;
                }

                if (data.temp_pwd_sent === true) {
                    window.location.reload();
                }
            } catch (e) {
                // Abaikan error jaringan
            }
        }, 10000);
    </script>

</body>
</html>
