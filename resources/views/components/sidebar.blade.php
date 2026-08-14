@php
    $user = auth()->user();
    $isAdmin      = $user && in_array($user->role, ['admin', 'superadmin']);
    $isSuperAdmin = $user && $user->role === 'superadmin';
@endphp

<nav class="fixed left-4 top-1/2 -translate-y-1/2 w-16 md:w-20 hidden sm:flex flex-col items-center py-5 md:py-6 rounded-full h-auto max-h-[90vh] bg-white/90 backdrop-blur-2xl border border-white/60 shadow-[0_8px_30px_rgba(0,0,0,0.06)] z-30 gap-2">

    @if($isAdmin)
    <a href="{{ route('admin.assets.create') }}" title="Tambah Aset Baru"
        class="{{ request()->routeIs('admin.assets.create') ? 'bg-[#006948] text-white shadow-md' : 'bg-[#e6f4ee] text-[#006948] hover:bg-[#006948] hover:text-white' }} rounded-full p-3 transition flex items-center justify-center mb-1">
        <span class="material-symbols-outlined text-2xl" style="font-variation-settings:'FILL' 1">add_circle</span>
    </a>
    <div class="w-8 h-px bg-gray-200 my-1"></div>
    @endif

    <div class="flex flex-col gap-2 items-center w-full px-2 flex-1">
        <a href="{{ route('assets.index') }}" title="Peta Aset"
            class="{{ request()->routeIs('assets.index') ? 'bg-[#006948] text-white shadow-md' : 'text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee]/70' }} rounded-full p-3 transition flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">map</span>
        </a>

        <a href="{{ route('assets.catalog') }}" title="Daftar Aset"
            class="{{ request()->routeIs('assets.catalog') ? 'bg-[#006948] text-white shadow-md' : 'text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee]/70' }} rounded-full p-3 transition flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">apartment</span>
        </a>

        <a href="{{ route('favorites.index') }}" title="Favorit Saya"
            class="{{ request()->routeIs('favorites.index') ? 'bg-[#006948] text-white shadow-md' : 'text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee]/70' }} rounded-full p-3 transition flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">favorite</span>
        </a>

        @if($isAdmin)
        <a href="{{ route('admin.assets.index') }}" title="Kelola Aset"
            class="{{ request()->routeIs('admin.assets.*') ? 'bg-[#006948] text-white shadow-md' : 'text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee]/70' }} rounded-full p-3 transition flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">inventory_2</span>
        </a>
        @endif

        @if($isSuperAdmin)
        <a href="{{ route('admin.users.index') }}" title="Manajemen Pengguna"
            class="{{ request()->routeIs('admin.users.*') ? 'bg-[#006948] text-white shadow-md' : 'text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee]/70' }} rounded-full p-3 transition flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">manage_accounts</span>
        </a>
        @endif
    </div>

    <div class="w-8 h-px bg-gray-200 my-1"></div>

    <div class="flex flex-col gap-2 items-center w-full px-2 pb-2">
        <a href="{{ route('faq') }}" title="Bantuan & FAQ"
            class="{{ request()->routeIs('faq') ? 'bg-[#006948] text-white shadow-md' : 'text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee]/70' }} rounded-full p-3 transition flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">help</span>
        </a>

        @if(auth()->check())
        <a href="{{ route('logout') }}" title="Logout ({{ auth()->user()->name }})"
            class="{{ request()->routeIs('logout') ? 'bg-[#006948] text-white shadow-md' : 'text-[#637369] hover:text-red-500 hover:bg-red-50' }} rounded-full p-3 transition flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">logout</span>
        </a>
        @else
        <a href="{{ route('login') }}" title="Login Admin"
            class="{{ request()->routeIs('login') ? 'bg-[#006948] text-white shadow-md' : 'text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee]/70' }} rounded-full p-3 transition flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">account_circle</span>
        </a>
        @endif
    </div>
</nav>