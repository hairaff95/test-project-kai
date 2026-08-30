<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-[#F6F7F9] font-sans antialiased text-gray-900 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between">

    {{-- Top Navbar --}}
    <x-navbar active="reports" />

    {{-- Main Content --}}
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-6 pb-24 lg:pb-8 flex flex-col gap-4 sm:gap-5">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0">
            <h1 class="text-2xl sm:text-[30px] font-bold tracking-tight text-gray-950">
                Laporan
            </h1>

            {{-- Header Action Buttons --}}
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <button id="btn-filter-lap" type="button" class="flex items-center gap-2 rounded-xl bg-[#0066FF] hover:bg-blue-700 px-4 py-2 text-sm font-semibold text-white shadow-xs transition cursor-pointer">
                    <x-icon name="filter-icon" class="w-4 h-4 text-white" />
                    <span>Filter</span>
                </button>

                <a href="{{ route('laporan.index') }}" class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 shadow-xs transition cursor-pointer" title="Reset">
                    <x-icon name="refresh" class="w-4.5 h-4.5 text-gray-600" />
                </a>
            </div>
        </div>

        {{-- Unified Card Container: Filter Bar + Bordered Table --}}
        <div class="rounded-2xl sm:rounded-3xl bg-white p-4 sm:p-5 shadow-[0_2px_12px_rgba(0,0,0,0.02)] border border-gray-100/90 flex flex-col gap-4">

            {{-- Filter Bar --}}
            <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">

                {{-- Search --}}
                <div class="relative w-[170px] sm:w-[185px] h-[38px] sm:h-[40px]">
                    <x-icon name="search" class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                    <input
                        id="search-lap"
                        type="text"
                        placeholder="Search"
                        class="w-full h-full pl-9 pr-3 py-2 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#0066FF] text-gray-700 placeholder-gray-400 transition"
                    >
                </div>

            </div>

            {{-- Table Wrapper Ber-Stroke --}}
            <div class="border border-gray-200 rounded-xl overflow-hidden bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F8F9FA] border-b border-gray-200">
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">Januari</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">Februari</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">Maret</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">April</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">Mei</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">Juni</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">Juli</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">Agustus</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">September</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">Oktober</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">November</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">Desember</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">Form RKA</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">Tahun RKA</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap">Akun GL</th>
                                <th scope="col" class="py-3 px-3.5 text-xs font-semibold text-gray-400 whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs sm:text-[13px] text-gray-800">
                            @forelse($items as $row)
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $row['januari'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $row['februari'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $row['maret'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $row['april'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $row['mei'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $row['juni'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $row['juli'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $row['agustus'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $row['september'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $row['oktober'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $row['november'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $row['desember'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $row['form_rka'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $row['tahun_rka'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $row['akun_gl'] }}
                                    </td>
                                    <td class="py-3.5 px-3.5 whitespace-nowrap text-center">
                                        <div class="relative inline-block text-left action-menu-wrapper"
                                             data-asset="{{ $row['asset_number'] }}">
                                            <button
                                                type="button"
                                                class="action-menu-btn flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition cursor-pointer"
                                                title="Aksi"
                                            >
                                                <x-icon name="dots-vertical" class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="16" class="text-center py-8 text-gray-400">
                                        Tidak ada data laporan yang tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>

    {{-- Global Dropdown Menu Aksi (Diperbesar 1.5x) --}}
    <div id="global-action-dropdown" class="hidden fixed z-[9999] w-[155px] sm:w-[165px] rounded-2xl bg-white border border-gray-100 shadow-[0_10px_35px_rgba(0,0,0,0.14)] p-2 sm:p-2.5 flex flex-col gap-1">
        <a id="dd-lihat" href="#" class="flex items-center gap-2.5 px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition">
            <x-icon name="icon-lihat" class="w-5 h-5 text-gray-500 shrink-0" />
            <span>Lihat</span>
        </a>
        <a id="dd-edit" href="#" class="flex items-center gap-2.5 px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition">
            <x-icon name="edit" class="w-5 h-5 text-gray-500 shrink-0" />
            <span>Edit</span>
        </a>
        <form id="dd-delete-form" method="POST" onsubmit="return confirm('Hapus aset ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 text-xs sm:text-sm font-semibold text-[#EF4444] hover:bg-red-50 rounded-xl transition cursor-pointer">
                <x-icon name="delete" class="w-5 h-5 text-[#EF4444] shrink-0" />
                <span>Hapus</span>
            </button>
        </form>
    </div>

    <script>
        (function () {
            const dropdown     = document.getElementById('global-action-dropdown');
            const ddLihat      = document.getElementById('dd-lihat');
            const ddEdit       = document.getElementById('dd-edit');
            const ddDeleteForm = document.getElementById('dd-delete-form');

            const routes = {
                detail: (id) => `/asset/${id}`,
                edit:   (id) => `/laporan/${id}/edit`,
                delete: (id) => `/admin/assets/${id}`,
            };

            @foreach($items as $row)
            routes['detail_{{ $row['asset_number'] }}'] = '{{ route('asset.detail', $row['asset_number']) }}';
            routes['edit_{{ $row['asset_number'] }}']   = '{{ route('laporan.edit', $row['asset_number']) }}';
            routes['delete_{{ $row['asset_number'] }}'] = '{{ route('admin.assets.destroy', $row['asset_number']) }}';
            @endforeach

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.action-menu-btn');

                if (btn) {
                    e.stopPropagation();

                    const wrapper = btn.closest('.action-menu-wrapper');
                    const assetId = wrapper.dataset.asset;
                    const rect    = btn.getBoundingClientRect();
                    const dropW   = 165;

                    let left = rect.right - dropW;
                    let top  = rect.bottom + 6;

                    ddLihat.href        = routes[`detail_${assetId}`] || `/asset/${assetId}`;
                    ddEdit.href         = routes[`edit_${assetId}`] || `/laporan/${assetId}/edit`;
                    ddDeleteForm.action = routes[`delete_${assetId}`] || `/admin/assets/${assetId}`;

                    if (!dropdown.classList.contains('hidden') && dropdown.dataset.open === assetId) {
                        dropdown.classList.add('hidden');
                        dropdown.dataset.open = '';
                        return;
                    }

                    dropdown.style.top    = top + 'px';
                    dropdown.style.left   = left + 'px';
                    dropdown.dataset.open = assetId;
                    dropdown.classList.remove('hidden');
                } else if (!e.target.closest('#global-action-dropdown')) {
                    dropdown.classList.add('hidden');
                    dropdown.dataset.open = '';
                }
            });

            document.addEventListener('scroll', function (e) {
                if (e.target && e.target.closest && e.target.closest('#global-action-dropdown')) {
                    return;
                }
                dropdown.classList.add('hidden');
                dropdown.dataset.open = '';
            }, true);
        })();
    </script>

</body>

</html>
