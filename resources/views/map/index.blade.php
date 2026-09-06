<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">

    <title>{{ config('app.name', 'KAI Tracker') }} — Peta</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Anti-FOUC Auto Theme Script (WIB 17:00 - 07:00 Auto Dark Mode) -->
    <x-theme-script />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite([
            'resources/css/app.css',
            'resources/js/app.js',
        ])
    @endif

    <!-- Clean Console Handler (Meredam warning usang Leaflet & error file:// dari ekstensi browser) -->
    <script>
        (function () {
            const origWarn = console.warn;
            const origError = console.error;

            console.warn = function (...args) {
                const msg = args.map(a => (typeof a === 'object' ? JSON.stringify(a) : (a || ''))).join(' ');
                if (msg.includes('mozPressure') || msg.includes('mozInputSource')) {
                    return;
                }
                origWarn.apply(console, args);
            };

            console.error = function (...args) {
                const msg = args.map(a => (typeof a === 'object' ? JSON.stringify(a) : (a || ''))).join(' ');
                if (msg.includes('may not load or link to file') || msg.includes('Security Error') || msg.includes('file:///')) {
                    return;
                }
                origError.apply(console, args);
            };
        })();
    </script>

    {{-- Leaflet JS & CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        .tool-active-bg {
            background-color: rgba(229, 231, 235, 0.8) !important;
        }

        .dark .tool-active-bg {
            background-color: rgba(255, 255, 255, 0.15) !important;
        }

        #map {
            background-color: #F6F7F9 !important;
            cursor: grab !important;
        }

        .dark #map {
            background-color: #282A2C !important;
        }

        #map:active,
        #map.leaflet-drag-target {
            cursor: grabbing !important;
        }

        .leaflet-container {
            background: #F6F7F9 !important;
            font-family: inherit;
            outline: none;
            cursor: grab !important;
        }

        .dark .leaflet-container {
            background: #282A2C !important;
        }

        .leaflet-container:active,
        .leaflet-container.leaflet-drag-target {
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

        .leaflet-container a.btn-buka-maps {
            background-color: #ffffff !important;
            border-color: #e5e7eb !important;
            color: #374151 !important;
            text-decoration: none !important;
        }

        .leaflet-container a.btn-buka-maps * {
            color: #374151 !important;
        }

        .dark .leaflet-container a.btn-buka-maps {
            background-color: #2D3034 !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
            text-decoration: none !important;
        }

        .dark .leaflet-container a.btn-buka-maps * {
            color: #ffffff !important;
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

        .kabupaten-label-wrapper {
            background: transparent !important;
            border: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            pointer-events: none !important;
        }

        .kabupaten-label-badge {
            display: inline-block;
            letter-spacing: -0.01em;
            line-height: 1.2;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
        }

        /* Mobile Asset Bottom Sheet Drawer (Rounded Top & Custom Buttons) */
        #mobileAssetBottomSheet,
        #mobileFilterBottomSheet {
            border-top-left-radius: 36px !important;
            border-top-right-radius: 36px !important;
            border-bottom-left-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
            overflow: hidden !important;
            box-shadow: 0 -16px 50px rgba(0, 0, 0, 0.22) !important;
        }

        .dark #mobileAssetBottomSheet,
        .dark #mobileFilterBottomSheet {
            box-shadow: 0 -16px 50px rgba(0, 0, 0, 0.85) !important;
        }

        .mobile-btn-detail {
            height: 48px !important;
            min-height: 48px !important;
            border-radius: 14px !important;
            background-color: #0066FF !important;
            color: #ffffff !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            text-decoration: none !important;
            flex: 1 1 0% !important;
            border: none !important;
            outline: none !important;
            cursor: pointer !important;
            user-select: none !important;
            transition: background-color 0.2s ease !important;
        }

        .mobile-btn-detail:hover {
            background-color: #0052cc !important;
        }

        .mobile-btn-maps {
            height: 48px !important;
            min-height: 48px !important;
            border-radius: 14px !important;
            background-color: #ffffff !important;
            border: 1.5px solid #D1D5DB !important;
            color: #71717A !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            text-decoration: none !important;
            flex: 1 1 0% !important;
            cursor: pointer !important;
            user-select: none !important;
            transition: background-color 0.2s ease, border-color 0.2s ease !important;
        }

        .mobile-btn-maps:hover {
            background-color: #F9FAFB !important;
        }

        .dark .mobile-btn-maps {
            background-color: #2D3034 !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
            color: #D1D5DB !important;
        }

        .dark .mobile-btn-maps:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }
    </style>
</head>

<body
    class="h-screen overflow-hidden bg-[#F6F7F9] dark:bg-[#282A2C] font-sans antialiased text-gray-900 dark:text-gray-100 selection:bg-blue-100 selection:text-blue-600 relative transition-colors duration-200">

    {{-- Navbar --}}
    <x-navbar active="map" />

    {{-- Header: Judul Heatmaps, Tools Zoom, & Tombol Filter (z-50) --}}
    <div class="relative z-50 w-full max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 pointer-events-none">

        {{-- Mobile: Left (Title + Tools underneath) and Right (Filter button) --}}
        <div class="flex items-start justify-between lg:hidden">
            <div class="pointer-events-auto flex flex-col gap-2">
                <h1 class="text-[22px] font-bold text-gray-950 dark:text-white tracking-tight leading-tight">
                    Heatmaps
                </h1>

                {{-- Zoom tools underneath Heatmaps text --}}
                <div class="flex items-center gap-1.5">
                    <button id="zoomInButton" type="button" onclick="if(window.mapZoomIn) window.mapZoomIn();"
                        class="w-9 h-9 flex items-center justify-center rounded-[8px] border border-[#8E8E8E] dark:border-white/15 bg-white/90 dark:bg-[#34383D]/90 backdrop-blur-sm hover:bg-gray-100 dark:hover:bg-[#40454B] active:bg-gray-200 text-gray-700 dark:text-white transition cursor-pointer shadow-xs"
                        title="Zoom In">
                        <x-icon name="zoom-in" class="w-4 h-4" />
                    </button>
                    <button id="zoomOutButton" type="button" onclick="if(window.mapZoomOut) window.mapZoomOut();"
                        class="w-9 h-9 flex items-center justify-center rounded-[8px] border border-[#8E8E8E] dark:border-white/15 bg-white/90 dark:bg-[#34383D]/90 backdrop-blur-sm hover:bg-gray-100 dark:hover:bg-[#40454B] active:bg-gray-200 text-gray-700 dark:text-white transition cursor-pointer shadow-xs"
                        title="Zoom Out">
                        <x-icon name="zoom-out" class="w-4 h-4" />
                    </button>
                    <button id="panToolButton" type="button" onclick="if(window.mapPanTool) window.mapPanTool();"
                        class="w-9 h-9 flex items-center justify-center rounded-[8px] border border-[#8E8E8E] dark:border-white/15 bg-white/90 dark:bg-[#34383D]/90 backdrop-blur-sm hover:bg-gray-100 dark:hover:bg-[#40454B] active:bg-gray-200 text-gray-700 dark:text-white transition cursor-pointer shadow-xs"
                        title="Pusatkan Peta Jawa Tengah">
                        <x-icon name="hand-pan" class="w-4 h-4 text-gray-600 dark:text-white" />
                    </button>
                </div>
            </div>

            <div class="pointer-events-auto">
                <button id="filterButton" type="button"
                    class="w-11 h-11 flex items-center justify-center rounded-[10px] bg-white dark:bg-[#1F2123] shadow-[0_4px_12px_rgba(0,0,0,0.08)] dark:shadow-none border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-[#2D3034] active:bg-gray-100 text-gray-800 dark:text-white transition cursor-pointer z-50 relative select-none"
                    style="cursor: pointer !important;" title="Filter Peta">
                    <x-icon name="filter-peta" class="w-5 h-5 text-gray-800 dark:text-white pointer-events-none" />
                </button>
            </div>
        </div>

        {{-- Desktop: single row (title + center tools + filter button) --}}
        <div class="hidden lg:flex items-center justify-between relative min-h-[44px]">
            <div class="pointer-events-auto">
                <h1 class="text-[30px] font-bold text-gray-950 dark:text-white tracking-tight">
                    Heatmaps
                </h1>
            </div>

            <div
                class="pointer-events-auto absolute left-1/2 -translate-x-1/2 flex items-center gap-[5px] bg-transparent">
                <button id="zoomInButtonDesktop" type="button" onclick="if(window.mapZoomIn) window.mapZoomIn();"
                    class="w-11 h-11 flex items-center justify-center rounded-[10px] border-2 border-[#8E8E8E] dark:border-white/20 bg-transparent hover:bg-gray-200/80 dark:hover:bg-[#34383D] active:bg-gray-300/80 text-gray-700 dark:text-white transition cursor-pointer"
                    title="Zoom In">
                    <x-icon name="zoom-in" class="w-6 h-6" />
                </button>
                <button id="zoomOutButtonDesktop" type="button" onclick="if(window.mapZoomOut) window.mapZoomOut();"
                    class="w-11 h-11 flex items-center justify-center rounded-[10px] border-2 border-[#8E8E8E] dark:border-white/20 bg-transparent hover:bg-gray-200/80 dark:hover:bg-[#34383D] active:bg-gray-300/80 text-gray-700 dark:text-white transition cursor-pointer"
                    title="Zoom Out">
                    <x-icon name="zoom-out" class="w-6 h-6" />
                </button>
                <button id="panToolButtonDesktop" type="button" onclick="if(window.mapPanTool) window.mapPanTool();"
                    class="w-11 h-11 flex items-center justify-center rounded-[10px] border-2 border-[#8E8E8E] dark:border-white/20 bg-transparent hover:bg-gray-200/80 dark:hover:bg-[#34383D] active:bg-gray-300/80 text-gray-700 dark:text-white transition cursor-pointer"
                    title="Pusatkan Peta Jawa Tengah">
                    <x-icon name="hand-pan" class="w-6 h-6 text-gray-600 dark:text-white" />
                </button>
            </div>

            <div class="pointer-events-auto">
                <button id="filterButtonDesktop" type="button"
                    class="w-11 h-11 sm:w-12 sm:h-12 flex items-center justify-center rounded-[10px] bg-white dark:bg-[#1F2123] shadow-[0_4px_12px_rgba(0,0,0,0.06)] dark:shadow-none border border-gray-100 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-[#2D3034] active:bg-gray-100 text-gray-800 dark:text-white transition-transform duration-300 ease-in-out cursor-pointer z-50 relative select-none"
                    style="cursor: pointer !important;" title="Filter Peta">
                    <x-icon name="filter-peta" class="w-6 h-6 text-gray-800 dark:text-white pointer-events-none" />
                </button>
            </div>
        </div>
    </div>

    {{-- Map Canvas --}}
    <div id="map" class="absolute inset-0 z-0 h-screen w-full"></div>

    {{-- Overlay Background Filter (z-40 di bawah modal z-50 dan tombol z-50) --}}
    <div id="filterOverlay"
        class="invisible fixed inset-0 z-40 bg-black/[0.12] opacity-0 transition-all duration-300 pointer-events-auto">
    </div>

    {{-- Mobile Asset Bottom Sheet Overlay (z-[130] di atas bottom navbar z-[120]) --}}
    <div id="mobileAssetBottomSheetOverlay"
        class="invisible fixed inset-0 z-[130] bg-black/40 backdrop-blur-[2px] opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"
        onclick="closeMobileAssetBottomSheet()">
    </div>

    {{-- Mobile Asset Bottom Sheet Modal (Drawer dari Bawah z-[140] menutupi navbar sepenuhnya) --}}
    <div id="mobileAssetBottomSheet"
        class="invisible fixed inset-x-0 bottom-0 z-[140] max-h-[90vh] bg-white dark:bg-[#1F2123] rounded-t-[36px] sm:rounded-t-[40px] shadow-[0_-16px_50px_rgba(0,0,0,0.22)] dark:shadow-[0_-16px_50px_rgba(0,0,0,0.85)] border-t border-x border-gray-100 dark:border-white/10 transform translate-y-full opacity-0 transition-all duration-300 ease-out pointer-events-none flex flex-col lg:hidden overflow-hidden" style="padding-bottom: max(1.5rem, env(safe-area-inset-bottom, 1.5rem));">
        
        {{-- Content Container --}}
        <div id="mobileAssetBottomSheetContent" class="overflow-y-auto px-6 pt-7 pb-4 sm:px-8 sm:pt-8 sm:pb-6">
        </div>
    </div>

    {{-- ================= MOBILE FILTER BOTTOM SHEET (DRAWER DARI BAWAH) ================= --}}
    {{-- Mobile Filter Bottom Sheet Overlay --}}
    <div id="mobileFilterOverlay"
        class="invisible fixed inset-0 z-[130] bg-black/40 backdrop-blur-[2px] opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"
        onclick="closeFilterModal()">
    </div>

    {{-- Mobile Filter Bottom Sheet Modal (Persis Gambar Referensi User) --}}
    <div id="mobileFilterBottomSheet"
        class="invisible fixed inset-x-0 bottom-0 z-[140] max-h-[90vh] bg-white dark:bg-[#1F2123] rounded-t-[36px] sm:rounded-t-[40px] shadow-[0_-16px_50px_rgba(0,0,0,0.22)] dark:shadow-[0_-16px_50px_rgba(0,0,0,0.85)] border-t border-x border-gray-100 dark:border-white/10 transform translate-y-full opacity-0 transition-all duration-300 ease-out pointer-events-none flex flex-col lg:hidden overflow-hidden"
        style="border-top-left-radius: 36px !important; border-top-right-radius: 36px !important; padding-bottom: max(1.25rem, env(safe-area-inset-bottom, 1.25rem));">

        {{-- Mobile Filter Header: Title + Badge Active Count + Close 'X' Button --}}
        <div class="px-6 pt-6 pb-3.5 flex items-center justify-between border-b border-gray-100 dark:border-white/10 shrink-0">
            <div class="flex items-center gap-2.5">
                <h2 class="text-lg font-bold text-gray-950 dark:text-white tracking-tight">
                    Filter Peta
                </h2>
                <span id="mobileActiveFilterBadge"
                    class="hidden w-6 h-6 items-center justify-center text-xs font-bold text-[#0066FF] dark:text-[#3B82F6] bg-blue-50 dark:bg-blue-600/20 rounded-full select-none">
                    0
                </span>
            </div>

            <button type="button" onclick="closeFilterModal()"
                class="w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 transition cursor-pointer select-none"
                aria-label="Tutup Filter">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Mobile Filter Content Body --}}
        <div class="overflow-y-auto px-6 py-4 flex-1">
            <div class="grid grid-cols-2 gap-x-3.5 gap-y-3.5">
                {{-- 1. STASIUN --}}
                <div class="flex flex-col">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-[#9AA0A6] mb-1.5">
                        <x-icon name="subway" class="w-4 h-4 shrink-0 text-gray-400 dark:text-[#9AA0A6]" />
                        Stasiun
                    </label>
                    <div class="relative custom-filter-container" data-filter-id="stasiun">
                        <button type="button"
                            class="filter-dropdown-btn flex items-center justify-between w-full h-[44px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-xl px-3 py-2 transition cursor-pointer">
                            <span class="filter-selected-label text-[#8B8B8B] dark:text-[#9AA0A6] font-medium text-xs truncate select-none">Semua Stasiun</span>
                            <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 dark:text-[#9AA0A6] shrink-0 ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                        </button>
                        <div class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[140px] max-h-[190px] overflow-y-auto rounded-xl bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1 flex flex-col gap-0.5">
                            <button type="button" onclick="selectMapFilter('stasiun', '', 'Semua Stasiun')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg transition text-left cursor-pointer">
                                <span>Semua Stasiun</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('stasiun', 'gambir', 'Gambir')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Gambir</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('stasiun', 'bandung', 'Bandung')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Bandung</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('stasiun', 'surabaya', 'Surabaya')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Surabaya</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('stasiun', 'semarang', 'Semarang Poncol')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Semarang Poncol</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('stasiun', 'pekalongan', 'Pekalongan')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Pekalongan</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('stasiun', 'tegal', 'Tegal')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Tegal</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 2. WILAYAH --}}
                <div class="flex flex-col">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-[#9AA0A6] mb-1.5">
                        <x-icon name="explore_nearby" class="w-4 h-4 shrink-0 text-gray-400 dark:text-[#9AA0A6]" />
                        Wilayah
                    </label>
                    <div class="relative custom-filter-container" data-filter-id="wilayah">
                        <button type="button"
                            class="filter-dropdown-btn flex items-center justify-between w-full h-[44px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-xl px-3 py-2 transition cursor-pointer">
                            <span class="filter-selected-label text-[#8B8B8B] dark:text-[#9AA0A6] font-medium text-xs truncate select-none">Row & Non Row</span>
                            <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 dark:text-[#9AA0A6] shrink-0 ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                        </button>
                        <div class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[140px] max-h-[190px] overflow-y-auto rounded-xl bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1 flex flex-col gap-0.5">
                            <button type="button" onclick="selectMapFilter('wilayah', '', 'Row & Non Row')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg transition text-left cursor-pointer">
                                <span>Row & Non Row</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('wilayah', 'row', 'Row')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Row</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('wilayah', 'non-row', 'Non Row')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Non Row</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 3. ASET --}}
                <div class="flex flex-col">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-[#9AA0A6] mb-1.5">
                        <x-icon name="aset-icon" class="w-4 h-4 shrink-0 text-gray-400 dark:text-[#9AA0A6]" />
                        Aset
                    </label>
                    <div class="relative custom-filter-container" data-filter-id="aset">
                        <button type="button"
                            class="filter-dropdown-btn flex items-center justify-between w-full h-[44px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-xl px-3 py-2 transition cursor-pointer">
                            <span class="filter-selected-label text-[#8B8B8B] dark:text-[#9AA0A6] font-medium text-xs truncate select-none">Semua Aset</span>
                            <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 dark:text-[#9AA0A6] shrink-0 ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                        </button>
                        <div class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[140px] max-h-[190px] overflow-y-auto rounded-xl bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1 flex flex-col gap-0.5">
                            <button type="button" onclick="selectMapFilter('aset', '', 'Semua Aset')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg transition text-left cursor-pointer">
                                <span>Semua Aset</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('aset', 'tanah', 'Tanah')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Tanah</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('aset', 'bangunan', 'Bangunan')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Bangunan</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 4. JENIS KONTRAK --}}
                <div class="flex flex-col">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-[#9AA0A6] mb-1.5">
                        <x-icon name="contract-icon" class="w-4 h-4 shrink-0 text-gray-400 dark:text-[#9AA0A6]" />
                        Jenis Kontrak
                    </label>
                    <div class="relative custom-filter-container" data-filter-id="jenis_kontrak">
                        <button type="button"
                            class="filter-dropdown-btn flex items-center justify-between w-full h-[44px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-xl px-3 py-2 transition cursor-pointer">
                            <span class="filter-selected-label text-[#8B8B8B] dark:text-[#9AA0A6] font-medium text-xs truncate select-none">Semua Kontrak</span>
                            <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 dark:text-[#9AA0A6] shrink-0 ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                        </button>
                        <div class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[140px] max-h-[190px] overflow-y-auto rounded-xl bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1 flex flex-col gap-0.5">
                            <button type="button" onclick="selectMapFilter('jenis_kontrak', '', 'Semua Kontrak')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg transition text-left cursor-pointer">
                                <span>Semua Kontrak</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('jenis_kontrak', 'sewa', 'Sewa')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Sewa</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('jenis_kontrak', 'kerjasama', 'Kerja Sama')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Kerja Sama</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 5. JENIS PENDAPATAN --}}
                <div class="flex flex-col">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-[#9AA0A6] mb-1.5">
                        <x-icon name="jenis-pendapatan-icon" class="w-4 h-4 shrink-0 text-gray-400 dark:text-[#9AA0A6]" />
                        Jenis Pendapatan
                    </label>
                    <div class="relative custom-filter-container" data-filter-id="jenis_pendapatan">
                        <button type="button"
                            class="filter-dropdown-btn flex items-center justify-between w-full h-[44px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-xl px-3 py-2 transition cursor-pointer">
                            <span class="filter-selected-label text-[#8B8B8B] dark:text-[#9AA0A6] font-medium text-xs truncate select-none">Semua Pend...</span>
                            <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 dark:text-[#9AA0A6] shrink-0 ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                        </button>
                        <div class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[140px] max-h-[190px] overflow-y-auto rounded-xl bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1 flex flex-col gap-0.5">
                            <button type="button" onclick="selectMapFilter('jenis_pendapatan', '', 'Semua Pend...')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg transition text-left cursor-pointer">
                                <span>Semua Pend...</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('jenis_pendapatan', 'sewa', 'Sewa')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Sewa</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('jenis_pendapatan', 'iklan', 'Iklan')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Iklan</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('jenis_pendapatan', 'lainnya', 'Lainnya')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>Lainnya</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 6. SPV --}}
                <div class="flex flex-col">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-[#9AA0A6] mb-1.5">
                        <x-icon name="spv-icon" class="w-4 h-4 shrink-0 text-gray-400 dark:text-[#9AA0A6]" />
                        SPV
                    </label>
                    <div class="relative custom-filter-container" data-filter-id="spv">
                        <button type="button"
                            class="filter-dropdown-btn flex items-center justify-between w-full h-[44px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-xl px-3 py-2 transition cursor-pointer">
                            <span class="filter-selected-label text-[#8B8B8B] dark:text-[#9AA0A6] font-medium text-xs truncate select-none">Semua SPV</span>
                            <x-icon name="chevron-down" class="w-3.5 h-3.5 text-gray-400 dark:text-[#9AA0A6] shrink-0 ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                        </button>
                        <div class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[140px] max-h-[190px] overflow-y-auto rounded-xl bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1 flex flex-col gap-0.5">
                            <button type="button" onclick="selectMapFilter('spv', '', 'Semua SPV')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg transition text-left cursor-pointer">
                                <span>Semua SPV</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('spv', 'spv1', 'SPV 1')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>SPV 1</span>
                            </button>
                            <button type="button" onclick="selectMapFilter('spv', 'spv2', 'SPV 2')" class="filter-option-btn flex items-center justify-between w-full px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition text-left cursor-pointer">
                                <span>SPV 2</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile Filter Footer: Reset filters (Link) & Apply filters (Solid Button) Persis Gambar --}}
        <div class="px-6 pt-3 flex items-center justify-between shrink-0 border-t border-gray-100 dark:border-white/10">
            <button id="resetFilterMobile" type="button"
                class="text-sm font-semibold text-[#0066FF] dark:text-[#3B82F6] hover:underline cursor-pointer select-none transition py-2 px-1">
                Reset filter
            </button>

            <button id="applyFilterMobile" type="button"
                class="h-[48px] px-7 rounded-[14px] bg-[#0066FF] hover:bg-blue-700 text-sm font-semibold text-white transition shadow-sm cursor-pointer select-none flex items-center justify-center">
                Terapkan Filter
            </button>
        </div>
    </div>

    {{-- ================= DESKTOP FILTER MODAL (ASIDE FLOATING DARI KANAN) ================= --}}
    <aside id="filterModal"
        class="hidden lg:flex fixed right-3 sm:right-6 lg:right-10 top-16 sm:top-20 bottom-24 lg:bottom-8 z-50 w-[373px] bg-white dark:bg-[#1F2123] rounded-2xl lg:rounded-[10px] p-4 sm:p-6 lg:p-7 shadow-[0_20px_50px_rgba(0,0,0,0.14)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.6)] border border-gray-100/90 dark:border-white/5 transition-all duration-300 ease-in-out transform translate-x-[140%] opacity-0 pointer-events-none flex-col justify-start overflow-y-auto">
        <div class="mb-3 sm:mb-5 lg:mb-6 flex items-center justify-between">
            <h2 class="text-base sm:text-lg lg:text-[20px] font-bold text-gray-950 dark:text-white tracking-tight">
                Filter Peta
            </h2>
        </div>

        {{-- Hidden Inputs for Shared Filter State --}}
        <input type="hidden" id="stasiun" name="stasiun" value="">
        <input type="hidden" id="wilayah" name="wilayah" value="">
        <input type="hidden" id="aset" name="aset" value="">
        <input type="hidden" id="jenis_kontrak" name="jenis_kontrak" value="">
        <input type="hidden" id="jenis_pendapatan" name="jenis_pendapatan" value="">
        <input type="hidden" id="spv" name="spv" value="">

        {{-- FILTER 2-COLUMN GRID (DESKTOP) --}}
        <div class="grid grid-cols-2 gap-x-2.5 sm:gap-x-4 gap-y-3 sm:gap-y-5">

            {{-- 1. STASIUN --}}
            <div class="flex flex-col">
                <label
                    class="flex items-center gap-1 sm:gap-[6px] text-[11px] sm:text-xs lg:text-sm font-semibold text-gray-700 dark:text-[#9AA0A6] mb-1 sm:mb-[6px]">
                    <x-icon name="subway"
                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 lg:w-5 lg:h-5 shrink-0 text-gray-400 dark:text-[#9AA0A6]" />
                    Stasiun
                </label>
                <div class="relative custom-filter-container" data-filter-id="stasiun">
                    <button type="button"
                        class="filter-dropdown-btn flex items-center justify-between w-full h-[36px] sm:h-[42px] lg:h-[46px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3.5 py-1.5 sm:py-2 transition cursor-pointer">
                        <span
                            class="filter-selected-label text-[#8B8B8B] dark:text-[#9AA0A6] font-medium text-[11px] sm:text-xs lg:text-[13px] truncate select-none">Semua
                            Stasiun</span>
                        <x-icon name="chevron-down"
                            class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 dark:text-[#9AA0A6] shrink-0 ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                    </button>
                    <div
                        class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[140px] max-h-[200px] overflow-y-auto rounded-xl lg:rounded-2xl bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1 sm:p-1.5 flex flex-col gap-0.5">
                        <button type="button" onclick="selectMapFilter('stasiun', '', 'Semua Stasiun')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Semua Stasiun</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('stasiun', 'gambir', 'Gambir')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Gambir</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('stasiun', 'bandung', 'Bandung')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Bandung</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('stasiun', 'surabaya', 'Surabaya')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Surabaya</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('stasiun', 'semarang', 'Semarang Poncol')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Semarang Poncol</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('stasiun', 'pekalongan', 'Pekalongan')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Pekalongan</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('stasiun', 'tegal', 'Tegal')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Tegal</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- 2. WILAYAH --}}
            <div class="flex flex-col">
                <label
                    class="flex items-center gap-1 sm:gap-[6px] text-[11px] sm:text-xs lg:text-sm font-semibold text-gray-700 dark:text-[#9AA0A6] mb-1 sm:mb-[6px]">
                    <x-icon name="explore_nearby"
                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 lg:w-5 lg:h-5 shrink-0 text-gray-400 dark:text-[#9AA0A6]" />
                    Wilayah
                </label>
                <div class="relative custom-filter-container" data-filter-id="wilayah">
                    <button type="button"
                        class="filter-dropdown-btn flex items-center justify-between w-full h-[36px] sm:h-[42px] lg:h-[46px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3.5 py-1.5 sm:py-2 transition cursor-pointer">
                        <span
                            class="filter-selected-label text-[#8B8B8B] dark:text-[#9AA0A6] font-medium text-[11px] sm:text-xs lg:text-[13px] truncate select-none">Row
                            & Non Row</span>
                        <x-icon name="chevron-down"
                            class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 dark:text-[#9AA0A6] shrink-0 ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                    </button>
                    <div
                        class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[140px] max-h-[200px] overflow-y-auto rounded-xl lg:rounded-2xl bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1 sm:p-1.5 flex flex-col gap-0.5">
                        <button type="button" onclick="selectMapFilter('wilayah', '', 'Row & Non Row')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Row & Non Row</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('wilayah', 'row', 'Row')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Row</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('wilayah', 'non-row', 'Non Row')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Non Row</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- 3. ASET --}}
            <div class="flex flex-col">
                <label
                    class="flex items-center gap-1 sm:gap-[6px] text-[11px] sm:text-xs lg:text-sm font-semibold text-gray-700 dark:text-[#9AA0A6] mb-1 sm:mb-[6px]">
                    <x-icon name="aset-icon"
                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 lg:w-5 lg:h-5 shrink-0 text-gray-400 dark:text-[#9AA0A6]" />
                    Aset
                </label>
                <div class="relative custom-filter-container" data-filter-id="aset">
                    <button type="button"
                        class="filter-dropdown-btn flex items-center justify-between w-full h-[36px] sm:h-[42px] lg:h-[46px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3.5 py-1.5 sm:py-2 transition cursor-pointer">
                        <span
                            class="filter-selected-label text-[#8B8B8B] dark:text-[#9AA0A6] font-medium text-[11px] sm:text-xs lg:text-[13px] truncate select-none">Semua
                            Aset</span>
                        <x-icon name="chevron-down"
                            class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 dark:text-[#9AA0A6] shrink-0 ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                    </button>
                    <div
                        class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[140px] max-h-[200px] overflow-y-auto rounded-xl lg:rounded-2xl bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1 sm:p-1.5 flex flex-col gap-0.5">
                        <button type="button" onclick="selectMapFilter('aset', '', 'Semua Aset')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Semua Aset</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('aset', 'tanah', 'Tanah')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Tanah</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('aset', 'bangunan', 'Bangunan')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Bangunan</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- 4. JENIS KONTRAK --}}
            <div class="flex flex-col">
                <label
                    class="flex items-center gap-1 sm:gap-[6px] text-[11px] sm:text-xs lg:text-sm font-semibold text-gray-700 dark:text-[#9AA0A6] mb-1 sm:mb-[6px]">
                    <x-icon name="contract-icon"
                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 lg:w-5 lg:h-5 shrink-0 text-gray-400 dark:text-[#9AA0A6]" />
                    Jenis Kontrak
                </label>
                <div class="relative custom-filter-container" data-filter-id="jenis_kontrak">
                    <button type="button"
                        class="filter-dropdown-btn flex items-center justify-between w-full h-[36px] sm:h-[42px] lg:h-[46px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3.5 py-1.5 sm:py-2 transition cursor-pointer">
                        <span
                            class="filter-selected-label text-[#8B8B8B] dark:text-[#9AA0A6] font-medium text-[11px] sm:text-xs lg:text-[13px] truncate select-none">Semua
                            Kontrak</span>
                        <x-icon name="chevron-down"
                            class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 dark:text-[#9AA0A6] shrink-0 ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                    </button>
                    <div
                        class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[140px] max-h-[200px] overflow-y-auto rounded-xl lg:rounded-2xl bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1 sm:p-1.5 flex flex-col gap-0.5">
                        <button type="button" onclick="selectMapFilter('jenis_kontrak', '', 'Semua Kontrak')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Semua Kontrak</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('jenis_kontrak', 'sewa', 'Sewa')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Sewa</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('jenis_kontrak', 'kerjasama', 'Kerja Sama')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Kerja Sama</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- 5. JENIS PENDAPATAN --}}
            <div class="flex flex-col">
                <label
                    class="flex items-center gap-1 sm:gap-[6px] text-[11px] sm:text-xs lg:text-sm font-semibold text-gray-700 dark:text-[#9AA0A6] mb-1 sm:mb-[6px]">
                    <x-icon name="jenis-pendapatan-icon"
                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 lg:w-5 lg:h-5 shrink-0 text-gray-400 dark:text-[#9AA0A6]" />
                    Jenis Pendapatan
                </label>
                <div class="relative custom-filter-container" data-filter-id="jenis_pendapatan">
                    <button type="button"
                        class="filter-dropdown-btn flex items-center justify-between w-full h-[36px] sm:h-[42px] lg:h-[46px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3.5 py-1.5 sm:py-2 transition cursor-pointer">
                        <span
                            class="filter-selected-label text-[#8B8B8B] dark:text-[#9AA0A6] font-medium text-[11px] sm:text-xs lg:text-[13px] truncate select-none">Semua
                            Pend...</span>
                        <x-icon name="chevron-down"
                            class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 dark:text-[#9AA0A6] shrink-0 ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                    </button>
                    <div
                        class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[140px] max-h-[200px] overflow-y-auto rounded-xl lg:rounded-2xl bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1 sm:p-1.5 flex flex-col gap-0.5">
                        <button type="button" onclick="selectMapFilter('jenis_pendapatan', '', 'Semua Pend...')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Semua Pend...</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('jenis_pendapatan', 'sewa', 'Sewa')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Sewa</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('jenis_pendapatan', 'iklan', 'Iklan')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Iklan</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('jenis_pendapatan', 'lainnya', 'Lainnya')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Lainnya</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- 6. SPV --}}
            <div class="flex flex-col">
                <label
                    class="flex items-center gap-1 sm:gap-[6px] text-[11px] sm:text-xs lg:text-sm font-semibold text-gray-700 dark:text-[#9AA0A6] mb-1 sm:mb-[6px]">
                    <x-icon name="spv-icon"
                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 lg:w-5 lg:h-5 shrink-0 text-gray-400 dark:text-[#9AA0A6]" />
                    SPV
                </label>
                <div class="relative custom-filter-container" data-filter-id="spv">
                    <button type="button"
                        class="filter-dropdown-btn flex items-center justify-between w-full h-[36px] sm:h-[42px] lg:h-[46px] bg-white dark:bg-[#2D3034] border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 rounded-lg lg:rounded-[10px] px-2.5 sm:px-3.5 py-1.5 sm:py-2 transition cursor-pointer">
                        <span
                            class="filter-selected-label text-[#8B8B8B] dark:text-[#9AA0A6] font-medium text-[11px] sm:text-xs lg:text-[13px] truncate select-none">Semua
                            SPV</span>
                        <x-icon name="chevron-down"
                            class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 dark:text-[#9AA0A6] shrink-0 ml-1 pointer-events-none transition-transform duration-200 filter-dropdown-arrow" />
                    </button>
                    <div
                        class="filter-dropdown-menu opacity-0 invisible scale-95 pointer-events-none transition-all duration-200 origin-top-left absolute left-0 top-full mt-1 z-[100] w-full min-w-[140px] max-h-[200px] overflow-y-auto rounded-xl lg:rounded-2xl bg-white dark:bg-[#2D3034] border border-gray-100 dark:border-white/10 shadow-[0_10px_35px_rgba(0,0,0,0.14)] dark:shadow-[0_10px_35px_rgba(0,0,0,0.6)] p-1 sm:p-1.5 flex flex-col gap-0.5">
                        <button type="button" onclick="selectMapFilter('spv', '', 'Semua SPV')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>Semua SPV</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('spv', 'spv1', 'SPV 1')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>SPV 1</span>
                        </button>
                        <button type="button" onclick="selectMapFilter('spv', 'spv2', 'SPV 2')"
                            class="filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer">
                            <span>SPV 2</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- ACTION BUTTONS (DESKTOP) --}}
        <div class="mt-4 sm:mt-6 lg:mt-8 flex gap-2 sm:gap-3.5 shrink-0">
            <button id="applyFilter" type="button"
                class="h-[38px] sm:h-[44px] lg:h-[48px] flex-1 rounded-lg lg:rounded-[10px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-semibold text-white transition flex items-center justify-center gap-1.5 sm:gap-2 shadow-xs cursor-pointer">
                <x-icon name="filter-icon" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" />
                Terapkan Filter
            </button>

            <button id="resetFilter" type="button"
                class="h-[38px] sm:h-[44px] lg:h-[48px] w-[75px] sm:w-[95px] lg:w-[115px] rounded-lg lg:rounded-[10px] border border-gray-300 dark:border-white/15 bg-white dark:bg-[#2D3034] text-xs sm:text-sm font-semibold text-gray-800 dark:text-white transition hover:bg-gray-50 dark:hover:bg-white/10 cursor-pointer">
                Reset
            </button>
        </div>

    </aside>

    {{-- Centralized Blade Icons Container untuk JavaScript Popup & Bottom Sheet --}}
    <div id="blade-map-icons-tpl" class="hidden" style="display:none !important;" aria-hidden="true">
        <div id="icon-corp-src"><x-icon name="icon-corp" /></div>
        <div id="icon-alamat-src"><x-icon name="icon-alamat" /></div>
        <div id="icon-luas-src"><x-icon name="icon-luas" /></div>
        <div id="icon-jenis-src"><x-icon name="icon-jenis" /></div>
        <div id="icon-nilai-src"><x-icon name="icon-nilai" /></div>
        <div id="icon-periode-src"><x-icon name="icon-periode" /></div>
        <div id="icon-maps-src"><x-icon name="maps" class="w-4 h-4 text-gray-700 dark:text-gray-200 shrink-0" /></div>
    </div>

    {{-- Javascript & Peta Leaflet --}}
    <script>
        // Data aset dari database
        const assets = @json($assets);

        let jatengGeojsonLayer = null;
        let jatengBounds = null;
        let baseJatengZoom = 8.5;
        let kabupatenLabelsLayer = L.layerGroup();

        const isMobileScreen = window.innerWidth < 768;
        const initialMobileZoom = 9.75;
        const initialDesktopZoom = 8.5;

        // Inisialisasi peta Leaflet berpusat di Jawa Tengah dengan zoom touchpad cepat & bertenaga
        const map = L.map('map', {
            center: [-7.15, 110.14],
            zoom: isMobileScreen ? initialMobileZoom : initialDesktopZoom,
            zoomSnap: 0.25,
            zoomDelta: 10,
            wheelPxPerZoomLevel: 100,
            wheelDebounceTime: 25,
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

        kabupatenLabelsLayer.addTo(map);

        // Pusatkan peta ke wilayah Jawa Tengah (Zoom besar proporsional di mobile, full bounds di desktop)
        function fitJatengBounds() {
            if (jatengBounds) {
                if (window.innerWidth < 768) {
                    map.setView([-7.15, 110.14], initialMobileZoom, {
                        animate: true
                    });
                } else {
                    map.fitBounds(jatengBounds, {
                        padding: [20, 20],
                        animate: true
                    });
                }
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

        window.mapZoomIn = function () {
            flashZoomIn();
            map.setZoom(Math.floor(map.getZoom()) + 1);
        };

        window.mapZoomOut = function () {
            flashZoomOut();
            map.setZoom(Math.ceil(map.getZoom()) - 1);
        };

        window.mapPanTool = function () {
            fitJatengBounds();
        };

        let lastZoomLevel = map.getZoom();

        map.on('zoomstart', function () {
            isCurrentlyZooming = true;
            if (panToolButton) panToolButton.classList.remove('tool-active-bg');
            lastZoomLevel = map.getZoom();
        });

        map.on('zoomanim', function (e) {
            isCurrentlyZooming = true;
            if (panToolButton) panToolButton.classList.remove('tool-active-bg');
            if (e.zoom > lastZoomLevel) {
                flashZoomIn();
            } else if (e.zoom < lastZoomLevel) {
                flashZoomOut();
            }
            lastZoomLevel = e.zoom;
        });

        map.on('zoom', function () {
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

        map.on('zoomend', function () {
            clearTimeout(zoomEndTimer);
            zoomEndTimer = setTimeout(() => {
                isCurrentlyZooming = false;
            }, 300);
        });

        map.on('dragstart', function () {
            if (!isCurrentlyZooming) {
                setPanToolVisual(true);
            }
        });

        map.on('drag', function () {
            if (!isCurrentlyZooming) {
                setPanToolVisual(true);
            }
        });

        map.on('dragend', function () {
            setPanToolVisual(false);
        });

        window.addEventListener('mouseup', function () {
            setPanToolVisual(false);
        });

        window.addEventListener('touchend', function () {
            setPanToolVisual(false);
        });

        // Ikon Titik Minimalist (Saat Tampilan Overview / Zoom Kecil) - Bersih dan Statis Tanpa Kedip
        const redDotIcon = L.divIcon({
            className: 'custom-pin-wrapper',
            html: `
                <div class="cursor-pointer flex items-center justify-center hover:scale-125 transition-transform select-none">
                    <span class="inline-flex rounded-full h-3 w-3 bg-[#BE0000] border-2 border-white shadow-[0_2px_5px_rgba(0,0,0,0.3)]"></span>
                </div>
            `,
            iconSize: [12, 12],
            iconAnchor: [6, 6]
        });

        // Ikon Pin Penuh (Saat Zoom In / Memperbesar Peta)
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

        let assetMarkerInstances = [];

        function getActiveMarkerIcon() {
            return map.getZoom() >= 9.6 ? redPinIcon : redDotIcon;
        }

        function refreshMarkerIcons() {
            const icon = getActiveMarkerIcon();
            assetMarkerInstances.forEach(marker => {
                if (marker && marker.setIcon && marker.getIcon() !== icon) {
                    marker.setIcon(icon);
                    const popup = marker.getPopup();
                    if (popup) {
                        popup.options.offset = (icon === redPinIcon) ? [0, -16] : [0, -8];
                    }
                }
            });
        }

        // Refresh marker icons hanya saat zoom selesai agar tidak patah-patah di tengah animasi
        map.on('zoomend', refreshMarkerIcons);

        // Function to get current GeoJSON style based on theme
        function getGeoJsonStyle() {
            const isDark = document.documentElement.classList.contains('dark');
            return {
                fillColor: isDark ? '#383C40' : '#E2E8F0',
                fillOpacity: 0.95,
                color: isDark ? '#202225' : '#FFFFFF',
                weight: 1.2,
                opacity: 1
            };
        }

        // Render nama-nama Kabupaten & Kota menempel di peta
        function createKabupatenLabels() {
            kabupatenLabelsLayer.clearLayers();
            if (!jatengGeojsonLayer) return;

            jatengGeojsonLayer.eachLayer(layer => {
                const feature = layer.feature;
                if (!feature || !feature.properties) return;

                const name = feature.properties.short_name || feature.properties.name;
                let center = null;
                if (layer.getBounds && typeof layer.getBounds === 'function') {
                    center = layer.getBounds().getCenter();
                } else if (feature.properties.lat && feature.properties.lon) {
                    center = L.latLng(feature.properties.lat, feature.properties.lon);
                }

                if (center) {
                    // Penyesuaian posisi center presisi agar label berada tepat di daratan masing-masing
                    if (name.includes('Jepara')) center = L.latLng(-6.62, 110.72);
                    if (name === 'Kabupaten Batang' || name.includes('Batang')) center = L.latLng(-7.02, 109.88);
                    if (name === 'Kota Pekalongan') center = L.latLng(-6.8898, 109.6753);
                    if (name === 'Kabupaten Pekalongan') center = L.latLng(-7.06, 109.62);
                    if (name === 'Kota Semarang') center = L.latLng(-7.0051, 110.4281);
                    if (name === 'Kabupaten Semarang') center = L.latLng(-7.20, 110.43);
                    if (name === 'Kota Tegal') center = L.latLng(-6.8674, 109.1352);
                    if (name === 'Kabupaten Tegal') center = L.latLng(-7.06, 109.14);
                    if (name === 'Kota Magelang') center = L.latLng(-7.4706, 110.2178);
                    if (name === 'Kabupaten Magelang') center = L.latLng(-7.54, 110.25);
                    if (name === 'Kota Salatiga') center = L.latLng(-7.3305, 110.5084);
                    if (name.includes('Surakarta') || name.includes('Solo')) center = L.latLng(-7.5666, 110.8249);
                    if (name === 'Kabupaten Kendal') center = L.latLng(-7.02, 110.17);

                    const labelHtml = `
                        <div class="kabupaten-label-badge font-bold text-[9px] sm:text-[10px] text-gray-800 dark:text-gray-100 bg-white/80 dark:bg-[#1E2023]/85 px-1.5 py-0.5 rounded shadow-[0_1px_3px_rgba(0,0,0,0.12)] border border-gray-300/60 dark:border-white/10 backdrop-blur-[2px] select-none pointer-events-none whitespace-nowrap">
                            ${name}
                        </div>
                    `;
                    const labelIcon = L.divIcon({
                        className: 'kabupaten-label-wrapper',
                        html: labelHtml,
                        iconSize: [120, 22],
                        iconAnchor: [60, 11]
                    });

                    const labelMarker = L.marker(center, {
                        icon: labelIcon,
                        interactive: false,
                        zIndexOffset: -50
                    });

                    kabupatenLabelsLayer.addLayer(labelMarker);
                }
            });
        }

        // Load GeoJSON batas wilayah Jawa Tengah (35 Kabupaten & Kota)
        fetch('/js/jawa-tengah-kabupaten.json')
            .then(response => {
                if (!response.ok) throw new Error('Failed to load jawa-tengah-kabupaten.json');
                return response.json();
            })
            .then(data => {
                jatengGeojsonLayer = L.geoJSON(data, {
                    style: getGeoJsonStyle(),
                    onEachFeature: function (feature, layer) {
                        layer.on({
                            mouseover: function (e) {
                                const isDark = document.documentElement.classList.contains('dark');
                                e.target.setStyle({
                                    fillColor: isDark ? '#475569' : '#DBEAFE',
                                    weight: 2,
                                    color: '#0066FF'
                                });
                                if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                    e.target.bringToFront();
                                }
                            },
                            mouseout: function (e) {
                                e.target.setStyle(getGeoJsonStyle());
                            }
                        });
                    }
                }).addTo(map);

                jatengBounds = jatengGeojsonLayer.getBounds();

                if (window.innerWidth < 768) {
                    map.setView([-7.15, 110.14], initialMobileZoom, {
                        animate: false
                    });
                } else {
                    map.fitBounds(jatengBounds, {
                        padding: [20, 20],
                        animate: false
                    });
                }

                const baseMinZoom = map.getBoundsZoom(jatengBounds, false, [20, 20]);
                baseJatengZoom = baseMinZoom || 8.0;
                map.setMinZoom(Math.max(6.0, baseJatengZoom - 2.5));
                map.setMaxZoom(18);
                map.setMaxBounds(jatengBounds.pad(1.2));

                createKabupatenLabels();
                renderMarkers();

                setTimeout(() => {
                    if (map) map.invalidateSize();
                }, 100);
            })
            .catch(error => {
                console.error('GeoJSON error:', error);
                renderMarkers(); // Fallback: marker tetap muncul meskipun file geojson gagal dimuat
            });

        // Theme synchronization for map and popups
        window.updateMapTheme = function () {
            if (jatengGeojsonLayer) {
                jatengGeojsonLayer.setStyle(getGeoJsonStyle());
            }
            createKabupatenLabels();
            if (map) {
                map.eachLayer(layer => {
                    if (layer instanceof L.Marker && layer._assetData && layer._assetId && layer.isPopupOpen && layer.isPopupOpen()) {
                        const popup = layer.getPopup();
                        if (popup) {
                            popup.setContent(createPopupCardHTML(layer._assetData, layer._assetId));
                        }
                    }
                });
            }
        };

        // Listen for theme toggle events
        window.addEventListener('themeChanged', function () {
            if (window.updateMapTheme) window.updateMapTheme();
        });

        // Hook observer for class changes on documentElement
        const themeObserver = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.attributeName === 'class') {
                    if (window.updateMapTheme) window.updateMapTheme();
                }
            });
        });
        themeObserver.observe(document.documentElement, { attributes: true });

        window.addEventListener('resize', function () {
            if (map) {
                map.invalidateSize();
                if (jatengBounds) {
                    const baseMinZoom = map.getBoundsZoom(jatengBounds, false, [20, 20]);
                    baseJatengZoom = baseMinZoom || 8.0;
                    map.setMinZoom(Math.max(6.5, baseJatengZoom - 1));
                }
            }
        });

        window.addEventListener('load', function () {
            if (map) {
                map.invalidateSize();
            }
        });

        // Ikon Popup & Bottom Sheet terpusat dari komponen Blade <x-icon />
        const ICON_CORP = document.getElementById('icon-corp-src')?.innerHTML || '';
        const ICON_ALAMAT = document.getElementById('icon-alamat-src')?.innerHTML || '';
        const ICON_LUAS = document.getElementById('icon-luas-src')?.innerHTML || '';
        const ICON_JENIS = document.getElementById('icon-jenis-src')?.innerHTML || '';
        const ICON_NILAI = document.getElementById('icon-nilai-src')?.innerHTML || '';
        const ICON_PERIODE = document.getElementById('icon-periode-src')?.innerHTML || '';
        const ICON_MAPS = document.getElementById('icon-maps-src')?.innerHTML || '';

        // Template HTML untuk Mobile Bottom Sheet Drawer
        function createMobileBottomSheetHTML(asset, id) {
            const googleMapsUrl = (asset.latitude && asset.longitude)
                ? `https://www.google.com/maps?q=${asset.latitude},${asset.longitude}`
                : '#';

            return `
                <div class="font-sans text-left">
                    {{-- Header: Icon Gedung + Nama Tenant / Perusahaan --}}
                    <div class="mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 text-[#0066FF] flex items-center justify-center">
                                ${ICON_CORP}
                            </div>
                            <h3 class="m-0 text-xl sm:text-2xl font-bold leading-tight text-gray-950 dark:text-white tracking-tight truncate">${asset.tenant || asset.name || '-'}</h3>
                        </div>
                        <p class="mt-2 text-center text-sm sm:text-base font-semibold text-[#8C95A0] dark:text-gray-400 tracking-wide truncate">${(asset.code ? asset.code + ' • ' : '') + (asset.location || '')}</p>
                    </div>

                    {{-- 2-Column Info Grid Sesuai Desain Gambar: Kiri 3 item, Kanan 2 item --}}
                    <div class="grid grid-cols-2 gap-x-5 sm:gap-x-8">
                        {{-- Kolom Kiri: Alamat, Jenis Aset, Periode --}}
                        <div class="space-y-4 sm:space-y-5">
                            {{-- Alamat --}}
                            <div class="flex items-start gap-2.5 sm:gap-3 min-w-0">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 flex items-center justify-center mt-0.5">${ICON_ALAMAT}</div>
                                <div class="min-w-0 flex-1">
                                    <span class="block text-sm sm:text-[14px] font-semibold text-gray-800 dark:text-gray-200 leading-tight">Alamat</span>
                                    <span class="block text-xs sm:text-[13px] text-gray-500 dark:text-gray-400 leading-relaxed mt-0.5 line-clamp-3">${asset.address || '-'}</span>
                                </div>
                            </div>

                            {{-- Jenis Aset --}}
                            <div class="flex items-start gap-2.5 sm:gap-3 min-w-0">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 flex items-center justify-center mt-0.5">${ICON_JENIS}</div>
                                <div class="min-w-0 flex-1">
                                    <span class="block text-sm sm:text-[14px] font-semibold text-gray-800 dark:text-gray-200 leading-tight">Jenis Aset</span>
                                    <span class="block text-xs sm:text-[13px] text-gray-500 dark:text-gray-400 leading-relaxed mt-0.5 line-clamp-2">${asset.type || '-'}</span>
                                </div>
                            </div>

                            {{-- Periode --}}
                            <div class="flex items-start gap-2.5 sm:gap-3 min-w-0">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 flex items-center justify-center mt-0.5">${ICON_PERIODE}</div>
                                <div class="min-w-0 flex-1">
                                    <span class="block text-sm sm:text-[14px] font-semibold text-gray-800 dark:text-gray-200 leading-tight">Periode</span>
                                    <span class="block text-xs sm:text-[13px] text-gray-500 dark:text-gray-400 leading-relaxed mt-0.5 truncate">${asset.period || '-'}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Luas, Nilai Aset --}}
                        <div class="space-y-4 sm:space-y-5">
                            {{-- Luas --}}
                            <div class="flex items-start gap-2.5 sm:gap-3 min-w-0">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 flex items-center justify-center mt-0.5">${ICON_LUAS}</div>
                                <div class="min-w-0 flex-1">
                                    <span class="block text-sm sm:text-[14px] font-semibold text-gray-800 dark:text-gray-200 leading-tight">Luas</span>
                                    <span class="block text-xs sm:text-[13px] text-gray-500 dark:text-gray-400 leading-relaxed mt-0.5 truncate">${asset.area || '-'}</span>
                                </div>
                            </div>

                            {{-- Nilai Aset --}}
                            <div class="flex items-start gap-2.5 sm:gap-3 min-w-0">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 flex items-center justify-center mt-0.5">${ICON_NILAI}</div>
                                <div class="min-w-0 flex-1">
                                    <span class="block text-sm sm:text-[14px] font-semibold text-gray-800 dark:text-gray-200 leading-tight">Nilai Aset</span>
                                    <span class="block text-xs sm:text-[13px] text-gray-500 dark:text-gray-400 leading-relaxed mt-0.5 truncate">${asset.value || '-'}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi: Detail Lanjutan & Buka Maps Persis Gambar Referensi --}}
                    <div class="mt-8 flex items-center gap-3.5 sm:gap-4 shrink-0">
                        <a href="/asset/${id}" class="mobile-btn-detail flex-1" style="height: 48px !important; min-height: 48px !important; border-radius: 14px !important; background-color: #0066FF !important; color: #ffffff !important; text-decoration: none !important; font-size: 15px !important; font-weight: 600 !important;">Detail Lanjutan</a>
                        <a href="${googleMapsUrl}" target="_blank" class="mobile-btn-maps flex-1 flex items-center justify-center gap-2" style="height: 48px !important; min-height: 48px !important; border-radius: 14px !important; border: 1.5px solid #D1D5DB !important; text-decoration: none !important; font-size: 15px !important; font-weight: 600 !important;">
                            ${ICON_MAPS}
                            <span>Buka Maps</span>
                        </a>
                    </div>
                </div>
            `;
        }

        window.openMobileAssetBottomSheet = function (asset, id, latlng) {
            const sheet = document.getElementById('mobileAssetBottomSheet');
            const overlay = document.getElementById('mobileAssetBottomSheetOverlay');
            const content = document.getElementById('mobileAssetBottomSheetContent');
            const mobileBottomNav = document.getElementById('mobileBottomNav');
            if (!sheet || !content) return;

            content.innerHTML = createMobileBottomSheetHTML(asset, id);
            
            // Tampilkan elemen
            sheet.classList.remove('invisible', 'opacity-0');
            requestAnimationFrame(() => {
                sheet.classList.remove('translate-y-full', 'pointer-events-none');
                sheet.classList.add('translate-y-0', 'pointer-events-auto');
            });

            if (overlay) {
                overlay.classList.remove('invisible', 'opacity-0', 'pointer-events-none');
                overlay.classList.add('opacity-100', 'pointer-events-auto');
            }

            // Animasi navbar tertutup / tenggelam dengan halus
            if (mobileBottomNav) {
                mobileBottomNav.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
            }
            if (typeof window.closeMobileSubMenu === 'function') {
                window.closeMobileSubMenu();
            }

            if (latlng && map) {
                const currentZoom = Math.max(map.getZoom(), 10.5);
                const projected = map.project(latlng, currentZoom);
                const targetCenter = map.unproject(projected.add([0, 130]), currentZoom);
                map.flyTo(targetCenter, currentZoom, { duration: 0.4, easeLinearity: 0.25 });
            }
        };

        window.closeMobileAssetBottomSheet = function () {
            const sheet = document.getElementById('mobileAssetBottomSheet');
            const overlay = document.getElementById('mobileAssetBottomSheetOverlay');
            const mobileBottomNav = document.getElementById('mobileBottomNav');

            if (sheet) {
                sheet.classList.add('translate-y-full', 'pointer-events-none');
                sheet.classList.remove('translate-y-0', 'pointer-events-auto');
                setTimeout(() => {
                    if (sheet.classList.contains('translate-y-full')) {
                        sheet.classList.add('invisible', 'opacity-0');
                    }
                }, 300);
            }
            if (overlay) {
                overlay.classList.add('opacity-0', 'pointer-events-none');
                overlay.classList.remove('opacity-100', 'pointer-events-auto');
                setTimeout(() => {
                    if (overlay.classList.contains('opacity-0')) {
                        overlay.classList.add('invisible');
                    }
                }, 300);
            }

            // Kembalikan navbar mobile ke posisi semula
            if (mobileBottomNav) {
                mobileBottomNav.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
            }
        };

        // Template HTML untuk kartu popup aset Desktop
        function createPopupCardHTML(asset, id) {
            const googleMapsUrl = (asset.latitude && asset.longitude)
                ? `https://www.google.com/maps?q=${asset.latitude},${asset.longitude}`
                : '#';

            return `
                <div class="w-[320px] sm:w-[420px] rounded-[28px] sm:rounded-[36px] bg-white dark:bg-[#1F2123] p-6 sm:p-7 md:p-8 shadow-[0_24px_60px_rgba(0,0,0,0.14)] dark:shadow-[0_24px_60px_rgba(0,0,0,0.7)] border border-gray-100/90 dark:border-white/10 font-sans text-left relative">
                    <div class="mb-6 sm:mb-7">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 text-[#0066FF] flex items-center justify-center">${ICON_CORP}</div>
                            <h3 class="m-0 text-base sm:text-[22px] font-bold leading-snug text-gray-950 dark:text-white truncate">${asset.tenant || asset.name || '-'}</h3>
                        </div>
                        <p class="mt-1 sm:mt-1.5 text-xs sm:text-[13px] font-semibold text-gray-400 dark:text-[#9AA0A6] pl-10 sm:pl-11 truncate">${(asset.code ? asset.code + ' • ' : '') + (asset.location || '')}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-x-6 sm:gap-x-8 gap-y-5 sm:gap-y-6 pt-1">
                        <div class="flex items-center gap-3 sm:gap-3.5 min-w-0">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 shrink-0 flex items-center justify-center">${ICON_ALAMAT}</div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs sm:text-[13px] font-semibold text-gray-900 dark:text-[#9AA0A6] leading-tight mb-1">Alamat</span>
                                <span class="block text-xs sm:text-[13px] text-gray-500 dark:text-white leading-relaxed line-clamp-3">${asset.address || '-'}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 sm:gap-3.5 min-w-0">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 shrink-0 flex items-center justify-center">${ICON_LUAS}</div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs sm:text-[13px] font-semibold text-gray-900 dark:text-[#9AA0A6] leading-tight mb-1">Luas</span>
                                <span class="block text-xs sm:text-[13px] text-gray-500 dark:text-white leading-relaxed truncate">${asset.area || '-'}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 sm:gap-3.5 min-w-0">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 shrink-0 flex items-center justify-center">${ICON_JENIS}</div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs sm:text-[13px] font-semibold text-gray-900 dark:text-[#9AA0A6] leading-tight mb-1">Jenis Aset</span>
                                <span class="block text-xs sm:text-[13px] text-gray-500 dark:text-white leading-relaxed line-clamp-2">${asset.type || '-'}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 sm:gap-3.5 min-w-0">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 shrink-0 flex items-center justify-center">${ICON_NILAI}</div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs sm:text-[13px] font-semibold text-gray-900 dark:text-[#9AA0A6] leading-tight mb-1">Nilai Aset</span>
                                <span class="block text-xs sm:text-[13px] text-gray-500 dark:text-white leading-relaxed truncate">${asset.value || '-'}</span>
                            </div>
                        </div>
                        <div class="col-span-2 flex items-center gap-3 sm:gap-3.5 min-w-0">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 shrink-0 flex items-center justify-center">${ICON_PERIODE}</div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs sm:text-[13px] font-semibold text-gray-900 dark:text-[#9AA0A6] leading-tight mb-1">Periode</span>
                                <span class="block text-xs sm:text-[13px] text-gray-500 dark:text-white leading-relaxed truncate">${asset.period || '-'}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-7 sm:mt-8 flex items-center gap-3 sm:gap-4">
                        <a href="/asset/${id}" class="btn-detail-lanjutan flex-1 h-[44px] sm:h-[48px] flex items-center justify-center text-center cursor-pointer rounded-xl sm:rounded-2xl bg-[#0066FF] px-4 text-xs sm:text-sm font-semibold !text-white transition hover:bg-blue-700 shadow-xs whitespace-nowrap" style="color: #ffffff !important;">Detail Lanjutan</a>
                        <a href="${googleMapsUrl}" target="_blank" class="btn-buka-maps flex-1 h-[44px] sm:h-[48px] flex items-center justify-center gap-2 text-center cursor-pointer rounded-xl sm:rounded-2xl border border-gray-300 dark:border-white/15 bg-white dark:bg-[#2D3034] px-4 text-xs sm:text-sm font-semibold text-gray-700 dark:text-white transition hover:bg-gray-50 dark:hover:bg-white/10 shadow-xs whitespace-nowrap">
                            ${ICON_MAPS}
                            <span>Buka Maps</span>
                        </a>
                    </div>
                </div>
            `;
        }

        // Render marker aset dan popup info
        function renderMarkers() {
            assetMarkerInstances.forEach(m => map.removeLayer(m));
            assetMarkerInstances = [];

            const coordCounts = {};
            const activeIcon = getActiveMarkerIcon();

            Object.entries(assets).forEach(([id, asset], index) => {
                let lat = parseFloat(asset.latitude);
                let lng = parseFloat(asset.longitude);

                if (!isNaN(lat) && !isNaN(lng)) {
                    const key = `${lat.toFixed(4)},${lng.toFixed(4)}`;
                    if (!coordCounts[key]) {
                        coordCounts[key] = 0;
                    } else {
                        coordCounts[key]++;
                        const angle = (coordCounts[key] * 137.5) * (Math.PI / 180);
                        const radius = 0.002 * Math.sqrt(coordCounts[key]);
                        lat += radius * Math.cos(angle);
                        lng += radius * Math.sin(angle);
                    }

                    const marker = L.marker([lat, lng], { icon: activeIcon }).addTo(map);
                    marker._assetData = asset;
                    marker._assetId = id;
                    assetMarkerInstances.push(marker);

                    const popupOffset = (activeIcon === redPinIcon) ? [0, -16] : [0, -8];
                    
                    marker.bindPopup(function () {
                        return createPopupCardHTML(asset, id);
                    }, {
                        offset: popupOffset,
                        closeButton: false,
                        autoPan: false,
                        className: 'custom-asset-leaflet-popup'
                    });

                    marker.on('click', function (e) {
                        L.DomEvent.stopPropagation(e);

                        if (isMobile()) {
                            map.closePopup();
                            closeFilterModal();
                            openMobileAssetBottomSheet(asset, id, [lat, lng]);
                        } else {
                            closeMobileAssetBottomSheet();
                            const baseZoom = baseJatengZoom || map.getMinZoom() || 8.5;
                            const pointZoomLevel = Math.max(baseZoom + 1.5, 10.5);

                            const projected = map.project([lat, lng], pointZoomLevel);
                            const yOffset = 170;
                            const targetCenter = map.unproject(projected.subtract([0, yOffset]), pointZoomLevel);

                            const currentCenter = map.getCenter();
                            const isAlreadyNear = Math.abs(currentCenter.lat - targetCenter.lat) < 0.005 &&
                                                  Math.abs(currentCenter.lng - targetCenter.lng) < 0.005 &&
                                                  Math.abs(map.getZoom() - pointZoomLevel) < 0.2;

                            if (isAlreadyNear) {
                                marker.openPopup();
                            } else {
                                map.once('moveend', function () {
                                    marker.openPopup();
                                });
                                map.flyTo(targetCenter, pointZoomLevel, {
                                    duration: 0.45,
                                    easeLinearity: 0.25
                                });
                            }
                        }
                    });
                }
            });
        }

        map.on('popupclose', function () {
            if (!isMobile()) {
                fitJatengBounds();
            }
        });

        map.on('click', function () {
            closeFilterModal();
            closeMobileAssetBottomSheet();
        });

        // Kontrol filter panel & button animation
        const filterButton = document.getElementById('filterButton');
        const filterButtonDesktop = document.getElementById('filterButtonDesktop');
        const filterModal = document.getElementById('filterModal');
        const filterOverlay = document.getElementById('filterOverlay');
        const applyFilter = document.getElementById('applyFilter');
        const resetFilter = document.getElementById('resetFilter');

        let isFilterOpen = false;

        function isMobile() {
            return window.innerWidth < 1024;
        }

        function alignFilterModal() {
            if (!isMobile() && filterButtonDesktop && filterModal) {
                const rect = filterButtonDesktop.getBoundingClientRect();
                filterModal.style.top = rect.top + 'px';
            }
        }

        window.addEventListener('resize', () => {
            if (isFilterOpen) {
                alignFilterModal();
            }
        });

        function updateActiveFilterBadge() {
            const filterKeys = ['stasiun', 'wilayah', 'aset', 'jenis_kontrak', 'jenis_pendapatan', 'spv'];
            let activeCount = 0;
            filterKeys.forEach(k => {
                const el = document.getElementById(k);
                if (el && el.value && el.value.trim() !== '') {
                    activeCount++;
                }
            });

            const badge = document.getElementById('mobileActiveFilterBadge');
            if (badge) {
                if (activeCount > 0) {
                    badge.textContent = activeCount;
                    badge.classList.remove('hidden');
                    badge.classList.add('flex');
                } else {
                    badge.classList.add('hidden');
                    badge.classList.remove('flex');
                }
            }
        }

        function openFilter() {
            isFilterOpen = true;

            if (isMobile()) {
                if (typeof window.closeMobileAssetBottomSheet === 'function') {
                    window.closeMobileAssetBottomSheet();
                }

                const sheet = document.getElementById('mobileFilterBottomSheet');
                const overlay = document.getElementById('mobileFilterOverlay');
                const mobileBottomNav = document.getElementById('mobileBottomNav');

                if (sheet) {
                    sheet.classList.remove('invisible', 'opacity-0');
                    requestAnimationFrame(() => {
                        sheet.classList.remove('translate-y-full', 'pointer-events-none');
                        sheet.classList.add('translate-y-0', 'pointer-events-auto');
                    });
                }

                if (overlay) {
                    overlay.classList.remove('invisible', 'opacity-0', 'pointer-events-none');
                    overlay.classList.add('opacity-100', 'pointer-events-auto');
                }

                if (mobileBottomNav) {
                    mobileBottomNav.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
                }
                if (typeof window.closeMobileSubMenu === 'function') {
                    window.closeMobileSubMenu();
                }
            } else {
                alignFilterModal();

                if (filterModal) {
                    filterModal.classList.remove('translate-x-[140%]', 'opacity-0', 'pointer-events-none');
                    filterModal.classList.add('translate-x-0', 'opacity-100', 'pointer-events-auto');
                }

                if (filterButtonDesktop) {
                    const shiftWidth = (filterModal?.offsetWidth || 373) + 12;
                    filterButtonDesktop.style.transform = 'translateX(-' + shiftWidth + 'px)';
                }

                if (filterOverlay) {
                    filterOverlay.classList.remove('invisible', 'opacity-0');
                    filterOverlay.classList.add('visible', 'opacity-100');
                }
            }
        }

        function closeFilterModal() {
            isFilterOpen = false;

            if (isMobile()) {
                const sheet = document.getElementById('mobileFilterBottomSheet');
                const overlay = document.getElementById('mobileFilterOverlay');
                const mobileBottomNav = document.getElementById('mobileBottomNav');

                if (sheet) {
                    sheet.classList.add('translate-y-full', 'pointer-events-none');
                    sheet.classList.remove('translate-y-0', 'pointer-events-auto');
                    setTimeout(() => {
                        if (sheet.classList.contains('translate-y-full')) {
                            sheet.classList.add('invisible', 'opacity-0');
                        }
                    }, 300);
                }

                if (overlay) {
                    overlay.classList.add('opacity-0', 'pointer-events-none');
                    overlay.classList.remove('opacity-100', 'pointer-events-auto');
                    setTimeout(() => {
                        if (overlay.classList.contains('opacity-0')) {
                            overlay.classList.add('invisible');
                        }
                    }, 300);
                }

                if (mobileBottomNav) {
                    mobileBottomNav.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
                }
            } else {
                if (filterModal) {
                    filterModal.classList.remove('translate-x-0', 'opacity-100', 'pointer-events-auto');
                    filterModal.classList.add('translate-x-[140%]', 'opacity-0', 'pointer-events-none');
                }

                if (filterButtonDesktop) {
                    filterButtonDesktop.style.transform = 'translateX(0)';
                }

                if (filterOverlay) {
                    filterOverlay.classList.remove('visible', 'opacity-100');
                    filterOverlay.classList.add('invisible', 'opacity-0');
                }
            }

            // Close all dropdown menus
            document.querySelectorAll('.filter-dropdown-menu').forEach(m => closeSmoothDropdown(m));
            document.querySelectorAll('.filter-dropdown-arrow').forEach(a => a.classList.remove('rotate-180'));
        }

        function toggleFilter() {
            if (isFilterOpen) {
                closeFilterModal();
            } else {
                openFilter();
            }
        }

        // ================= CUSTOM MAP FILTER DROPDOWN LOGIC =================
        window.selectMapFilter = function (filterId, value, labelText) {
            const input = document.getElementById(filterId);
            if (input) {
                input.value = value;
            }

            // Update all containers for this filter (both mobile and desktop)
            const containers = document.querySelectorAll(`.custom-filter-container[data-filter-id="${filterId}"]`);
            containers.forEach(container => {
                const labelSpan = container.querySelector('.filter-selected-label');
                if (labelSpan) {
                    labelSpan.textContent = labelText;
                    if (value && value !== '') {
                        labelSpan.classList.remove('text-[#8B8B8B]', 'dark:text-[#9AA0A6]');
                        labelSpan.classList.add('text-black', 'dark:text-white', 'font-semibold');
                    } else {
                        labelSpan.classList.remove('text-black', 'dark:text-white', 'font-semibold');
                        labelSpan.classList.add('text-[#8B8B8B]', 'dark:text-[#9AA0A6]', 'font-medium');
                    }
                }

                // Update active state in menu options
                const options = container.querySelectorAll('.filter-option-btn');
                options.forEach(btn => {
                    const span = btn.querySelector('span');
                    if (span && span.textContent.trim() === labelText.trim()) {
                        btn.className = "filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium bg-blue-50 dark:bg-blue-600/20 text-[#0066FF] dark:text-[#3B82F6] rounded-lg lg:rounded-xl transition text-left cursor-pointer";
                    } else {
                        btn.className = "filter-option-btn flex items-center justify-between w-full px-2.5 sm:px-3 py-1.5 sm:py-2 text-[11px] sm:text-xs lg:text-[13px] font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg lg:rounded-xl transition text-left cursor-pointer";
                    }
                });

                const menu = container.querySelector('.filter-dropdown-menu');
                if (menu) {
                    closeSmoothDropdown(menu);
                }
                const arrow = container.querySelector('.filter-dropdown-arrow');
                if (arrow) {
                    arrow.classList.remove('rotate-180');
                }
            });

            updateActiveFilterBadge();
        };

        function openSmoothDropdown(el) {
            if (!el) return;
            el.classList.remove('opacity-0', 'invisible', 'scale-95', 'pointer-events-none');
            el.classList.add('opacity-100', 'visible', 'scale-100', 'pointer-events-auto');
        }
        function closeSmoothDropdown(el) {
            if (!el) return;
            el.classList.add('opacity-0', 'invisible', 'scale-95', 'pointer-events-none');
            el.classList.remove('opacity-100', 'visible', 'scale-100', 'pointer-events-auto');
        }
        function isSmoothDropdownOpen(el) {
            return el && !el.classList.contains('invisible');
        }

        document.addEventListener('click', function (e) {
            const filterBtn = e.target.closest('.filter-dropdown-btn');
            const allFilterMenus = document.querySelectorAll('.filter-dropdown-menu');
            const allFilterArrows = document.querySelectorAll('.filter-dropdown-arrow');

            if (filterBtn) {
                e.stopPropagation();
                const container = filterBtn.closest('.custom-filter-container');
                const menu = container ? container.querySelector('.filter-dropdown-menu') : null;
                const arrow = filterBtn.querySelector('.filter-dropdown-arrow');
                const wasOpen = isSmoothDropdownOpen(menu);

                // Close all other dropdown menus & arrows
                allFilterMenus.forEach(closeSmoothDropdown);
                allFilterArrows.forEach(a => a.classList.remove('rotate-180'));

                if (!wasOpen && menu) {
                    openSmoothDropdown(menu);
                    if (arrow) arrow.classList.add('rotate-180');
                }
            } else if (!e.target.closest('.filter-dropdown-menu')) {
                allFilterMenus.forEach(closeSmoothDropdown);
                allFilterArrows.forEach(a => a.classList.remove('rotate-180'));
            }
        });

        // Wire up both mobile and desktop filter buttons
        if (filterButton) {
            filterButton.addEventListener('click', function (e) {
                e.stopPropagation();
                toggleFilter();
            });
        }
        if (filterButtonDesktop) {
            filterButtonDesktop.addEventListener('click', function (e) {
                e.stopPropagation();
                toggleFilter();
            });
        }

        if (filterOverlay) {
            filterOverlay.addEventListener('click', function () {
                closeFilterModal();
            });
        }

        const applyFilterMobile = document.getElementById('applyFilterMobile');
        if (applyFilterMobile) {
            applyFilterMobile.addEventListener('click', function () {
                closeFilterModal();
            });
        }

        const resetFilterMobile = document.getElementById('resetFilterMobile');
        if (resetFilterMobile) {
            resetFilterMobile.addEventListener('click', function () {
                selectMapFilter('stasiun', '', 'Semua Stasiun');
                selectMapFilter('wilayah', '', 'Row & Non Row');
                selectMapFilter('aset', '', 'Semua Aset');
                selectMapFilter('jenis_kontrak', '', 'Semua Kontrak');
                selectMapFilter('jenis_pendapatan', '', 'Semua Pend...');
                selectMapFilter('spv', '', 'Semua SPV');
            });
        }

        if (applyFilter) {
            applyFilter.addEventListener('click', function () {
                closeFilterModal();
            });
        }

        if (resetFilter) {
            resetFilter.addEventListener('click', function () {
                selectMapFilter('stasiun', '', 'Semua Stasiun');
                selectMapFilter('wilayah', '', 'Row & Non Row');
                selectMapFilter('aset', '', 'Semua Aset');
                selectMapFilter('jenis_kontrak', '', 'Semua Kontrak');
                selectMapFilter('jenis_pendapatan', '', 'Semua Pend...');
                selectMapFilter('spv', '', 'Semua SPV');
                closeFilterModal();
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeFilterModal();
                if (typeof window.closeMobileAssetBottomSheet === 'function') {
                    window.closeMobileAssetBottomSheet();
                }
                map.closePopup();
            }
        });
    </script>
<x-temp-password-guard />
</body>

</html>