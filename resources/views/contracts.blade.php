<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Kontrak — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-[#F6F7F9] font-sans antialiased text-gray-900 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between">

    {{-- Top Navbar --}}
    <x-navbar active="contracts" />

    {{-- Main Content --}}
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-6 pb-24 lg:pb-8 flex flex-col gap-4 sm:gap-5">

        {{-- Page Header: Title & Action Buttons --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0">
            <h1 class="text-2xl sm:text-[30px] font-bold tracking-tight text-gray-950">
                Daftar Kontrak
            </h1>

            <div class="flex items-center gap-2 self-start sm:self-auto">
                <button type="button" style="background-color: #0066FF;" class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:opacity-95 transition cursor-pointer">
                    <x-icon name="filter" class="w-4 h-4 text-white" />
                    <span>Terapkan Filter</span>
                </button>

                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 shadow-xs transition cursor-pointer" title="Reset Filter">
                    <x-icon name="refresh" class="w-4.5 h-4.5 text-gray-600" />
                </button>
            </div>
        </div>

        {{-- Filter Row Container --}}
        <div class="rounded-2xl sm:rounded-3xl bg-white p-3.5 sm:p-4 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col gap-3">
            <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                
                {{-- Search Box --}}
                <div class="relative flex-1 min-w-[200px] sm:min-w-[240px]">
                    <x-icon name="search" class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                    <input 
                        type="text" 
                        placeholder="Search" 
                        class="w-full pl-10 pr-3.5 py-2 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#0066FF] text-gray-800 placeholder-gray-400 transition"
                    >
                </div>

                {{-- Select 1: Semua Stasiun --}}
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition">
                        <option>Semua Stasiun</option>
                        <option>Semarang Tawang</option>
                        <option>Semarang Poncol</option>
                        <option>Tegal</option>
                        <option>Pekalongan</option>
                        <option>Cepu</option>
                    </select>
                    <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                </div>

                {{-- Select 2: Raw dan Non Raw --}}
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition">
                        <option>Raw dan Non Raw</option>
                        <option>Raw</option>
                        <option>Non Raw</option>
                    </select>
                    <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                </div>

                {{-- Select 3: Semua Jenis Pendapatan --}}
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition">
                        <option>Semua Jenis Pendapatan</option>
                        <option>Pendapatan Angkutan</option>
                        <option>Pendapatan Non Angkutan</option>
                        <option>Sewa Aset</option>
                    </select>
                    <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                </div>

                {{-- Select 4: Semua RKA --}}
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition">
                        <option>Semua RKA</option>
                        <option>RKA 2026</option>
                        <option>RKA 2025</option>
                    </select>
                    <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                </div>

                {{-- Select 5: Semua Jenis Aset --}}
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition">
                        <option>Semua Jenis Aset</option>
                        <option>Bangunan Dinas</option>
                        <option>Tanah Lapang</option>
                        <option>Gudang</option>
                        <option>Kios / Ruko</option>
                    </select>
                    <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                </div>

                {{-- Select 6: Semua Invoice --}}
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-200 text-gray-600 text-xs sm:text-sm rounded-xl pl-3.5 pr-8 py-2 focus:outline-none focus:border-[#0066FF] cursor-pointer transition">
                        <option>Semua Invoice</option>
                        <option>Terbit</option>
                        <option>Belum Terbit</option>
                        <option>Lunas</option>
                    </select>
                    <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                </div>

            </div>
        </div>

        {{-- Table Container --}}
        <div class="rounded-2xl sm:rounded-3xl bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/90 overflow-hidden flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Penyewa</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">No Aset</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Stasiun</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Jenis Aset</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Peruntukan</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Luas (m²)</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Nilai Kontrak</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Jatuh Tempo</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Ket/Invoice</th>
                            <th scope="col" class="py-3.5 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-[13px] text-gray-700">
                        @forelse($contracts as $item)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="py-3.5 px-4 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $item['tenant'] }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                    {{ $item['asset_no'] }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                    {{ $item['station'] }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                    {{ $item['asset_type'] }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 font-normal max-w-[260px] leading-snug">
                                    {{ $item['designation'] }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                    {{ $item['area'] }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-900 font-semibold whitespace-nowrap">
                                    {{ $item['contract_value'] }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap font-normal">
                                    {{ $item['due_date'] }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-700 font-medium whitespace-nowrap">
                                    {{ $item['status'] }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                    {{-- Three-dot action menu --}}
                                    <div class="relative inline-block text-left action-menu-wrapper">
                                        <button
                                            type="button"
                                            class="action-menu-btn flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition cursor-pointer"
                                            title="Aksi"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="5" r="1.5"/>
                                                <circle cx="12" cy="12" r="1.5"/>
                                                <circle cx="12" cy="19" r="1.5"/>
                                            </svg>
                                        </button>

                                        {{-- Dropdown Menu --}}
                                        <div class="action-dropdown hidden absolute right-0 z-50 mt-1 w-36 origin-top-right rounded-xl bg-white border border-gray-200 shadow-lg py-1">
                                            <a href="#" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                                <x-icon name="eye" class="w-4 h-4 text-gray-400" />
                                                <span>Lihat</span>
                                            </a>
                                            <a href="#" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition">
                                                <x-icon name="pencil" class="w-4 h-4 text-blue-500" />
                                                <span class="text-blue-600 font-medium">Edit</span>
                                            </a>
                                            <a href="#" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-red-50 transition">
                                                <x-icon name="trash" class="w-4 h-4 text-red-500" />
                                                <span class="text-red-500">Hapus</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-8 text-gray-400">
                                    Tidak ada data kontrak yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
        // Toggle action dropdown on three-dot button click
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.action-menu-btn');

            // Close all open dropdowns first
            document.querySelectorAll('.action-dropdown').forEach(d => d.classList.add('hidden'));

            if (btn) {
                e.stopPropagation();
                const dropdown = btn.closest('.action-menu-wrapper').querySelector('.action-dropdown');
                dropdown.classList.toggle('hidden');
            }
        });
    </script>

</body>

</html>
