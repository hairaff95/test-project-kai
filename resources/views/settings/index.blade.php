@extends('layouts.app')

@section('title', 'Pengaturan — Persetujuan Reset Sandi')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb & Title --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-1.5 text-xs sm:text-[13px] text-gray-400 mb-1">
                <span>Dashboard</span>
                <span>/</span>
                <span class="text-[#0066FF] font-medium">Pengaturan</span>
            </div>
            <h1 class="text-2xl sm:text-[28px] font-bold text-gray-900 tracking-tight">
                Persetujuan Reset Sandi Admin
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Kelola dan setujui permohonan perubahan kata sandi dari akun Admin untuk pengiriman kode verifikasi OTP.
            </p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rounded-2xl border border-gray-200/80 bg-white p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium">Menunggu Persetujuan</p>
                <p class="text-2xl font-bold text-amber-500 mt-1" id="count-pending">2</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">
                ⏳
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200/80 bg-white p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium">Disetujui (OTP Terkirim)</p>
                <p class="text-2xl font-bold text-green-600 mt-1" id="count-approved">5</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-green-50 text-green-600 flex items-center justify-center font-bold text-lg">
                ✓
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200/80 bg-white p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium">Ditolak</p>
                <p class="text-2xl font-bold text-red-500 mt-1">1</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-red-50 text-red-500 flex items-center justify-center font-bold text-lg">
                ✕
            </div>
        </div>
    </div>

    {{-- Request Table Card --}}
    <div class="rounded-2xl border border-gray-200/80 bg-white shadow-xs overflow-hidden">
        <div class="px-6 py-4.5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm sm:text-base font-bold text-gray-900">
                Daftar Permohonan Reset Kata Sandi
            </h2>
            <span class="text-xs text-gray-400">Super Admin Authorization</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-gray-700">
                <thead class="bg-gray-50 text-[11px] font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200/70">
                    <tr>
                        <th class="py-3 px-6">Nama Admin & Email</th>
                        <th class="py-3 px-6">Wilayah / Unit</th>
                        <th class="py-3 px-6">Waktu Pengajuan</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6 text-right">Aksi Persetujuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="requests-tbody">
                    {{-- Row 1: Pending --}}
                    <tr class="hover:bg-gray-50/70 transition" id="row-1">
                        <td class="py-4 px-6">
                            <div class="font-semibold text-gray-900">Bambang Sudarsono</div>
                            <div class="text-xs text-gray-400 mt-0.5">bambang.admin@kai.id</div>
                        </td>
                        <td class="py-4 px-6 text-gray-600">Daop 4 Semarang</td>
                        <td class="py-4 px-6 text-gray-500 text-xs">Hari ini, 14:15 WIB</td>
                        <td class="py-4 px-6" id="status-badge-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu Persetujuan
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right" id="action-cell-1">
                            <div class="inline-flex items-center gap-2">
                                <button
                                    type="button"
                                    onclick="approveRequest(1, 'Bambang Sudarsono', 'bambang.admin@kai.id')"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-[#0066FF] hover:bg-blue-700 text-xs font-medium text-white shadow-2xs transition cursor-pointer"
                                >
                                    <span>✓</span>
                                    <span>Setujui & Kirim OTP</span>
                                </button>
                                <button
                                    type="button"
                                    onclick="rejectRequest(1)"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-red-50 text-xs font-medium text-red-600 transition cursor-pointer"
                                >
                                    <span>Tolak</span>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 2: Pending --}}
                    <tr class="hover:bg-gray-50/70 transition" id="row-2">
                        <td class="py-4 px-6">
                            <div class="font-semibold text-gray-900">Siti Rahmawati</div>
                            <div class="text-xs text-gray-400 mt-0.5">siti.rahmawati@kai.id</div>
                        </td>
                        <td class="py-4 px-6 text-gray-600">Daop 1 Jakarta</td>
                        <td class="py-4 px-6 text-gray-500 text-xs">Hari ini, 11:30 WIB</td>
                        <td class="py-4 px-6" id="status-badge-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu Persetujuan
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right" id="action-cell-2">
                            <div class="inline-flex items-center gap-2">
                                <button
                                    type="button"
                                    onclick="approveRequest(2, 'Siti Rahmawati', 'siti.rahmawati@kai.id')"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-[#0066FF] hover:bg-blue-700 text-xs font-medium text-white shadow-2xs transition cursor-pointer"
                                >
                                    <span>✓</span>
                                    <span>Setujui & Kirim OTP</span>
                                </button>
                                <button
                                    type="button"
                                    onclick="rejectRequest(2)"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-red-50 text-xs font-medium text-red-600 transition cursor-pointer"
                                >
                                    <span>Tolak</span>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 3: Already Approved --}}
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="py-4 px-6">
                            <div class="font-semibold text-gray-900">Haidar Rasyid</div>
                            <div class="text-xs text-gray-400 mt-0.5">haidar.admin@kai.id</div>
                        </td>
                        <td class="py-4 px-6 text-gray-600">Pusat Komersial Aset</td>
                        <td class="py-4 px-6 text-gray-500 text-xs">Kemarin, 09:20 WIB</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Disetujui (OTP Aktif)
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right text-xs text-gray-400">
                            Selesai diproses
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Notification Modal / Toast --}}
<div id="toast-modal" class="hidden fixed bottom-6 right-6 z-[100] max-w-sm rounded-2xl bg-gray-900 text-white p-4 shadow-xl border border-gray-800 transition-all duration-300 transform translate-y-4 opacity-0">
    <div class="flex items-start gap-3">
        <div class="w-7 h-7 rounded-lg bg-green-500/20 text-green-400 flex items-center justify-center font-bold text-sm shrink-0">
            ✓
        </div>
        <div>
            <p class="text-xs font-semibold text-white" id="toast-title">Persetujuan Berhasil</p>
            <p class="text-[11px] text-gray-300 mt-0.5" id="toast-msg">Kode OTP verifikasi telah dikirimkan ke email admin terkait.</p>
        </div>
    </div>
</div>

<script>
    function showToast(title, msg) {
        const toast = document.getElementById('toast-modal');
        const tTitle = document.getElementById('toast-title');
        const tMsg = document.getElementById('toast-msg');

        if (toast && tTitle && tMsg) {
            tTitle.textContent = title;
            tMsg.textContent = msg;
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.remove('translate-y-4', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-4', 'opacity-0');
                setTimeout(() => toast.classList.add('hidden'), 300);
            }, 4000);
        }
    }

    function approveRequest(id, name, email) {
        const badge = document.getElementById(`status-badge-${id}`);
        const actionCell = document.getElementById(`action-cell-${id}`);

        if (badge) {
            badge.innerHTML = `
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200/60">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    Disetujui (OTP Terkirim)
                </span>
            `;
        }

        if (actionCell) {
            actionCell.innerHTML = `
                <span class="text-xs text-green-600 font-medium">OTP: 849201 terkirim ke ${email}</span>
            `;
        }

        const pendingEl = document.getElementById('count-pending');
        const approvedEl = document.getElementById('count-approved');
        if (pendingEl) pendingEl.textContent = Math.max(0, parseInt(pendingEl.textContent) - 1);
        if (approvedEl) approvedEl.textContent = parseInt(approvedEl.textContent) + 1;

        showToast('Permohonan Disetujui', `Kode OTP 6-digit berhasil dikirimkan ke email ${email}.`);
    }

    function rejectRequest(id) {
        const badge = document.getElementById(`status-badge-${id}`);
        const actionCell = document.getElementById(`action-cell-${id}`);

        if (badge) {
            badge.innerHTML = `
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200/60">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                    Ditolak
                </span>
            `;
        }

        if (actionCell) {
            actionCell.innerHTML = `
                <span class="text-xs text-red-500">Permohonan ditolak</span>
            `;
        }

        const pendingEl = document.getElementById('count-pending');
        if (pendingEl) pendingEl.textContent = Math.max(0, parseInt(pendingEl.textContent) - 1);

        showToast('Permohonan Ditolak', 'Permohonan reset kata sandi admin telah ditolak.');
    }
</script>
@endsection
