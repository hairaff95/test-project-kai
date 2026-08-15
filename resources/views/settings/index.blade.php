@extends('layout.app')

@section('title', 'Pengaturan & Info Aplikasi — KAI Daop 4 Semarang')

@section('content')
<div class="w-full px-6 sm:px-8 lg:px-10 py-8 pb-32 sm:pb-12 space-y-8">

    {{-- Header --}}
    <div class="border-b border-gray-200 pb-6">
        <span class="text-xs font-bold uppercase tracking-wider text-primary">Sistem & Pengaturan</span>
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-950 tracking-tight mt-1">
            Pengaturan & Informasi Sistem
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Informasi pengembang aplikasi dan akses portal internal staf KAI Daop 4 Semarang.
        </p>
    </div>

    {{-- App Info Section --}}
    <div class="border-b border-gray-200 pb-8 space-y-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-primary flex items-center justify-center text-white shrink-0">
                <i data-lucide="train" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-gray-950">
                    KAI Property Asset Tracker
                </h2>
                <p class="text-xs font-semibold text-primary mt-0.5">
                    PT Kereta Api Indonesia (Persero) · Daerah Operasi 4 Semarang
                </p>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-700 text-[10px] font-semibold mt-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Versi 2.4 (Terbaru)
                </span>
            </div>
        </div>

        <div class="space-y-4 max-w-4xl">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tentang Pengembang Sistem</h3>
            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                Aplikasi ini dikembangkan dan dikelola oleh <strong>Unit Pengelolaan & Komersialisasi Aset Non-Angkutan PT KAI Daop 4 Semarang</strong> bekerja sama dengan Tim Pengembang Sistem Informasi Geografis (GIS) untuk memfasilitasi transparansi inventarisasi, penyewaan, serta optimalisasi aset tanah dan bangunan milik negara.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-200 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-orange-50 text-primary flex items-center justify-center shrink-0">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase block">Kantor Operasional</span>
                        <span class="text-xs font-semibold text-gray-800">Jl. MH Thamrin No. 3, Semarang</span>
                    </div>
                </div>

                <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-200 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-orange-50 text-primary flex items-center justify-center shrink-0">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase block">Kontak Email</span>
                        <span class="text-xs font-semibold text-gray-800">komersial.daop4@kai.id</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section 2: Akses Administrator / Staf Internal --}}
    <div class="space-y-5 max-w-4xl">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-950 flex items-center gap-2">
                <i data-lucide="shield" class="w-5 h-5 text-primary"></i>
                <span>Portal Akses Administrator</span>
            </h2>
            <span class="text-[11px] text-gray-400 font-medium">Khusus Staf Resmi</span>
        </div>

        <p class="text-xs text-gray-500 leading-relaxed">
            Akses dashboard manajemen aset, penambahan properti baru, update koordinat peta, dan konfigurasi sistem.
        </p>

        @auth
        {{-- Logged in as Admin --}}
        <div class="p-4 rounded-xl bg-orange-50/70 border border-primary-border flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }} · {{ auth()->user()->email }}</div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.assets.index') }}" 
                   class="px-4 py-2 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-semibold transition flex items-center gap-1.5">
                    <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                    <span>Buka Panel Admin</span>
                </a>
                <a href="{{ route('logout') }}" 
                   class="px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-red-50 hover:text-red-600 text-gray-700 text-xs font-semibold transition">
                    Keluar
                </a>
            </div>
        </div>
        @else
        {{-- Guest User --}}
        <div class="p-5 rounded-xl bg-gray-50 border border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-gray-900">Apakah Anda staf pengelola aset KAI?</p>
                <p class="text-[11px] text-gray-500 mt-0.5">Masuk menggunakan kredensial akun internal Anda.</p>
            </div>
            <a href="{{ route('login') }}" 
               class="px-6 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-sm font-semibold transition flex items-center justify-center gap-2 shrink-0 min-h-[44px]">
                <i data-lucide="log-in" class="w-5 h-5"></i>
                <span>Masuk Administrator</span>
            </a>
        </div>
        @endauth
    </div>

</div>
@endsection
