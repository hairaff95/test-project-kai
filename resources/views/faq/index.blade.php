<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>FAQ - Bantuan - KAI Asset Management</title>

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
                        "primary":            "#006948",
                        "primary-dark":       "#005137",
                        "primary-light":      "#e6f4ee",
                        "primary-mid":        "#b3d9c9",
                        "background":         "#f4f8f5",
                        "surface":            "#ffffff",
                        "on-surface":         "#1a201c",
                        "on-surface-variant": "#637369",
                        "border-subtle":      "#e8eee9",
                    },
                    fontFamily: {
                        "jakarta": ["Plus Jakarta Sans", "sans-serif"],
                        "inter":   ["Inter", "sans-serif"]
                    },
                    boxShadow: {
                        "card": "0 2px 12px 0 rgba(0,105,72,0.06)",
                        "dock": "0 8px 30px rgba(0,0,0,0.07)",
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: "Plus Jakarta Sans", "Inter", sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
            line-height: 1;
        }
        .ms-filled { font-variation-settings: "FILL" 1, "wght" 400, "GRAD" 0, "opsz" 24; }

        /* FAQ accordion */
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }
        .faq-item.open .faq-answer {
            max-height: 500px;
        }
        .faq-item.open .faq-icon {
            transform: rotate(180deg);
        }
        .faq-icon { transition: transform 0.3s ease; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f4f8f5; }
        ::-webkit-scrollbar-thumb { background: #b3d9c9; border-radius: 99px; }

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
    </style>
</head>

<body class="bg-background text-on-surface min-h-screen overflow-x-hidden antialiased">

    <x-sidebar />

    <!-- ===== MAIN CONTENT ===== -->
    <main class="pl-4 pr-4 sm:pl-28 sm:pr-6 md:pl-32 md:pr-8 pt-6 pb-16 min-h-screen">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-1.5 text-xs text-on-surface-variant mb-6" aria-label="breadcrumb">
            <a href="{{ route('assets.index') }}" class="hover:text-primary transition flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">home</span>
                Beranda
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface font-semibold">Bantuan & FAQ</span>
        </nav>

        <!-- ===== PAGE HEADER ===== -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-on-surface tracking-tight leading-tight">
                    Bantuan & FAQ
                </h1>
                <p class="text-sm text-on-surface-variant mt-1">Temukan jawaban atas pertanyaan seputar pengelolaan aset KAI</p>
            </div>
            <!-- Search -->
            <div class="relative w-full sm:w-72 shrink-0">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/60 text-[18px]">search</span>
                <input
                    type="text"
                    id="faq-search"
                    placeholder="Cari pertanyaan..."
                    class="w-full bg-white border border-border-subtle rounded-full pl-10 pr-4 py-2.5
                           text-sm text-on-surface placeholder:text-on-surface-variant/60
                           focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition shadow-sm" />
            </div>
        </div>

        <!-- ===== KATEGORI CHIPS ===== -->
        <div class="flex flex-wrap gap-2 mb-8" id="category-filter">
            <button onclick="filterCategory(this, 'semua')"
                class="cat-btn active-cat bg-primary text-white text-xs font-semibold px-4 py-2 rounded-full transition shadow-sm">
                Semua
            </button>
            <button onclick="filterCategory(this, 'umum')"
                class="cat-btn bg-white border border-border-subtle text-on-surface-variant text-xs font-medium px-4 py-2 rounded-full hover:border-primary hover:text-primary transition">
                Umum
            </button>
            <button onclick="filterCategory(this, 'aset')"
                class="cat-btn bg-white border border-border-subtle text-on-surface-variant text-xs font-medium px-4 py-2 rounded-full hover:border-primary hover:text-primary transition">
                Pengelolaan Aset
            </button>
            <button onclick="filterCategory(this, 'harga')"
                class="cat-btn bg-white border border-border-subtle text-on-surface-variant text-xs font-medium px-4 py-2 rounded-full hover:border-primary hover:text-primary transition">
                Harga & Penawaran
            </button>
            <button onclick="filterCategory(this, 'akun')"
                class="cat-btn bg-white border border-border-subtle text-on-surface-variant text-xs font-medium px-4 py-2 rounded-full hover:border-primary hover:text-primary transition">
                Akun & Akses
            </button>
            <button onclick="filterCategory(this, 'teknis')"
                class="cat-btn bg-white border border-border-subtle text-on-surface-variant text-xs font-medium px-4 py-2 rounded-full hover:border-primary hover:text-primary transition">
                Teknis
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- ===== FAQ LIST ===== -->
            <div class="lg:col-span-2 flex flex-col gap-3" id="faq-list">

                <!-- === UMUM === -->
                <p class="text-[11px] font-bold text-on-surface-variant uppercase tracking-widest mt-2 mb-1 faq-section" data-cat="umum">Umum</p>

                <div class="faq-item bg-white rounded-2xl border border-border-subtle shadow-card overflow-hidden" data-cat="umum" data-question="apa itu kai asset management">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left">
                        <span class="font-semibold text-sm text-on-surface">Apa itu KAI Asset Management?</span>
                        <span class="material-symbols-outlined faq-icon text-on-surface-variant shrink-0 text-[20px]">expand_more</span>
                    </button>
                    <div class="faq-answer px-5">
                        <p class="text-sm text-on-surface-variant pb-5 leading-relaxed">
                            KAI Asset Management adalah platform internal PT Kereta Api Indonesia (KAI) untuk mengelola, memantau, dan menawarkan aset properti milik KAI kepada calon penyewa maupun pembeli. Platform ini memuat data koordinat, luas, harga penawaran, dan status seluruh aset bangunan KAI.
                        </p>
                    </div>
                </div>

                <div class="faq-item bg-white rounded-2xl border border-border-subtle shadow-card overflow-hidden" data-cat="umum" data-question="siapa yang bisa mengakses sistem ini">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left">
                        <span class="font-semibold text-sm text-on-surface">Siapa yang bisa mengakses sistem ini?</span>
                        <span class="material-symbols-outlined faq-icon text-on-surface-variant shrink-0 text-[20px]">expand_more</span>
                    </button>
                    <div class="faq-answer px-5">
                        <p class="text-sm text-on-surface-variant pb-5 leading-relaxed">
                            Sistem ini dapat diakses oleh pegawai KAI yang memiliki akun aktif dengan hak akses yang sesuai. Terdapat dua level akses utama: <strong class="text-on-surface">Viewer</strong> (hanya melihat data aset) dan <strong class="text-on-surface">Admin</strong> (mengelola data aset secara penuh). Hubungi tim IT KAI untuk pengajuan akun.
                        </p>
                    </div>
                </div>

                <div class="faq-item bg-white rounded-2xl border border-border-subtle shadow-card overflow-hidden" data-cat="umum" data-question="browser apa yang didukung">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left">
                        <span class="font-semibold text-sm text-on-surface">Browser apa saja yang didukung?</span>
                        <span class="material-symbols-outlined faq-icon text-on-surface-variant shrink-0 text-[20px]">expand_more</span>
                    </button>
                    <div class="faq-answer px-5">
                        <p class="text-sm text-on-surface-variant pb-5 leading-relaxed">
                            Sistem dioptimalkan untuk <strong class="text-on-surface">Google Chrome</strong> (versi 100+), <strong class="text-on-surface">Microsoft Edge</strong>, dan <strong class="text-on-surface">Mozilla Firefox</strong> versi terbaru. Fitur peta interaktif memerlukan koneksi internet aktif. Penggunaan di browser lama atau Internet Explorer tidak disarankan.
                        </p>
                    </div>
                </div>

                <!-- === PENGELOLAAN ASET === -->
                <p class="text-[11px] font-bold text-on-surface-variant uppercase tracking-widest mt-4 mb-1 faq-section" data-cat="aset">Pengelolaan Aset</p>

                <div class="faq-item bg-white rounded-2xl border border-border-subtle shadow-card overflow-hidden" data-cat="aset" data-question="bagaimana cara menambah aset baru">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left">
                        <span class="font-semibold text-sm text-on-surface">Bagaimana cara menambah aset baru?</span>
                        <span class="material-symbols-outlined faq-icon text-on-surface-variant shrink-0 text-[20px]">expand_more</span>
                    </button>
                    <div class="faq-answer px-5">
                        <div class="pb-5">
                            <p class="text-sm text-on-surface-variant leading-relaxed mb-3">
                                Untuk menambah aset baru, ikuti langkah berikut:
                            </p>
                            <ol class="list-none flex flex-col gap-2">
                                <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                    <span class="bg-primary-light text-primary text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5">1</span>
                                    Buka halaman <strong class="text-on-surface">Kelola Aset</strong> dari menu navigasi.
                                </li>
                                <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                    <span class="bg-primary-light text-primary text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5">2</span>
                                    Klik tombol <strong class="text-on-surface">+ Tambah Aset</strong> di pojok kanan atas.
                                </li>
                                <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                    <span class="bg-primary-light text-primary text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5">3</span>
                                    Isi formulir: nama bangunan, koordinat (latitude & longitude), luas, harga, dan status.
                                </li>
                                <li class="flex items-start gap-3 text-sm text-on-surface-variant">
                                    <span class="bg-primary-light text-primary text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5">4</span>
                                    Upload foto bangunan (opsional), lalu klik <strong class="text-on-surface">Simpan Aset</strong>.
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="faq-item bg-white rounded-2xl border border-border-subtle shadow-card overflow-hidden" data-cat="aset" data-question="bagaimana cara mengubah status aset">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left">
                        <span class="font-semibold text-sm text-on-surface">Bagaimana cara mengubah status aset?</span>
                        <span class="material-symbols-outlined faq-icon text-on-surface-variant shrink-0 text-[20px]">expand_more</span>
                    </button>
                    <div class="faq-answer px-5">
                        <p class="text-sm text-on-surface-variant pb-5 leading-relaxed">
                            Klik ikon <strong class="text-on-surface">Edit</strong> (pensil) pada baris aset yang ingin diubah di halaman Kelola Aset. Di dalam formulir edit, ubah field <strong class="text-on-surface">Status</strong> menjadi <em>Tersedia</em>, <em>Dalam Proses</em>, atau <em>Terjual</em>, lalu simpan perubahan.
                        </p>
                    </div>
                </div>

                <div class="faq-item bg-white rounded-2xl border border-border-subtle shadow-card overflow-hidden" data-cat="aset" data-question="bagaimana cara menghapus aset">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left">
                        <span class="font-semibold text-sm text-on-surface">Apakah data aset yang dihapus bisa dikembalikan?</span>
                        <span class="material-symbols-outlined faq-icon text-on-surface-variant shrink-0 text-[20px]">expand_more</span>
                    </button>
                    <div class="faq-answer px-5">
                        <p class="text-sm text-on-surface-variant pb-5 leading-relaxed">
                            <strong class="text-on-surface">Tidak.</strong> Penghapusan data aset bersifat permanen dan tidak dapat dibatalkan. Pastikan Anda telah memverifikasi data sebelum melakukan penghapusan. Jika data terhapus secara tidak sengaja, segera hubungi administrator sistem untuk kemungkinan pemulihan dari backup.
                        </p>
                    </div>
                </div>

                <!-- === HARGA & PENAWARAN === -->
                <p class="text-[11px] font-bold text-on-surface-variant uppercase tracking-widest mt-4 mb-1 faq-section" data-cat="harga">Harga & Penawaran</p>

                <div class="faq-item bg-white rounded-2xl border border-border-subtle shadow-card overflow-hidden" data-cat="harga" data-question="apakah harga penawaran bisa dinegosiasi">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left">
                        <span class="font-semibold text-sm text-on-surface">Apakah harga penawaran bisa dinegosiasi?</span>
                        <span class="material-symbols-outlined faq-icon text-on-surface-variant shrink-0 text-[20px]">expand_more</span>
                    </button>
                    <div class="faq-answer px-5">
                        <p class="text-sm text-on-surface-variant pb-5 leading-relaxed">
                            Harga yang tertera adalah harga penawaran awal. Negosiasi dapat dilakukan melalui proses resmi yang diatur oleh Divisi Properti KAI. Untuk memulai proses negosiasi, hubungi tim melalui kontak yang tersedia di halaman detail aset.
                        </p>
                    </div>
                </div>

                <div class="faq-item bg-white rounded-2xl border border-border-subtle shadow-card overflow-hidden" data-cat="harga" data-question="bagaimana cara memperbarui harga aset">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left">
                        <span class="font-semibold text-sm text-on-surface">Bagaimana cara memperbarui harga aset?</span>
                        <span class="material-symbols-outlined faq-icon text-on-surface-variant shrink-0 text-[20px]">expand_more</span>
                    </button>
                    <div class="faq-answer px-5">
                        <p class="text-sm text-on-surface-variant pb-5 leading-relaxed">
                            Admin dapat memperbarui harga melalui fitur Edit di halaman Kelola Aset. Perubahan harga akan langsung tercermin di peta dan halaman detail aset. Setiap perubahan harga dicatat dalam log aktivitas sistem.
                        </p>
                    </div>
                </div>

                <!-- === AKUN & AKSES === -->
                <p class="text-[11px] font-bold text-on-surface-variant uppercase tracking-widest mt-4 mb-1 faq-section" data-cat="akun">Akun & Akses</p>

                <div class="faq-item bg-white rounded-2xl border border-border-subtle shadow-card overflow-hidden" data-cat="akun" data-question="cara mengajukan akun baru">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left">
                        <span class="font-semibold text-sm text-on-surface">Bagaimana cara mengajukan akun baru?</span>
                        <span class="material-symbols-outlined faq-icon text-on-surface-variant shrink-0 text-[20px]">expand_more</span>
                    </button>
                    <div class="faq-answer px-5">
                        <p class="text-sm text-on-surface-variant pb-5 leading-relaxed">
                            Pengajuan akun dilakukan melalui atasan langsung dengan mengisi formulir permohonan akses sistem. Formulir dikirimkan ke tim IT KAI Daop masing-masing. Proses aktivasi membutuhkan waktu 1–3 hari kerja setelah formulir diterima.
                        </p>
                    </div>
                </div>

                <div class="faq-item bg-white rounded-2xl border border-border-subtle shadow-card overflow-hidden" data-cat="akun" data-question="lupa password atau tidak bisa login">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left">
                        <span class="font-semibold text-sm text-on-surface">Lupa password atau tidak bisa login?</span>
                        <span class="material-symbols-outlined faq-icon text-on-surface-variant shrink-0 text-[20px]">expand_more</span>
                    </button>
                    <div class="faq-answer px-5">
                        <p class="text-sm text-on-surface-variant pb-5 leading-relaxed">
                            Gunakan fitur <strong class="text-on-surface">Lupa Password</strong> di halaman login, lalu ikuti instruksi yang dikirim ke email KAI Anda. Jika email tidak diterima dalam 5 menit, periksa folder Spam atau hubungi helpdesk IT di ext. <strong class="text-on-surface">1500</strong>.
                        </p>
                    </div>
                </div>

                <!-- === TEKNIS === -->
                <p class="text-[11px] font-bold text-on-surface-variant uppercase tracking-widest mt-4 mb-1 faq-section" data-cat="teknis">Teknis</p>

                <div class="faq-item bg-white rounded-2xl border border-border-subtle shadow-card overflow-hidden" data-cat="teknis" data-question="peta tidak muncul atau loading lama">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left">
                        <span class="font-semibold text-sm text-on-surface">Peta tidak muncul atau loading terlalu lama?</span>
                        <span class="material-symbols-outlined faq-icon text-on-surface-variant shrink-0 text-[20px]">expand_more</span>
                    </button>
                    <div class="faq-answer px-5">
                        <p class="text-sm text-on-surface-variant pb-5 leading-relaxed">
                            Periksa koneksi internet Anda. Peta membutuhkan koneksi aktif untuk memuat tile dari server kartografi. Jika masalah berlanjut, coba: (1) refresh halaman, (2) hapus cache browser, (3) coba di browser berbeda. Jika tetap bermasalah, laporkan ke helpdesk IT.
                        </p>
                    </div>
                </div>

                <div class="faq-item bg-white rounded-2xl border border-border-subtle shadow-card overflow-hidden" data-cat="teknis" data-question="bagaimana cara export data aset">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left">
                        <span class="font-semibold text-sm text-on-surface">Bagaimana cara export data aset?</span>
                        <span class="material-symbols-outlined faq-icon text-on-surface-variant shrink-0 text-[20px]">expand_more</span>
                    </button>
                    <div class="faq-answer px-5">
                        <p class="text-sm text-on-surface-variant pb-5 leading-relaxed">
                            Di halaman Kelola Aset, klik tombol <strong class="text-on-surface">Export</strong> di bagian atas kanan. Data akan diunduh dalam format <strong class="text-on-surface">Excel (.xlsx)</strong> atau <strong class="text-on-surface">CSV</strong> sesuai pilihan. Fitur ini hanya tersedia untuk pengguna dengan hak akses Admin.
                        </p>
                    </div>
                </div>

                <!-- No result state -->
                <div id="no-result" class="hidden flex flex-col items-center justify-center py-16 text-center">
                    <div class="bg-white rounded-full p-5 mb-3 border border-border-subtle">
                        <span class="material-symbols-outlined text-[40px] text-on-surface-variant/40">search_off</span>
                    </div>
                    <p class="font-semibold text-on-surface">Pertanyaan tidak ditemukan</p>
                    <p class="text-sm text-on-surface-variant mt-1">Coba kata kunci lain atau hubungi kami langsung</p>
                </div>

            </div><!-- end faq-list -->

            <!-- ===== SIDEBAR KANAN ===== -->
            <div class="flex flex-col gap-4">

                <!-- Kontak Bantuan -->
                <div class="bg-white rounded-2xl border border-border-subtle shadow-card p-5">
                    <h3 class="font-bold text-sm text-on-surface mb-0.5">Tidak menemukan jawaban?</h3>
                    <p class="text-xs text-on-surface-variant mb-4">Hubungi tim kami secara langsung.</p>

                    <div class="flex flex-col gap-2">
                        <a href="mailto:properti@kai.id"
                           class="flex items-center gap-3 p-3 rounded-xl bg-background hover:bg-primary-light transition group">
                            <div class="bg-primary-light group-hover:bg-white rounded-lg p-2 transition">
                                <span class="material-symbols-outlined ms-filled text-primary text-[18px]">mail</span>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-on-surface">Email</p>
                                <p class="text-xs text-on-surface-variant">properti@kai.id</p>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 ml-auto">open_in_new</span>
                        </a>

                        <a href="tel:+62217191150"
                           class="flex items-center gap-3 p-3 rounded-xl bg-background hover:bg-primary-light transition group">
                            <div class="bg-primary-light group-hover:bg-white rounded-lg p-2 transition">
                                <span class="material-symbols-outlined ms-filled text-primary text-[18px]">call</span>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-on-surface">Telepon</p>
                                <p class="text-xs text-on-surface-variant">(021) 719-1150</p>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 ml-auto">chevron_right</span>
                        </a>

                        <div class="flex items-center gap-3 p-3 rounded-xl bg-background">
                            <div class="bg-primary-light rounded-lg p-2">
                                <span class="material-symbols-outlined ms-filled text-primary text-[18px]">schedule</span>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-on-surface">Jam Operasional</p>
                                <p class="text-xs text-on-surface-variant">Sen–Jum &nbsp;08.00–17.00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan & Tautan Cepat (digabung) -->
                <div class="bg-white rounded-2xl border border-border-subtle shadow-card p-5">

                    <!-- Ringkasan -->
                    <h3 class="font-bold text-sm text-on-surface mb-3">Ringkasan</h3>
                    <div class="grid grid-cols-3 gap-2 mb-5">
                        <div class="bg-background rounded-xl p-3 text-center">
                            <p class="text-lg font-bold text-primary">12</p>
                            <p class="text-[10px] text-on-surface-variant mt-0.5">Pertanyaan</p>
                        </div>
                        <div class="bg-background rounded-xl p-3 text-center">
                            <p class="text-lg font-bold text-primary">5</p>
                            <p class="text-[10px] text-on-surface-variant mt-0.5">Kategori</p>
                        </div>
                        <div class="bg-background rounded-xl p-3 text-center">
                            <p class="text-lg font-bold text-on-surface">Agt</p>
                            <p class="text-[10px] text-on-surface-variant mt-0.5">Update</p>
                        </div>
                    </div>

                    <div class="h-px bg-border-subtle mb-4"></div>

                    <!-- Tautan Cepat -->
                    <h3 class="font-bold text-sm text-on-surface mb-2">Tautan Cepat</h3>
                    <div class="flex flex-col gap-0.5">
                        <a href="{{ route('assets.index') }}"
                           class="flex items-center gap-2.5 text-sm text-on-surface-variant hover:text-primary hover:bg-primary-light rounded-lg px-2 py-2 transition">
                            <span class="material-symbols-outlined text-[17px]">map</span>
                            Peta Aset
                        </a>
                        <a href="{{ route('assets.manage') }}"
                           class="flex items-center gap-2.5 text-sm text-on-surface-variant hover:text-primary hover:bg-primary-light rounded-lg px-2 py-2 transition">
                            <span class="material-symbols-outlined text-[17px]">inventory_2</span>
                            Kelola Aset
                        </a>
                        <a href="#"
                           class="flex items-center gap-2.5 text-sm text-on-surface-variant hover:text-primary hover:bg-primary-light rounded-lg px-2 py-2 transition">
                            <span class="material-symbols-outlined text-[17px]">description</span>
                            Laporan
                        </a>
                    </div>
                </div>

            </div>
        </div><!-- end grid -->

    </main>

    <script>
        /* ---- Accordion ---- */
        function toggleFaq(btn) {
            const item = btn.closest('.faq-item');
            const isOpen = item.classList.contains('open');
            // close all
            document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        }

        /* ---- Category filter ---- */
        function filterCategory(btn, cat) {
            document.querySelectorAll('.cat-btn').forEach(b => {
                b.classList.remove('bg-primary', 'text-white', 'active-cat', 'shadow-sm');
                b.classList.add('bg-white', 'border', 'border-border-subtle', 'text-on-surface-variant');
            });
            btn.classList.add('bg-primary', 'text-white', 'active-cat', 'shadow-sm');
            btn.classList.remove('bg-white', 'border', 'border-border-subtle', 'text-on-surface-variant');

            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.toggle('hidden', cat !== 'semua' && item.dataset.cat !== cat);
            });
            document.querySelectorAll('.faq-section').forEach(sec => {
                sec.classList.toggle('hidden', cat !== 'semua' && sec.dataset.cat !== cat);
            });
        }

        /* ---- Search ---- */
        document.getElementById('faq-search').addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            let found = 0;

            document.querySelectorAll('.faq-item').forEach(item => {
                const q_text = item.dataset.question || '';
                const btn_text = item.querySelector('button span').textContent.toLowerCase();
                const match = !q || btn_text.includes(q) || q_text.includes(q);
                item.classList.toggle('hidden', !match);
                if (match) found++;
            });

            // hide section headers with no visible items
            document.querySelectorAll('.faq-section').forEach(sec => {
                const cat = sec.dataset.cat;
                const hasVisible = [...document.querySelectorAll(`.faq-item[data-cat="${cat}"]`)]
                    .some(i => !i.classList.contains('hidden'));
                sec.classList.toggle('hidden', !hasVisible);
            });

            document.getElementById('no-result').classList.toggle('hidden', found > 0);
        });
    </script>

</body>
</html>
