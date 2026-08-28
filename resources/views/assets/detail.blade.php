<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $asset->asset_block_name }} - KAI Tracker</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-[#f3f3f3] font-sans text-[#171717]">

    <x-navbar active="map" />

    <main class="mx-auto px-10 py-4">

        @php
            $contract  = $asset->contract;
            $financial = $contract?->financial;
            $monthly   = $contract?->monthlySchedules->first();
            $tenant    = $contract?->tenant;
        @endphp

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[325px_1fr]">

            {{-- ===================== LEFT COLUMN ===================== --}}

            <div>

                {{-- BACK BUTTON --}}
                <a href="{{ route('map') }}" class="mb-4 inline-flex items-center text-[15px] font-semibold text-black transition hover:text-blue-600">
                    @if(file_exists(public_path('image/modal-popup-map/detail-map/back-square.svg')))
                        {!! file_get_contents(public_path('image/modal-popup-map/detail-map/back-square.svg')) !!}
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                    @endif
                    <span class="ml-1.5">Kembali</span>
                </a>

                {{-- FOTO UTAMA --}}
                <div class="flex h-[256px] w-full items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8]">
                    <div class="text-[13px] text-gray-500">Foto Aset</div>
                </div>

                {{-- THUMBNAIL --}}
                <div class="mt-3 grid grid-cols-3 gap-1">
                    @for($i = 0; $i < 3; $i++)
                        <div class="flex h-[103px] items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8]"></div>
                    @endfor
                </div>

                {{-- DATA ADMINISTRATIF --}}
                <div class="mt-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">

                    <h3 class="mb-3 text-[14px] font-semibold text-gray-800">Data Administratif</h3>

                    <div class="grid grid-cols-2 gap-x-5 gap-y-3">

                        @if($financial)
                            <div>
                                <p class="text-[11px] text-gray-400">GL Account</p>
                                <p class="mt-[3px] text-[11px] font-semibold text-gray-700">{{ $financial->gl_account ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400">Form RKA</p>
                                <p class="mt-[3px] text-[11px] font-semibold text-gray-700">{{ $financial->form_rka ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400">Jenis Pendapatan</p>
                                <p class="mt-[3px] text-[11px] font-semibold text-gray-700">{{ $financial->jenis_pendapatan ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400">Tahun RKA</p>
                                <p class="mt-[3px] text-[11px] font-semibold text-gray-700">{{ $financial->tahun_rka ?? '-' }}</p>
                            </div>
                        @endif

                        @if($contract)
                            <div>
                                <p class="text-[11px] text-gray-400">SPV / Sales Executive</p>
                                <p class="mt-[3px] text-[11px] font-semibold text-gray-700">{{ $contract->spv ?? '-' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-[11px] text-gray-400">Keterangan</p>
                                <p class="mt-[3px] text-[11px] font-semibold leading-[1.4] text-gray-700">{{ $contract->keterangan ?? '-' }}</p>
                            </div>
                        @endif

                        @if($tenant)
                            <div class="col-span-2">
                                <p class="text-[11px] text-gray-400">Ket. Pendapatan / Penyewa</p>
                                <p class="mt-[3px] text-[11px] font-semibold leading-[1.4] text-gray-700">{{ $tenant->fullname }}</p>
                            </div>
                        @endif

                    </div>

                </div>

            </div>


            {{-- ===================== RIGHT COLUMN ===================== --}}

            <div class="pt-[45px]">

                {{-- HEADER --}}
                <div class="mb-5 flex items-start justify-between gap-4">

                    <div>
                        <h1 class="text-[30px] font-semibold leading-tight tracking-[-0.5px]">
                            {{ $asset->asset_block_name }}
                        </h1>
                        <p class="mt-3 text-[12px] text-gray-400">
                            {{ $asset->jenis_asset }}
                        </p>
                    </div>

                    {{-- TOMBOL EDIT & HAPUS --}}
                    <div class="flex shrink-0 items-center gap-2">

                        <a
                            href="{{ route('admin.assets.edit', $asset->asset_number) }}"
                            class="inline-flex h-[38px] items-center gap-2 rounded-lg bg-blue-600 px-5 text-[13px] font-semibold text-white shadow-sm transition hover:bg-blue-700 active:scale-95"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            Edit
                        </a>

                        <form action="{{ route('admin.assets.destroy', $asset->asset_number) }}" method="POST" id="form-hapus-aset">
                            @csrf
                            @method('DELETE')
                            <button
                                type="button"
                                onclick="document.getElementById('modal-hapus').classList.remove('hidden')"
                                class="inline-flex h-[38px] items-center gap-2 rounded-lg bg-red-500 px-5 text-[13px] font-semibold text-white shadow-sm transition hover:bg-red-600 active:scale-95"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                                Hapus
                            </button>
                        </form>

                    </div>

                </div>

                {{-- DESKRIPSI --}}
                @if($asset->description)
                    <p class="mb-5 max-w-[680px] text-[13px] leading-[1.6] text-gray-500">
                        {{ $asset->description }}
                    </p>
                @elseif($contract?->keterangan)
                    <p class="mb-5 max-w-[680px] text-[13px] leading-[1.6] text-gray-500">
                        {{ $contract->keterangan }}
                    </p>
                @endif


                {{-- ============ ALAMAT ============ --}}

                <h3 class="mb-3 text-[14px] font-semibold">Alamat</h3>

                <div class="overflow-hidden rounded-[14px] border border-[#cfcfcf]">
                    <div class="grid grid-cols-3">
                        <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Wilayah Aset</div>
                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">{{ $asset->wilayah_asset }}</div>
                        </div>

                        <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Jenis Aset</div>
                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">{{ $asset->jenis_asset }}</div>
                        </div>

                        <div class="row-span-3 flex items-center border-b border-[#d5d5d5]">
                            <div class="w-[35%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Alamat Aset</div>
                            <div class="flex w-[65%] items-center px-3 py-2 text-[11px] leading-[1.45]">{{ $asset->wilayah_asset }}, Stasiun {{ $asset->stasiun }}</div>
                        </div>

                        <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Stasiun</div>
                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">{{ $asset->stasiun }}</div>
                        </div>

                        <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Luas Area</div>
                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">{{ $asset->size_area_formatted }}</div>
                        </div>

                        @if($contract)

                            <div class="flex min-h-[52px] items-center border-t border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Jenis Kontrak</div>
                                <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">{{ $contract->jenis_kontrak }}</div>
                            </div>
                        @endif

                        <div class="flex min-h-[52px] items-center border-t border-r border-[#d5d5d5]">
                            <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Peruntukan</div>
                            <div class="flex w-[50%] items-center justify-end px-3 text-right text-[11px]">{{ $asset->peruntukan }}</div>
                        </div>

                    </div>
                </div>


                {{-- ============ DATA FINANSIAL ============ --}}

                @if($contract)
                    <div class="mt-7">

                        <h3 class="mb-3 text-[14px] font-semibold">Data Finansial</h3>

                        <div class="grid grid-cols-3 gap-x-8 gap-y-5">

                            <div>
                                <p class="text-[11px] text-gray-400">Nilai Kontrak</p>
                                <p class="mt-1 text-[12px] font-medium">{{ $contract->price_formatted }}</p>
                            </div>

                            @if($financial)
                                <div>
                                    <p class="text-[11px] text-gray-400">Jumlah Hari</p>
                                    <p class="mt-1 text-[12px] font-medium">{{ number_format($financial->jumlah_hari, 0, ',', '.') }} hari</p>
                                </div>

                                <div>
                                    <p class="text-[11px] text-gray-400">Nilai Per Hari</p>
                                    <p class="mt-1 text-[12px] font-medium">Rp {{ number_format($financial->nilai_per_hari, 0, ',', '.') }}</p>
                                </div>

                                <div>
                                    <p class="text-[11px] text-gray-400">Hari Berjalan ({{ date('Y') }})</p>
                                    <p class="mt-1 text-[12px] font-medium">{{ number_format($financial->hari_2026, 0, ',', '.') }} hari</p>
                                </div>

                                <div>
                                    <p class="text-[11px] text-gray-400">Nilai Tahun Berjalan</p>
                                    <p class="mt-1 text-[12px] font-medium">Rp {{ number_format($financial->nilai_2026, 0, ',', '.') }}</p>
                                </div>

                                <div>
                                    <p class="text-[11px] text-gray-400">Total Jan–Des</p>
                                    <p class="mt-1 text-[12px] font-medium">Rp {{ number_format($financial->nilai_2026, 0, ',', '.') }}</p>
                                </div>
                            @endif

                        </div>


                        {{-- NILAI PER BULAN --}}
                        @if($monthly)
                            <div class="mt-5">
                                <p class="mb-2 text-[11px] text-gray-400">Nilai Per Bulan</p>

                                <div class="overflow-hidden rounded-[14px] border border-[#cfcfcf]">
                                    <div class="grid grid-cols-4">
                                        @php
                                            $bulan = [
                                                ['Jan', 'januari'],  ['Apr', 'april'],    ['Jul', 'juli'],     ['Okt', 'oktober'],
                                                ['Feb', 'febuari'],  ['Mei', 'mei'],      ['Agu', 'agustus'],  ['Nov', 'november'],
                                                ['Mar', 'maret'],    ['Jun', 'juni'],     ['Sep', 'september'],['Des', 'desember'],
                                            ];
                                        @endphp
                                        @foreach($bulan as $idx => [$label, $col])
                                            @php
                                                $isLastRow = $idx >= 8;
                                                $isLastCol = ($idx % 4) === 3;
                                                $borderB = !$isLastRow ? 'border-b' : '';
                                                $borderR = !$isLastCol ? 'border-r' : '';
                                            @endphp
                                            <div class="flex {{ $borderB }} {{ $borderR }} border-[#d5d5d5]">
                                                <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">{{ $label }}</div>
                                                <div class="flex flex-1 items-center justify-end px-3 text-[11px]">
                                                    {{ number_format((float) $monthly->$col, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                @endif


                {{-- PERIODE & LOKASI --}}
                @if($contract)
                    <div class="mt-7 grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="mb-2 text-[14px] font-semibold">Periode Kontrak</h3>
                            <p class="text-[13px] text-gray-600">
                                {{ $contract->start_datetime->format('d/m/Y') }} – {{ $contract->end_datetime->format('d/m/Y') }}
                            </p>
                            @if($contract->start_datetime_baru && $contract->end_datetime_baru)
                                <p class="mt-1 text-[11px] text-gray-400">
                                    Baru: {{ $contract->start_datetime_baru->format('d/m/Y') }} – {{ $contract->end_datetime_baru->format('d/m/Y') }}
                                </p>
                            @endif
                        </div>

                        @if($asset->latitude && $asset->longitude)
                            <div>
                                <h3 class="mb-2 text-[14px] font-semibold">Lokasi</h3>
                                <a
                                    href="https://www.google.com/maps?q={{ $asset->latitude }},{{ $asset->longitude }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-[12px] font-medium text-gray-700 transition hover:bg-gray-50"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    Buka di Google Maps
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

            </div>

        </div>

    </main>


    {{-- MODAL KONFIRMASI HAPUS --}}
    <div id="modal-hapus" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="w-[380px] rounded-2xl bg-white p-6 shadow-xl">

            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
            </div>

            <h3 class="mb-1 text-[16px] font-semibold text-gray-900">Hapus Aset</h3>
            <p class="mb-6 text-[13px] text-gray-500">
                Yakin ingin menghapus <span class="font-semibold text-gray-700">{{ $asset->asset_block_name }}</span>?
                Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('modal-hapus').classList.add('hidden')"
                    class="flex-1 rounded-lg border border-gray-200 bg-white py-2.5 text-[13px] font-semibold text-gray-700 transition hover:bg-gray-50">
                    Batal
                </button>
                <button type="button" onclick="document.getElementById('form-hapus-aset').submit()"
                    class="flex-1 rounded-lg bg-red-500 py-2.5 text-[13px] font-semibold text-white transition hover:bg-red-600">
                    Ya, Hapus
                </button>
            </div>

        </div>
    </div>

</body>

</html>
