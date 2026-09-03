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
                        <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/50 rounded-full flex items-center justify-center shrink-0">
                            <x-icon name="toast-peringatan" class="w-6 h-6" />
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
                    <p class="font-semibold text-xs mb-2 text-blue-900 dark:text-blue-300 flex items-center gap-1.5">
                        <x-icon name="toast-peringatan" class="w-4 h-4" /> Informasi Penting:
                    </p>
                    <ul class="list-disc pl-4 space-y-1 text-xs text-blue-700 dark:text-blue-300/80">
                        <li>Jika disetujui, kode OTP akan dikirim ke email Anda</li>
                        <li>Jika tidak diproses dalam <strong>24 jam</strong>, sistem akan otomatis mereset password dan mengirimkan password sementara ke email Anda</li>
                    </ul>
                </div>

                {{-- Waktu kedaluwarsa --}}
                @if($resetRequest->request_expires_at)
                    <div class="flex items-center gap-3 bg-gray-50 dark:bg-[#282A2C] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 mb-6">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
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
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shrink-0 text-white">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
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
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center shrink-0">
                            <x-icon name="toast-sukses" class="w-6 h-6" />
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
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shrink-0 text-white">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <span class="text-sm text-gray-700 font-medium">Request dikirim ke Super Admin</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shrink-0 text-white">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <span class="text-sm text-gray-700 font-medium">Disetujui Super Admin</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shrink-0 text-white">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
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
                    Masukkan Kode OTP
                </a>

            @else
                {{-- Status lain (rejected, completed, auto_reset) --}}
                <div class="bg-gray-50 dark:bg-[#282A2C] border border-gray-200 dark:border-white/10 rounded-2xl p-6 mb-6 text-center">
                    @if($resetRequest->status === 'rejected')
                        <x-icon name="toast-gagal" class="w-10 h-10 mx-auto mb-3" />
                        <p class="font-bold text-gray-800 dark:text-white text-sm mb-1">Request Ditolak</p>
                        <p class="text-gray-500 dark:text-[#9AA0A6] text-xs">Request reset password Anda ditolak oleh Super Admin. Silakan hubungi Super Admin untuk informasi lebih lanjut.</p>
                    @elseif($resetRequest->status === 'completed')
                        <x-icon name="toast-sukses" class="w-10 h-10 mx-auto mb-3" />
                        <p class="font-bold text-gray-800 dark:text-white text-sm mb-1">Password Berhasil Diubah</p>
                        <p class="text-gray-500 dark:text-[#9AA0A6] text-xs">Proses reset password telah selesai. Silakan login dengan password baru Anda.</p>
                    @elseif($resetRequest->status === 'auto_reset')
                        <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/40 flex items-center justify-center mx-auto mb-3 text-[#0066FF] dark:text-[#3B82F6]">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                        </div>
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
                <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-3 text-gray-400">
                    <x-icon name="mail" class="w-6 h-6" />
                </div>
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
        // Auto-polling setiap 3 detik saat status masih pending
        const pollInterval = setInterval(async () => {
            try {
                const res  = await fetch('{{ route('password.request.poll') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();

                if (data.status === 'approved' && data.redirect_url) {
                    clearInterval(pollInterval);
                    window.showToast('Request disetujui! Mengalihkan ke halaman OTP...', 'success');
                    setTimeout(() => window.location.href = data.redirect_url, 1500);
                }
            } catch (e) {
                // Abaikan error jaringan, coba lagi di interval berikutnya
            }
        }, 3000);
    </script>
    @endif

    <x-toast />
</body>
</html>
