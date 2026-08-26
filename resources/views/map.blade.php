<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'KAI Tracker') }} — Peta</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite([
            'resources/css/app.css',
        ])
    @endif

    {{-- Leaflet JS & CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        .tool-active-bg {
            background-color: rgba(229, 231, 235, 0.8) !important;
        }

        #map {
            background-color: #F6F7F9 !important;
            cursor: grab !important;
        }

        #map:active, #map.leaflet-drag-target {
            cursor: grabbing !important;
        }

        .leaflet-container {
            background: #F6F7F9 !important;
            font-family: inherit;
            outline: none;
            cursor: grab !important;
        }

        .leaflet-container:active, .leaflet-container.leaflet-drag-target {
            cursor: grabbing !important;
        }

        .leaflet-grab {
            cursor: grab !important;
        }

        .leaflet-popup-content-wrapper {
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
            border-radius: 24px !important;
        }

        .leaflet-popup-content {
            margin: 0 !important;
            width: auto !important;
            line-height: inherit !important;
        }

        .leaflet-popup-tip-container {
            display: none !important;
        }

        .leaflet-container a.btn-detail-lanjutan,
        .leaflet-container a.btn-detail-lanjutan * {
            color: #ffffff !important;
            text-decoration: none !important;
        }

        .leaflet-container a.btn-buka-maps,
        .leaflet-container a.btn-buka-maps * {
            color: #4b5563 !important;
            text-decoration: none !important;
        }

        .custom-pin-wrapper {
            background: transparent;
            border: none;
        }

        .custom-pin-marker {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .custom-pin-marker:hover {
            transform: scale(1.2) translateY(-2px);
        }
    </style>
</head>

<body class="h-screen overflow-hidden bg-[#F6F7F9] font-sans antialiased text-gray-900 selection:bg-blue-100 selection:text-blue-600 relative">

    {{-- Navbar --}}
    <x-navbar active="map" />

    {{-- Header: Judul, Tools Zoom, & Tombol Filter --}}
    <div class="relative z-30 w-full max-w-[1600px] mx-auto px-5 sm:px-8 lg:px-10 pt-5 pointer-events-none">
        <div class="flex items-center justify-between relative min-h-[44px]">
            <div>
            </div>

            <!-- Tools Zoom & Pan -->
            <div class="pointer-events-auto absolute left-1/2 -translate-x-1/2 flex items-center gap-[5px] bg-transparent">
                <button
                    id="zoomInButton"
                    type="button"
                    onclick="if(window.mapZoomIn) window.mapZoomIn();"
                    class="w-11 h-11 flex items-center justify-center rounded-[10px] border-2 border-[#8E8E8E] bg-transparent hover:bg-gray-200/80 active:bg-gray-300/80 text-gray-700 transition cursor-pointer"
                    title="Zoom In"
                >
                    <x-icon name="zoom-in" class="w-6 h-6" />
                </button>
                <button
                    id="zoomOutButton"
                    type="button"
                    onclick="if(window.mapZoomOut) window.mapZoomOut();"
                    class="w-11 h-11 flex items-center justify-center rounded-[10px] border-2 border-[#8E8E8E] bg-transparent hover:bg-gray-200/80 active:bg-gray-300/80 text-gray-700 transition cursor-pointer"
                    title="Zoom Out"
                >
                    <x-icon name="zoom-out" class="w-6 h-6" />
                </button>
                <button
                    id="panToolButton"
                    type="button"
                    onclick="if(window.mapPanTool) window.mapPanTool();"
                    class="w-11 h-11 flex items-center justify-center rounded-[10px] border-2 border-[#8E8E8E] bg-transparent hover:bg-gray-200/80 active:bg-gray-300/80 text-gray-700 transition cursor-pointer"
                    title="Pusatkan Peta Indonesia"
                >
                    <x-icon name="hand-pan" class="w-6 h-6 text-gray-600" />
                </button>
            </div>

            <!-- Tombol Buka Filter -->
            <div class="pointer-events-auto">
                <button
                    id="filterButton"
                    type="button"
                    class="w-11 h-11 sm:w-12 sm:h-12 flex items-center justify-center rounded-[10px] bg-white shadow-[0_4px_12px_rgba(0,0,0,0.06)] border border-gray-100 hover:bg-gray-50 active:bg-gray-100 transition cursor-pointer"
                    title="Filter Peta"
                >
                    <x-icon name="filter-peta" class="w-6 h-6 text-gray-800" />
                </button>
            </div>
        </div>
    </div>

    {{-- Map Canvas --}}
    <div id="map" class="absolute inset-0 z-0 h-screen w-full"></div>

    {{-- Overlay Background Filter --}}
    <div id="filterOverlay" class="invisible fixed inset-0 z-40 bg-black/[0.12] opacity-0 transition-all duration-200"></div>

    {{-- Modal Filter --}}
    <aside
        id="filterModal"
        class="invisible opacity-0 scale-95 fixed right-6 sm:right-8 lg:right-10 top-28 bottom-6 sm:bottom-8 z-50 w-[360px] sm:w-[385px] lg:w-[410px] bg-white rounded-[10px] p-7 sm:p-8 shadow-[0_20px_50px_rgba(0,0,0,0.08)] border border-gray-100/90 transition-all duration-200 pointer-events-none flex flex-col justify-start overflow-y-auto"
    >
        <div class="mb-7 flex items-center justify-between">
            <h2 class="text-lg sm:text-[20px] font-bold text-gray-950 tracking-tight">
                Filter Peta
            </h2>
            <button
                id="closeFilter"
                type="button"
                class="flex h-7 w-7 items-center justify-center rounded-[10px] bg-gray-100 text-gray-500 hover:bg-gray-200 transition font-bold text-xs cursor-pointer"
                title="Tutup Filter"
            >
                ×
            </button>
        </div>

        {{-- FILTER 2-COLUMN GRID --}}
        <div class="grid grid-cols-2 gap-x-4 gap-y-5">

            {{-- 1. STASIUN --}}
            <div class="flex flex-col">
                <label class="flex items-center gap-[6px] text-sm font-semibold text-gray-700 mb-[6px]">
                    <x-icon name="subway" class="w-5 h-5 shrink-0 text-gray-400" />
                    Stasiun
                </label>
                <div class="relative">
                    <select
                        id="stasiun"
                        class="h-[46px] w-full cursor-pointer rounded-[10px] border border-gray-300 bg-white px-3.5 text-[13px] sm:text-sm text-gray-700 outline-none transition focus:border-blue-600 appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.8%22%20d%3D%22M6%208l4%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_0.75rem_center] bg-no-repeat pr-8"
                    >
                        <option value="">Semua Stasiun</option>
                        <option value="gambir">Gambir</option>
                        <option value="bandung">Bandung</option>
                        <option value="surabaya">Surabaya</option>
                        <option value="semarang">Semarang Poncol</option>
                    </select>
                </div>
            </div>

            {{-- 2. WILAYAH --}}
            <div class="flex flex-col">
                <label class="flex items-center gap-[6px] text-sm font-semibold text-gray-700 mb-[6px]">
                    <x-icon name="explore_nearby" class="w-5 h-5 shrink-0" />
                    Wilayah
                </label>
                <div class="relative">
                    <select
                        id="wilayah"
                        class="h-[46px] w-full cursor-pointer rounded-[10px] border border-gray-300 bg-white px-3.5 text-[13px] sm:text-sm text-gray-700 outline-none transition focus:border-blue-600 appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.8%22%20d%3D%22M6%208l4%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_0.75rem_center] bg-no-repeat pr-8"
                    >
                        <option value="">Row & Non Row</option>
                        <option value="row">Row</option>
                        <option value="non-row">Non Row</option>
                    </select>
                </div>
            </div>

            {{-- 3. ASET --}}
            <div class="flex flex-col">
                <label class="flex items-center gap-[6px] text-sm font-semibold text-gray-700 mb-[6px]">
                    <x-icon name="aset-icon" class="w-5 h-5 shrink-0" />
                    Aset
                </label>
                <div class="relative">
                    <select
                        id="aset"
                        class="h-[46px] w-full cursor-pointer rounded-[10px] border border-gray-300 bg-white px-3.5 text-[13px] sm:text-sm text-gray-700 outline-none transition focus:border-blue-600 appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.8%22%20d%3D%22M6%208l4%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_0.75rem_center] bg-no-repeat pr-8"
                    >
                        <option value="">Semua Aset</option>
                        <option value="tanah">Tanah</option>
                        <option value="bangunan">Bangunan</option>
                    </select>
                </div>
            </div>

            {{-- 4. JENIS KONTRAK --}}
            <div class="flex flex-col">
                <label class="flex items-center gap-[6px] text-sm font-semibold text-gray-700 mb-[6px]">
                    <x-icon name="contract-icon" class="w-5 h-5 shrink-0" />
                    Jenis Kontrak
                </label>
                <div class="relative">
                    <select
                        id="jenis_kontrak"
                        class="h-[46px] w-full cursor-pointer rounded-[10px] border border-gray-300 bg-white px-3.5 text-[13px] sm:text-sm text-gray-700 outline-none transition focus:border-blue-600 appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.8%22%20d%3D%22M6%208l4%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_0.75rem_center] bg-no-repeat pr-8"
                    >
                        <option value="">Semua Kontrak</option>
                        <option value="sewa">Sewa</option>
                        <option value="kerjasama">Kerja Sama</option>
                    </select>
                </div>
            </div>

            {{-- 5. JENIS PENDAPATAN --}}
            <div class="flex flex-col">
                <label class="flex items-center gap-[6px] text-sm font-semibold text-gray-700 mb-[6px]">
                    <x-icon name="jenis-pendapatan-icon" class="w-5 h-5 shrink-0" />
                    Jenis Pendapatan
                </label>
                <div class="relative">
                    <select
                        id="jenis_pendapatan"
                        class="h-[46px] w-full cursor-pointer rounded-[10px] border border-gray-300 bg-white px-3.5 text-[13px] sm:text-sm text-gray-700 outline-none transition focus:border-blue-600 appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.8%22%20d%3D%22M6%208l4%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_0.75rem_center] bg-no-repeat pr-8"
                    >
                        <option value="">Semua Pend...</option>
                        <option value="sewa">Sewa</option>
                        <option value="iklan">Iklan</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
            </div>

            {{-- 6. SPV --}}
            <div class="flex flex-col">
                <label class="flex items-center gap-[6px] text-sm font-semibold text-gray-700 mb-[6px]">
                    <x-icon name="spv-icon" class="w-5 h-5 shrink-0" />
                    SPV
                </label>
                <div class="relative">
                    <select
                        id="spv"
                        class="h-[46px] w-full cursor-pointer rounded-[10px] border border-gray-300 bg-white px-3.5 text-[13px] sm:text-sm text-gray-700 outline-none transition focus:border-blue-600 appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.8%22%20d%3D%22M6%208l4%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_0.75rem_center] bg-no-repeat pr-8"
                    >
                        <option value="">Semua SPV</option>
                        <option value="spv1">SPV 1</option>
                        <option value="spv2">SPV 2</option>
                    </select>
                </div>
            </div>

        </div>

        {{-- ACTION BUTTONS --}}
        <div class="mt-8 flex gap-3.5">
            <button
                id="applyFilter"
                type="button"
                class="h-[48px] flex-1 rounded-[10px] bg-[#0066FF] hover:bg-blue-700 text-sm font-semibold text-white transition flex items-center justify-center gap-2 shadow-xs cursor-pointer"
            >
                <x-icon name="filter-icon" class="w-4 h-4 text-white" />
                Terapkan Filter
            </button>

            <button
                id="resetFilter"
                type="button"
                class="h-[48px] w-[115px] rounded-[10px] border border-gray-300 bg-white text-sm font-semibold text-gray-800 transition hover:bg-gray-50 cursor-pointer"
            >
                Reset
            </button>
        </div>

    </aside>


    {{-- Javascript & Peta Leaflet --}}
    <script>
        // Data aset dari database
        const assets = @json($assets);

        let indonesiaGeojsonLayer = null;
        let indonesiaBounds = null;
        let baseIndonesiaZoom = 5;

        // Inisialisasi peta Leaflet dengan smooth & responsive zoom
        const map = L.map('map', {
            center: [-2.2, 118.0],
            zoom: 5,
            zoomSnap: 0.1,
            zoomDelta: 0.5,
            wheelPxPerZoomLevel: 85,
            wheelDebounceTime: 0,
            zoomAnimation: true,
            fadeAnimation: true,
            markerZoomAnimation: true,
            zoomControl: false,
            attributionControl: false,
            dragging: true,
            touchZoom: true,
            scrollWheelZoom: true,
            doubleClickZoom: true
        });

        // Pusatkan peta ke kepulauan Indonesia
        function fitIndonesiaBounds() {
            if (indonesiaBounds) {
                map.fitBounds(indonesiaBounds, {
                    padding: [10, 10],
                    animate: true
                });
            }
        }

        const zoomInButton = document.getElementById('zoomInButton');
        const zoomOutButton = document.getElementById('zoomOutButton');
        const panToolButton = document.getElementById('panToolButton');

        let zoomInTimer = null;
        let zoomOutTimer = null;
        let isCurrentlyZooming = false;
        let zoomEndTimer = null;

        function flashZoomIn() {
            if (!zoomInButton) return;
            isCurrentlyZooming = true;
            zoomInButton.classList.add('tool-active-bg');
            if (panToolButton) panToolButton.classList.remove('tool-active-bg');
            clearTimeout(zoomInTimer);
            zoomInTimer = setTimeout(() => {
                zoomInButton.classList.remove('tool-active-bg');
            }, 300);
            clearTimeout(zoomEndTimer);
            zoomEndTimer = setTimeout(() => {
                isCurrentlyZooming = false;
            }, 350);
        }

        function flashZoomOut() {
            if (!zoomOutButton) return;
            isCurrentlyZooming = true;
            zoomOutButton.classList.add('tool-active-bg');
            if (panToolButton) panToolButton.classList.remove('tool-active-bg');
            clearTimeout(zoomOutTimer);
            zoomOutTimer = setTimeout(() => {
                zoomOutButton.classList.remove('tool-active-bg');
            }, 300);
            clearTimeout(zoomEndTimer);
            zoomEndTimer = setTimeout(() => {
                isCurrentlyZooming = false;
            }, 350);
        }

        function setPanToolVisual(active) {
            if (!panToolButton || isCurrentlyZooming) return;
            if (active) {
                panToolButton.classList.add('tool-active-bg');
            } else {
                panToolButton.classList.remove('tool-active-bg');
            }
        }

        window.mapZoomIn = function() {
            flashZoomIn();
            map.setZoom(Math.floor(map.getZoom()) + 1);
        };

        window.mapZoomOut = function() {
            flashZoomOut();
            map.setZoom(Math.ceil(map.getZoom()) - 1);
        };

        window.mapPanTool = function() {
            fitIndonesiaBounds();
        };

        let lastZoomLevel = map.getZoom();

        map.on('zoomstart', function() {
            isCurrentlyZooming = true;
            if (panToolButton) panToolButton.classList.remove('tool-active-bg');
            lastZoomLevel = map.getZoom();
        });

        map.on('zoomanim', function(e) {
            isCurrentlyZooming = true;
            if (panToolButton) panToolButton.classList.remove('tool-active-bg');
            if (e.zoom > lastZoomLevel) {
                flashZoomIn();
            } else if (e.zoom < lastZoomLevel) {
                flashZoomOut();
            }
            lastZoomLevel = e.zoom;
        });

        map.on('zoom', function() {
            isCurrentlyZooming = true;
            if (panToolButton) panToolButton.classList.remove('tool-active-bg');
            const currentZoom = map.getZoom();
            if (currentZoom > lastZoomLevel) {
                flashZoomIn();
            } else if (currentZoom < lastZoomLevel) {
                flashZoomOut();
            }
            lastZoomLevel = currentZoom;
        });

        map.on('zoomend', function() {
            clearTimeout(zoomEndTimer);
            zoomEndTimer = setTimeout(() => {
                isCurrentlyZooming = false;
            }, 300);
        });

        map.on('dragstart', function() {
            if (!isCurrentlyZooming) {
                setPanToolVisual(true);
            }
        });

        map.on('drag', function() {
            if (!isCurrentlyZooming) {
                setPanToolVisual(true);
            }
        });

        map.on('dragend', function() {
            setPanToolVisual(false);
        });

        window.addEventListener('mouseup', function() {
            setPanToolVisual(false);
        });

        window.addEventListener('touchend', function() {
            setPanToolVisual(false);
        });

        // Ikon Pin Lokasi
        const redPinIcon = L.divIcon({
            className: 'custom-pin-wrapper',
            html: `
                <div class="custom-pin-marker cursor-pointer hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 drop-shadow-[0_4px_8px_rgba(190,0,0,0.4)]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.62 8.45C19.57 3.83 15.54 1.75 12 1.75C12 1.75 12 1.75 11.99 1.75C8.45997 1.75 4.41997 3.82 3.36997 8.44C2.19997 13.6 5.35997 17.97 8.21997 20.72C9.27997 21.74 10.64 22.25 12 22.25C13.36 22.25 14.72 21.74 15.77 20.72C18.63 17.97 21.79 13.61 20.62 8.45Z" fill="#BE0000"/>
                        <path d="M12 13.46C13.7397 13.46 15.15 12.0497 15.15 10.31C15.15 8.57031 13.7397 7.16 12 7.16C10.2603 7.16 8.84998 8.57031 8.84998 10.31C8.84998 12.0497 10.2603 13.46 12 13.46Z" fill="white"/>
                    </svg>
                </div>
            `,
            iconSize: [32, 32],
            iconAnchor: [16, 30]
        });

        // Load GeoJSON batas wilayah Indonesia
        fetch('/js/indonesia.json')
            .then(response => {
                if (!response.ok) throw new Error('Failed to load indonesia.json');
                return response.json();
            })
            .then(data => {
                indonesiaGeojsonLayer = L.geoJSON(data, {
                    style: {
                        fillColor: '#757575',
                        fillOpacity: 1,
                        color: '#F6F7F9',
                        weight: 0.7,
                        opacity: 1
                    },
                    onEachFeature: function(feature, layer) {
                        layer.on({
                            mouseover: function(e) {
                                e.target.setStyle({
                                    fillColor: '#636363'
                                });
                            },
                            mouseout: function(e) {
                                e.target.setStyle({
                                    fillColor: '#757575'
                                });
                            }
                        });
                    }
                }).addTo(map);

                indonesiaBounds = indonesiaGeojsonLayer.getBounds();

                map.fitBounds(indonesiaBounds, {
                    padding: [10, 10]
                });

                const baseMinZoom = map.getBoundsZoom(indonesiaBounds, false, [10, 10]);
                baseIndonesiaZoom = baseMinZoom;
                map.setMinZoom(baseMinZoom);
                map.setMaxZoom(12);
                map.setMaxBounds(indonesiaBounds.pad(0.25));

                renderMarkers();
            })
            .catch(error => {
                console.error('GeoJSON error:', error);
            });

        window.addEventListener('resize', function() {
            if (indonesiaBounds) {
                const baseMinZoom = map.getBoundsZoom(indonesiaBounds, false, [10, 10]);
                baseIndonesiaZoom = baseMinZoom;
                map.setMinZoom(baseMinZoom);
            }
        });

        // Ikon 3D untuk popup kartu aset
        const ICON_CORP = `<svg class="w-7 h-7 shrink-0 text-[#0066FF]" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 18.7775V0H10.4319V4.17278H20.8639V18.7775H0ZM2.08639 16.6911H8.34555V14.6047H2.08639V16.6911ZM2.08639 12.5183H8.34555V10.4319H2.08639V12.5183ZM2.08639 8.34555H8.34555V6.25916H2.08639V8.34555ZM2.08639 4.17278H8.34555V2.08639H2.08639V4.17278ZM10.4319 16.6911H18.7775V6.25916H10.4319V16.6911ZM12.5183 10.4319V8.34555H16.6911V10.4319H12.5183ZM12.5183 14.6047V12.5183H16.6911V14.6047H12.5183Z" fill="currentColor"/></svg>`;
        const ICON_ALAMAT = `<svg class="w-6 h-6 shrink-0" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg"><g filter="url(#f_d_alm)"><g filter="url(#f1_d_alm)"><path d="M4.51 3.01C4.51 2.18 5.18 1.5 6.01 1.5H18.04C18.87 1.5 19.54 2.18 19.54 3.01V11.28C19.54 12.11 18.87 12.78 18.04 12.78H6.01C5.18 12.78 4.51 12.11 4.51 11.28V3.01Z" fill="url(#p0_lin_alm)"/></g><path fill-rule="evenodd" clip-rule="evenodd" d="M10.52 4.51L13.53 5.26V16.54L10.52 15.79V10.31C10.78 10.77 11.27 11.09 11.84 11.09C12.67 11.09 13.34 10.41 13.34 9.58C13.34 8.75 12.67 8.08 11.84 8.08C11.27 8.08 10.78 8.39 10.52 8.86V4.51Z" fill="white" fill-opacity="0.4"/><path d="M7.52 5.26L4.51 4.51V15.79L7.52 16.54V5.26Z" fill="white" fill-opacity="0.4"/><path d="M13.53 5.26L16.54 4.51V15.79L13.53 16.54V5.26Z" fill="white" fill-opacity="0.4"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10.52 4.51L7.52 5.26V16.54L10.52 15.79V10.31C10.4 10.1 10.34 9.85 10.34 9.58C10.34 9.32 10.4 9.07 10.52 8.86V4.51Z" fill="white" fill-opacity="0.4"/><path d="M1.5 5.26L4.51 4.51V15.79L1.5 16.54V5.26Z" fill="white" fill-opacity="0.4"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12.06 14.28C12.7 13.72 14.47 11.93 14.47 9.69C14.47 8.32 13.65 6.95 11.84 6.95C10.03 6.95 9.21 8.32 9.21 9.69C9.21 11.93 10.98 13.72 11.62 14.28C11.75 14.4 11.93 14.4 12.06 14.28ZM11.84 11.09C12.67 11.09 13.34 10.41 13.34 9.58C13.34 8.75 12.67 8.08 11.84 8.08C11.01 8.08 10.34 8.75 10.34 9.58C10.34 10.41 11.01 11.09 11.84 11.09Z" fill="white" fill-opacity="0.6"/></g><defs><filter id="f_d_alm" x="0.75" y="0.75" width="21" height="18" filterUnits="userSpaceOnUse"><feOffset dx="0.75" dy="0.75"/><feGaussianBlur stdDeviation="0.75"/><feColorMatrix type="matrix" values="0 0 0 0 0.545 0 0 0 0 0.823 0 0 0 0 0.192 0 0 0 0.4 0"/><feBlend mode="normal" in="SourceGraphic" result="shape"/></filter><filter id="f1_d_alm" x="3" y="0" width="18" height="14" filterUnits="userSpaceOnUse"><feGaussianBlur stdDeviation="0.75"/><feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.8 0"/><feBlend mode="normal" in="SourceGraphic" result="shape"/></filter><linearGradient id="p0_lin_alm" x1="12" y1="1.5" x2="12" y2="12.8" gradientUnits="userSpaceOnUse"><stop stop-color="#93DF32"/><stop offset="1" stop-color="#70BD0D"/></linearGradient></defs></svg>`;
        const ICON_LUAS = `<svg class="w-6 h-6 shrink-0" viewBox="0 0 21 23" fill="none" xmlns="http://www.w3.org/2000/svg"><g filter="url(#f_d_ls)"><g filter="url(#f1_d_ls)"><path d="M9.99 6.92C9.99 6.49 10.34 6.15 10.76 6.15H17.68C18.1 6.15 18.45 6.49 18.45 6.92V16.14C18.45 16.57 18.1 16.91 17.68 16.91H10.76C10.34 16.91 9.99 16.57 9.99 16.14V6.92Z" fill="url(#p0_lin_ls)"/></g><g filter="url(#f2_d_ls)"><path d="M5.38 2.31C5.38 1.88 5.72 1.54 6.15 1.54H11.53C11.95 1.54 12.3 1.88 12.3 2.31V16.14C12.3 16.57 11.95 16.91 11.53 16.91H6.15C5.72 16.91 5.38 16.57 5.38 16.14V2.31Z" fill="url(#p1_lin_ls)"/></g><path d="M1.54 5.38C1.54 4.96 1.88 4.61 2.31 4.61H7.69C8.11 4.61 8.46 4.96 8.46 5.38V19.22C8.46 19.64 8.11 19.99 7.69 19.99H2.31C1.88 19.99 1.54 19.64 1.54 19.22V5.38Z" fill="white" fill-opacity="0.4"/></g><defs><filter id="f_d_ls" x="0.76" y="0.76" width="20" height="21.5" filterUnits="userSpaceOnUse"><feOffset dx="0.76" dy="0.76"/><feGaussianBlur stdDeviation="0.76"/><feColorMatrix type="matrix" values="0 0 0 0 0.18 0 0 0 0 0.76 0 0 0 0 0.83 0 0 0 0.4 0"/><feBlend mode="normal" in="SourceGraphic" result="shape"/></filter><filter id="f1_d_ls" x="8.4" y="4.6" width="11.5" height="13.8" filterUnits="userSpaceOnUse"><feGaussianBlur stdDeviation="0.76"/><feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.8 0"/><feBlend mode="normal" in="SourceGraphic" result="shape"/></filter><filter id="f2_d_ls" x="3.8" y="0" width="10" height="18.5" filterUnits="userSpaceOnUse"><feGaussianBlur stdDeviation="0.76"/><feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.8 0"/><feBlend mode="normal" in="SourceGraphic" result="shape"/></filter><linearGradient id="p0_lin_ls" x1="14.2" y1="6.1" x2="14.2" y2="16.9" gradientUnits="userSpaceOnUse"><stop stop-color="#31C8D2"/><stop offset="1" stop-color="#1AA6E1"/></linearGradient><linearGradient id="p1_lin_ls" x1="8.8" y1="1.5" x2="8.8" y2="16.9" gradientUnits="userSpaceOnUse"><stop stop-color="#31C8D2"/><stop offset="1" stop-color="#1AA6E1"/></linearGradient></defs></svg>`;
        const ICON_JENIS = `<svg class="w-6 h-6 shrink-0" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg"><g filter="url(#f_d_jns)"><g filter="url(#f1_d_jns)"><path d="M4.51 3.01C4.51 2.18 5.18 1.5 6.01 1.5H18.04C18.87 1.5 19.54 2.18 19.54 3.01V11.28C19.54 12.11 18.87 12.78 18.04 12.78H6.01C5.18 12.78 4.51 12.11 4.51 11.28V3.01Z" fill="url(#p0_lin_jns)"/></g><path d="M1.5 5.26C1.5 4.85 1.84 4.51 2.25 4.51H15.79C16.2 4.51 16.54 4.85 16.54 5.26V6.77C16.54 7.18 16.2 7.52 15.79 7.52H2.25C1.84 7.52 1.5 7.18 1.5 6.77V5.26Z" fill="white" fill-opacity="0.4"/><path d="M1.5 8.64C1.5 8.44 1.67 8.27 1.88 8.27H14.66C14.87 8.27 15.03 8.44 15.03 8.64V10.15C15.03 10.36 14.87 10.52 14.66 10.52H1.88C1.67 10.52 1.5 10.36 1.5 10.15V8.64Z" fill="white" fill-opacity="0.4"/><path d="M1.5 11.65C1.5 11.44 1.67 11.28 1.88 11.28H8.64C8.85 11.28 9.02 11.44 9.02 11.65V12.4C9.02 12.61 8.85 12.78 8.64 12.78H1.88C1.67 12.78 1.5 12.61 1.5 12.4V11.65Z" fill="white" fill-opacity="0.4"/><path d="M11.22 16.68C12.1 18.11 13.71 18.11 14.63 18C16.48 17.78 17.78 16.73 17.41 13.23C17.31 12.26 16.57 11.86 15.69 12.45C15.36 11.51 13.75 11.78 13.84 12.67L13.64 10.73C13.56 10 13.16 9.31 12.33 9.41C11.5 9.5 11.5 10.49 11.6 11.41L11.96 14.87L11.17 13.98C10.91 13.76 10.24 13.15 9.7 13.41C9.17 13.67 9.08 14.23 9.37 14.68C9.65 15.14 10.65 15.76 11.22 16.68Z" fill="white" fill-opacity="0.6"/></g><defs><filter id="f_d_jns" x="0.75" y="0.75" width="21" height="19.5" filterUnits="userSpaceOnUse"><feOffset dx="0.75" dy="0.75"/><feGaussianBlur stdDeviation="0.75"/><feColorMatrix type="matrix" values="0 0 0 0 0.615 0 0 0 0 0.407 0 0 0 0 0.952 0 0 0 0.4 0"/><feBlend mode="normal" in="SourceGraphic" result="shape"/></filter><filter id="f1_d_jns" x="3" y="0" width="18" height="14.2" filterUnits="userSpaceOnUse"><feGaussianBlur stdDeviation="0.75"/><feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.8 0"/><feBlend mode="normal" in="SourceGraphic" result="shape"/></filter><linearGradient id="p0_lin_jns" x1="12" y1="1.5" x2="12" y2="12.8" gradientUnits="userSpaceOnUse"><stop stop-color="#6966FF"/><stop offset="1" stop-color="#9D68F3"/></linearGradient></defs></svg>`;
        const ICON_NILAI = `<svg class="w-6 h-6 shrink-0" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg"><g filter="url(#f_d_nl)"><g filter="url(#f1_d_nl)"><path d="M4.2 2.8C4.2 2.03 4.83 1.4 5.6 1.4H16.8C17.57 1.4 18.2 2.03 18.2 2.8V9.1C18.2 9.87 17.57 10.5 16.8 10.5H5.6C4.83 10.5 4.2 9.87 4.2 9.1V2.8Z" fill="url(#p0_lin_nl)"/></g><path d="M3.85 4.25C4.05 3.5 4.82 3.06 5.57 3.26L16.39 6.15C17.13 6.35 17.58 7.12 17.38 7.87L15.75 13.96C15.55 14.7 14.78 15.15 14.03 14.95L3.21 12.05C2.47 11.85 2.02 11.08 2.22 10.33L3.85 4.25Z" fill="white" fill-opacity="0.4"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1.4 7.35C1.4 6.58 2.03 5.95 2.8 5.95H14C14.77 5.95 15.4 6.58 15.4 7.35V13.65C15.4 14.42 14.77 15.05 14 15.05H2.8C2.03 15.05 1.4 14.42 1.4 13.65V7.35ZM10.5 10.5C10.5 12.24 9.56 13.65 8.4 13.65C7.24 13.65 6.3 12.24 6.3 10.5C6.3 8.76 7.24 7.35 8.4 7.35C9.56 7.35 10.5 8.76 10.5 10.5ZM3.85 7.7C3.85 8.09 3.54 8.4 3.15 8.4C2.76 8.4 2.45 8.09 2.45 7.7C2.45 7.31 2.76 7 3.15 7C3.54 7 3.85 7.31 3.85 7.7ZM14.35 7.7C14.35 8.09 14.04 8.4 13.65 8.4C13.26 8.4 12.95 8.09 12.95 7.7C12.95 7.31 13.26 7 13.65 7C14.04 7 14.35 7.31 14.35 7.7ZM3.15 14C3.54 14 3.85 13.69 3.85 13.3C3.85 12.91 3.54 12.6 3.15 12.6C2.76 12.6 2.45 12.91 2.45 13.3C2.45 13.69 2.76 14 3.15 14ZM14.35 13.3C14.35 13.69 14.04 14 13.65 14C13.26 14 12.95 13.69 12.95 13.3C12.95 12.91 13.26 12.6 13.65 12.6C14.04 12.6 14.35 12.91 14.35 13.3Z" fill="white" fill-opacity="0.4"/></g><defs><filter id="f_d_nl" x="0.7" y="0.7" width="19.6" height="16.4" filterUnits="userSpaceOnUse"><feOffset dx="0.7" dy="0.7"/><feGaussianBlur stdDeviation="0.7"/><feColorMatrix type="matrix" values="0 0 0 0 0.192 0 0 0 0 0.823 0 0 0 0 0.556 0 0 0 0.4 0"/><feBlend mode="normal" in="SourceGraphic" result="shape"/></filter><filter id="f1_d_nl" x="2.8" y="0" width="16.8" height="11.9" filterUnits="userSpaceOnUse"><feGaussianBlur stdDeviation="0.7"/><feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.8 0"/><feBlend mode="normal" in="SourceGraphic" result="shape"/></filter><linearGradient id="p0_lin_nl" x1="11.2" y1="1.4" x2="11.2" y2="10.5" gradientUnits="userSpaceOnUse"><stop stop-color="#21EB66"/><stop offset="1" stop-color="#12D583"/></linearGradient></defs></svg>`;
        const ICON_PERIODE = `<svg class="w-6 h-6 shrink-0" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g filter="url(#f_d_prd)"><g filter="url(#f1_d_prd)"><path d="M4.57 3.05C4.57 2.21 5.25 1.52 6.09 1.52H18.28C19.12 1.52 19.81 2.21 19.81 3.05V11.43C19.81 12.27 19.12 12.95 18.28 12.95H6.09C5.25 12.95 4.57 12.27 4.57 11.43V3.05Z" fill="url(#p0_lin_prd)"/></g><path d="M1.52 6.09V6.86H16.76V6.09C16.76 5.25 16.08 4.57 15.24 4.57H3.05C2.21 4.57 1.52 5.25 1.52 6.09Z" fill="white" fill-opacity="0.4"/><path fill-rule="evenodd" clip-rule="evenodd" d="M16.76 7.62V15.24C16.76 16.08 16.08 16.76 15.24 16.76H3.05C2.21 16.76 1.52 16.08 1.52 15.24V7.62H16.76ZM13.71 10.67C14.13 10.67 14.47 10.32 14.47 9.9C14.47 9.48 14.13 9.14 13.71 9.14C13.29 9.14 12.95 9.48 12.95 9.9C12.95 10.32 13.29 10.67 13.71 10.67Z" fill="white" fill-opacity="0.4"/></g><defs><filter id="f_d_prd" x="0.76" y="0.76" width="21.3" height="18.2" filterUnits="userSpaceOnUse"><feOffset dx="0.76" dy="0.76"/><feGaussianBlur stdDeviation="0.76"/><feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 0.627 0 0 0 0 0.07 0 0 0 0.4 0"/><feBlend mode="normal" in="SourceGraphic" result="shape"/></filter><filter id="f1_d_prd" x="3" y="0" width="18.2" height="14.4" filterUnits="userSpaceOnUse"><feGaussianBlur stdDeviation="0.76"/><feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.8 0"/><feBlend mode="normal" in="SourceGraphic" result="shape"/></filter><linearGradient id="p0_lin_prd" x1="12.2" y1="1.5" x2="12.2" y2="12.9" gradientUnits="userSpaceOnUse"><stop stop-color="#FFA800"/><stop offset="1" stop-color="#FF7A00"/></linearGradient></defs></svg>`;

        // Template HTML untuk kartu popup aset
        function createPopupCardHTML(asset, id) {
            const googleMapsUrl = (asset.latitude && asset.longitude) 
                ? `https://www.google.com/maps?q=${asset.latitude},${asset.longitude}` 
                : '#';

            return `
                <div class="w-[360px] sm:w-[410px] rounded-3xl bg-white p-7 shadow-[0_20px_50px_rgba(0,0,0,0.14)] border border-gray-100/90 font-sans text-left relative">
                    <div class="mb-4">
                        <div class="flex items-center gap-3">
                            ${ICON_CORP}
                            <h3 class="m-0 text-[21px] sm:text-[23px] font-bold leading-tight text-gray-950 truncate">${asset.name || '-'}</h3>
                        </div>
                        <p class="mt-2 text-sm font-medium text-gray-400 pl-10 truncate">${(asset.code ? asset.code + ' • ' : '') + (asset.location || '')}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-x-5 gap-y-4 pt-2">
                        <div class="flex items-start gap-2.5">
                            <div class="shrink-0 mt-0.5">${ICON_ALAMAT}</div>
                            <div class="min-w-0">
                                <span class="block text-xs font-semibold text-gray-900">Alamat</span>
                                <span class="block text-xs text-gray-500 mt-0.5 leading-snug break-words">${asset.address || '-'}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-2.5">
                            <div class="shrink-0 mt-0.5">${ICON_LUAS}</div>
                            <div class="min-w-0">
                                <span class="block text-xs font-semibold text-gray-900">Luas</span>
                                <span class="block text-xs text-gray-500 mt-0.5 leading-snug">${asset.area || '-'}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-2.5">
                            <div class="shrink-0 mt-0.5">${ICON_JENIS}</div>
                            <div class="min-w-0">
                                <span class="block text-xs font-semibold text-gray-900">Jenis Aset</span>
                                <span class="block text-xs text-gray-500 mt-0.5 leading-snug break-words">${asset.type || '-'}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-2.5">
                            <div class="shrink-0 mt-0.5">${ICON_NILAI}</div>
                            <div class="min-w-0">
                                <span class="block text-xs font-semibold text-gray-900">Nilai Aset</span>
                                <span class="block text-xs text-gray-500 mt-0.5 leading-snug">${asset.value || '-'}</span>
                            </div>
                        </div>

                        <div class="col-span-2 flex items-start gap-2.5">
                            <div class="shrink-0 mt-0.5">${ICON_PERIODE}</div>
                            <div class="min-w-0">
                                <span class="block text-xs font-semibold text-gray-900">Periode</span>
                                <span class="block text-xs text-gray-500 mt-0.5 leading-snug">${asset.period || '-'}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <a href="/asset/${id}" class="btn-detail-lanjutan flex-1 text-center cursor-pointer rounded-xl bg-[#0066FF] py-3 px-4 text-sm font-semibold !text-white transition hover:bg-blue-700 shadow-sm inline-block" style="color: #ffffff !important;">Detail Lanjutan</a>
                        <a href="${googleMapsUrl}" target="_blank" class="btn-buka-maps w-[125px] text-center cursor-pointer rounded-xl border border-gray-300 bg-white py-3 px-4 text-sm font-medium text-gray-600 transition hover:bg-gray-50 inline-block">Buka Maps</a>
                    </div>
                </div>
            `;
        }

        // Render marker aset dan popup info
        function renderMarkers() {
            Object.entries(assets).forEach(([id, asset]) => {
                const lat = parseFloat(asset.latitude);
                const lng = parseFloat(asset.longitude);

                if (!isNaN(lat) && !isNaN(lng)) {
                    const marker = L.marker([lat, lng], { icon: redPinIcon }).addTo(map);

                    const popup = L.popup({
                        offset: [0, -16],
                        closeButton: false,
                        autoPan: false,
                        className: 'custom-asset-leaflet-popup'
                    }).setContent(createPopupCardHTML(asset, id));

                    marker.bindPopup(popup);

                    marker.on('click', function(e) {
                        L.DomEvent.stopPropagation(e);
                        
                        const baseZoom = baseIndonesiaZoom || map.getMinZoom() || 5;
                        const pointZoomLevel = baseZoom + 1.2;

                        const projected = map.project([lat, lng], pointZoomLevel);
                        const targetCenter = map.unproject(projected.subtract([0, 150]), pointZoomLevel);

                        map.flyTo(targetCenter, pointZoomLevel, {
                            duration: 0.65
                        });

                        marker.openPopup();
                    });
                }
            });
        }

        map.on('popupclose', function() {
            fitIndonesiaBounds();
        });

        // Kontrol modal filter
        const filterButton = document.getElementById('filterButton');
        const filterModal = document.getElementById('filterModal');
        const filterOverlay = document.getElementById('filterOverlay');
        const closeFilter = document.getElementById('closeFilter');
        const applyFilter = document.getElementById('applyFilter');
        const resetFilter = document.getElementById('resetFilter');

        function openFilter() {
            filterModal.classList.remove('invisible', 'opacity-0', 'scale-95', 'pointer-events-none');
            filterModal.classList.add('visible', 'opacity-100', 'scale-100', 'pointer-events-auto');

            filterOverlay.classList.remove('invisible', 'opacity-0');
            filterOverlay.classList.add('visible', 'opacity-100');
        }

        function closeFilterModal() {
            filterModal.classList.remove('visible', 'opacity-100', 'scale-100', 'pointer-events-auto');
            filterModal.classList.add('invisible', 'opacity-0', 'scale-95', 'pointer-events-none');

            filterOverlay.classList.remove('visible', 'opacity-100');
            filterOverlay.classList.add('invisible', 'opacity-0');
        }

        filterButton.addEventListener('click', function(e) {
            e.stopPropagation();
            openFilter();
        });

        closeFilter.addEventListener('click', function(e) {
            e.stopPropagation();
            closeFilterModal();
        });

        filterOverlay.addEventListener('click', function() {
            closeFilterModal();
        });

        applyFilter.addEventListener('click', function() {
            closeFilterModal();
        });

        resetFilter.addEventListener('click', function() {
            document.querySelectorAll('#filterModal select').forEach(sel => sel.selectedIndex = 0);
            closeFilterModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFilterModal();
                map.closePopup();
            }
        });
    </script>
</body>
</html>