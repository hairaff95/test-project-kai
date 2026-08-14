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
                        "glass-surface": "rgba(255, 255, 255, 0.90)",
                        "glass-border": "rgba(255, 255, 255, 0.70)",
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
            transition: transform 0.2s ease, background-color 0.2s ease;
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

        .dropdown-panel {
            opacity: 0;
            transform: translateY(-6px) scale(0.97);
            pointer-events: none;
            transition: opacity 0.18s ease, transform 0.18s ease;
        }

        .dropdown-panel.open {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .dd-item {
            transition: background 0.12s, color 0.12s;
        }

        .dd-item.selected {
            background: rgba(0, 105, 72, 0.10);
            color: #006948;
            font-weight: 600;
        }

        .filter-btn.active {
            background: #006948;
            color: #ffffff;
        }

        .filter-btn.active .filter-icon {
            color: #ffffff;
            transform: rotate(180deg);
        }

        .filter-icon {
            transition: transform 0.2s ease;
            color: #6d7a72;
        }
    </style>
</head>

<body class="bg-background text-on-background h-screen w-screen overflow-hidden relative">
    <div id="map" class="absolute inset-0"></div>

    <div
        class="fixed top-3 left-4 right-4 md:top-4 md:left-28 md:right-4 z-20 flex flex-col items-center gap-3 pointer-events-none">
        <div
            class="flex items-center gap-2 sm:gap-3 md:gap-4 bg-glass-surface backdrop-blur-2xl border border-glass-border shadow-[0_8px_30px_rgba(0,0,0,0.08)] rounded-full py-2 px-3 sm:px-4 pointer-events-auto max-w-full">
            <div
                class="flex items-center gap-2 bg-surface-container-low rounded-full px-3 py-1.5 md:px-4 md:py-2 w-44 sm:w-60 md:w-80 shrink-0">
                <span class="material-symbols-outlined text-outline text-lg md:text-xl">search</span>
                <input id="map-search" oninput="applyFilters()"
                    class="bg-transparent border-none focus:ring-0 text-xs md:text-sm font-medium w-full placeholder:text-outline-variant outline-none"
                    placeholder="Cari aset di Semarang..." type="text" />
            </div>

            <div class="h-6 w-px bg-outline-variant/60 shrink-0"></div>

            <div class="flex items-center gap-1 sm:gap-2 shrink-0">
                <div class="relative" id="dd-tipe-wrap">
                    <button onclick="toggleDropdown('dd-tipe')" id="btn-tipe"
                        class="filter-btn flex items-center gap-1 px-3 py-1.5 rounded-full hover:bg-surface-variant/50 transition text-xs md:text-sm font-medium text-on-surface-variant whitespace-nowrap">
                        <span id="label-tipe">Tipe</span>
                        <span class="material-symbols-outlined filter-icon text-[16px]">expand_more</span>
                    </button>
                    <div id="dd-tipe"
                        class="dropdown-panel absolute top-[calc(100%+8px)] left-0 w-52 bg-white/95 backdrop-blur-2xl rounded-2xl border border-white/70 shadow-[0_12px_40px_rgba(0,0,0,0.15)] p-2 z-50">
                        <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-widest px-2 py-1">
                            Jenis Aset</p>
                        <div class="flex flex-col gap-0.5">
                            <button onclick="selectFilter('tipe','','Tipe',this)"
                                class="dd-item w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm text-on-surface selected">
                                <span class="material-symbols-outlined text-[16px] text-outline">select_all</span>
                                Semua Tipe
                            </button>
                            <button onclick="selectFilter('tipe','gudang','Gudang',this)"
                                class="dd-item w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm text-on-surface">
                                <span class="material-symbols-outlined text-[16px] text-outline">warehouse</span>
                                Gudang
                            </button>
                            <button onclick="selectFilter('tipe','rumah dinas','Rumah Dinas',this)"
                                class="dd-item w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm text-on-surface">
                                <span class="material-symbols-outlined text-[16px] text-outline">home</span>
                                Rumah Dinas
                            </button>
                            <button onclick="selectFilter('tipe','lahan','Lahan',this)"
                                class="dd-item w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm text-on-surface">
                                <span class="material-symbols-outlined text-[16px] text-outline">landscape</span>
                                Lahan
                            </button>
                        </div>
                    </div>
                </div>

                <div class="relative" id="dd-status-wrap">
                    <button onclick="toggleDropdown('dd-status')" id="btn-status"
                        class="filter-btn flex items-center gap-1 px-3 py-1.5 rounded-full hover:bg-surface-variant/50 transition text-xs md:text-sm font-medium text-on-surface-variant whitespace-nowrap">
                        <span id="label-status">Status</span>
                        <span class="material-symbols-outlined filter-icon text-[16px]">expand_more</span>
                    </button>
                    <div id="dd-status"
                        class="dropdown-panel absolute top-[calc(100%+8px)] left-0 w-48 bg-white/95 backdrop-blur-2xl rounded-2xl border border-white/70 shadow-[0_12px_40px_rgba(0,0,0,0.15)] p-2 z-50">
                        <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-widest px-2 py-1">
                            Status Aset</p>
                        <div class="flex flex-col gap-0.5">
                            <button onclick="selectFilter('status','','Status',this)"
                                class="dd-item w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm text-on-surface selected">
                                <span class="w-2 h-2 rounded-full bg-outline-variant"></span>
                                Semua Status
                            </button>
                            <button onclick="selectFilter('status','tersedia','Tersedia',this)"
                                class="dd-item w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm text-on-surface">
                                <span class="w-2 h-2 rounded-full bg-[#006948]"></span>
                                Tersedia
                            </button>
                            <button onclick="selectFilter('status','terjual','Terjual',this)"
                                class="dd-item w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm text-on-surface">
                                <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                Terjual
                            </button>
                        </div>
                    </div>
                </div>

                <div class="relative" id="dd-harga-wrap">
                    <button onclick="toggleDropdown('dd-harga')" id="btn-harga"
                        class="filter-btn flex items-center gap-1 px-3 py-1.5 rounded-full hover:bg-surface-variant/50 transition text-xs md:text-sm font-medium text-on-surface-variant whitespace-nowrap">
                        <span id="label-harga">Harga</span>
                        <span class="material-symbols-outlined filter-icon text-[16px]">expand_more</span>
                    </button>
                    <div id="dd-harga"
                        class="dropdown-panel absolute top-[calc(100%+8px)] left-0 w-52 bg-white/95 backdrop-blur-2xl rounded-2xl border border-white/70 shadow-[0_12px_40px_rgba(0,0,0,0.15)] p-2 z-50">
                        <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-widest px-2 py-1">
                            Rentang Harga</p>
                        <div class="flex flex-col gap-0.5">
                            <button onclick="selectFilter('harga','','Harga',this)"
                                class="dd-item w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm text-on-surface selected">
                                <span
                                    class="material-symbols-outlined text-[16px] text-outline">currency_exchange</span>
                                Semua Harga
                            </button>
                            <button onclick="selectFilter('harga','under-5m','&lt; Rp 5 M',this)"
                                class="dd-item w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm text-on-surface">
                                <span class="material-symbols-outlined text-[16px] text-outline">south</span>
                                &lt; Rp 5 M
                            </button>
                            <button onclick="selectFilter('harga','above-5m','&gt; Rp 5 M',this)"
                                class="dd-item w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm text-on-surface">
                                <span class="material-symbols-outlined text-[16px] text-outline">north</span>
                                &ge; Rp 5 M
                            </button>
                        </div>
                    </div>
                </div>

                <button id="btn-reset" onclick="resetFilters()"
                    class="hidden items-center gap-1 pl-2 pr-3 py-1.5 rounded-full bg-[#006948] text-white text-xs font-medium whitespace-nowrap hover:bg-[#005137] transition">
                    <span class="material-symbols-outlined text-[14px]">close</span>
                    Reset
                </button>
            </div>
        </div>

        <div class="flex flex-row items-center gap-2 md:gap-4 pointer-events-auto max-w-full px-1">
            <div
                class="bg-map-dark-pill backdrop-blur-md rounded-xl md:rounded-2xl p-2.5 md:p-4 flex flex-col items-center justify-center min-w-[95px] md:min-w-[120px] shadow-lg border border-white/10">
                <span id="kpi-count"
                    class="font-geist font-bold text-base md:text-xl text-white">{{ $kpi['total_assets'] }}</span>
                <span class="font-geist text-[10px] md:text-xs uppercase tracking-wider text-surface-dim mt-0.5">Total
                    Aset</span>
            </div>
            <div
                class="bg-map-dark-pill backdrop-blur-md rounded-xl md:rounded-2xl p-2.5 md:p-4 flex flex-col items-center justify-center min-w-[125px] md:min-w-[160px] shadow-lg border border-white/10">
                <span class="font-geist font-bold text-base md:text-xl text-white">{{ $kpi['total_valuation'] }}</span>
                <span
                    class="font-geist text-[10px] md:text-xs uppercase tracking-wider text-surface-dim mt-0.5">Estimasi
                    Total</span>
            </div>
            <div
                class="bg-map-dark-pill backdrop-blur-md rounded-xl md:rounded-2xl p-2.5 md:p-4 flex flex-col items-center justify-center min-w-[95px] md:min-w-[120px] shadow-lg border border-white/10">
                <span class="font-geist font-bold text-base md:text-xl text-white">{{ $kpi['average_age'] }}</span>
                <span class="font-geist text-[10px] md:text-xs uppercase tracking-wider text-surface-dim mt-0.5">Rata
                    Usia</span>
            </div>
        </div>
    </div>

    <x-sidebar />

    <div id="bottom-card"
        class="fixed bottom-3 left-3 right-3 sm:left-20 md:left-28 md:right-6 md:bottom-6 z-20 pointer-events-auto transition-all duration-300">
        <div
            class="bg-glass-surface backdrop-blur-2xl border border-glass-border rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-[0_8px_32px_rgba(0,0,0,0.12)] flex flex-col md:flex-row gap-4 md:gap-8 max-w-5xl mx-auto max-h-[55vh] md:max-h-none overflow-y-auto">
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-1 md:mb-2">
                        <h2 id="asset-title" class="font-geist font-semibold text-base md:text-xl text-on-surface">
                            {{ $assetsForMap[0]['title'] ?? '' }}
                        </h2>
                        <button class="text-secondary-container hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-lg md:text-2xl">favorite_border</span>
                        </button>
                    </div>
                    <p id="asset-address"
                        class="text-xs md:text-sm font-medium text-on-surface-variant flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px] md:text-[18px]">location_on</span>
                        {{ $assetsForMap[0]['address'] ?? '' }}
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-2 md:gap-4 mt-3 md:mt-6">
                    <div
                        class="bg-surface-container-low rounded-xl md:rounded-2xl p-2.5 md:p-3 flex flex-col gap-0.5 md:gap-1">
                        <span class="material-symbols-outlined text-outline text-base md:text-lg">domain</span>
                        <span
                            class="text-[9px] md:text-[11px] font-semibold tracking-wider text-on-surface-variant">LUAS
                            TANAH</span>
                        <span id="asset-land"
                            class="font-geist font-bold text-xs md:text-base text-on-surface">{{ $assetsForMap[0]['land_area'] ?? '' }}</span>
                    </div>
                    <div
                        class="bg-surface-container-low rounded-xl md:rounded-2xl p-2.5 md:p-3 flex flex-col gap-0.5 md:gap-1">
                        <span class="material-symbols-outlined text-outline text-base md:text-lg">warehouse</span>
                        <span
                            class="text-[9px] md:text-[11px] font-semibold tracking-wider text-on-surface-variant">BANGUNAN</span>
                        <span id="asset-building"
                            class="font-geist font-bold text-xs md:text-base text-on-surface">{{ $assetsForMap[0]['building_area'] ?? '' }}</span>
                    </div>
                    <div
                        class="bg-surface-container-low rounded-xl md:rounded-2xl p-2.5 md:p-3 flex flex-col gap-0.5 md:gap-1">
                        <span class="material-symbols-outlined text-outline text-base md:text-lg">local_shipping</span>
                        <span
                            class="text-[9px] md:text-[11px] font-semibold tracking-wider text-on-surface-variant">AKSES</span>
                        <span id="asset-access"
                            class="text-[10px] md:text-xs font-semibold text-on-surface mt-0.5 md:mt-1 truncate">{{ $assetsForMap[0]['road_access'] ?? '' }}</span>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-[340px] lg:w-[380px] flex flex-col gap-3 md:gap-4">
                <div class="relative w-full h-32 md:h-40 rounded-xl md:rounded-2xl overflow-hidden shadow-inner">
                    <img id="asset-image" alt="Asset Preview"
                        class="w-full h-full object-cover transition-opacity duration-300"
                        src="{{ $assetsForMap[0]['image'] ?? '' }}" />
                    <div id="asset-status"
                        class="absolute top-2 left-2 md:top-3 md:left-3 bg-primary text-on-primary text-[10px] md:text-[11px] font-bold px-2.5 py-0.5 md:px-3 md:py-1 rounded-full shadow-md">
                        {{ $assetsForMap[0]['status'] ?? '' }}
                    </div>
                </div>
                <div class="flex justify-between items-end px-1 md:px-2">
                    <div class="flex flex-col">
                        <span
                            class="text-[9px] md:text-[11px] font-semibold tracking-wider text-on-surface-variant uppercase">PENAWARAN</span>
                        <span id="asset-price"
                            class="font-geist font-bold text-lg md:text-2xl text-primary mt-0.5">{{ $assetsForMap[0]['price'] ?? '' }}</span>
                    </div>
                    <a id="asset-detail-link"
                        href="{{ isset($assetsForMap[0]) ? route('assets.show', $assetsForMap[0]['id']) : '#' }}"
                        class="bg-primary hover:bg-primary-container text-on-primary rounded-full px-4 py-2 md:px-5 md:py-3 flex items-center gap-1.5 md:gap-2 transition-all shadow-lg hover:shadow-xl font-medium text-xs md:text-sm">
                        <span>Detail Aset</span>
                        <span class="material-symbols-outlined text-xs md:text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const rawAssets = @json($assetsForMap);
        const map = L.map('map', {
            zoomControl: false,
            attributionControl: true
        }).setView([-6.9932, 110.4203], 13);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://carto.com/">CARTO</a> | PT Kereta Api Indonesia'
        }).addTo(map);

        let markerMap = {};

        function renderMarkers(list) {
            Object.values(markerMap).forEach(m => map.removeLayer(m));
            markerMap = {};

            list.forEach(asset => {
                const customIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div class="custom-pin" id="pin-${asset.id}"><span class="material-symbols-outlined text-[18px]">home_pin</span></div>`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 16]
                });

                const marker = L.marker([asset.lat, asset.lng], { icon: customIcon }).addTo(map);
                markerMap[asset.id] = marker;

                marker.on('click', () => selectAsset(asset));
            });
        }

        function selectAsset(asset) {
            map.flyTo([asset.lat, asset.lng], 15, { duration: 1.2 });

            document.querySelectorAll('.custom-pin').forEach(p => p.classList.remove('active'));
            const pin = document.getElementById('pin-' + asset.id);
            if (pin) pin.classList.add('active');

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
        }

        renderMarkers(rawAssets);

        const activeFilters = { tipe: '', status: '', harga: '', search: '' };

        function toggleDropdown(id) {
            const panel = document.getElementById(id);
            const isOpen = panel.classList.contains('open');
            closeAllDropdowns();

            if (!isOpen) {
                panel.classList.add('open');
            }
        }

        function closeAllDropdowns() {
            document.querySelectorAll('.dropdown-panel').forEach(p => p.classList.remove('open'));
        }

        function selectFilter(key, value, label, btn) {
            activeFilters[key] = value.toLowerCase();
            document.getElementById('label-' + key).textContent = label;

            const filterBtn = document.getElementById('btn-' + key);
            if (value) {
                filterBtn.classList.add('active');
            } else {
                filterBtn.classList.remove('active');
            }

            const panelId = 'dd-' + key;
            document.querySelectorAll(`#${panelId} .dd-item`).forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            document.getElementById(panelId).classList.remove('open');

            updateResetButton();
            applyFilters();
        }

        function resetFilters() {
            activeFilters.tipe = activeFilters.status = activeFilters.harga = activeFilters.search = '';
            document.getElementById('map-search').value = '';

            ['tipe', 'status', 'harga'].forEach(key => {
                const labels = { tipe: 'Tipe', status: 'Status', harga: 'Harga' };
                document.getElementById('label-' + key).textContent = labels[key];
                document.getElementById('btn-' + key).classList.remove('active');

                const items = document.querySelectorAll(`#dd-${key} .dd-item`);
                items.forEach(b => b.classList.remove('selected'));
                if (items[0]) items[0].classList.add('selected');
            });

            updateResetButton();
            applyFilters();
        }

        function updateResetButton() {
            const hasFilter = activeFilters.tipe !== '' || activeFilters.status !== '' || activeFilters.harga !== '' || activeFilters.search !== '';
            const resetBtn = document.getElementById('btn-reset');
            if (hasFilter) {
                resetBtn.classList.remove('hidden');
                resetBtn.classList.add('flex');
            } else {
                resetBtn.classList.add('hidden');
                resetBtn.classList.remove('flex');
            }
        }

        function applyFilters() {
            activeFilters.search = document.getElementById('map-search').value.toLowerCase().trim();
            updateResetButton();

            const filtered = rawAssets.filter(asset => {
                const titleMatch = !activeFilters.search ||
                    asset.title.toLowerCase().includes(activeFilters.search) ||
                    asset.address.toLowerCase().includes(activeFilters.search);

                const tipeMatch = !activeFilters.tipe ||
                    asset.title.toLowerCase().includes(activeFilters.tipe);

                const statusMatch = !activeFilters.status ||
                    asset.status.toLowerCase() === activeFilters.status;

                let hargaMatch = true;
                if (activeFilters.harga === 'under-5m') {
                    hargaMatch = asset.price.includes('1.') || asset.price.includes('2.') || asset.price.includes('3.') || asset.price.includes('4.');
                } else if (activeFilters.harga === 'above-5m') {
                    hargaMatch = !asset.price.includes('1.') && !asset.price.includes('2.') && !asset.price.includes('3.') && !asset.price.includes('4.');
                }

                return titleMatch && tipeMatch && statusMatch && hargaMatch;
            });

            renderMarkers(filtered);
            document.getElementById('kpi-count').innerText = filtered.length;

            if (filtered.length > 0) {
                selectAsset(filtered[0]);
                document.getElementById('bottom-card').style.opacity = '1';
                document.getElementById('bottom-card').style.pointerEvents = 'auto';
            } else {
                document.getElementById('bottom-card').style.opacity = '0.4';
                document.getElementById('bottom-card').style.pointerEvents = 'none';
            }
        }

        document.addEventListener('click', e => {
            if (!e.target.closest('#dd-tipe-wrap, #dd-status-wrap, #dd-harga-wrap')) {
                closeAllDropdowns();
            }
        });
    </script>
</body>

</html>