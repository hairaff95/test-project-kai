<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Super Admin — KAI Tracker App</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }, colors: { primary: '#0066FF' } } }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#F8F8F6] font-sans antialiased min-h-screen">

    @include('superadmin.partials.sidebar')

    <div class="lg:ml-64 min-h-screen">
        @include('superadmin.partials.topbar', ['title' => 'Dashboard'])

        <main class="p-6 lg:p-8">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm font-medium">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600 shrink-0"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm font-medium">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 shrink-0"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Page Heading --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Selamat datang, {{ Auth::user()->name }}</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola admin dan request reset password dari panel ini.</p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">

                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-500">Total Admin</span>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                            <i data-lucide="users" class="w-5 h-5 text-blue-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalAdmins }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $activeAdmins }} aktif</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-500">Admin Aktif</span>
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                            <i data-lucide="user-check" class="w-5 h-5 text-green-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $activeAdmins }}</p>
                    <p class="text-xs text-gray-400 mt-1">dari {{ $totalAdmins }} total</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-100 shadow-sm {{ $pendingRequests > 0 ? 'ring-2 ring-orange-300' : '' }}">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-500">Request Pending</span>
                        <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center">
                            <i data-lucide="clock" class="w-5 h-5 text-orange-500"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $pendingRequests }}</p>
                    <a href="{{ route('superadmin.reset-requests') }}" class="text-xs text-orange-500 hover:underline mt-1 inline-block">Lihat semua →</a>
                </div>

            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <a href="{{ route('superadmin.admins.index') }}" class="flex items-center gap-4 bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition group">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                        <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Kelola Admin</p>
                        <p class="text-xs text-gray-500 mt-0.5">Tambah, edit, nonaktifkan admin</p>
                    </div>
                    <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto"></i>
                </a>

                <a href="{{ route('superadmin.reset-requests') }}" class="flex items-center gap-4 bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition group">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center group-hover:bg-orange-100 transition">
                        <i data-lucide="key-round" class="w-6 h-6 text-orange-500"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Request Reset Password</p>
                        <p class="text-xs text-gray-500 mt-0.5">Approve atau tolak request admin</p>
                    </div>
                    @if($pendingRequests > 0)
                        <span class="ml-auto bg-orange-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">{{ $pendingRequests }}</span>
                    @else
                        <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto"></i>
                    @endif
                </a>

            </div>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => { lucide.createIcons(); });
    </script>
</body>
</html>
