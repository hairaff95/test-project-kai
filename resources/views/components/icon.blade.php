@props(['name'])

@switch($name)
    @case('kai-logo')
        <svg {{ $attributes->merge(['class' => 'h-8 w-auto', 'viewBox' => '0 0 294.74 124.22']) }} xmlns="http://www.w3.org/2000/svg">
            <defs>
                <style>.cls-1{fill:#2d2a70;}.cls-2{fill:#ed6b23;}</style>
            </defs>
            <g id="Layer_2">
                <g id="Layer_1-2">
                    <path class="cls-1" d="M99.58,124.22h28.56l-6.55-10.77Zm16.67-19.53L86.56,55.91,144.12,0H98.65a13.65,13.65,0,0,0-9.54,3.88L48.79,43.28,53.33,0H12.27L0,116.81a6.71,6.71,0,0,0,6.68,7.42h33.6L43.07,98,55.45,86l21.78,34.43a8.13,8.13,0,0,0,6.87,3.78H99.58l7.81-15.57Z"/>
                    <path class="cls-2" d="M141,124.22l55.61-33.81,7.08,28.71a6.71,6.71,0,0,0,6.52,5.11h36L230.13,70l61.24-37.24.26-2.5-192,93.95Zm83.38-73.65L209.37,0H174a19.52,19.52,0,0,0-17.45,10.77L106,111.37,292,26.52l.29-2.85ZM164.6,74.24,177,48l3.27-7.25a2.23,2.23,0,0,1,4.19.38l5.67,23Z"/>
                    <path class="cls-1" d="M269.53,0a19.52,19.52,0,0,0-19.41,17.49l-2.5,23.88,44.69-17.7L294.74,0Zm-30.6,124.22h43l9.42-91.45L245.6,60.61Z"/>
                </g>
            </g>
        </svg>
        @break

    @case('nav-home')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M12 3L3 10V20C3 20.5523 3.44772 21 4 21H20C20.5523 21 21 20.5523 21 20V10L12 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9 16H15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        @break

    @case('nav-map')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M12 21C16 17 20 13.4183 20 9C20 4.58172 16.4183 1 12 1C7.58172 1 4 4.58172 4 9C4 13.4183 8 17 12 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="12" cy="9" r="3" stroke="currentColor" stroke-width="2"/>
        </svg>
        @break

    @case('nav-contract')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M4 2V22L7 20L10 22L13 20L16 22L20 20V2L16 4L13 2L10 4L7 2L4 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M8 7H16M8 11H16M8 15H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        @break

    @case('nav-scan')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M3 7V5C3 3.89543 3.89543 3 5 3H7M17 3H19C20.1046 3 21 3.89543 21 5V7M21 17V19C21 20.1046 20.1046 21 19 21H17M7 21H5C3.89543 21 3 20.1046 3 19V17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M7 8V16M10 8V16M14 8V16M17 8V16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        @break

    @case('nav-card')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <rect x="2" y="5" width="20" height="14" rx="3" stroke="currentColor" stroke-width="2"/>
            <path d="M2 10H22M6 15H10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        @break

    @case('nav-user')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
            <path d="M5 21V19C5 16.7909 7.23858 15 10 15H14C16.7614 15 19 16.7909 19 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        @break

    @case('dots-vertical')
    @case('more-vertical')
        <svg {{ $attributes->merge(['class' => 'w-4 h-4', 'viewBox' => '0 0 24 24', 'fill' => 'currentColor']) }} xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="5" r="2.2" />
            <circle cx="12" cy="12" r="2.2" />
            <circle cx="12" cy="19" r="2.2" />
        </svg>
        @break

    @case('moon')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M2.03 12.42C2.39 17.57 6.76 21.76 11.99 21.99C15.68 22.15 18.98 20.43 20.96 17.72C21.78 16.61 21.34 15.87 19.97 16.12C19.3 16.24 18.61 16.29 17.89 16.26C13 16.06 9 11.97 8.98 7.14001C8.97 5.84001 9.24 4.61001 9.73 3.49001C10.27 2.25001 9.62 1.66001 8.37 2.19001C4.41 3.86001 1.7 7.85001 2.03 12.42Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break

    @case('notification')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M12.02 2.91C8.71 2.91 6.02 5.6 6.02 8.91V11.8C6.02 12.41 5.76 13.34 5.45 13.86L4.3 15.77C3.59 16.95 4.08 18.26 5.38 18.7C9.69 20.14 14.34 20.14 18.65 18.7C19.86 18.3 20.39 16.87 19.73 15.77L18.58 13.86C18.28 13.34 18.02 12.41 18.02 11.8V8.91C18.02 5.61 15.32 2.91 12.02 2.91Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
            <path d="M13.87 3.2C13.56 3.11 13.24 3.04 12.91 3C11.95 2.88 11.03 2.95 10.17 3.2C10.46 2.46 11.18 1.94 12.02 1.94C12.86 1.94 13.58 2.46 13.87 3.2Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path opacity="0.4" d="M15.02 19.06C15.02 20.71 13.67 22.06 12.02 22.06C11.2 22.06 10.44 21.72 9.89999 21.18C9.35999 20.64 9.01999 19.88 9.01999 19.06" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"/>
        </svg>
        @break

    @case('profile-circle')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.4" d="M12.12 12.78C12.05 12.77 11.96 12.77 11.88 12.78C10.12 12.72 8.71997 11.28 8.71997 9.51001C8.71997 7.70001 10.18 6.23001 12 6.23001C13.81 6.23001 15.28 7.70001 15.28 9.51001C15.27 11.28 13.88 12.72 12.12 12.78Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path opacity="0.34" d="M18.74 19.38C16.96 21.01 14.6 22 12 22C9.40001 22 7.04001 21.01 5.26001 19.38C5.36001 18.44 5.96001 17.52 7.03001 16.8C9.77001 14.98 14.25 14.98 16.97 16.8C18.04 17.52 18.64 18.44 18.74 19.38Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break

    @case('subway')
    @case('stasiun')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 20 20', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M0 20V6.85C0 5.43333 0.366667 4.20417 1.1 3.1625C1.83333 2.12083 2.86667 1.33333 4.2 0.8C5.1 0.45 6.05833 0.229167 7.075 0.1375C8.09167 0.0458333 9.06667 0 10 0C10.9333 0 11.9083 0.0458333 12.925 0.1375C13.9417 0.229167 14.9 0.45 15.8 0.8C17.1333 1.33333 18.1667 2.12083 18.9 3.1625C19.6333 4.20417 20 5.43333 20 6.85V20H0ZM7.1 18H12.85L11.35 16.5H8.6L7.1 18ZM5.5 11H14.5V7H5.5V11ZM14.2125 14.2125C14.4042 14.0208 14.5 13.7833 14.5 13.5C14.5 13.2167 14.4042 12.9792 14.2125 12.7875C14.0208 12.5958 13.7833 12.5 13.5 12.5C13.2167 12.5 12.9792 12.5958 12.7875 12.7875C12.5958 12.9792 12.5 13.2167 12.5 13.5C12.5 13.7833 12.5958 14.0208 12.7875 14.2125C12.9792 14.4042 13.2167 14.5 13.5 14.5C13.7833 14.5 14.0208 14.4042 14.2125 14.2125ZM7.2125 14.2125C7.40417 14.0208 7.5 13.7833 7.5 13.5C7.5 13.2167 7.40417 12.9792 7.2125 12.7875C7.02083 12.5958 6.78333 12.5 6.5 12.5C6.21667 12.5 5.97917 12.5958 5.7875 12.7875C5.59583 12.9792 5.5 13.2167 5.5 13.5C5.5 13.7833 5.59583 14.0208 5.7875 14.2125C5.97917 14.4042 6.21667 14.5 6.5 14.5C6.78333 14.5 7.02083 14.4042 7.2125 14.2125ZM2 18H5.5V17.5L6.55 16.45C5.81667 16.35 5.20833 16.0208 4.725 15.4625C4.24167 14.9042 4 14.25 4 13.5V7C4 5.7 4.62083 4.875 5.8625 4.525C7.10417 4.175 8.48333 4 10 4C11.6667 4 13.0833 4.175 14.25 4.525C15.4167 4.875 16 5.7 16 7V13.5C16 14.25 15.7583 14.9042 15.275 15.4625C14.7917 16.0208 14.1833 16.35 13.45 16.45L14.5 17.5V18H18V6.85C18 5.85 17.7542 4.99583 17.2625 4.2875C16.7708 3.57917 16.0333 3.03333 15.05 2.65C14.3167 2.36667 13.5042 2.1875 12.6125 2.1125C11.7208 2.0375 10.85 2 10 2C9.15 2 8.27917 2.0375 7.3875 2.1125C6.49583 2.1875 5.68333 2.36667 4.95 2.65C3.96667 3.03333 3.22917 3.57917 2.7375 4.2875C2.24583 4.99583 2 5.85 2 6.85V18Z" fill="#BDBDBD"/>
        </svg>
        @break

    @case('explore_nearby')
    @case('wilayah')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 20 20', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <rect width="20" height="20" rx="5" fill="#D9D9D9"/>
            <path d="M9.99996 14.5833C10.625 13.9583 11.1805 13.3125 11.6666 12.6458C12.0833 12.0764 12.4652 11.4514 12.8125 10.7708C13.1597 10.0903 13.3333 9.41666 13.3333 8.74999C13.3333 7.83332 13.0069 7.0486 12.3541 6.39582C11.7013 5.74305 10.9166 5.41666 9.99996 5.41666C9.08329 5.41666 8.29857 5.74305 7.64579 6.39582C6.99301 7.0486 6.66663 7.83332 6.66663 8.74999C6.66663 9.41666 6.84024 10.0903 7.18746 10.7708C7.53468 11.4514 7.91663 12.0764 8.33329 12.6458C8.8194 13.3125 9.37496 13.9583 9.99996 14.5833ZM9.11454 9.63541C8.87149 9.39235 8.74996 9.09721 8.74996 8.74999C8.74996 8.40277 8.87149 8.10763 9.11454 7.86457C9.3576 7.62152 9.65274 7.49999 9.99996 7.49999C10.3472 7.49999 10.6423 7.62152 10.8854 7.86457C11.1284 8.10763 11.25 8.40277 11.25 8.74999C11.25 9.09721 11.1284 9.39235 10.8854 9.63541C10.6423 9.87846 10.3472 9.99999 9.99996 9.99999C9.65274 9.99999 9.3576 9.87846 9.11454 9.63541Z" fill="white"/>
        </svg>
        @break

    @case('aset-icon')
    @case('aset')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M1 21V11L8 6L15 11L13.575 12.425L8 8.45L3 12V19H5V14H11V21H9V16H7V21H1ZM23 3V13.125C22.7167 12.825 22.4083 12.5542 22.075 12.3125C21.7417 12.0708 21.3833 11.8583 21 11.675V5H12V6.4L10 4.95V3H23ZM17 9H19V7H17V9ZM18 23C16.6167 23 15.4375 22.5125 14.4625 21.5375C13.4875 20.5625 13 19.3833 13 18C13 16.6167 13.4875 15.4375 14.4625 14.4625C15.4375 13.4875 16.6167 13 18 13C19.3833 13 20.5625 13.4875 21.5375 14.4625C22.5125 15.4375 23 16.6167 23 18C23 19.3833 22.5125 20.5625 21.5375 21.5375C20.5625 22.5125 19.3833 23 18 23ZM17.5 21H18.5V18.5H21V17.5H18.5V15H17.5V17.5H15V18.5H17.5V21Z" fill="#BDBDBD"/>
        </svg>
        @break

    @case('contract-icon')
    @case('contract')
    @case('jenis-kontrak')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M9 9V7H18V9H9ZM9 12V10H18V12H9ZM12 22H6C5.16667 22 4.45833 21.7083 3.875 21.125C3.29167 20.5417 3 19.8333 3 19V16H6V2H21V11.025C20.6667 10.9917 20.3292 11.0042 19.9875 11.0625C19.6458 11.1208 19.3167 11.225 19 11.375V4H8V16H14L12 18H5V19C5 19.2833 5.09583 19.5208 5.2875 19.7125C5.47917 19.9042 5.71667 20 6 20H12V22ZM14 22V18.925L19.525 13.425C19.675 13.275 19.8417 13.1667 20.025 13.1C20.2083 13.0333 20.3917 13 20.575 13C20.775 13 20.9667 13.0375 21.15 13.1125C21.3333 13.1875 21.5 13.3 21.65 13.45L22.575 14.375C22.7083 14.525 22.8125 14.6917 22.8875 14.875C22.9625 15.0583 23 15.2417 23 15.425C23 15.6083 22.9667 15.7958 22.9 15.9875C22.8333 16.1792 22.725 16.35 22.575 16.5L17.075 22H14ZM15.5 20.5H16.45L19.475 17.45L19.025 16.975L18.55 16.525L15.5 19.55V20.5ZM19.025 16.975L18.55 16.525L19.475 17.45L19.025 16.975Z" fill="#BDBDBD"/>
        </svg>
        @break

    @case('jenis-pendapatan-icon')
    @case('jenis-pendapatan')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M11.1 21H12.85V19.75C13.6833 19.6 14.4 19.275 15 18.775C15.6 18.275 15.9 17.5333 15.9 16.55C15.9 15.85 15.7 15.2083 15.3 14.625C14.9 14.0417 14.1 13.5333 12.9 13.1C11.9 12.7667 11.2083 12.475 10.825 12.225C10.4417 11.975 10.25 11.6333 10.25 11.2C10.25 10.7667 10.4042 10.425 10.7125 10.175C11.0208 9.925 11.4667 9.8 12.05 9.8C12.5833 9.8 13 9.92917 13.3 10.1875C13.6 10.4458 13.8167 10.7667 13.95 11.15L15.55 10.5C15.3667 9.91667 15.0292 9.40833 14.5375 8.975C14.0458 8.54167 13.5 8.3 12.9 8.25V7H11.15V8.25C10.3167 8.43333 9.66667 8.8 9.2 9.35C8.73333 9.9 8.5 10.5167 8.5 11.2C8.5 11.9833 8.72917 12.6167 9.1875 13.1C9.64583 13.5833 10.3667 14 11.35 14.35C12.4 14.7333 13.1292 15.075 13.5375 15.375C13.9458 15.675 14.15 16.0667 14.15 16.55C14.15 17.1 13.9542 17.5042 13.5625 17.7625C13.1708 18.0208 12.7 18.15 12.15 18.15C11.6 18.15 11.1125 17.9792 10.6875 17.6375C10.2625 17.2958 9.95 16.7833 9.75 16.1L8.1 16.75C8.33333 17.55 8.69583 18.1958 9.1875 18.6875C9.67917 19.1792 10.3167 19.5167 11.1 19.7V21ZM12 24C10.6167 24 9.31667 23.7375 8.1 23.2125C6.88333 22.6875 5.825 21.975 4.925 21.075C4.025 20.175 3.3125 19.1167 2.7875 17.9C2.2625 16.6833 2 15.3833 2 14C2 12.6167 2.2625 11.3167 2.7875 10.1C3.3125 8.88333 4.025 7.825 4.925 6.925C5.825 6.025 6.88333 5.3125 8.1 4.7875C9.31667 4.2625 10.6167 4 12 4C13.3833 4 14.6833 4.2625 15.9 4.7875C17.1167 5.3125 18.175 6.025 19.075 6.925C19.975 7.825 20.6875 8.88333 21.2125 10.1C21.7375 11.3167 22 12.6167 22 14C22 15.3833 21.7375 16.6833 21.2125 17.9C20.6875 19.1167 19.975 20.175 19.075 21.075C18.175 21.975 17.1167 22.6875 15.9 23.2125C14.6833 23.7375 13.3833 24 12 24ZM12 22C14.2333 22 16.125 21.225 17.675 19.675C19.225 18.125 20 16.2333 20 14C20 11.7667 19.225 9.875 17.675 8.325C16.125 6.775 14.2333 6 12 6C9.76667 6 7.875 6.775 6.325 8.325C4.775 9.875 4 11.7667 4 14C4 16.2333 4.775 18.125 6.325 19.675C7.875 21.225 9.76667 22 12 22Z" fill="#BDBDBD"/>
        </svg>
        @break

    @case('spv-icon')
    @case('spv')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M15.225 14.275C14.7417 13.7917 14.5 13.2 14.5 12.5C14.5 11.8 14.7417 11.2083 15.225 10.725C15.7083 10.2417 16.3 10 17 10C17.7 10 18.2917 10.2417 18.775 10.725C19.2583 11.2083 19.5 11.8 19.5 12.5C19.5 13.2 19.2583 13.7917 18.775 14.275C18.2917 14.7583 17.7 15 17 15C16.3 15 15.7083 14.7583 15.225 14.275ZM12 20V18.6C12 18.2 12.1042 17.8292 12.3125 17.4875C12.5208 17.1458 12.8167 16.9 13.2 16.75C13.8 16.5 14.4208 16.3125 15.0625 16.1875C15.7042 16.0625 16.35 16 17 16C17.65 16 18.2958 16.0625 18.9375 16.1875C19.5792 16.3125 20.2 16.5 20.8 16.75C21.1833 16.9 21.4792 17.1458 21.6875 17.4875C21.8958 17.8292 22 18.2 22 18.6V20H12ZM7.175 10.825C6.39167 10.0417 6 9.1 6 8C6 6.9 6.39167 5.95833 7.175 5.175C7.95833 4.39167 8.9 4 10 4C11.1 4 12.0417 4.39167 12.825 5.175C13.6083 5.95833 14 6.9 14 8C14 9.1 13.6083 10.0417 12.825 10.825C12.0417 11.6083 11.1 12 10 12C8.9 12 7.95833 11.6083 7.175 10.825ZM2 20V17.2C2 16.6333 2.14167 16.1125 2.425 15.6375C2.70833 15.1625 3.1 14.8 3.6 14.55C4.6 14.05 5.6375 13.6667 6.7125 13.4C7.7875 13.1333 8.88333 13 10 13C10.5833 13 11.1667 13.05 11.75 13.15C12.3333 13.25 12.9167 13.3667 13.5 13.5L11.8 15.2C11.5 15.1167 11.2 15.0625 10.9 15.0375C10.6 15.0125 10.3 15 10 15C9.03333 15 8.0875 15.1167 7.1625 15.35C6.2375 15.5833 5.35 15.9167 4.5 16.35C4.33333 16.4333 4.20833 16.55 4.125 16.7C4.04167 16.85 4 17.0167 4 17.2V18H10V20H2ZM11.4125 9.4125C11.8042 9.02083 12 8.55 12 8C12 7.45 11.8042 6.97917 11.4125 6.5875C11.0208 6.19583 10.55 6 10 6C9.45 6 8.97917 6.19583 8.5875 6.5875C8.19583 6.97917 8 7.45 8 8C8 8.55 8.19583 9.02083 8.5875 9.4125C8.97917 9.80417 9.45 10 10 10C10.55 10 11.0208 9.80417 11.4125 9.4125Z" fill="#BDBDBD"/>
        </svg>
        @break

    @case('filter-icon')
    @case('filter')
        <svg {{ $attributes->merge(['class' => 'w-4 h-4', 'viewBox' => '0 0 17 17', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M9.91667 17C9.76341 17 9.61428 16.9503 9.49167 16.8583L6.65834 14.7333C6.57037 14.6673 6.49897 14.5818 6.44979 14.4834C6.40061 14.3851 6.37501 14.2766 6.37501 14.1667V10.1858L1.40534 4.59495C1.05239 4.19678 0.821942 3.70516 0.741688 3.17916C0.661434 2.65317 0.734792 2.11518 0.952944 1.62988C1.1711 1.14457 1.52476 0.732595 1.97143 0.443458C2.41809 0.154321 2.93876 0.000330682 3.47084 -5.36442e-06L13.5292 -5.36442e-06C14.0612 0.000618713 14.5817 0.154864 15.0282 0.444195C15.4747 0.733526 15.8282 1.14563 16.0461 1.63099C16.264 2.11635 16.3371 2.65431 16.2567 3.18023C16.1762 3.70615 15.9456 4.19765 15.5925 4.59566L10.625 10.1858V16.2917C10.625 16.4795 10.5504 16.6597 10.4175 16.7925C10.2847 16.9254 10.1045 17 9.91667 17V17Z" fill="currentColor"/>
        </svg>
        @break

    @case('filter-peta')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 40 40', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M31.1111 13.8889H24.4445" stroke="#111827" stroke-width="2.6" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <g>
                <path d="M13.3332 13.8889H8.88879" stroke="#8E8E8E" stroke-width="2.6" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M17.7777 17.7778C19.9255 17.7778 21.6666 16.0367 21.6666 13.8889C21.6666 11.7411 19.9255 10 17.7777 10C15.6299 10 13.8888 11.7411 13.8888 13.8889C13.8888 16.0367 15.6299 17.7778 17.7777 17.7778Z" stroke="#8E8E8E" stroke-width="2.6" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
            <path d="M15.5555 26.1111H8.88879" stroke="#111827" stroke-width="2.6" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <g>
                <path d="M31.1111 26.1111H26.6666" stroke="#8E8E8E" stroke-width="2.6" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22.2221 30C24.3699 30 26.111 28.2589 26.111 26.1111C26.111 23.9633 24.3699 22.2222 22.2221 22.2222C20.0744 22.2222 18.3333 23.9633 18.3333 26.1111C18.3333 28.2589 20.0744 30 22.2221 30Z" stroke="#8E8E8E" stroke-width="2.6" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
        </svg>
        @break

    @case('location-icon')
    @case('lokasi')
    @case('pin-location')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M20.62 8.45C19.57 3.83 15.54 1.75 12 1.75C12 1.75 12 1.75 11.99 1.75C8.45997 1.75 4.41997 3.82 3.36997 8.44C2.19997 13.6 5.35997 17.97 8.21997 20.72C9.27997 21.74 10.64 22.25 12 22.25C13.36 22.25 14.72 21.74 15.77 20.72C18.63 17.97 21.79 13.61 20.62 8.45Z" fill="#BE0000"/>
            <path d="M12 13.46C13.7397 13.46 15.15 12.0497 15.15 10.31C15.15 8.57031 13.7397 7.16 12 7.16C10.2603 7.16 8.84998 8.57031 8.84998 10.31C8.84998 12.0497 10.2603 13.46 12 13.46Z" fill="white"/>
        </svg>
        @break

    @case('folder')
    @case('fi-ss-folder')
        <svg {{ $attributes->merge(['class' => 'w-10 h-10', 'viewBox' => '0 0 35 35', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M35 10.0338V8.75044C35 7.59012 34.5391 6.47732 33.7186 5.65685C32.8981 4.83637 31.7853 4.37544 30.625 4.37544H17.8442L12.0108 1.45877H4.375C3.21468 1.45877 2.10188 1.91971 1.28141 2.74018C0.460936 3.56065 0 4.67345 0 5.83377L0 10.2088L35 10.0338Z" fill="#E8E8E8"/>
            <path d="M1.99042 13.1076C0.889604 13.1128 0 14.0067 0 15.1075V31.5411C0 32.6456 0.895431 33.5411 2 33.5411H33C34.1046 33.5411 35 32.6456 35 31.5411V14.959C35 13.8507 34.0987 12.9537 32.9904 12.959L1.99042 13.1076Z" fill="#BEBEBE"/>
        </svg>
        @break

    @case('arrow-up-right')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M7 17L17 7M17 7H9M17 7V15" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break

    @case('zoom-in')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <circle cx="10.5" cy="10.5" r="7.5" fill="#A3A3A3"/>
            <path d="M10.5 7.5v6M7.5 10.5h6" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round"/>
            <circle cx="18" cy="18" r="1.8" fill="#525252"/>
        </svg>
        @break

    @case('zoom-out')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <circle cx="10.5" cy="10.5" r="7.5" fill="#A3A3A3"/>
            <path d="M7.5 10.5h6" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round"/>
            <circle cx="18" cy="18" r="1.8" fill="#525252"/>
        </svg>
        @break

    @case('hand-pan')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M8.5 11.5V5a1.5 1.5 0 0 1 3 0v4.5M11.5 9.5V3.5a1.5 1.5 0 0 1 3 0v6M14.5 9.5V5a1.5 1.5 0 0 1 3 0v6.5M8.5 11.5a1.5 1.5 0 0 0-3 0v4a6.5 6.5 0 0 0 6.5 6.5h2a6.5 6.5 0 0 0 6.5-6.5V11.5a1.5 1.5 0 0 0-3 0v3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break

    @case('tooltip')
    @case('Tooltip')
        <svg {{ $attributes->merge(['class' => 'w-16 h-16', 'viewBox' => '0 0 72 73', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#icon_filter_tooltip)">
                <rect x="11.3894" width="48.7788" height="41.7788" rx="15.1858" fill="#1E293B"/>
                <g clip-path="url(#icon_clip_tooltip)">
                    <path d="M34.4365 48.4365L28.1859 42.1858L35.7788 34.5929L43.3717 42.1858L37.121 48.4365C36.3797 49.1778 35.1778 49.1778 34.4365 48.4365Z" fill="#1E293B"/>
                </g>
            </g>
            <defs>
                <filter id="icon_filter_tooltip" x="2.31266e-05" y="-1.19209e-07" width="71.5575" height="72.1505" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feMorphology radius="1.89823" operator="erode" in="SourceAlpha" result="effect1_dropShadow_5_1740"/>
                    <feOffset dy="3.79646"/>
                    <feGaussianBlur stdDeviation="2.84735"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.0627451 0 0 0 0 0.0941176 0 0 0 0 0.156863 0 0 0 0.03 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_5_1740"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feMorphology radius="3.79646" operator="erode" in="SourceAlpha" result="effect2_dropShadow_5_1740"/>
                    <feOffset dy="11.3894"/>
                    <feGaussianBlur stdDeviation="7.59292"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.0627451 0 0 0 0 0.0941176 0 0 0 0 0.156863 0 0 0 0.08 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_5_1740" result="effect2_dropShadow_5_1740"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_5_1740" result="shape"/>
                </filter>
                <clipPath id="icon_clip_tooltip">
                    <rect width="15.1858" height="7.59292" fill="white" transform="translate(28.1859 41.7787)"/>
                </clipPath>
            </defs>
        </svg>
        @break

    @case('corporate-fare')
    @case('corporate_fare')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 21 19', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M0 18.7775V0H10.4319V4.17278H20.8639V18.7775H0ZM2.08639 16.6911H8.34555V14.6047H2.08639V16.6911ZM2.08639 12.5183H8.34555V10.4319H2.08639V12.5183ZM2.08639 8.34555H8.34555V6.25916H2.08639V8.34555ZM2.08639 4.17278H8.34555V2.08639H2.08639V4.17278ZM10.4319 16.6911H18.7775V6.25916H10.4319V16.6911ZM12.5183 10.4319V8.34555H16.6911V10.4319H12.5183ZM12.5183 14.6047V12.5183H16.6911V14.6047H12.5183Z" fill="currentColor"/>
        </svg>
        @break

    @case('back-square')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 24 24', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <g opacity="0.4">
                <path d="M8.9999 15.38H13.9199C15.6199 15.38 16.9999 14 16.9999 12.3C16.9999 10.6 15.6199 9.21997 13.9199 9.21997H7.1499" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8.57 10.77L7 9.18999L8.57 7.62" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
        </svg>
        @break

    @case('alamat')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 22 19', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_alamat)">
                <g filter="url(#filter1_d_alamat)">
                    <path d="M4.51001 3.0067C4.51001 2.17642 5.18308 1.50335 6.01336 1.50335H18.0402C18.8704 1.50335 19.5435 2.17642 19.5435 3.0067V11.2751C19.5435 12.1054 18.8704 12.7785 18.0402 12.7785H6.01336C5.18308 12.7785 4.51001 12.1054 4.51001 11.2751V3.0067Z" fill="url(#paint0_linear_alamat)"/>
                </g>
                <g filter="url(#filter2_dd_alamat)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5233 4.51005L13.53 5.26172V16.5368L10.5233 15.7852V10.3122C10.7798 10.7744 11.2727 11.0872 11.8387 11.0872C12.669 11.0872 13.3421 10.4141 13.3421 9.58385C13.3421 8.75357 12.669 8.0805 11.8387 8.0805C11.2727 8.0805 10.7798 8.39331 10.5233 8.85548V4.51005Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter3_dd_alamat)">
                    <path d="M7.51671 5.26172L4.51001 4.51005V15.7852L7.51671 16.5368V5.26172Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter4_dd_alamat)">
                    <path d="M13.53 5.26172L16.5367 4.51005V15.7852L13.53 16.5368V5.26172Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter5_dd_alamat)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5233 4.51005L7.5166 5.26172V16.5368L10.5233 15.7852V10.3122C10.4036 10.0965 10.3354 9.84812 10.3354 9.58385C10.3354 9.31958 10.4036 9.07125 10.5233 8.85548V4.51005Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter6_dd_alamat)">
                    <path d="M1.5033 5.26172L4.50999 4.51005V15.7852L1.5033 16.5368V5.26172Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter7_dd_alamat)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0608 14.2811C12.6951 13.7152 14.4696 11.9312 14.4696 9.68636C14.4696 8.31966 13.6475 6.95298 11.8387 6.95298C10.03 6.95298 9.20789 8.31966 9.20789 9.68636C9.20789 11.9312 10.9824 13.7152 11.6167 14.2811C11.7452 14.3957 11.9323 14.3957 12.0608 14.2811ZM11.8387 11.0872C12.669 11.0872 13.3421 10.4141 13.3421 9.58385C13.3421 8.75356 12.669 8.0805 11.8387 8.0805C11.0085 8.0805 10.3354 8.75356 10.3354 9.58385C10.3354 10.4141 11.0085 11.0872 11.8387 11.0872Z" fill="white" fill-opacity="0.6"/>
                </g>
            </g>
            <defs>
                <filter id="filter0_d_alamat" x="0.751621" y="0.751675" width="21.0469" height="18.0402" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dx="0.751675" dy="0.751675"/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.545098 0 0 0 0 0.823529 0 0 0 0 0.192157 0 0 0 0.4 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5703"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_37_5703" result="shape"/>
                </filter>
                <filter id="filter1_d_alamat" x="3.00666" y="-2.38419e-07" width="18.0401" height="14.2818" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.8 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5703"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_37_5703" result="shape"/>
                </filter>
                <filter id="filter2_dd_alamat" x="9.01997" y="3.75837" width="6.01341" height="15.0335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.375837"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5703"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.751675"/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5703" result="effect2_dropShadow_37_5703"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5703" result="shape"/>
                </filter>
                <filter id="filter3_dd_alamat" x="3.00666" y="3.75837" width="6.01341" height="15.0335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.375837"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5703"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.751675"/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5703" result="effect2_dropShadow_37_5703"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5703" result="shape"/>
                </filter>
                <filter id="filter4_dd_alamat" x="12.0267" y="3.75837" width="6.01341" height="15.0335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.375837"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5703"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.751675"/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5703" result="effect2_dropShadow_37_5703"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5703" result="shape"/>
                </filter>
                <filter id="filter5_dd_alamat" x="6.01325" y="3.75837" width="6.01341" height="15.0335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.375837"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5703"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.751675"/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5703" result="effect2_dropShadow_37_5703"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5703" result="shape"/>
                </filter>
                <filter id="filter6_dd_alamat" x="-5.36442e-05" y="3.75837" width="6.01341" height="15.0335" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.375837"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5703"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.751675"/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5703" result="effect2_dropShadow_37_5703"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5703" result="shape"/>
                </filter>
                <filter id="filter7_dd_alamat" x="7.70454" y="6.20131" width="8.26842" height="10.4208" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.375837"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5703"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.751675"/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5703" result="effect2_dropShadow_37_5703"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5703" result="shape"/>
                </filter>
                <linearGradient id="paint0_linear_alamat" x1="12.0268" y1="1.50335" x2="12.0268" y2="12.7785" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#93DF32"/>
                    <stop offset="1" stop-color="#70BD0D"/>
                </linearGradient>
            </defs>
        </svg>
        @break

    @case('luas')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 21 23', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_luas)">
                <g filter="url(#filter1_d_luas)">
                    <path d="M9.9928 6.91802C9.9928 6.49351 10.337 6.14935 10.7615 6.14935H17.6795C18.104 6.14935 18.4482 6.49351 18.4482 6.91802V16.1421C18.4482 16.5666 18.104 16.9107 17.6795 16.9107H10.7615C10.337 16.9107 9.9928 16.5666 9.9928 16.1421V6.91802Z" fill="url(#paint0_linear_luas)"/>
                </g>
                <g filter="url(#filter2_d_luas)">
                    <path d="M5.38074 2.30601C5.38074 1.88149 5.72489 1.53734 6.14941 1.53734H11.5301C11.9546 1.53734 12.2988 1.88149 12.2988 2.30601V16.1421C12.2988 16.5666 11.9546 16.9107 11.5301 16.9107H6.14941C5.72489 16.9107 5.38074 16.5666 5.38074 16.1421V2.30601Z" fill="url(#paint1_linear_luas)"/>
                </g>
                <g filter="url(#filter3_dd_luas)">
                    <path d="M1.53735 5.38069C1.53735 4.95617 1.88151 4.61202 2.30602 4.61202H7.68671C8.11122 4.61202 8.45538 4.95617 8.45538 5.38069V19.2167C8.45538 19.6412 8.11122 19.9854 7.68671 19.9854H2.30602C1.88151 19.9854 1.53735 19.6412 1.53735 19.2167V5.38069Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter4_dd_luas)">
                    <path d="M2.69043 13.2595C2.69043 12.9411 2.94853 12.683 3.26693 12.683H6.72594C7.04434 12.683 7.30244 12.9411 7.30244 13.2595C7.30244 13.5779 7.04434 13.836 6.72594 13.836H3.26693C2.94853 13.836 2.69043 13.5779 2.69043 13.2595Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter5_dd_luas)">
                    <path d="M2.69043 15.5656C2.69043 15.2472 2.94853 14.9891 3.26693 14.9891H6.72594C7.04434 14.9891 7.30244 15.2472 7.30244 15.5656C7.30244 15.884 7.04434 16.1421 6.72594 16.1421H3.26693C2.94853 16.1421 2.69043 15.884 2.69043 15.5656Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter6_dd_luas)">
                    <path d="M2.69043 17.8716C2.69043 17.5532 2.94853 17.2951 3.26693 17.2951H6.72594C7.04434 17.2951 7.30244 17.5532 7.30244 17.8716C7.30244 18.19 7.04434 18.4481 6.72594 18.4481H3.26693C2.94853 18.4481 2.69043 18.19 2.69043 17.8716Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter7_dd_luas)">
                    <path d="M2.69043 10.9535C2.69043 10.6351 2.94853 10.377 3.26693 10.377H6.72594C7.04434 10.377 7.30244 10.6351 7.30244 10.9535C7.30244 11.2719 7.04434 11.53 6.72594 11.53H3.26693C2.94853 11.53 2.69043 11.2719 2.69043 10.9535Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter8_dd_luas)">
                    <path d="M2.69043 8.64754C2.69043 8.32914 2.94853 8.07104 3.26693 8.07104H6.72594C7.04434 8.07104 7.30244 8.32914 7.30244 8.64754C7.30244 8.96594 7.04434 9.22404 6.72594 9.22404H3.26693C2.94853 9.22404 2.69043 8.96594 2.69043 8.64754Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter9_dd_luas)">
                    <path d="M2.69043 6.34154C2.69043 6.02313 2.94853 5.76503 3.26693 5.76503H6.72594C7.04434 5.76503 7.30244 6.02313 7.30244 6.34154C7.30244 6.65994 7.04434 6.91804 6.72594 6.91804H3.26693C2.94853 6.91804 2.69043 6.65994 2.69043 6.34154Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter10_dd_luas)">
                    <path d="M6.53394 9.9927C6.53394 9.56819 6.87809 9.22403 7.3026 9.22403H10.5117C10.6741 9.22403 10.8324 9.2755 10.9638 9.37106L14.6727 12.0685C14.8716 12.2131 14.9893 12.4442 14.9893 12.6901V19.2167C14.9893 19.6412 14.6451 19.9854 14.2206 19.9854H7.3026C6.87809 19.9854 6.53394 19.6412 6.53394 19.2167V9.9927Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter11_dd_luas)">
                    <path d="M12.2988 14.0282C12.2988 13.7098 12.5569 13.4517 12.8753 13.4517C13.1937 13.4517 13.4518 13.7098 13.4518 14.0282V17.4872C13.4518 17.8056 13.1937 18.0637 12.8753 18.0637C12.5569 18.0637 12.2988 17.8056 12.2988 17.4872V14.0282Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter12_dd_luas)">
                    <path d="M9.9928 12.4909C9.9928 12.1725 10.2509 11.9144 10.5693 11.9144C10.8877 11.9144 11.1458 12.1725 11.1458 12.4909V17.4872C11.1458 17.8057 10.8877 18.0637 10.5693 18.0637C10.2509 18.0637 9.9928 17.8057 9.9928 17.4872V12.4909Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter13_dd_luas)">
                    <path d="M7.68677 10.9535C7.68677 10.6351 7.94487 10.377 8.26327 10.377C8.58167 10.377 8.83977 10.6351 8.83977 10.9535V17.4872C8.83977 17.8056 8.58167 18.0637 8.26327 18.0637C7.94487 18.0637 7.68677 17.8056 7.68677 17.4872V10.9535Z" fill="white" fill-opacity="0.6"/>
                </g>
            </g>
            <defs>
                <filter id="filter0_d_luas" x="0.768684" y="0.768669" width="19.9854" height="21.5227" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dx="0.768669" dy="0.768669"/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.180392 0 0 0 0 0.764706 0 0 0 0 0.835294 0 0 0 0.4 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter1_d_luas" x="8.45546" y="4.61201" width="11.53" height="13.836" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.8 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter2_d_luas" x="3.8434" y="-1.19209e-07" width="9.99265" height="18.4481" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.8 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter3_dd_luas" x="1.51396e-05" y="3.84335" width="9.99265" height="18.4481" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.384335"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.768669"/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5783" result="effect2_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter4_dd_luas" x="1.15309" y="11.9144" width="7.68674" height="4.22768" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.384335"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.768669"/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5783" result="effect2_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter5_dd_luas" x="1.15309" y="14.2204" width="7.68674" height="4.22768" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.384335"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.768669"/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5783" result="effect2_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter6_dd_luas" x="1.15309" y="16.5264" width="7.68674" height="4.22768" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.384335"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.768669"/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5783" result="effect2_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter7_dd_luas" x="1.15309" y="9.60837" width="7.68674" height="4.22768" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.384335"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.768669"/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5783" result="effect2_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter8_dd_luas" x="1.15309" y="7.30237" width="7.68674" height="4.22768" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.384335"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.768669"/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5783" result="effect2_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter9_dd_luas" x="1.15309" y="4.99636" width="7.68674" height="4.22768" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.384335"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.768669"/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5783" result="effect2_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter10_dd_luas" x="4.9966" y="8.45536" width="11.53" height="13.836" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.384335"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.768669"/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5783" result="effect2_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter11_dd_luas" x="10.7615" y="12.683" width="4.22763" height="7.68669" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.384335"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.768669"/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5783" result="effect2_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter12_dd_luas" x="8.45546" y="11.1457" width="4.22763" height="9.22403" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.384335"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.768669"/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5783" result="effect2_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5783" result="shape"/>
                </filter>
                <filter id="filter13_dd_luas" x="6.14943" y="9.60837" width="4.22763" height="10.7614" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.384335"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5783"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.768669"/>
                    <feGaussianBlur stdDeviation="0.768669"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5783" result="effect2_dropShadow_37_5783"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5783" result="shape"/>
                </filter>
                <linearGradient id="paint0_linear_luas" x1="14.2205" y1="6.14935" x2="14.2205" y2="16.9107" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#31C8D2"/>
                    <stop offset="1" stop-color="#1AA6E1"/>
                </linearGradient>
                <linearGradient id="paint1_linear_luas" x1="8.83975" y1="1.53734" x2="8.83975" y2="16.9107" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#31C8D2"/>
                    <stop offset="1" stop-color="#1AA6E1"/>
                </linearGradient>
            </defs>
        </svg>
        @break

    @case('jenis-asset')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 22 21', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_jenis)">
                <g filter="url(#filter1_d_jenis)">
                    <path d="M4.50989 3.0067C4.50989 2.17642 5.18296 1.50335 6.01324 1.50335H18.04C18.8703 1.50335 19.5434 2.17642 19.5434 3.0067V11.2751C19.5434 12.1054 18.8703 12.7785 18.04 12.7785H6.01324C5.18296 12.7785 4.50989 12.1054 4.50989 11.2751V3.0067Z" fill="url(#paint0_linear_jenis)"/>
                </g>
                <g filter="url(#filter2_dd_jenis)">
                    <path d="M1.5033 5.26173C1.5033 4.8466 1.83984 4.51006 2.25497 4.51006H15.7851C16.2002 4.51006 16.5368 4.8466 16.5368 5.26173V6.76508C16.5368 7.18021 16.2002 7.51675 15.7851 7.51675H2.25497C1.83984 7.51675 1.5033 7.18021 1.5033 6.76508V5.26173Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter3_dd_jenis)">
                    <path d="M1.5033 8.64425C1.5033 8.43668 1.67156 8.26842 1.87913 8.26842H14.6576C14.8652 8.26842 15.0334 8.43668 15.0334 8.64425V10.1476C15.0334 10.3552 14.8652 10.5234 14.6576 10.5234H1.87913C1.67156 10.5234 1.5033 10.3552 1.5033 10.1476V8.64425Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter4_dd_jenis)">
                    <path d="M1.5033 11.651C1.5033 11.4434 1.67156 11.2751 1.87913 11.2751H8.64421C8.85178 11.2751 9.02004 11.4434 9.02004 11.651V12.4026C9.02004 12.6102 8.85178 12.7785 8.64421 12.7785H1.87913C1.67156 12.7785 1.5033 12.6102 1.5033 12.4026V11.651Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter5_dd_jenis)">
                    <path d="M11.2158 16.6802C12.0978 18.1139 13.7078 18.1069 14.6334 17.9966C16.4844 17.7758 17.7809 16.7346 17.4141 13.2318C17.3121 12.2589 16.5671 11.8552 15.6926 12.4521C15.3593 11.5067 13.7481 11.781 13.8415 12.6729L13.6377 10.7269C13.5613 9.99722 13.1595 9.3063 12.328 9.40548C11.4965 9.50469 11.5044 10.4889 11.6007 11.4086L11.963 14.8672L11.167 13.9771C10.9101 13.7614 10.2372 13.1521 9.70226 13.4129C9.16735 13.6738 9.08459 14.2255 9.36692 14.6843C9.64925 15.1432 10.6512 15.7625 11.2158 16.6802Z" fill="white" fill-opacity="0.6"/>
                </g>
            </g>
            <defs>
                <filter id="filter0_d_jenis" x="0.751621" y="0.751675" width="21.0467" height="19.5435" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dx="0.751675" dy="0.751675"/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.615686 0 0 0 0 0.407843 0 0 0 0 0.952941 0 0 0 0.4 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5739"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_37_5739" result="shape"/>
                </filter>
                <filter id="filter1_d_jenis" x="3.00654" y="-2.38419e-07" width="18.0401" height="14.2818" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.8 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5739"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_37_5739" result="shape"/>
                </filter>
                <filter id="filter2_dd_jenis" x="-5.36442e-05" y="3.75838" width="18.0401" height="6.0134" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.375837"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5739"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.751675"/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5739" result="effect2_dropShadow_37_5739"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5739" result="shape"/>
                </filter>
                <filter id="filter3_dd_jenis" x="-5.36442e-05" y="7.51674" width="16.5369" height="5.26173" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.375837"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5739"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.751675"/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5739" result="effect2_dropShadow_37_5739"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5739" result="shape"/>
                </filter>
                <filter id="filter4_dd_jenis" x="-5.36442e-05" y="10.5234" width="10.5234" height="4.51006" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.375837"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5739"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.751675"/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5739" result="effect2_dropShadow_37_5739"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5739" result="shape"/>
                </filter>
                <filter id="filter5_dd_jenis" x="7.70454" y="8.64428" width="11.2751" height="11.6509" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.375837"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5739"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.751675"/>
                    <feGaussianBlur stdDeviation="0.751675"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5739" result="effect2_dropShadow_37_5739"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5739" result="shape"/>
                </filter>
                <linearGradient id="paint0_linear_jenis" x1="12.0266" y1="1.50335" x2="12.0266" y2="12.7785" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#6966FF"/>
                    <stop offset="1" stop-color="#9D68F3"/>
                </linearGradient>
            </defs>
        </svg>
        @break

    @case('nilai-asset')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 21 18', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_nilai)">
                <g filter="url(#filter1_d_nilai)">
                    <path d="M4.20007 2.80015C4.20007 2.02691 4.8269 1.40008 5.60015 1.40008H16.8008C17.5739 1.40008 18.2008 2.02691 18.2008 2.80015V9.1005C18.2008 9.87374 17.5739 10.5006 16.8008 10.5006H5.60015C4.8269 10.5006 4.20007 9.87374 4.20007 9.1005V2.80015Z" fill="url(#paint0_linear_nilai)"/>
                </g>
                <g filter="url(#filter2_dd_nilai)">
                    <path d="M3.85399 4.24584C4.05414 3.49895 4.82185 3.05571 5.56874 3.25583L16.3877 6.15476C17.1346 6.3549 17.5778 7.12261 17.3777 7.8695L15.747 13.9552C15.5469 14.702 14.7792 15.1453 14.0323 14.9451L3.21335 12.0462C2.46647 11.8461 2.02322 11.0784 2.22334 10.3315L3.85399 4.24584Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter3_dd_nilai)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.40002 7.3504C1.40002 6.57716 2.02686 5.95033 2.8001 5.95033H14.0007C14.774 5.95033 15.4008 6.57716 15.4008 7.3504V13.6507C15.4008 14.424 14.774 15.0508 14.0007 15.0508H2.8001C2.02686 15.0508 1.40002 14.424 1.40002 13.6507V7.3504ZM10.5005 10.5006C10.5005 12.2404 9.56026 13.6507 8.4004 13.6507C7.24055 13.6507 6.30029 12.2404 6.30029 10.5006C6.30029 8.76078 7.24055 7.3504 8.4004 7.3504C9.56026 7.3504 10.5005 8.76078 10.5005 10.5006ZM3.85016 7.70042C3.85016 8.08703 3.53673 8.40046 3.15012 8.40046C2.76351 8.40046 2.45008 8.08703 2.45008 7.70042C2.45008 7.31381 2.76351 7.00038 3.15012 7.00038C3.53673 7.00038 3.85016 7.31381 3.85016 7.70042ZM14.3507 7.70042C14.3507 8.08703 14.0373 8.40046 13.6507 8.40046C13.2641 8.40046 12.9507 8.08703 12.9507 7.70042C12.9507 7.31381 13.2641 7.00038 13.6507 7.00038C14.0373 7.00038 14.3507 7.31381 14.3507 7.70042ZM3.15012 14.0008C3.53673 14.0008 3.85016 13.6873 3.85016 13.3007C3.85016 12.9141 3.53673 12.6007 3.15012 12.6007C2.76351 12.6007 2.45008 12.9141 2.45008 13.3007C2.45008 13.6873 2.76351 14.0008 3.15012 14.0008ZM14.3507 13.3007C14.3507 13.6873 14.0373 14.0008 13.6507 14.0008C13.2641 14.0008 12.9507 13.6873 12.9507 13.3007C12.9507 12.9141 13.2641 12.6007 13.6507 12.6007C14.0373 12.6007 14.3507 12.9141 14.3507 13.3007Z" fill="white" fill-opacity="0.4"/>
                </g>
            </g>
            <defs>
                <filter id="filter0_d_nilai" x="0.699986" y="0.70004" width="19.6009" height="16.4509" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dx="0.700038" dy="0.700038"/>
                    <feGaussianBlur stdDeviation="0.700038"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.192157 0 0 0 0 0.823529 0 0 0 0 0.556863 0 0 0 0.4 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5721"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_37_5721" result="shape"/>
                </filter>
                <filter id="filter1_d_nilai" x="2.8" y="1.90735e-06" width="16.8009" height="11.9006" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.700038"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.8 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5721"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_37_5721" result="shape"/>
                </filter>
                <filter id="filter2_dd_nilai" x="0.775217" y="2.50774" width="18.0506" height="14.5856" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.350019"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5721"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.700038"/>
                    <feGaussianBlur stdDeviation="0.700038"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5721" result="effect2_dropShadow_37_5721"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5721" result="shape"/>
                </filter>
                <filter id="filter3_dd_nilai" x="-5.14984e-05" y="5.25029" width="16.8009" height="11.9006" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.350019"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5721"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.700038"/>
                    <feGaussianBlur stdDeviation="0.700038"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5721" result="effect2_dropShadow_37_5721"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5721" result="shape"/>
                </filter>
                <linearGradient id="paint0_linear_nilai" x1="11.2005" y1="1.40008" x2="11.2005" y2="10.5006" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#21EB66"/>
                    <stop offset="1" stop-color="#12D583"/>
                </linearGradient>
            </defs>
        </svg>
        @break

    @case('periode')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 23 20', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_periode)">
                <g filter="url(#filter1_d_periode)">
                    <path d="M4.57068 3.04722C4.57068 2.20575 5.25282 1.52361 6.09429 1.52361H18.2832C19.1246 1.52361 19.8068 2.20575 19.8068 3.04722V11.4271C19.8068 12.2686 19.1246 12.9507 18.2832 12.9507H6.09429C5.25282 12.9507 4.57068 12.2686 4.57068 11.4271V3.04722Z" fill="url(#paint0_linear_periode)"/>
                </g>
                <g filter="url(#filter2_dd_periode)">
                    <path d="M1.52356 6.09444V6.85625H16.7597V6.09444C16.7597 5.25297 16.0775 4.57083 15.2361 4.57083H3.04717C2.2057 4.57083 1.52356 5.25297 1.52356 6.09444Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter3_dd_periode)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7597 7.61806V15.2361C16.7597 16.0775 16.0775 16.7597 15.2361 16.7597H3.04717C2.2057 16.7597 1.52356 16.0775 1.52356 15.2361V7.61806H16.7597ZM13.7125 10.6653C14.1332 10.6653 14.4743 10.3242 14.4743 9.90348C14.4743 9.48275 14.1332 9.14167 13.7125 9.14167C13.2917 9.14167 12.9506 9.48275 12.9506 9.90348C12.9506 10.3242 13.2917 10.6653 13.7125 10.6653Z" fill="white" fill-opacity="0.4"/>
                </g>
                <g filter="url(#filter4_dd_periode)">
                    <path d="M5.33257 14.4743C5.33257 14.895 4.99149 15.2361 4.57077 15.2361C4.15004 15.2361 3.80896 14.895 3.80896 14.4743C3.80896 14.0536 4.15004 13.7125 4.57077 13.7125C4.99149 13.7125 5.33257 14.0536 5.33257 14.4743Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter5_dd_periode)">
                    <path d="M5.33257 12.1889C5.33257 12.6096 4.99149 12.9507 4.57077 12.9507C4.15004 12.9507 3.80896 12.6096 3.80896 12.1889C3.80896 11.7682 4.15004 11.4271 4.57077 11.4271C4.99149 11.4271 5.33257 11.7682 5.33257 12.1889Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter6_dd_periode)">
                    <path d="M5.33257 9.90347C5.33257 10.3242 4.99149 10.6653 4.57077 10.6653C4.15004 10.6653 3.80896 10.3242 3.80896 9.90347C3.80896 9.48274 4.15004 9.14166 4.57077 9.14166C4.99149 9.14166 5.33257 9.48274 5.33257 9.90347Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter7_dd_periode)">
                    <path d="M8.37981 14.4743C8.37981 14.895 8.03873 15.2361 7.61801 15.2361C7.19728 15.2361 6.8562 14.895 6.8562 14.4743C6.8562 14.0536 7.19728 13.7125 7.61801 13.7125C8.03873 13.7125 8.37981 14.0536 8.37981 14.4743Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter8_dd_periode)">
                    <path d="M8.37981 12.1889C8.37981 12.6096 8.03873 12.9507 7.61801 12.9507C7.19728 12.9507 6.8562 12.6096 6.8562 12.1889C6.8562 11.7682 7.19728 11.4271 7.61801 11.4271C8.03873 11.4271 8.37981 11.7682 8.37981 12.1889Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter9_dd_periode)">
                    <path d="M8.37981 9.90347C8.37981 10.3242 8.03873 10.6653 7.61801 10.6653C7.19728 10.6653 6.8562 10.3242 6.8562 9.90347C6.8562 9.48274 7.19728 9.14166 7.61801 9.14166C8.03873 9.14166 8.37981 9.48274 8.37981 9.90347Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter10_dd_periode)">
                    <path d="M11.4269 14.4743C11.4269 14.895 11.0859 15.2361 10.6651 15.2361C10.2444 15.2361 9.90332 14.895 9.90332 14.4743C9.90332 14.0536 10.2444 13.7125 10.6651 13.7125C11.0859 13.7125 11.4269 14.0536 11.4269 14.4743Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter11_dd_periode)">
                    <path d="M11.4269 12.1889C11.4269 12.6096 11.0859 12.9507 10.6651 12.9507C10.2444 12.9507 9.90332 12.6096 9.90332 12.1889C9.90332 11.7682 10.2444 11.4271 10.6651 11.4271C11.0859 11.4271 11.4269 11.7682 11.4269 12.1889Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter12_dd_periode)">
                    <path d="M11.4269 9.90347C11.4269 10.3242 11.0859 10.6653 10.6651 10.6653C10.2444 10.6653 9.90332 10.3242 9.90332 9.90347C9.90332 9.48274 10.2444 9.14166 10.6651 9.14166C11.0859 9.14166 11.4269 9.48274 11.4269 9.90347Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter13_dd_periode)">
                    <path d="M14.4742 14.4743C14.4742 14.895 14.1331 15.2361 13.7124 15.2361C13.2916 15.2361 12.9506 14.895 12.9506 14.4743C12.9506 14.0536 13.2916 13.7125 13.7124 13.7125C14.1331 13.7125 14.4742 14.0536 14.4742 14.4743Z" fill="white" fill-opacity="0.6"/>
                </g>
                <g filter="url(#filter14_dd_periode)">
                    <path d="M14.4742 12.1889C14.4742 12.6096 14.1331 12.9507 13.7124 12.9507C13.2916 12.9507 12.9506 12.6096 12.9506 12.1889C12.9506 11.7682 13.2916 11.4271 13.7124 11.4271C14.1331 11.4271 14.4742 11.7682 14.4742 12.1889Z" fill="white" fill-opacity="0.6"/>
                </g>
            </g>
            <defs>
                <filter id="filter0_d_periode" x="0.761754" y="0.761799" width="21.3304" height="18.2834" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dx="0.761806" dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 0.627451 0 0 0 0 0.0705882 0 0 0 0.4 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter1_d_periode" x="3.04707" y="-6.67572e-06" width="18.2833" height="14.4743" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.8 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter2_dd_periode" x="-5.24521e-05" y="3.80903" width="18.2833" height="5.33264" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter3_dd_periode" x="-5.24521e-05" y="6.85625" width="18.2833" height="12.1889" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter4_dd_periode" x="2.28535" y="12.9507" width="4.57078" height="4.57083" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter5_dd_periode" x="2.28535" y="10.6653" width="4.57078" height="4.57083" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter6_dd_periode" x="2.28535" y="8.37986" width="4.57078" height="4.57083" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter7_dd_periode" x="5.33259" y="12.9507" width="4.57078" height="4.57083" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter8_dd_periode" x="5.33259" y="10.6653" width="4.57078" height="4.57083" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter9_dd_periode" x="5.33259" y="8.37986" width="4.57078" height="4.57083" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter10_dd_periode" x="8.37971" y="12.9507" width="4.57078" height="4.57083" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter11_dd_periode" x="8.37971" y="10.6653" width="4.57078" height="4.57083" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter12_dd_periode" x="8.37971" y="8.37986" width="4.57078" height="4.57083" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter13_dd_periode" x="14.4742" y="12.9507" width="4.57078" height="4.57083" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <filter id="filter14_dd_periode" x="14.4742" y="12.1889" width="4.57078" height="4.57083" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="0.380903"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_37_5752"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="0.761806"/>
                    <feGaussianBlur stdDeviation="0.761806"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 1 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_37_5752" result="effect2_dropShadow_37_5752"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_37_5752" result="shape"/>
                </filter>
                <linearGradient id="paint0_linear_periode" x1="12.1887" y1="1.52361" x2="12.1887" y2="12.9507" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#FFBC0E"/>
                    <stop offset="1" stop-color="#FF7C1E"/>
                </linearGradient>
            </defs>
        </svg>
        @break

    @case('search')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break

    @case('refresh')
    @case('reset')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M4 4V9H4.582M20 20V15H19.418M19.938 10C19.446 6.05369 16.0796 3 12 3C8.61868 3 5.67104 5.09341 4.5 8.1M4.062 14C4.554 17.9463 7.9204 21 12 21C15.3813 21 18.329 18.9066 19.5 15.9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break

    @case('eye')
    @case('view')
        <svg {{ $attributes->merge(['class' => 'w-4 h-4', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="12" cy="12" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break

    @case('pencil')
    @case('edit')
        <svg {{ $attributes->merge(['class' => 'w-4 h-4', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M18.5 2.50001C18.8978 2.10219 19.4374 1.87869 20 1.87869C20.5626 1.87869 21.1022 2.10219 21.5 2.50001C21.8978 2.89784 22.1213 3.4374 22.1213 4.00001C22.1213 4.56263 21.8978 5.10219 21.5 5.50001L12 15L8 16L9 12L18.5 2.50001Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break

    @case('trash')
    @case('delete')
        <svg {{ $attributes->merge(['class' => 'w-4 h-4', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M3 6H5H21" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break

    @case('chevron-down')
        <svg {{ $attributes->merge(['class' => 'w-4 h-4', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor']) }} xmlns="http://www.w3.org/2000/svg">
            <path d="M6 9L12 15L18 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break

    @case('setting')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 27 28', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_setting)">
                <path d="M11.4102 4.4274C12.4001 3.85753 13.9495 3.85757 14.9395 4.4274L20.1104 7.41763C22.2198 8.83728 22.3398 9.04741 22.3398 11.277V16.7174C22.3398 18.9473 22.2194 19.1573 20.1494 20.5573L14.9297 23.567C14.4397 23.857 13.7999 23.9977 13.1699 23.9977C12.5399 23.9977 11.8994 23.857 11.3994 23.567L6.22949 20.5768C4.12008 19.1572 4.00002 18.9371 4 16.7077V11.277C4.00001 9.04732 4.11977 8.83696 6.18945 7.43716L11.4102 4.4274ZM13.1699 10.7477C11.375 10.7477 9.91992 12.2028 9.91992 13.9977C9.92017 15.7924 11.3752 17.2477 13.1699 17.2477C14.9647 17.2477 16.4197 15.7924 16.4199 13.9977C16.4199 12.2028 14.9648 10.7477 13.1699 10.7477Z" fill="currentColor"/>
            </g>
            <defs>
                <filter id="filter0_d_setting" x="-2.83008" y="-2.00275" width="32" height="32" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="2"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_setting"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_setting" result="shape"/>
                </filter>
            </defs>
        </svg>
        @break

    @case('logout')
        <svg {{ $attributes->merge(['class' => 'w-6 h-6', 'viewBox' => '0 0 28 28', 'fill' => 'none']) }} xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_logout)">
                <path d="M10.9976 9.2V18.79C10.9976 22 12.9976 24 16.1976 24H18.7876C21.9876 24 23.9876 22 23.9876 18.8V9.2C23.9976 6 21.9976 4 18.7976 4H16.1976C12.9976 4 10.9976 6 10.9976 9.2Z" fill="currentColor"/>
                <g filter="url(#filter1_d_logout)">
                    <path d="M7.5675 10.12L4.2175 13.47C3.9275 13.76 3.9275 14.24 4.2175 14.53L7.5675 17.88C7.8575 18.17 8.3375 18.17 8.6275 17.88C8.9175 17.59 8.9175 17.11 8.6275 16.82L6.5575 14.75H17.2475C17.6575 14.75 17.9975 14.41 17.9975 14C17.9975 13.59 17.6575 13.25 17.2475 13.25H6.5575L8.6275 11.18C8.7775 11.03 8.8475 10.84 8.8475 10.65C8.8475 10.46 8.7775 10.26 8.6275 10.12C8.3375 9.81999 7.8675 9.81999 7.5675 10.12Z" fill="#D9D9D9"/>
                </g>
            </g>
            <defs>
                <filter id="filter0_d_logout" x="-2.00244" y="-2" width="32" height="32" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="2"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_logout"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_logout" result="shape"/>
                </filter>
                <filter id="filter1_d_logout" x="3" y="8.89499" width="17.9976" height="12.2025" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dx="1" dy="1"/>
                    <feGaussianBlur stdDeviation="1"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_logout_inner"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_logout_inner" result="shape"/>
                </filter>
            </defs>
        </svg>
        @break

    @default
        <!-- Icon {{ $name }} not found -->
@endswitch
