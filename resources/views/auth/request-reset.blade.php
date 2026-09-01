<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request Reset Password — KAI Tracker App</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } } }</script>
</head>

<body class="min-h-screen bg-white font-sans antialiased text-gray-900 flex flex-col justify-center items-center px-4 py-12">

    <div class="w-full max-w-[420px]">

        {{-- Logo --}}
        <div class="text-center mb-8 flex items-center justify-center">
            <x-icon name="kai-logo" class="h-[19px] sm:h-5 lg:h-[24px] w-auto shrink-0" />
            <p class="text-black font-bold italic">Tracker<span class="text-[#0066FF]">App</span></p>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                ❌ {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Heading --}}
        <h1 class="text-3xl font-bold text-gray-950 tracking-tight mb-2">
            Reset Password
        </h1>
        <p class="text-sm text-gray-500 leading-relaxed mb-8">
            Masukkan email yang terdaftar. Request akan dikirim ke Super Admin untuk disetujui.
        </p>

        {{-- Form input email --}}
        <form method="POST" action="{{ route('password.submit-request') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-xs font-semibold text-gray-700 mb-2">
                    Alamat Email
                </label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    placeholder="masukkan email yang terdaftar"
                    autofocus
                    class="w-full rounded-[10px] border border-gray-300 bg-white py-3 px-4 text-xs sm:text-sm text-gray-800 placeholder:text-gray-400 focus:border-[#0066FF] focus:outline-none transition shadow-2xs @error('email') border-red-400 @enderror"
                >
                @error('email')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Info alur --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-xs text-blue-800">
                <p class="font-semibold mb-1.5">Informasi Proses:</p>
                <ol class="list-decimal pl-4 space-y-1 text-blue-700">
                    <li>Masukkan email → request dikirim ke Super Admin</li>
                    <li>Super Admin menyetujui → kode OTP dikirim ke email Anda</li>
                    <li>Masukkan OTP → atur password baru</li>
                    <li>Jika tidak direspon 24 jam → password sementara otomatis dikirim</li>
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
            <a href="{{ route('login') }}" class="text-xs text-gray-400 hover:text-gray-700 transition">
                Kembali ke halaman Masuk
            </a>
        </div>

    </div>

</body>
</html>
