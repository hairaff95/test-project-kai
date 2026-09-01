<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'KAI Daop 4 Semarang — Property Asset Tracker')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: '#F37021',
                        'primary-hover': '#d45f0e',
                        'primary-light': '#fef0e6',
                        'primary-border': '#fcd7c0',
                        kai: {
                            orange: '#F37021',
                            blue: '#2D2A70',
                            gray: '#F8F9FA'
                        },
                        surface: '#FFFFFF',
                        bgbase: '#F8F8F6',
                        borderbase: '#E5E7EB',
                        textmain: '#1A1A1A',
                        textmuted: '#6B7280',
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Disable visible scrollbars globally for 100% stable viewport width */
        *, html, body, div, span, nav, ul, li {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }
        *::-webkit-scrollbar,
        html::-webkit-scrollbar,
        body::-webkit-scrollbar,
        div::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            background: transparent !important;
        }

        html {
            overflow-y: auto;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8F8F6;
            color: #1A1A1A;
            -webkit-overflow-scrolling: touch;
        }

        /* Safe Area Inset Variables & Utilities (Notch / Dynamic Island / Home Indicator) */
        :root {
            --sat: env(safe-area-inset-top, 0px);
            --sab: env(safe-area-inset-bottom, 0px);
            --sal: env(safe-area-inset-left, 0px);
            --sar: env(safe-area-inset-right, 0px);
        }
        .pt-safe { padding-top: env(safe-area-inset-top, 0px); }
        .pb-safe { padding-bottom: env(safe-area-inset-bottom, 0px); }
        .pl-safe { padding-left: env(safe-area-inset-left, 0px); }
        .pr-safe { padding-right: env(safe-area-inset-right, 0px); }
        .p-safe {
            padding-top: env(safe-area-inset-top, 0px);
            padding-bottom: env(safe-area-inset-bottom, 0px);
            padding-left: env(safe-area-inset-left, 0px);
            padding-right: env(safe-area-inset-right, 0px);
        }
        .bottom-safe {
            bottom: calc(1rem + env(safe-area-inset-bottom, 0px));
        }

        /* Lucide icon alignment */
        [data-lucide] {
            display: inline-block;
            vertical-align: middle;
            stroke-width: 1.75;
        }

        /* Leaflet Map Containment */
        .leaflet-container {
            font-family: 'Plus Jakarta Sans', sans-serif;
            z-index: 1 !important;
        }
        .leaflet-pane {
            z-index: 1 !important;
        }
        .leaflet-top,
        .leaflet-bottom {
            z-index: 2 !important;
        }
        .leaflet-control {
            z-index: 2 !important;
        }
    </style>

    @stack('head')
</head>
<body class="bg-bgbase text-textmain antialiased min-h-full flex flex-col pl-safe pr-safe">

    @if(!request()->routeIs('login'))
        <x-navbar />
    @endif

    {{-- Flash Notifications --}}
    @if(session('success'))
    <div id="flash-toast-success" class="fixed top-[calc(5rem+env(safe-area-inset-top,0px))] right-6 z-50 flex items-center gap-3 bg-white border border-green-200 text-green-800 px-4 py-3 rounded-xl shadow-lg transition-all duration-300 text-sm font-medium">
        <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
        <span>{{ session('success') }}</span>
        <button onclick="document.getElementById('flash-toast-success').remove()" class="text-gray-400 hover:text-gray-600 ml-2">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div id="flash-toast-error" class="fixed top-[calc(5rem+env(safe-area-inset-top,0px))] right-6 z-50 flex items-center gap-3 bg-white border border-red-200 text-red-800 px-4 py-3 rounded-xl shadow-lg transition-all duration-300 text-sm font-medium">
        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
        <span>{{ session('error') }}</span>
        <button onclick="document.getElementById('flash-toast-error').remove()" class="text-gray-400 hover:text-gray-600 ml-2">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
    @endif

    <main class="flex-1 pb-[calc(7rem+env(safe-area-inset-bottom,0px))] md:pb-0">
        @yield('content')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            setTimeout(() => {
                const s = document.getElementById('flash-toast-success');
                const e = document.getElementById('flash-toast-error');
                if (s) { s.style.opacity = '0'; setTimeout(() => s.remove(), 300); }
                if (e) { e.style.opacity = '0'; setTimeout(() => e.remove(), 300); }
            }, 4000);
        });
    </script>

    @stack('scripts')
</body>
</html>
