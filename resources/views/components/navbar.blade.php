@php
    $user = auth()->user();
    $isAdmin = $user && in_array($user->role, ['admin', 'superadmin']);
    $isSuperAdmin = $user && $user->role === 'superadmin';
    $currentRoute = request()->route()?->getName() ?? '';
@endphp

{{-- Top Navigation Bar --}}
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200 pt-safe">
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-10">
        <div class="flex items-center justify-between h-16">
            
            {{-- Logo & Brand --}}
            <div class="flex items-center">
                <a href="{{ route('assets.index') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-2xl bg-primary flex items-center justify-center text-white shadow-sm group-hover:bg-primary-hover transition shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="16" x="4" y="3" rx="2"/><path d="M4 11h16"/><path d="M12 3v8"/><path d="m8 19-2 3"/><path d="m18 22-2-3"/><path d="M8 15h0"/><path d="M16 15h0"/></svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-base tracking-tight text-gray-950 leading-none">
                            KAI <span class="text-primary font-black">DAOP 4</span>
                        </span>
                        <span class="text-[10px] tracking-widest uppercase text-slate-500 font-semibold mt-0.5">Semarang Property</span>
                    </div>
                </a>
            </div>

            {{-- Desktop Navigation Links --}}
            <div class="flex items-center gap-8">
                <nav class="hidden md:flex items-center gap-7">
                    <a href="{{ route('assets.index') }}" 
                       class="text-sm transition-colors {{ request()->routeIs('assets.index') ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-gray-600 hover:text-gray-900 font-medium' }}">
                        Peta Aset
                    </a>
                    <a href="{{ route('assets.catalog') }}" 
                       class="text-sm transition-colors {{ request()->routeIs('assets.catalog') ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-gray-600 hover:text-gray-900 font-medium' }}">
                        Katalog Properti
                    </a>
                    <a href="{{ route('favorites.index') }}" 
                       class="text-sm transition-colors flex items-center gap-1.5 {{ request()->routeIs('favorites.*') ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-gray-600 hover:text-gray-900 font-medium' }}">
                        Favorit
                    </a>
                    <a href="{{ route('faq') }}" 
                       class="text-sm transition-colors {{ request()->routeIs('faq') ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-gray-600 hover:text-gray-900 font-medium' }}">
                        FAQ
                    </a>
                    <a href="{{ route('settings') }}" 
                       class="text-sm transition-colors {{ request()->routeIs('settings') ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-gray-600 hover:text-gray-900 font-medium' }}">
                        Pengaturan
                    </a>
                </nav>
                @if($isAdmin)
                {{-- Admin Menu --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" 
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-orange-50 text-xs font-semibold text-primary border border-primary-border hover:bg-orange-100 transition min-h-[36px]">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        <span>Menu Admin</span>
                        <i data-lucide="chevron-down" class="w-3 h-3 text-primary transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" 
                         x-cloak
                         style="display: none;"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-1.5 z-50">
                        
                        <div class="px-3.5 py-2 border-b border-gray-100">
                            <p class="text-xs font-semibold text-gray-900">{{ $user->name }}</p>
                            <p class="text-[11px] text-slate-500 capitalize">{{ $user->role }}</p>
                        </div>

                        <a href="{{ route('admin.assets.index') }}" 
                           class="flex items-center gap-2.5 px-3.5 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-primary transition min-h-[44px]">
                            <i data-lucide="building" class="w-5 h-5 text-gray-400"></i>
                            <span>Kelola Aset</span>
                        </a>

                        <a href="{{ route('admin.assets.create') }}" 
                           class="flex items-center gap-2.5 px-3.5 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-primary transition min-h-[44px]">
                            <i data-lucide="plus-circle" class="w-5 h-5 text-gray-400"></i>
                            <span>Tambah Aset Baru</span>
                        </a>

                        @if($isSuperAdmin)
                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center gap-2.5 px-3.5 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-primary transition min-h-[44px]">
                            <i data-lucide="users" class="w-5 h-5 text-gray-400"></i>
                            <span>Manajemen Pengguna</span>
                        </a>
                        @endif

                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="{{ route('logout') }}" 
                           class="flex items-center gap-2.5 px-3.5 py-2.5 text-sm text-red-600 hover:bg-red-50 transition min-h-[44px]">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            <span>Keluar</span>
                        </a>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</header>

{{-- Mobile Bottom Navigation --}}
<div class="md:hidden fixed inset-x-0 z-50 flex justify-center pointer-events-none select-none px-4" 
     style="bottom: calc(1rem + env(safe-area-inset-bottom, 0px));">
    <nav class="pointer-events-auto bg-white/95 backdrop-blur-lg border border-gray-200/90 rounded-full shadow-2xl h-14 px-2 grid grid-cols-5 items-center w-full max-w-[360px]">
        
        @php $isHome = request()->routeIs('assets.index'); @endphp
        <a href="{{ route('assets.index') }}" 
           title="Peta Aset"
           class="w-full h-full flex items-center justify-center transition-colors group {{ $isHome ? 'text-primary' : 'text-slate-500 hover:text-gray-900' }}">
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 {{ $isHome ? 'bg-orange-50 text-primary' : 'text-slate-500' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $isHome ? '2.5' : '2' }}" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
        </a>

        @php $isExplore = request()->routeIs('assets.catalog') || request()->routeIs('assets.show'); @endphp
        <a href="{{ route('assets.catalog') }}" 
           title="Katalog Properti"
           class="w-full h-full flex items-center justify-center transition-colors group {{ $isExplore ? 'text-primary' : 'text-slate-500 hover:text-gray-900' }}">
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 {{ $isExplore ? 'bg-orange-50 text-primary' : 'text-slate-500' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $isExplore ? '2.5' : '2' }}" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
        </a>

        @php $isFav = request()->routeIs('favorites.*'); @endphp
        <a href="{{ route('favorites.index') }}" 
           title="Favorit"
           class="w-full h-full flex items-center justify-center transition-colors group {{ $isFav ? 'text-rose-500' : 'text-slate-500 hover:text-gray-900' }}">
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 {{ $isFav ? 'bg-rose-50 text-rose-500' : 'text-slate-500' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="{{ $isFav ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="{{ $isFav ? '2.5' : '2' }}" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
            </div>
        </a>

        @php $isFaq = request()->routeIs('faq'); @endphp
        <a href="{{ route('faq') }}" 
           title="Tanya Jawab & Bantuan"
           class="w-full h-full flex items-center justify-center transition-colors group {{ $isFaq ? 'text-primary' : 'text-slate-500 hover:text-gray-900' }}">
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 {{ $isFaq ? 'bg-orange-50 text-primary' : 'text-slate-500' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $isFaq ? '2.5' : '2' }}" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
            </div>
        </a>

        @php $isSettings = request()->routeIs('settings') || request()->routeIs('admin.*') || request()->routeIs('login'); @endphp
        <a href="{{ route('settings') }}" 
           title="Pengaturan & Akun"
           class="w-full h-full flex items-center justify-center transition-colors group {{ $isSettings ? 'text-primary' : 'text-slate-500 hover:text-gray-900' }}">
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 {{ $isSettings ? 'bg-orange-50 text-primary' : 'text-slate-500' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $isSettings ? '2.5' : '2' }}" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
        </a>

    </nav>
</div>
