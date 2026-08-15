@extends('layout.app')

@section('title', 'Manajemen Pengguna — Super Admin KAI Daop 4')

@section('content')
    <div class="w-full max-w-full overflow-x-hidden px-4 sm:px-6 py-6 sm:py-8 pb-32 sm:pb-12 space-y-6 sm:space-y-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">Akses Super Administrator</span>
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-950 tracking-tight">
                    Manajemen Pengguna & Admin
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Kelola hak akses pengguna, tambah staf admin, atur status aktif, dan fitur kick session.
                </p>
            </div>

            <button onclick="openModal('modal-create')"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-sm font-semibold transition min-h-[44px] self-start sm:self-auto">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                <span>Tambah Admin Baru</span>
            </button>
        </div>

        {{-- Users Container --}}
        <div class="space-y-4">
            {{-- Desktop Table --}}
            <div class="hidden md:block border-t border-b border-gray-200 bg-white overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead
                        class="bg-gray-50/80 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4">Nama Lengkap & Email</th>
                            <th class="px-6 py-4">Username</th>
                            <th class="px-6 py-4">Role Akses</th>
                            <th class="px-6 py-4">Status Akun</th>
                            <th class="px-6 py-4 text-right">Aksi Kelola</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $u)
                            <tr class="hover:bg-gray-50/60 transition">

                                {{-- Name & Email --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 leading-tight">{{ $u->name }}</div>
                                            <div class="text-xs text-gray-400 mt-0.5">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Username --}}
                                <td class="px-6 py-4 font-mono text-xs font-semibold text-gray-700">
                                    {{ $u->username }}
                                </td>

                                {{-- Role --}}
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider
                                          {{ $u->role === 'superadmin' ? 'bg-purple-100 text-purple-800' : ($u->role === 'admin' ? 'bg-orange-100 text-primary' : 'bg-gray-100 text-gray-700') }}">
                                        {{ $u->role }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if($u->is_active)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-1.5">

                                        {{-- Edit Button --}}
                                        <button
                                            onclick="openEditModal({{ $u->id }}, '{{ addslashes($u->username) }}', '{{ addslashes($u->name) }}', '{{ addslashes($u->email) }}', '{{ $u->role }}', {{ $u->is_active ? 'true' : 'false' }})"
                                            class="p-2 rounded-lg bg-gray-50 hover:bg-orange-50 text-gray-600 hover:text-primary border border-gray-200 transition"
                                            title="Edit Pengguna">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>

                                        @if($u->id !== auth()->id())
                                            {{-- Kick Session Button --}}
                                            <form method="POST" action="{{ route('admin.users.kick', $u->id) }}"
                                                onsubmit="return confirm('Kick pengguna {{ $u->name }}? Sesi login aktif akan dihapus dan akun dinonaktifkan.')"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 rounded-lg bg-gray-50 hover:bg-amber-50 text-gray-600 hover:text-amber-700 border border-gray-200 transition"
                                                    title="Kick & Nonaktifkan">
                                                    <i data-lucide="user-x" class="w-4 h-4"></i>
                                                </button>
                                            </form>

                                            {{-- Delete Button --}}
                                            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}"
                                                onsubmit="return confirm('Hapus akun {{ $u->name }} secara permanen?')"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 rounded-lg bg-gray-50 hover:bg-red-50 text-gray-600 hover:text-red-600 border border-gray-200 transition"
                                                    title="Hapus Pengguna">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    <i data-lucide="users" class="w-8 h-8 mx-auto mb-2 text-gray-300"></i>
                                    <p class="font-semibold text-gray-600 text-sm">Tidak ada data pengguna</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile List --}}
            <div class="md:hidden divide-y divide-gray-200 border-t border-b border-gray-200 bg-white">
                @forelse($users as $u)
                    <div class="px-5 sm:px-6 py-4.5 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 leading-tight text-sm">{{ $u->name }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $u->email }}</div>
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                  {{ $u->role === 'superadmin' ? 'bg-purple-100 text-purple-800' : ($u->role === 'admin' ? 'bg-orange-100 text-primary' : 'bg-gray-100 text-gray-700') }}">
                                {{ $u->role }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400 font-mono">{{ $u->username }}</span>
                                <span class="text-gray-300">·</span>
                                @if($u->is_active)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-red-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center gap-1.5">
                                <button
                                    onclick="openEditModal({{ $u->id }}, '{{ addslashes($u->username) }}', '{{ addslashes($u->name) }}', '{{ addslashes($u->email) }}', '{{ $u->role }}', {{ $u->is_active ? 'true' : 'false' }})"
                                    class="p-2 rounded-lg bg-gray-50 hover:bg-orange-50 text-gray-600 hover:text-primary border border-gray-200 transition"
                                    title="Edit">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>

                                @if($u->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.kick', $u->id) }}"
                                        onsubmit="return confirm('Kick pengguna {{ $u->name }}?')" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="p-2 rounded-lg bg-gray-50 hover:bg-amber-50 text-gray-600 hover:text-amber-700 border border-gray-200 transition"
                                            title="Kick">
                                            <i data-lucide="user-x" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}"
                                        onsubmit="return confirm('Hapus akun {{ $u->name }}?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 rounded-lg bg-gray-50 hover:bg-red-50 text-gray-600 hover:text-red-600 border border-gray-200 transition"
                                            title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-400">
                        <i data-lucide="users" class="w-8 h-8 mx-auto mb-2 text-gray-300"></i>
                        <p class="font-semibold text-gray-600 text-sm">Tidak ada data pengguna</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Modal: Tambah User --}}
    <div id="modal-create" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h2 class="font-bold text-gray-900 text-base flex items-center gap-2">
                    <i data-lucide="user-plus" class="w-4 h-4 text-primary"></i>
                    <span>Tambah Admin Baru</span>
                </h2>
                <button onclick="closeModal('modal-create')" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-3.5">
                @csrf
                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Username *</label>
                    <input type="text" name="username" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:bg-white focus:border-primary outline-none transition">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Nama Lengkap
                        *</label>
                    <input type="text" name="name" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:bg-white focus:border-primary outline-none transition">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Alamat Email
                        *</label>
                    <input type="email" name="email" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:bg-white focus:border-primary outline-none transition">
                </div>

                {{-- Role Dropdown --}}
                <div class="relative" x-data="{ 
                    open: false, 
                    selected: 'admin',
                    options: {
                        'admin': { label: 'Admin Daop 4', icon: 'shield' },
                        'user':  { label: 'User Biasa', icon: 'user' }
                    }
                }" @click.outside="open = false">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Peran / Role
                        *</label>
                    <input type="hidden" name="role" :value="selected">

                    <button type="button" @click="open = !open"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 flex items-center justify-between focus:bg-white focus:border-primary transition">
                        <div class="flex items-center gap-2">
                            <i :data-lucide="options[selected].icon" class="w-4 h-4 text-primary"></i>
                            <span x-text="options[selected].label" class="font-medium"></span>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 transition-transform"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="absolute top-full left-0 right-0 mt-1.5 bg-white border border-gray-200 rounded-2xl shadow-xl p-1.5 z-50">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-3 py-1.5">HAK AKSES</p>
                        <template x-for="(opt, key) in options" :key="key">
                            <button type="button"
                                @click="selected = key; open = false; $nextTick(() => lucide.createIcons())"
                                :class="selected === key ? 'bg-primary-light text-primary font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs sm:text-sm transition">
                                <i :data-lucide="opt.icon" :class="selected === key ? 'text-primary' : 'text-gray-400'"
                                    class="w-4 h-4"></i>
                                <span x-text="opt.label"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Password * (Min. 8
                        Karakter)</label>
                    <input type="password" name="password" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:bg-white focus:border-primary outline-none transition">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Konfirmasi Password
                        *</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:bg-white focus:border-primary outline-none transition">
                </div>

                <div class="flex gap-2 pt-3">
                    <button type="submit"
                        class="flex-1 py-2.5 px-4 rounded-xl bg-primary hover:bg-primary-hover text-white text-sm font-semibold shadow-sm transition">
                        Simpan Admin
                    </button>
                    <button type="button" onclick="closeModal('modal-create')"
                        class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Edit User --}}
    <div id="modal-edit" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h2 class="font-bold text-gray-900 text-base flex items-center gap-2">
                    <i data-lucide="edit" class="w-4 h-4 text-primary"></i>
                    <span>Edit Data Pengguna</span>
                </h2>
                <button onclick="closeModal('modal-edit')" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="edit-form" method="POST" class="space-y-3.5">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Username *</label>
                    <input type="text" id="edit-username" name="username" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:bg-white focus:border-primary outline-none transition">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Nama Lengkap
                        *</label>
                    <input type="text" id="edit-name" name="name" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:bg-white focus:border-primary outline-none transition">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Alamat Email
                        *</label>
                    <input type="email" id="edit-email" name="email" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:bg-white focus:border-primary outline-none transition">
                </div>

                {{-- Role Dropdown in Edit Modal --}}
                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Peran / Role
                        *</label>
                    <select id="edit-role" name="role" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:bg-white focus:border-primary outline-none transition">
                        <option value="admin">Admin Daop 4</option>
                        <option value="user">User Biasa</option>
                    </select>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="edit-active" name="is_active" value="1"
                        class="w-4 h-4 rounded text-primary focus:ring-primary border-gray-300">
                    <label for="edit-active" class="text-xs font-semibold text-gray-700 cursor-pointer">Status Akun
                        Aktif</label>
                </div>

                <div class="pt-2 border-t border-gray-100">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">
                        Ganti Password <span class="text-gray-400 font-normal lowercase">(kosongkan jika tidak
                            diubah)</span>
                    </label>
                    <input type="password" name="password" placeholder="Password baru..."
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:bg-white focus:border-primary outline-none transition">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Konfirmasi Password
                        Baru</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru..."
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-900 focus:bg-white focus:border-primary outline-none transition">
                </div>

                <div class="flex gap-2 pt-3">
                    <button type="submit"
                        class="flex-1 py-2.5 px-4 rounded-xl bg-primary hover:bg-primary-hover text-white text-sm font-semibold shadow-sm transition">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeModal('modal-edit')"
                        class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openModal(id) {
            const el = document.getElementById(id);
            el.classList.remove('hidden');
            el.classList.add('flex');
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            el.classList.add('hidden');
            el.classList.remove('flex');
        }

        function openEditModal(id, username, name, email, role, isActive) {
            document.getElementById('edit-form').action = `/admin/users/${id}`;
            document.getElementById('edit-username').value = username;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-role').value = role;
            document.getElementById('edit-active').checked = isActive;
            openModal('modal-edit');
        }

        ['modal-create', 'modal-edit'].forEach(id => {
            const modal = document.getElementById(id);
            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === this) closeModal(id);
                });
            }
        });
    </script>
@endpush