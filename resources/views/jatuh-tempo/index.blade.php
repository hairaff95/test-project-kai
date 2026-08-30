<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jatuh Tempo — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-[#F6F7F9] font-sans antialiased text-gray-900 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between">

    {{-- Top Navbar --}}
    <x-navbar active="due-dates" />

    {{-- Main Content --}}
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-6 pb-24 lg:pb-8 flex flex-col gap-4 sm:gap-5">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0">
            <h1 class="text-2xl sm:text-[30px] font-bold tracking-tight text-gray-950">
                Jatuh Tempo
            </h1>

            {{-- Header Action Buttons --}}
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <button id="btn-filter-jt" type="button" class="flex items-center gap-2 rounded-xl bg-[#0066FF] hover:bg-blue-700 px-4 py-2 text-sm font-semibold text-white shadow-xs transition cursor-pointer">
                    <x-icon name="filter-icon" class="w-4 h-4 text-white" />
                    <span>Filter</span>
                </button>

                <a href="{{ route('due-dates.index') }}" class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 shadow-xs transition cursor-pointer" title="Reset">
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
                        id="search-jt"
                        type="text"
                        placeholder="Search"
                        class="w-full h-full pl-9 pr-3 py-2 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#0066FF] text-gray-700 placeholder-gray-400 transition"
                    >
                </div>

                {{-- Filter Nama Penyewa --}}
                @php
                    $tenantList = $contracts->map(fn($c) => $c->tenant?->fullname)->filter()->unique()->values();
                @endphp
                <div class="relative custom-filter-container">
                    <button type="button" class="filter-dropdown-btn inline-flex items-center h-[38px] sm:h-[40px] bg-white border border-gray-200 hover:border-gray-300 rounded-xl px-3.5 py-2 transition cursor-pointer">
                        <span id="label-penyewa" class="text-gray-400 font-normal text-xs sm:text-sm select-none">Nama Penyewa</span>
                        <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 ml-2 pointer-events-none" />
                    </button>
                    <div class="filter-dropdown-menu hidden absolute left-0 top-full mt-1.5 z-[100] min-w-[180px] max-h-[280px] overflow-y-auto rounded-2xl bg-white border border-gray-100 shadow-[0_10px_35px_rgba(0,0,0,0.14)] p-2 sm:p-2.5 flex flex-col gap-1">
                        <button type="button" onclick="filterJtClient('penyewa', '', 'Nama Penyewa')" class="flex items-center justify-between w-full px-3 py-2 text-xs sm:text-sm font-semibold bg-blue-50 text-[#0066FF] rounded-xl transition text-left cursor-pointer">
                            <span>Semua Penyewa</span>
                        </button>
                        @foreach($tenantList as $t)
                            <button type="button" onclick="filterJtClient('penyewa', '{{ $t }}', '{{ $t }}')" class="flex items-center justify-between w-full px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition text-left cursor-pointer">
                                <span>{{ $t }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Filter Status Customer (Dinamis dari database) --}}
                <div class="relative custom-filter-container">
                    <button type="button" class="filter-dropdown-btn inline-flex items-center h-[38px] sm:h-[40px] bg-white border border-gray-200 hover:border-gray-300 rounded-xl px-3.5 py-2 transition cursor-pointer">
                        <span id="label-status" class="text-gray-400 font-normal text-xs sm:text-sm select-none">Status Customer</span>
                        <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 ml-2 pointer-events-none" />
                    </button>
                    <div class="filter-dropdown-menu hidden absolute left-0 top-full mt-1.5 z-[100] min-w-[175px] max-h-[280px] overflow-y-auto rounded-2xl bg-white border border-gray-100 shadow-[0_10px_35px_rgba(0,0,0,0.14)] p-2 sm:p-2.5 flex flex-col gap-1">
                        <button type="button" onclick="filterJtClient('status', '', 'Status Customer')" class="flex items-center justify-between w-full px-3 py-2 text-xs sm:text-sm font-semibold bg-blue-50 text-[#0066FF] rounded-xl transition text-left cursor-pointer">
                            <span>Semua Status</span>
                        </button>
                        @foreach($statusCustomerOptions as $opt)
                            <button type="button" onclick="filterJtClient('status', '{{ $opt }}', '{{ $opt }}')" class="flex items-center justify-between w-full px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition text-left cursor-pointer">
                                <span>{{ $opt }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Filter Nilai Kontrak --}}
                <div class="relative custom-filter-container">
                    <button type="button" class="filter-dropdown-btn inline-flex items-center h-[38px] sm:h-[40px] bg-white border border-gray-200 hover:border-gray-300 rounded-xl px-3.5 py-2 transition cursor-pointer">
                        <span id="label-nilai" class="text-gray-400 font-normal text-xs sm:text-sm select-none">Nilai Kontrak</span>
                        <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 ml-2 pointer-events-none" />
                    </button>
                    <div class="filter-dropdown-menu hidden absolute left-0 top-full mt-1.5 z-[100] min-w-[180px] max-h-[280px] overflow-y-auto rounded-2xl bg-white border border-gray-100 shadow-[0_10px_35px_rgba(0,0,0,0.14)] p-2 sm:p-2.5 flex flex-col gap-1">
                        <button type="button" onclick="filterJtClient('nilai', '', 'Nilai Kontrak')" class="flex items-center justify-between w-full px-3 py-2 text-xs sm:text-sm font-semibold bg-blue-50 text-[#0066FF] rounded-xl transition text-left cursor-pointer">
                            <span>Semua Nilai Kontrak</span>
                        </button>
                        <button type="button" onclick="filterJtClient('nilai', 'lt_50jt', '< Rp 50 jt')" class="flex items-center justify-between w-full px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition text-left cursor-pointer">
                            <span>< Rp 50 jt</span>
                        </button>
                        <button type="button" onclick="filterJtClient('nilai', 'gt_50jt', '> Rp 50 jt')" class="flex items-center justify-between w-full px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition text-left cursor-pointer">
                            <span>> Rp 50 jt</span>
                        </button>
                        <button type="button" onclick="filterJtClient('nilai', 'gt_100jt', '> Rp 100 jt')" class="flex items-center justify-between w-full px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition text-left cursor-pointer">
                            <span>> Rp 100 jt</span>
                        </button>
                        <button type="button" onclick="filterJtClient('nilai', 'gt_500jt', '> Rp 500 jt')" class="flex items-center justify-between w-full px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition text-left cursor-pointer">
                            <span>> Rp 500 jt</span>
                        </button>
                    </div>
                </div>

                {{-- Filter Semua Jenis Aset --}}
                <div class="relative custom-filter-container">
                    <button type="button" class="filter-dropdown-btn inline-flex items-center h-[38px] sm:h-[40px] bg-white border border-gray-200 hover:border-gray-300 rounded-xl px-3.5 py-2 transition cursor-pointer">
                        <span id="label-jenis" class="text-gray-400 font-normal text-xs sm:text-sm select-none">Semua Jenis Aset</span>
                        <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 ml-2 pointer-events-none" />
                    </button>
                    <div class="filter-dropdown-menu hidden absolute left-0 top-full mt-1.5 z-[100] min-w-[180px] max-h-[280px] overflow-y-auto rounded-2xl bg-white border border-gray-100 shadow-[0_10px_35px_rgba(0,0,0,0.14)] p-2 sm:p-2.5 flex flex-col gap-1">
                        <button type="button" onclick="filterJtClient('jenis', '', 'Semua Jenis Aset')" class="flex items-center justify-between w-full px-3 py-2 text-xs sm:text-sm font-semibold bg-blue-50 text-[#0066FF] rounded-xl transition text-left cursor-pointer">
                            <span>Semua Jenis Aset</span>
                        </button>
                        @foreach($jenisAssetOptions as $opt)
                            <button type="button" onclick="filterJtClient('jenis', '{{ $opt }}', '{{ $opt }}')" class="flex items-center justify-between w-full px-3 py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition text-left cursor-pointer">
                                <span>{{ $opt }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Table Wrapper Ber-Stroke --}}
            <div class="border border-gray-200 rounded-xl overflow-hidden bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F8F9FA] border-b border-gray-200">
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">No Aset</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Nama Penyewa</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Brand</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Selesai Kontrak</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Selesai Kontrak Baru</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Sisa Masa Sewa</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">SPV</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">Keterangan</th>
                                <th scope="col" class="py-3 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs sm:text-[13px] text-gray-800">
                            @forelse($contracts as $item)
                                @php
                                    $penyewa = $item->tenant?->fullname ?? $item->tenant?->name ?? 'Drs. Bambang Sudarsono';
                                    $brand = $item->tenant?->brand ?? 'Apotek K-24';
                                    $statusCust = $item->tenant?->status_customer ?? 'Aktif';
                                    $jenisAset = $item->asset?->jenis_asset ?? 'Tanah';
                                    $selesaiLama = $item->end_datetime ? \Carbon\Carbon::parse($item->end_datetime)->format('d/m/Y') : '10/01/2026';
                                    $selesaiBaru = $item->end_datetime_baru ? \Carbon\Carbon::parse($item->end_datetime_baru)->format('d/m/Y') : '10/01/2027';
                                @endphp
                                <tr class="hover:bg-gray-50/60 transition-colors"
                                    data-penyewa="{{ strtolower($penyewa) }}"
                                    data-status="{{ strtolower($statusCust) }}"
                                    data-jenis="{{ strtolower($jenisAset) }}"
                                    data-price="{{ (float)($item->price ?? 0) }}"
                                >
                                    <td class="py-3.5 px-4 font-normal text-gray-900 whitespace-nowrap">
                                        {{ $item->asset_number ?? 'AST-SMG-PCL-001' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-900 font-medium whitespace-nowrap">
                                        {{ $penyewa }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $brand }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $selesaiLama }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $selesaiBaru }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $item->contract_duration ?? '1245417' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $item->spv_name ?? 'Sales Executive Area 1 Pekalongan' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap font-normal">
                                        {{ $item->keterangan ?? 'RKA' }}
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                        <div class="relative inline-block text-left action-menu-wrapper"
                                             data-asset="{{ $item->asset_number }}">
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
                                    <td colspan="9" class="text-center py-8 text-gray-400">
                                        Tidak ada data jatuh tempo yang tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>

    {{-- Global Dropdown Menu Aksi --}}
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
                edit:   (id) => `/jatuh-tempo/${id}/edit`,
                delete: (id) => `/admin/assets/${id}`,
            };

            @foreach($contracts as $item)
            routes['detail_{{ $item->asset_number }}'] = '{{ route('asset.detail', $item->asset_number) }}';
            routes['edit_{{ $item->asset_number }}']   = '{{ route('due-dates.edit', $item->asset_number) }}';
            routes['delete_{{ $item->asset_number }}'] = '{{ route('admin.assets.destroy', $item->asset_number) }}';
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
                    ddEdit.href         = routes[`edit_${assetId}`] || `/jatuh-tempo/${assetId}/edit`;
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

            // Filter state
            const filters = { search: '', penyewa: '', status: '', nilai: '', jenis: '' };

            window.filterJtClient = function (type, value, label) {
                filters[type] = value;

                if (type === 'penyewa') {
                    const lbl = document.getElementById('label-penyewa');
                    lbl.textContent = value ? label : 'Nama Penyewa';
                    lbl.className = value ? 'text-gray-800 font-semibold text-xs sm:text-sm select-none' : 'text-gray-400 font-normal text-xs sm:text-sm select-none';
                } else if (type === 'status') {
                    const lbl = document.getElementById('label-status');
                    lbl.textContent = value ? label : 'Status Customer';
                    lbl.className = value ? 'text-gray-800 font-semibold text-xs sm:text-sm select-none' : 'text-gray-400 font-normal text-xs sm:text-sm select-none';
                } else if (type === 'nilai') {
                    const lbl = document.getElementById('label-nilai');
                    lbl.textContent = value ? label : 'Nilai Kontrak';
                    lbl.className = value ? 'text-gray-800 font-semibold text-xs sm:text-sm select-none' : 'text-gray-400 font-normal text-xs sm:text-sm select-none';
                } else if (type === 'jenis') {
                    const lbl = document.getElementById('label-jenis');
                    lbl.textContent = value ? label : 'Semua Jenis Aset';
                    lbl.className = value ? 'text-gray-800 font-semibold text-xs sm:text-sm select-none' : 'text-gray-400 font-normal text-xs sm:text-sm select-none';
                }

                // Close menus
                document.querySelectorAll('.filter-dropdown-menu').forEach(m => m.classList.add('hidden'));

                // Apply client-side row filtering
                const rows = document.querySelectorAll('tbody tr[data-penyewa]');
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    const rowPenyewa = (row.dataset.penyewa || '').toLowerCase();
                    const rowStatus = (row.dataset.status || '').toLowerCase();
                    const rowJenis = (row.dataset.jenis || '').toLowerCase();
                    const rowPrice = parseFloat(row.dataset.price || '0');

                    const matchSearch = !filters.search || text.includes(filters.search.toLowerCase());
                    const matchPenyewa = !filters.penyewa || rowPenyewa.includes(filters.penyewa.toLowerCase());
                    const matchStatus = !filters.status || rowStatus === filters.status.toLowerCase();
                    const matchJenis = !filters.jenis || rowJenis === filters.jenis.toLowerCase();

                    let matchNilai = true;
                    if (filters.nilai === 'lt_50jt') matchNilai = rowPrice < 50000000;
                    else if (filters.nilai === 'gt_50jt') matchNilai = rowPrice > 50000000;
                    else if (filters.nilai === 'gt_100jt') matchNilai = rowPrice > 100000000;
                    else if (filters.nilai === 'gt_500jt') matchNilai = rowPrice > 500000000;

                    if (matchSearch && matchPenyewa && matchStatus && matchJenis && matchNilai) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            };

            const searchInput = document.getElementById('search-jt');
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    filters.search = this.value;
                    filterJtClient('search', this.value, '');
                });
            }

            document.addEventListener('click', function (e) {
                const filterBtn = e.target.closest('.filter-dropdown-btn');
                const allFilterMenus = document.querySelectorAll('.filter-dropdown-menu');

                if (filterBtn) {
                    e.stopPropagation();
                    const container = filterBtn.closest('.custom-filter-container');
                    const menu = container.querySelector('.filter-dropdown-menu');
                    const wasHidden = menu.classList.contains('hidden');

                    allFilterMenus.forEach(m => m.classList.add('hidden'));
                    dropdown.classList.add('hidden');

                    if (wasHidden) {
                        menu.classList.remove('hidden');
                    }
                } else if (!e.target.closest('.filter-dropdown-menu')) {
                    allFilterMenus.forEach(m => m.classList.add('hidden'));
                }
            });

            document.addEventListener('scroll', function (e) {
                if (e.target && e.target.closest && (e.target.closest('.filter-dropdown-menu') || e.target.closest('#global-action-dropdown'))) {
                    return;
                }
                dropdown.classList.add('hidden');
                dropdown.dataset.open = '';
                document.querySelectorAll('.filter-dropdown-menu').forEach(m => m.classList.add('hidden'));
            }, true);
        })();
    </script>

</body>

</html>
