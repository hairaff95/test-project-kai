<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Pengaturan — Profil Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-[#F6F7F9] font-sans antialiased text-gray-900 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between">

    {{-- Navbar --}}
    <x-navbar active="pengaturan" />

    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-5 sm:pt-8 pb-28 lg:pb-12">

        {{-- Main 2-Column Layout (Sidebar Kiri & Konten Kanan) --}}
        <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-5 lg:gap-14 items-start">

            {{-- ================= SIDEBAR KIRI ================= --}}
            <div class="space-y-4 lg:space-y-6">
                <h1 class="text-[24px] sm:text-[30px] lg:text-[34px] font-bold text-gray-950 tracking-tight">
                    Pengaturan
                </h1>

                {{-- Desktop: vertical nav, Mobile: horizontal tab pills --}}
                <nav class="flex flex-row lg:flex-col gap-2 lg:gap-3 overflow-x-auto pb-1 lg:pb-0">
                    {{-- 1. Tab Profil Saya --}}
                    <button
                        type="button"
                        onclick="switchAdminTab('profil')"
                        id="tab-btn-profil"
                        class="shrink-0 text-left text-sm font-semibold transition cursor-pointer text-[#0066FF] lg:text-[#0066FF] px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-blue-50 lg:bg-transparent"
                    >
                        Profil Saya
                    </button>

                    {{-- 2. Tab Pengajuan Reset Sandi --}}
                    <button
                        type="button"
                        onclick="switchAdminTab('reset-sandi')"
                        id="tab-btn-reset-sandi"
                        class="shrink-0 text-left text-sm font-medium transition cursor-pointer text-gray-400 hover:text-gray-700 px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-gray-100/80 lg:bg-transparent"
                    >
                        Pengajuan Reset Sandi
                    </button>
                </nav>
            </div>


            {{-- ================= KONTEN KANAN ================= --}}
            <div class="w-full">

                {{-- ------------------- TAB 1: PROFIL SAYA ------------------- --}}
                <div id="panel-profil" class="space-y-6">

                    {{-- Card 1: Avatar & Nama --}}
                    <div class="rounded-3xl border border-gray-200/80 bg-white p-6 sm:p-8 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
                        <div class="flex items-center gap-5 sm:gap-6">
                            {{-- Avatar circle --}}
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#D9D9D9] flex items-center justify-center text-gray-400 shrink-0 select-none overflow-hidden">
                                <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>

                            <div>
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-snug" id="display-fullname">
                                    Haidar Rafi Kosong Enam
                                </h2>
                                <p class="text-xs sm:text-sm text-gray-500 font-medium mt-1">
                                    Admin KAI Aset
                                </p>
                            </div>
                        </div>

                        <div>
                            <button
                                type="button"
                                onclick="openEditProfileModal()"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-medium text-white shadow-xs transition cursor-pointer"
                            >
                                <x-icon name="edit-detail-peta" class="w-4 h-4" />
                                <span>Edit</span>
                            </button>
                        </div>
                    </div>

                    {{-- Card 2: Informasi Profil --}}
                    <div class="rounded-3xl border border-gray-200/80 bg-white p-6 sm:p-8 shadow-xs space-y-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <h3 class="text-base sm:text-lg font-bold text-gray-900">
                                Informasi Profil
                            </h3>
                            <button
                                type="button"
                                onclick="openEditProfileModal()"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-medium text-white shadow-xs transition cursor-pointer"
                            >
                                <x-icon name="edit-detail-peta" class="w-4 h-4" />
                                <span>Edit</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8 pt-2">
                            {{-- Nama Awal --}}
                            <div>
                                <span class="block text-xs font-medium text-gray-400 mb-1.5">Nama Awal</span>
                                <span class="block text-sm sm:text-[15px] font-semibold text-gray-900" id="display-first-name">
                                    Haidar Rafi
                                </span>
                            </div>

                            {{-- Nama Akhir --}}
                            <div>
                                <span class="block text-xs font-medium text-gray-400 mb-1.5">Nama Akhir</span>
                                <span class="block text-sm sm:text-[15px] font-semibold text-gray-900" id="display-last-name">
                                    Kosong Enam
                                </span>
                            </div>

                            {{-- Alamat Email --}}
                            <div class="sm:col-span-2">
                                <span class="block text-xs font-medium text-gray-400 mb-1.5">Alamat Email</span>
                                <span class="block text-sm sm:text-[15px] font-semibold text-gray-900" id="display-email">
                                    admin.kai@daop4.com
                                </span>
                            </div>
                        </div>
                    </div>

                </div>


                {{-- ------------------- TAB 2: PENGAJUAN RESET SANDI ------------------- --}}
                <div id="panel-reset-sandi" class="hidden">
                    <div class="rounded-3xl border border-gray-200/80 bg-white p-6 sm:p-10 shadow-xs space-y-6 max-w-3xl">
                        
                        {{-- Title --}}
                        <h2 class="text-2xl sm:text-[30px] font-bold text-gray-950 tracking-tight leading-tight">
                            Pengajuan Ubah Kata Sandi
                        </h2>

                        {{-- Description per Desain Figma --}}
                        <p class="text-xs sm:text-sm text-gray-600 font-normal leading-relaxed">
                            Ajukan Reset Kata Sandi login aplikasi Tracker APP, ingat pengajuan kata sandi menunggu persetujuan dari superadmin selama 1x24 jam, jika belum di setujui silahkan cek email untuk mendapatkan kata sandi sementara untuk login dan untuk pengubahan kata sandi
                        </p>

                        {{-- Buttons: Batal & Ajukan Perubahan Kata Sandi --}}
                        <div class="flex items-center gap-3 pt-4">
                            {{-- Tombol Batal --}}
                            <button
                                type="button"
                                onclick="switchAdminTab('profil')"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-[8px] bg-[#E00000] hover:bg-red-700 text-xs sm:text-sm font-medium text-white transition shadow-xs cursor-pointer"
                            >
                                <span>✕</span>
                                <span>Batal</span>
                            </button>

                            {{-- Tombol Ajukan Perubahan Kata Sandi --}}
                            <button
                                type="button"
                                onclick="submitResetRequest()"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-medium text-white transition shadow-xs cursor-pointer"
                            >
                                <span>✓</span>
                                <span>Ajukan Perubahan Kata Sandi</span>
                            </button>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </main>

    {{-- ================= MODAL EDIT INFORMASI PROFIL ================= --}}
    <div id="modal-edit-profile" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-xs p-4">
        <div class="w-full max-w-md rounded-3xl bg-white p-6 sm:p-8 shadow-2xl border border-gray-100 space-y-5 animate-in fade-in zoom-in-95 duration-200">
            
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="text-lg font-bold text-gray-900">Edit Informasi Profil</h3>
                <button type="button" onclick="closeEditProfileModal()" class="text-gray-400 hover:text-gray-700 text-lg cursor-pointer">✕</button>
            </div>

            <form id="form-edit-profile" onsubmit="saveProfileChanges(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Awal</label>
                    <input
                        type="text"
                        id="input-first-name"
                        value="Haidar Rafi"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-[#0066FF] focus:outline-none transition"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Akhir</label>
                    <input
                        type="text"
                        id="input-last-name"
                        value="Kosong Enam"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-[#0066FF] focus:outline-none transition"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Alamat Email</label>
                    <input
                        type="email"
                        id="input-email"
                        value="admin.kai@daop4.com"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-[#0066FF] focus:outline-none transition"
                        required
                    >
                </div>

                <div class="flex items-center justify-end gap-3 pt-3">
                    <button
                        type="button"
                        onclick="closeEditProfileModal()"
                        class="px-5 py-2.5 rounded-[8px] border border-gray-200 text-xs sm:text-sm font-medium text-gray-600 hover:bg-gray-50 transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 text-xs sm:text-sm font-medium text-white transition shadow-xs cursor-pointer"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- Scripts untuk Tab Switching & Modal --}}
    <script>
        function switchAdminTab(tabName) {
            const btnProfil = document.getElementById('tab-btn-profil');
            const btnReset = document.getElementById('tab-btn-reset-sandi');
            const panelProfil = document.getElementById('panel-profil');
            const panelReset = document.getElementById('panel-reset-sandi');

            const activeClass = "shrink-0 text-left text-sm font-semibold transition cursor-pointer text-[#0066FF] px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-blue-50 lg:bg-transparent";
            const inactiveClass = "shrink-0 text-left text-sm font-medium transition cursor-pointer text-gray-400 hover:text-gray-700 px-4 py-2 lg:px-0 lg:py-0 rounded-full lg:rounded-none bg-gray-100/80 lg:bg-transparent";

            if (tabName === 'profil') {
                btnProfil.className = activeClass;
                btnReset.className = inactiveClass;
                panelProfil.classList.remove('hidden');
                panelReset.classList.add('hidden');
            } else {
                btnProfil.className = inactiveClass;
                btnReset.className = activeClass;
                panelProfil.classList.add('hidden');
                panelReset.classList.remove('hidden');
            }
        }


        function openEditProfileModal() {
            const modal = document.getElementById('modal-edit-profile');
            if (modal) modal.classList.remove('hidden');
        }

        function closeEditProfileModal() {
            const modal = document.getElementById('modal-edit-profile');
            if (modal) modal.classList.add('hidden');
        }

        function saveProfileChanges(e) {
            e.preventDefault();
            const firstName = document.getElementById('input-first-name').value.trim();
            const lastName = document.getElementById('input-last-name').value.trim();
            const email = document.getElementById('input-email').value.trim();

            document.getElementById('display-first-name').textContent = firstName;
            document.getElementById('display-last-name').textContent = lastName;
            document.getElementById('display-fullname').textContent = `${firstName} ${lastName}`;
            document.getElementById('display-email').textContent = email;

            closeEditProfileModal();
        }

        function submitResetRequest() {
            // Frontend prototype without toast per design request
        }
    </script>

</body>
</html>
