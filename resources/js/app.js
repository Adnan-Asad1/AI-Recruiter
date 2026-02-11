import './bootstrap';

import AOS from 'aos';
import 'aos/dist/aos.css';
import Alpine from 'alpinejs';

// Init AOS
AOS.init({
  duration: 800,   // animation duration in ms
  once: false,      // animation only once on scroll
});

// Alpine.js
window.Alpine = Alpine;
Alpine.start();
