<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>{{ $asset->asset_block_name }} - KAI Tracker</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Anti-FOUC Theme Script -->
    <script>
        if (localStorage.getItem('kai_theme') === 'dark' || (!('kai_theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    {{-- Leaflet JS & CSS for Google Maps Interactive Preview --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="min-h-screen bg-[#F3F4F6] dark:bg-[#282A2C] font-sans text-[#171717] dark:text-gray-100 transition-colors duration-200">

    <x-navbar active="map" />

    <main class="mx-auto px-4 sm:px-10 py-3 sm:py-5 pb-28 sm:pb-10">

        @php
            $contract  = $asset->contract;
            $financial = $contract?->financial;
            $monthly   = $contract?->monthlySchedules->first();
            $tenant    = $contract?->tenant;
        @endphp

        <div class="grid grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-[325px_1fr]">

            {{-- ===================== LEFT COLUMN ===================== --}}

            <div>

                {{-- BREADCRUMB NAVIGATION --}}
                <div class="mb-3 sm:mb-4 flex items-center gap-1.5 text-[11px] sm:text-[13px] text-gray-400 dark:text-[#9AA0A6]">
                    <a href="{{ route('map') }}" class="hover:text-gray-600 dark:hover:text-gray-200 transition">Peta</a>
                    <span>/</span>
                    <span class="text-[#0066FF] dark:text-[#3B82F6] font-medium">Detail Lanjutan</span>
                </div>

                {{-- MOBILE HEADER & ACTIONS (Tampil sebelum foto pada mobile saja) --}}
                <div class="lg:hidden mb-3.5 flex flex-col gap-2">
                    <div>
                        <h1 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white leading-tight">
                            {{ $asset->asset_block_name }}
                        </h1>
                        <p class="mt-1 text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6] uppercase tracking-wide font-normal">
                            {{ $asset->wilayah_asset ?? 'JL. SLAMET 17 KEL. BENDAN KEC. PEKALONGAN BARAT KAB. PEKALONGAN' }} ({{ $asset->asset_number }})
                        </p>
                    </div>

                    {{-- DESKRIPSI MOBILE --}}
                    <p class="text-xs leading-relaxed text-gray-500 dark:text-[#9AA0A6] font-normal">
                        {{ $asset->description ?? ($contract?->keterangan ?? 'Kawasan strategis dekat pusat niaga Tegal') }}
                    </p>

                    {{-- TOMBOL EDIT & HAPUS MOBILE (Di bawah teks deskripsi) --}}
                    <div class="flex items-center gap-2 pt-0.5">
                        <button
                            type="button"
                            onclick="openEditDrawer()"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-[#0066FF] hover:bg-blue-700 px-3 py-1.5 text-xs font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                        >
                            <x-icon name="icon-edit-detail-peta" class="w-3.5 h-3.5 text-white" />
                            <span>Edit</span>
                        </button>

                        <form action="{{ route('admin.assets.destroy', $asset->asset_number) }}" method="POST" id="form-hapus-aset-mobile">
                            @csrf
                            @method('DELETE')
                            <button
                                type="button"
                                onclick="document.getElementById('modal-hapus').classList.remove('hidden')"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-[#E52500] hover:bg-red-700 px-3 py-1.5 text-xs font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                            >
                                <x-icon name="icon-trash-edit-detail-peta" class="w-3.5 h-3.5 text-white" />
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- FOTO UTAMA --}}
                <div class="flex h-[180px] sm:h-[256px] w-full items-center justify-center overflow-hidden rounded-xl bg-[#d8d8d8] dark:bg-[#34383D] transition-colors">
                    <div class="text-xs sm:text-[13px] text-gray-500 dark:text-[#9AA0A6]">Foto Aset</div>
                </div>

                {{-- THUMBNAIL --}}
                <div class="mt-2.5 sm:mt-3 grid grid-cols-3 gap-2">
                    @for($i = 0; $i < 3; $i++)
                        <div class="flex h-[65px] sm:h-[96px] items-center justify-center overflow-hidden rounded-xl bg-[#d8d8d8] dark:bg-[#34383D] transition-colors"></div>
                    @endfor
                </div>

                {{-- DATA ADMINISTRATIF (Blok Putih / Gelap) --}}
                <div class="mt-3.5 sm:mt-4 rounded-xl sm:rounded-2xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3.5 sm:p-5 shadow-xs transition-colors">

                    <h3 class="mb-2.5 sm:mb-3 text-xs sm:text-[14px] font-semibold text-gray-900 dark:text-white">Data Administratif</h3>

                    <div class="grid grid-cols-2 gap-x-3 sm:gap-x-5 gap-y-2.5 sm:gap-y-3.5">

                        <div>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">GL Akun</p>
                            <p class="mt-0.5 text-[10px] sm:text-[11px] font-semibold text-gray-800 dark:text-white">{{ $financial->gl_account ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">Form RKA</p>
                            <p class="mt-0.5 text-[10px] sm:text-[11px] font-normal text-gray-800 dark:text-white">{{ $financial->form_rka ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">Jenis Pendapatan</p>
                            <p class="mt-0.5 text-[10px] sm:text-[11px] font-normal text-gray-800 dark:text-white">{{ $financial->jenis_pendapatan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">SPV / Sales Executive</p>
                            <p class="mt-0.5 text-[10px] sm:text-[11px] font-normal text-gray-800 dark:text-white">{{ $contract->spv ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">Tahun RKA</p>
                            <p class="mt-0.5 text-[10px] sm:text-[11px] font-normal text-gray-800 dark:text-white">{{ $financial->tahun_rka ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">Ket. Pendapatan</p>
                            <p class="mt-0.5 text-[10px] sm:text-[11px] font-normal leading-[1.4] text-gray-800 dark:text-white">{{ $asset->description ?? ($tenant?->fullname ?? '-') }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">Keterangan</p>
                            <p class="mt-0.5 text-[10px] sm:text-[11px] font-normal leading-[1.4] text-gray-800 dark:text-white">{{ $contract->keterangan ?? '-' }}</p>
                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================== RIGHT COLUMN ===================== --}}

            <div class="pt-0 lg:pt-[36px]">

                {{-- HEADER & DESKRIPSI DESKTOP (Hanya tampil di layar desktop lg+) --}}
                <div class="hidden lg:block">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 sm:gap-4">

                        <div>
                            <h1 class="text-xl sm:text-[30px] font-bold tracking-tight text-gray-950 dark:text-white leading-tight">
                                {{ $asset->asset_block_name }}
                            </h1>
                            <p class="mt-1 text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6] uppercase tracking-wide font-normal">
                                {{ $asset->wilayah_asset ?? 'JL. SLAMET 17 KEL. BENDAN KEC. PEKALONGAN BARAT KAB. PEKALONGAN' }} ({{ $asset->asset_number }})
                            </p>
                        </div>

                        {{-- TOMBOL EDIT & HAPUS (Sejajar di kanan) --}}
                        <div class="flex shrink-0 items-center gap-2">

                            <button
                                type="button"
                                onclick="openEditDrawer()"
                                class="inline-flex items-center gap-1.5 sm:gap-2 rounded-lg sm:rounded-[8px] bg-[#0066FF] hover:bg-blue-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                            >
                                <x-icon name="icon-edit-detail-peta" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" />
                                <span>Edit</span>
                            </button>

                            <form action="{{ route('admin.assets.destroy', $asset->asset_number) }}" method="POST" id="form-hapus-aset">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="button"
                                    onclick="document.getElementById('modal-hapus').classList.remove('hidden')"
                                    class="inline-flex items-center gap-1.5 sm:gap-2 rounded-lg sm:rounded-[8px] bg-[#E52500] hover:bg-red-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                                >
                                    <x-icon name="icon-trash-edit-detail-peta" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" />
                                    <span>Hapus</span>
                                </button>
                            </form>

                        </div>

                    </div>

                    {{-- DESKRIPSI --}}
                    <p class="mt-2.5 sm:mt-4 text-xs sm:text-[13px] leading-relaxed text-gray-500 dark:text-[#9AA0A6] max-w-[850px] font-normal">
                        {{ $asset->description ?? ($contract?->keterangan ?? 'Lorem ipsum dolor sit amet consectetur. Nisi vitae dolor lectus velit enim lorem. Nam mauris non egestas vitae blandit ultrices hendrerit nunc donec. Amet tellus tristique tortor fringilla enim vitae at. Ornare fermentum morbi ullamcorper ut tortor ut aenean tellus. Vestibulum suspendisse dapibus orci lectus.') }}
                    </p>
                </div>


                {{-- ============ ALAMAT (Blok Putih / Gelap) ============ --}}

                <div class="mt-3.5 sm:mt-5 rounded-xl sm:rounded-2xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3.5 sm:p-5 shadow-xs transition-colors">
                    <h3 class="mb-2.5 sm:mb-3 text-xs sm:text-[14px] font-semibold text-gray-900 dark:text-white">Alamat</h3>

                    {{-- Mobile View for Alamat --}}
                    <div class="sm:hidden overflow-hidden rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1F2123] divide-y divide-gray-100 dark:divide-white/10 text-[11px]">
                        <div class="flex items-center justify-between px-3 py-2 bg-white dark:bg-[#1F2123]">
                            <span class="text-gray-400 dark:text-[#9AA0A6]">Wilayah Aset</span>
                            <span class="font-medium text-gray-800 dark:text-white text-right">{{ $asset->wilayah_asset }}</span>
                        </div>
                        <div class="flex items-center justify-between px-3 py-2 bg-white dark:bg-[#1F2123]">
                            <span class="text-gray-400 dark:text-[#9AA0A6]">Jenis Aset</span>
                            <span class="font-medium text-gray-800 dark:text-white text-right">{{ $asset->jenis_asset }}</span>
                        </div>
                        <div class="flex items-center justify-between px-3 py-2 bg-white dark:bg-[#1F2123]">
                            <span class="text-gray-400 dark:text-[#9AA0A6]">Stasiun</span>
                            <span class="font-medium text-gray-800 dark:text-white text-right">{{ $asset->stasiun }}</span>
                        </div>
                        <div class="flex items-center justify-between px-3 py-2 bg-white dark:bg-[#1F2123]">
                            <span class="text-gray-400 dark:text-[#9AA0A6]">Luas Area</span>
                            <span class="font-medium text-gray-800 dark:text-white text-right">{{ $asset->size_area_formatted }}</span>
                        </div>
                        <div class="flex items-center justify-between px-3 py-2 bg-white dark:bg-[#1F2123]">
                            <span class="text-gray-400 dark:text-[#9AA0A6]">Jenis Kontrak</span>
                            <span class="font-medium text-gray-800 dark:text-white text-right">{{ $contract?->jenis_kontrak ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between px-3 py-2 bg-white dark:bg-[#1F2123]">
                            <span class="text-gray-400 dark:text-[#9AA0A6]">Peruntukan</span>
                            <span class="font-medium text-gray-800 dark:text-white text-right">{{ $asset->peruntukan }}</span>
                        </div>
                        <div class="flex flex-col gap-0.5 px-3 py-2 bg-white dark:bg-[#1F2123]">
                            <span class="text-gray-400 dark:text-[#9AA0A6]">Alamat Aset</span>
                            <span class="font-medium text-gray-800 dark:text-white leading-snug">{{ $asset->description ?? ($asset->wilayah_asset . ', Stasiun ' . $asset->stasiun) }}</span>
                        </div>
                    </div>

                    {{-- Desktop View for Alamat --}}
                    <div class="hidden sm:block overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1F2123]">
                        <div class="grid grid-cols-3">
                            <div class="flex min-h-[52px] items-center border-b border-r border-gray-200 dark:border-white/10 bg-white dark:bg-[#1F2123]">
                                <div class="w-[50%] bg-white dark:bg-[#1F2123] px-3.5 py-3 text-[11px] text-gray-900 dark:text-[#9AA0A6] font-normal">Wilayah Aset</div>
                                <div class="flex w-[50%] items-center justify-end px-3.5 text-right text-[11px] font-normal text-gray-800 dark:text-white">{{ $asset->wilayah_asset }}</div>
                            </div>

                            <div class="flex min-h-[52px] items-center border-b border-r border-gray-200 dark:border-white/10 bg-white dark:bg-[#1F2123]">
                                <div class="w-[50%] bg-white dark:bg-[#1F2123] px-3.5 py-3 text-[11px] text-gray-900 dark:text-[#9AA0A6] font-normal">Jenis Aset</div>
                                <div class="flex w-[50%] items-center justify-end px-3.5 text-right text-[11px] font-normal text-gray-800 dark:text-white">{{ $asset->jenis_asset }}</div>
                            </div>

                            <div class="row-span-3 flex items-center border-b border-gray-200 dark:border-white/10 bg-white dark:bg-[#1F2123]">
                                <div class="w-[35%] bg-white dark:bg-[#1F2123] px-3.5 py-3 text-[11px] text-gray-900 dark:text-[#9AA0A6] font-normal self-stretch flex items-center border-r border-gray-200 dark:border-white/10">Alamat Aset</div>
                                <div class="flex w-[65%] items-center px-3.5 py-2 text-[11px] leading-[1.5] text-gray-800 dark:text-white font-normal">{{ $asset->description ?? ($asset->wilayah_asset . ', Stasiun ' . $asset->stasiun) }}</div>
                            </div>

                            <div class="flex min-h-[52px] items-center border-b border-r border-gray-200 dark:border-white/10 bg-white dark:bg-[#1F2123]">
                                <div class="w-[50%] bg-white dark:bg-[#1F2123] px-3.5 py-3 text-[11px] text-gray-900 dark:text-[#9AA0A6] font-normal">Stasiun</div>
                                <div class="flex w-[50%] items-center justify-end px-3.5 text-right text-[11px] font-normal text-gray-800 dark:text-white">{{ $asset->stasiun }}</div>
                            </div>

                            <div class="flex min-h-[52px] items-center border-b border-r border-gray-200 dark:border-white/10 bg-white dark:bg-[#1F2123]">
                                <div class="w-[50%] bg-white dark:bg-[#1F2123] px-3.5 py-3 text-[11px] text-gray-900 dark:text-[#9AA0A6] font-normal">Luas Area</div>
                                <div class="flex w-[50%] items-center justify-end px-3.5 text-right text-[11px] font-normal text-gray-800 dark:text-white">{{ $asset->size_area_formatted }}</div>
                            </div>

                            <div class="flex min-h-[52px] items-center border-r border-gray-200 dark:border-white/10 bg-white dark:bg-[#1F2123]">
                                <div class="w-[50%] bg-white dark:bg-[#1F2123] px-3.5 py-3 text-[11px] text-gray-900 dark:text-[#9AA0A6] font-normal">Jenis Kontrak</div>
                                <div class="flex w-[50%] items-center justify-end px-3.5 text-right text-[11px] font-normal text-gray-800 dark:text-white">{{ $contract?->jenis_kontrak ?? '-' }}</div>
                            </div>

                            <div class="flex min-h-[52px] items-center border-r border-gray-200 dark:border-white/10 bg-white dark:bg-[#1F2123]">
                                <div class="w-[50%] bg-white dark:bg-[#1F2123] px-3.5 py-3 text-[11px] text-gray-900 dark:text-[#9AA0A6] font-normal">Peruntukan</div>
                                <div class="flex w-[50%] items-center justify-end px-3.5 text-right text-[11px] font-normal text-gray-800 dark:text-white">{{ $asset->peruntukan }}</div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- ============ DATA FINANSIAL (Blok Putih / Gelap) ============ --}}

                <div class="mt-3.5 sm:mt-5 rounded-xl sm:rounded-2xl border border-gray-200/80 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3.5 sm:p-5 shadow-xs transition-colors">

                    <h3 class="mb-2.5 sm:mb-3 text-xs sm:text-[14px] font-semibold text-gray-900 dark:text-white">Data Finansial</h3>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 sm:gap-x-8 gap-y-2.5 sm:gap-y-4">

                        <div>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">Nilai Kontrak</p>
                            <p class="mt-0.5 sm:mt-1 text-[11px] sm:text-[12px] font-semibold text-gray-900 dark:text-white">{{ $contract?->price_formatted ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">Jumlah Hari</p>
                            <p class="mt-0.5 sm:mt-1 text-[11px] sm:text-[12px] font-normal text-gray-800 dark:text-white">{{ $financial ? number_format($financial->jumlah_hari, 0, ',', '.') . ' hari' : '-' }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">Nilai Per Hari</p>
                            <p class="mt-0.5 sm:mt-1 text-[11px] sm:text-[12px] font-normal text-gray-800 dark:text-white">{{ $financial ? 'Rp ' . number_format($financial->nilai_per_hari, 0, ',', '.') : '-' }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">Hari Berjalan</p>
                            <p class="mt-0.5 sm:mt-1 text-[11px] sm:text-[12px] font-normal text-gray-800 dark:text-white">{{ $financial ? number_format($financial->hari_2026, 0, ',', '.') . ' hari' : '-' }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">Nilai Tahun Berjalan</p>
                            <p class="mt-0.5 sm:mt-1 text-[11px] sm:text-[12px] font-normal text-gray-800 dark:text-white">{{ $financial ? 'Rp ' . number_format($financial->nilai_2026, 0, ',', '.') : '-' }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6]">Total Jan–Des</p>
                            <p class="mt-0.5 sm:mt-1 text-[11px] sm:text-[12px] font-normal text-gray-800 dark:text-white">{{ $financial ? 'Rp ' . number_format($financial->nilai_2026, 0, ',', '.') : '-' }}</p>
                        </div>

                    </div>


                    {{-- NILAI PER BULAN --}}
                    <div class="mt-3.5 sm:mt-5">
                        <p class="mb-2 sm:mb-2.5 text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6] font-normal">Nilai Per Bulan:</p>

                        <div class="overflow-hidden rounded-lg sm:rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1F2123]">
                            <div class="grid grid-cols-2 sm:grid-cols-4">
                                @php
                                    $bulan = [
                                        ['Jan', 'januari'],  ['Apr', 'april'],    ['Jul', 'juli'],     ['Okt', 'oktober'],
                                        ['Feb', 'febuari'],  ['Mei', 'mei'],      ['Agu', 'agustus'],  ['Nov', 'november'],
                                        ['Mar', 'maret'],    ['Jun', 'juni'],     ['Sep', 'september'],['Des', 'desember'],
                                    ];
                                @endphp
                                @foreach($bulan as $idx => [$label, $col])
                                    @php
                                        $isLastRowDesktop = $idx >= 8;
                                        $isLastColDesktop = ($idx % 4) === 3;
                                        $isLastRowMobile  = $idx >= 10;
                                        $isLastColMobile  = ($idx % 2) === 1;
                                    @endphp
                                    <div class="flex border-b sm:border-b-0 {{ !$isLastRowDesktop ? 'sm:border-b' : '' }} {{ !$isLastRowMobile ? 'border-b' : 'border-b-0' }} border-r {{ $isLastColDesktop ? 'sm:border-r-0' : 'sm:border-r' }} {{ $isLastColMobile ? 'border-r-0' : 'border-r' }} border-gray-200 dark:border-white/10 bg-white dark:bg-[#1F2123]">
                                        <div class="w-[38%] sm:w-[35%] bg-white dark:bg-[#1F2123] px-2 sm:px-3 py-1.5 sm:py-2 text-[10px] sm:text-[11px] text-gray-900 dark:text-[#9AA0A6] font-normal border-r border-gray-200 dark:border-white/10">{{ $label }}</div>
                                        <div class="flex flex-1 items-center justify-end px-2 sm:px-3 text-[10px] sm:text-[11px] text-gray-800 dark:text-white font-normal bg-white dark:bg-[#1F2123]">
                                            {{ $monthly ? number_format((float) $monthly->$col, 0, ',', '.') : '-' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </main>


    {{-- SLIDE DRAWER EDIT ASET --}}
    <div id="drawer-edit-backdrop" class="opacity-0 pointer-events-none fixed inset-0 top-16 sm:top-20 z-30 bg-black/20 dark:bg-black/60 backdrop-blur-[1px] transition-opacity duration-300" onclick="closeEditDrawer()"></div>

    <div id="drawer-edit" class="fixed right-0 sm:right-8 lg:right-10 top-14 sm:top-[100px] bottom-0 sm:bottom-8 z-40 w-full sm:w-[420px] max-w-full sm:max-w-[calc(100vw-40px)] rounded-t-2xl sm:rounded-2xl bg-white dark:bg-[#1F2123] border border-gray-100 dark:border-white/10 shadow-[0_20px_60px_rgba(0,0,0,0.18)] dark:shadow-[0_20px_60px_rgba(0,0,0,0.7)] p-4 sm:p-6 flex flex-col justify-between overflow-hidden transform translate-x-[120%] transition-transform duration-300 ease-in-out">
        
        {{-- TABS ATAS --}}
        <div class="flex items-center border-b border-gray-100 dark:border-white/10 pb-2.5 sm:pb-3 gap-3.5 sm:gap-6 text-xs sm:text-[13px] shrink-0">
            <button type="button" id="tab-btn-info" onclick="switchEditTab('info')" class="font-medium text-[#0066FF] dark:text-[#3B82F6] border-b-2 border-[#0066FF] dark:border-[#3B82F6] pb-2 -mb-2.5 sm:-mb-3 transition cursor-pointer">Informasi Aset</button>
            <button type="button" id="tab-btn-admin" onclick="switchEditTab('admin')" class="font-medium text-gray-500 dark:text-white hover:text-gray-800 dark:hover:text-white pb-2 -mb-2.5 sm:-mb-3 transition cursor-pointer">Data Administratif</button>
            <button type="button" id="tab-btn-finansial" onclick="switchEditTab('finansial')" class="font-medium text-gray-500 dark:text-white hover:text-gray-800 dark:hover:text-white pb-2 -mb-2.5 sm:-mb-3 transition cursor-pointer">Data Finansial</button>
        </div>

        {{-- ==================== TAB 1: INFORMASI ASET (3 SUB-PAGES) ==================== --}}
        <div id="tab-content-info" class="edit-tab-container flex-1 flex flex-col overflow-hidden">
            
            {{-- STEP 1: INFORMASI DASAR ASET --}}
            <div id="edit-step-1" class="edit-step-content flex flex-col flex-1 overflow-hidden mt-4">
                {{-- HEADER STEP 1 & CHEVRON NAVIGATION --}}
                <div class="flex items-center justify-between shrink-0 mb-4">
                    <h2 class="text-base sm:text-lg font-medium text-black dark:text-white">Informasi dasar aset</h2>
                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="goToInfoStep(2)" class="flex h-6 w-6 items-center justify-center rounded-[5px] bg-[#7F7F7F] dark:bg-[#383C40] text-white hover:bg-gray-600 dark:hover:bg-[#4A4E54] transition cursor-pointer shadow-xs" title="Lanjut ke bagian 2">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto pr-1 space-y-4 text-left">
                    {{-- Judul Aset --}}
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Judul Aset<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="asset_block_name"
                            value="{{ $asset->asset_block_name }}"
                            class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
                        >
                    </div>

                    {{-- Subjudul Aset --}}
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Subjudul Aset<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="subjudul_aset"
                            value="{{ $asset->wilayah_asset ?? 'JL. SLAMET 17 KEL. BENDAN KEC. PEKALONGAN BARAT KAB. PEKALONGAN' }} ({{ $asset->asset_number }})"
                            class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            required
                        >
                    </div>

                    {{-- Isi Deskripsi --}}
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Isi Deskripsi
                        </label>
                        <textarea
                            name="description"
                            rows="3"
                            class="w-full min-h-[85px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition resize-none leading-relaxed font-normal"
                        >{{ $asset->description ?? ($contract?->keterangan ?? '') }}</textarea>
                    </div>

                    {{-- Wilayah Aset (Background Gelap & Corner Radius 5 & DnD) --}}
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Wilayah Aset<span class="text-red-500">*</span>
                        </label>
                        <div class="dnd-container min-h-[85px] rounded-[5px] border border-gray-200 dark:border-white/10 bg-[#EFEFEF] dark:bg-[#282A2C] p-2.5 flex flex-wrap content-start gap-2 shadow-2xs">
                            <div draggable="true" class="dnd-pill h-8 w-auto inline-flex items-center gap-2 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2.5 sm:px-3 text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                                <x-icon name="icon-drag-n-drop" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                                <span class="font-medium">{{ $asset->wilayah_asset ?? 'Daop 4 Semarang' }}</span>
                                <button type="button" onclick="removeDndPill(this)" class="ml-1 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Tambahkan Kolom Baru (Wilayah) --}}
                    <div>
                        <p class="text-[11px] text-gray-400 dark:text-white mb-1.5 font-medium">Tambahkan Kolom Baru</p>
                        <button type="button" onclick="addNewDndPill(this, 'Wilayah Baru')" class="inline-flex items-center gap-1.5 rounded-[5px] bg-[#A6A6A6] dark:bg-[#383C40] hover:bg-gray-400 dark:hover:bg-[#43484E] border border-transparent dark:border-white/10 px-3 py-1.5 text-xs font-medium text-[#171717] dark:text-white transition cursor-pointer shadow-2xs">
                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                            <span>Tambah Kolom</span>
                        </button>
                    </div>

                    {{-- Jenis Aset (Background Gelap & Corner Radius 5 & DnD) --}}
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Jenis Aset<span class="text-red-500">*</span>
                        </label>
                        <div class="dnd-container min-h-[85px] rounded-[5px] border border-gray-200 dark:border-white/10 bg-[#EFEFEF] dark:bg-[#282A2C] p-2.5 flex flex-wrap content-start gap-2 shadow-2xs">
                            <div draggable="true" class="dnd-pill h-8 w-auto inline-flex items-center gap-2 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2.5 sm:px-3 text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                                <x-icon name="icon-drag-n-drop" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                                <span class="font-medium">Rumah Perusahaan</span>
                                <button type="button" onclick="removeDndPill(this)" class="ml-1 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <div draggable="true" class="dnd-pill h-8 w-auto inline-flex items-center gap-2 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2.5 sm:px-3 text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                                <x-icon name="icon-drag-n-drop" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                                <span class="font-medium">Bangunan Dinas</span>
                                <button type="button" onclick="removeDndPill(this)" class="ml-1 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <div draggable="true" class="dnd-pill h-8 w-auto inline-flex items-center gap-2 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2.5 sm:px-3 text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                                <x-icon name="icon-drag-n-drop" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                                <span class="font-medium">Tanah</span>
                                <button type="button" onclick="removeDndPill(this)" class="ml-1 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Tambahkan Kolom Baru (Jenis) --}}
                    <div>
                        <p class="text-[11px] text-gray-400 dark:text-white mb-1.5 font-medium">Tambahkan Kolom Baru</p>
                        <button type="button" onclick="addNewDndPill(this, 'Jenis Aset Baru')" class="inline-flex items-center gap-1.5 rounded-[5px] bg-[#A6A6A6] dark:bg-[#383C40] hover:bg-gray-400 dark:hover:bg-[#43484E] border border-transparent dark:border-white/10 px-3 py-1.5 text-xs font-medium text-[#171717] dark:text-white transition cursor-pointer shadow-2xs">
                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                            <span>Tambah Kolom</span>
                        </button>
                    </div>
                </div>
            </div>


            {{-- STEP 2: LUAS, ALAMAT, PERUNTUKAN, KONTRAK, STASIUN --}}
            <div id="edit-step-2" class="edit-step-content hidden flex flex-col flex-1 overflow-hidden mt-4">
                {{-- HEADER STEP 2 & CHEVRON NAVIGATION --}}
                <div class="flex items-center justify-between shrink-0 mb-4">
                    <h2 class="text-base sm:text-lg font-medium text-black dark:text-white">Luas Aset<span class="text-red-500">*</span></h2>
                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="goToInfoStep(1)" class="flex h-6 w-6 items-center justify-center rounded-[5px] bg-[#7F7F7F] dark:bg-[#383C40] text-white hover:bg-gray-600 dark:hover:bg-[#4A4E54] transition cursor-pointer shadow-xs" title="Kembali ke bagian 1">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </button>
                        <button type="button" onclick="goToInfoStep(3)" class="flex h-6 w-6 items-center justify-center rounded-[5px] bg-[#7F7F7F] dark:bg-[#383C40] text-white hover:bg-gray-600 dark:hover:bg-[#4A4E54] transition cursor-pointer shadow-xs" title="Lanjut ke bagian 3">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto pr-1 space-y-4 text-left">
                    {{-- Input Luas Aset --}}
                    <div>
                        <input
                            type="text"
                            name="size_area"
                            value="{{ $asset->size_area_formatted ?? '2.462,00 m²' }}"
                            class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Alamat Lengkap Aset --}}
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Alamat Lengkap Aset<span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="full_address"
                            rows="3"
                            class="w-full min-h-[85px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition resize-none leading-relaxed font-normal"
                        >{{ $asset->description ?? 'Jl. Panggung Timur No. 13, Kel. Panggung, Kec. Tegal Timur, Kota Tegal, Jawa Tengah (Lintas Non Op Tegal - Pelabuhan)' }}</textarea>
                    </div>

                    {{-- Peruntukan --}}
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Peruntukan<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="peruntukan"
                            value="{{ $asset->peruntukan ?? 'Gudang Logistik Komersial' }}"
                            class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    {{-- Jenis Kontrak (Background Gelap & Corner Radius 5 & DnD) --}}
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Jenis Kontrak<span class="text-red-500">*</span>
                        </label>
                        <div class="dnd-container min-h-[85px] rounded-[5px] border border-gray-200 dark:border-white/10 bg-[#EFEFEF] dark:bg-[#282A2C] p-2.5 flex flex-wrap content-start gap-2 shadow-2xs">
                            <div draggable="true" class="dnd-pill h-8 w-auto inline-flex items-center gap-2 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2.5 sm:px-3 text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                                <x-icon name="icon-drag-n-drop" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                                <span class="font-medium">Kontrak Pengawasan</span>
                                <button type="button" onclick="removeDndPill(this)" class="ml-1 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <div draggable="true" class="dnd-pill h-8 w-auto inline-flex items-center gap-2 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2.5 sm:px-3 text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                                <x-icon name="icon-drag-n-drop" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                                <span class="font-medium">Kontrak Sewa</span>
                                <button type="button" onclick="removeDndPill(this)" class="ml-1 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Tambahkan Kolom Baru (Kontrak) --}}
                    <div>
                        <p class="text-[11px] text-gray-400 dark:text-white mb-1.5 font-medium">Tambahkan Kolom Baru</p>
                        <button type="button" onclick="addNewDndPill(this, 'Kontrak Baru')" class="inline-flex items-center gap-1.5 rounded-[5px] bg-[#A6A6A6] dark:bg-[#383C40] hover:bg-gray-400 dark:hover:bg-[#43484E] border border-transparent dark:border-white/10 px-3 py-1.5 text-xs font-medium text-[#171717] dark:text-white transition cursor-pointer shadow-2xs">
                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                            <span>Tambah Kolom</span>
                        </button>
                    </div>

                    {{-- Stasiun (Background Gelap & Corner Radius 5 & DnD) --}}
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Stasiun<span class="text-red-500">*</span>
                        </label>
                        <div class="dnd-container min-h-[85px] rounded-[5px] border border-gray-200 dark:border-white/10 bg-[#EFEFEF] dark:bg-[#282A2C] p-2.5 flex flex-wrap content-start gap-2 shadow-2xs">
                            @php
                                $stasiuns = ['Pekalongan', 'Kaliwungu', 'Weleri', 'Batang', 'Ujungnegoro', 'Kendal'];
                            @endphp
                            @foreach($stasiuns as $st)
                                <div draggable="true" class="dnd-pill h-8 w-auto inline-flex items-center gap-2 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2.5 sm:px-3 text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                                    <x-icon name="icon-drag-n-drop" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                                    <span class="font-medium">{{ $st }}</span>
                                    <button type="button" onclick="removeDndPill(this)" class="ml-1 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Tambahkan Kolom Baru (Stasiun) --}}
                    <div>
                        <p class="text-[11px] text-gray-400 dark:text-white mb-1.5 font-medium">Tambahkan Kolom Baru</p>
                        <button type="button" onclick="addNewDndPill(this, 'Stasiun Baru')" class="inline-flex items-center gap-1.5 rounded-[5px] bg-[#A6A6A6] dark:bg-[#383C40] hover:bg-gray-400 dark:hover:bg-[#43484E] border border-transparent dark:border-white/10 px-3 py-1.5 text-xs font-medium text-[#171717] dark:text-white transition cursor-pointer shadow-2xs">
                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                            <span>Tambah Kolom</span>
                        </button>
                    </div>
                </div>
            </div>


            {{-- STEP 3: TAMBAH GAMBAR & KOORDINAT MAPS --}}
            <div id="edit-step-3" class="edit-step-content hidden flex flex-col flex-1 overflow-hidden mt-4">
                {{-- HEADER STEP 3 & CHEVRON NAVIGATION --}}
                <div class="flex items-center justify-between shrink-0 mb-3">
                    <h2 class="text-base sm:text-lg font-medium text-black dark:text-white">Tambah Gambar<span class="text-red-500">*</span></h2>
                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="goToInfoStep(2)" class="flex h-6 w-6 items-center justify-center rounded-[6px] bg-[#7F7F7F] dark:bg-[#383C40] text-white hover:bg-gray-600 dark:hover:bg-[#4A4E54] transition cursor-pointer shadow-xs" title="Kembali ke bagian 2">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </button>
                        <button type="button" disabled class="flex h-6 w-6 items-center justify-center rounded-[6px] bg-[#A6A6A6] dark:bg-[#383C40]/50 text-white cursor-not-allowed opacity-60">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto pr-1 space-y-4 text-left">
                    {{-- Upload Box Dashed (Larger height matching design) --}}
                    <div onclick="document.getElementById('file-upload-input').click()" class="rounded-2xl border-2 border-dashed border-gray-300 dark:border-white/20 bg-transparent hover:bg-gray-50/70 dark:hover:bg-white/5 py-8 px-5 flex flex-col items-center justify-center text-center transition cursor-pointer">
                        <input type="file" id="file-upload-input" class="hidden" accept="image/jpeg,image/png,image/webp,image/jpg" onchange="handleFileUpload(event)" multiple>
                        <x-icon name="icon-upload-gambar" class="w-16 h-16 mb-2.5 text-[#4F4F4F] dark:text-[#9AA0A6]" />
                        <p class="text-xs sm:text-[13px] font-medium text-black dark:text-white">Klik ikon untuk tambah gambar dibawah 10 MB</p>
                        <p class="text-[11px] text-gray-400 dark:text-[#9AA0A6] mt-0.5 font-normal">pilih dalam format JPEG, JPG, PNG, WEBP</p>
                    </div>

                    {{-- Container List Gambar DnD --}}
                    <div id="image-dnd-wrapper" class="space-y-3">
                        {{-- Slot Utama --}}
                        <div>
                            <label class="block text-xs font-medium text-black dark:text-white mb-1.5">Utama</label>
                            <div id="image-slot-utama" class="image-drop-target">
                                {{-- Rendered dynamically by renderImageList() --}}
                            </div>
                        </div>

                        {{-- Grid Gambar Lainnya (2 Kolom) --}}
                        <div id="image-grid-secondary" class="grid grid-cols-2 gap-3 image-drop-target">
                            {{-- Rendered dynamically by renderImageList() --}}
                        </div>
                    </div>

                    {{-- Titik Koordinat G Maps (Google Maps Asli & Sinkronisasi Realtime) --}}
                    <div class="pt-2">
                        <label class="block text-xs sm:text-sm font-medium text-black dark:text-white mb-2">
                            Titik Koordinat G Maps<span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-[140px_1fr] sm:grid-cols-[165px_1fr] gap-3.5 items-center">
                            <div class="h-[145px] sm:h-[160px] w-full rounded-2xl overflow-hidden border border-gray-200 dark:border-white/10 bg-gray-100 dark:bg-[#282A2C] relative shadow-2xs">
                                <div id="edit-map-preview" class="w-full h-full z-0"></div>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-black dark:text-white mb-1">Latitude</label>
                                    <input
                                        type="text"
                                        id="input-edit-latitude"
                                        name="latitude"
                                        value="{{ $asset->latitude ?? '-6.88856' }}"
                                        oninput="handleCoordinateInputChange()"
                                        placeholder="-6.88856"
                                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                    >
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-black dark:text-white mb-1">Longtitude</label>
                                    <input
                                        type="text"
                                        id="input-edit-longitude"
                                        name="longitude"
                                        value="{{ $asset->longitude ?? '109.67530' }}"
                                        oninput="handleCoordinateInputChange()"
                                        placeholder="109.67530"
                                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="flex justify-end pt-3">
                        <button
                            type="button"
                            onclick="closeEditDrawer()"
                            class="inline-flex items-center gap-2 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 px-6 py-2.5 text-sm font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                        >
                            <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            <span>Simpan</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>


        {{-- ==================== TAB 2: DATA ADMINISTRATIF ==================== --}}
        <div id="tab-content-admin" class="edit-tab-container hidden flex-1 flex flex-col overflow-hidden mt-4">
            {{-- HEADER DATA ADMINISTRATIF & TOMBOL SIMPAN --}}
            <div class="flex items-center justify-between shrink-0 mb-4">
                <h2 class="text-base sm:text-lg font-medium text-black dark:text-white">Data administratif</h2>
                <button
                    type="button"
                    onclick="closeEditDrawer()"
                    class="inline-flex items-center gap-1.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 px-4 py-1.5 text-xs sm:text-sm font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Simpan</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto pr-1 space-y-3.5 text-left">
                {{-- GL Akun --}}
                <div>
                    <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                        GL Akun<span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="gl_account"
                        value="{{ $financial->gl_account ?? '411101 - Sewa Tanah Row' }}"
                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                    >
                </div>

                {{-- Form RKA --}}
                <div>
                    <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                        Form RKA<span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="form_rka"
                        value="{{ $financial->form_rka ?? 'RKA' }}"
                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                    >
                </div>

                {{-- Row 2 Cols: Tahun RKA & Sales Eksekutif/SPV --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Tahun RKA<span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                id="input-tahun-rka"
                                name="tahun_rka"
                                value="{{ $financial->tahun_rka ?? '2026' }}"
                                class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-8 pr-3 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            >
                            <button
                                type="button"
                                onclick="openCalendarPicker(event, 'input-tahun-rka')"
                                class="absolute left-2.5 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-600 transition cursor-pointer"
                            >
                                <x-icon name="icon-calendar" class="h-3.5 w-3.5 text-[#0066FF]" />
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Sales Eksekutif/SPV<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="spv"
                            value="{{ $contract->spv ?? 'SPV Komersial & Non Angkutan Daop 4' }}"
                            class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>
                </div>

                {{-- Jenis Pendapatan --}}
                <div>
                    <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                        Jenis Pendapatan<span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="jenis_pendapatan"
                        value="{{ $financial->jenis_pendapatan ?? 'Row' }}"
                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                    >
                </div>

                {{-- Keterangan Pendapatan --}}
                <div>
                    <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                        Keterangan Pendapatan<span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="ket_pendapatan"
                        value="{{ $asset->description ?? ($tenant?->fullname ?? 'Aset lahan pergudangan sisi timur stasiun Poncol') }}"
                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                    >
                </div>

                {{-- Keterangan (Background Gelap & Corner Radius 5 & DnD) --}}
                <div>
                    <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                        Keterangan<span class="text-red-500">*</span>
                    </label>
                    <div class="dnd-container min-h-[85px] rounded-[5px] border border-gray-200 dark:border-white/10 bg-[#EFEFEF] dark:bg-[#282A2C] p-2.5 flex flex-wrap content-start gap-2 shadow-2xs">
                        <div draggable="true" class="dnd-pill h-8 w-auto inline-flex items-center gap-2 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2.5 sm:px-3 text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">Non RKA</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-1 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <div draggable="true" class="dnd-pill h-8 w-auto inline-flex items-center gap-2 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2.5 sm:px-3 text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                            <x-icon name="icon-drag-n-drop" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                            <span class="font-medium">RKA</span>
                            <button type="button" onclick="removeDndPill(this)" class="ml-1 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Tambahkan Kolom Baru (Keterangan) --}}
                <div>
                    <p class="text-[11px] text-gray-400 dark:text-white mb-1.5 font-medium">Tambahkan Kolom Baru</p>
                    <button type="button" onclick="addNewDndPill(this, 'Keterangan Baru')" class="inline-flex items-center gap-1.5 rounded-[5px] bg-[#A6A6A6] dark:bg-[#383C40] hover:bg-gray-400 dark:hover:bg-[#43484E] border border-transparent dark:border-white/10 px-3 py-1.5 text-xs font-medium text-[#171717] dark:text-white transition cursor-pointer shadow-2xs">
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                        <span>Tambah Kolom</span>
                    </button>
                </div>
            </div>
        </div>


        {{-- ==================== TAB 3: DATA FINANSIAL ==================== --}}
        <div id="tab-content-finansial" class="edit-tab-container hidden flex-1 flex flex-col overflow-hidden mt-4">
            {{-- HEADER DATA FINANSIAL & TOMBOL SIMPAN --}}
            <div class="flex items-center justify-between shrink-0 mb-4">
                <h2 class="text-base sm:text-lg font-medium text-black dark:text-white">Data Finansial</h2>
                <button
                    type="button"
                    onclick="closeEditDrawer()"
                    class="inline-flex items-center gap-1.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 px-4 py-1.5 text-xs sm:text-sm font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Simpan</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto pr-1 space-y-3.5 text-left">
                {{-- Row 1: Nilai Kontrak & Total Jan-Des --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Nilai Kontrak<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="price"
                            value="{{ $contract?->price_formatted ?? 'Rp 970.028.000' }}"
                            class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 py-1.5 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Total Jan–Des<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="total_jandes"
                            value="Rp 323.047.645"
                            class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 py-1.5 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>
                </div>

                {{-- Row 2: Jumlah Hari & Nilai Per Hari --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Jumlah Hari<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="jumlah_hari"
                            value="{{ $financial ? number_format($financial->jumlah_hari, 0, ',', '.') . ' hari' : '1.096 hari' }}"
                            class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 py-1.5 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Nilai Per Hari<span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nilai_per_hari"
                            value="{{ $financial ? 'Rp ' . number_format($financial->nilai_per_hari, 0, ',', '.') : 'Rp 294.717' }}"
                            class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 py-1.5 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                        >
                    </div>
                </div>

                {{-- Row 3: Hari Berjalan & Nilai Tahun Berjalan --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Hari Berjalan<span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                id="input-hari-berjalan"
                                name="hari_berjalan"
                                value="{{ $financial ? number_format($financial->hari_2026, 0, ',', '.') . ' hari' : '365 hari' }}"
                                class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-8 pr-3 py-1.5 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            >
                            <button
                                type="button"
                                onclick="openCalendarPicker(event, 'input-hari-berjalan')"
                                class="absolute left-2.5 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-600 transition cursor-pointer"
                            >
                                <x-icon name="icon-calendar" class="h-3.5 w-3.5 text-[#0066FF]" />
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-black dark:text-white mb-1.5">
                            Nilai Tahun Berjalan<span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                id="input-nilai-tahun-berjalan"
                                name="nilai_tahun_berjalan"
                                value="{{ $financial ? 'Rp ' . number_format($financial->nilai_2026, 0, ',', '.') : 'Rp 323.047.645' }}"
                                class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-8 pr-3 py-1.5 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                            >
                            <button
                                type="button"
                                onclick="openCalendarPicker(event, 'input-nilai-tahun-berjalan')"
                                class="absolute left-2.5 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-600 transition cursor-pointer"
                            >
                                <x-icon name="icon-calendar" class="h-3.5 w-3.5 text-[#0066FF]" />
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Nilai Per Bulan --}}
                <div class="pt-2">
                    <h3 class="text-xs sm:text-sm font-medium text-black dark:text-white mb-2.5">Nilai Per Bulan</h3>

                    @php
                        $months1 = [
                            ['Januari', 'januari', '26.920.637'],
                            ['Februari', 'febuari', '26.920.637'],
                            ['Maret', 'maret', '26.920.637'],
                            ['April', 'april', '26.920.637'],
                            ['Mei', 'mei', '26.920.637'],
                            ['Juni', 'juni', '26.920.637'],
                        ];
                        $months2 = [
                            ['Juli', 'juli', '26.920.637'],
                            ['Agu', 'agustus', '26.920.637'],
                            ['September', 'september', '26.920.637'],
                            ['Oktober', 'oktober', '26.920.637'],
                            ['November', 'november', '26.920.637'],
                            ['Desember', 'desember', '26.920.637'],
                        ];
                    @endphp

                    <div class="grid grid-cols-2 gap-3">
                        {{-- Kolom Kiri: Jan - Jun --}}
                        <div class="space-y-2.5">
                            @foreach($months1 as [$label, $col, $default])
                                <div>
                                    <label class="block text-[11px] text-gray-500 dark:text-[#9AA0A6] mb-1 font-medium">{{ $label }}</label>
                                    <input
                                        type="text"
                                        name="{{ $col }}"
                                        value="{{ $monthly ? number_format((float)$monthly->$col, 0, ',', '.') : $default }}"
                                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 py-1.5 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                    >
                                </div>
                            @endforeach
                        </div>

                        {{-- Kolom Kanan: Jul - Des --}}
                        <div class="space-y-2.5">
                            @foreach($months2 as [$label, $col, $default])
                                <div>
                                    <label class="block text-[11px] text-gray-500 dark:text-[#9AA0A6] mb-1 font-medium">{{ $label }}</label>
                                    <input
                                        type="text"
                                        name="{{ $col }}"
                                        value="{{ $monthly ? number_format((float)$monthly->$col, 0, ',', '.') : $default }}"
                                        class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3 py-1.5 text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- POPUP CALENDAR PICKER (Dropdown Style) --}}
    <div id="popup-calendar-picker" class="hidden absolute z-[150] w-[290px] rounded-2xl bg-white dark:bg-[#1F2123] border border-gray-100 dark:border-white/10 shadow-[0_15px_40px_rgba(0,0,0,0.16)] dark:shadow-[0_15px_40px_rgba(0,0,0,0.7)] p-4 select-none">
        {{-- Header: < [Jun ⌵] [2025 ⌵] > --}}
        <div class="flex items-center justify-between mb-3.5">
            <button type="button" onclick="calPrevMonth()" class="p-1 text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white transition cursor-pointer">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <div class="flex items-center gap-2">
                <div class="inline-flex items-center gap-1 border border-gray-200 dark:border-white/10 rounded-xl px-2.5 py-1 text-xs sm:text-sm font-semibold text-gray-800 dark:text-white">
                    <span id="cal-month-name">Jun</span>
                    <svg class="h-3.5 w-3.5 text-gray-500 dark:text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </div>
                <div class="inline-flex items-center gap-1 border border-gray-200 dark:border-white/10 rounded-xl px-2.5 py-1 text-xs sm:text-sm font-semibold text-gray-800 dark:text-white">
                    <span id="cal-year-val">2025</span>
                    <svg class="h-3.5 w-3.5 text-gray-500 dark:text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </div>
            </div>
            <button type="button" onclick="calNextMonth()" class="p-1 text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white transition cursor-pointer">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>

        {{-- Weekdays header: Ming Sen Sel Rab Kam Jum Sa --}}
        <div class="grid grid-cols-7 text-center text-xs font-semibold text-slate-500 dark:text-[#9AA0A6] mb-2">
            <div>Ming</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sa</div>
        </div>

        {{-- Days grid --}}
        <div id="cal-days-grid" class="grid grid-cols-7 text-center text-xs font-medium gap-y-1">
            {{-- Rendered via JS --}}
        </div>
    </div>


    {{-- MODAL KONFIRMASI HAPUS --}}
    <div id="modal-hapus" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 dark:bg-black/70 backdrop-blur-sm">
        <div class="w-[380px] rounded-2xl bg-white dark:bg-[#1F2123] border border-gray-100 dark:border-white/10 p-6 shadow-xl dark:shadow-[0_20px_50px_rgba(0,0,0,0.8)]">

            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                <x-icon name="trash-line" class="w-6 h-6 text-red-600 dark:text-red-400" />
            </div>

            <h3 class="mb-1 text-[16px] font-semibold text-gray-900 dark:text-white">Hapus Aset</h3>
            <p class="mb-6 text-[13px] text-gray-500 dark:text-[#9AA0A6]">
                Yakin ingin menghapus <span class="font-semibold text-gray-700 dark:text-white">{{ $asset->asset_block_name }}</span>?
                Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('modal-hapus').classList.add('hidden')"
                    class="flex-1 rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#2D3034] py-2.5 text-[13px] font-semibold text-gray-700 dark:text-white transition hover:bg-gray-50 dark:hover:bg-white/10 cursor-pointer">
                    Batal
                </button>
                <button type="button" onclick="document.getElementById('form-hapus-aset').submit()"
                    class="flex-1 rounded-xl bg-red-500 hover:bg-red-600 py-2.5 text-[13px] font-semibold text-white transition cursor-pointer">
                    Ya, Hapus
                </button>
            </div>

        </div>
    </div>

    {{-- SCRIPT DRAWER EDIT & CALENDAR PICKER & DRAG AND DROP --}}
    <script>
        let currentInfoStep = 1;
        let currentTab = 'info';

        // Tab switcher
        function switchEditTab(tab) {
            currentTab = tab;
            const tabs = ['info', 'admin', 'finansial'];

            tabs.forEach(t => {
                const btn = document.getElementById(`tab-btn-${t}`);
                const content = document.getElementById(`tab-content-${t}`);

                if (t === tab) {
                    btn.className = "font-medium text-[#0066FF] dark:text-[#3B82F6] border-b-2 border-[#0066FF] dark:border-[#3B82F6] pb-2 -mb-2.5 sm:-mb-3 transition cursor-pointer";
                    content.classList.remove('hidden');
                } else {
                    btn.className = "font-medium text-gray-500 dark:text-white hover:text-gray-800 dark:hover:text-white pb-2 -mb-2.5 sm:-mb-3 transition cursor-pointer";
                    content.classList.add('hidden');
                }
            });

            if (tab === 'info') {
                goToInfoStep(currentInfoStep);
            }
        }

        function goToInfoStep(step) {
            currentInfoStep = step;
            document.querySelectorAll('.edit-step-content').forEach(el => el.classList.add('hidden'));
            const target = document.getElementById(`edit-step-${step}`);
            if (target) {
                target.classList.remove('hidden');
            }
            if (step === 3) {
                renderImageList();
                setTimeout(initEditMapPreview, 100);
            }
        }

        function openEditDrawer() {
            const drawer = document.getElementById('drawer-edit');
            const backdrop = document.getElementById('drawer-edit-backdrop');
            
            switchEditTab('info');
            goToInfoStep(1);
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-100');
            drawer.classList.remove('translate-x-[120%]');
            drawer.classList.add('translate-x-0');
            initDragAndDrop();
            renderImageList();
        }

        function closeEditDrawer() {
            const drawer = document.getElementById('drawer-edit');
            const backdrop = document.getElementById('drawer-edit-backdrop');
            
            closeCalendarPicker();
            drawer.classList.remove('translate-x-0');
            drawer.classList.add('translate-x-[120%]');
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
        }

        // ================= DRAG AND DROP SYSTEM =================
        let draggedItem = null;
        let dropPlaceholder = null;

        function createDropPlaceholder() {
            const el = document.createElement('div');
            el.className = 'dnd-placeholder border-2 border-dashed border-blue-400 bg-blue-50/60 dark:bg-blue-900/30 rounded-[5px] h-8 min-w-[70px] transition-all duration-150 flex items-center justify-center';
            return el;
        }

        function initDragAndDrop() {
            const containers = document.querySelectorAll('.dnd-container');
            
            containers.forEach(container => {
                if (container.dataset.dndBound) return;
                container.dataset.dndBound = "true";

                container.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    
                    if (!draggedItem) return;
                    if (!dropPlaceholder) {
                        dropPlaceholder = createDropPlaceholder();
                    }

                    const afterElement = getDragAfterElement(container, e.clientX, e.clientY);
                    if (afterElement == null) {
                        container.appendChild(dropPlaceholder);
                    } else {
                        container.insertBefore(dropPlaceholder, afterElement);
                    }
                });

                container.addEventListener('dragleave', function(e) {
                    if (e.relatedTarget && !container.contains(e.relatedTarget)) {
                        if (dropPlaceholder && dropPlaceholder.parentNode === container) {
                            dropPlaceholder.remove();
                        }
                    }
                });

                container.addEventListener('drop', function(e) {
                    e.preventDefault();
                    if (draggedItem && dropPlaceholder && dropPlaceholder.parentNode) {
                        dropPlaceholder.parentNode.insertBefore(draggedItem, dropPlaceholder);
                    }
                    cleanupDnD();
                });
            });

            document.querySelectorAll('.dnd-pill').forEach(attachPillEvents);
        }

        function attachPillEvents(pill) {
            pill.setAttribute('draggable', 'true');

            pill.addEventListener('dragstart', function(e) {
                draggedItem = pill;
                setTimeout(() => {
                    pill.classList.add('opacity-40', 'scale-95', 'shadow-md');
                }, 0);
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', pill.innerText);
            });

            pill.addEventListener('dragend', function() {
                cleanupDnD();
            });
        }

        function cleanupDnD() {
            if (draggedItem) {
                draggedItem.classList.remove('opacity-40', 'scale-95', 'shadow-md');
                draggedItem = null;
            }
            if (dropPlaceholder && dropPlaceholder.parentNode) {
                dropPlaceholder.remove();
            }
            dropPlaceholder = null;
        }

        function getDragAfterElement(container, x, y) {
            const draggableElements = [...container.querySelectorAll('.dnd-pill:not(.opacity-40)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offsetX = x - box.left - box.width / 2;
                const offsetY = y - box.top - box.height / 2;
                const distance = Math.hypot(offsetX, offsetY);

                if (offsetX < 0 && distance < closest.distance) {
                    return { distance: distance, element: child };
                } else {
                    return closest;
                }
            }, { distance: Number.POSITIVE_INFINITY }).element;
        }

        function removeDndPill(button) {
            const pill = button.closest('.dnd-pill');
            if (pill) {
                pill.classList.add('scale-75', 'opacity-0');
                setTimeout(() => pill.remove(), 150);
            }
        }

        function addNewDndPill(button, defaultName = 'Kolom Baru') {
            const container = button.closest('div').previousElementSibling?.querySelector('.dnd-container') 
                || button.parentElement.previousElementSibling?.querySelector('.dnd-container')
                || button.parentElement.previousElementSibling;
            
            const name = prompt('Masukkan nama item baru:', defaultName);
            if (!name || !name.trim()) return;

            if (container && container.classList.contains('dnd-container')) {
                const newPill = document.createElement('div');
                newPill.className = 'dnd-pill h-8 w-auto inline-flex items-center gap-2 rounded-[5px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#383C40] px-2.5 sm:px-3 text-xs text-gray-700 dark:text-white shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0';
                newPill.innerHTML = `
                    <x-icon name="icon-drag-n-drop" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 shrink-0 pointer-events-none" />
                    <span class="font-medium">${name.trim()}</span>
                    <button type="button" onclick="removeDndPill(this)" class="ml-1 text-gray-400 dark:text-gray-300 hover:text-red-500 cursor-pointer">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                `;
                container.appendChild(newPill);
                attachPillEvents(newPill);
            }
        }

        // ================= IMAGE LIST & DRAG-DROP SYSTEM =================
        let uploadedImages = [
            { id: 'img-1', name: 'gambar-utama.jpg', size: '10 MB' },
            { id: 'img-2', name: 'gambar-1.jpg', size: '10 MB' },
            { id: 'img-3', name: 'gambar-2.jpg', size: '10 MB' },
            { id: 'img-4', name: 'gambar-3.jpg', size: '10 MB' }
        ];

        let draggedImageIdx = null;

        function renderImageList() {
            const utamaSlot = document.getElementById('image-slot-utama');
            const secondaryGrid = document.getElementById('image-grid-secondary');
            if (!utamaSlot || !secondaryGrid) return;

            if (uploadedImages.length === 0) {
                utamaSlot.innerHTML = `<div class="text-xs text-gray-400 dark:text-[#9AA0A6] p-4 border border-dashed border-gray-300 dark:border-white/10 rounded-xl text-center">Belum ada gambar</div>`;
                secondaryGrid.innerHTML = '';
                return;
            }

            // 1. Render Utama (Index 0) - Large card layout
            const mainImg = uploadedImages[0];
            utamaSlot.innerHTML = `
                <div draggable="true" 
                     ondragstart="handleImageDragStart(event, 0)" 
                     ondragover="handleImageDragOver(event)" 
                     ondrop="handleImageDrop(event, 0)" 
                     class="image-dnd-card rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] p-3 flex items-center justify-between shadow-2xs cursor-grab active:cursor-grabbing hover:border-blue-400 transition select-none">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-14 h-14 rounded-lg bg-[#d8d8d8] dark:bg-[#383C40] shrink-0 flex items-center justify-center text-gray-400">
                            <svg class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                        <div class="truncate">
                            <p class="text-sm font-medium text-black dark:text-white truncate">${mainImg.name}</p>
                            <p class="text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5">${mainImg.size}</p>
                        </div>
                    </div>
                    <div class="text-gray-400 hover:text-gray-600 pl-2 shrink-0">
                        <svg class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.6169 6.92501C15.7491 6.92501 16.6669 6.0072 16.6669 4.87501C16.6669 3.74283 15.7491 2.82501 14.6169 2.82501C13.4847 2.82501 12.5669 3.74283 12.5669 4.87501C12.5669 6.0072 13.4847 6.92501 14.6169 6.92501Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path opacity="0.4" d="M5.3835 6.92501C6.51569 6.92501 7.43349 6.0072 7.43349 4.87501C7.43349 3.74283 6.51569 2.82501 5.3835 2.82501C4.25132 2.82501 3.3335 3.74283 3.3335 4.87501C3.3335 6.0072 4.25132 6.92501 5.3835 6.92501Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path opacity="0.4" d="M14.6169 17.175C15.7491 17.175 16.6669 16.2572 16.6669 15.125C16.6669 13.9928 15.7491 13.075 14.6169 13.075C13.4847 13.075 12.5669 13.9928 12.5669 15.125C12.5669 16.2572 13.4847 17.175 14.6169 17.175Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M5.3835 17.175C6.51569 17.175 7.43349 16.2572 7.43349 15.125C7.43349 13.9928 6.51569 13.075 5.3835 13.075C4.25132 13.075 3.3335 13.9928 3.3335 15.125C3.3335 16.2572 4.25132 17.175 5.3835 17.175Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            `;

            // 2. Render Secondary (Index 1 .. N) - 2 columns grid layout
            secondaryGrid.innerHTML = uploadedImages.slice(1).map((img, idx) => {
                const actualIndex = idx + 1;
                return `
                    <div draggable="true" 
                         ondragstart="handleImageDragStart(event, ${actualIndex})" 
                         ondragover="handleImageDragOver(event)" 
                         ondrop="handleImageDrop(event, ${actualIndex})" 
                         class="image-dnd-card rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] p-2.5 flex items-center justify-between shadow-2xs cursor-grab active:cursor-grabbing hover:border-blue-400 transition select-none">
                        <div class="flex items-center gap-2.5 overflow-hidden">
                            <div class="w-11 h-11 rounded-lg bg-[#d8d8d8] dark:bg-[#383C40] shrink-0 flex items-center justify-center text-gray-400">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                            <div class="truncate">
                                <p class="text-xs font-medium text-black dark:text-white truncate">${img.name}</p>
                                <p class="text-[10px] text-gray-400 dark:text-[#9AA0A6] mt-0.5">${img.size}</p>
                            </div>
                        </div>
                        <div class="text-gray-400 hover:text-gray-600 pl-1.5 shrink-0">
                            <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.6169 6.92501C15.7491 6.92501 16.6669 6.0072 16.6669 4.87501C16.6669 3.74283 15.7491 2.82501 14.6169 2.82501C13.4847 2.82501 12.5669 3.74283 12.5669 4.87501C12.5669 6.0072 13.4847 6.92501 14.6169 6.92501Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path opacity="0.4" d="M5.3835 6.92501C6.51569 6.92501 7.43349 6.0072 7.43349 4.87501C7.43349 3.74283 6.51569 2.82501 5.3835 2.82501C4.25132 2.82501 3.3335 3.74283 3.3335 4.87501C3.3335 6.0072 4.25132 6.92501 5.3835 6.92501Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path opacity="0.4" d="M14.6169 17.175C15.7491 17.175 16.6669 16.2572 16.6669 15.125C16.6669 13.9928 15.7491 13.075 14.6169 13.075C13.4847 13.075 12.5669 13.9928 12.5669 15.125C12.5669 16.2572 13.4847 17.175 14.6169 17.175Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5.3835 17.175C6.51569 17.175 7.43349 16.2572 7.43349 15.125C7.43349 13.9928 6.51569 13.075 5.3835 13.075C4.25132 13.075 3.3335 13.9928 3.3335 15.125C3.3335 16.2572 4.25132 17.175 5.3835 17.175Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function handleImageDragStart(e, index) {
            draggedImageIdx = index;
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', index);
            setTimeout(() => {
                if (e.target) e.target.classList.add('opacity-40');
            }, 0);
        }

        function handleImageDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
        }

        function handleImageDrop(e, targetIndex) {
            e.preventDefault();
            if (draggedImageIdx === null || draggedImageIdx === targetIndex) return;

            const movedItem = uploadedImages.splice(draggedImageIdx, 1)[0];
            uploadedImages.splice(targetIndex, 0, movedItem);
            draggedImageIdx = null;
            renderImageList();
        }

        function handleFileUpload(e) {
            const files = Array.from(e.target.files);
            files.forEach((file, i) => {
                uploadedImages.push({
                    id: 'img-' + Date.now() + '-' + i,
                    name: file.name,
                    size: (file.size / (1024 * 1024)).toFixed(1) + ' MB'
                });
            });
            renderImageList();
        }

        // ================= GOOGLE MAPS INTERACTIVE PREVIEW & SYNC =================
        let editMapInstance = null;
        let editMapMarker = null;

        function initEditMapPreview() {
            const mapContainer = document.getElementById('edit-map-preview');
            if (!mapContainer || typeof L === 'undefined') return;

            const latInput = document.getElementById('input-edit-latitude');
            const lngInput = document.getElementById('input-edit-longitude');

            let initialLat = latInput ? parseFloat(latInput.value) : -6.88856;
            let initialLng = lngInput ? parseFloat(lngInput.value) : 109.67530;

            if (isNaN(initialLat)) initialLat = -6.88856;
            if (isNaN(initialLng)) initialLng = 109.67530;

            if (!editMapInstance) {
                editMapInstance = L.map('edit-map-preview', {
                    zoomControl: false,
                    attributionControl: false
                }).setView([initialLat, initialLng], 14);

                // Google Maps Layer
                L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }).addTo(editMapInstance);

                // Custom Red Pin Marker
                const pinIcon = L.divIcon({
                    className: 'bg-transparent border-0',
                    html: `
                        <div style="transform: translate(-14px, -28px); width: 28px; height: 28px; cursor: grab;">
                            <svg class="w-7 h-7 drop-shadow-md" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.62 8.45C19.57 3.83 15.54 1.75 12 1.75C12 1.75 12 1.75 11.99 1.75C8.45997 1.75 4.41997 3.82 3.36997 8.44C2.19997 13.6 5.35997 17.97 8.21997 20.72C9.27997 21.74 10.64 22.25 12 22.25C13.36 22.25 14.72 21.74 15.77 20.72C18.63 17.97 21.79 13.61 20.62 8.45Z" fill="#E52500"/>
                                <circle cx="12" cy="10.5" r="3.2" fill="white"/>
                            </svg>
                        </div>
                    `,
                    iconSize: [0, 0]
                });

                editMapMarker = L.marker([initialLat, initialLng], {
                    draggable: true,
                    icon: pinIcon
                }).addTo(editMapInstance);

                // Marker drag events
                editMapMarker.on('drag', function(e) {
                    const pos = e.target.getLatLng();
                    if (latInput) latInput.value = pos.lat.toFixed(6);
                    if (lngInput) lngInput.value = pos.lng.toFixed(6);
                });

                editMapMarker.on('dragend', function(e) {
                    const pos = e.target.getLatLng();
                    if (latInput) latInput.value = pos.lat.toFixed(6);
                    if (lngInput) lngInput.value = pos.lng.toFixed(6);
                    editMapInstance.panTo(pos);
                });

                // Map click event
                editMapInstance.on('click', function(e) {
                    const pos = e.latlng;
                    editMapMarker.setLatLng(pos);
                    if (latInput) latInput.value = pos.lat.toFixed(6);
                    if (lngInput) lngInput.value = pos.lng.toFixed(6);
                    editMapInstance.panTo(pos);
                });
            } else {
                editMapInstance.setView([initialLat, initialLng], 14);
                editMapMarker.setLatLng([initialLat, initialLng]);
            }

            setTimeout(() => {
                if (editMapInstance) {
                    editMapInstance.invalidateSize();
                }
            }, 200);
        }

        function handleCoordinateInputChange() {
            const latInput = document.getElementById('input-edit-latitude');
            const lngInput = document.getElementById('input-edit-longitude');
            if (!latInput || !lngInput || !editMapInstance || !editMapMarker) return;

            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);

            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                const newPos = [lat, lng];
                editMapMarker.setLatLng(newPos);
                editMapInstance.panTo(newPos);
            }
        }

        // ================= POPUP CALENDAR LOGIC =================
        let calTargetInputId = null;
        let calCurrentYear = 2025;
        let calCurrentMonth = 5; // 0-indexed: 5 = June (Jun)

        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        function renderCalendar() {
            const monthNameEl = document.getElementById('cal-month-name');
            const yearValEl = document.getElementById('cal-year-val');
            const daysGridEl = document.getElementById('cal-days-grid');

            if (!monthNameEl || !daysGridEl) return;

            monthNameEl.textContent = monthNames[calCurrentMonth];
            yearValEl.textContent = calCurrentYear;

            daysGridEl.innerHTML = '';

            const firstDayIndex = new Date(calCurrentYear, calCurrentMonth, 1).getDay();
            const totalDaysInMonth = new Date(calCurrentYear, calCurrentMonth + 1, 0).getDate();
            const prevMonthTotalDays = new Date(calCurrentYear, calCurrentMonth, 0).getDate();

            // Previous month overflow days
            for (let i = firstDayIndex - 1; i >= 0; i--) {
                const dayNum = prevMonthTotalDays - i;
                const cell = document.createElement('div');
                cell.className = 'py-1 text-gray-400 dark:text-gray-600 text-center pointer-events-none select-none';
                cell.textContent = dayNum;
                daysGridEl.appendChild(cell);
            }

            // Current month days
            for (let d = 1; d <= totalDaysInMonth; d++) {
                const cell = document.createElement('button');
                cell.type = 'button';

                let isSelected = false;
                if (calTargetInputId) {
                    const inputEl = document.getElementById(calTargetInputId);
                    if (inputEl && inputEl.value) {
                        const parts = inputEl.value.split('/');
                        if (parts.length === 3) {
                            const selD = parseInt(parts[0], 10);
                            const selM = parseInt(parts[1], 10) - 1;
                            let selY = parseInt(parts[2], 10);
                            if (selY < 100) selY += 2000;
                            if (selD === d && selM === calCurrentMonth && selY === calCurrentYear) {
                                isSelected = true;
                            }
                        }
                    }
                }

                if (isSelected) {
                    cell.className = 'h-7 w-7 mx-auto flex items-center justify-center rounded-full bg-[#0066FF] text-white font-semibold shadow-xs cursor-pointer';
                } else {
                    cell.className = 'h-7 w-7 mx-auto flex items-center justify-center rounded-full text-gray-800 dark:text-white hover:bg-blue-50 dark:hover:bg-white/10 hover:text-[#0066FF] dark:hover:text-[#3B82F6] font-medium transition cursor-pointer';
                }

                cell.textContent = d;
                cell.onclick = function () {
                    selectCalendarDate(d, calCurrentMonth, calCurrentYear);
                };
                daysGridEl.appendChild(cell);
            }

            // Next month overflow days to complete rows (up to 35 or 42 cells)
            const totalRendered = firstDayIndex + totalDaysInMonth;
            const remainingCells = (totalRendered % 7 === 0) ? 0 : 7 - (totalRendered % 7);
            for (let n = 1; n <= remainingCells; n++) {
                const cell = document.createElement('div');
                cell.className = 'py-1 text-gray-400 dark:text-gray-600 text-center pointer-events-none select-none';
                cell.textContent = n;
                daysGridEl.appendChild(cell);
            }
        }

        function calPrevMonth() {
            calCurrentMonth--;
            if (calCurrentMonth < 0) {
                calCurrentMonth = 11;
                calCurrentYear--;
            }
            renderCalendar();
        }

        function calNextMonth() {
            calCurrentMonth++;
            if (calCurrentMonth > 11) {
                calCurrentMonth = 0;
                calCurrentYear++;
            }
            renderCalendar();
        }

        function openCalendarPicker(e, targetInputId) {
            e.stopPropagation();
            calTargetInputId = targetInputId;
            const picker = document.getElementById('popup-calendar-picker');
            const targetBtn = e.currentTarget;
            const container = targetBtn.closest('.relative') || targetBtn.parentElement;

            renderCalendar();

            // Pindahkan picker langsung ke dalam container input (.relative) agar menempel persis seperti dropdown
            container.appendChild(picker);
            picker.classList.remove('hidden');

            const containerRect = container.getBoundingClientRect();
            const popupHeight = picker.offsetHeight || 315;
            const spaceBelow = window.innerHeight - containerRect.bottom;
            const spaceAbove = containerRect.top;

            picker.style.position = 'absolute';
            picker.style.zIndex = '150';

            // Vertikal: Buka di ATAS jika mepet bawah layar, atau di BAWAH secara default
            if (spaceBelow < popupHeight && spaceAbove > spaceBelow) {
                picker.style.top = 'auto';
                picker.style.bottom = 'calc(100% + 4px)';
            } else {
                picker.style.bottom = 'auto';
                picker.style.top = 'calc(100% + 4px)';
            }

            // Horizontal: Menempel di sisi kiri input (atau sisi kanan jika mentok layar)
            if (containerRect.left + 295 > window.innerWidth) {
                picker.style.left = 'auto';
                picker.style.right = '0';
            } else {
                picker.style.left = '0';
                picker.style.right = 'auto';
            }
        }

        function closeCalendarPicker() {
            const picker = document.getElementById('popup-calendar-picker');
            if (picker) {
                picker.classList.add('hidden');
            }
        }

        function selectCalendarDate(day, monthIndex, year) {
            if (calTargetInputId) {
                const targetInput = document.getElementById(calTargetInputId);
                if (targetInput) {
                    const formatted = `${day} ${monthNames[monthIndex]} ${year}`;
                    targetInput.value = formatted;
                }
            }
            closeCalendarPicker();
        }

        document.addEventListener('DOMContentLoaded', initDragAndDrop);

        document.addEventListener('click', function (e) {
            if (!e.target.closest('#popup-calendar-picker') && !e.target.closest('[onclick*="openCalendarPicker"]')) {
                closeCalendarPicker();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeCalendarPicker();
                closeEditDrawer();
            }
        });
    </script>
