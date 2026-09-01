<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Admin — Super Admin KAI</title>
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
        @include('superadmin.partials.topbar', ['title' => 'Kelola Admin'])

        <main class="p-6 lg:p-8">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600 shrink-0"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 shrink-0"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Daftar Admin</h1>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $admins->total() }} admin terdaftar</p>
                </div>
                <a href="{{ route('superadmin.admins.create') }}"
                    class="flex items-center gap-2 bg-[#0066FF] hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Tambah Admin
                </a>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50">
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3">Admin</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3">Email</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3">Username</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3">Status</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3">Dibuat</th>
                                <th class="text-right text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($admins as $admin)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-xs font-bold text-blue-600">{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                                            </div>
                                            <span class="font-medium text-gray-900">{{ $admin->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $admin->email }}</td>
                                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">{{ $admin->username }}</td>
                                    <td class="px-6 py-4">
                                        @if($admin->is_active)
                                            <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $admin->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            {{-- Edit --}}
                                            <a href="{{ route('superadmin.admins.edit', $admin) }}"
                                                class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                            {{-- Toggle Aktif --}}
                                            <form action="{{ route('superadmin.admins.toggle', $admin) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="p-2 text-gray-400 hover:text-{{ $admin->is_active ? 'orange' : 'green' }}-600 hover:bg-{{ $admin->is_active ? 'orange' : 'green' }}-50 rounded-lg transition"
                                                    title="{{ $admin->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                    <i data-lucide="{{ $admin->is_active ? 'user-x' : 'user-check' }}" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            {{-- Hapus --}}
                                            <form action="{{ route('superadmin.admins.destroy', $admin) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus admin {{ $admin->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                        <i data-lucide="users" class="w-10 h-10 mx-auto mb-3 opacity-30"></i>
                                        <p>Belum ada admin terdaftar.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($admins->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $admins->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => { lucide.createIcons(); });
    </script>
</body>
</html>
