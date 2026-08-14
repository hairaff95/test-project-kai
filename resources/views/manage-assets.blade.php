<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Kelola Aset Bangunan - KAI</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
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
                        "primary": "#006948",
                        "primary-dark": "#005137",
                        "primary-light": "#e6f4ee",
                        "background": "#f4f8f5",
                        "surface": "#ffffff",
                        "on-surface": "#1a201c",
                        "on-surface-variant": "#637369",
                        "border-subtle": "#e8eee9",
                    },
                    fontFamily: {
                        "jakarta": ["Plus Jakarta Sans", "sans-serif"],
                        "inter": ["Inter", "sans-serif"]
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
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24
        }
    </style>
</head>

<body class="bg-background text-on-surface min-h-screen flex antialiased">

    <!-- Left Floating Dock Sidebar -->
    <aside class="fixed left-4 top-1/2 -translate-y-1/2 w-16 md:w-20 hidden sm:flex flex-col items-center py-6 md:py-8 rounded-full h-[85vh] max-h-[750px] bg-white/90 backdrop-blur-2xl border border-white/60 shadow-[0_8px_30px_rgba(0,0,0,0.06)] z-30">
        <div class="mb-4">
            <a href="{{ route('assets.index') }}" class="p-2.5 rounded-full text-on-surface-variant hover:text-primary transition flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">home</span>
            </a>
        </div>

        <div class="flex flex-col gap-3 items-center flex-1 w-full px-2">
            <!-- Active Menu: Manage Assets -->
            <a href="{{ route('assets.manage') }}" title="Kelola Aset"
                class="bg-primary text-white rounded-full p-3 shadow-md scale-105 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">add_circle</span>
            </a>
            <a href="#" title="Kalender"
                class="text-on-surface-variant hover:text-primary hover:bg-primary-light/50 rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">calendar_today</span>
            </a>
            <a href="#" title="Laporan"
                class="text-on-surface-variant hover:text-primary hover:bg-primary-light/50 rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">description</span>
            </a>
        </div>

        <div class="flex flex-col gap-3 items-center mt-auto">
            <a href="#" title="Bantuan"
                class="text-on-surface-variant hover:text-primary hover:bg-primary-light/50 rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">help</span>
            </a>
            <a href="#" title="Profil"
                class="text-on-surface-variant hover:text-primary hover:bg-primary-light/50 rounded-full p-2.5 transition flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">account_circle</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 sm:ml-24 md:ml-28 p-4 sm:p-8 md:p-10 max-w-7xl mx-auto w-full">
        <!-- Top Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-on-surface tracking-tight">Kelola Aset Bangunan</h1>
                <p class="text-sm text-on-surface-variant mt-1">Tambah, edit, atau hapus titik koordinat dan rincian harga aset</p>
            </div>
            <button class="bg-primary hover:bg-primary-dark text-white font-semibold text-sm px-5 py-3 rounded-full flex items-center gap-2 shadow-sm transition duration-200 self-start sm:self-auto">
                <span class="material-symbols-outlined text-lg">add</span>
                <span>Tambah Aset Baru</span>
            </button>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-8 max-w-2xl">
            <div class="bg-white rounded-2xl p-5 md:p-6 shadow-sm border border-border-subtle flex flex-col justify-between">
                <span class="text-xs font-semibold text-on-surface-variant">Total Aset</span>
                <span class="text-2xl md:text-3xl font-bold text-primary mt-2">124</span>
            </div>
            <div class="bg-white rounded-2xl p-5 md:p-6 shadow-sm border border-border-subtle flex flex-col justify-between">
                <span class="text-xs font-semibold text-on-surface-variant">Aset Tersedia</span>
                <span class="text-2xl md:text-3xl font-bold text-primary mt-2">85</span>
            </div>
            <div class="bg-white rounded-2xl p-5 md:p-6 shadow-sm border border-border-subtle flex flex-col justify-between">
                <span class="text-xs font-semibold text-on-surface-variant">Aset Terjual</span>
                <span class="text-2xl md:text-3xl font-bold text-on-surface mt-2">39</span>
            </div>
        </div>

        <!-- Table Container Card -->
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-border-subtle">
            <!-- Table Header & Search -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <h2 class="text-lg font-bold text-on-surface">Daftar Aset</h2>
                <div class="relative w-full sm:w-72">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">search</span>
                    <input type="text" placeholder="Cari bangunan..."
                        class="w-full bg-[#f8faf8] border border-border-subtle rounded-full pl-10 pr-4 py-2 text-xs md:text-sm text-on-surface placeholder:text-on-surface-variant/70 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary" />
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[12px] font-semibold text-on-surface-variant/80 border-b border-border-subtle/80">
                            <th class="pb-4 pl-2 font-medium">Gambar</th>
                            <th class="pb-4 font-medium">Nama Bangunan</th>
                            <th class="pb-4 font-medium">Koordinat</th>
                            <th class="pb-4 font-medium">Luas (m²)</th>
                            <th class="pb-4 font-medium">Harga Penawaran</th>
                            <th class="pb-4 font-medium">Status</th>
                            <th class="pb-4 text-center pr-2 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle text-sm">
                        <!-- Row 1 -->
                        <tr class="hover:bg-background/50 transition">
                            <td class="py-4 pl-2">
                                <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=160&q=80"
                                    alt="Gedung Sudirman" class="w-12 h-12 rounded-xl object-cover border border-border-subtle" />
                            </td>
                            <td class="py-4 font-bold text-on-surface pr-4">
                                Gedung Sudirman A
                            </td>
                            <td class="py-4 text-xs text-on-surface-variant">
                                -6.2088,<br />106.8229
                            </td>
                            <td class="py-4 font-semibold text-on-surface">4,500</td>
                            <td class="py-4 font-bold text-primary">Rp 45 M</td>
                            <td class="py-4">
                                <span class="bg-primary-light text-primary text-xs font-semibold px-3 py-1 rounded-full inline-block">
                                    Tersedia
                                </span>
                            </td>
                            <td class="py-4 pr-2">
                                <div class="flex items-center justify-center gap-2 text-on-surface-variant">
                                    <button class="hover:text-primary p-1 transition" title="Edit">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button class="hover:text-red-600 p-1 transition" title="Hapus">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                    <a href="{{ route('assets.index') }}" class="hover:text-primary p-1 transition" title="Lihat di Peta">
                                        <span class="material-symbols-outlined text-lg">map</span>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="hover:bg-background/50 transition">
                            <td class="py-4 pl-2">
                                <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=160&q=80"
                                    alt="Ruko Thamrin" class="w-12 h-12 rounded-xl object-cover border border-border-subtle" />
                            </td>
                            <td class="py-4 font-bold text-on-surface pr-4">
                                Ruko Thamrin Plaza
                            </td>
                            <td class="py-4 text-xs text-on-surface-variant">
                                -6.1944,<br />106.8230
                            </td>
                            <td class="py-4 font-semibold text-on-surface">850</td>
                            <td class="py-4 font-bold text-primary">Rp 12 M</td>
                            <td class="py-4">
                                <span class="bg-primary-light text-primary text-xs font-semibold px-3 py-1 rounded-full inline-block">
                                    Tersedia
                                </span>
                            </td>
                            <td class="py-4 pr-2">
                                <div class="flex items-center justify-center gap-2 text-on-surface-variant">
                                    <button class="hover:text-primary p-1 transition" title="Edit">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button class="hover:text-red-600 p-1 transition" title="Hapus">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                    <a href="{{ route('assets.index') }}" class="hover:text-primary p-1 transition" title="Lihat di Peta">
                                        <span class="material-symbols-outlined text-lg">map</span>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="hover:bg-background/50 transition">
                            <td class="py-4 pl-2">
                                <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=160&q=80"
                                    alt="Gudang Logistik" class="w-12 h-12 rounded-xl object-cover border border-border-subtle" />
                            </td>
                            <td class="py-4 font-bold text-on-surface pr-4">
                                Gudang Logistik Priok
                            </td>
                            <td class="py-4 text-xs text-on-surface-variant">
                                -6.1046,<br />106.8835
                            </td>
                            <td class="py-4 font-semibold text-on-surface">12,000</td>
                            <td class="py-4 font-bold text-on-surface">Rp 80 M</td>
                            <td class="py-4">
                                <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-3 py-1 rounded-full inline-block">
                                    Terjual
                                </span>
                            </td>
                            <td class="py-4 pr-2">
                                <div class="flex items-center justify-center gap-2 text-on-surface-variant">
                                    <a href="{{ route('assets.show', 1) }}" class="hover:text-primary p-1 transition" title="Lihat Detail">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>

</html>
