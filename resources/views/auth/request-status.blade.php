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
        <div class="text-center mb-8">
            <span class="text-2xl font-bold italic text-gray-900 dark:text-white">KAI <span class="text-[#0066FF] dark:text-[#3B82F6]">TrackerApp</span></span>
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

                {{-- Info 24 jam --}}
                <div class="bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800/50 rounded-xl p-4 mb-6 text-sm text-blue-800 dark:text-blue-200">
                    <p class="font-semibold text-xs mb-2 text-blue-900 dark:text-blue-300">ℹ️ Informasi Penting:</p>
                    <ul class="list-disc pl-4 space-y-1 text-xs text-blue-700 dark:text-blue-300/80">
                        <li>Jika disetujui, kode OTP akan dikirim ke email Anda</li>
                        <li>Jika tidak diproses dalam <strong>24 jam</strong>, sistem akan otomatis mereset password dan mengirimkan password sementara ke email Anda</li>
                    </ul>
                </div>

                {{-- Waktu kedaluwarsa --}}
                @if($resetRequest->request_expires_at)
                    <div class="flex items-center gap-2 bg-gray-50 dark:bg-[#282A2C] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 mb-6">
                        <span class="text-sm">🕒</span>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-[#9AA0A6]">Kedaluwarsa otomatis pada:</p>
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
                            <div class="w-6 h-6 bg-orange-400 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-white text-xs font-bold">2</span>
                            </div>
                            <span class="text-sm text-gray-400 dark:text-[#9AA0A6]">Menunggu persetujuan Super Admin...</span>
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
                        <p class="font-bold text-gray-800 dark:text-white text-sm mb-1">Password Direset Otomatis</p>
                        <p class="text-gray-500 dark:text-[#9AA0A6] text-xs">Karena tidak ada respon dalam 24 jam, sistem telah mengirimkan password sementara ke email Anda.</p>
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

</body>
</html>
