<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password — KAI Tracker App</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
            background-color: #f0f4f8;
            color: #1a202c;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            width: 100%;
            padding: 40px 16px;
            background-color: #f0f4f8;
        }

        .container {
            max-width: 540px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
        }

        /* ── HEADER ── */
        .header {
            background: #0055D4;
            padding: 28px 40px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header-logo {
            display: block;
            height: 36px;
            width: auto;
        }

        .header-divider {
            width: 1px;
            height: 32px;
            background: rgba(255,255,255,0.35);
            flex-shrink: 0;
        }

        .header-title {
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.2px;
            line-height: 1.3;
        }

        .header-subtitle {
            color: rgba(255,255,255,0.75);
            font-size: 12px;
            font-weight: 400;
            margin-top: 2px;
        }

        /* ── BODY ── */
        .body {
            padding: 36px 40px;
        }

        .greeting {
            font-size: 16px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 12px;
        }

        .body p {
            font-size: 14px;
            line-height: 1.7;
            color: #4a5568;
            margin-bottom: 0;
        }

        /* ── OTP BOX ── */
        .otp-box {
            background: #EEF4FF;
            border: 2px solid #3285FF;
            border-radius: 14px;
            text-align: center;
            padding: 28px 24px 22px;
            margin: 28px 0;
        }

        .otp-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #3285FF;
            margin-bottom: 12px;
        }

        .otp-code {
            font-size: 46px;
            font-weight: 800;
            letter-spacing: 14px;
            color: #0055D4;
            line-height: 1;
            padding-left: 14px; /* compensate letter-spacing on last char */
        }

        .otp-expires {
            font-size: 12px;
            color: #718096;
            margin-top: 12px;
            line-height: 1.5;
        }

        .otp-expires strong {
            color: #E53E3E;
        }

        /* ── CTA BUTTON ── */
        .cta-wrap {
            text-align: center;
            margin: 8px 0 28px;
        }

        .cta-text {
            font-size: 13px;
            color: #718096;
            margin-bottom: 14px;
        }

        .btn-link {
            display: inline-block;
            background: #0055D4;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            padding: 14px 32px;
            border-radius: 10px;
            letter-spacing: 0.2px;
        }

        /* ── WARNING BOX ── */
        .warning {
            background: #FFFBEB;
            border: 1px solid #F6AD55;
            border-left: 4px solid #DD6B20;
            padding: 14px 16px;
            border-radius: 8px;
            font-size: 13px;
            color: #7B341E;
            line-height: 1.6;
            margin-top: 4px;
        }

        .warning strong {
            color: #C05621;
        }

        .note {
            font-size: 13px;
            color: #718096;
            line-height: 1.7;
            margin-top: 20px;
        }

        /* ── FOOTER ── */
        .footer {
            background: #F7FAFC;
            border-top: 1px solid #E2E8F0;
            padding: 20px 40px;
            text-align: center;
            font-size: 12px;
            color: #A0AEC0;
            line-height: 1.6;
        }

        /* ── RESPONSIVE ── */
        @media only screen and (max-width: 580px) {
            .header        { padding: 22px 24px; }
            .body          { padding: 28px 24px; }
            .footer        { padding: 18px 24px; }
            .otp-code      { font-size: 36px; letter-spacing: 10px; padding-left: 10px; }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container">

        {{-- ── HEADER ── --}}
        <div class="header">
            {{-- KAI Logo SVG (inline, white fill) --}}
            <svg class="header-logo" viewBox="0 0 294.74 124.22" xmlns="http://www.w3.org/2000/svg" aria-label="Logo KAI">
                <path fill="#ffffff" d="M99.58,124.22h28.56l-6.55-10.77Zm16.67-19.53L86.56,55.91,144.12,0H98.65a13.65,13.65,0,0,0-9.54,3.88L48.79,43.28,53.33,0H12.27L0,116.81a6.71,6.71,0,0,0,6.68,7.42h33.6L43.07,98,55.45,86l21.78,34.43a8.13,8.13,0,0,0,6.87,3.78H99.58l7.81-15.57Z"/>
                <path fill="#ed6b23" d="M141,124.22l55.61-33.81,7.08,28.71a6.71,6.71,0,0,0,6.52,5.11h36L230.13,70l61.24-37.24.26-2.5-192,93.95Zm83.38-73.65L209.37,0H174a19.52,19.52,0,0,0-17.45,10.77L106,111.37,292,26.52l.29-2.85ZM164.6,74.24,177,48l3.27-7.25a2.23,2.23,0,0,1,4.19.38l5.67,23Z"/>
                <path fill="#ffffff" d="M269.53,0a19.52,19.52,0,0,0-19.41,17.49l-2.5,23.88,44.69-17.7L294.74,0Zm-30.6,124.22h43l9.42-91.45L245.6,60.61Z"/>
            </svg>

            <div class="header-divider"></div>

            <div>
                <div class="header-title">KAI Tracker App</div>
                <div class="header-subtitle">Sistem Informasi Aset — Daop 4 Semarang</div>
            </div>
        </div>

        {{-- ── BODY ── --}}
        <div class="body">

            <p class="greeting">Halo, {{ $user->name }}.</p>
            <p>
                Request reset password Anda telah <strong style="color:#2D3748;">disetujui</strong> oleh Super Admin.
                Gunakan kode OTP berikut untuk melanjutkan proses penggantian kata sandi:
            </p>

            {{-- OTP Box --}}
            <div class="otp-box">
                <div class="otp-label">Kode Verifikasi OTP</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-expires">
                    Kode ini berlaku selama <strong>10 menit</strong> sejak email ini dikirim.<br>
                    Segera masukkan sebelum kedaluwarsa.
                </div>
            </div>

            {{-- CTA Button --}}
            @if($resetRequest)
                <div class="cta-wrap">
                    <p class="cta-text">Atau klik tombol berikut untuk langsung ke halaman verifikasi:</p>
                    <a href="{{ route('password.access-token', $resetRequest) }}" class="btn-link">
                        Verifikasi OTP Sekarang &rarr;
                    </a>
                </div>
            @endif

            {{-- Warning --}}
            <div class="warning">
                &#9888;&#65039; <strong>Jangan bagikan kode ini kepada siapapun</strong>, termasuk tim IT atau Super Admin.
                Kode ini bersifat rahasia dan hanya untuk Anda gunakan sendiri.
            </div>

            <p class="note">
                Jika Anda tidak merasa mengajukan request ini, abaikan email ini dan segera hubungi Super Admin
                untuk menonaktifkan request yang ada.
            </p>

        </div>

        {{-- ── FOOTER ── --}}
        <div class="footer">
            &copy; {{ date('Y') }} PT Kereta Api Indonesia (Persero) &mdash; Daop 4 Semarang<br>
            Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.
        </div>

    </div>
</div>
</body>
</html>
