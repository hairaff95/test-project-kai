<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>Peta Interaktif & Portofolio Aset — KAI Daop 4 Semarang</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: '#F37021',
                        'primary-hover': '#d45f0e',
                        'primary-light': '#fef0e6',
                        'primary-border': '#fcd7c0',
                        kai: {
                            orange: '#F37021',
                            blue: '#2D2A70',
                            gray: '#F8F9FA'
                        },
                        surface: '#FFFFFF',
                        bgbase: '#F8F8F6',
                        borderbase: '#E5E7EB',
                        textmain: '#1A1A1A',
                        textmuted: '#6B7280',
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons & Alpine.js -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Disable and hide all browser scrollbars completely */
        *, html, body, div, span, nav, ul, li {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }
        *::-webkit-scrollbar,
        html::-webkit-scrollbar,
        body::-webkit-scrollbar,
        div::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            background: transparent !important;
        }

        html, body {
            overflow: hidden !important;
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8F8F6;
            color: #1A1A1A;
            -webkit-overflow-scrolling: touch;
        }

        /* Safe Area Inset Variables & Utilities */
        :root {
            --sat: env(safe-area-inset-top, 0px);
            --sab: env(safe-area-inset-bottom, 0px);
            --sal: env(safe-area-inset-left, 0px);
            --sar: env(safe-area-inset-right, 0px);
        }
        .pt-safe { padding-top: env(safe-area-inset-top, 0px); }
        .pb-safe { padding-bottom: env(safe-area-inset-bottom, 0px); }
        .pl-safe { padding-left: env(safe-area-inset-left, 0px); }
        .pr-safe { padding-right: env(safe-area-inset-right, 0px); }
        .bottom-safe { bottom: calc(1rem + env(safe-area-inset-bottom, 0px)); }

        /* Leaflet Z-Index Containment & Isolation */
        .leaflet-container {
            font-family: 'Plus Jakarta Sans', sans-serif;
            z-index: 1 !important;
            width: 100%;
            height: 100%;
        }
        .leaflet-pane { z-index: 1 !important; }
        .leaflet-top, .leaflet-bottom { z-index: 2 !important; }
        .leaflet-control { z-index: 2 !important; }

        /* Marker pin */
        .price-pin {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
            user-select: none;
        }
        .price-pin-bubble {
            background: #FFFFFF;
            color: #111827;
            font-size: 11px;
            font-weight: 800;
            padding: 5px 10px;
            border-radius: 9999px;
            border: 1.5px solid #E5E7EB;
            box-shadow: 0 4px 14px rgba(0,0,0,0.12);
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
        }
        .price-pin:hover .price-pin-bubble {
            background: #F37021;
            color: #FFFFFF;
            border-color: #F37021;
            transform: scale(1.08);
            box-shadow: 0 8px 20px rgba(243, 112, 33, 0.35);
        }
        .price-pin.active .price-pin-bubble {
            background: #111827;
            color: #FFFFFF;
            border-color: #111827;
            transform: scale(1.12);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        .price-pin-arrow {
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 6px solid #E5E7EB;
            margin-top: -1px;
            transition: border-top-color 0.2s ease;
        }
        .price-pin:hover .price-pin-arrow {
            border-top-color: #F37021;
        }
        .price-pin.active .price-pin-arrow {
            border-top-color: #111827;
        }

        /* Marker pulses */
        .marker-selected-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 44px;
            height: 44px;
            border-radius: 9999px;
            border: 2px solid #F37021;
            background: rgba(243, 112, 33, 0.15);
            animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
            pointer-events: none;
        }

        /* Autocomplete dropdown */
        .search-suggestions-popover {
            opacity: 0;
            transform: translateY(-6px) scale(0.98);
            pointer-events: none;
            transition: opacity 0.15s ease, transform 0.15s ease;
        }
        .search-suggestions-popover.open {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .leaflet-control-attribution { font-size: 9px; opacity: 0.5; }
    </style>
</head>
<body class="bg-bgbase text-textmain antialiased h-full w-full overflow-hidden flex flex-col pl-safe pr-safe">

    {{-- Header Navbar --}}
    <x-navbar />

    {{-- Map Container --}}
    <div class="relative flex-1 w-full h-[calc(100vh-4rem)] overflow-hidden">
        
        {{-- Map Canvas --}}
        <div id="map" class="absolute inset-0 w-full h-full"></div>

        {{-- Filter & Search Controls --}}
        <div class="absolute top-3 left-3 right-3 sm:top-6 sm:left-6 sm:right-auto z-20 pointer-events-auto space-y-2 sm:space-y-3.5">
            
            {{-- Filter Buttons --}}
            <div class="flex items-center gap-1.5 sm:gap-3.5 w-full sm:w-auto">
                
                {{-- Status Filter --}}
                <div class="relative flex-1 sm:flex-none" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" 
                            id="btn-filter-status"
                            class="w-full sm:w-auto h-9 sm:h-12 px-2.5 sm:px-4 rounded-[10px] sm:rounded-[14px] text-[11px] sm:text-xs font-bold bg-[#121417] text-white shadow-md flex items-center justify-between sm:justify-start gap-1.5 sm:gap-2.5 hover:bg-black transition whitespace-nowrap">
                        <div class="flex items-center gap-1.5 truncate">
                            <i data-lucide="layers" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-primary shrink-0"></i>
                            <span id="label-status" class="truncate">Semua Status</span>
                        </div>
                        <div class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full border border-gray-600 flex items-center justify-center text-gray-400 text-[8px] sm:text-[10px] shrink-0">
                            <i data-lucide="chevron-down" class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-gray-300"></i>
                        </div>
                    </button>
                    <div x-show="open" x-cloak style="display: none;"
                         class="absolute top-full mt-2 left-0 w-52 sm:w-56 bg-white border border-gray-200 rounded-[18px] shadow-2xl p-2 z-50 divide-y divide-gray-100">
                        <div class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-gray-400">
                            Status Aset
                        </div>
                        <div class="pt-1 space-y-0.5">
                            <button onclick="setFilterStatus('', 'Semua Status'); open=false" class="w-full text-left px-2.5 py-2 rounded-[12px] text-xs font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition flex items-center gap-2.5">
                                <i data-lucide="layers" class="w-4 h-4 text-primary shrink-0"></i>
                                <span>Semua Status</span>
                            </button>
                            <button onclick="setFilterStatus('tersedia', 'Tersedia'); open=false" class="w-full text-left px-2.5 py-2 rounded-[12px] text-xs font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition flex items-center gap-2.5">
                                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                                <span>Tersedia</span>
                            </button>
                            <button onclick="setFilterStatus('proses', 'Dalam Proses'); open=false" class="w-full text-left px-2.5 py-2 rounded-[12px] text-xs font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition flex items-center gap-2.5">
                                <i data-lucide="clock" class="w-4 h-4 text-amber-500 shrink-0"></i>
                                <span>Dalam Proses</span>
                            </button>
                            <button onclick="setFilterStatus('terjual', 'Terjual'); open=false" class="w-full text-left px-2.5 py-2 rounded-[12px] text-xs font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition flex items-center gap-2.5">
                                <i data-lucide="tag" class="w-4 h-4 text-rose-500 shrink-0"></i>
                                <span>Terjual</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 2. Type / Tipe Filter --}}
                <div class="relative flex-1 sm:flex-none" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" 
                            id="btn-filter-type"
                            class="w-full sm:w-auto h-9 sm:h-12 px-2.5 sm:px-4 rounded-[10px] sm:rounded-[14px] text-[11px] sm:text-xs font-bold bg-[#121417] text-white shadow-md flex items-center justify-between sm:justify-start gap-1.5 sm:gap-2.5 hover:bg-black transition whitespace-nowrap">
                        <div class="flex items-center gap-1.5 truncate">
                            <i data-lucide="building-2" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-primary shrink-0"></i>
                            <span id="label-type" class="truncate">Semua Tipe</span>
                        </div>
                        <div class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full border border-gray-600 flex items-center justify-center text-gray-400 text-[8px] sm:text-[10px] shrink-0">
                            <i data-lucide="chevron-down" class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-gray-300"></i>
                        </div>
                    </button>
                    <div x-show="open" x-cloak style="display: none;"
                         class="absolute top-full mt-2 left-0 w-52 sm:w-56 bg-white border border-gray-200 rounded-[18px] shadow-2xl p-2 z-50 divide-y divide-gray-100">
                        <div class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-gray-400">
                            Tipe Properti
                        </div>
                        <div class="pt-1 space-y-0.5">
                            <button onclick="setFilterType('', 'Semua Tipe'); open=false" class="w-full text-left px-2.5 py-2 rounded-[12px] text-xs font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition flex items-center gap-2.5">
                                <i data-lucide="layout-grid" class="w-4 h-4 text-primary shrink-0"></i>
                                <span>Semua Tipe</span>
                            </button>
                            <button onclick="setFilterType('gudang', 'Gudang Logistik'); open=false" class="w-full text-left px-2.5 py-2 rounded-[12px] text-xs font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition flex items-center gap-2.5">
                                <i data-lucide="warehouse" class="w-4 h-4 text-indigo-500 shrink-0"></i>
                                <span>Gudang Logistik</span>
                            </button>
                            <button onclick="setFilterType('rumah dinas', 'Rumah Dinas'); open=false" class="w-full text-left px-2.5 py-2 rounded-[12px] text-xs font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition flex items-center gap-2.5">
                                <i data-lucide="home" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                                <span>Rumah Dinas</span>
                            </button>
                            <button onclick="setFilterType('lahan', 'Lahan Komersial'); open=false" class="w-full text-left px-2.5 py-2 rounded-[12px] text-xs font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition flex items-center gap-2.5">
                                <i data-lucide="map" class="w-4 h-4 text-amber-500 shrink-0"></i>
                                <span>Lahan Komersial</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 3. Wilayah Dropdown --}}
                <div class="relative flex-1 sm:flex-none" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" 
                            id="btn-filter-district"
                            class="w-full sm:w-auto h-9 sm:h-12 px-2.5 sm:px-4 rounded-[10px] sm:rounded-[14px] text-[11px] sm:text-xs font-bold bg-white border border-gray-200 text-gray-900 shadow-md flex items-center justify-between sm:justify-start gap-1.5 sm:gap-2 hover:border-primary hover:text-primary transition whitespace-nowrap">
                        <div class="flex items-center gap-1.5 truncate">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-primary shrink-0"></i>
                            <span id="label-district" class="truncate">Wilayah</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400 shrink-0"></i>
                    </button>
                    <div x-show="open" x-cloak style="display: none;"
                         class="absolute top-full mt-2 left-0 w-56 sm:w-60 bg-white border border-gray-200 rounded-[18px] shadow-2xl p-2 z-50 divide-y divide-gray-100">
                        <div class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-gray-400">
                            Wilayah Operasional
                        </div>
                        <div class="pt-1 space-y-0.5">
                            <button onclick="setFilterDistrict('', 'Semua Wilayah'); open=false" class="w-full text-left px-2.5 py-2 rounded-[12px] text-xs font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition flex items-center gap-2.5">
                                <i data-lucide="map" class="w-4 h-4 text-primary shrink-0"></i>
                                <span>Semua Wilayah</span>
                            </button>
                            <button onclick="setFilterDistrict('genuk', 'Genuk'); open=false" class="w-full text-left px-2.5 py-2 rounded-[12px] text-xs font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition flex items-center gap-2.5">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-500 shrink-0"></i>
                                <span>Genuk - Semarang Timur</span>
                            </button>
                            <button onclick="setFilterDistrict('candisari', 'Candisari'); open=false" class="w-full text-left px-2.5 py-2 rounded-[12px] text-xs font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition flex items-center gap-2.5">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-500 shrink-0"></i>
                                <span>Candisari - Semarang Atas</span>
                            </button>
                            <button onclick="setFilterDistrict('semarang utara', 'Poncol'); open=false" class="w-full text-left px-2.5 py-2 rounded-[12px] text-xs font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition flex items-center gap-2.5">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-500 shrink-0"></i>
                                <span>Semarang Utara / Poncol</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Reset Button --}}
                <button onclick="resetAllFilters()" 
                        title="Reset Semua Filter"
                        class="h-9 w-9 sm:h-12 sm:w-12 rounded-[10px] sm:rounded-[14px] bg-white border border-gray-200 text-gray-700 hover:text-primary hover:border-primary shadow-md flex items-center justify-center transition shrink-0">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                </button>
            </div>

            {{-- Row 2: Search Bar Squircle (Clean Input, No Extra Header Text) --}}
            <div class="relative w-full sm:w-[380px]">
                <div class="flex items-center bg-white border border-gray-200 shadow-xl rounded-[14px] sm:rounded-[18px] px-3.5 sm:px-4 h-11 sm:h-12 w-full">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400 shrink-0 mr-2.5 sm:mr-3"></i>
                    <input type="text" id="map-search-input"
                           placeholder="Cari nama aset, wilayah, jalan..."
                           autocomplete="off"
                           oninput="handleSearchInput(this.value)"
                           class="bg-transparent text-xs sm:text-sm font-semibold text-gray-950 placeholder-gray-400 outline-none w-full border-none p-0 focus:ring-0 leading-tight">
                    <button onclick="clearSearch()" id="search-clear-btn" class="hidden text-gray-400 hover:text-gray-600 p-1">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full border border-gray-300 flex items-center justify-center">
                            <i data-lucide="x" class="w-2.5 h-2.5 sm:w-3 sm:h-3"></i>
                        </div>
                    </button>
                </div>

                {{-- Autocomplete Suggestions Dropdown --}}
                <div id="search-suggestions"
                     class="search-suggestions-popover absolute top-full mt-2 left-0 right-0 bg-white border border-gray-200 rounded-[18px] shadow-2xl overflow-hidden z-50 divide-y divide-gray-100 max-h-56 sm:max-h-64 overflow-y-auto">
                </div>
            </div>

        </div>

        {{-- Bottom-Left Floating Zoom Controls (Desktop only) --}}
        <div class="absolute bottom-6 left-4 z-20 hidden lg:flex flex-col bg-white border border-gray-200 rounded-[20px] shadow-xl overflow-hidden">
            <button onclick="map.zoomIn()" class="w-10 h-10 flex items-center justify-center text-gray-700 hover:bg-orange-50 hover:text-primary transition border-b border-gray-100">
                <i data-lucide="plus" class="w-4 h-4"></i>
            </button>
            <button onclick="map.zoomOut()" class="w-10 h-10 flex items-center justify-center text-gray-700 hover:bg-orange-50 hover:text-primary transition border-b border-gray-100">
                <i data-lucide="minus" class="w-4 h-4"></i>
            </button>
            <button onclick="resetMapView()" title="Pusat Peta" class="w-10 h-10 flex items-center justify-center text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i data-lucide="crosshair" class="w-4 h-4"></i>
            </button>
        </div>

        {{-- Empty Notice Badge on Map --}}
        <div id="map-empty-notice" class="hidden absolute bottom-24 lg:bottom-6 left-1/2 -translate-x-1/2 z-20 pointer-events-none w-max max-w-[90vw]">
            <div class="bg-gray-900/90 backdrop-blur-md text-white rounded-full px-4 py-2 flex items-center gap-2 shadow-2xl text-xs font-semibold">
                <i data-lucide="info" class="w-4 h-4 text-primary shrink-0"></i>
                <span>Tidak ada aset yang cocok dengan filter</span>
            </div>
        </div>

        {{-- Detail Panel --}}
        <div id="floating-property-panel" 
             class="hidden fixed lg:absolute bottom-[calc(5.75rem+env(safe-area-inset-bottom,0px))] lg:bottom-6 lg:top-6 right-3 lg:right-6 left-3 sm:left-auto w-auto sm:w-[460px] lg:w-[540px] xl:w-[580px] z-30 pointer-events-auto bg-white rounded-[24px] sm:rounded-[28px] lg:rounded-[32px] border border-gray-200/90 shadow-2xl p-3.5 sm:p-5 lg:p-6 flex flex-col justify-between space-y-2.5 sm:space-y-3.5 transition-all duration-300">
            
            {{-- Close Button --}}
            <button onclick="closePropertyPanel()" 
                    title="Tutup Panel"
                    class="absolute top-3 right-3 sm:top-4 sm:right-4 z-30 w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-gray-100/90 hover:bg-gray-200 text-gray-700 shadow-xs flex items-center justify-center transition">
                <i data-lucide="x" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
            </button>

            {{-- Main Asset Preview --}}
            <div class="space-y-2 sm:space-y-3">
                
                {{-- Hero Photo Container --}}
                <div class="relative h-28 sm:h-44 lg:h-52 w-full rounded-[16px] sm:rounded-[20px] lg:rounded-[24px] overflow-hidden bg-gray-100 group">
                    <img id="hero-image" 
                         src="{{ $assetsForMap[0]['image'] ?? '' }}" 
                         alt="{{ $assetsForMap[0]['title'] ?? 'Properti KAI' }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    
                    {{-- Status & District Badge --}}
                    <div class="absolute top-2 left-2 sm:top-2.5 sm:left-2.5 flex items-center gap-1.5">
                        <span id="hero-status" class="inline-flex items-center px-2 py-0.5 sm:px-3 sm:py-1 rounded-full text-[9px] sm:text-[11px] font-bold bg-white/95 backdrop-blur-md text-emerald-700 shadow-md">
                            • {{ $assetsForMap[0]['status'] ?? 'Tersedia' }}
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full text-[8px] sm:text-[10px] font-semibold bg-gray-900/80 backdrop-blur-md text-white shadow-md">
                            <span id="hero-district">{{ $assetsForMap[0]['district'] ?? 'Semarang' }}</span>
                        </span>
                    </div>

                    {{-- Maps Route Button --}}
                    <div class="absolute top-2 right-10 sm:top-2.5 sm:right-12">
                        <a id="hero-map-rute" 
                           href="https://www.google.com/maps/dir/?api=1&destination={{ $assetsForMap[0]['lat'] ?? '' }},{{ $assetsForMap[0]['lng'] ?? '' }}" 
                           target="_blank"
                           title="Petunjuk Arah Google Maps"
                           class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-white/90 backdrop-blur-md shadow-md flex items-center justify-center text-gray-700 hover:text-primary transition">
                            <i data-lucide="navigation" class="w-3 h-3 sm:w-3.5 sm:h-3.5"></i>
                        </a>
                    </div>

                    {{-- Asset Code Badge --}}
                    <div class="absolute bottom-2 left-2 sm:bottom-2.5 sm:left-2.5 bg-black/60 backdrop-blur-sm text-white text-[8px] sm:text-[10px] font-mono font-medium px-2 py-0.5 rounded-md sm:rounded-lg">
                        Kode: <span id="hero-code">{{ $assetsForMap[0]['asset_code'] ?? 'KAI-AST' }}</span>
                    </div>
                </div>

                {{-- Asset Info --}}
                <div class="space-y-1 sm:space-y-1.5">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h2 id="hero-title" class="text-sm sm:text-base lg:text-lg font-black text-gray-950 tracking-tight leading-snug line-clamp-1">
                                {{ $assetsForMap[0]['title'] ?? 'Nama Properti' }}
                            </h2>
                            <p id="hero-address" class="text-[11px] sm:text-xs text-slate-500 truncate flex items-center gap-1 mt-0.5">
                                <i data-lucide="map-pin" class="w-3 h-3 text-primary shrink-0"></i>
                                <span>{{ $assetsForMap[0]['address'] ?? 'Semarang' }}</span>
                            </p>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="text-[10px] text-gray-400 font-semibold uppercase">Nilai Penawaran</div>
                            <div id="hero-price" class="text-xs sm:text-sm lg:text-base font-extrabold text-primary">
                                {{ $assetsForMap[0]['price'] ?? 'Rp 0' }}
                            </div>
                        </div>
                    </div>

                    {{-- Specs Row --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-1.5 sm:gap-2 pt-1 border-t border-gray-100">
                        <div class="bg-gray-50/80 rounded-[10px] sm:rounded-[12px] p-1.5 sm:p-2 border border-gray-100 text-left">
                            <div class="text-[9px] text-gray-400 font-semibold uppercase">Luas Tanah</div>
                            <div id="hero-land" class="text-[11px] sm:text-xs font-bold text-gray-900">
                                {{ $assetsForMap[0]['land_area'] ?? '-' }}
                            </div>
                        </div>
                        <div class="bg-gray-50/80 rounded-[10px] sm:rounded-[12px] p-1.5 sm:p-2 border border-gray-100 text-left">
                            <div class="text-[9px] text-gray-400 font-semibold uppercase">Luas Bangunan</div>
                            <div id="hero-building" class="text-[11px] sm:text-xs font-bold text-gray-900">
                                {{ $assetsForMap[0]['building_area'] ?? '-' }}
                            </div>
                        </div>
                        <div class="bg-gray-50/80 rounded-[10px] sm:rounded-[12px] p-1.5 sm:p-2 border border-gray-100 text-left">
                            <div class="text-[9px] text-gray-400 font-semibold uppercase">Sertifikat</div>
                            <div id="hero-cert" class="text-[11px] sm:text-xs font-bold text-gray-900 truncate">
                                {{ $assetsForMap[0]['certificate'] ?? 'HPL' }}
                            </div>
                        </div>
                        <div class="bg-gray-50/80 rounded-[10px] sm:rounded-[12px] p-1.5 sm:p-2 border border-gray-100 text-left">
                            <div class="text-[9px] text-gray-400 font-semibold uppercase">Kondisi</div>
                            <div id="hero-condition" class="text-[11px] sm:text-xs font-bold text-gray-900 capitalize">
                                {{ $assetsForMap[0]['condition'] ?? 'Baik' }}
                            </div>
                        </div>
                    </div>

                    {{-- Description Text --}}
                    <p id="hero-desc" class="hidden sm:block text-xs text-gray-600 line-clamp-2 leading-relaxed pt-0.5">
                        {{ $assetsForMap[0]['description'] ?? '' }}
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-2 pt-1 sm:pt-2">
                    <a id="hero-detail-link" 
                       href="{{ isset($assetsForMap[0]) ? route('assets.show', $assetsForMap[0]['id']) : '#' }}" 
                       class="flex-1 h-9 sm:h-11 rounded-[12px] sm:rounded-[14px] bg-primary hover:bg-primary-hover text-white text-xs sm:text-sm font-bold shadow-md flex items-center justify-center gap-2 transition">
                        <span>Lihat Detail Lengkap</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                    </a>
                    <a id="hero-wa-btn" 
                       href="https://wa.me/6281234567890?text={{ urlencode('Halo KAI Daop 4, saya tertarik dengan aset: ' . ($assetsForMap[0]['title'] ?? '')) }}" 
                       target="_blank"
                       class="h-9 sm:h-11 px-3 sm:px-4 rounded-[12px] sm:rounded-[14px] bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold shadow-md flex items-center justify-center gap-1.5 transition shrink-0">
                        <i data-lucide="message-circle" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                        <span class="hidden sm:inline">Hubungi</span>
                    </a>
                </div>
            </div>

            {{-- Nearby Assets --}}
            <div class="hidden sm:block pt-2 sm:pt-3 border-t border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-[11px] font-bold text-gray-900 uppercase tracking-wider">
                        Aset Terkait Lainnya
                    </div>
                    <a href="{{ route('assets.catalog') }}" class="text-[11px] font-semibold text-primary hover:underline flex items-center gap-0.5">
                        <span>Semua</span>
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    </a>
                </div>

                {{-- Mini Cards Container --}}
                <div class="grid grid-cols-3 gap-2" id="mini-cards-container">
                    @foreach(array_slice($assetsForMap->toArray(), 0, 3) as $index => $item)
                    <div onclick="selectAssetById({{ $item['id'] }})"
                         id="mini-card-{{ $item['id'] }}"
                         class="mini-card group cursor-pointer bg-gray-50/90 hover:bg-white rounded-[16px] border {{ $index === 0 ? 'border-primary ring-2 ring-primary/20' : 'border-gray-200' }} p-2 hover:shadow-md transition flex flex-col justify-between shrink-0">
                        
                        {{-- Mini Thumbnail --}}
                        <div class="relative h-16 sm:h-20 w-full rounded-[12px] overflow-hidden bg-gray-100 mb-1">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <span class="absolute top-1 left-1 px-1.5 py-0.5 rounded-md text-[8px] sm:text-[9px] font-bold bg-white/90 backdrop-blur-xs text-gray-900 shadow-xs">
                                {{ $item['short_price'] }}
                            </span>
                        </div>

                        {{-- Mini Details --}}
                        <div class="space-y-0.5">
                            <h3 class="text-[10px] sm:text-[11px] font-bold text-gray-900 truncate group-hover:text-primary transition">
                                {{ $item['title'] }}
                            </h3>
                            <p class="text-[9px] sm:text-[10px] text-slate-500 truncate flex items-center gap-1">
                                <i data-lucide="map-pin" class="w-2.5 h-2.5 text-primary shrink-0"></i>
                                <span>{{ $item['district'] }}</span>
                            </p>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    {{-- Map Script --}}
    <script>
        const rawAssets = @json($assetsForMap);
        let currentStatusFilter = '';
        let currentTypeFilter = '';
        let currentDistrictFilter = '';
        let currentSearchQuery = '';
        let selectedAssetId = rawAssets.length > 0 ? rawAssets[0].id : null;
        let markersMap = {};

        // Initialize Leaflet Map
        const map = L.map('map', { 
            zoomControl: false, 
            attributionControl: true 
        }).setView([-6.9932, 110.4203], 13);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://carto.com/">CARTO</a> | PT KAI Daop 4'
        }).addTo(map);

        // Render Price Tag Marker Pins
        function renderMarkers() {
            // Clear existing markers
            Object.values(markersMap).forEach(m => map.removeLayer(m));
            markersMap = {};

            const filtered = rawAssets.filter(item => {
                const matchStatus = !currentStatusFilter || (item.raw_status && item.raw_status.toLowerCase() === currentStatusFilter.toLowerCase());
                const matchType = !currentTypeFilter || (
                    (item.title && item.title.toLowerCase().includes(currentTypeFilter)) ||
                    (item.description && item.description.toLowerCase().includes(currentTypeFilter))
                );
                const matchDistrict = !currentDistrictFilter || (
                    (item.district && item.district.toLowerCase().includes(currentDistrictFilter)) ||
                    (item.address && item.address.toLowerCase().includes(currentDistrictFilter))
                );
                const matchSearch = !currentSearchQuery || (
                    (item.title && item.title.toLowerCase().includes(currentSearchQuery)) ||
                    (item.address && item.address.toLowerCase().includes(currentSearchQuery)) ||
                    (item.district && item.district.toLowerCase().includes(currentSearchQuery))
                );
                return matchStatus && matchType && matchDistrict && matchSearch;
            });

            // Toggle empty state notice
            const emptyNotice = document.getElementById('map-empty-notice');
            if (emptyNotice) {
                emptyNotice.classList.toggle('hidden', filtered.length > 0);
            }

            if (filtered.length === 0) return;

            filtered.forEach(item => {
                const isActive = item.id === selectedAssetId;
                const iconHtml = `
                    <div class="price-pin ${isActive ? 'active' : ''}" id="marker-${item.id}">
                        <div class="price-pin-bubble">
                            <span>${item.short_price}</span>
                        </div>
                        <div class="price-pin-dot"></div>
                    </div>
                `;

                const customIcon = L.divIcon({
                    className: 'custom-leaflet-price-pin',
                    html: iconHtml,
                    iconSize: [80, 36],
                    iconAnchor: [40, 36]
                });

                const marker = L.marker([item.lat, item.lng], { icon: customIcon }).addTo(map);
                marker.on('click', () => {
                    selectAssetById(item.id);
                });

                markersMap[item.id] = marker;
            });

            // If selected item is not in filtered list, close or update
            if (selectedAssetId && !filtered.some(a => a.id === selectedAssetId)) {
                closePropertyPanel();
            }
        }

        // Select Asset and Update Floating Card & Map Fly-To
        function selectAssetById(id, shouldFly = true) {
            const asset = rawAssets.find(a => a.id === id);
            if (!asset) return;

            selectedAssetId = id;

            // Open Floating Property Panel
            const panel = document.getElementById('floating-property-panel');
            if (panel) {
                panel.classList.remove('hidden');
            }

            // Update Featured Hero Card Elements
            const heroImg = document.getElementById('hero-image');
            if (heroImg) heroImg.src = asset.image;

            const heroStatus = document.getElementById('hero-status');
            if (heroStatus) heroStatus.textContent = '• ' + asset.status;

            const heroDistrict = document.getElementById('hero-district');
            if (heroDistrict) heroDistrict.textContent = asset.district;

            const heroCode = document.getElementById('hero-code');
            if (heroCode) heroCode.textContent = asset.asset_code || 'KAI-AST';

            const heroTitle = document.getElementById('hero-title');
            if (heroTitle) heroTitle.textContent = asset.title;

            const heroAddress = document.getElementById('hero-address');
            if (heroAddress) heroAddress.textContent = asset.address;

            const heroPrice = document.getElementById('hero-price');
            if (heroPrice) heroPrice.textContent = asset.price;

            const heroLand = document.getElementById('hero-land');
            if (heroLand) heroLand.textContent = asset.land_area;

            const heroBuilding = document.getElementById('hero-building');
            if (heroBuilding) heroBuilding.textContent = asset.building_area;

            const heroAccess = document.getElementById('hero-access');
            if (heroAccess) heroAccess.textContent = asset.road_access;

            const heroElectricity = document.getElementById('hero-electricity');
            if (heroElectricity) heroElectricity.textContent = asset.electricity || '33.000 VA';

            const heroDescription = document.getElementById('hero-description');
            if (heroDescription) heroDescription.textContent = asset.description;

            const heroLikes = document.getElementById('hero-likes');
            if (heroLikes) heroLikes.textContent = (asset.likes_count || 0) + ' Disukai';

            // Update Action Buttons
            const heroWaBtn = document.getElementById('hero-wa-btn');
            if (heroWaBtn) {
                const cleanPhone = (asset.contact_phone || '6281234567890').replace(/[^0-9]/g, '');
                const waText = encodeURIComponent(`Halo Unit Komersialisasi KAI Daop 4, saya berminat dengan aset: ${asset.title} (${asset.asset_code || ''}).`);
                heroWaBtn.href = `https://wa.me/${cleanPhone}?text=${waText}`;
            }

            const heroDetailBtn = document.getElementById('hero-detail-btn');
            if (heroDetailBtn) {
                heroDetailBtn.href = `/assets/${asset.id}`;
            }

            const heroMapRute = document.getElementById('hero-map-rute');
            if (heroMapRute) {
                heroMapRute.href = `https://www.google.com/maps/dir/?api=1&destination=${asset.lat},${asset.lng}`;
            }

            // Update mini-card active rings
            document.querySelectorAll('.mini-card').forEach(c => {
                c.classList.remove('border-primary', 'ring-2', 'ring-primary/20');
                c.classList.add('border-gray-200');
            });
            const activeMini = document.getElementById(`mini-card-${asset.id}`);
            if (activeMini) {
                activeMini.classList.remove('border-gray-200');
                activeMini.classList.add('border-primary', 'ring-2', 'ring-primary/20');
            }

            // Update active marker pin
            document.querySelectorAll('.price-pin').forEach(p => p.classList.remove('active'));
            const activePinEl = document.getElementById(`marker-${asset.id}`);
            if (activePinEl) {
                activePinEl.classList.add('active');
            }

            // Fly map to selected coordinates
            if (shouldFly) {
                map.flyTo([asset.lat, asset.lng], 15, { animate: true, duration: 1.0 });
            }

            lucide.createIcons();
        }

        // Close Floating Box Function
        function closePropertyPanel() {
            const panel = document.getElementById('floating-property-panel');
            if (panel) panel.classList.add('hidden');
            document.querySelectorAll('.price-pin').forEach(p => p.classList.remove('active'));
            selectedAssetId = null;
        }

        // Live Search Input Autocomplete
        function handleSearchInput(val) {
            const clearBtn = document.getElementById('search-clear-btn');
            const popover = document.getElementById('search-suggestions');
            currentSearchQuery = val.trim().toLowerCase();

            if (clearBtn) clearBtn.classList.toggle('hidden', currentSearchQuery.length === 0);

            if (currentSearchQuery.length < 2) {
                if (popover) {
                    popover.classList.remove('open');
                    popover.innerHTML = '';
                }
                renderMarkers();
                return;
            }

            const matches = rawAssets.filter(item => 
                item.title.toLowerCase().includes(currentSearchQuery) ||
                item.address.toLowerCase().includes(currentSearchQuery) ||
                item.district.toLowerCase().includes(currentSearchQuery)
            );

            if (popover) {
                if (matches.length === 0) {
                    popover.innerHTML = `
                        <div class="p-4 text-center text-xs text-gray-500">
                            Tidak ada aset yang cocok dengan "${val}"
                        </div>
                    `;
                } else {
                    popover.innerHTML = matches.map(item => {
                        const regex = new RegExp(`(${currentSearchQuery})`, 'gi');
                        const highlightedTitle = item.title.replace(regex, '<mark class="bg-orange-100 text-primary font-bold px-0.5 rounded">$1</mark>');
                        return `
                            <button onclick="selectSuggestion(${item.id})" class="w-full text-left p-3 hover:bg-orange-50/80 transition flex items-center gap-3">
                                <img src="${item.image}" class="w-10 h-10 rounded-[12px] object-cover shrink-0 border border-gray-200">
                                <div class="min-w-0 flex-1">
                                    <div class="text-xs font-bold text-gray-900 truncate">${highlightedTitle}</div>
                                    <div class="text-[11px] text-gray-500 truncate">${item.address}</div>
                                </div>
                                <div class="text-right shrink-0">
                                    <div class="text-xs font-bold text-primary">${item.short_price}</div>
                                    <span class="text-[10px] text-emerald-600 font-semibold">${item.status}</span>
                                </div>
                            </button>
                        `;
                    }).join('');
                }
                popover.classList.add('open');
            }

            renderMarkers();
        }

        function selectSuggestion(id) {
            selectAssetById(id);
            const popover = document.getElementById('search-suggestions');
            if (popover) {
                popover.classList.remove('open');
                popover.innerHTML = '';
            }
        }

        function clearSearch() {
            const input = document.getElementById('map-search-input');
            if (input) input.value = '';
            handleSearchInput('');
        }

        // Filter Handlers
        function setFilterStatus(status, label) {
            currentStatusFilter = status;
            const lbl = document.getElementById('label-status');
            if (lbl) lbl.textContent = label;
            renderMarkers();
        }

        function setFilterType(type, label) {
            currentTypeFilter = type;
            const lbl = document.getElementById('label-type');
            if (lbl) lbl.textContent = label;
            renderMarkers();
        }

        function setFilterDistrict(district, label) {
            currentDistrictFilter = district;
            const lbl = document.getElementById('label-district');
            if (lbl) lbl.textContent = label;
            renderMarkers();
        }

        function resetAllFilters() {
            currentStatusFilter = '';
            currentTypeFilter = '';
            currentDistrictFilter = '';
            currentSearchQuery = '';
            clearSearch();
            setFilterStatus('', 'Semua Status');
            setFilterType('', 'Semua Tipe');
            setFilterDistrict('', 'Wilayah');
            closePropertyPanel();
            resetMapView();
        }

        function resetMapView() {
            if (rawAssets.length > 0) {
                map.flyTo([-6.9932, 110.4203], 13, { duration: 1.0 });
            }
        }

        // Dismiss search popover on outside click
        document.addEventListener('click', (e) => {
            const searchWrap = document.getElementById('map-search-input');
            const popover = document.getElementById('search-suggestions');
            if (popover && searchWrap && !searchWrap.contains(e.target) && !popover.contains(e.target)) {
                popover.classList.remove('open');
            }
        });

        // Initialize markers on DOM Ready (Detail box hidden until user clicks a pin!)
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            renderMarkers();
        });
    </script>
</body>
</html>