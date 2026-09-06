<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Edit Laporan ΓÇö KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Anti-FOUC Auto Theme Script (WIB 17:00 - 07:00 Auto Dark Mode) -->
    <x-theme-script />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    {{-- Leaflet JS & CSS for Google Maps Interactive Preview --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<style>
    @media (max-width: 1023.98px) {
        .mobile-dropup-sheet {
            animation: slideUpLaporanSheet 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    }
    @keyframes slideUpLaporanSheet {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
</head>

<body class="min-h-screen bg-[#F6F7F9] dark:bg-[#282A2C] font-sans antialiased text-gray-900 dark:text-gray-100 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between transition-colors duration-200">

    {{-- Top Navbar (Desktop Only on Edit Page) --}}
    <div class="hidden lg:block">
        <x-navbar active="reports" />
    </div>

    {{-- Mobile Sheet Backdrop Overlay --}}
    <div class="fixed inset-0 bg-black/40 backdrop-blur-[2px] z-40 lg:hidden" onclick="window.location.href='{{ route('laporan.index') }}'"></div>

    {{-- Main Content / Mobile Dropup Bottom Sheet Panel --}}
    <main class="mobile-dropup-sheet fixed inset-x-0 bottom-0 z-50 h-[90dvh] max-h-[90dvh] flex flex-col bg-white dark:bg-[#1F2123] rounded-t-[36px] sm:rounded-t-[40px] shadow-[0_-16px_50px_rgba(0,0,0,0.25)] dark:shadow-[0_-16px_50px_rgba(0,0,0,0.85)] border-t border-x border-gray-100 dark:border-white/10 overflow-hidden lg:static lg:h-auto lg:max-h-none lg:rounded-none lg:bg-transparent lg:shadow-none lg:border-none lg:overflow-visible w-full flex-1 max-w-[1600px] mx-auto lg:px-10 lg:pt-6 lg:pb-10 transition-all duration-300" style="padding-bottom: 0 !important;">

        {{-- Mobile Dropup Sheet Header (Persis Desain Filter Peta) --}}
        <div class="px-5 pt-5 pb-3.5 flex items-center justify-between border-b border-gray-100 dark:border-white/10 shrink-0 lg:hidden">
            <div class="flex items-center gap-2">
                <h2 class="text-base font-bold text-gray-950 dark:text-white tracking-tight">
                    Edit Laporan
                </h2>
            </div>
            <a href="{{ route('laporan.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 transition cursor-pointer" aria-label="Tutup">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        {{-- Desktop Page Header & Breadcrumbs & Action Buttons --}}
        <div class="hidden lg:flex items-center justify-between gap-3 shrink-0 mb-6">
            <div>
                <h1 class="text-lg sm:text-[26px] font-bold tracking-tight text-gray-950 dark:text-white">
                    Edit Laporan
                </h1>
                <div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-400 dark:text-[#9AA0A6] mt-0.5">
                    <a href="{{ route('laporan.index') }}" class="hover:text-gray-600 dark:hover:text-white transition">Laporan</a>
                    <span>/</span>
                    <span class="text-[#0066FF] dark:text-[#3B82F6] font-medium">Edit</span>
                </div>
            </div>

            {{-- Top Right Buttons: Simpan & Batal --}}
            <div class="flex items-center gap-2 sm:gap-2.5">
                <button
                    type="submit"
                    form="form-edit-laporan"
                    onclick="if(window.setPendingToast) window.setPendingToast('Sukses update data laporan terbaru!', 'success');"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#0066FF] hover:bg-blue-700 px-3.5 sm:px-5 py-2 text-xs sm:text-sm font-semibold text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Simpan</span>
                </button>

                <a
                    href="{{ route('laporan.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#E60000] hover:bg-red-700 px-3.5 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    <span>Batal</span>
                </a>
            </div>
        </div>

        {{-- Scrollable Form Wrapper for Mobile & Full Layout for Desktop --}}
        <div class="overflow-y-auto min-h-0 flex-1 px-4 py-4 sm:px-6 lg:px-0 lg:py-0 lg:overflow-visible lg:flex-none flex flex-col gap-4 sm:gap-6 pb-8 lg:pb-0">
            {{-- Form & Grid Container --}}
            <form id="form-edit-laporan" action="{{ route('laporan.update', $contract->contract_number) }}" method="POST" onsubmit="if(window.setPendingToast) window.setPendingToast('Sukses update data laporan terbaru!', 'success');" class="w-full">
                @csrf
                @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_380px] xl:grid-cols-[1fr_420px] gap-3.5 sm:gap-6 items-start">

                {{-- Left Column: 2 White Cards --}}
                <div class="flex flex-col gap-3.5 sm:gap-6">

                    {{-- CARD 1: INFORMASI AKUN & RKA --}}
                    <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3 sm:p-5 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                        <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white mb-2 sm:mb-3.5">
                            Informasi Akun & RKA
                        </h2>

                        <div class="space-y-2 sm:space-y-3">
                            {{-- No Kontrak & No Aset --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        No Kontrak<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="contract_number"
                                        value="{{ old('contract_number', $contract->contract_number) }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>

                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        No Aset<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="asset_number"
                                        value="{{ old('asset_number', $contract->asset_number ?? '') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Akun GL --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        Akun GL<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="akun_gl"
                                        value="{{ old('akun_gl', $financial->gl_account ?? '') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Form RKA & Tahun RKA --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        Form RKA<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="form_rka"
                                        value="{{ old('form_rka', $financial->form_rka ?? '') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>

                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        Tahun RKA<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="tahun_rka"
                                        value="{{ old('tahun_rka', $financial->tahun_rka !== null ? $financial->tahun_rka : '') }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: RINCIAN PENDAPATAN BULANAN (JANUARI - DESEMBER) --}}
                    <div class="rounded-xl sm:rounded-2xl border border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] p-3 sm:p-5 shadow-[0_4px_25px_rgba(0,0,0,0.03)] transition-colors">
                        <h2 class="text-xs sm:text-sm font-bold text-gray-950 dark:text-white mb-2 sm:mb-3.5">
                            Rincian Pendapatan Bulanan
                        </h2>

                        @php
                            $months = [
                                'januari' => 'Januari',
                                'februari' => 'Februari',
                                'maret' => 'Maret',
                                'april' => 'April',
                                'mei' => 'Mei',
                                'juni' => 'Juni',
                                'juli' => 'Juli',
                                'agustus' => 'Agustus',
                                'september' => 'September',
                                'oktober' => 'Oktober',
                                'november' => 'November',
                                'desember' => 'Desember'
                            ];
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-3">
                            @foreach($months as $key => $label)
                                @php
                                    $col = ($key === 'februari') ? 'febuari' : $key;
                                    $val = ($schedule && $schedule->$col !== null) ? number_format((float)$schedule->$col, 0, ',', '.') : '0';
                                @endphp
                                <div class="flex flex-col w-full">
                                    <label class="block text-[10.5px] sm:text-xs font-semibold text-gray-700 dark:text-white mb-0.5 sm:mb-1">
                                        {{ $label }}<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="{{ $key }}"
                                        value="{{ old($key, $val) }}"
                                        class="w-full h-[32px] sm:h-[36px] rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-[#282A2C] px-2.5 sm:px-3 text-[11px] sm:text-xs text-gray-800 dark:text-white focus:border-[#0066FF] focus:outline-none transition font-normal"
                                        required
                                    >
                                </div>
                            @endforeach
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
        </div>

        {{-- Mobile Dropup Sheet Footer (Sticky Bottom Action Bar) --}}
        <div class="px-6 pt-3.5 pb-3 flex items-center justify-between shrink-0 border-t border-gray-100 dark:border-white/10 bg-white dark:bg-[#1F2123] lg:hidden z-20" style="padding-bottom: max(1.25rem, env(safe-area-inset-bottom, 1.25rem));">
            <a href="{{ route('laporan.index') }}" class="text-sm font-semibold text-[#0066FF] dark:text-[#3B82F6] hover:underline cursor-pointer select-none transition py-2 px-1">
                Batal
            </a>
            <button type="submit" form="form-edit-laporan" onclick="if(window.setPendingToast) window.setPendingToast('Sukses update data laporan terbaru!', 'success');" class="h-[46px] min-h-[46px] px-6 rounded-[14px] bg-[#0066FF] hover:bg-blue-700 text-sm font-semibold text-white transition shadow-sm cursor-pointer select-none flex items-center justify-center shrink-0">
                Simpan
            </button>
        </div>

    </main>

    {{-- SCRIPTS: GOOGLE MAPS --}}
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

        document.addEventListener('DOMContentLoaded', () => {
            initEditMapPreview();
        });
    </script>

<x-temp-password-guard />
</body>
</html>
