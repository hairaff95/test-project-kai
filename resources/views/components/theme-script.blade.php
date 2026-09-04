<script>
    (function() {
        try {
            var saved = localStorage.getItem('kai_theme');
            var isDark;

            if (saved === 'dark') {
                isDark = true;
            } else if (saved === 'light') {
                isDark = false;
            } else {
                // Belum pernah di-set manual → pakai jam WIB (17:00 - 07:00)
                var now = new Date();
                var str = now.toLocaleTimeString('en-US', { timeZone: 'Asia/Jakarta', hour12: false, hour: '2-digit', minute: '2-digit' });
                var parts = str.split(':');
                var mins = parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
                isDark = mins >= 1020 || mins < 420;
            }

            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        } catch (e) {
            // Fallback jika localStorage tidak tersedia
            var wibH = (new Date().getUTCHours() + 7) % 24;
            if (wibH >= 17 || wibH < 7) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    })();
</script>
