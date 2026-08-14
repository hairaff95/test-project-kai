<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Login Admin - KAI Asset Management</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary":            "#006948",
                        "primary-dark":       "#005137",
                        "primary-light":      "#e6f4ee",
                        "background":         "#f4f8f5",
                        "surface":            "#ffffff",
                        "on-surface":         "#1a201c",
                        "on-surface-variant": "#637369",
                        "border-subtle":      "#e8eee9",
                    },
                    fontFamily: {
                        "jakarta": ["Plus Jakarta Sans", "sans-serif"],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: "Plus Jakarta Sans", sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
            line-height: 1;
        }
        .ms-filled { font-variation-settings: "FILL" 1, "wght" 400, "GRAD" 0, "opsz" 24; }

        /* Decorative background pattern */
        .bg-pattern {
            background-color: #006948;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.06) 0%, transparent 40%),
                radial-gradient(circle at 60% 80%, rgba(0,81,55,0.8) 0%, transparent 50%);
        }

        /* Input focus ring */
        .form-input:focus {
            outline: none;
            border-color: #006948;
            box-shadow: 0 0 0 3px rgba(0, 105, 72, 0.12);
        }
        .form-input { transition: border-color 0.15s, box-shadow 0.15s; }

        /* Shake animation for error */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%       { transform: translateX(-6px); }
            40%       { transform: translateX(6px); }
            60%       { transform: translateX(-4px); }
            80%       { transform: translateX(4px); }
        }
        .shake { animation: shake 0.4s ease; }
    </style>
</head>

<body class="min-h-screen flex antialiased">

    <!-- ===== LEFT PANEL (decorative) ===== -->
    <div class="hidden lg:flex lg:w-[45%] xl:w-1/2 bg-pattern flex-col justify-between p-10 xl:p-14 relative overflow-hidden">

        <!-- Decorative circles -->
        <div class="absolute top-0 right-0 w-80 h-80 bg-white/[0.03] rounded-full -translate-y-1/3 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/[0.04] rounded-full translate-y-1/3 -translate-x-1/3"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-white/[0.02] rounded-full -translate-x-1/2 -translate-y-1/2"></div>

        <!-- Logo -->
        <div class="relative z-10 flex items-center gap-3">
            <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined ms-filled text-white text-[22px]">train</span>
            </div>
            <div>
                <p class="text-white font-bold text-sm leading-tight">KAI Asset</p>
                <p class="text-white/60 text-xs">Management System</p>
            </div>
        </div>

        <!-- Center content -->
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 bg-white/10 text-white/80 text-xs font-medium px-3 py-1.5 rounded-full mb-6">
                <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                Panel Admin Aktif
            </div>
            <h1 class="text-3xl xl:text-4xl font-bold text-white leading-tight mb-4">
                Kelola Aset<br />Properti KAI<br />
                <span class="text-white/50">dengan mudah.</span>
            </h1>
            <p class="text-white/60 text-sm leading-relaxed max-w-xs">
                Platform terpusat untuk memantau, mengelola, dan menawarkan seluruh aset properti PT Kereta Api Indonesia.
            </p>

            <!-- Feature pills -->
            <div class="flex flex-wrap gap-2 mt-8">
                <span class="flex items-center gap-1.5 bg-white/10 text-white/80 text-xs px-3 py-1.5 rounded-full">
                    <span class="material-symbols-outlined ms-filled text-[13px]">map</span>
                    Peta Interaktif
                </span>
                <span class="flex items-center gap-1.5 bg-white/10 text-white/80 text-xs px-3 py-1.5 rounded-full">
                    <span class="material-symbols-outlined ms-filled text-[13px]">inventory_2</span>
                    Kelola Aset
                </span>
                <span class="flex items-center gap-1.5 bg-white/10 text-white/80 text-xs px-3 py-1.5 rounded-full">
                    <span class="material-symbols-outlined ms-filled text-[13px]">bar_chart</span>
                    Statistik
                </span>
            </div>
        </div>

        <!-- Bottom -->
        <div class="relative z-10">
            <p class="text-white/30 text-xs">© 2026 PT Kereta Api Indonesia (Persero)</p>
        </div>
    </div>

    <!-- ===== RIGHT PANEL (form) ===== -->
    <div class="flex-1 flex flex-col justify-center items-center bg-background px-6 py-12 sm:px-10">

        <!-- Mobile logo -->
        <div class="lg:hidden flex items-center gap-2 mb-8">
            <div class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined ms-filled text-white text-[20px]">train</span>
            </div>
            <div>
                <p class="text-on-surface font-bold text-sm">KAI Asset Management</p>
            </div>
        </div>

        <div class="w-full max-w-sm">

            <!-- Heading -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-on-surface">Masuk ke Panel Admin</h2>
                <p class="text-sm text-on-surface-variant mt-1.5">Masukkan kredensial akun admin Anda</p>
            </div>

            <!-- Session error -->
            @if (session('error'))
            <div id="alert-error"
                 class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3 mb-6 text-sm">
                <span class="material-symbols-outlined ms-filled text-[18px] shrink-0 mt-0.5">error</span>
                <span>{{ session('error') }}</span>
                <button onclick="this.closest('#alert-error').remove()" class="ml-auto shrink-0 text-red-400 hover:text-red-600">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                </button>
            </div>
            @endif

            <!-- Form -->
            <form id="login-form" action="{{ route('login.post') }}" method="POST" class="flex flex-col gap-5" novalidate>
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-on-surface-variant mb-1.5">
                        Email
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/50 text-[18px]">mail</span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="admin@kai.id"
                            autocomplete="email"
                            class="form-input w-full bg-white border border-border-subtle rounded-xl pl-10 pr-4 py-3
                                   text-sm text-on-surface placeholder:text-on-surface-variant/40
                                   @error('email') border-red-400 @enderror" />
                    </div>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="text-xs font-semibold text-on-surface-variant">
                            Password
                        </label>
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/50 text-[18px]">lock</span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            class="form-input w-full bg-white border border-border-subtle rounded-xl pl-10 pr-11 py-3
                                   text-sm text-on-surface placeholder:text-on-surface-variant/40
                                   @error('password') border-red-400 @enderror" />
                        <!-- Toggle visibility -->
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/50 hover:text-on-surface-variant transition">
                            <span class="material-symbols-outlined text-[18px]" id="eye-icon">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 rounded border-border-subtle text-primary focus:ring-primary focus:ring-1 cursor-pointer" />
                        <span class="text-sm text-on-surface-variant">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-primary hover:text-primary-dark font-medium transition">
                        Lupa password?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit" id="btn-submit"
                    class="w-full bg-primary hover:bg-primary-dark text-white font-semibold text-sm
                           py-3 rounded-xl flex items-center justify-center gap-2
                           shadow-sm transition active:scale-[0.98]">
                    <span id="btn-label">Masuk</span>
                    <span class="material-symbols-outlined text-[18px]" id="btn-icon">arrow_forward</span>
                    <!-- Spinner (hidden) -->
                    <svg id="btn-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                </button>

            </form>

            <!-- Divider -->
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-border-subtle"></div>
                <span class="text-xs text-on-surface-variant/50">atau</span>
                <div class="flex-1 h-px bg-border-subtle"></div>
            </div>

            <!-- Back to public -->
            <a href="{{ route('assets.index') }}"
               class="w-full flex items-center justify-center gap-2 border border-border-subtle bg-white
                      hover:bg-primary-light hover:border-primary text-on-surface-variant hover:text-primary
                      font-medium text-sm py-3 rounded-xl transition">
                <span class="material-symbols-outlined text-[18px]">map</span>
                Lihat Peta Aset Publik
            </a>

            <p class="text-center text-xs text-on-surface-variant/60 mt-8">
                Akses terbatas untuk pegawai KAI yang berwenang.<br />
                Hubungi IT KAI untuk permintaan akun.
            </p>
        </div>
    </div>

    <script>
        /* Toggle password visibility */
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        /* Loading state on submit */
        document.getElementById('login-form').addEventListener('submit', function (e) {
            const email    = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            if (!email || !password) {
                document.getElementById('login-form').classList.add('shake');
                setTimeout(() => document.getElementById('login-form').classList.remove('shake'), 500);
                e.preventDefault();
                return;
            }

            const btn     = document.getElementById('btn-submit');
            const label   = document.getElementById('btn-label');
            const icon    = document.getElementById('btn-icon');
            const spinner = document.getElementById('btn-spinner');

            btn.disabled  = true;
            label.textContent = 'Memverifikasi...';
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');
        });
    </script>

</body>
</html>
