# Implementation Plan: Main Dashboard

## Overview

Implementasi halaman utama (main dashboard) Klas Berdaya secara inkremental, dimulai dari fondasi tipe data dan mock data, kemudian reusable UI components, lalu layout utama (Sidebar + Header), dan akhirnya halaman dashboard dengan semua seksinya. Setiap langkah mengintegrasikan komponen ke dalam keseluruhan layout agar tidak ada kode yang "menggantung".

## Tasks

- [x] 1. Buat TypeScript types dan mock data
  - Buat file `src/types/program.ts` dengan interface `Program`, type `ProgramStatus`, dan type `ProgramCategory`
  - Buat file `src/types/activity.ts` dengan interface `Activity`, type `ActivityMode`, dan type `RegistrationStatus`
  - Buat file `src/types/announcement.ts` dengan interface `Announcement` dan type `AnnouncementCategory`
  - Buat file `src/types/dashboard.ts` dengan interface `DashboardStats`
  - Buat file `src/data/programs.ts` dengan minimal 5 item mock program dan helper `getRecentPrograms(n)`
  - Buat file `src/data/activities.ts` dengan minimal 5 item mock activity (tanggal bervariasi, sebagian di masa depan) dan helper `getUpcomingActivities(n)`
  - Buat file `src/data/announcements.ts` dengan minimal 5 item mock announcement dan helper `getRecentAnnouncements(n)`
  - Tambahkan utility `truncate(str, maxLength)` di `src/lib/utils.ts`
  - _Requirements: 9.1, 9.2, 9.3, 9.4, 9.5_

- [ ]* 1.1 Tulis property tests untuk utility dan data helpers
  - **Property 5: Fungsi truncate benar** — for any string dan maxLength, hasil truncate panjangnya ≤ maxLength+3, dan string pendek dikembalikan apa adanya
  - **Property 6: getRecentPrograms respects limit** — for any array programs dan n, hasilnya ≤ min(n, array.length)
  - **Property 7: getUpcomingActivities hanya masa depan** — for any array activities, semua item hasil filter memiliki date ≥ hari ini
  - Gunakan `fast-check` dengan minimum 100 iterasi
  - Tag: `Feature: main-dashboard, Property 5`, `Property 6`, `Property 7`
  - _Requirements: 6.1, 7.1, 6.2, 8.2_

- [x] 2. Buat komponen `StatusBadge`
  - Buat file `src/components/ui/StatusBadge.tsx`
  - Implementasikan semua nilai `BadgeStatus`: `active`, `upcoming`, `completed`, `open`, `closed`, `full`, `info`
  - Gunakan shadcn/ui `Badge` sebagai base component
  - Setiap status memiliki warna variant yang berbeda (gunakan `cn()` untuk class merging)
  - Sertakan label default per status (bisa di-override via prop `label`)
  - _Requirements: 6.2, 7.2_

- [ ]* 2.1 Tulis property test untuk `StatusBadge`
  - **Property 8: StatusBadge merender label tidak kosong** — for any nilai `BadgeStatus` valid, komponen merender badge dengan label non-empty dan kelas warna unik
  - Tag: `Feature: main-dashboard, Property 8`
  - _Requirements: 6.2, 7.2_

- [x] 3. Buat komponen `StatisticCard`
  - Buat file `src/components/ui/StatisticCard.tsx`
  - Implementasikan props: `title`, `value`, `icon`, `description?`, `trend?`
  - Tampilkan nilai angka besar di tengah, label di bawah, ikon di pojok kanan atas
  - Buat variasi skeleton: `StatisticCardSkeleton` untuk loading state
  - Gunakan shadcn/ui `Card` sebagai base component
  - _Requirements: 5.3, 5.1_

- [ ]* 3.1 Tulis property test untuk `StatisticCard`
  - **Property 1: StatisticCard selalu merender semua informasi** — for any valid `StatisticCardProps`, rendered output mengandung `value`, `title`, dan elemen ikon
  - Gunakan `fast-check` untuk generate random `title` (string), `value` (integer), dan pilih icon dari set yang valid
  - Minimum 100 iterasi
  - Tag: `Feature: main-dashboard, Property 1`
  - _Requirements: 5.3_

- [x] 4. Buat komponen `ProgramCard`
  - Buat file `src/components/ui/ProgramCard.tsx`
  - Implementasikan props: `program: Program`, `onClick?: () => void`
  - Tampilkan: kategori badge (warna per kategori), judul, deskripsi (truncate 100 char), tanggal mulai (format Indonesia), `StatusBadge` status
  - Buat variasi skeleton: `ProgramCardSkeleton`
  - Card harus clickable (`cursor-pointer`, hover state) dan memanggil `onClick` jika diberikan
  - _Requirements: 6.2, 6.6_

- [ ]* 4.1 Tulis property test untuk `ProgramCard`
  - **Property 2: ProgramCard selalu merender semua field** — for any valid `Program` object, rendered output mengandung judul, kategori, status badge, dan tanggal mulai
  - Gunakan `fast-check` untuk generate random `Program` objects
  - Tag: `Feature: main-dashboard, Property 2`
  - _Requirements: 6.2_

- [x] 5. Buat komponen `ActivityCard`
  - Buat file `src/components/ui/ActivityCard.tsx`
  - Implementasikan props: `activity: Activity`, `onClick?: () => void`
  - Tampilkan: judul, nama program terkait, tanggal & waktu (format: "Senin, 15 Jan 2025 · 09.00 WIB"), chip mode (Online/Offline/Hybrid), lokasi (jika ada), `StatusBadge` status pendaftaran
  - Buat variasi skeleton: `ActivityCardSkeleton`
  - _Requirements: 7.2, 7.6_

- [ ]* 5.1 Tulis property test untuk `ActivityCard`
  - **Property 3: ActivityCard selalu merender semua field** — for any valid `Activity` object, rendered output mengandung judul, nama program, tanggal/waktu, mode, dan status
  - Tag: `Feature: main-dashboard, Property 3`
  - _Requirements: 7.2_

- [x] 6. Buat komponen `AnnouncementCard`
  - Buat file `src/components/ui/AnnouncementCard.tsx`
  - Implementasikan props: `announcement: Announcement`, `onClick?: () => void`
  - Tampilkan: judul, summary (truncate 120 char), tanggal relatif ("2 hari lalu" menggunakan `formatDistanceToNow` dari `date-fns`), kategori tag
  - Buat variasi skeleton: `AnnouncementCardSkeleton`
  - _Requirements: 8.2, 8.6_

- [ ]* 6.1 Tulis property test untuk `AnnouncementCard`
  - **Property 4: AnnouncementCard selalu merender semua field** — for any valid `Announcement` object, rendered output mengandung judul, summary, tanggal, dan kategori
  - Tag: `Feature: main-dashboard, Property 4`
  - _Requirements: 8.2_

- [x] 7. Checkpoint — Pastikan semua UI components bekerja
  - Pastikan semua tests pass, verifikasi tidak ada TypeScript error pada semua file yang dibuat di task 1–6. Tanyakan jika ada pertanyaan sebelum lanjut.

- [x] 8. Buat komponen `Sidebar`
  - Buat file `src/components/layout/Sidebar.tsx`
  - Implementasikan daftar navigasi berdasarkan `NAV_ITEMS` (9 item sesuai spec) menggunakan ikon dari `lucide-react`
  - Tampilkan logo/nama brand "Klas Berdaya" di bagian atas sidebar
  - Gunakan `usePathname()` dari Next.js untuk deteksi active state (highlight item aktif)
  - Setiap nav item menggunakan Next.js `Link` component
  - Tambahkan tombol Logout di bagian bawah sidebar (terpisah dari nav items)
  - Sidebar memiliki props: `isOpen: boolean`, `onClose: () => void` untuk keperluan mobile Drawer
  - Pada mobile, render menggunakan shadcn/ui `Sheet` component (Drawer dari kiri)
  - Pada desktop/tablet, render sebagai kolom fixed sidebar biasa
  - Tambahkan `aria-label="Navigasi Utama"` pada elemen `<nav>`
  - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 2.7, 3.1, 3.2, 3.3, 3.4, 3.5_

- [x] 9. Buat komponen `Header`
  - Buat file `src/components/layout/Header.tsx`
  - Implementasikan props: `onMenuToggle: () => void`, `isSidebarOpen: boolean`, `pageTitle?: string`
  - Kiri: HamburgerButton (visible hanya di mobile, `aria-expanded={isSidebarOpen}`), PageTitle
  - Kanan: NotificationBell (ikon bell + badge count dummy), UserAvatar + nama user (hardcoded mock untuk sementara)
  - UserAvatar/nama menggunakan shadcn/ui `DropdownMenu` dengan opsi "Profile" dan "Logout"
  - Header menggunakan `sticky top-0 z-40` dan tinggi 64px
  - _Requirements: 4.1, 4.2, 4.3, 4.4, 4.5_

- [x] 10. Buat `DashboardLayout`
  - Buat file `src/app/(dashboard)/layout.tsx`
  - Kelola state `isSidebarOpen` (useState) di level layout
  - Susun struktur: Sidebar di kiri (tersembunyi di mobile), Header di atas, Main Content Area di kanan/bawah
  - Gunakan CSS Grid atau Flexbox untuk layout desktop: `grid-cols-[240px_1fr]`
  - Pada mobile, gunakan `flex-col` (Sidebar menjadi Drawer dari Sidebar component)
  - Pastikan Main Content Area menggunakan `overflow-y-auto` agar dapat discroll independen
  - Berikan padding konsisten pada Main Content Area
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 1.6_

- [ ]* 10.1 Tulis unit tests untuk Sidebar dan Drawer behavior
  - Test: Sidebar menampilkan 9 menu item
  - Test: Active item highlight berdasarkan pathname
  - Test: Drawer buka saat hamburger diklik (mobile)
  - Test: Drawer tutup saat overlay diklik
  - Test: Drawer tutup saat item nav diklik
  - Test: Drawer tutup saat Escape ditekan
  - _Requirements: 2.1, 2.2, 3.1–3.6_

- [x] 11. Buat halaman Dashboard (`page.tsx`)
  - Buat file `src/app/(dashboard)/dashboard/page.tsx`
  - Impor dan gunakan data dari `src/data/` (getRecentPrograms, getUpcomingActivities, getRecentAnnouncements)
  - Hitung `DashboardStats` dari mock data (total program aktif, kegiatan mendatang, pengumuman terbaru)
  - Susun halaman dengan urutan: WelcomeBanner, StatisticsSection, ProgramsSection, ActivitiesSection, AnnouncementsSection
  - Implementasikan `WelcomeBanner`: teks sapaan dengan nama user dan tanggal hari ini
  - Implementasikan `StatisticsSection`: 3 StatisticCard dalam grid (1 kolom mobile, 3 kolom tablet+)
  - Implementasikan `ProgramsSection`: SectionHeader + 3 ProgramCard dalam grid + tombol "Lihat Semua Program" → `/programs`
  - Implementasikan `ActivitiesSection`: SectionHeader + 3 ActivityCard dalam grid + tombol "Lihat Semua Kegiatan" → `/activities`
  - Implementasikan `AnnouncementsSection`: SectionHeader + 3 AnnouncementCard dalam grid + tombol "Lihat Semua Pengumuman" → `/announcements`
  - ProgramCard, ActivityCard, AnnouncementCard harus menggunakan `useRouter().push()` untuk navigasi ke halaman detail saat diklik
  - _Requirements: 5.1, 5.2, 6.1, 6.5, 7.1, 7.5, 8.1, 8.5_

- [x] 12. Implementasikan loading, empty, dan error states
  - Buat komponen `SectionSkeleton` reusable untuk grid skeleton (menerima prop count dan SkeletonCard component)
  - Simulasikan loading state dengan `useState isLoading` dan `useEffect` delay singkat di page.tsx
  - Buat komponen `SectionEmpty` yang menampilkan ikon + pesan + tombol opsional
  - Buat komponen `SectionError` yang menampilkan pesan error + tombol "Coba Lagi"
  - Tampilkan `SectionEmpty` jika array data kosong untuk masing-masing seksi
  - _Requirements: 5.2, 6.4, 7.4, 8.4, 10.1, 10.2, 10.3, 10.4_

- [ ]* 12.1 Tulis unit tests untuk loading, empty, dan error states
  - Test: Skeleton ditampilkan saat `QisLoading = true` untuk setiap seksi
  - Test: Empty state message ditampilkan saat data array kosong
  - Test: Error state + tombol "Coba Lagi" ditampilkan saat `error` prop ada
  - _Requirements: 10.1, 10.2, 10.3, 6.4, 7.4, 8.4_

- [x] 13. Pastikan aksesibilitas dan responsivitas
  - Verifikasi semantic HTML: gunakan `<nav>`, `<main>`, `<header>`, `<section>` sesuai spec
  - Tambahkan `aria-label="Navigasi Utama"` pada `<nav>` di Sidebar jika belum ada
  - Tambahkan `role="dialog"` dan `aria-modal="true"` pada Drawer saat terbuka
  - Verifikasi `aria-expanded` pada HamburgerButton ter-update saat Drawer buka/tutup
  - Uji di breakpoint mobile (375px), tablet (768px), desktop (1280px) — tidak ada horizontal scroll
  - Verifikasi focus indicator visible saat navigasi keyboard
  - _Requirements: 11.1, 11.2, 11.3, 11.4, 11.5, 11.6_

- [x] 14. Final checkpoint — Pastikan semua tests pass
  - Jalankan seluruh test suite, pastikan tidak ada TypeScript error, lint error, atau UI yang rusak. Verifikasi tampilan di mobile dan desktop. Tanyakan jika ada pertanyaan.

## Notes

- Tasks bertanda `*` bersifat opsional dan dapat dilewati untuk pengembangan MVP yang lebih cepat
- Setiap task mereferensikan requirement spesifik untuk traceability
- Property-based tests menggunakan `fast-check` dengan minimum 100 iterasi
- Mock data bersifat sementara dan akan diganti dengan API call di masa mendatang
- Untuk sementara, data user (nama, avatar) di Header menggunakan hardcoded mock — akan diganti setelah auth system tersedia
