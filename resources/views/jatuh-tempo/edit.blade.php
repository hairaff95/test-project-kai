<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Edit Jatuh Tempo — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
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

<body class="min-h-screen bg-[#F6F7F9] dark:bg-[#282A2C] font-sans antialiased text-gray-900 dark:text-gray-100 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between transition-colors duration-200">

    {{-- Top Navbar --}}
    <x-navbar active="due-dates" />

    {{-- Main Content --}}
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-3.5 sm:px-8 lg:px-10 pt-3 sm:pt-6 pb-28 lg:pb-10 flex flex-col gap-4 sm:gap-6">        {{-- Page Header & Breadcrumbs & Action Buttons --}}
        <div class="flex items-center justify-between gap-3 shrink-0">
            <div>
                <h1 class="text-lg sm:text-[26px] font-bold tracking-tight text-gray-950 dark:text-white">
                    Edit Jatuh Tempo
                </h1>
                <div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5">
                    <a href="{{ route('due-dates.index') }}" class="hover:text-gray-600 dark:hover:text-white transition">Jatuh Tempo</a>
                    <span>/</span>
                    <span class="text-[#0066FF] dark:text-[#3B82F6] font-medium">Edit</span>
                </div>
            </div>

            {{-- Top Right Buttons: Simpan & Batal --}}
            <div class="flex items-center gap-2 sm:gap-2.5">
                <button
                    type="submit"
                    form="form-edit-jatuh-tempo"
                    onclick="if(window.setPendingToast) window.setPendingToast('Sukses update data jatuh tempo terbaru!', 'success');"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#0066FF] hover:bg-blue-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Simpan</span>
                </button>

                <a
                    href="{{ route('due-dates.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#E60000] hover:bg-red-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    <span>Batal</span>
                </a>
            </div>
        </div>

        {{-- Form & Grid Container --}}
        <form id="form-edit-jatuh-tempo" action="{{ route('due-dates.update', $contract->contract_number) }}" method="POST" onsubmit="if(window.setPendingToast) window.setPendingToast('Sukses update data jatuh tempo terbaru!', 'success');" class="w-full">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_380px] xl:grid-cols-[1fr_420px] gap-3.5 sm:gap-6 items-start">

                {{-- Left Column: 2 White Cards --}}
                <div class="flex flex-col gap-3.5 sm:gap-6">

                    {{-- CARD 1: INFORMASI PENYEWA --}}
                    <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3 sm:p-5 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                        <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white mb-2 sm:mb-3.5">
                            Informasi Penyewa
                        </h2>

                        <div class="space-y-2 sm:space-y-3">
                            {{-- Nama Penyewa --}}
                            <div class="flex flex-col w-full">
                                <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                    Nama Penyewa<span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="nama_penyewa"
                                    value="{{ old('nama_penyewa', $contract->tenant?->fullname ?? 'Drs. Bambang Sudarsono') }}"
                                    class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                    required
                                >
                            </div>

                            {{-- Status Customer --}}
                            <div class="flex flex-col w-full">
                                <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                    Status Customer<span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="status_customer"
                                    value="{{ old('status_customer', $contract->tenant?->status_customer ?? 'Aktif') }}"
                                    class="w-full sm:w-48 max-w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                    required
                                >
                            </div>

                            {{-- Brand --}}
                            <div class="flex flex-col w-full">
                                <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                    Brand<span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="brand"
                                    value="{{ old('brand', $contract->tenant?->brand ?? '') }}"
                                    class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                >
                            </div>
                        </div>
                    </div>


                    {{-- CARD 2: INFORMASI JATUH TEMPO & KONTRAK --}}
                    <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3 sm:p-5 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                        <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white mb-2 sm:mb-3.5">
                            Informasi Jatuh Tempo & Kontrak
                        </h2>

                        <div class="space-y-2 sm:space-y-3">
                            {{-- No Aset & SPV --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        No Aset<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="asset_number"
                                        value="{{ old('asset_number', $contract->asset_number ?? 'AST-SMG-PCL-001') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>

                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        SPV<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="spv"
                                        value="{{ old('spv', $contract->spv ?? 'Sales Executive Area 1 Pekalongan') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Keterangan & Sisa Masa Sewa --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        Keterangan<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="keterangan"
                                        value="{{ old('keterangan', $contract->keterangan ?? 'RKA') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>

                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        Sisa Masa Sewa
                                    </label>
                                    <input
                                        type="text"
                                        id="input-sisa-masa-sewa"
                                        name="sisa_masa_sewa"
                                        value="{{ old('sisa_masa_sewa', $contract->due_days ?? '-') }}"
                                        readonly
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-[#282A2C]/60 px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-500 dark:text-[#9AA0A6] cursor-not-allowed focus:outline-none transition font-normal"
                                        title="Otomatis dihitung dari tanggal kontrak"
                                    >
                                </div>
                            </div>

                            {{-- Masa Selesai Kontrak --}}
                            <div>
                                <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                    Masa Selesai Kontrak<span class="text-red-500">*</span>
                                </label>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                    {{-- Selesai Kontrak --}}
                                    <div class="flex flex-col w-full">
                                        <label class="block text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6] mb-0.5">Selesai Kontrak</label>
                                        <div class="relative">
                                            <button
                                                type="button"
                                                onclick="openCalendarPicker(event, 'input-selesai-kontrak')"
                                                class="absolute left-2.5 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-600 transition cursor-pointer z-10"
                                            >
                                                <x-icon name="icon-calendar" class="h-3.5 w-3.5 text-[#0066FF] dark:text-[#3B82F6]" />
                                            </button>
                                            <input
                                                type="text"
                                                id="input-selesai-kontrak"
                                                name="end_datetime"
                                                value="{{ $contract->end_datetime ? $contract->end_datetime->format('d/m/y') : '' }}"
                                                placeholder="DD/MM/YY"
                                                class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-8 pr-2.5 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                            >
                                        </div>
                                    </div>

                                    {{-- Selesai Kontrak Baru --}}
                                    <div class="flex flex-col w-full">
                                        <label class="block text-[10px] sm:text-[11px] text-gray-400 dark:text-[#9AA0A6] mb-0.5">Selesai Kontrak Baru</label>
                                        <div class="relative">
                                            <button
                                                type="button"
                                                onclick="openCalendarPicker(event, 'input-selesai-kontrak-baru')"
                                                class="absolute left-2.5 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-600 transition cursor-pointer z-10"
                                            >
                                                <x-icon name="icon-calendar" class="h-3.5 w-3.5 text-[#0066FF] dark:text-[#3B82F6]" />
                                            </button>
                                            <input
                                                type="text"
                                                id="input-selesai-kontrak-baru"
                                                name="end_datetime_baru"
                                                value="{{ $contract->end_datetime_baru ? $contract->end_datetime_baru->format('d/m/y') : '' }}"
                                                placeholder="DD/MM/YY"
                                                class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] pl-8 pr-2.5 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- Right Column: CARD TITIK KOORDINAT G MAPS --}}
                <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-4 sm:p-5 shadow-[0_4px_25px_rgba(0,0,0,0.03)] h-fit transition-colors">
                    <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white mb-3">
                        Titik Koordinat G Maps<span class="text-red-500">*</span>
                    </h2>

                    <div class="flex flex-col gap-3.5">
                        <div class="h-[180px] sm:h-[200px] w-full rounded-2xl overflow-hidden border border-gray-200 dark:border-white/10 bg-gray-100 dark:bg-[#282A2C] relative shadow-2xs">
                            <div id="edit-map-preview" class="w-full h-full z-0"></div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-white mb-1">Latitude</label>
                                <input
                                    type="text"
                                    id="input-edit-latitude"
                                    name="latitude"
                                    value="{{ old('latitude', $contract->asset?->latitude ?? '-6.8887') }}"
                                    oninput="handleCoordinateInputChange()"
                                    placeholder="-6.8887"
                                    class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                >
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-white mb-1">Longtitude</label>
                                <input
                                    type="text"
                                    id="input-edit-longitude"
                                    name="longitude"
                                    value="{{ old('longitude', $contract->asset?->longitude ?? '109.6738') }}"
                                    oninput="handleCoordinateInputChange()"
                                    placeholder="109.6738"
                                    class="w-full rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-3.5 py-2 text-xs sm:text-sm text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                >
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </main>


    {{-- POPUP CALENDAR PICKER (Dropdown Style) --}}
    <div id="popup-calendar-picker" class="hidden absolute z-[150] w-[290px] rounded-2xl bg-white dark:bg-[#1F2123] border border-gray-100 dark:border-white/10 shadow-[0_15px_40px_rgba(0,0,0,0.16)] dark:shadow-[0_15px_40px_rgba(0,0,0,0.7)] p-4 select-none">
        <div class="flex items-center justify-between mb-3.5">
            <button type="button" onclick="calPrevMonth()" class="p-1 text-gray-500 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white transition cursor-pointer">
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
            <button type="button" onclick="calNextMonth()" class="p-1 text-gray-500 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white transition cursor-pointer">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>

        <div class="grid grid-cols-7 text-center text-xs font-semibold text-slate-500 dark:text-[#9AA0A6] mb-2">
            <div>Ming</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sa</div>
        </div>

        <div id="cal-days-grid" class="grid grid-cols-7 text-center text-xs font-medium gap-y-1">
            {{-- Rendered via JS --}}
        </div>
    </div>

    {{-- SCRIPTS: GOOGLE MAPS & CALENDAR PICKER --}}
    <script>
        // ================= GOOGLE MAPS INTERACTIVE PREVIEW & SYNC =================
        let editMapInstance = null;
        let editMapMarker = null;

        function initEditMapPreview() {
            const mapContainer = document.getElementById('edit-map-preview');
            if (!mapContainer || typeof L === 'undefined') return;

            const latInput = document.getElementById('input-edit-latitude');
            const lngInput = document.getElementById('input-edit-longitude');

            let initialLat = latInput ? parseFloat(latInput.value) : -6.8887;
            let initialLng = lngInput ? parseFloat(lngInput.value) : 109.6738;

            if (isNaN(initialLat)) initialLat = -6.8887;
            if (isNaN(initialLng)) initialLng = 109.6738;

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

        document.addEventListener('DOMContentLoaded', function() {
            initEditMapPreview();
        });

        // ================= POPUP CALENDAR LOGIC =================
        let calTargetInputId = null;
        let calCurrentYear = 2026;
        let calCurrentMonth = 0; // Jan

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
            const lastDay = new Date(calCurrentYear, calCurrentMonth + 1, 0).getDate();
            const prevMonthLastDay = new Date(calCurrentYear, calCurrentMonth, 0).getDate();

            for (let i = firstDayIndex; i > 0; i--) {
                const dayNum = prevMonthLastDay - i + 1;
                const cell = document.createElement('div');
                cell.className = 'py-1.5 text-gray-400 dark:text-gray-600 text-center pointer-events-none select-none';
                cell.textContent = dayNum;
                daysGridEl.appendChild(cell);
            }

            for (let d = 1; d <= lastDay; d++) {
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
                    cell.className = 'h-7 w-7 mx-auto flex items-center justify-center rounded-full hover:bg-blue-50 dark:hover:bg-white/10 text-gray-800 dark:text-white hover:text-[#0066FF] dark:hover:text-[#3B82F6] font-medium transition cursor-pointer';
                }

                cell.textContent = d;
                cell.onclick = (e) => {
                    e.stopPropagation();
                    selectCalendarDate(d, calCurrentMonth, calCurrentYear);
                };

                daysGridEl.appendChild(cell);
            }

            const totalRendered = firstDayIndex + lastDay;
            const remaining = totalRendered % 7 === 0 ? 0 : 7 - (totalRendered % 7);
            for (let nextD = 1; nextD <= remaining; nextD++) {
                const cell = document.createElement('div');
                cell.className = 'py-1.5 text-gray-400 dark:text-gray-600 text-center pointer-events-none select-none';
                cell.textContent = nextD;
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

        function openCalendarPicker(e, inputId) {
            e.stopPropagation();
            calTargetInputId = inputId;

            const inputEl = document.getElementById(inputId);
            if (inputEl && inputEl.value) {
                const parts = inputEl.value.split('/');
                if (parts.length === 3) {
                    const parsedM = parseInt(parts[1], 10) - 1;
                    let parsedY = parseInt(parts[2], 10);
                    if (parsedY < 100) parsedY += 2000;
                    if (!isNaN(parsedM) && parsedM >= 0 && parsedM <= 11) calCurrentMonth = parsedM;
                    if (!isNaN(parsedY) && parsedY > 2000) calCurrentYear = parsedY;
                }
            }

            renderCalendar();

            const picker = document.getElementById('popup-calendar-picker');
            const targetBtn = e.currentTarget;
            const container = targetBtn.closest('.relative') || targetBtn.parentElement;

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
            if (picker) picker.classList.add('hidden');
            calTargetInputId = null;
        }

        function selectCalendarDate(day, month, year) {
            if (calTargetInputId) {
                const inputEl = document.getElementById(calTargetInputId);
                if (inputEl) {
                    const dd = String(day).padStart(2, '0');
                    const mm = String(month + 1).padStart(2, '0');
                    const yy = String(year).slice(-2);
                    inputEl.value = `${dd}/${mm}/${yy}`;
                }
            }
            closeCalendarPicker();
        }

        document.addEventListener('click', function(e) {
            const picker = document.getElementById('popup-calendar-picker');
            if (picker && !picker.classList.contains('hidden')) {
                if (!picker.contains(e.target)) {
                    closeCalendarPicker();
                }
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            initDragAndDrop();
        });
    </script>

<x-temp-password-guard />
</body>
</html>
