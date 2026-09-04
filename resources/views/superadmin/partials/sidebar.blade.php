<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#1E2228] flex flex-col hidden lg:flex">
    {{-- Logo --}}
    <div class="flex items-center gap-2 px-6 py-5 border-b border-white/10">
        <span class="text-white font-bold text-lg italic">KAI <span class="text-[#0066FF]">Admin</span></span>
        <span class="text-xs text-white/40 ml-auto">Super Admin</span>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

        <a href="{{ route('superadmin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                {{ request()->routeIs('superadmin.dashboard') ? 'bg-[#0066FF] text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0"></i>
            Dashboard
        </a>

        <a href="{{ route('superadmin.admins.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                {{ request()->routeIs('superadmin.admins.*') ? 'bg-[#0066FF] text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i data-lucide="users" class="w-5 h-5 shrink-0"></i>
            Kelola Admin
        </a>

        <a href="{{ route('superadmin.reset-requests') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                {{ request()->routeIs('superadmin.reset-requests') ? 'bg-[#0066FF] text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i data-lucide="key-round" class="w-5 h-5 shrink-0"></i>
            Request Reset Password
            @php
                $pendingCount = \App\Models\PasswordResetRequest::where('status', 'pending')->count();
            @endphp
            @if($pendingCount > 0)
                <span class="ml-auto bg-orange-500 text-white text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
            @endif
        </a>

    </nav>

    {{-- User Info & Logout --}}
    <div class="px-4 py-4 border-t border-white/10">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center">
                <i data-lucide="user" class="w-5 h-5 text-white/70"></i>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-white/40 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-sm text-white/60 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                Keluar
            </button>
        </form>
    </div>
</aside>
