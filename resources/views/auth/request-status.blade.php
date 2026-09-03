<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Request Reset Password — KAI Tracker App</title>
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

    <div class="w-full max-w-[460px]">

        {{-- Logo --}}
        <div class="text-center mb-8 flex items-center justify-center gap-1.5">
            <x-icon name="kai-logo" class="h-[19px] sm:h-5 lg:h-[24px] w-auto shrink-0" />
            <p class="text-gray-900 dark:text-white font-bold italic text-lg">Tracker<span class="text-[#0066FF] dark:text-[#3B82F6]">App</span></p>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mb-5 flex items-center gap-3 bg-green-50 dark:bg-green-950/40 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-xl text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-5 flex items-center gap-3 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-xl text-sm">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- Heading --}}
        <h1 class="text-3xl font-bold text-gray-950 dark:text-white tracking-tight mb-3">
            Status Request
        </h1>
        <p class="text-sm text-gray-500 dark:text-[#9AA0A6] mb-8 leading-relaxed">
            Request reset password Anda telah dikirim ke Super Admin.
        </p>

        @if($resetRequest)

            {{-- Status: PENDING --}}
            @if($resetRequest->status === 'pending')
                @php
                    $isBlocked   = $resetRequest->isBlocked();
                    $remaining   = $resetRequest->remainingRequests();
                    $maxReq      = \App\Models\PasswordResetRequest::MAX_REQUESTS_PER_CYCLE;
                    $currentReq  = $resetRequest->request_count;
                    $tempSent    = $resetRequest->temp_password_sent_at !== null;
                @endphp

                {{-- Status box: blocked vs normal pending --}}
                @if($isBlocked)
                    <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/50 rounded-2xl p-6 mb-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-red-100 dark:bg-red-900/50 rounded-full flex items-center justify-center shrink-0 text-lg">
                                🚫
                            </div>
                            <div>
                                <p class="font-bold text-red-800 dark:text-red-300 text-sm mb-1">Batas Maksimal Request Tercapai</p>
                                <p class="text-red-700 dark:text-red-300/80 text-xs leading-relaxed">
                                    Anda telah mengajukan <strong>{{ $maxReq }}x request</strong> dalam siklus ini dan tidak dapat mengajukan request baru.
                                    Silakan tunggu Super Admin memproses request terakhir Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-orange-50 dark:bg-orange-950/30 border border-orange-200 dark:border-orange-800/50 rounded-2xl p-6 mb-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/50 rounded-full flex items-center justify-center shrink-0 text-lg">
                                ⏳
                            </div>
                            <div>
                                <p class="font-bold text-orange-800 dark:text-orange-300 text-sm mb-1">Menunggu Persetujuan Super Admin</p>
                                <p class="text-orange-700 dark:text-orange-300/80 text-xs leading-relaxed">
                                    Request Anda sedang dalam antrian. Super Admin akan mereview dan menyetujui atau menolak request ini.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Indikator sisa request --}}
                <div class="bg-gray-50 dark:bg-[#282A2C] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 mb-4">
                    <p class="text-xs text-gray-500 dark:text-[#9AA0A6] mb-2 font-semibold">Kuota Request Siklus Ini</p>
                    <div class="flex items-center gap-2">
                        @for($i = 1; $i <= $maxReq; $i++)
                            <div class="flex-1 h-2 rounded-full {{ $i <= $currentReq ? ($isBlocked ? 'bg-red-500' : 'bg-orange-400') : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                        @endfor
                    </div>
                    <p class="text-xs mt-2 {{ $isBlocked ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-500 dark:text-[#9AA0A6]' }}">
                        @if($isBlocked)
                            🚫 Request ke-{{ $currentReq }}/{{ $maxReq }} — Anda telah mencapai batas. Tidak bisa ajukan request baru.
                        @else
                            Request ke-{{ $currentReq }}/{{ $maxReq }} — Sisa: {{ $remaining }}x lagi sebelum di-block
                        @endif
                    </p>
                </div>

                {{-- Info waktu --}}
                <div class="bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800/50 rounded-xl p-4 mb-6 text-sm text-blue-800 dark:text-blue-200">
                    <p class="font-semibold text-xs mb-2 text-blue-900 dark:text-blue-300">ℹ️ Informasi Penting:</p>
                    <ul class="list-disc pl-4 space-y-1 text-xs text-blue-700 dark:text-blue-300/80">
                        <li>Jika disetujui, kode OTP akan dikirim ke email Anda</li>
                        @if(!$tempSent)
                            <li>Jika tidak direspons dalam <strong>1 menit</strong>, sistem akan otomatis mengirimkan <strong>password sementara</strong> ke email Anda</li>
                        @else
                            <li>✅ Password sementara telah dikirim ke email Anda — berlaku <strong>2 menit</strong> sejak pengiriman</li>
                        @endif
                        <li>Password sementara berlaku selama <strong>2 menit</strong></li>
                        @if(!$isBlocked)
                            <li>Setelah password sementara habis, ajukan <strong>request baru</strong> untuk mendapatkan password sementara baru (sisa {{ $remaining }}x)</li>
                        @else
                            <li>Anda tidak bisa mengajukan request baru. Silakan tunggu Super Admin memproses request ini.</li>
                        @endif
                        <li>Maksimal <strong>{{ $maxReq }}x request</strong> per siklus sebelum di-block</li>
                    </ul>
                </div>

                {{-- Waktu kedaluwarsa --}}
                @if($resetRequest->request_expires_at)
                    <div class="flex items-center gap-2 bg-gray-50 dark:bg-[#282A2C] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 mb-6">
                        <span class="text-sm">🕒</span>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-[#9AA0A6]">Request kedaluwarsa otomatis pada:</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                {{ $resetRequest->request_expires_at->format('d M Y, H:i') }} WIB
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Progress Steps --}}
                <div class="mb-8">
                    <p class="text-xs font-semibold text-gray-500 dark:text-[#9AA0A6] uppercase tracking-wider mb-4">Progress</p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-white text-xs font-bold">✓</span>
                            </div>
                            <span class="text-sm text-gray-700 dark:text-gray-200 font-medium">Request dikirim ke Super Admin</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 {{ $isBlocked ? 'bg-red-400' : 'bg-orange-400' }} rounded-full flex items-center justify-center shrink-0">
                                <span class="text-white text-xs font-bold">2</span>
                            </div>
                            <span class="text-sm text-gray-400 dark:text-[#9AA0A6]">
                                @if($isBlocked) 🚫 Menunggu respons Super Admin (request terblokir)...
                                @else Menunggu persetujuan Super Admin...
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-gray-500 dark:text-gray-300 text-xs font-bold">3</span>
                            </div>
                            <span class="text-sm text-gray-400 dark:text-[#9AA0A6]">OTP dikirim ke email Anda</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-gray-500 dark:text-gray-300 text-xs font-bold">4</span>
                            </div>
                            <span class="text-sm text-gray-400 dark:text-[#9AA0A6]">Verifikasi OTP & ubah password</span>
                        </div>
                    </div>
                </div>

                {{-- Tombol aksi berdasarkan kondisi --}}
                @php
                    $canRequestNew = !$isBlocked && $tempSent && !$resetRequest->isTempPasswordValid();
                    $waitingForTemp = !$tempSent && $resetRequest->created_at->diffInSeconds(now()) < \App\Models\PasswordResetRequest::TEMP_PASSWORD_DELAY_SECONDS;
                @endphp

                @if($canRequestNew)
                    {{-- Temp password sudah expired, session habis → tawarkan request baru --}}
                    <div class="bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/50 rounded-xl p-4 mb-4">
                        <p class="text-xs font-semibold text-amber-800 dark:text-amber-300 mb-1">⏰ Password sementara sudah kedaluwarsa</p>
                        <p class="text-xs text-amber-700 dark:text-amber-300/80">Ajukan request baru untuk mendapatkan password sementara yang baru. Sisa kesempatan: <strong>{{ $remaining }}x</strong></p>
                    </div>
                    <a href="{{ route('password.request') }}"
                        class="w-full inline-block text-center rounded-xl bg-[#0066FF] hover:bg-blue-700 py-3.5 text-sm font-semibold text-white transition shadow-sm mb-4">
                        Ajukan Request Baru →
                    </a>
                @elseif($waitingForTemp && !$isBlocked)
                    {{-- Masih menunggu 1 menit sebelum temp password dikirim --}}
                    <div id="countdown-box" class="bg-gray-50 dark:bg-[#282A2C] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 mb-4 text-center">
                        <p class="text-xs text-gray-500 dark:text-[#9AA0A6] mb-1">Password sementara dikirim dalam:</p>
                        <p id="countdown-timer" class="text-2xl font-bold text-[#0066FF] dark:text-[#3B82F6] font-mono">--:--</p>
                    </div>
                @elseif(!$tempSent && !$isBlocked)
                    {{-- Sudah > 1 menit, sedang dalam proses kirim --}}
                    <div class="bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800/50 rounded-xl px-4 py-3 mb-4 text-center">
                        <p class="text-xs text-blue-600 dark:text-blue-300">🔄 Mengirim password sementara ke email Anda...</p>
                    </div>
                @endif

            {{-- Status: APPROVED --}}
            @elseif($resetRequest->status === 'approved')
                <div class="bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800/50 rounded-2xl p-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center shrink-0 text-lg">
                            ✅
                        </div>
                        <div>
                            <p class="font-bold text-blue-800 dark:text-blue-300 text-sm mb-1">Request Disetujui!</p>
                            <p class="text-blue-700 dark:text-blue-300/80 text-xs leading-relaxed">
                                Super Admin telah menyetujui request Anda. Kode OTP telah dikirim ke email Anda.
                                @if($resetRequest->otp_expires_at)
                                    Kode berlaku hingga <strong>{{ $resetRequest->otp_expires_at->format('H:i') }} WIB</strong>.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- OTP ditampilkan langsung --}}
                @if($resetRequest->otp_code)
                    <div class="bg-white border-2 border-[#0066FF] rounded-2xl p-6 mb-6 text-center">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Kode OTP Anda</p>
                        <div class="flex items-center justify-center gap-2 mb-3">
                            @foreach(str_split($resetRequest->otp_code) as $digit)
                                <div class="w-11 h-13 flex items-center justify-center rounded-[14px] border-2 border-[#0066FF] bg-blue-50 text-2xl font-bold text-[#0066FF]">
                                    {{ $digit }}
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400">Gunakan kode ini untuk verifikasi. Jangan bagikan ke siapapun.</p>
                    </div>
                @endif

                {{-- Progress Steps --}}
                <div class="mb-8">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Progress</p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-white text-xs font-bold">✓</span>
                            </div>
                            <span class="text-sm text-gray-700 font-medium">Request dikirim ke Super Admin</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-white text-xs font-bold">✓</span>
                            </div>
                            <span class="text-sm text-gray-700 font-medium">Disetujui Super Admin</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-white text-xs font-bold">✓</span>
                            </div>
                            <span class="text-sm text-gray-700 font-medium">OTP tersedia</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-[#0066FF] rounded-full flex items-center justify-center shrink-0">
                                <span class="text-white text-xs font-bold">4</span>
                            </div>
                            <span class="text-sm text-gray-800 font-semibold">Verifikasi OTP & ubah password</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('password.verify') }}"
                    class="w-full inline-block text-center rounded-xl bg-[#0066FF] hover:bg-blue-700 py-3.5 text-sm font-semibold text-white transition shadow-sm mb-4">
                    Masukkan Kode OTP →
                </a>

            @else
                {{-- Status lain (rejected, completed, auto_reset) --}}
                <div class="bg-gray-50 dark:bg-[#282A2C] border border-gray-200 dark:border-white/10 rounded-2xl p-6 mb-6 text-center">
                    @if($resetRequest->status === 'rejected')
                        <div class="text-3xl mb-3">❌</div>
                        <p class="font-bold text-gray-800 dark:text-white text-sm mb-1">Request Ditolak</p>
                        <p class="text-gray-500 dark:text-[#9AA0A6] text-xs">Request reset password Anda ditolak oleh Super Admin. Silakan hubungi Super Admin untuk informasi lebih lanjut.</p>
                    @elseif($resetRequest->status === 'completed')
                        <div class="text-3xl mb-3">🎉</div>
                        <p class="font-bold text-gray-800 dark:text-white text-sm mb-1">Password Berhasil Diubah</p>
                        <p class="text-gray-500 dark:text-[#9AA0A6] text-xs">Proses reset password telah selesai. Silakan login dengan password baru Anda.</p>
                    @elseif($resetRequest->status === 'auto_reset')
                        <div class="text-3xl mb-3">🔄</div>
                        <p class="font-bold text-gray-800 dark:text-white text-sm mb-1">Password Sementara Dikirim</p>
                        <p class="text-gray-500 dark:text-[#9AA0A6] text-xs">Karena Super Admin belum memproses dalam 1 menit, sistem telah mengirimkan password sementara ke email Anda. Password berlaku selama 2 menit.</p>
                    @endif
                </div>

                <a href="{{ route('login') }}"
                    class="w-full inline-block text-center rounded-xl bg-[#0066FF] hover:bg-blue-700 py-3.5 text-sm font-semibold text-white transition shadow-sm mb-4">
                    Kembali ke Halaman Masuk
                </a>
            @endif

        @else
            {{-- Tidak ada request aktif --}}
            <div class="bg-gray-50 dark:bg-[#282A2C] border border-gray-200 dark:border-white/10 rounded-2xl p-6 text-center mb-6">
                <div class="text-3xl mb-3">📭</div>
                <p class="font-bold text-gray-800 dark:text-white text-sm mb-1">Tidak Ada Request Aktif</p>
                <p class="text-gray-500 dark:text-[#9AA0A6] text-xs">Anda belum memiliki request reset password yang sedang diproses.</p>
            </div>

            <a href="{{ route('password.request') }}"
                class="w-full inline-block text-center rounded-xl bg-[#0066FF] hover:bg-blue-700 py-3.5 text-sm font-semibold text-white transition shadow-sm mb-4">
                Buat Request Reset Password
            </a>
        @endif

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-xs text-gray-400 dark:text-[#9AA0A6] hover:text-gray-700 dark:hover:text-white transition">
                &larr; Kembali ke halaman Masuk
            </a>
        </div>

    </div>

    @if(isset($resetRequest) && $resetRequest && $resetRequest->status === 'pending')
    <script>
        // ── Countdown timer ke pengiriman temp password ──────────────────────────
        @php
            $targetTs = $resetRequest->created_at->timestamp + \App\Models\PasswordResetRequest::TEMP_PASSWORD_DELAY_SECONDS;
        @endphp

        const countdownTarget = {{ $targetTs }};
        const countdownEl     = document.getElementById('countdown-timer');
        const countdownBox    = document.getElementById('countdown-box');

        function updateCountdown() {
            if (!countdownEl) return;
            const now       = Math.floor(Date.now() / 1000);
            const remaining = countdownTarget - now;
            if (remaining <= 0) {
                // Waktu habis, reload halaman untuk tampilkan status terbaru
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

        // ── Auto-polling setiap 15 detik: cek status & approved redirect ────────
        const pollInterval = setInterval(async () => {
            try {
                const res  = await fetch('{{ route('password.request.poll') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();

                if (data.status === 'approved' && data.redirect_url) {
                    clearInterval(pollInterval);
                    document.body.insertAdjacentHTML('afterbegin', `
                        <div style="position:fixed;top:0;left:0;right:0;z-index:9999;background:#0066FF;color:white;text-align:center;padding:12px;font-size:14px;font-weight:600;">
                            ✅ Request disetujui! Mengalihkan ke halaman OTP...
                        </div>
                    `);
                    setTimeout(() => window.location.href = data.redirect_url, 1500);
                    return;
                }

                // Jika temp_pwd_sent baru saja dikirim, reload halaman agar tombol request baru muncul
                if (data.temp_pwd_sent === true) {
                    window.location.reload();
                }
            } catch (e) {
                // Abaikan error jaringan
            }
        }, 15000);

        // ── Auto-reload saat temp password expired (agar tombol "Ajukan Request Baru" muncul) ──
        @if($resetRequest->temp_password_sent_at && $resetRequest->isTempPasswordValid())
        const tempExpAt = {{ $resetRequest->temp_password_expires_at->timestamp }};
        const msUntilExpiry = (tempExpAt - Math.floor(Date.now() / 1000)) * 1000;
        if (msUntilExpiry > 0) {
            setTimeout(() => window.location.reload(), msUntilExpiry + 500);
        }
        @endif
    </script>
    @endif

</body>
</html>
