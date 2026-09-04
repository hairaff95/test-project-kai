<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Admin — Super Admin KAI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } } }</script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#F8F8F6] font-sans antialiased min-h-screen">

    @include('superadmin.partials.sidebar')

    <div class="lg:ml-64 min-h-screen">
        @include('superadmin.partials.topbar', ['title' => 'Edit Admin'])

        <main class="p-6 lg:p-8">
            <div class="max-w-xl">

                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ route('superadmin.admins.index') }}" class="text-gray-400 hover:text-gray-700 transition">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <h1 class="text-xl font-bold text-gray-900">Edit Admin: {{ $admin->name }}</h1>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
                    <form action="{{ route('superadmin.admins.update', $admin) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                                class="w-full rounded-lg border border-gray-300 py-2.5 px-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition @error('name') border-red-400 @enderror">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Username</label>
                            <input type="text" name="username" value="{{ old('username', $admin->username) }}"
                                class="w-full rounded-lg border border-gray-300 py-2.5 px-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition @error('username') border-red-400 @enderror">
                            @error('username')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                                class="w-full rounded-lg border border-gray-300 py-2.5 px-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition @error('email') border-red-400 @enderror">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="border-t border-gray-100 pt-5">
                            <p class="text-xs text-gray-400 mb-3">Kosongkan field password jika tidak ingin mengubah password.</p>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru (opsional)</label>
                            <input type="password" name="password"
                                class="w-full rounded-lg border border-gray-300 py-2.5 px-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition @error('password') border-red-400 @enderror"
                                placeholder="Minimal 8 karakter">
                            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation"
                                class="w-full rounded-lg border border-gray-300 py-2.5 px-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition"
                                placeholder="Ulangi password baru">
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                class="bg-[#0066FF] hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('superadmin.admins.index') }}"
                                class="text-sm text-gray-500 hover:text-gray-800 px-4 py-2.5 rounded-xl hover:bg-gray-100 transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>

    <script>document.addEventListener('DOMContentLoaded', () => { lucide.createIcons(); });</script>
</body>
</html>
