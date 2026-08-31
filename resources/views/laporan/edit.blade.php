<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Edit Laporan — KAI Tracker App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-[#F6F7F9] font-sans antialiased text-gray-900 selection:bg-blue-100 selection:text-blue-600 flex flex-col justify-between">

    {{-- Top Navbar --}}
    <x-navbar active="reports" />

    {{-- Main Content --}}
    <main class="w-full flex-1 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-10 pt-4 sm:pt-6 pb-28 lg:pb-10 flex flex-col gap-6">

        {{-- Page Header & Breadcrumbs & Action Buttons --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 shrink-0">
            <div>
                <h1 class="text-2xl sm:text-[30px] font-bold tracking-tight text-gray-950">
                    Edit Laporan
                </h1>
                <div class="flex items-center gap-1.5 text-xs sm:text-[13px] text-gray-400 mt-1">
                    <a href="{{ route('laporan.index') }}" class="hover:text-gray-600 transition">Laporan</a>
                    <span>/</span>
                    <span class="text-[#0066FF] font-medium">Edit</span>
                </div>
            </div>

            {{-- Top Right Buttons: Simpan & Batal --}}
            <div class="flex items-center gap-3">
                <button
                    type="submit"
                    form="form-edit-laporan"
                    class="inline-flex items-center gap-2 rounded-[8px] bg-[#0066FF] hover:bg-blue-700 px-5 py-2.5 text-xs sm:text-sm font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Simpan</span>
                </button>

                <a
                    href="{{ route('laporan.index') }}"
                    class="inline-flex items-center gap-2 rounded-[8px] bg-[#E60000] hover:bg-red-700 px-5 py-2.5 text-xs sm:text-sm font-medium text-white shadow-xs transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    <span>Batal</span>
                </a>
            </div>
        </div>

        {{-- Form & Grid Container --}}
        <form id="form-edit-laporan" action="{{ route('laporan.update', $contract->asset_number ?? $contract->contract_number) }}" method="POST" class="w-full">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_380px] xl:grid-cols-[1fr_420px] gap-6 items-start">

                {{-- Left Column: 2 White Cards --}}
                <div class="flex flex-col gap-6">

                    {{-- CARD 1: INFORMASI AKUN & RKA --}}
                    <div class="rounded-2xl border border-gray-100 bg-white p-6 sm:p-7 shadow-[0_4px_25px_rgba(0,0,0,0.03)]">
                        <h2 class="text-base sm:text-lg font-bold text-gray-950 mb-5">
                            Informasi Akun & RKA
                        </h2>

                        <div class="space-y-4">
                            {{-- Akun GL & No Aset 2-Cols --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-800 mb-1.5">
                                        Akun GL<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="akun_gl"
                                        value="{{ old('akun_gl', $financial->gl_account ?? '3421190010') }}"
                                        class="w-full rounded-[10px] border border-gray-200 bg-white px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 focus:border-[#0066FF] focus:outline-none transition shadow-2xs"
                                        required
                                    >
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-800 mb-1.5">
                                        No Aset / Kontrak<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="contract_number"
                                        value="{{ old('contract_number', $contract->contract_number ?? ($contract->asset_number ?? '-')) }}"
                                        class="w-full rounded-[10px] border border-gray-200 bg-white px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 focus:border-[#0066FF] focus:outline-none transition shadow-2xs"
                                        required
                                    >
                                </div>
                            </div>

                            {{-- Form RKA & Tahun RKA 2-Cols --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-800 mb-1.5">
                                        Form RKA<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="form_rka"
                                        value="{{ old('form_rka', $financial->form_rka ?? '0') }}"
                                        class="w-full rounded-[10px] border border-gray-200 bg-white px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 focus:border-[#0066FF] focus:outline-none transition shadow-2xs"
                                        required
                                    >
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-800 mb-1.5">
                                        Tahun RKA<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="tahun_rka"
                                        value="{{ old('tahun_rka', $financial->tahun_rka ?? '0') }}"
                                        class="w-full rounded-[10px] border border-gray-200 bg-white px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 focus:border-[#0066FF] focus:outline-none transition shadow-2xs"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- CARD 2: RINCIAN LAPORAN BULANAN (JANUARI - DESEMBER) --}}
                    <div class="rounded-2xl border border-gray-100 bg-white p-6 sm:p-7 shadow-[0_4px_25px_rgba(0,0,0,0.03)]">
                        <h2 class="text-base sm:text-lg font-bold text-gray-950 mb-5">
                            Rincian Pendapatan Bulanan
                        </h2>

                        @php
                            $months = [
                                'januari' => 'Januari',
                                'februari' => 'Februari',
                                'maret' => 'Maret',
                                'april' => 'April',
                                'mei' => 'Mei',
                                'juni' => 'Juni',
                                'juli' => 'Juli',
                                'agustus' => 'Agustus',
                                'september' => 'September',
                                'oktober' => 'Oktober',
                                'november' => 'November',
                                'desember' => 'Desember'
                            ];
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($months as $key => $label)
                                @php
                                    $col = ($key === 'februari') ? 'febuari' : $key;
                                    $val = $schedule->$col ? (string)(int)$schedule->$col : '9402819';
                                @endphp
                                <div>
                                    <label class="block text-xs font-semibold text-gray-800 mb-1.5">
                                        {{ $label }}<span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="{{ $key }}"
                                        value="{{ old($key, $val) }}"
                                        class="w-full rounded-[10px] border border-gray-200 bg-white px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 focus:border-[#0066FF] focus:outline-none transition shadow-2xs"
                                        required
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>


                {{-- Right Column: CARD KUSTOM TABLE (Sesuai Kolom Laporan) --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 sm:p-7 shadow-[0_4px_25px_rgba(0,0,0,0.03)] h-fit">
                    <div class="flex items-center justify-between mb-3.5">
                        <h2 class="text-base sm:text-lg font-bold text-gray-950">
                            Kustom Table
                        </h2>
                        <button
                            type="button"
                            onclick="resetTableColumns()"
                            class="text-xs sm:text-sm font-medium text-[#0066FF] hover:text-blue-700 transition cursor-pointer"
                        >
                            Reset
                        </button>
                    </div>

                    <h3 class="text-xs sm:text-sm font-semibold text-gray-800 mb-1">
                        Ubah Urutan Kolom
                    </h3>
                    <p class="text-[11px] text-gray-400 mb-4 leading-relaxed">
                        Ubah urutan kolom dengan geser pada icon, dan sesuaikan untuk tampilan urutannya.
                    </p>

                    {{-- DRAG AND DROP CONTAINER --}}
                    <div class="dnd-container min-h-[160px] rounded-[10px] border border-gray-200 bg-[#EFEFEF] p-3 flex flex-wrap content-start gap-2 shadow-2xs">

                        @php
                            $pills = [
                                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
                                'Form RKA', 'Tahun RKA', 'Akun GL'
                            ];
                        @endphp

                        @foreach($pills as $pill)
                            <div draggable="true" class="dnd-pill h-8 w-auto inline-flex items-center gap-2 rounded-[5px] border border-gray-300 bg-white px-2.5 sm:px-3 text-xs text-gray-700 shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                                <x-icon name="icon-drag-n-drop" class="w-3.5 h-3.5 text-gray-500 shrink-0 pointer-events-none" />
                                <span class="font-medium">{{ $pill }}</span>
                                <button type="button" onclick="removeDndPill(this)" class="ml-1 text-gray-400 hover:text-red-500 cursor-pointer">
                                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </form>

    </main>

    {{-- SCRIPTS: DRAG & DROP --}}
    <script>
        let draggedItem = null;
        let dropPlaceholder = null;

        function createDropPlaceholder() {
            const el = document.createElement('div');
            el.className = 'dnd-placeholder border-2 border-dashed border-blue-400 bg-blue-50/60 rounded-[5px] h-8 min-w-[70px] transition-all duration-150 flex items-center justify-center';
            return el;
        }

        function initDragAndDrop() {
            const containers = document.querySelectorAll('.dnd-container');
            
            containers.forEach(container => {
                if (container.dataset.dndBound) return;
                container.dataset.dndBound = "true";

                container.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    
                    if (!draggedItem) return;
                    if (!dropPlaceholder) {
                        dropPlaceholder = createDropPlaceholder();
                    }

                    const afterElement = getDragAfterElement(container, e.clientX, e.clientY);
                    if (afterElement == null) {
                        container.appendChild(dropPlaceholder);
                    } else {
                        container.insertBefore(dropPlaceholder, afterElement);
                    }
                });

                container.addEventListener('dragleave', function(e) {
                    if (e.relatedTarget && !container.contains(e.relatedTarget)) {
                        if (dropPlaceholder && dropPlaceholder.parentNode === container) {
                            dropPlaceholder.remove();
                        }
                    }
                });

                container.addEventListener('drop', function(e) {
                    e.preventDefault();
                    if (draggedItem && dropPlaceholder && dropPlaceholder.parentNode) {
                        dropPlaceholder.parentNode.insertBefore(draggedItem, dropPlaceholder);
                    }
                    cleanupDnD();
                });
            });

            document.querySelectorAll('.dnd-pill').forEach(attachPillEvents);
        }

        function attachPillEvents(pill) {
            pill.setAttribute('draggable', 'true');

            pill.addEventListener('dragstart', function(e) {
                draggedItem = pill;
                setTimeout(() => {
                    pill.classList.add('opacity-40', 'scale-95', 'shadow-md');
                }, 0);
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', pill.innerText);
            });

            pill.addEventListener('dragend', function() {
                cleanupDnD();
            });
        }

        function cleanupDnD() {
            if (draggedItem) {
                draggedItem.classList.remove('opacity-40', 'scale-95', 'shadow-md');
                draggedItem = null;
            }
            if (dropPlaceholder && dropPlaceholder.parentNode) {
                dropPlaceholder.remove();
            }
            dropPlaceholder = null;
        }

        function getDragAfterElement(container, x, y) {
            const draggableElements = [...container.querySelectorAll('.dnd-pill:not(.opacity-40)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offsetX = x - box.left - box.width / 2;
                const offsetY = y - box.top - box.height / 2;
                const distance = Math.hypot(offsetX, offsetY);

                if (offsetX < 0 && distance < closest.distance) {
                    return { distance: distance, element: child };
                } else {
                    return closest;
                }
            }, { distance: Number.POSITIVE_INFINITY }).element;
        }

        function removeDndPill(button) {
            const pill = button.closest('.dnd-pill');
            if (pill) {
                pill.classList.add('scale-75', 'opacity-0');
                setTimeout(() => pill.remove(), 150);
            }
        }

        const defaultLaporanColumns = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
            'Form RKA', 'Tahun RKA', 'Akun GL'
        ];

        function resetTableColumns() {
            const container = document.querySelector('.dnd-container');
            if (!container) return;

            container.innerHTML = defaultLaporanColumns.map(col => `
                <div draggable="true" class="dnd-pill h-8 w-auto inline-flex items-center gap-2 rounded-[5px] border border-gray-300 bg-white px-2.5 sm:px-3 text-xs text-gray-700 shadow-2xs cursor-grab active:cursor-grabbing select-none transition-all duration-150 shrink-0">
                    <svg class="w-3.5 h-3.5 text-gray-500 shrink-0 pointer-events-none" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.6169 6.92501C15.7491 6.92501 16.6669 6.0072 16.6669 4.87501C16.6669 3.74283 15.7491 2.82501 14.6169 2.82501C13.4847 2.82501 12.5669 3.74283 12.5669 4.87501C12.5669 6.0072 13.4847 6.92501 14.6169 6.92501Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path opacity="0.4" d="M5.3835 6.92501C6.51569 6.92501 7.43349 6.0072 7.43349 4.87501C7.43349 3.74283 6.51569 2.82501 5.3835 2.82501C4.25132 2.82501 3.3335 3.74283 3.3335 4.87501C3.3335 6.0072 4.25132 6.92501 5.3835 6.92501Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path opacity="0.4" d="M14.6169 17.175C15.7491 17.175 16.6669 16.2572 16.6669 15.125C16.6669 13.9928 15.7491 13.075 14.6169 13.075C13.4847 13.075 12.5669 13.9928 12.5669 15.125C12.5669 16.2572 13.4847 17.175 14.6169 17.175Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5.3835 17.175C6.51569 17.175 7.43349 16.2572 7.43349 15.125C7.43349 13.9928 6.51569 13.075 5.3835 13.075C4.25132 13.075 3.3335 13.9928 3.3335 15.125C3.3335 16.2572 4.25132 17.175 5.3835 17.175Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="font-medium">${col}</span>
                    <button type="button" onclick="removeDndPill(this)" class="ml-1 text-gray-400 hover:text-red-500 cursor-pointer">
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            `).join('');

            container.querySelectorAll('.dnd-pill').forEach(attachPillEvents);
        }

        document.addEventListener('DOMContentLoaded', () => {
            initDragAndDrop();
        });
    </script>

</body>
</html>
