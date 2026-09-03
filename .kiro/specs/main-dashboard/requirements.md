# Requirements Document

## Introduction

Fitur **Main Dashboard** adalah halaman utama (home/overview) yang ditampilkan setelah user login ke platform Klas Berdaya. Halaman ini memberikan ringkasan informasi penting secara sekilas kepada user, mencakup statistik keseluruhan, program terbaru/unggulan, kegiatan yang akan datang, dan pengumuman terbaru. Dashboard menggunakan layout dua-kolom dengan sidebar navigasi di sisi kiri dan area konten utama di sisi kanan, serta bersifat responsif sehingga sidebar berubah menjadi drawer di perangkat mobile.

## Glossary

- **Dashboard**: Halaman utama/overview yang menjadi landing page setelah login
- **Sidebar**: Panel navigasi vertikal di sisi kiri layar pada tampilan desktop/tablet
- **Drawer**: Sidebar yang tersembunyi dan dapat ditampilkan/disembunyikan via toggle pada tampilan mobile
- **StatisticCard**: Komponen kartu yang menampilkan satu angka statistik beserta label dan ikon
- **ProgramCard**: Komponen kartu yang menampilkan informasi ringkas sebuah program
- **ActivityCard**: Komponen kartu yang menampilkan informasi ringkas sebuah kegiatan/activity
- **AnnouncementCard**: Komponen kartu yang menampilkan informasi ringkas sebuah pengumuman
- **StatusBadge**: Komponen badge kecil yang menunjukkan status sebuah item (aktif, mendatang, selesai, dll.)
- **Header**: Bar navigasi horizontal di bagian atas halaman yang menampilkan judul, notifikasi, dan info user
- **Mock Data**: Data dummy yang digunakan sementara sebelum integrasi dengan API nyata
- **DashboardLayout**: Layout wrapper yang menyatukan Sidebar, Header, dan Main Content Area
- **Program**: Inisiatif atau program resmi yang tersedia di platform Klas Berdaya
- **Activity**: Kegiatan konkret yang terkait dengan program, memiliki tanggal pelaksanaan
- **Announcement**: Pengumuman resmi dari platform kepada seluruh user
- **User**: Pengguna umum yang sudah login ke platform Klas Berdaya

---

## Requirements

### Requirement 1: Layout Utama Dashboard

**User Story:** user tidak harus login dahulu, user ingin melihat halaman dashboard dengan layout yang terstruktur, agar saya dapat dengan mudah menavigasi ke berbagai bagian platform.

#### Acceptance Criteria

1. THE Dashboard SHALL menampilkan tiga area utama: Sidebar (navigasi), Header (bar atas), dan Main Content Area (konten utama)
2. WHEN user mengakses halaman dashboard di perangkat desktop (lebar layar ≥ 1024px), THE Dashboard SHALL menampilkan Sidebar yang selalu terlihat di sisi kiri dengan lebar tetap 240px
3. WHEN user mengakses halaman dashboard di perangkat tablet (lebar layar 768px–1023px), THE Dashboard SHALL menampilkan Sidebar yang selalu terlihat di sisi kiri dengan lebar tetap 200px
4. WHEN user mengakses halaman dashboard di perangkat mobile (lebar layar < 768px), THE Dashboard SHALL menyembunyikan Sidebar dan menggantinya dengan Drawer yang dapat dibuka/ditutup
5. THE DashboardLayout SHALL menggunakan struktur file `src/app/(dashboard)/layout.tsx` sebagai layout wrapper
6. THE Main Content Area SHALL memiliki padding yang konsisten (16px mobile, 24px tablet, 32px desktop) dan tidak menyebabkan horizontal scrolling

---

### Requirement 2: Sidebar Navigasi

**User Story:** Sebagai user, saya ingin melihat menu navigasi lengkap di sidebar, agar saya dapat berpindah ke halaman yang diinginkan dengan cepat.

#### Acceptance Criteria

1. THE Sidebar SHALL menampilkan 9 menu item navigasi secara berurutan: Dashboard, Programs, Activities, My Registrations, Announcements, Membership Card, Profile, Settings, dan Logout
2. WHEN user berada di halaman Dashboard, THE Sidebar SHALL menampilkan menu item "Dashboard" dalam keadaan aktif dengan visual highlight yang jelas
3. WHEN user mengklik salah satu menu item navigasi, THE Sidebar SHALL menavigasi user ke halaman yang sesuai menggunakan Next.js Link
4. THE Sidebar SHALL menampilkan ikon yang relevan di sebelah kiri label setiap menu item
5. THE Sidebar SHALL menampilkan logo/nama brand Klas Berdaya di bagian atas
6. WHEN user mengklik menu item "Logout", THE Sidebar SHALL memproses proses logout user dari sesi
7. THE Sidebar SHALL menggunakan warna dan tipografi yang konsisten dengan design system shadcn/ui

---

### Requirement 3: Drawer Mobile

**User Story:** Sebagai user mobile, saya ingin bisa membuka dan menutup menu navigasi via tombol, agar saya tetap bisa mengakses navigasi tanpa membuang ruang layar yang terbatas.

#### Acceptance Criteria

1. WHEN layar berukuran mobile (< 768px), THE Header SHALL menampilkan tombol hamburger (ikon menu) di sisi kiri
2. WHEN user mengklik tombol hamburger, THE Drawer SHALL terbuka dari sisi kiri dan menampilkan semua menu navigasi yang sama dengan Sidebar desktop
3. WHEN Drawer terbuka, THE Dashboard SHALL menampilkan overlay semi-transparan di atas Main Content Area
4. WHEN user mengklik overlay di luar Drawer, THE Drawer SHALL menutup secara otomatis
5. WHEN user mengklik salah satu menu item di dalam Drawer, THE Drawer SHALL menutup secara otomatis setelah navigasi berhasil
6. WHEN user menekan tombol Escape pada keyboard, THE Drawer SHALL menutup secara otomatis

---

### Requirement 4: Header

**User Story:** Sebagai user, saya ingin melihat header yang informatif di bagian atas halaman, agar saya mengetahui konteks halaman yang sedang dilihat dan dapat mengakses aksi-aksi cepat.

#### Acceptance Criteria

1. THE Header SHALL menampilkan judul halaman yang aktif saat ini (contoh: "Dashboard" saat di halaman dashboard)
2. THE Header SHALL menampilkan avatar dan nama user yang sedang login di sisi kanan
3. THE Header SHALL menampilkan ikon notifikasi dengan indikator badge jika terdapat notifikasi yang belum dibaca
4. WHEN user mengklik avatar atau nama user, THE Header SHALL menampilkan dropdown menu dengan opsi "Profile" dan "Logout"
5. THE Header SHALL memiliki tinggi tetap 64px dan menggunakan sticky positioning agar selalu terlihat saat scroll

---

### Requirement 5: Ringkasan Statistik

**User Story:** Sebagai user, saya ingin melihat ringkasan statistik platform dalam bentuk kartu di bagian atas dashboard, agar saya mendapatkan gambaran umum aktivitas platform secara cepat.

#### Acceptance Criteria

1. THE Dashboard SHALL menampilkan 3 StatisticCard dalam satu baris, masing-masing menunjukkan: total program aktif, total kegiatan mendatang, dan total pengumuman terbaru
2. WHEN data statistik sedang dimuat, THE Dashboard SHALL menampilkan skeleton loading pada setiap StatisticCard
3. THE StatisticCard SHALL menampilkan angka utama, label deskriptif, dan ikon yang relevan
4. WHEN lebar layar mobile (< 768px), THE StatisticCard SHALL ditampilkan dalam layout single-column (1 kartu per baris)
5. WHEN lebar layar tablet (768px–1023px), THE StatisticCard SHALL ditampilkan dalam layout 3-kolom

---

### Requirement 6: Seksi Program Terbaru

**User Story:** Sebagai user, saya ingin melihat daftar program terbaru atau unggulan di dashboard, agar saya dapat mengetahui program apa yang tersedia dan menarik untuk diikuti.

#### Acceptance Criteria

1. THE Dashboard SHALL menampilkan seksi "Program Terbaru" dengan maksimal 3 ProgramCard
2. THE ProgramCard SHALL menampilkan: judul program, deskripsi singkat (maks. 100 karakter), kategori, status (StatusBadge), dan tanggal mulai
3. WHEN data program sedang dimuat, THE Dashboard SHALL menampilkan skeleton loading pada setiap ProgramCard
4. IF tidak ada program yang tersedia, THEN THE Dashboard SHALL menampilkan empty state dengan pesan "Belum ada program yang tersedia."
5. THE Dashboard SHALL menampilkan tombol "Lihat Semua Program" di bawah daftar ProgramCard yang mengarahkan ke halaman Programs
6. WHEN user mengklik sebuah ProgramCard, THE Dashboard SHALL menavigasi user ke halaman detail program yang bersangkutan

---

### Requirement 7: Seksi Kegiatan Mendatang

**User Story:** Sebagai user, saya ingin melihat daftar kegiatan yang akan datang di dashboard, agar saya dapat merencanakan partisipasi saya lebih awal.

#### Acceptance Criteria

1. THE Dashboard SHALL menampilkan seksi "Kegiatan Mendatang" dengan maksimal 3 ActivityCard
2. THE ActivityCard SHALL menampilkan: judul kegiatan, nama program terkait, tanggal & waktu pelaksanaan, lokasi/mode (online/offline), dan status pendaftaran (StatusBadge)
3. WHEN data kegiatan sedang dimuat, THE Dashboard SHALL menampilkan skeleton loading pada setiap ActivityCard
4. IF tidak ada kegiatan mendatang, THEN THE Dashboard SHALL menampilkan empty state dengan pesan "Belum ada kegiatan mendatang."
5. THE Dashboard SHALL menampilkan tombol "Lihat Semua Kegiatan" di bawah daftar ActivityCard yang mengarahkan ke halaman Activities
6. WHEN user mengklik sebuah ActivityCard, THE Dashboard SHALL menavigasi user ke halaman detail kegiatan yang bersangkutan

---

### Requirement 8: Seksi Pengumuman Terbaru

**User Story:** Sebagai user, saya ingin melihat pengumuman terbaru di dashboard, agar saya tidak melewatkan informasi penting dari platform.

#### Acceptance Criteria

1. THE Dashboard SHALL menampilkan seksi "Pengumuman Terbaru" dengan maksimal 3 AnnouncementCard
2. THE AnnouncementCard SHALL menampilkan: judul pengumuman, ringkasan isi (maks. 120 karakter), tanggal publikasi, dan kategori/tag pengumuman
3. WHEN data pengumuman sedang dimuat, THE Dashboard SHALL menampilkan skeleton loading pada setiap AnnouncementCard
4. IF tidak ada pengumuman, THEN THE Dashboard SHALL menampilkan empty state dengan pesan "Belum ada pengumuman."
5. THE Dashboard SHALL menampilkan tombol "Lihat Semua Pengumuman" di bawah daftar AnnouncementCard yang mengarahkan ke halaman Announcements
6. WHEN user mengklik sebuah AnnouncementCard, THE Dashboard SHALL menavigasi user ke halaman detail pengumuman yang bersangkutan

---

### Requirement 9: Mock Data

**User Story:** Sebagai developer, saya ingin menggunakan mock data yang terstruktur untuk mengisi konten dashboard, agar tampilan dashboard dapat diuji dan dikembangkan tanpa bergantung pada API yang belum tersedia.

#### Acceptance Criteria

1. THE System SHALL menyimpan mock data program di file `src/data/programs.ts` dengan minimal 5 item data
2. THE System SHALL menyimpan mock data kegiatan di file `src/data/activities.ts` dengan minimal 5 item data
3. THE System SHALL menyimpan mock data pengumuman di file `src/data/announcements.ts` dengan minimal 5 item data
4. THE System SHALL mendefinisikan TypeScript interface/type untuk setiap entitas data di folder `src/types/`
5. WHEN mock data digunakan di komponen, THE System SHALL mengimpor data dari file `src/data/` bukan mendefinisikan data langsung di dalam komponen

---

### Requirement 10: Loading dan Error State

**User Story:** Sebagai user, saya ingin melihat indikasi yang jelas ketika data sedang dimuat atau terjadi kesalahan, agar saya tidak merasa kebingungan atau menunggu tanpa kejelasan.

#### Acceptance Criteria

1. WHEN konten dashboard sedang dimuat, THE Dashboard SHALL menampilkan komponen Skeleton pada setiap area konten yang belum tersedia
2. IF terjadi error saat mengambil data, THEN THE Dashboard SHALL menampilkan pesan error yang jelas, contoh: "Gagal memuat data. Coba Lagi."
3. THE Dashboard SHALL menampilkan tombol "Coba Lagi" pada setiap seksi yang mengalami error
4. WHEN skeleton ditampilkan, THE Dashboard SHALL mempertahankan struktur layout agar tidak terjadi layout shift saat data termuat

---

### Requirement 11: Aksesibilitas dan Responsivitas

**User Story:** Sebagai user dengan berbagai perangkat dan kebutuhan aksesibilitas, saya ingin dashboard dapat digunakan dengan nyaman, agar pengalaman menggunakan platform tetap inklusif dan menyenangkan.

#### Acceptance Criteria

1. THE Dashboard SHALL menggunakan semantic HTML elements (nav, main, header, section, article) pada struktur layout
2. THE Sidebar SHALL memiliki atribut `aria-label="Navigasi Utama"` dan setiap menu item memiliki atribut accessible
3. THE Drawer SHALL memiliki atribut `role="dialog"` dan `aria-modal="true"` ketika terbuka
4. WHEN tombol hamburger di Header diklik, THE Header SHALL memperbarui atribut `aria-expanded` pada tombol tersebut
5. THE Dashboard SHALL tidak menyebabkan horizontal scrolling pada viewport apapun
6. WHEN user menggunakan keyboard untuk navigasi, THE Dashboard SHALL menampilkan focus indicator yang jelas pada setiap elemen interaktif
