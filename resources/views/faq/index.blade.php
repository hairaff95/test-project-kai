@extends('layout.app')

@section('title', 'Pusat Bantuan & FAQ — KAI Daop 4 Semarang')

@section('content')
<div class="w-full px-6 sm:px-8 lg:px-10 py-8 pb-32 sm:pb-12">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 mb-6 border-b border-gray-200">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-primary">Pusat Informasi</span>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-950 tracking-tight mt-1">
                Tanya Jawab & Bantuan (FAQ)
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Panduan seputar pemanfaatan, sewa, dan pembelian aset properti PT KAI Daop 4 Semarang.
            </p>
        </div>

        {{-- Search Input --}}
        <div class="relative w-full md:w-80">
            <input type="text" id="faq-search" 
                   placeholder="Cari topik atau pertanyaan..." 
                   class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
            <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
        </div>
    </div>

    {{-- Category Filter --}}
    <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-6 no-scrollbar" id="category-filter">
        <button onclick="filterCategory(this, 'semua')" 
                class="cat-btn active-cat bg-primary text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shrink-0">
            Semua Topik
        </button>
        <button onclick="filterCategory(this, 'umum')" 
                class="cat-btn bg-white border border-gray-200 text-gray-600 text-xs font-medium px-4 py-2.5 rounded-xl hover:border-primary hover:text-primary transition shrink-0">
            Umum
        </button>
        <button onclick="filterCategory(this, 'aset')" 
                class="cat-btn bg-white border border-gray-200 text-gray-600 text-xs font-medium px-4 py-2.5 rounded-xl hover:border-primary hover:text-primary transition shrink-0">
            Pengelolaan Aset
        </button>
        <button onclick="filterCategory(this, 'harga')" 
                class="cat-btn bg-white border border-gray-200 text-gray-600 text-xs font-medium px-4 py-2.5 rounded-xl hover:border-primary hover:text-primary transition shrink-0">
            Harga & Penawaran
        </button>
        <button onclick="filterCategory(this, 'akun')" 
                class="cat-btn bg-white border border-gray-200 text-gray-600 text-xs font-medium px-4 py-2.5 rounded-xl hover:border-primary hover:text-primary transition shrink-0">
            Akun & Akses
        </button>
        <button onclick="filterCategory(this, 'teknis')" 
                class="cat-btn bg-white border border-gray-200 text-gray-600 text-xs font-medium px-4 py-2.5 rounded-xl hover:border-primary hover:text-primary transition shrink-0">
            Teknis
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
        
        {{-- FAQ List --}}
        <div class="lg:col-span-2 divide-y divide-gray-200 border-t border-b border-gray-200" id="faq-list">

            {{-- 1. UMUM --}}
            <div class="faq-item py-4 transition-colors" data-cat="umum" data-question="apa itu kai asset management">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 text-left font-bold text-sm text-gray-900 hover:text-primary transition">
                    <span>Apa itu KAI Property Asset Tracker?</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 faq-icon transition-transform"></i>
                </button>
                <div class="faq-answer hidden pt-3 text-sm text-gray-600 leading-relaxed">
                    KAI Property Asset Tracker adalah platform GIS berbasis web resmi untuk memetakan, melacak, dan mengelola katalog aset properti strategis milik PT Kereta Api Indonesia (Persero) Daop 4 Semarang yang siap dikomersialkan untuk disewakan maupun dikerjasamakan.
                </div>
            </div>

            <div class="faq-item py-4 transition-colors" data-cat="umum" data-question="siapa yang bisa mengakses sistem ini">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 text-left font-bold text-sm text-gray-900 hover:text-primary transition">
                    <span>Siapa yang dapat mengakses sistem ini?</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 faq-icon transition-transform"></i>
                </button>
                <div class="faq-answer hidden pt-3 text-sm text-gray-600 leading-relaxed">
                    Masyarakat umum dapat melihat katalog properti, lokasi di peta, rute, dan mengajukan minat penawaran. Sementara pegawai dan unit pengelola KAI memiliki hak akses khusus Admin & Super Admin untuk memperbarui data aset dan manajemen inventaris.
                </div>
            </div>

            {{-- 2. PENGELOLAAN ASET --}}
            <div class="faq-item py-4 transition-colors" data-cat="aset" data-question="bagaimana cara menambah aset baru">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 text-left font-bold text-sm text-gray-900 hover:text-primary transition">
                    <span>Bagaimana prosedur penambahan data aset baru?</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 faq-icon transition-transform"></i>
                </button>
                <div class="faq-answer hidden pt-3 text-sm text-gray-600 leading-relaxed space-y-2">
                    <p>Admin dapat login ke panel, lalu mengakses menu <strong>Tambah Aset Baru</strong>. Form telah dilengkapi pemilih koordinat peta interaktif (Leaflet) dan upload foto properti.</p>
                </div>
            </div>

            <div class="faq-item py-4 transition-colors" data-cat="aset" data-question="bagaimana cara mengubah status aset">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 text-left font-bold text-sm text-gray-900 hover:text-primary transition">
                    <span>Bagaimana cara mengubah status penawaran aset?</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 faq-icon transition-transform"></i>
                </button>
                <div class="faq-answer hidden pt-3 text-sm text-gray-600 leading-relaxed">
                    Status aset dapat diubah kapan saja melalui halaman <strong>Kelola Aset</strong> dengan menekan tombol Edit pada baris properti terkait. Pilihan status meliputi: <em>Tersedia</em>, <em>Dalam Proses</em>, atau <em>Terjual</em>.
                </div>
            </div>

            {{-- 3. HARGA & PENAWARAN --}}
            <div class="faq-item py-4 transition-colors" data-cat="harga" data-question="apakah harga penawaran bisa dinegosiasi">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 text-left font-bold text-sm text-gray-900 hover:text-primary transition">
                    <span>Apakah nilai penawaran properti dapat dinegosiasikan?</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 faq-icon transition-transform"></i>
                </button>
                <div class="faq-answer hidden pt-3 text-sm text-gray-600 leading-relaxed">
                    Ya, seluruh nilai penawaran yang tertera bersifat <em>negotiable</em> (dapat dinegosiasikan). Calon mitra atau penyewa dapat langsung menghubungi Unit Komersialisasi Aset KAI Daop 4 melalui tombol kontak WhatsApp yang tertera di setiap halaman detail aset.
                </div>
            </div>

            {{-- 4. AKUN & AKSES --}}
            <div class="faq-item py-4 transition-colors" data-cat="akun" data-question="cara mengajukan akun admin baru">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 text-left font-bold text-sm text-gray-900 hover:text-primary transition">
                    <span>Bagaimana cara mendapatkan akun Admin?</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 faq-icon transition-transform"></i>
                </button>
                <div class="faq-answer hidden pt-3 text-sm text-gray-600 leading-relaxed">
                    Akun admin dibuat dan dikelola secara terpusat oleh <strong>Super Admin</strong> melalui menu Manajemen Pengguna.
                </div>
            </div>

            {{-- 5. TEKNIS --}}
            <div class="faq-item py-4 transition-colors" data-cat="teknis" data-question="peta tidak muncul atau error">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 text-left font-bold text-sm text-gray-900 hover:text-primary transition">
                    <span>Peta GIS tidak muncul di peramban saya?</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 faq-icon transition-transform"></i>
                </button>
                <div class="faq-answer hidden pt-3 text-sm text-gray-600 leading-relaxed">
                    Pastikan koneksi internet Anda aktif untuk memuat peta dasar (tiles Leaflet). Jika Anda menggunakan jaringan korporat dengan firewall ketat, pastikan akses ke domain <code class="bg-gray-100 px-1 py-0.5 rounded text-xs">*.basemaps.cartocdn.com</code> dan <code class="bg-gray-100 px-1 py-0.5 rounded text-xs">*.openstreetmap.org</code> diizinkan.
                </div>
            </div>

            <div class="faq-item py-4 transition-colors" data-cat="teknis" data-question="bagaimana cara melihat petunjuk arah">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 text-left font-bold text-sm text-gray-900 hover:text-primary transition">
                    <span>Bagaimana cara mendapatkan petunjuk arah ke lokasi aset?</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 faq-icon transition-transform"></i>
                </button>
                <div class="faq-answer hidden pt-3 text-sm text-gray-600 leading-relaxed">
                    Pada setiap halaman detail aset, klik tombol <strong>Navigasi Rute</strong> atau buka koordinat untuk langsung terhubung ke aplikasi Google Maps dengan titik tujuan otomatis.
                </div>
            </div>

            {{-- No Result State --}}
            <div id="no-result" class="hidden text-center py-16">
                <i data-lucide="search-x" class="w-10 h-10 text-gray-400 mx-auto mb-2"></i>
                <p class="font-bold text-gray-900 text-sm">Pertanyaan tidak ditemukan</p>
                <p class="text-xs text-gray-500 mt-1">Coba gunakan kata kunci lain atau hubungi unit komersialisasi langsung.</p>
            </div>

        </div>

        {{-- Right: Contact Box (Clean Border-Separated Flat Panel) --}}
        <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-24">
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 space-y-6">
                <div>
                    <h2 class="text-base font-bold text-gray-950">Butuh Bantuan Langsung?</h2>
                    <p class="text-xs text-slate-500 mt-1">Hubungi tim Unit Komersialisasi Aset KAI Daop 4 Semarang.</p>
                </div>

                <div class="space-y-3">
                    <a href="https://wa.me/6281234567890" target="_blank"
                       class="flex items-center gap-3 p-3 rounded-xl bg-white hover:bg-orange-50 hover:text-primary border border-gray-200 transition group">
                        <div class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition shrink-0">
                            <i data-lucide="message-square" class="w-4 h-4"></i>
                        </div>
                        <div class="text-xs">
                            <p class="font-bold text-gray-900 group-hover:text-primary">WhatsApp Unit</p>
                            <p class="text-gray-500">0812-3456-7890</p>
                        </div>
                    </a>

                    <a href="tel:02476541000"
                       class="flex items-center gap-3 p-3 rounded-xl bg-white hover:bg-orange-50 hover:text-primary border border-gray-200 transition group">
                        <div class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition shrink-0">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                        </div>
                        <div class="text-xs">
                            <p class="font-bold text-gray-900 group-hover:text-primary">Telepon Kantor</p>
                            <p class="text-gray-500">(024) 7654-1000</p>
                        </div>
                    </a>

                    <div class="p-3.5 rounded-xl bg-white border border-gray-200 text-xs space-y-1">
                        <div class="font-bold text-gray-900 flex items-center gap-1.5">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i>
                            <span>Jam Operasional</span>
                        </div>
                        <p class="text-gray-500 pl-5">Senin – Jumat: 08.00 – 17.00 WIB</p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Ingin Menyewa Aset?</span>
                    <a href="{{ route('assets.catalog') }}" 
                       class="w-full py-2.5 px-4 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-semibold transition flex items-center justify-center gap-2">
                        <span>Buka Katalog Aset</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    function toggleFaq(btn) {
        const item = btn.closest('.faq-item');
        const answer = item.querySelector('.faq-answer');
        const icon = btn.querySelector('.faq-icon');
        const isHidden = answer.classList.contains('hidden');

        // Close all
        document.querySelectorAll('.faq-answer').forEach(a => a.classList.add('hidden'));
        document.querySelectorAll('.faq-icon').forEach(i => i.classList.remove('rotate-180'));

        if (isHidden) {
            answer.classList.remove('hidden');
            icon.classList.add('rotate-180');
        }
    }

    function filterCategory(btn, cat) {
        document.querySelectorAll('.cat-btn').forEach(b => {
            b.classList.remove('bg-primary', 'text-white', 'shadow-sm');
            b.classList.add('bg-white', 'border', 'border-gray-200', 'text-gray-600');
        });
        btn.classList.add('bg-primary', 'text-white', 'shadow-sm');
        btn.classList.remove('bg-white', 'border', 'border-gray-200', 'text-gray-600');

        let matchCount = 0;
        document.querySelectorAll('.faq-item').forEach(item => {
            const isMatch = cat === 'semua' || item.dataset.cat === cat;
            item.classList.toggle('hidden', !isMatch);
            if (isMatch) matchCount++;
        });

        document.getElementById('no-result').classList.toggle('hidden', matchCount > 0);
    }

    document.getElementById('faq-search').addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        let count = 0;

        document.querySelectorAll('.faq-item').forEach(item => {
            const text = item.textContent.toLowerCase();
            const match = !q || text.includes(q);
            item.classList.toggle('hidden', !match);
            if (match) count++;
        });

        document.getElementById('no-result').classList.toggle('hidden', count > 0);
    });
</script>
@endpush
