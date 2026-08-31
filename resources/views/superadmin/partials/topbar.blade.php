<header class="bg-white border-b border-gray-100 px-6 lg:px-8 py-4 flex items-center justify-between">
    <div>
        <h2 class="text-lg font-bold text-gray-900">{{ $title ?? 'Panel Super Admin' }}</h2>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('welcome') }}" class="text-xs text-gray-400 hover:text-gray-700 flex items-center gap-1 transition">
            <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
            Lihat Aplikasi
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg transition flex items-center gap-1.5">
                <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                Keluar
            </button>
        </form>
    </div>
</header>
