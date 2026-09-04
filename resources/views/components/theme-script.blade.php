<script>
    (function() {
        try {
            var now = new Date();
            var str = now.toLocaleTimeString('en-US', { timeZone: 'Asia/Jakarta', hour12: false, hour: '2-digit', minute: '2-digit' });
            var parts = str.split(':');
            var mins = parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
            var isDark = mins >= 1020 || mins < 420;
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        } catch (e) {
            var wibH = (new Date().getUTCHours() + 7) % 24;
            if (wibH >= 17 || wibH < 7) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    })();
</script>
