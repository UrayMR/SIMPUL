// Bootstrap bawaan Laravel
import './bootstrap';

// Load SCSS
// import '../scss/app.scss';

// Bootstrap core JS
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap; // ⬅️ tambahkan baris ini

/* Sneat Core */
import '../sneat/js/helpers.js';
import '../sneat/js/config.js';
import '../sneat/js/menu.js';
import '../sneat/js/ui-toasts.js';
import '../sneat/js/main.js';

import AOS from 'aos';
import 'aos/dist/aos.css';

// Inisialisasi AOS
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,      // durasi animasi (ms)
        once: true,         // animasi hanya sekali
        offset: 120,        // jarak trigger dari bawah viewport
    });
});


/* Log untuk debug */
// console.log("Sneat Loaded:", {
//     helpers: typeof window.Helpers !== "undefined",
//     bootstrap: typeof window.bootstrap !== "undefined", // ✅ tambahkan untuk memastikan
// });
