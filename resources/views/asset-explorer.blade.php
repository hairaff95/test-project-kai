<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>SpatialTrack - Asset Explorer (KAI Daop 4 Semarang)</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Inter:wght@400;500&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "background": "#f5fbf5",
                        "primary": "#006948",
                        "primary-container": "#00855d",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#f5fff7",
                        "secondary-container": "#fea619",
                        "on-surface": "#171d19",
                        "on-surface-variant": "#3d4a42",
                        "surface-container-low": "#eff5ef",
                        "surface-variant": "#dee4de",
                        "surface-dim": "#d5dcd6",
                        "outline": "#6d7a72",
                        "outline-variant": "#bccac0",
                        "glass-surface": "rgba(255, 255, 255, 0.82)",
                        "glass-border": "rgba(255, 255, 255, 0.55)",
                        "map-dark-pill": "rgba(15, 18, 22, 0.88)",
                    },
                    borderRadius: {
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        "full": "9999px"
                    },
                    fontFamily: {
                        "geist": ["Geist", "sans-serif"],
                        "inter": ["Inter", "sans-serif"]
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: "Inter", sans-serif;
        }

        #map {
            height: 100vh;
            width: 100vw;
            z-index: 1;
        }

        .custom-pin {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background-color: #e59524;
            color: white;
            border-radius: 50%;
            border: 3px solid #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .custom-pin:hover,
        .custom-pin.active {
            transform: scale(1.25);
            background-color: #006948;
        }

        .leaflet-control-attribution {
            font-size: 9px;
            opacity: 0.6;
        }
    </style>
</head>

<body class="bg-background text-on-background h-screen w-screen overflow-hidden relative">
    <div id="map" class="absolute inset-0"></div>

    <div class="fixed top-3 left-3 right-3 md:top-4 md:left-28 md:right-4 z-20 flex flex-col items-center gap-3 pointer-events-none">
        <div class="flex flex-wrap items-center justify-between md:justify-start gap-2 md:gap-4 bg-glass-surface backdrop-blur-2xl border border-glass-border shadow-md rounded-2xl md:rounded-full py-2 px-3 md:px-4 pointer-events-auto w-full md:w-auto max-w-full overflow-x-auto">
            <div class="flex items-center gap-2 bg-surface-container-low rounded-full px-3 py-1.5 md:px-4 md:py-2 flex-1 md:w-80 min-w-[180px]">
                <span class="material-symbols-outlined text-outline text-lg md:text-2xl">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-xs md:text-sm font-medium w-full placeholder:text-outline-variant outline-none"
                    placeholder="Cari aset di Semarang..." type="text" />
            </div>
            <div class="hidden sm:block h-6 w-px bg-outline-variant"></div>
            <div class="flex items-center gap-1 sm:gap-2 overflow-x-auto">
                <button class="flex items-center gap-1 px-3 py-1.5 rounded-full hover:bg-surface-variant/50 transition-colors text-xs md:text-sm font-medium text-on-surface-variant whitespace-nowrap">
                    Tipe <span class="material-symbols-outlined text-xs md:text-sm">arrow_drop_down</span>
                </button>
                <button class="flex items-center gap-1 px-3 py-1.5 rounded-full hover:bg-surface-variant/50 transition-colors text-xs md:text-sm font-medium text-on-surface-variant whitespace-nowrap">
                    Status <span class="material-symbols-outlined text-xs md:text-sm">arrow_drop_down</span>
                </button>
                <button class="flex items-center gap-1 px-3 py-1.5 rounded-full hover:bg-surface-variant/50 transition-colors text-xs md:text-sm font-medium text-on-surface-variant whitespace-nowrap">
                    Harga <span class="material-symbols-outlined text-xs md:text-sm">arrow_drop_down</span>
                </button>
            </div>
        </div>

        <div class="flex flex-row items-center gap-2 md:gap-4 pointer-events-auto overflow-x-auto max-w-full px-1">
            <div class="bg-map-dark-pill backdrop-blur-md rounded-xl md:rounded-2xl p-2.5 md:p-4 flex flex-col items-center justify-center min-w-[95px] md:min-w-[120px] shadow-lg border border-white/10">
                <span class="font-geist font-bold text-base md:text-xl text-white">{{ $kpi['total_assets'] }}</span>
                <span class="font-geist text-[10px] md:text-xs uppercase tracking-wider text-surface-dim mt-0.5">Total Aset</span>
            </div>
            <div class="bg-map-dark-pill backdrop-blur-md rounded-xl md:rounded-2xl p-2.5 md:p-4 flex flex-col items-center justify-center min-w-[125px] md:min-w-[160px] shadow-lg border border-white/10">
                <span class="font-geist font-bold text-base md:text-xl text-white">{{ $kpi['total_valuation'] }}</span>
                <span class="font-geist text-[10px] md:text-xs uppercase tracking-wider text-surface-dim mt-0.5">Estimasi Total</span>
            </div>
            <div class="bg-map-dark-pill backdrop-blur-md rounded-xl md:rounded-2xl p-2.5 md:p-4 flex flex-col items-center justify-center min-w-[95px] md:min-w-[120px] shadow-lg border border-white/10">
                <span class="font-geist font-bold text-base md:text-xl text-white">{{ $kpi['average_age'] }}</span>
                <span class="font-geist text-[10px] md:text-xs uppercase tracking-wider text-surface-dim mt-0.5">Rata Usia</span>
            </div>
        </div>
    </div>

    <nav class="fixed left-3 md:left-4 top-1/2 -translate-y-1/2 w-14 md:w-20 hidden sm:flex flex-col gap-2 md:gap-3 items-center py-6 md:py-8 rounded-full h-[75vh] md:h-[85vh] max-h-[750px] bg-glass-surface backdrop-blur-3xl border border-glass-border shadow-[0_0_20px_rgba(255,255,255,0.4)] z-30">
        <div class="mb-3 md:mb-6">
            <span class="material-symbols-outlined text-2xl md:text-3xl text-primary">train</span>
        </div>
        <div class="flex flex-col gap-2 md:gap-3 w-full items-center flex-1">
            <a href="{{ route('assets.index') }}" title="Peta Aset"
                class="bg-primary text-on-primary rounded-full p-2.5 md:p-3 shadow-md scale-105 md:scale-110 flex items-center justify-center">
                <span class="material-symbols-outlined text-lg md:text-2xl">map</span>
            </a>
            <a href="{{ route('assets.manage') }}" title="Kelola Aset"
                class="text-on-surface-variant hover:bg-surface-variant/50 rounded-full p-2.5 md:p-3 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-lg md:text-2xl">add_circle</span>
            </a>
            <a href="#" title="Riwayat Pengajuan"
                class="text-on-surface-variant hover:bg-surface-variant/50 rounded-full p-2.5 md:p-3 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-lg md:text-2xl">description</span>
            </a>
        </div>
        <div class="flex flex-col gap-2 md:gap-3 w-full items-center mt-auto">
            <a href="#" title="Bantuan"
                class="text-on-surface-variant hover:bg-surface-variant/50 rounded-full p-2.5 md:p-3 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-lg md:text-2xl">help</span>
            </a>
            <a href="#" title="Profil Pegawai"
                class="text-on-surface-variant hover:bg-surface-variant/50 rounded-full p-2.5 md:p-3 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-lg md:text-2xl">account_circle</span>
            </a>
        </div>
    </nav>

    <div class="fixed bottom-3 left-3 right-3 sm:left-20 md:left-28 md:right-6 md:bottom-6 z-20 pointer-events-auto">
        <div class="bg-glass-surface backdrop-blur-2xl border border-glass-border rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-[0_8px_32px_rgba(0,0,0,0.12)] flex flex-col md:flex-row gap-4 md:gap-8 max-w-5xl mx-auto max-h-[55vh] md:max-h-none overflow-y-auto">
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-1 md:mb-2">
                        <h2 id="asset-title" class="font-geist font-semibold text-base md:text-xl text-on-surface">
                            {{ $assets[0]['title'] }}</h2>
                        <button class="text-secondary-container hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-lg md:text-2xl">favorite_border</span>
                        </button>
                    </div>
                    <p id="asset-address" class="text-xs md:text-sm font-medium text-on-surface-variant flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px] md:text-[18px]">location_on</span>
                        {{ $assets[0]['address'] }}
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-2 md:gap-4 mt-3 md:mt-6">
                    <div class="bg-surface-container-low rounded-xl md:rounded-2xl p-2.5 md:p-3 flex flex-col gap-0.5 md:gap-1">
                        <span class="material-symbols-outlined text-outline text-base md:text-lg">domain</span>
                        <span class="text-[9px] md:text-[11px] font-semibold tracking-wider text-on-surface-variant">LUAS TANAH</span>
                        <span id="asset-land" class="font-geist font-bold text-xs md:text-base text-on-surface">{{ $assets[0]['land_area'] }}</span>
                    </div>
                    <div class="bg-surface-container-low rounded-xl md:rounded-2xl p-2.5 md:p-3 flex flex-col gap-0.5 md:gap-1">
                        <span class="material-symbols-outlined text-outline text-base md:text-lg">warehouse</span>
                        <span class="text-[9px] md:text-[11px] font-semibold tracking-wider text-on-surface-variant">BANGUNAN</span>
                        <span id="asset-building" class="font-geist font-bold text-xs md:text-base text-on-surface">{{ $assets[0]['building_area'] }}</span>
                    </div>
                    <div class="bg-surface-container-low rounded-xl md:rounded-2xl p-2.5 md:p-3 flex flex-col gap-0.5 md:gap-1">
                        <span class="material-symbols-outlined text-outline text-base md:text-lg">local_shipping</span>
                        <span class="text-[9px] md:text-[11px] font-semibold tracking-wider text-on-surface-variant">AKSES</span>
                        <span id="asset-access" class="text-[10px] md:text-xs font-semibold text-on-surface mt-0.5 md:mt-1 truncate">{{ $assets[0]['road_access'] }}</span>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-[340px] lg:w-[380px] flex flex-col gap-3 md:gap-4">
                <div class="relative w-full h-32 md:h-40 rounded-xl md:rounded-2xl overflow-hidden shadow-inner">
                    <img id="asset-image" alt="Asset Preview"
                        class="w-full h-full object-cover transition-opacity duration-300"
                        src="{{ $assets[0]['image'] }}" />
                    <div id="asset-status"
                        class="absolute top-2 left-2 md:top-3 md:left-3 bg-primary text-on-primary text-[10px] md:text-[11px] font-bold px-2.5 py-0.5 md:px-3 md:py-1 rounded-full shadow-md">
                        {{ $assets[0]['status'] }}
                    </div>
                </div>
                <div class="flex justify-between items-end px-1 md:px-2">
                    <div class="flex flex-col">
                        <span class="text-[9px] md:text-[11px] font-semibold tracking-wider text-on-surface-variant uppercase">PENAWARAN</span>
                        <span id="asset-price" class="font-geist font-bold text-lg md:text-2xl text-primary mt-0.5">{{ $assets[0]['price'] }}</span>
                    </div>
                    <a id="asset-detail-link" href="{{ route('assets.show', $assets[0]['id']) }}"
                        class="bg-primary hover:bg-primary-container text-on-primary rounded-full px-4 py-2 md:px-5 md:py-3 flex items-center gap-1.5 md:gap-2 transition-all shadow-lg hover:shadow-xl font-medium text-xs md:text-sm">
                        <span>Detail Aset</span>
                        <span class="material-symbols-outlined text-xs md:text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const assets = @json($assets);

        const map = L.map('map', {
            zoomControl: false,
            attributionControl: true
        }).setView([-6.9932, 110.4203], 13);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://carto.com/">CARTO</a> | PT Kereta Api Indonesia'
        }).addTo(map);

        assets.forEach(asset => {
            const customIcon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div class="custom-pin"><span class="material-symbols-outlined text-[18px]">home_pin</span></div>`,
                iconSize: [32, 32],
                iconAnchor: [16, 16]
            });

            const marker = L.marker([asset.lat, asset.lng], { icon: customIcon }).addTo(map);

            marker.on('click', () => {
                map.flyTo([asset.lat, asset.lng], 15, { duration: 1.2 });

                document.getElementById('asset-title').innerText = asset.title;
                document.getElementById('asset-address').innerHTML = `<span class="material-symbols-outlined text-[16px] md:text-[18px]">location_on</span> ${asset.address}`;
                document.getElementById('asset-land').innerText = asset.land_area;
                document.getElementById('asset-building').innerText = asset.building_area;
                document.getElementById('asset-access').innerText = asset.road_access;
                document.getElementById('asset-price').innerText = asset.price;
                document.getElementById('asset-status').innerText = asset.status;
                document.getElementById('asset-detail-link').href = `/assets/${asset.id}`;

                const imgEl = document.getElementById('asset-image');
                imgEl.style.opacity = '0.3';
                setTimeout(() => {
                    imgEl.src = asset.image;
                    imgEl.style.opacity = '1';
                }, 150);
            });
        });
    </script>
</body>

</html>