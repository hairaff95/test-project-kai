<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Sementara</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; }
        .container { max-width: 520px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: #F37021; padding: 32px 40px; text-align: center; }
        .header h1 { color: #fff; font-size: 22px; margin: 0; font-weight: 700; letter-spacing: -0.5px; }
        .body { padding: 36px 40px; }
        .body p { color: #374151; font-size: 14px; line-height: 1.6; margin: 0 0 16px; }
        .pass-box { background: #FFF7ED; border: 2px dashed #F37021; border-radius: 12px; text-align: center; padding: 24px; margin: 24px 0; }
        .pass-code { font-size: 24px; font-weight: 800; letter-spacing: 4px; color: #F37021; font-family: monospace; word-break: break-all; }
        .warning { background: #FEF2F2; border-left: 4px solid #EF4444; padding: 12px 16px; border-radius: 6px; font-size: 13px; color: #7F1D1D; }
        .steps { background: #F0FDF4; border-radius: 8px; padding: 16px 20px; margin-top: 16px; }
        .steps ol { margin: 0; padding-left: 20px; font-size: 13px; color: #374151; line-height: 1.8; }
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
            <p>Karena request reset password Anda belum disetujui Super Admin dalam <strong>1 menit</strong>, sistem secara otomatis mengirimkan password sementara. Berikut adalah password sementara Anda:</p>

            <div class="pass-box">
                <div class="pass-code">{{ $tempPassword }}</div>
            </div>

            <div class="warning">
                ⏱️ Password sementara ini <strong>hanya berlaku selama 2 menit</strong> sejak email ini dikirim. Setelah habis, ajukan request reset password baru melalui halaman login (maksimal 3x request per siklus).
            </div>

            <div class="steps">
                <strong style="font-size: 13px; color: #15803D;">Langkah selanjutnya:</strong>
                <ol>
                    <li>Login menggunakan password sementara di atas <strong>sebelum 2 menit habis</strong></li>
                    <li>Jika sudah login, segera pergi ke menu <strong>Ubah Kata Sandi</strong></li>
                    <li>Buat password baru yang aman</li>
                    <li>Jika waktu habis, ajukan request baru dari halaman login</li>
                </ol>
            </div>

            <p style="margin-top: 20px;">Jika Anda tidak merasa melakukan request ini, segera hubungi Super Admin.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} PT Kereta Api Indonesia (Persero) — Daop 4 Semarang
        </div>
    </div>
</body>
</html>
