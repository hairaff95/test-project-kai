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

    <div class="w-full max-w-[360px] sm:max-w-[400px]">

        {{-- Illustration --}}
        <div class="flex justify-center mb-6 sm:mb-8">
            <x-icon name="asset-status-permintaan" class="w-full max-w-[280px] sm:max-w-[320px] h-auto" />
        </div>

        {{-- Heading --}}
        <h1 class="text-2xl sm:text-[28px] font-bold text-gray-950 dark:text-white tracking-tight mb-2 sm:mb-2.5">
            Status Permintaan
        </h1>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mb-4 flex items-start gap-2.5 bg-green-50 dark:bg-green-950/40 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-xl text-xs sm:text-sm">
                <span class="mt-0.5">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 flex items-start gap-2.5 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-xl text-xs sm:text-sm">
                <span class="mt-0.5">❌</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($resetRequest)

            {{-- ── STATUS: PENDING ─────────────────────────────────────────── --}}
            @if($resetRequest->status === 'pending')
                @php
                    $isBlocked      = $resetRequest->isBlocked();
                    $remaining      = $resetRequest->remainingRequests();
                    $maxReq         = \App\Models\PasswordResetRequest::MAX_REQUESTS_PER_CYCLE;
                    $currentReq     = $resetRequest->request_count;
                    $tempSent       = $resetRequest->temp_password_sent_at !== null;
                    $waitingForTemp = !$tempSent && $resetRequest->created_at->diffInSeconds(now()) < \App\Models\PasswordResetRequest::TEMP_PASSWORD_DELAY_SECONDS;
                @endphp

                {{-- Subtitle dinamis --}}
                <p class="text-xs sm:text-sm text-gray-500 dark:text-[#9AA0A6] font-normal leading-relaxed mb-5 sm:mb-6">
                    @if($isBlocked)
                        Anda telah mencapai batas maksimal request. Tunggu Super Admin memproses request terakhir Anda.
                    @elseif($tempSent && $resetRequest->isTempPasswordValid())
                        ✅ Password sementara telah dikirim ke email Anda — berlaku <strong>2 menit</strong> sejak pengiriman.
                    @elseif($canRequestNew)
                        Password sementara sudah kedaluwarsa. Ajukan request baru untuk mendapatkan password baru.
                    @else
                        Permintaan Anda sedang dalam antrian. Super Admin akan mereview dan menyetujui permintaan ini.
                    @endif
                </p>

                {{-- Countdown timer (hanya tampil jika masih menunggu temp password) --}}
                @if($waitingForTemp && !$isBlocked)
                    <div id="countdown-box" class="flex items-center justify-between bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800/50 rounded-xl px-4 py-3 mb-4">
                        <p class="text-xs text-blue-600 dark:text-blue-300">Password sementara dikirim dalam:</p>
                        <p id="countdown-timer" class="text-lg font-bold text-[#0066FF] dark:text-[#3B82F6] font-mono">--:--</p>
                    </div>
                @elseif(!$tempSent && !$isBlocked && !$waitingForTemp)
                    <div class="bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800/50 rounded-xl px-4 py-3 mb-4 text-center">
                        <p class="text-xs text-blue-600 dark:text-blue-300">🔄 Mengirim password sementara ke email Anda...</p>
                    </div>
                @endif

                {{-- Tombol aksi --}}
                @if($isBlocked)
                    <button disabled
                        class="w-full inline-flex items-center justify-center rounded-lg bg-gray-300 dark:bg-gray-700 py-3 sm:py-3.5 text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400 cursor-not-allowed tracking-wide mb-5 sm:mb-6">
                        🚫 Menunggu Super Admin
                    </button>
                @else
                    <a href="{{ route('password.verify', array_filter(['email' => request('email')])) }}"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-[#0066FF] hover:bg-blue-700 py-3 sm:py-3.5 text-xs sm:text-sm font-semibold text-white transition active:scale-98 cursor-pointer tracking-wide shadow-sm mb-5 sm:mb-6">
                        Verifikasi Sekarang
                    </a>
                @endif

            {{-- ── STATUS: APPROVED ────────────────────────────────────────── --}}
            @elseif($resetRequest->status === 'approved')

                <p class="text-xs sm:text-sm text-gray-500 dark:text-[#9AA0A6] font-normal leading-relaxed mb-5 sm:mb-6">
                    ✅ Request Anda telah disetujui. Kode OTP telah dikirim ke email Anda.
                    @if($resetRequest->otp_expires_at)
                        Berlaku hingga <strong>{{ $resetRequest->otp_expires_at->format('H:i') }} WIB</strong>.
                    @endif
                </p>

                {{-- Tampilkan OTP langsung --}}
                @if($resetRequest->otp_code)
                    <div class="bg-white dark:bg-[#282A2C] border-2 border-[#0066FF] dark:border-[#3B82F6] rounded-2xl p-5 mb-5 text-center">
                        <p class="text-xs font-semibold text-gray-500 dark:text-[#9AA0A6] uppercase tracking-wider mb-3">Kode OTP Anda</p>
                        <div class="flex items-center justify-center gap-2 mb-2">
                            @foreach(str_split($resetRequest->otp_code) as $digit)
                                <div class="w-10 h-12 flex items-center justify-center rounded-xl border-2 border-[#0066FF] dark:border-[#3B82F6] bg-blue-50 dark:bg-blue-950/30 text-xl font-bold text-[#0066FF] dark:text-[#3B82F6]">
                                    {{ $digit }}
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 dark:text-[#9AA0A6]">Jangan bagikan kode ini ke siapapun.</p>
                    </div>
                @endif

                <a href="{{ route('password.verify') }}"
                    class="w-full inline-flex items-center justify-center rounded-lg bg-[#0066FF] hover:bg-blue-700 py-3 sm:py-3.5 text-xs sm:text-sm font-semibold text-white transition active:scale-98 cursor-pointer tracking-wide shadow-sm mb-5 sm:mb-6">
                    Masukkan Kode OTP →
                </a>

            {{-- ── STATUS: LAINNYA (rejected, completed, auto_reset) ────────── --}}
            @else

                @if($resetRequest->status === 'rejected')
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-[#9AA0A6] font-normal leading-relaxed mb-5 sm:mb-6">
                        ❌ Request reset password Anda ditolak oleh Super Admin. Silakan hubungi Super Admin untuk informasi lebih lanjut.
                    </p>
                @elseif($resetRequest->status === 'completed')
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-[#9AA0A6] font-normal leading-relaxed mb-5 sm:mb-6">
                        🎉 Proses reset password telah selesai. Silakan login dengan password baru Anda.
                    </p>
                @elseif($resetRequest->status === 'auto_reset')
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-[#9AA0A6] font-normal leading-relaxed mb-5 sm:mb-6">
                        🔄 Sistem telah mengirimkan password sementara ke email Anda karena Super Admin belum merespons dalam 1 menit. Password berlaku 2 menit.
                    </p>
                @endif

                <a href="{{ route('login') }}"
                    class="w-full inline-flex items-center justify-center rounded-lg bg-[#0066FF] hover:bg-blue-700 py-3 sm:py-3.5 text-xs sm:text-sm font-semibold text-white transition active:scale-98 cursor-pointer tracking-wide shadow-sm mb-5 sm:mb-6">
                    Kembali ke Halaman Masuk
                </a>

            @endif

        @else
            {{-- Tidak ada request aktif --}}
            <p class="text-xs sm:text-sm text-gray-500 dark:text-[#9AA0A6] font-normal leading-relaxed mb-5 sm:mb-6">
                📭 Anda belum memiliki request reset password yang sedang diproses.
            </p>
            <a href="{{ route('password.request') }}"
                class="w-full inline-flex items-center justify-center rounded-lg bg-[#0066FF] hover:bg-blue-700 py-3 sm:py-3.5 text-xs sm:text-sm font-semibold text-white transition active:scale-98 cursor-pointer tracking-wide shadow-sm mb-5 sm:mb-6">
                Buat Request Reset Password
            </a>
        @endif

    </div>

    {{-- Global Toast Notification --}}
    <x-toast />

    {{-- Scripts: countdown + auto-polling --}}
    @if(isset($resetRequest) && $resetRequest && $resetRequest->status === 'pending')
    <script>
        // ── Countdown timer ke pengiriman temp password ──────────────────
        @php
            $targetTs = $resetRequest->created_at->timestamp + \App\Models\PasswordResetRequest::TEMP_PASSWORD_DELAY_SECONDS;
        @endphp

        const countdownTarget = {{ $targetTs }};
        const countdownEl     = document.getElementById('countdown-timer');

        function updateCountdown() {
            if (!countdownEl) return;
            const now       = Math.floor(Date.now() / 1000);
            const remaining = countdownTarget - now;
            if (remaining <= 0) {
                window.location.reload();
                return;
            }
            const m = Math.floor(remaining / 60).toString().padStart(2, '0');
            const s = (remaining % 60).toString().padStart(2, '0');
            countdownEl.textContent = m + ':' + s;
        }

        if (countdownEl) {
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        // ── Auto-polling setiap 10 detik ────────────────────────────────
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

        // ── Auto-reload saat temp password expired ──────────────────────
        @if($resetRequest->temp_password_sent_at && $resetRequest->isTempPasswordValid())
        const tempExpAt     = {{ $resetRequest->temp_password_expires_at->timestamp }};
        const msUntilExpiry = (tempExpAt - Math.floor(Date.now() / 1000)) * 1000;
        if (msUntilExpiry > 0) {
            setTimeout(() => window.location.reload(), msUntilExpiry + 500);
        }
        @endif
    </script>
    @endif

</body>
</html>
