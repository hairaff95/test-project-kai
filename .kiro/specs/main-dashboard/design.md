# Design Document: Main Dashboard

## Overview

Main Dashboard adalah halaman utama platform Klas Berdaya yang ditampilkan setelah user login. Halaman ini dirancang sebagai *overview page* yang memberikan ringkasan informasi platform secara sekilas — statistik, program terbaru, kegiatan mendatang, dan pengumuman — dalam satu tampilan yang terorganisir dan mudah dipindai.

Arsitektur UI mengikuti pola **App Shell + Content Sections**: layout wrapper permanen (Sidebar + Header) membungkus area konten dinamis. Pada mobile, Sidebar dikompres menjadi Drawer untuk memaksimalkan ruang layar.

Design terinspirasi dari youth-platform modern (seperti zilenialjateng.id) dengan karakteristik: tipografi bersih, kartu berisi informasi padat, warna yang energetik namun profesional, dan hierarki visual yang jelas.

---

## Architecture

### Struktur Folder

```
src/
├── app/
│   └── (dashboard)/
│       ├── layout.tsx          ← DashboardLayout (Sidebar + Header wrapper)
│       └── dashboard/
│           └── page.tsx        ← Halaman Main Dashboard
│
├── components/
│   ├── layout/
│   │   ├── Sidebar.tsx         ← Sidebar navigasi (desktop/tablet)
│   │   ├── Header.tsx          ← Header bar
│   │   └── DashboardLayout.tsx ← Layout wrapper (opsional, bisa di app/layout)
│   │
│   └── ui/                     ← Reusable UI components
│       ├── StatisticCard.tsx
│       ├── ProgramCard.tsx
│       ├── ActivityCard.tsx
│       ├── AnnouncementCard.tsx
│       └── StatusBadge.tsx
│
├── data/
│   ├── programs.ts             ← Mock data program
│   ├── activities.ts           ← Mock data kegiatan
│   └── announcements.ts        ← Mock data pengumuman
│
├── hooks/
│   └── useDashboard.ts         ← Hook untuk mengambil & mengagregasi data dashboard
│
├── types/
│   ├── program.ts              ← TypeScript types untuk Program
│   ├── activity.ts             ← TypeScript types untuk Activity
│   └── announcement.ts         ← TypeScript types untuk Announcement
│
└── lib/
    └── utils.ts                ← Utility functions (cn, formatDate, truncate)
```

### Component Hierarchy

```
DashboardLayout (layout.tsx)
├── Sidebar
│   ├── SidebarBrand
│   ├── SidebarNavItem (×9)
│   └── SidebarLogout
│
├── Header
│   ├── HamburgerButton (mobile only)
│   ├── PageTitle
│   ├── NotificationBell
│   └── UserMenu
│       ├── UserAvatar
│       └── UserDropdown
│
└── Main Content Area
    └── DashboardPage (page.tsx)
        ├── WelcomeBanner
        ├── StatisticsSection
        │   ├── StatisticCard (Total Program)
        │   ├── StatisticCard (Kegiatan Mendatang)
        │   └── StatisticCard (Pengumuman Terbaru)
        │
        ├── ProgramsSection
        │   ├── SectionHeader ("Program Terbaru")
        │   ├── ProgramCard (×3)
        │   └── ViewAllButton → /programs
        │
        ├── ActivitiesSection
        │   ├── SectionHeader ("Kegiatan Mendatang")
        │   ├── ActivityCard (×3)
        │   └── ViewAllButton → /activities
        │
        └── AnnouncementsSection
            ├── SectionHeader ("Pengumuman Terbaru")
            ├── AnnouncementCard (×3)
            └── ViewAllButton → /announcements
```

---

## Components and Interfaces

### 1. DashboardLayout (`layout.tsx`)

Layout wrapper yang digunakan oleh semua halaman dalam route group `(dashboard)`.

**Tanggung Jawab:**
- Mengelola state `isSidebarOpen` untuk mobile Drawer
- Mengirimkan callback open/close ke Header dan Sidebar
- Menyusun struktur grid layout

**Layout Structure:**
```
┌─────────────────────────────────────────┐
│  Sidebar (fixed, 240px)  │  Header (64px)│
│                          ├──────────────┤
│  [Nav Items]             │  Main Content │
│                          │  (scrollable) │
└──────────────────────────┴───────────────┘
```

**Mobile:**
```
┌─────────────────────────────────┐
│  Header (64px) [☰ hamburger]   │
├─────────────────────────────────┤
│  Main Content (full width)      │
│  (scrollable)                   │
└─────────────────────────────────┘
[Drawer overlays from left when open]
```

### 2. Sidebar Component

```typescript
// Props
interface SidebarProps {
  isOpen: boolean        // untuk mobile drawer
  onClose: () => void    // menutup drawer
}

// Nav items config
const NAV_ITEMS: NavItem[] = [
  { label: 'Dashboard',       href: '/dashboard',       icon: LayoutDashboard },
  { label: 'Programs',        href: '/programs',         icon: BookOpen },
  { label: 'Activities',      href: '/activities',       icon: Calendar },
  { label: 'My Registrations',href: '/registrations',   icon: ClipboardList },
  { label: 'Announcements',   href: '/announcements',    icon: Megaphone },
  { label: 'Membership Card', href: '/membership',       icon: CreditCard },
  { label: 'Profile',         href: '/profile',          icon: User },
  { label: 'Settings',        href: '/settings',         icon: Settings },
]
```

**Behavior:**
- Desktop/Tablet: selalu visible sebagai kolom kiri
- Mobile: muncul sebagai Drawer (Sheet dari shadcn/ui) dari sisi kiri dengan overlay backdrop
- Active state: background highlight + text warna primary pada item yang sesuai dengan current pathname

### 3. Header Component

```typescript
interface HeaderProps {
  onMenuToggle: () => void   // toggle mobile drawer
  isSidebarOpen: boolean     // untuk aria-expanded
  pageTitle?: string         // judul halaman aktif
}
```

**Konten:**
- Kiri: HamburgerButton (mobile only), PageTitle
- Kanan: NotificationBell (dengan badge count), UserAvatar + nama

### 4. StatisticCard Component

```typescript
interface StatisticCardProps {
  title: string         // Label statistik, contoh: "Total Program"
  value: number         // Angka utama
  icon: LucideIcon      // Ikon dari lucide-react
  description?: string  // Teks deskripsi tambahan (opsional)
  trend?: {
    value: number       // Persentase perubahan
    direction: 'up' | 'down' | 'neutral'
  }
}
```

### 5. ProgramCard Component

```typescript
interface ProgramCardProps {
  program: Program
  onClick?: () => void
}
```

**Konten yang ditampilkan:** Gambar/banner (opsional), kategori badge, judul, deskripsi singkat (truncate 100 char), tanggal mulai, StatusBadge status

### 6. ActivityCard Component

```typescript
interface ActivityCardProps {
  activity: Activity
  onClick?: () => void
}
```

**Konten yang ditampilkan:** Judul kegiatan, nama program induk, tanggal & waktu (format: "Senin, 15 Jan 2025 · 09.00 WIB"), mode (Online/Offline) + lokasi, StatusBadge status pendaftaran

### 7. AnnouncementCard Component

```typescript
interface AnnouncementCardProps {
  announcement: Announcement
  onClick?: () => void
}
```

**Konten yang ditampilkan:** Judul, ringkasan (truncate 120 char), tanggal publikasi (format relatif: "2 hari lalu"), kategori tag

### 8. StatusBadge Component

```typescript
type BadgeStatus = 
  | 'active'      // Aktif - hijau
  | 'upcoming'    // Mendatang - biru  
  | 'completed'   // Selesai - abu
  | 'open'        // Pendaftaran Dibuka - hijau
  | 'closed'      // Pendaftaran Ditutup - merah
  | 'full'        // Penuh - oranye
  | 'info'        // Informasi - ungu

interface StatusBadgeProps {
  status: BadgeStatus
  label?: string  // Override label default
}
```

---

## Data Models

### Program Type

```typescript
// src/types/program.ts

export type ProgramStatus = 'active' | 'upcoming' | 'completed'
export type ProgramCategory = 
  | 'Teknologi' 
  | 'Kepemimpinan' 
  | 'Kewirausahaan'
  | 'Seni & Budaya'
  | 'Lingkungan'
  | 'Kesehatan'

export interface Program {
  id: string
  title: string
  description: string
  category: ProgramCategory
  status: ProgramStatus
  startDate: string        // ISO date string: "2025-02-01"
  endDate: string          // ISO date string: "2025-06-30"
  imageUrl?: string
  registrationDeadline?: string
  maxParticipants?: number
  currentParticipants?: number
  organizerName: string
  tags: string[]
  createdAt: string
}
```

### Activity Type

```typescript
// src/types/activity.ts

export type ActivityMode = 'online' | 'offline' | 'hybrid'
export type RegistrationStatus = 'open' | 'closed' | 'full'

export interface Activity {
  id: string
  title: string
  programId: string
  programName: string
  description: string
  date: string             // ISO date: "2025-01-20"
  startTime: string        // "09:00"
  endTime: string          // "12:00"
  mode: ActivityMode
  location?: string        // Nama tempat jika offline/hybrid
  meetingUrl?: string      // URL jika online
  registrationStatus: RegistrationStatus
  maxParticipants?: number
  currentParticipants?: number
  createdAt: string
}
```

### Announcement Type

```typescript
// src/types/announcement.ts

export type AnnouncementCategory = 
  | 'Program'
  | 'Kegiatan'
  | 'Umum'
  | 'Penting'
  | 'Beasiswa'

export interface Announcement {
  id: string
  title: string
  content: string          // Full content (markdown/HTML)
  summary: string          // Ringkasan singkat, maks 200 char
  category: AnnouncementCategory
  publishedAt: string      // ISO datetime
  isImportant: boolean     // Untuk pin/highlight di dashboard
  imageUrl?: string
  authorName: string
  tags: string[]
}
```

### Dashboard Stats Type

```typescript
// src/types/dashboard.ts

export interface DashboardStats {
  totalActivePrograms: number
  totalUpcomingActivities: number
  totalRecentAnnouncements: number
}
```

---

## Mock Data Contracts

### `src/data/programs.ts`

```typescript
import { Program } from '@/types/program'

export const mockPrograms: Program[] = [
  // Minimal 5 item
  {
    id: 'prog-001',
    title: 'Program Digitalisasi Desa 2025',
    description: 'Program peningkatan kapasitas digital untuk masyarakat desa...',
    category: 'Teknologi',
    status: 'active',
    startDate: '2025-01-15',
    endDate: '2025-06-30',
    organizerName: 'Klas Berdaya',
    tags: ['digital', 'desa', 'teknologi'],
    createdAt: '2025-01-01T00:00:00Z',
  },
  // ... 4 item lainnya
]

// Helper: ambil N program terbaru
export const getRecentPrograms = (n = 3): Program[] => 
  mockPrograms
    .sort((a, b) => new Date(b.createdAt).getTime() - new Date(a.createdAt).getTime())
    .slice(0, n)
```

### `src/data/activities.ts`

```typescript
import { Activity } from '@/types/activity'

export const mockActivities: Activity[] = [
  // Minimal 5 item
]

// Helper: ambil N kegiatan mendatang (date >= today)
export const getUpcomingActivities = (n = 3): Activity[] =>
  mockActivities
    .filter(a => new Date(a.date) >= new Date())
    .sort((a, b) => new Date(a.date).getTime() - new Date(b.date).getTime())
    .slice(0, n)
```

### `src/data/announcements.ts`

```typescript
import { Announcement } from '@/types/announcement'

export const mockAnnouncements: Announcement[] = [
  // Minimal 5 item
]

// Helper: ambil N pengumuman terbaru
export const getRecentAnnouncements = (n = 3): Announcement[] =>
  mockAnnouncements
    .sort((a, b) => new Date(b.publishedAt).getTime() - new Date(a.publishedAt).getTime())
    .slice(0, n)
```

---

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system — essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: StatisticCard selalu merender semua informasi yang diperlukan

*For any* valid `StatisticCardProps`, komponen StatisticCard yang dirender SHALL mengandung: nilai numerik (`value`), teks label (`title`), dan elemen ikon.

**Validates: Requirements 5.3**

---

### Property 2: ProgramCard selalu merender semua field yang diperlukan

*For any* valid `Program` object, komponen ProgramCard yang dirender SHALL menampilkan: judul program, kategori, status badge, dan tanggal mulai.

**Validates: Requirements 6.2**

---

### Property 3: ActivityCard selalu merender semua field yang diperlukan

*For any* valid `Activity` object, komponen ActivityCard yang dirender SHALL menampilkan: judul kegiatan, nama program terkait, tanggal & waktu, mode pelaksanaan, dan status pendaftaran.

**Validates: Requirements 7.2**

---

### Property 4: AnnouncementCard selalu merender semua field yang diperlukan

*For any* valid `Announcement` object, komponen AnnouncementCard yang dirender SHALL menampilkan: judul, ringkasan (summary), tanggal publikasi, dan kategori.

**Validates: Requirements 8.2**

---

### Property 5: Deskripsi/ringkasan selalu terpotong dengan benar

*For any* string dengan panjang > N karakter, fungsi truncate SHALL menghasilkan string yang panjangnya ≤ N + 3 karakter (N karakter + "..."), dan untuk string dengan panjang ≤ N karakter, fungsi truncate SHALL mengembalikan string tersebut apa adanya tanpa modifikasi.

**Validates: Requirements 6.2, 8.2**

---

### Property 6: getRecentPrograms tidak pernah mengembalikan lebih dari N item

*For any* array `mockPrograms` dengan panjang ≥ 0, memanggil `getRecentPrograms(n)` SHALL mengembalikan array dengan panjang `min(n, mockPrograms.length)`.

**Validates: Requirements 6.1**

---

### Property 7: getUpcomingActivities hanya mengembalikan kegiatan di masa depan

*For any* array `mockActivities`, memanggil `getUpcomingActivities()` SHALL mengembalikan array dimana setiap item memiliki nilai `date` yang lebih besar atau sama dengan tanggal hari ini.

**Validates: Requirements 7.1**

---

### Property 8: StatusBadge merender label yang sesuai untuk setiap status

*For any* nilai `BadgeStatus` yang valid, komponen StatusBadge SHALL merender badge dengan label yang tidak kosong dan kelas warna yang berbeda dari status lainnya.

**Validates: Requirements 6.2, 7.2**

---

## Error Handling

### Loading States

Setiap seksi konten menggunakan `Suspense`-compatible pattern:

```typescript
// Pola skeleton loading
function ProgramsSectionSkeleton() {
  return (
    <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
      {Array.from({ length: 3 }).map((_, i) => (
        <Skeleton key={i} className="h-48 w-full rounded-lg" />
      ))}
    </div>
  )
}
```

### Error States

```typescript
// Pola error state dengan tombol retry
function SectionError({ message, onRetry }: { message: string; onRetry: () => void }) {
  return (
    <div className="flex flex-col items-center gap-3 py-8 text-center">
      <AlertCircle className="text-destructive" />
      <p className="text-sm text-muted-foreground">{message}</p>
      <Button variant="outline" size="sm" onClick={onRetry}>Coba Lagi</Button>
    </div>
  )
}
```

### Empty States

```typescript
// Pola empty state
function SectionEmpty({ message }: { message: string }) {
  return (
    <div className="flex flex-col items-center gap-2 py-8 text-center">
      <InboxIcon className="text-muted-foreground/50" />
      <p className="text-sm text-muted-foreground">{message}</p>
    </div>
  )
}
```

---

## Testing Strategy

### Pendekatan Pengujian

Fitur ini adalah UI dashboard berbasis React dengan mock data statis. Pengujian berfokus pada:

1. **Unit Tests** — Memverifikasi rendering komponen dengan data konkret
2. **Property-Based Tests** — Memverifikasi properti universal (rendering field yang diperlukan, truncate, filter data) dengan input yang digenerate secara acak

Framework yang digunakan:
- **Vitest** — Test runner
- **React Testing Library** — Rendering dan assertion komponen
- **fast-check** — Property-based testing library

Konfigurasi property test: minimum **100 iterasi** per test.

### Unit Tests (Contoh-based)

Mencakup:
- Snapshot test untuk StatisticCard, ProgramCard, ActivityCard, AnnouncementCard dengan data valid
- Test empty state: rendering pesan kosong jika data array kosong
- Test loading state: rendering skeleton saat `isLoading = true`
- Test Sidebar: highlight active item berdasarkan pathname
- Test Drawer: buka/tutup via toggle, tutup via overlay click, tutup via Escape

### Property-Based Tests

Setiap properti berikut diimplementasikan sebagai SATU property-based test dengan **≥ 100 iterasi**:

| Property | Tag |
|---|---|
| Property 1: StatisticCard merender semua field | `Feature: main-dashboard, Property 1` |
| Property 2: ProgramCard merender semua field | `Feature: main-dashboard, Property 2` |
| Property 3: ActivityCard merender semua field | `Feature: main-dashboard, Property 3` |
| Property 4: AnnouncementCard merender semua field | `Feature: main-dashboard, Property 4` |
| Property 5: Fungsi truncate benar | `Feature: main-dashboard, Property 5` |
| Property 6: getRecentPrograms respects limit | `Feature: main-dashboard, Property 6` |
| Property 7: getUpcomingActivities hanya masa depan | `Feature: main-dashboard, Property 7` |
| Property 8: StatusBadge label tidak kosong | `Feature: main-dashboard, Property 8` |

### Aksesibilitas

- Jalankan `axe` atau `jest-axe` pada rendered output komponen utama
- Verifikasi aria attributes pada Sidebar, Drawer, dan HamburgerButton

## Icon & Logo Guidelines

- Gunakan Font Awesome untuk icon pada UI jika icon yang dibutuhkan tersedia.