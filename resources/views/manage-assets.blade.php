<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Kelola Aset Bangunan - KAI</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary":         "#006948",
                        "primary-dark":    "#005137",
                        "primary-light":   "#e6f4ee",
                        "primary-mid":     "#b3d9c9",
                        "background":      "#f4f8f5",
                        "surface":         "#ffffff",
                        "on-surface":      "#1a201c",
                        "on-surface-variant": "#637369",
                        "border-subtle":   "#e8eee9",
                        "danger":          "#dc2626",
                        "danger-light":    "#fee2e2",
                        "warning":         "#d97706",
                        "warning-light":   "#fef3c7",
                    },
                    fontFamily: {
                        "jakarta": ["Plus Jakarta Sans", "sans-serif"],
                        "inter":   ["Inter", "sans-serif"]
                    },
                    boxShadow: {
                        "card":   "0 2px 12px 0 rgba(0,105,72,0.06)",
                        "dock":   "0 8px 30px rgba(0,0,0,0.07)",
                        "modal":  "0 20px 60px rgba(0,0,0,0.15)",
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
            line-height: 1;
        }
        .ms-filled {
            font-variation-settings: "FILL" 1, "wght" 400, "GRAD" 0, "opsz" 24;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f4f8f5; }
        ::-webkit-scrollbar-thumb { background: #b3d9c9; border-radius: 99px; }
        /* Tab indicator animation */
        .tab-active {
            position: relative;
        }
        .tab-active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0; right: 0;
            height: 2px;
            background: #006948;
            border-radius: 2px 2px 0 0;
        }
        /* Tooltip */
        [data-tooltip] { position: relative; }
        [data-tooltip]:hover::before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: calc(100% + 6px);
            left: 50%; transform: translateX(-50%);
            background: #1a201c;
            color: #fff;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 6px;
            white-space: nowrap;
            pointer-events: none;
            z-index: 50;
        }
        /* Row hover */
        tbody tr { transition: background 0.12s; }
        /* Modal backdrop */
        #modal-hapus { transition: opacity 0.2s; }
    </style>
</head>

<body class="bg-background text-on-surface min-h-screen overflow-x-hidden antialiased">

    <!-- ===== LEFT FLOATING DOCK SIDEBAR ===== -->
    <aside class="fixed left-4 top-1/2 -translate-y-1/2 w-16 hidden sm:flex flex-col items-center py-5 rounded-full
                  h-[88vh] max-h-[760px] bg-white/95 backdrop-blur-2xl border border-white/60 shadow-dock z-30">

        <!-- Logo / Home -->
        <a href="{{ route('assets.index') }}"
           data-tooltip="Beranda"
           class="mb-3 p-2.5 rounded-full text-on-surface-variant hover:text-primary hover:bg-primary-light transition flex items-center justify-center">
            <span class="material-symbols-outlined text-[22px]">home</span>
        </a>

        <div class="w-8 h-px bg-border-subtle mb-3"></div>

        <!-- Nav Items -->
        <div class="flex flex-col gap-2 items-center flex-1 w-full px-2">
            <a href="{{ route('assets.manage') }}"
               data-tooltip="Kelola Aset"
               class="bg-primary text-white rounded-full p-3 shadow-md flex items-center justify-center">
                <span class="material-symbols-outlined ms-filled text-[22px]">inventory_2</span>
            </a>
            <a href="#"
               data-tooltip="Kalender"
               class="text-on-surface-variant hover:text-primary hover:bg-primary-light rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">calendar_today</span>
            </a>
            <a href="#"
               data-tooltip="Laporan"
               class="text-on-surface-variant hover:text-primary hover:bg-primary-light rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">description</span>
            </a>
            <a href="#"
               data-tooltip="Statistik"
               class="text-on-surface-variant hover:text-primary hover:bg-primary-light rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">bar_chart</span>
            </a>
        </div>

        <div class="w-8 h-px bg-border-subtle mt-3 mb-3"></div>

        <!-- Bottom Nav -->
        <div class="flex flex-col gap-2 items-center">
            <a href="{{ route('faq') }}"
               data-tooltip="Bantuan"
               class="text-on-surface-variant hover:text-primary hover:bg-primary-light rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">help</span>
            </a>
            <a href="#"
               data-tooltip="Profil"
               class="text-on-surface-variant hover:text-primary hover:bg-primary-light rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">account_circle</span>
            </a>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="pl-4 pr-4 sm:pl-28 sm:pr-6 md:pl-32 md:pr-8 pt-6 pb-10 min-h-screen">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-1.5 text-xs text-on-surface-variant mb-6" aria-label="breadcrumb">
            <a href="{{ route('assets.index') }}" class="hover:text-primary transition flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                Beranda
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface font-semibold">Kelola Aset</span>
        </nav>

        <!-- ===== PAGE HEADER ===== -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-on-surface tracking-tight leading-tight">
                    Kelola Aset Bangunan
                </h1>
                <p class="text-sm text-on-surface-variant mt-1.5">
                    Kelola titik koordinat, harga penawaran, dan status seluruh aset properti KAI
                </p>
            </div>
            <div class="flex gap-2 self-start sm:self-auto shrink-0">
                <button
                    class="bg-white border border-border-subtle text-on-surface-variant hover:text-primary hover:border-primary
                           font-medium text-sm px-4 py-2.5 rounded-full flex items-center gap-2 shadow-sm transition"
                    title="Export data">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    <span class="hidden sm:inline">Export</span>
                </button>
                <button
                    onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
                    class="bg-primary hover:bg-primary-dark text-white font-semibold text-sm px-5 py-2.5 rounded-full
                           flex items-center gap-2 shadow-sm transition">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>Tambah Aset</span>
                </button>
            </div>
        </div>

        <!-- ===== SUMMARY CARDS ===== -->
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-8">

            <!-- Total Aset -->
            <div class="bg-white rounded-2xl p-5 shadow-card border border-border-subtle flex items-start gap-4">
                <div class="bg-primary-light rounded-xl p-2.5 shrink-0">
                    <span class="material-symbols-outlined ms-filled text-primary text-[22px]">domain</span>
                </div>
                <div>
                    <p class="text-xs font-medium text-on-surface-variant">Total Aset</p>
                    <p class="text-2xl font-bold text-on-surface mt-0.5">124</p>
                    <p class="text-[11px] text-on-surface-variant/70 mt-1">Seluruh bangunan</p>
                </div>
            </div>

            <!-- Tersedia -->
            <div class="bg-white rounded-2xl p-5 shadow-card border border-border-subtle flex items-start gap-4">
                <div class="bg-primary-light rounded-xl p-2.5 shrink-0">
                    <span class="material-symbols-outlined ms-filled text-primary text-[22px]">check_circle</span>
                </div>
                <div>
                    <p class="text-xs font-medium text-on-surface-variant">Tersedia</p>
                    <p class="text-2xl font-bold text-primary mt-0.5">85</p>
                    <p class="text-[11px] text-primary/70 mt-1">
                        <span class="material-symbols-outlined text-[12px] align-text-top">trending_up</span>
                        68.5% dari total
                    </p>
                </div>
            </div>

            <!-- Terjual -->
            <div class="bg-white rounded-2xl p-5 shadow-card border border-border-subtle flex items-start gap-4">
                <div class="bg-gray-100 rounded-xl p-2.5 shrink-0">
                    <span class="material-symbols-outlined ms-filled text-gray-500 text-[22px]">sell</span>
                </div>
                <div>
                    <p class="text-xs font-medium text-on-surface-variant">Terjual</p>
                    <p class="text-2xl font-bold text-on-surface mt-0.5">39</p>
                    <p class="text-[11px] text-on-surface-variant/70 mt-1">31.5% dari total</p>
                </div>
            </div>

            <!-- Nilai Total -->
            <div class="bg-gradient-to-br from-primary to-primary-dark rounded-2xl p-5 shadow-card flex items-start gap-4 col-span-2 xl:col-span-1">
                <div class="bg-white/20 rounded-xl p-2.5 shrink-0">
                    <span class="material-symbols-outlined ms-filled text-white text-[22px]">payments</span>
                </div>
                <div>
                    <p class="text-xs font-medium text-white/80">Estimasi Nilai</p>
                    <p class="text-2xl font-bold text-white mt-0.5">Rp 1,2 T</p>
                    <p class="text-[11px] text-white/60 mt-1">Total penawaran aktif</p>
                </div>
            </div>

        </div>

        <!-- ===== TABLE CARD ===== -->
        <div class="bg-white rounded-3xl shadow-card border border-border-subtle overflow-hidden">

            <!-- Card Header: Search + Filter -->
            <div class="px-6 pt-6 pb-0">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                    <h2 class="text-base font-bold text-on-surface">Daftar Aset</h2>

                    <div class="flex items-center gap-2 flex-wrap">
                        <!-- Search -->
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant/60 text-[18px]">search</span>
                            <input
                                type="text"
                                id="search-input"
                                placeholder="Cari bangunan..."
                                class="bg-background border border-border-subtle rounded-full pl-9 pr-4 py-2
                                       text-xs text-on-surface placeholder:text-on-surface-variant/60
                                       focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary w-48 sm:w-60 transition" />
                        </div>

                        <!-- Filter Dropdown -->
                        <div class="relative">
                            <select
                                id="filter-status"
                                class="appearance-none bg-background border border-border-subtle rounded-full pl-4 pr-8 py-2
                                       text-xs text-on-surface focus:outline-none focus:ring-1 focus:ring-primary
                                       focus:border-primary cursor-pointer">
                                <option value="">Semua Status</option>
                                <option value="tersedia">Tersedia</option>
                                <option value="terjual">Terjual</option>
                                <option value="dalam-proses">Dalam Proses</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-on-surface-variant/60 text-[16px] pointer-events-none">expand_more</span>
                        </div>

                        <!-- Sort -->
                        <button
                            class="bg-background border border-border-subtle rounded-full px-4 py-2 text-xs text-on-surface-variant
                                   hover:text-primary hover:border-primary flex items-center gap-1.5 transition">
                            <span class="material-symbols-outlined text-[16px]">sort</span>
                            Urutkan
                        </button>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="flex border-b border-border-subtle gap-1 -mx-0">
                    <button onclick="switchTab(this, 'semua')"
                        class="tab-btn tab-active text-primary text-xs font-semibold px-4 py-2.5 border-b-2 border-primary transition">
                        Semua <span class="ml-1 bg-primary-light text-primary text-[10px] font-bold px-1.5 py-0.5 rounded-full">124</span>
                    </button>
                    <button onclick="switchTab(this, 'tersedia')"
                        class="tab-btn text-on-surface-variant text-xs font-medium px-4 py-2.5 border-b-2 border-transparent hover:text-primary transition">
                        Tersedia <span class="ml-1 bg-gray-100 text-gray-500 text-[10px] font-bold px-1.5 py-0.5 rounded-full">85</span>
                    </button>
                    <button onclick="switchTab(this, 'terjual')"
                        class="tab-btn text-on-surface-variant text-xs font-medium px-4 py-2.5 border-b-2 border-transparent hover:text-primary transition">
                        Terjual <span class="ml-1 bg-gray-100 text-gray-500 text-[10px] font-bold px-1.5 py-0.5 rounded-full">39</span>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto min-w-0">
                <table class="w-full min-w-[700px] text-left" id="asset-table">
                    <thead>
                        <tr class="text-[11px] font-semibold text-on-surface-variant/70 uppercase tracking-wide bg-background/60 border-b border-border-subtle">
                            <th class="py-3.5 pl-6 pr-3 w-10">
                                <input type="checkbox" id="select-all"
                                    class="rounded border-border-subtle text-primary focus:ring-primary cursor-pointer" />
                            </th>
                            <th class="py-3.5 pr-3 w-14">Foto</th>
                            <th class="py-3.5 pr-4">
                                <button class="flex items-center gap-1 hover:text-primary transition">
                                    Nama Bangunan
                                    <span class="material-symbols-outlined text-[14px]">unfold_more</span>
                                </button>
                            </th>
                            <th class="py-3.5 pr-4">Koordinat</th>
                            <th class="py-3.5 pr-4">
                                <button class="flex items-center gap-1 hover:text-primary transition">
                                    Luas (m²)
                                    <span class="material-symbols-outlined text-[14px]">unfold_more</span>
                                </button>
                            </th>
                            <th class="py-3.5 pr-4">
                                <button class="flex items-center gap-1 hover:text-primary transition">
                                    Harga Penawaran
                                    <span class="material-symbols-outlined text-[14px]">unfold_more</span>
                                </button>
                            </th>
                            <th class="py-3.5 pr-4">Status</th>
                            <th class="py-3.5 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle text-sm" id="table-body">

                        <!-- Row 1 -->
                        <tr class="hover:bg-primary-light/20 transition asset-row" data-status="tersedia">
                            <td class="py-4 pl-6 pr-3">
                                <input type="checkbox"
                                    class="row-check rounded border-border-subtle text-primary focus:ring-primary cursor-pointer" />
                            </td>
                            <td class="py-4 pr-3">
                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=160&q=80"
                                        alt="Gedung Sudirman A"
                                        class="w-11 h-11 rounded-xl object-cover border border-border-subtle shadow-sm" />
                                </div>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-on-surface text-sm">Gedung Sudirman A</p>
                                <p class="text-xs text-on-surface-variant mt-0.5">Jakarta Pusat · ID-001</p>
                            </td>
                            <td class="py-4 pr-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[14px] text-on-surface-variant/60">location_on</span>
                                    <span class="text-xs text-on-surface-variant font-mono">-6.2088, 106.8229</span>
                                </div>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="font-semibold text-on-surface">4.500</span>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="font-bold text-primary">Rp 45 M</span>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="inline-flex items-center gap-1 bg-primary-light text-primary text-xs font-semibold px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary inline-block"></span>
                                    Tersedia
                                </span>
                            </td>
                            <td class="py-4 pr-6">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('assets.show', 1) }}"
                                       data-tooltip="Lihat Detail"
                                       class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-primary-light transition">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>
                                    <button
                                        data-tooltip="Edit Aset"
                                        onclick="openEditModal('Gedung Sudirman A')"
                                        class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-primary-light transition">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </button>
                                    <a href="{{ route('assets.index') }}"
                                       data-tooltip="Lihat di Peta"
                                       class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-primary-light transition">
                                        <span class="material-symbols-outlined text-[18px]">map</span>
                                    </a>
                                    <button
                                        data-tooltip="Hapus"
                                        onclick="openHapusModal('Gedung Sudirman A')"
                                        class="p-1.5 rounded-lg text-on-surface-variant hover:text-danger hover:bg-danger-light transition">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="hover:bg-primary-light/20 transition asset-row" data-status="tersedia">
                            <td class="py-4 pl-6 pr-3">
                                <input type="checkbox"
                                    class="row-check rounded border-border-subtle text-primary focus:ring-primary cursor-pointer" />
                            </td>
                            <td class="py-4 pr-3">
                                <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=160&q=80"
                                    alt="Ruko Thamrin Plaza"
                                    class="w-11 h-11 rounded-xl object-cover border border-border-subtle shadow-sm" />
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-on-surface text-sm">Ruko Thamrin Plaza</p>
                                <p class="text-xs text-on-surface-variant mt-0.5">Jakarta Pusat · ID-002</p>
                            </td>
                            <td class="py-4 pr-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[14px] text-on-surface-variant/60">location_on</span>
                                    <span class="text-xs text-on-surface-variant font-mono">-6.1944, 106.8230</span>
                                </div>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="font-semibold text-on-surface">850</span>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="font-bold text-primary">Rp 12 M</span>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="inline-flex items-center gap-1 bg-primary-light text-primary text-xs font-semibold px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary inline-block"></span>
                                    Tersedia
                                </span>
                            </td>
                            <td class="py-4 pr-6">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('assets.show', 2) }}"
                                       data-tooltip="Lihat Detail"
                                       class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-primary-light transition">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>
                                    <button
                                        data-tooltip="Edit Aset"
                                        onclick="openEditModal('Ruko Thamrin Plaza')"
                                        class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-primary-light transition">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </button>
                                    <a href="{{ route('assets.index') }}"
                                       data-tooltip="Lihat di Peta"
                                       class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-primary-light transition">
                                        <span class="material-symbols-outlined text-[18px]">map</span>
                                    </a>
                                    <button
                                        data-tooltip="Hapus"
                                        onclick="openHapusModal('Ruko Thamrin Plaza')"
                                        class="p-1.5 rounded-lg text-on-surface-variant hover:text-danger hover:bg-danger-light transition">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="hover:bg-primary-light/20 transition asset-row" data-status="terjual">
                            <td class="py-4 pl-6 pr-3">
                                <input type="checkbox"
                                    class="row-check rounded border-border-subtle text-primary focus:ring-primary cursor-pointer" />
                            </td>
                            <td class="py-4 pr-3">
                                <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=160&q=80"
                                    alt="Gudang Logistik Priok"
                                    class="w-11 h-11 rounded-xl object-cover border border-border-subtle shadow-sm" />
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-on-surface text-sm">Gudang Logistik Priok</p>
                                <p class="text-xs text-on-surface-variant mt-0.5">Jakarta Utara · ID-003</p>
                            </td>
                            <td class="py-4 pr-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[14px] text-on-surface-variant/60">location_on</span>
                                    <span class="text-xs text-on-surface-variant font-mono">-6.1046, 106.8835</span>
                                </div>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="font-semibold text-on-surface">12.000</span>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="font-bold text-on-surface-variant line-through text-xs">Rp 80 M</span>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 text-xs font-semibold px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span>
                                    Terjual
                                </span>
                            </td>
                            <td class="py-4 pr-6">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('assets.show', 3) }}"
                                       data-tooltip="Lihat Detail"
                                       class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-primary-light transition">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>
                                    <button
                                        data-tooltip="Edit Aset"
                                        onclick="openEditModal('Gudang Logistik Priok')"
                                        class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-primary-light transition">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </button>
                                    <a href="{{ route('assets.index') }}"
                                       data-tooltip="Lihat di Peta"
                                       class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-primary-light transition">
                                        <span class="material-symbols-outlined text-[18px]">map</span>
                                    </a>
                                    <button
                                        data-tooltip="Hapus"
                                        onclick="openHapusModal('Gudang Logistik Priok')"
                                        class="p-1.5 rounded-lg text-on-surface-variant hover:text-danger hover:bg-danger-light transition">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr class="hover:bg-primary-light/20 transition asset-row" data-status="dalam-proses">
                            <td class="py-4 pl-6 pr-3">
                                <input type="checkbox"
                                    class="row-check rounded border-border-subtle text-primary focus:ring-primary cursor-pointer" />
                            </td>
                            <td class="py-4 pr-3">
                                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=160&q=80"
                                    alt="Kantor Operasional Bandung"
                                    class="w-11 h-11 rounded-xl object-cover border border-border-subtle shadow-sm" />
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-on-surface text-sm">Kantor Operasional Bandung</p>
                                <p class="text-xs text-on-surface-variant mt-0.5">Bandung · ID-004</p>
                            </td>
                            <td class="py-4 pr-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[14px] text-on-surface-variant/60">location_on</span>
                                    <span class="text-xs text-on-surface-variant font-mono">-6.9175, 107.6191</span>
                                </div>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="font-semibold text-on-surface">2.200</span>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="font-bold text-primary">Rp 28 M</span>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="inline-flex items-center gap-1 bg-warning-light text-warning text-xs font-semibold px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-warning inline-block animate-pulse"></span>
                                    Dalam Proses
                                </span>
                            </td>
                            <td class="py-4 pr-6">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('assets.show', 4) }}"
                                       data-tooltip="Lihat Detail"
                                       class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-primary-light transition">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>
                                    <button
                                        data-tooltip="Edit Aset"
                                        onclick="openEditModal('Kantor Operasional Bandung')"
                                        class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-primary-light transition">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </button>
                                    <a href="{{ route('assets.index') }}"
                                       data-tooltip="Lihat di Peta"
                                       class="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-primary-light transition">
                                        <span class="material-symbols-outlined text-[18px]">map</span>
                                    </a>
                                    <button
                                        data-tooltip="Hapus"
                                        onclick="openHapusModal('Kantor Operasional Bandung')"
                                        class="p-1.5 rounded-lg text-on-surface-variant hover:text-danger hover:bg-danger-light transition">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <!-- Empty State (hidden by default) -->
                <div id="empty-state" class="hidden flex flex-col items-center justify-center py-20 text-center">
                    <div class="bg-background rounded-full p-5 mb-4">
                        <span class="material-symbols-outlined text-[48px] text-on-surface-variant/40">search_off</span>
                    </div>
                    <p class="font-semibold text-on-surface">Tidak ada aset ditemukan</p>
                    <p class="text-sm text-on-surface-variant mt-1">Coba ubah kata kunci atau filter pencarian</p>
                </div>
            </div>

            <!-- Bulk Actions + Pagination -->
            <div class="px-6 py-4 border-t border-border-subtle flex flex-col sm:flex-row sm:items-center justify-between gap-3">

                <!-- Bulk Actions -->
                <div id="bulk-actions" class="hidden items-center gap-2">
                    <span class="text-xs text-on-surface-variant" id="selected-count">0 aset dipilih</span>
                    <button class="text-xs font-medium text-danger border border-danger/30 hover:bg-danger-light px-3 py-1.5 rounded-full transition flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">delete</span>
                        Hapus Dipilih
                    </button>
                </div>
                <div id="no-bulk" class="text-xs text-on-surface-variant">
                    Menampilkan <span class="font-semibold text-on-surface">1–4</span> dari <span class="font-semibold text-on-surface">124</span> aset
                </div>

                <!-- Pagination -->
                <div class="flex items-center gap-1">
                    <button class="p-1.5 rounded-lg text-on-surface-variant hover:bg-background transition disabled:opacity-30" disabled>
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                    </button>
                    <button class="w-8 h-8 rounded-lg bg-primary text-white text-xs font-bold">1</button>
                    <button class="w-8 h-8 rounded-lg hover:bg-background text-on-surface-variant text-xs font-medium transition">2</button>
                    <button class="w-8 h-8 rounded-lg hover:bg-background text-on-surface-variant text-xs font-medium transition">3</button>
                    <span class="text-on-surface-variant text-xs px-1">...</span>
                    <button class="w-8 h-8 rounded-lg hover:bg-background text-on-surface-variant text-xs font-medium transition">31</button>
                    <button class="p-1.5 rounded-lg text-on-surface-variant hover:bg-background transition">
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- end TABLE CARD -->

    </main>
    <!-- end MAIN -->


    <!-- ===== MODAL: TAMBAH ASET ===== -->
    <div id="modal-tambah"
         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
         onclick="if(event.target===this) this.classList.add('hidden')">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
        <div class="relative bg-white rounded-3xl shadow-modal w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-5 border-b border-border-subtle">
                <h3 class="font-bold text-on-surface">Tambah Aset Baru</h3>
                <button onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                    class="p-1.5 rounded-full hover:bg-background text-on-surface-variant transition">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <form class="px-6 py-5 flex flex-col gap-4">
                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Nama Bangunan <span class="text-danger">*</span></label>
                    <input type="text" placeholder="cth. Gedung Utama Bandung"
                        class="w-full border border-border-subtle rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Latitude <span class="text-danger">*</span></label>
                        <input type="number" step="any" placeholder="-6.2088"
                            class="w-full border border-border-subtle rounded-xl px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Longitude <span class="text-danger">*</span></label>
                        <input type="number" step="any" placeholder="106.8229"
                            class="w-full border border-border-subtle rounded-xl px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Luas (m²) <span class="text-danger">*</span></label>
                        <input type="number" placeholder="4500"
                            class="w-full border border-border-subtle rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Harga Penawaran</label>
                        <input type="text" placeholder="cth. 45000000000"
                            class="w-full border border-border-subtle rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary" />
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Status</label>
                    <select class="w-full border border-border-subtle rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                        <option value="tersedia">Tersedia</option>
                        <option value="dalam-proses">Dalam Proses</option>
                        <option value="terjual">Terjual</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Foto Bangunan</label>
                    <div class="border-2 border-dashed border-border-subtle rounded-xl p-6 text-center hover:border-primary transition cursor-pointer">
                        <span class="material-symbols-outlined text-[32px] text-on-surface-variant/40 mb-2">cloud_upload</span>
                        <p class="text-xs text-on-surface-variant">Klik atau seret foto ke sini</p>
                        <p class="text-[11px] text-on-surface-variant/60 mt-1">JPG, PNG, WebP · Maks. 5 MB</p>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button"
                        onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                        class="flex-1 border border-border-subtle text-on-surface-variant rounded-xl py-2.5 text-sm font-medium hover:bg-background transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-primary hover:bg-primary-dark text-white rounded-xl py-2.5 text-sm font-semibold transition shadow-sm">
                        Simpan Aset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MODAL: KONFIRMASI HAPUS ===== -->
    <div id="modal-hapus"
         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
         onclick="if(event.target===this) this.classList.add('hidden')">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
        <div class="relative bg-white rounded-3xl shadow-modal w-full max-w-sm p-6">
            <div class="flex flex-col items-center text-center">
                <div class="bg-danger-light rounded-full p-4 mb-4">
                    <span class="material-symbols-outlined ms-filled text-danger text-[32px]">delete</span>
                </div>
                <h3 class="font-bold text-on-surface text-lg">Hapus Aset?</h3>
                <p class="text-sm text-on-surface-variant mt-2">
                    Anda akan menghapus aset
                    <span class="font-semibold text-on-surface" id="hapus-nama">—</span>.
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex gap-3 mt-6">
                <button
                    onclick="document.getElementById('modal-hapus').classList.add('hidden')"
                    class="flex-1 border border-border-subtle text-on-surface-variant rounded-xl py-2.5 text-sm font-medium hover:bg-background transition">
                    Batal
                </button>
                <button
                    class="flex-1 bg-danger hover:bg-red-700 text-white rounded-xl py-2.5 text-sm font-semibold transition shadow-sm">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>


    <!-- ===== SCRIPTS ===== -->
    <script>
        /* ---- Checkbox: select all ---- */
        const selectAll = document.getElementById('select-all');
        const rowChecks = document.querySelectorAll('.row-check');
        const bulkActions = document.getElementById('bulk-actions');
        const noBulk = document.getElementById('no-bulk');
        const selectedCount = document.getElementById('selected-count');

        function updateBulkBar() {
            const checked = document.querySelectorAll('.row-check:checked').length;
            if (checked > 0) {
                bulkActions.classList.remove('hidden');
                bulkActions.classList.add('flex');
                noBulk.classList.add('hidden');
                selectedCount.textContent = checked + ' aset dipilih';
            } else {
                bulkActions.classList.add('hidden');
                bulkActions.classList.remove('flex');
                noBulk.classList.remove('hidden');
            }
        }

        selectAll.addEventListener('change', () => {
            rowChecks.forEach(c => c.checked = selectAll.checked);
            updateBulkBar();
        });
        rowChecks.forEach(c => c.addEventListener('change', updateBulkBar));

        /* ---- Tab switching ---- */
        function switchTab(btn, status) {
            document.querySelectorAll('.tab-btn').forEach(t => {
                t.classList.remove('text-primary', 'font-semibold', 'border-primary', 'tab-active');
                t.classList.add('text-on-surface-variant', 'font-medium', 'border-transparent');
            });
            btn.classList.add('text-primary', 'font-semibold', 'border-primary', 'tab-active');
            btn.classList.remove('text-on-surface-variant', 'font-medium', 'border-transparent');

            document.querySelectorAll('.asset-row').forEach(row => {
                if (status === 'semua' || row.dataset.status === status) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }

        /* ---- Search ---- */
        document.getElementById('search-input').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            let found = 0;
            document.querySelectorAll('.asset-row').forEach(row => {
                const name = row.querySelector('td:nth-child(3) p').textContent.toLowerCase();
                const match = name.includes(q);
                row.classList.toggle('hidden', !match);
                if (match) found++;
            });
            document.getElementById('empty-state').classList.toggle('hidden', found > 0);
        });

        /* ---- Filter status ---- */
        document.getElementById('filter-status').addEventListener('change', function () {
            const val = this.value;
            document.querySelectorAll('.asset-row').forEach(row => {
                if (!val || row.dataset.status === val) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        });

        /* ---- Modals ---- */
        function openHapusModal(nama) {
            document.getElementById('hapus-nama').textContent = nama;
            document.getElementById('modal-hapus').classList.remove('hidden');
        }

        function openEditModal(nama) {
            // Reuse tambah modal, pre-fill nama
            const modal = document.getElementById('modal-tambah');
            modal.querySelector('h3').textContent = 'Edit Aset';
            modal.querySelector('input[type="text"]').value = nama;
            modal.classList.remove('hidden');
        }

        /* ---- Close modals on Escape ---- */
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                document.getElementById('modal-tambah').classList.add('hidden');
                document.getElementById('modal-hapus').classList.add('hidden');
            }
        });
    </script>

</body>
</html>
