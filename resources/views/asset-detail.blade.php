<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Asset Detail - {{ $asset['title'] }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Geist:wght@400;600;700&family=Inter:wght@400;500&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-tint": "#006c4a",
                        "glass-surface": "rgba(255, 255, 255, 0.75)",
                        "surface-container": "#e9efe9",
                        "on-primary-fixed": "#002114",
                        "surface-variant": "#dee4de",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-fixed": "#410004",
                        "tertiary-fixed-dim": "#ffb3ae",
                        "bg-gradient-start": "#E0F2FE",
                        "secondary-container": "#fea619",
                        "background": "#f5fbf5",
                        "on-primary-container": "#f5fff7",
                        "primary-fixed": "#85f8c4",
                        "on-secondary-container": "#684000",
                        "on-secondary-fixed-variant": "#653e00",
                        "on-secondary-fixed": "#2a1700",
                        "inverse-on-surface": "#ecf2ec",
                        "on-primary-fixed-variant": "#005137",
                        "error": "#ba1a1a",
                        "map-dark-pill": "rgba(0, 0, 0, 0.8)",
                        "on-background": "#171d19",
                        "secondary-fixed": "#ffddb8",
                        "outline": "#6d7a72",
                        "surface-container-low": "#eff5ef",
                        "tertiary": "#9b3e3b",
                        "secondary-fixed-dim": "#ffb95f",
                        "secondary": "#855300",
                        "inverse-primary": "#68dba9",
                        "on-primary": "#ffffff",
                        "surface": "#f5fbf5",
                        "on-error": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-tertiary-container": "#fffbff",
                        "error-container": "#ffdad6",
                        "primary-fixed-dim": "#68dba9",
                        "tertiary-container": "#ba5551",
                        "on-surface-variant": "#3d4a42",
                        "surface-dim": "#d5dcd6",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#171d19",
                        "primary": "#006948",
                        "outline-variant": "#bccac0",
                        "surface-bright": "#f5fbf5",
                        "surface-container-highest": "#dee4de",
                        "on-tertiary-fixed-variant": "#7f2928",
                        "inverse-surface": "#2c322e",
                        "bg-gradient-end": "#DCFCE7",
                        "tertiary-fixed": "#ffdad7",
                        "surface-container-high": "#e4eae4",
                        "glass-border": "rgba(255, 255, 255, 0.5)",
                        "on-secondary": "#ffffff",
                        "primary-container": "#00855d"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "label-caps": ["Geist", "sans-serif"],
                        "headline-lg": ["Geist", "sans-serif"],
                        "headline-md": ["Geist", "sans-serif"],
                        "data-tabular": ["Geist", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"],
                        "display-lg": ["Geist", "sans-serif"],
                        "body-lg": ["Inter", "sans-serif"]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24
        }
        .bg-map-layer {
            background-image: url(https://lh3.googleusercontent.com/aida-public/AB6AXuB6ZneUgGDjqGatQIT32vaSn1IsPfI_wkWher32duQB7V3O7gJRdcqUBqPlBypCWuBI1cGCHTb9k4XSY2m5cUirfXs1I4XLsgrzD932JFRD6LcExEGzfIOvJezMZWRuatPhuwHnQd9Mmop1HLb9vD-zT7o5gAlnMg8pjQEcQvXCEP5hTHeUejJiJYwMyF7ltT_kfHlSD8jMYnAK4mU-UtO8iXULvLdT-8E2YZz7Zug0Gh245em4eOjU);
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-surface text-on-surface font-body-lg min-h-screen relative overflow-x-hidden selection:bg-primary-container selection:text-on-primary-container">
    <div class="fixed inset-0 z-0 bg-map-layer opacity-40 mix-blend-multiply"></div>
    <div class="fixed inset-0 z-0 bg-gradient-to-br from-bg-gradient-start/80 to-bg-gradient-end/80 pointer-events-none"></div>

    <aside class="fixed left-4 top-1/2 -translate-y-1/2 w-16 hidden md:flex flex-col items-center py-5 rounded-full
                  h-[88vh] max-h-[760px] bg-white/95 backdrop-blur-2xl border border-white/60 shadow-[0_8px_30px_rgba(0,0,0,0.07)] z-50">

        <!-- Home -->
        <a href="{{ route('assets.index') }}"
           title="Beranda"
           class="mb-3 p-2.5 rounded-full text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee] transition flex items-center justify-center">
            <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24">home</span>
        </a>

        <div class="w-8 h-px bg-[#e8eee9] mb-3"></div>

        <!-- Nav Items -->
        <div class="flex flex-col gap-2 items-center flex-1 w-full px-2">
            <a href="{{ route('assets.manage') }}"
               title="Kelola Aset"
               class="text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee] rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">inventory_2</span>
            </a>
            <a href="#"
               title="Kalender"
               class="text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee] rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24">calendar_today</span>
            </a>
            <a href="#"
               title="Laporan"
               class="text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee] rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24">description</span>
            </a>
            <a href="#"
               title="Statistik"
               class="text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee] rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24">bar_chart</span>
            </a>
        </div>

        <div class="w-8 h-px bg-[#e8eee9] mt-3 mb-3"></div>

        <!-- Bottom Nav -->
        <div class="flex flex-col gap-2 items-center">
            <a href="#"
               title="Bantuan"
               class="text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee] rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24">help</span>
            </a>
            <a href="#"
               title="Profil"
               class="text-[#637369] hover:text-[#006948] hover:bg-[#e6f4ee] rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24">account_circle</span>
            </a>
        </div>
    </aside>

    <main class="relative z-10 md:ml-28 lg:ml-32 min-h-screen p-4 sm:p-6 md:p-8 max-w-7xl mx-auto flex flex-col gap-4 md:gap-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('assets.index') }}"
                class="bg-glass-surface backdrop-blur-xl border border-glass-border p-2 md:p-2.5 rounded-full hover:bg-surface-variant/50 transition-colors shadow-sm flex items-center justify-center">
                <span class="material-symbols-outlined text-on-surface-variant text-base md:text-xl">arrow_back</span>
            </a>
            <div class="flex flex-wrap items-center gap-1.5 md:gap-2 text-xs md:text-sm font-medium text-on-surface-variant">
                <a href="{{ route('assets.index') }}" class="hover:underline">Assets</a>
                <span class="material-symbols-outlined text-[14px] md:text-[16px]">chevron_right</span>
                <span>Properti KAI</span>
                <span class="material-symbols-outlined text-[14px] md:text-[16px]">chevron_right</span>
                <span class="text-on-surface font-semibold truncate max-w-[200px] sm:max-w-none">{{ $asset['title'] }}</span>
            </div>
        </div>

        <div class="bg-glass-surface backdrop-blur-xl border border-glass-border shadow-[0_8px_32px_rgba(0,0,0,0.05)] rounded-2xl md:rounded-3xl p-4 sm:p-6 md:p-8 flex flex-col lg:flex-row gap-6 md:gap-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-white/40 to-transparent"></div>
            <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-white/40 to-transparent"></div>

            <div class="flex-1 flex flex-col gap-4 md:gap-6">
                <div class="flex flex-col gap-3">
                    <div class="relative w-full h-56 sm:h-72 md:h-96 rounded-xl md:rounded-2xl overflow-hidden border border-glass-border shadow-inner group">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            src="{{ $asset['image'] }}" alt="{{ $asset['title'] }}" />
                        <div class="absolute top-3 left-3 md:top-4 md:left-4">
                            <span class="bg-primary/90 text-on-primary text-xs font-semibold px-3 py-1.5 rounded-full backdrop-blur-md shadow-md flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-primary-fixed animate-pulse"></span>
                                {{ $asset['status'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-start pt-3 md:pt-4 border-t border-glass-border">
                    <div>
                        <h1 class="font-geist font-bold text-xl sm:text-2xl md:text-3xl text-on-surface mb-1 md:mb-2">{{ $asset['title'] }}</h1>
                        <p class="text-xs sm:text-sm font-medium text-on-surface-variant flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] md:text-[18px]">location_on</span>
                            {{ $asset['address'] }}
                        </p>
                    </div>
                    <button class="bg-surface-container hover:bg-error-container text-on-surface-variant hover:text-error rounded-full p-2.5 md:p-3 transition-colors duration-200">
                        <span class="material-symbols-outlined text-lg md:text-xl">favorite</span>
                    </button>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 md:gap-4 mt-1 md:mt-2">
                    <div class="bg-surface/60 rounded-xl p-3 md:p-4 border border-glass-border">
                        <div class="text-on-surface-variant mb-1 flex items-center gap-1.5 md:gap-2">
                            <span class="material-symbols-outlined text-[18px] md:text-[20px]">architecture</span>
                            <span class="text-[10px] md:text-xs font-semibold tracking-wider">LUAS TANAH</span>
                        </div>
                        <div class="font-geist font-bold text-sm md:text-lg text-on-surface">{{ $asset['land_area'] }}</div>
                    </div>
                    <div class="bg-surface/60 rounded-xl p-3 md:p-4 border border-glass-border">
                        <div class="text-on-surface-variant mb-1 flex items-center gap-1.5 md:gap-2">
                            <span class="material-symbols-outlined text-[18px] md:text-[20px]">foundation</span>
                            <span class="text-[10px] md:text-xs font-semibold tracking-wider">LUAS BANGUNAN</span>
                        </div>
                        <div class="font-geist font-bold text-sm md:text-lg text-on-surface">{{ $asset['building_area'] }}</div>
                    </div>
                    <div class="bg-surface/60 rounded-xl p-3 md:p-4 border border-glass-border">
                        <div class="text-on-surface-variant mb-1 flex items-center gap-1.5 md:gap-2">
                            <span class="material-symbols-outlined text-[18px] md:text-[20px]">local_shipping</span>
                            <span class="text-[10px] md:text-xs font-semibold tracking-wider">AKSES JALAN</span>
                        </div>
                        <div class="font-geist font-bold text-sm md:text-lg text-on-surface truncate">{{ $asset['road_access'] }}</div>
                    </div>
                    <div class="bg-surface/60 rounded-xl p-3 md:p-4 border border-glass-border">
                        <div class="text-on-surface-variant mb-1 flex items-center gap-1.5 md:gap-2">
                            <span class="material-symbols-outlined text-[18px] md:text-[20px]">bolt</span>
                            <span class="text-[10px] md:text-xs font-semibold tracking-wider">LISTRIK</span>
                        </div>
                        <div class="font-geist font-bold text-sm md:text-lg text-on-surface">{{ $asset['electricity'] ?? '105,000 VA' }}</div>
                    </div>
                    <div class="bg-surface/60 rounded-xl p-3 md:p-4 border border-glass-border">
                        <div class="text-on-surface-variant mb-1 flex items-center gap-1.5 md:gap-2">
                            <span class="material-symbols-outlined text-[18px] md:text-[20px]">water_drop</span>
                            <span class="text-[10px] md:text-xs font-semibold tracking-wider">AIR</span>
                        </div>
                        <div class="font-geist font-bold text-sm md:text-lg text-on-surface">{{ $asset['water'] ?? 'PDAM / Sumur' }}</div>
                    </div>
                    <div class="bg-surface/60 rounded-xl p-3 md:p-4 border border-glass-border">
                        <div class="text-on-surface-variant mb-1 flex items-center gap-1.5 md:gap-2">
                            <span class="material-symbols-outlined text-[18px] md:text-[20px]">security</span>
                            <span class="text-[10px] md:text-xs font-semibold tracking-wider">KEAMANAN</span>
                        </div>
                        <div class="font-geist font-bold text-sm md:text-lg text-on-surface text-primary">{{ $asset['security'] ?? '24 Jam' }}</div>
                    </div>
                </div>

                <div class="mt-2 md:mt-4">
                    <h3 class="font-geist font-semibold text-base md:text-xl text-on-surface mb-2">Deskripsi Aset</h3>
                    <p class="text-xs sm:text-sm md:text-base text-on-surface-variant leading-relaxed">
                        {{ $asset['description'] ?? 'Aset strategis milik PT Kereta Api Indonesia (Persero) Daop 4 Semarang. Berlokasi di titik prima dengan aksesibilitas tinggi menuju jalur logistik, stasiun, dan pusat bisnis kota. Sangat potensial untuk pengembangan komersial, pergudangan, maupun hunian.' }}
                    </p>
                </div>
            </div>

            <div class="w-full lg:w-80 flex flex-col gap-4 md:gap-6">
                <div class="bg-primary-container text-on-primary-container rounded-2xl p-5 md:p-6 shadow-[0_0_30px_rgba(0,133,93,0.2)] flex flex-col gap-3 md:gap-4 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div>
                        <span class="text-[10px] md:text-xs font-semibold tracking-wider text-primary-fixed opacity-90 block mb-1">HARGA PENAWARAN</span>
                        <div class="font-geist font-bold text-2xl sm:text-3xl md:text-4xl tracking-tight">{{ $asset['price'] }}</div>
                        <div class="text-xs md:text-sm opacity-80 mt-1">Negotiable • Direct Owner (PT KAI)</div>
                    </div>
                    <button class="w-full bg-on-primary-container text-primary-container font-semibold py-3 md:py-3.5 rounded-full mt-1 hover:bg-white transition-colors duration-300 flex items-center justify-center gap-2 group shadow-lg text-sm md:text-base">
                        Ajukan Penawaran
                        <span class="material-symbols-outlined text-sm md:text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>
                    <button class="w-full bg-transparent border border-primary-fixed/30 text-primary-fixed text-xs md:text-sm font-medium py-2.5 md:py-3 rounded-full hover:bg-primary-fixed/10 transition-colors duration-300 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[16px] md:text-[18px]">download</span>
                        Download Brosur
                    </button>
                </div>

                <div class="bg-surface/60 rounded-xl p-4 border border-glass-border flex flex-col gap-2.5 md:gap-3">
                    <div class="flex items-center justify-between">
                        <h4 class="font-geist font-semibold text-sm md:text-base text-on-surface">Koordinat Lokasi</h4>
                        <a href="https://maps.google.com/?q={{ $asset['lat'] }},{{ $asset['lng'] }}" target="_blank"
                            class="text-primary text-xs md:text-sm font-medium hover:underline">Google Maps</a>
                    </div>
                    <div class="font-geist text-xs md:text-sm text-on-surface-variant opacity-80">
                        Lat: {{ $asset['lat'] }} • Lng: {{ $asset['lng'] }}
                    </div>
                </div>

                <div class="bg-glass-surface rounded-xl p-4 border border-glass-border mt-auto">
                    <div class="flex items-center gap-3 mb-3 md:mb-4">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-primary text-white flex items-center justify-center border border-white">
                            <span class="material-symbols-outlined text-lg md:text-xl">person</span>
                        </div>
                        <div>
                            <div class="font-geist font-semibold text-sm md:text-base text-on-surface">Unit Komersialisasi Aset</div>
                            <div class="text-xs md:text-sm text-on-surface-variant">KAI Daop 4 Semarang</div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="https://wa.me/6281234567890" target="_blank"
                            class="flex-1 bg-surface-container hover:bg-surface-variant text-on-surface font-medium text-xs md:text-sm py-2 md:py-2.5 rounded-full transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[16px] md:text-[18px]">call</span>
                            Hubungi Unit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
