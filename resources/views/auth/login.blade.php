@extends('layout.app')

@section('title', 'Admin & Staf Login — KAI Daop 4 Semarang')

@section('content')
    <div
        class="min-h-screen w-full bg-[#F5F1E7] text-stone-900 relative overflow-hidden flex flex-col justify-between selection:bg-orange-100 selection:text-primary">

        {{-- Top Header --}}
        <header class="w-full px-6 sm:px-10 lg:px-16 pt-6 sm:pt-8 flex items-center justify-between z-20">
            {{-- Left: Brand & Contact --}}
            <div class="space-y-1">
                <a href="{{ route('assets.index') }}" class="flex items-center gap-2 group">
                    <span class="font-extrabold text-xl sm:text-2xl tracking-tight text-stone-950">
                        KAI <span class="text-primary font-black">DAOP 4</span>
                    </span>
                </a>
                <a href="mailto:daop4.semarang@kai.id"
                    class="text-xs text-stone-500 hover:text-stone-900 flex items-center gap-1.5 transition">
                    <span>daop4.semarang@kai.id</span>
                    <i data-lucide="arrow-right"
                        class="w-3.5 h-3.5 text-stone-400 group-hover:translate-x-0.5 transition-transform"></i>
                </a>
            </div>

            {{-- Right: Globe & Action Button --}}
            <div class="flex items-center gap-4 sm:gap-6">
                <button type="button" title="Bahasa Indonesia"
                    class="hidden sm:flex items-center gap-1.5 text-xs font-semibold text-stone-600 hover:text-stone-950 transition">
                    <i data-lucide="globe" class="w-4 h-4 text-stone-500"></i>
                    <span>ID</span>
                </button>

                <a href="{{ route('assets.catalog') }}"
                    class="px-5 py-2.5 rounded-2xl bg-[#F7A867] hover:bg-[#ea934a] text-white text-xs sm:text-sm font-bold shadow-xs hover:shadow-md transition min-h-[40px] flex items-center justify-center">
                    Katalog Aset
                </a>
            </div>
        </header>


        {{-- Background Thematic Illustrations & Doodle Vector Elements --}}
        <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
            {{-- Right Side: Thematic Illustration Image with Vector Overlay --}}
            <div class="hidden lg:block absolute right-0 bottom-0 top-16 w-1/2 max-w-[700px] h-full opacity-90">
                <img src="{{ asset('images/auth-kai-bg.jpg') }}" alt="KAI Login Illustration"
                    class="w-full h-full object-contain object-right-bottom mix-blend-multiply select-none">
            </div>

            {{-- Left Side: Decorative Geometric Dotted Blocks & Wireframe Cards --}}
            <div class="hidden md:block absolute left-8 lg:left-20 bottom-16 w-72 space-y-4">

                {{-- Floating Wireframe Card 1 --}}
                <div
                    class="relative w-36 h-24 rounded-2xl border-2 border-stone-800 bg-white/60 backdrop-blur-xs p-3.5 shadow-sm transform -rotate-3 hover:rotate-0 transition">
                    <div class="w-16 h-2 rounded-full bg-stone-300 mb-2"></div>
                    <div class="w-24 h-1.5 rounded-full bg-stone-200 mb-1.5"></div>
                    <div class="w-12 h-1.5 rounded-full bg-stone-200"></div>
                    <div
                        class="absolute -top-3 -right-3 w-7 h-7 rounded-full bg-[#F7A867] border-2 border-stone-800 flex items-center justify-center">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-white"></i>
                    </div>
                </div>

                {{-- Dotted Geometric Pedestal 1 --}}
                <div class="flex items-end gap-3">
                    <div
                        class="w-20 h-36 rounded-2xl bg-[#F8D279] border-2 border-stone-800 p-2 relative overflow-hidden flex flex-col justify-between">
                        <div class="grid grid-cols-2 gap-2 opacity-80 pt-1">
                            <div class="w-2.5 h-2.5 rounded-full bg-stone-900 mx-auto"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-stone-900 mx-auto"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-stone-900 mx-auto"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-stone-900 mx-auto"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-stone-900 mx-auto"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-stone-900 mx-auto"></div>
                        </div>
                        <div class="w-full text-center">
                            <span class="text-[9px] font-black text-stone-900 tracking-tighter">DAOP 4</span>
                        </div>
                    </div>

                    {{-- Wireframe Card 2 with Arrow --}}
                    <div
                        class="w-24 h-28 rounded-2xl bg-white border-2 border-stone-800 p-2.5 flex flex-col justify-between">
                        <div class="w-full flex justify-end">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" class="text-stone-800">
                                <path d="M7 17L17 7M17 7H7M17 7V17" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <div class="w-10 h-2 rounded-full bg-[#F7A867]"></div>
                            <div class="w-14 h-1.5 rounded-full bg-stone-200"></div>
                        </div>
                    </div>
                </div>

                {{-- Hand-drawn Squiggle Curve --}}
                <svg width="120" height="40" viewBox="0 0 120 40" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" class="text-stone-800 opacity-75">
                    <path d="M5 25 C 20 5, 35 35, 50 15 C 65 -5, 80 35, 95 15 C 105 5, 115 25, 118 20" />
                </svg>
            </div>

            {{-- Floating Squiggles & Dots --}}
            <div class="absolute top-28 left-1/4 w-3 h-3 rounded-full border-2 border-stone-800 opacity-60"></div>
            <div class="absolute top-44 right-1/4 w-2 h-2 rounded-full bg-stone-800 opacity-60"></div>
            <div class="absolute bottom-32 left-1/3 w-4 h-4 rounded-full border-2 border-stone-800 opacity-40"></div>
        </div>


        {{-- Main Central Card --}}
        <main class="w-full flex items-center justify-center px-4 py-8 z-10 my-auto">
            <div
                class="w-full max-w-[430px] bg-white rounded-[32px] sm:rounded-[36px] shadow-[0_20px_50px_rgba(0,0,0,0.06)] border border-stone-200/90 p-7 sm:p-9 space-y-6">

                {{-- Card Title & Greeting --}}
                <div class="text-center space-y-2">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-stone-950 tracking-tight">
                        Agent Login
                    </h1>
                    <p class="text-xs sm:text-sm text-stone-500 max-w-xs mx-auto leading-relaxed">
                        Hey, Enter your details to get sign in to your account
                    </p>
                </div>

                {{-- Error Flash Alert --}}
                @if(session('error'))
                    <div
                        class="p-3.5 rounded-2xl bg-red-50 border border-red-200 text-xs font-semibold text-red-700 flex items-center gap-2.5">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-red-500 shrink-0"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf

                    {{-- Input 1: Enter Email / Username --}}
                    <div>
                        <div class="relative">
                            <input type="text" name="login" id="login-input" value="{{ old('login') }}" required autofocus
                                placeholder="Enter Email / Phone No"
                                class="w-full h-12 bg-white border border-stone-200 rounded-2xl pl-4 pr-11 text-sm text-stone-900 placeholder:text-stone-400 focus:border-stone-400 focus:ring-2 focus:ring-orange-100 outline-none transition">
                            <div
                                class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 rounded-full border-2 border-stone-300">
                            </div>
                        </div>
                        @error('login')
                            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input 2: Passcode with Hide/Show text toggle --}}
                    <div x-data="{ show: false }">
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="password" id="password-input" required
                                placeholder="Passcode"
                                class="w-full h-12 bg-white border border-stone-200 rounded-2xl pl-4 pr-16 text-sm text-stone-900 placeholder:text-stone-400 focus:border-stone-400 focus:ring-2 focus:ring-orange-100 outline-none transition">
                            <button type="button" @click="show = !show"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-stone-500 hover:text-stone-900 transition select-none">
                                <span x-text="show ? 'Hide' : 'Show'">Hide</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Trouble in sign in link --}}
                    <div class="pt-0.5">
                        <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Helpdesk IT KAI Daop 4, saya membutuhkan bantuan akses akun login admin.') }}"
                            target="_blank"
                            class="text-xs font-medium text-stone-800 hover:text-primary transition underline-offset-2 hover:underline">
                            Having trouble in sign in?
                        </a>
                    </div>

                    {{-- Submit CTA Button --}}
                    <button type="submit"
                        class="w-full h-12 rounded-2xl bg-[#F7A867] hover:bg-[#ea934a] text-white font-bold text-sm tracking-wide shadow-sm hover:shadow-md transition flex items-center justify-center">
                        Sign in
                    </button>
                </form>

                {{-- Demo Account Quick Fill --}}
                <div class="pt-4 border-t border-stone-100">
                    <p class="text-[11px] font-bold text-stone-400 uppercase tracking-wider text-center mb-2.5">
                        Pintasan Kredensial Demo
                    </p>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" onclick="fillCredentials('superadmin', 'superadmin123')"
                            class="p-2.5 rounded-xl border border-stone-200 bg-stone-50/70 hover:bg-orange-50 hover:border-primary/40 hover:text-primary text-xs font-semibold text-stone-700 transition flex flex-col items-center gap-0.5">
                            <span>Super Admin</span>
                            <span class="text-[10px] text-stone-400 font-normal">superadmin123</span>
                        </button>
                        <button type="button" onclick="fillCredentials('admin.daop4', 'admin123')"
                            class="p-2.5 rounded-xl border border-stone-200 bg-stone-50/70 hover:bg-orange-50 hover:border-primary/40 hover:text-primary text-xs font-semibold text-stone-700 transition flex flex-col items-center gap-0.5">
                            <span>Admin Daop 4</span>
                            <span class="text-[10px] text-stone-400 font-normal">admin123</span>
                        </button>
                    </div>
                </div>

                {{-- Bottom Request Now Link --}}
                <div class="text-center pt-2 text-xs text-stone-600">
                    <span>Don't have an account?</span>
                    <a href="{{ route('assets.index') }}"
                        class="font-bold text-stone-900 hover:text-primary transition ml-1 underline-offset-2 hover:underline">
                        Request Now
                    </a>
                </div>

            </div>
        </main>


        {{-- Footer --}}
        <footer class="w-full px-6 py-6 text-center text-xs text-stone-500 z-20">
            <span>Copyright @PT Kereta Api Indonesia (Persero) 2026</span>
            <span class="mx-2 text-stone-300">|</span>
            <a href="{{ route('faq') }}" class="hover:text-stone-900 transition">Privacy Policy</a>
        </footer>

    </div>
@endsection

@push('scripts')
    <script>
        function fillCredentials(login, pass) {
            document.getElementById('login-input').value = login;
            document.getElementById('password-input').value = pass;
        }
    </script>
@endpush