<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Request Reset Password — Super Admin KAI</title>
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
        @include('superadmin.partials.topbar', ['title' => 'Request Reset Password'])

        <main class="p-6 lg:p-8">

            <div class="mb-6">
                <h1 class="text-xl font-bold text-gray-900">Request Reset Password</h1>
                <p class="text-sm text-gray-500 mt-0.5">Approve atau tolak request reset password dari admin.</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50">
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3">Admin</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3">Email</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3">Status</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3">Waktu Request</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3">Kedaluwarsa</th>
                                <th class="text-right text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($requests as $req)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $req->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $req->user->email ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusConfig = [
                                                'pending'    => ['bg-orange-50 text-orange-700', 'Pending'],
                                                'approved'   => ['bg-blue-50 text-blue-700', 'Disetujui'],
                                                'rejected'   => ['bg-red-50 text-red-700', 'Ditolak'],
                                                'completed'  => ['bg-green-50 text-green-700', 'Selesai'],
                                                'auto_reset' => ['bg-purple-50 text-purple-700', 'Auto Reset'],
                                            ];
                                            [$cls, $label] = $statusConfig[$req->status] ?? ['bg-gray-50 text-gray-700', $req->status];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $cls }}">
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $req->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 text-xs {{ $req->isExpired() ? 'text-red-500' : 'text-gray-400' }}">
                                        {{ $req->request_expires_at ? $req->request_expires_at->format('d M Y H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($req->isPending())
                                                {{-- Approve --}}
                                                <form action="{{ route('superadmin.reset-requests.approve', $req) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="flex items-center gap-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition"
                                                        onclick="return confirm('Setujui request reset password untuk {{ $req->user->name }}? OTP akan dikirim ke emailnya.')">
                                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                                        Approve
                                                    </button>
                                                </form>
                                                {{-- Reject --}}
                                                <form action="{{ route('superadmin.reset-requests.reject', $req) }}" method="POST" onsubmit="event.preventDefault(); return window.confirmDelete(this, 'Apakah Anda yakin ingin menolak permintaan reset kata sandi ini?');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="flex items-center gap-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition cursor-pointer">
                                                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                                        Tolak
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-400 italic">Sudah diproses</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                        <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-3 opacity-30"></i>
                                        <p>Tidak ada request reset password.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($requests->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $requests->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>

    <script>document.addEventListener('DOMContentLoaded', () => { lucide.createIcons(); });</script>
    <x-toast />
</body>
</html>
