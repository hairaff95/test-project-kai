<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Sementara Anda — KAI Tracker App</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #F8FAFC;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #000000;
            -webkit-font-smoothing: antialiased;
        }
        .email-wrapper {
            width: 100%;
            background-color: #F8FAFC;
            padding: 48px 16px;
            box-sizing: border-box;
        }
        .email-card {
            max-width: 440px;
            margin: 0 auto;
            background-color: #FFFFFF;
            border-radius: 24px;
            padding: 48px 36px 44px 36px;
            text-align: center;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.04);
            box-sizing: border-box;
        }
        .illustration-wrap {
            margin: 0 auto 32px auto;
            text-align: center;
        }
        .illustration-wrap img {
            width: 120px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .main-heading {
            font-size: 28px;
            font-weight: 800;
            color: #000000;
            margin: 0 0 14px 0;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }
        .sub-heading {
            font-size: 13px;
            color: #4B5563;
            line-height: 1.5;
            margin: 0 auto 32px auto;
            max-width: 320px;
        }
        .otp-display {
            font-size: 24px;
            font-weight: 800;
            color: #000000;
            margin: 0 0 32px 0;
            letter-spacing: 4px;
            font-family: monospace, 'Plus Jakarta Sans', sans-serif;
            word-break: break-all;
        }
        .expiry-note {
            font-size: 13px;
            color: #6B7280;
            margin: 0 0 32px 0;
        }
        .expiry-note strong {
            color: #2878F5;
            font-weight: 600;
        }
        .security-warning {
            font-size: 12px;
            color: #8C929D;
            line-height: 1.55;
            margin: 0 auto 40px auto;
            max-width: 330px;
        }
        .btn-link {
            display: inline-block;
            background-color: #0066FF;
            color: #FFFFFF !important;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 8px;
            margin-bottom: 32px;
        }
        .footer-logo {
            text-align: center;
            margin: 0 auto;
        }
        .footer-logo img {
            width: 138px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-card">
            
            {{-- Top Envelope Illustration from public/images/ --}}
            <div class="illustration-wrap">
                <img src="{{ asset('images/email-envelope-verify.svg') }}" width="120" height="120" alt="Verifikasi Email" />
            </div>

            {{-- Title --}}
            <h1 class="main-heading">Password Sementara Anda</h1>

            {{-- Subtitle --}}
            <p class="sub-heading">
                Halo <strong>{{ $user->name }}</strong>, berikut adalah password sementara Anda untuk masuk ke sistem.
            </p>

            {{-- Temporary Password Display --}}
            <div class="otp-display">{{ $tempPassword }}</div>

            {{-- Expiry Notice --}}
            <p class="expiry-note">
                Password sementara ini berlaku selama <strong>2 menit.</strong>
            </p>

            {{-- Security Notice --}}
            <p class="security-warning">
                Jangan bagikan password ini kepada siapa pun. Segera ganti kata sandi setelah berhasil masuk.
            </p>

            {{-- Login button --}}
            <div>
                <a href="{{ route('login') }}" class="btn-link">
                    Masuk Sekarang
                </a>
            </div>

            {{-- Footer KAI Tracker App Logo from public/images/ --}}
            <div class="footer-logo">
                <img src="{{ asset('images/kai-tracker-logo.svg') }}" width="138" height="34" alt="KAI Tracker App" />
            </div>

        </div>
    </div>
</body>
</html>
