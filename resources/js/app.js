import Sortable from 'sortablejs';
window.Sortable = Sortable;

// ===========================
// CENTRALIZED AUTO DARK MODE CONTROLLER (WIB 17:00 - 07:00)
// ===========================
function isWibNightTime() {
    try {
        const now = new Date();
        const wibTimeStr = now.toLocaleTimeString('en-US', { timeZone: 'Asia/Jakarta', hour12: false, hour: '2-digit', minute: '2-digit' });
        const [h, m] = wibTimeStr.split(':').map(Number);
        const mins = h * 60 + m;
        // Jam 17:00 WIB (1020 mins) s/d Jam 07:00 WIB (420 mins)
        return mins >= 17 * 60 || mins < 7 * 60;
    } catch (e) {
        const now = new Date();
        const wibHours = (now.getUTCHours() + 7) % 24;
        return wibHours >= 17 || wibHours < 7;
    }
}

function initTheme() {
    const isDark = isWibNightTime();
    
    if (isDark) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    updateThemeIcons(isDark);
}

function toggleTheme() {
    const isDark = document.documentElement.classList.toggle('dark');
    updateThemeIcons(isDark);
}

function updateThemeIcons(isDark) {
    const moonIcons = document.querySelectorAll('.theme-icon-moon');
    const sunIcons = document.querySelectorAll('.theme-icon-sun');
    
    moonIcons.forEach(el => {
        if (isDark) el.classList.add('hidden');
        else el.classList.remove('hidden');
    });
    
    sunIcons.forEach(el => {
        if (isDark) el.classList.remove('hidden');
        else el.classList.add('hidden');
    });
}

// Expose globally to window
window.toggleTheme = toggleTheme;
window.initTheme = initTheme;
window.updateThemeIcons = updateThemeIcons;
window.isWibNightTime = isWibNightTime;

// Initialize when script loads and on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTheme);
} else {
    initTheme();
}

// Check every 30 seconds to automatically switch at 17:00 and 07:00 WIB
setInterval(initTheme, 30000);

// Disable pinch-to-zoom gestures (2+ fingers) on mobile browsers
document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
});
document.addEventListener('gesturechange', function (e) {
    e.preventDefault();
});
document.addEventListener('gestureend', function (e) {
    e.preventDefault();
});
document.addEventListener('touchstart', function (e) {
    if (e.touches.length > 1) {
        e.preventDefault();
    }
}, { passive: false });
