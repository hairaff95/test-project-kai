<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; }
        .container { max-width: 520px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: #0066FF; padding: 32px 40px; text-align: center; }
        .header h1 { color: #fff; font-size: 22px; margin: 0; font-weight: 700; letter-spacing: -0.5px; }
        .body { padding: 36px 40px; }
        .body p { color: #374151; font-size: 14px; line-height: 1.6; margin: 0 0 16px; }
        .otp-box { background: #F3F7FF; border: 2px dashed #0066FF; border-radius: 12px; text-align: center; padding: 24px; margin: 24px 0; }
        .otp-code { font-size: 40px; font-weight: 800; letter-spacing: 10px; color: #0066FF; }
        .otp-expires { font-size: 12px; color: #6B7280; margin-top: 8px; }
        .warning { background: #FFF7ED; border-left: 4px solid #F59E0B; padding: 12px 16px; border-radius: 6px; font-size: 13px; color: #92400E; }
        .btn-link { display: inline-block; background: #0066FF; color: #fff; text-decoration: none; font-size: 14px; font-weight: 600; padding: 14px 28px; border-radius: 10px; margin-top: 20px; }
        .footer { background: #F9FAFB; padding: 20px 40px; text-align: center; font-size: 12px; color: #9CA3AF; border-top: 1px solid #E5E7EB; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KAI Tracker App</h1>
        </div>
        <div class="body">
            <p>Halo, <strong>{{ $user->name }}</strong>.</p>
            <p>Request reset password Anda telah <strong>disetujui</strong> oleh Super Admin. Gunakan kode OTP berikut untuk melanjutkan proses reset password:</p>

            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-expires">Kode berlaku selama <strong>30 menit</strong></div>
            </div>

            @if($resetRequest)
                <p style="text-align: center;">Atau klik tombol di bawah untuk langsung ke halaman verifikasi:</p>
                <div style="text-align: center;">
                    <a href="{{ route('password.access-token', $resetRequest) }}" class="btn-link">
                        Verifikasi OTP Sekarang →
                    </a>
                </div>
            @endif

            <div class="warning" style="margin-top: 24px;">
                ⚠️ Jangan bagikan kode ini kepada siapapun, termasuk tim IT. Kode ini bersifat rahasia dan hanya untuk Anda.
            </div>

            <p style="margin-top: 20px;">Jika Anda tidak melakukan request ini, abaikan email ini atau hubungi Super Admin segera.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} PT Kereta Api Indonesia (Persero) — Daop 4 Semarang
        </div>
    </div>
</body>
</html>
