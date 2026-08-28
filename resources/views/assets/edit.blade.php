<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Aset — {{ $asset->asset_block_name }} - KAI Tracker</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-[#f3f3f3] font-sans text-[#171717]">

    <x-navbar active="map" />

    <main class="mx-auto px-10 py-4">

        @if($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-[12px] text-red-700">
                <p class="mb-1 font-semibold">Terdapat kesalahan input:</p>
                <ul class="list-inside list-disc space-y-0.5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $contract  = $asset->contract;
            $financial = $contract?->financial;
            $monthly   = $contract?->monthlySchedules->first();
        @endphp

        <form method="POST" action="{{ route('admin.assets.update', $asset->asset_number) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-[325px_1fr]">


                {{-- ===================== LEFT COLUMN ===================== --}}

                <div>

                    {{-- BACK BUTTON --}}
                    <a href="{{ route('asset.detail', $asset->asset_number) }}"
                        class="mb-4 inline-flex items-center text-[15px] font-semibold text-black transition hover:text-blue-600">
                        @if(file_exists(public_path('image/modal-popup-map/detail-map/back-square.svg')))
                            {!! file_get_contents(public_path('image/modal-popup-map/detail-map/back-square.svg')) !!}
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                        @endif
                        <span class="ml-1.5">Kembali</span>
                    </a>

                    {{-- FOTO UTAMA (placeholder) --}}
                    <div class="flex h-[256px] w-full items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8]">
                        <div class="flex flex-col items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <span class="mt-2 text-[12px]">Foto Aset</span>
                        </div>
                    </div>

                    {{-- THUMBNAIL --}}
                    <div class="mt-3 grid grid-cols-3 gap-1">
                        @for($i = 0; $i < 3; $i++)
                            <div class="flex h-[103px] items-center justify-center overflow-hidden rounded-lg bg-[#d8d8d8]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                        @endfor
                    </div>

                    {{-- DATA ADMINISTRATIF --}}
                    <div class="mt-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">

                        <h3 class="mb-3 text-[14px] font-semibold text-gray-800">Data Administratif</h3>

                        <div class="grid grid-cols-2 gap-x-4 gap-y-3">

                            <div class="col-span-2">
                                <label class="text-[11px] text-gray-400">Nomor Aset</label>
                                <p class="mt-1 text-[11px] font-semibold text-gray-700">{{ $asset->asset_number }}</p>
                            </div>

                            @if($financial)
                                <div>
                                    <label class="text-[11px] text-gray-400">GL Account</label>
                                    <input type="text" name="gl_account"
                                        value="{{ old('gl_account', $financial->gl_account) }}"
                                        class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400">
                                </div>
                                <div>
                                    <label class="text-[11px] text-gray-400">Form RKA</label>
                                    <input type="text" name="form_rka"
                                        value="{{ old('form_rka', $financial->form_rka) }}"
                                        class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400">
                                </div>
                                <div>
                                    <label class="text-[11px] text-gray-400">Jenis Pendapatan</label>
                                    <input type="text" name="jenis_pendapatan"
                                        value="{{ old('jenis_pendapatan', $financial->jenis_pendapatan) }}"
                                        class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400">
                                </div>
                                <div>
                                    <label class="text-[11px] text-gray-400">Tahun RKA</label>
                                    <input type="number" name="tahun_rka"
                                        value="{{ old('tahun_rka', $financial->tahun_rka) }}"
                                        class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400">
                                </div>
                            @endif

                            @if($contract)
                                <div class="col-span-2">
                                    <label class="text-[11px] text-gray-400">SPV / Sales Executive</label>
                                    <input type="text" name="spv"
                                        value="{{ old('spv', $contract->spv) }}"
                                        class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400">
                                </div>
                                <div class="col-span-2">
                                    <label class="text-[11px] text-gray-400">Keterangan</label>
                                    <textarea name="keterangan" rows="2"
                                        class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1.5 text-[11px] font-semibold text-gray-700 outline-none focus:border-blue-400 resize-none">{{ old('keterangan', $contract->keterangan) }}</textarea>
                                </div>
                            @endif

                        </div>

                    </div>

                </div>


                {{-- ===================== RIGHT COLUMN ===================== --}}

                <div class="pt-[45px]">

                    {{-- HEADER — Judul + Tombol --}}
                    <div class="mb-5 flex items-start justify-between gap-4">

                        <div class="flex-1">
                            <input
                                type="text"
                                name="asset_block_name"
                                value="{{ old('asset_block_name', $asset->asset_block_name) }}"
                                placeholder="Input Judul... *"
                                required
                                class="w-full border-0 border-b-2 border-gray-300 bg-transparent pb-1 text-[28px] font-semibold tracking-tight text-gray-900 outline-none placeholder-gray-300 focus:border-blue-500"
                            >
                            <input
                                type="text"
                                name="wilayah_asset"
                                value="{{ old('wilayah_asset', $asset->wilayah_asset) }}"
                                placeholder="Wilayah Aset..."
                                class="mt-1 w-full border-0 bg-transparent text-[12px] text-gray-400 outline-none placeholder-gray-300 focus:text-gray-600"
                            >
                        </div>

                        {{-- TOMBOL SIMPAN & BATAL --}}
                        <div class="flex shrink-0 items-center gap-2">

                            <button type="submit"
                                class="inline-flex h-[38px] items-center gap-2 rounded-lg bg-blue-600 px-5 text-[13px] font-semibold text-white shadow-sm transition hover:bg-blue-700 active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                    <polyline points="17 21 17 13 7 13 7 21"/>
                                    <polyline points="7 3 7 8 15 8"/>
                                </svg>
                                Simpan
                            </button>

                            <a href="{{ route('asset.detail', $asset->asset_number) }}"
                                class="inline-flex h-[38px] items-center gap-2 rounded-lg bg-red-500 px-5 text-[13px] font-semibold text-white shadow-sm transition hover:bg-red-600 active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                                Batal
                            </a>

                        </div>

                    </div>


                    {{-- ============ ALAMAT ============ --}}

                    <h3 class="mb-3 text-[14px] font-semibold">Alamat <span class="text-red-500">*</span></h3>

                    <div class="overflow-hidden rounded-[14px] border border-[#cfcfcf]">
                        <div class="grid grid-cols-3">

                            <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Wilayah Aset <span class="text-red-500">*</span></div>
                                <div class="flex w-[50%] px-2">
                                    <input type="text" name="wilayah_asset_table"
                                        value="{{ old('wilayah_asset', $asset->wilayah_asset) }}"
                                        placeholder="Wilayah..."
                                        class="w-full bg-transparent text-right text-[11px] outline-none placeholder-gray-300"
                                        oninput="document.querySelector('[name=wilayah_asset]').value=this.value">
                                </div>
                            </div>

                            <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Jenis Aset <span class="text-red-500">*</span></div>
                                <div class="flex w-[50%] px-2">
                                    <select name="jenis_asset" class="w-full bg-transparent text-right text-[11px] outline-none">
                                        @foreach(['Tanah','Bangunan Dinas','Gudang','Ruko','Lahan Komersial'] as $opt)
                                            <option value="{{ $opt }}" {{ old('jenis_asset', $asset->jenis_asset) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row-span-2 flex items-start border-b border-[#d5d5d5]">
                                <div class="w-[35%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Alamat Aset</div>
                                <div class="flex w-[65%] px-2 py-2">
                                    <textarea name="alamat_display" rows="3" placeholder="Alamat lengkap..."
                                        class="w-full bg-transparent text-[11px] leading-[1.45] outline-none placeholder-gray-300 resize-none">{{ old('alamat_display', $asset->wilayah_asset.', Stasiun '.$asset->stasiun) }}</textarea>
                                </div>
                            </div>

                            <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Stasiun <span class="text-red-500">*</span></div>
                                <div class="flex w-[50%] px-2">
                                    <select name="stasiun" class="w-full bg-transparent text-right text-[11px] outline-none">
                                        @foreach(['Semarang Tawang','Semarang Poncol','Pekalongan','Tegal','Weleri'] as $opt)
                                            <option value="{{ $opt }}" {{ old('stasiun', $asset->stasiun) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="flex min-h-[52px] items-center border-b border-r border-[#d5d5d5]">
                                <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Luas Area (m²) <span class="text-red-500">*</span></div>
                                <div class="flex w-[50%] px-2">
                                    <input type="number" step="any" name="size_area"
                                        value="{{ old('size_area', $asset->size_area) }}"
                                        placeholder="0" required
                                        class="w-full bg-transparent text-right text-[11px] outline-none placeholder-gray-300">
                                </div>
                            </div>

                            @if($contract)
                                <div class="flex min-h-[52px] items-center border-r border-[#d5d5d5]">
                                    <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Tipe Lahan</div>
                                    <div class="flex w-[50%] px-2">
                                        <select name="area_kontrak" class="w-full bg-transparent text-right text-[11px] outline-none">
                                            @foreach(['Row','Non Row'] as $opt)
                                                <option value="{{ $opt }}" {{ old('area_kontrak', $contract->area_kontrak) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex min-h-[52px] items-center border-t border-r border-[#d5d5d5]">
                                    <div class="w-[50%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Jenis Kontrak</div>
                                    <div class="flex w-[50%] px-2">
                                        <select name="jenis_kontrak" class="w-full bg-transparent text-right text-[11px] outline-none">
                                            @foreach(['Baru','Perpanjangan','Pembaruan'] as $opt)
                                                <option value="{{ $opt }}" {{ old('jenis_kontrak', $contract->jenis_kontrak) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="flex min-h-[52px] items-center border-t border-[#d5d5d5]">
                                <div class="w-[35%] bg-[#f5f5f5] px-3 py-3 text-[11px] font-medium">Peruntukan</div>
                                <div class="flex w-[65%] px-2 py-2">
                                    <textarea name="peruntukan" rows="2" placeholder="Peruntukan aset..."
                                        class="w-full bg-transparent text-[11px] leading-[1.45] outline-none placeholder-gray-300 resize-none">{{ old('peruntukan', $asset->peruntukan) }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>


                    {{-- ============ DATA FINANSIAL ============ --}}

                    <div class="mt-7">

                        <h3 class="mb-3 text-[14px] font-semibold">Data Finansial <span class="text-red-500">*</span></h3>

                        <div class="grid grid-cols-3 gap-x-8 gap-y-5">

                            <div>
                                <p class="text-[11px] text-gray-400">Nilai Kontrak <span class="text-red-500">*</span></p>
                                <input type="number" step="any" name="price"
                                    value="{{ old('price', $contract?->price) }}"
                                    placeholder="Rp..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400">
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">Jumlah Hari</p>
                                <input type="number" name="jumlah_hari"
                                    value="{{ old('jumlah_hari', $financial?->jumlah_hari) }}"
                                    placeholder="Hari..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400">
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">Nilai Per Hari</p>
                                <input type="number" step="any" name="nilai_per_hari"
                                    value="{{ old('nilai_per_hari', $financial?->nilai_per_hari) }}"
                                    placeholder="Rp..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400">
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">Hari Berjalan ({{ date('Y') }})</p>
                                <input type="number" name="hari_2026"
                                    value="{{ old('hari_2026', $financial?->hari_2026) }}"
                                    placeholder="Hari..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400">
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">Nilai Tahun Berjalan</p>
                                <input type="number" step="any" name="nilai_2026"
                                    value="{{ old('nilai_2026', $financial?->nilai_2026) }}"
                                    placeholder="Rp..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400">
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">Total Jan–Des</p>
                                <input type="number" step="any" name="jan_des"
                                    value="{{ old('jan_des', $monthly?->jan_des) }}"
                                    placeholder="Rp..."
                                    class="mt-1 w-full rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-[12px] font-medium outline-none placeholder-gray-300 focus:border-blue-400 focus:ring-1 focus:ring-blue-400">
                            </div>

                        </div>


                        {{-- NILAI PER BULAN --}}
                        <div class="mt-5">
                            <p class="mb-2 text-[11px] text-gray-400">Nilai Per Bulan</p>

                            <div class="overflow-hidden rounded-[14px] border border-[#cfcfcf]">
                                <div class="grid grid-cols-4">
                                    @php
                                        $bulanMap = [
                                            ['Jan','januari'],  ['Apr','april'],    ['Jul','juli'],     ['Okt','oktober'],
                                            ['Feb','febuari'],  ['Mei','mei'],      ['Agu','agustus'],  ['Nov','november'],
                                            ['Mar','maret'],    ['Jun','juni'],     ['Sep','september'],['Des','desember'],
                                        ];
                                    @endphp
                                    @foreach($bulanMap as $idx => [$label, $col])
                                        @php
                                            $isLastRow = $idx >= 8;
                                            $isLastCol = ($idx % 4) === 3;
                                            $borderB = !$isLastRow ? 'border-b' : '';
                                            $borderR = !$isLastCol ? 'border-r' : '';
                                        @endphp
                                        <div class="flex {{ $borderB }} {{ $borderR }} border-[#d5d5d5]">
                                            <div class="w-[35%] bg-[#f5f5f5] px-3 py-2.5 text-[11px]">{{ $label }}</div>
                                            <div class="flex flex-1 items-center px-2">
                                                <input type="number" name="month_{{ $col }}"
                                                    value="{{ old('month_'.$col, $monthly?->$col) }}"
                                                    placeholder="0"
                                                    class="w-full bg-transparent text-right text-[11px] outline-none placeholder-gray-300">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Koordinat tersembunyi --}}
                    <input type="hidden" name="latitude"  value="{{ old('latitude',  $asset->latitude)  }}">
                    <input type="hidden" name="longitude" value="{{ old('longitude', $asset->longitude) }}">

                </div>

            </div>

        </form>

    </main>

    <script>
        document.querySelector('[name=wilayah_asset_table]')?.addEventListener('input', function() {
            document.querySelector('[name=wilayah_asset]').value = this.value;
        });
    </script>

</body>
</html>
