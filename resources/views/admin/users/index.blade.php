<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manajemen Pengguna — Super Admin KAI Daop 4</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = { theme: { extend: {
            colors: { "primary":"#006948","primary-dark":"#005137","primary-light":"#e6f4ee","background":"#f4f8f5","surface":"#ffffff","on-surface":"#1a201c","on-surface-variant":"#637369","border-subtle":"#e8eee9","danger":"#dc2626","danger-light":"#fee2e2" },
            fontFamily: { "jakarta":["Plus Jakarta Sans","sans-serif"] }
        }}}
    </script>
    <style>
        body { font-family:"Plus Jakarta Sans",sans-serif; }
        .material-symbols-outlined { font-variation-settings:"FILL" 0,"wght" 400,"GRAD" 0,"opsz" 24; line-height:1; }
        .modal { display:none; } .modal.open { display:flex; }
        label.modal-label { font-size: 0.8rem; font-weight: 600; color: #3d4a42; display:block; margin-bottom:0.3rem; }
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen">

<x-sidebar />

<main class="pl-4 pr-4 sm:pl-28 sm:pr-6 md:pl-32 md:pr-8 pt-8 pb-16 min-h-screen max-w-5xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-primary mb-1">Super Admin · KAI Daop 4</p>
            <h1 class="text-2xl md:text-3xl font-bold">Manajemen Pengguna</h1>
        </div>
        <button onclick="openModal('modal-create')"
            class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-full font-semibold text-sm hover:bg-primary-dark transition shadow-md">
            <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">person_add</span>
            Tambah Admin
        </button>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-base">check_circle</span>{{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 bg-danger-light border border-red-200 text-danger rounded-xl px-4 py-3 text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-base">error</span>{{ session('error') }}
    </div>
    @endif

    {{-- Tabel User --}}
    <div class="bg-white rounded-2xl border border-border-subtle shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-background border-b border-border-subtle">
                    <tr>
                        <th class="text-left px-5 py-3.5 font-semibold text-on-surface-variant text-xs uppercase tracking-wide">Pengguna</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-on-surface-variant text-xs uppercase tracking-wide">Username</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-on-surface-variant text-xs uppercase tracking-wide">Role</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-on-surface-variant text-xs uppercase tracking-wide">Status</th>
                        <th class="text-right px-5 py-3.5 font-semibold text-on-surface-variant text-xs uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle">
                    @forelse($users as $u)
                    @php
                        $isMe = $u->id === auth()->id();
                        $roleClr = match($u->role) {
                            'superadmin' => 'bg-purple-100 text-purple-700',
                            'admin'      => 'bg-primary-light text-primary',
                            default      => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <tr class="hover:bg-background/60 transition">
                        <td class="px-5 py-4">
                            <div>
                                <p class="font-semibold text-on-surface">{{ $u->name }} @if($isMe)<span class="text-xs text-on-surface-variant font-normal">(Anda)</span>@endif</p>
                                <p class="text-xs text-on-surface-variant">{{ $u->email }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-4 font-mono text-xs text-on-surface-variant">{{ $u->username }}</td>
                        <td class="px-4 py-4">
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full {{ $roleClr }}">{{ strtoupper($u->role) }}</span>
                        </td>
                        <td class="px-4 py-4">
                            @if($u->is_active)
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700">Aktif</span>
                            @else
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-500">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right">
                            @if(!$isMe && $u->role !== 'superadmin')
                            <div class="flex items-center justify-end gap-2">
                                {{-- Edit --}}
                                <button onclick="openEditModal({{ $u->id }}, '{{ $u->username }}', '{{ addslashes($u->name) }}', '{{ $u->email }}', '{{ $u->role }}', {{ $u->is_active ? 'true' : 'false' }})"
                                    class="p-1.5 rounded-lg hover:bg-primary-light text-on-surface-variant hover:text-primary transition" title="Edit">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </button>
                                {{-- Kick --}}
                                @if($u->is_active)
                                <form method="POST" action="{{ route('admin.users.kick', $u) }}"
                                    onsubmit="return confirm('Kick & nonaktifkan «{{ $u->name }}»? Session aktifnya akan langsung dicabut.')">
                                    @csrf
                                    <button type="submit" title="Kick / Nonaktifkan"
                                        class="p-1.5 rounded-lg hover:bg-amber-100 text-on-surface-variant hover:text-amber-600 transition">
                                        <span class="material-symbols-outlined text-lg">person_off</span>
                                    </button>
                                </form>
                                @endif
                                {{-- Delete --}}
                                <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                                    onsubmit="return confirm('Hapus permanen akun «{{ $u->name }}»?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus"
                                        class="p-1.5 rounded-lg hover:bg-danger-light text-on-surface-variant hover:text-danger transition">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-xs text-on-surface-variant italic">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-16 text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl block mb-2">group</span>
                            Belum ada pengguna.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

{{-- Modal: Tambah User --}}
<div id="modal-create" class="modal fixed inset-0 bg-black/40 backdrop-blur-sm z-50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-5">
            <h2 class="font-bold text-on-surface text-lg">Tambah Admin Baru</h2>
            <button onclick="closeModal('modal-create')" class="text-on-surface-variant hover:text-on-surface">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}" class="flex flex-col gap-4">
            @csrf
            <div>
                <label class="modal-label">Username *</label>
                <input type="text" name="username" required class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
            </div>
            <div>
                <label class="modal-label">Nama Lengkap *</label>
                <input type="text" name="name" required class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
            </div>
            <div>
                <label class="modal-label">Email *</label>
                <input type="email" name="email" required class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
            </div>
            <div>
                <label class="modal-label">Role *</label>
                <select name="role" required class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div>
                <label class="modal-label">Password * (min. 8 karakter)</label>
                <input type="password" name="password" required class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
            </div>
            <div>
                <label class="modal-label">Konfirmasi Password *</label>
                <input type="password" name="password_confirmation" required class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
            </div>
            <div class="flex gap-3 mt-2">
                <button type="submit" class="flex-1 bg-primary text-white py-2.5 rounded-full font-semibold text-sm hover:bg-primary-dark transition">Simpan</button>
                <button type="button" onclick="closeModal('modal-create')" class="flex-1 border border-border-subtle text-on-surface-variant py-2.5 rounded-full font-semibold text-sm hover:bg-background transition">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal: Edit User --}}
<div id="modal-edit" class="modal fixed inset-0 bg-black/40 backdrop-blur-sm z-50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-5">
            <h2 class="font-bold text-on-surface text-lg">Edit Pengguna</h2>
            <button onclick="closeModal('modal-edit')" class="text-on-surface-variant hover:text-on-surface">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="edit-form" method="POST" class="flex flex-col gap-4">
            @csrf @method('PUT')
            <div>
                <label class="modal-label">Username *</label>
                <input type="text" id="edit-username" name="username" required class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
            </div>
            <div>
                <label class="modal-label">Nama Lengkap *</label>
                <input type="text" id="edit-name" name="name" required class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
            </div>
            <div>
                <label class="modal-label">Email *</label>
                <input type="email" id="edit-email" name="email" required class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
            </div>
            <div>
                <label class="modal-label">Role *</label>
                <select id="edit-role" name="role" required class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" id="edit-active" name="is_active" value="1" class="rounded border-border-subtle text-primary focus:ring-primary" />
                <label for="edit-active" class="modal-label mb-0 !font-normal cursor-pointer">Akun aktif</label>
            </div>
            <div>
                <label class="modal-label">Password Baru <span class="font-normal text-on-surface-variant">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
            </div>
            <div>
                <label class="modal-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full rounded-xl border-border-subtle text-sm focus:ring-primary focus:border-primary" />
            </div>
            <div class="flex gap-3 mt-2">
                <button type="submit" class="flex-1 bg-primary text-white py-2.5 rounded-full font-semibold text-sm hover:bg-primary-dark transition">Simpan</button>
                <button type="button" onclick="closeModal('modal-edit')" class="flex-1 border border-border-subtle text-on-surface-variant py-2.5 rounded-full font-semibold text-sm hover:bg-background transition">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    function openEditModal(id, username, name, email, role, isActive) {
        document.getElementById('edit-form').action = `/admin/users/${id}`;
        document.getElementById('edit-username').value = username;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-role').value = role;
        document.getElementById('edit-active').checked = isActive;
        openModal('modal-edit');
    }

    // Tutup modal saat klik backdrop
    ['modal-create','modal-edit'].forEach(id => {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) closeModal(id);
        });
    });
</script>
</body>
</html>
