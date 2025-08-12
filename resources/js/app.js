import './bootstrap';
import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

// Configure Swiper modules
Swiper.use([Navigation, Pagination, Autoplay]);

// Initialize Alpine
window.Alpine = Alpine;
Alpine.start();

// Make Swiper available globally
window.Swiper = Swiper;

// Initialize components when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper for fasilitas if element exists
    if (document.querySelector('.fasilitasSwiper')) {
        new Swiper('.fasilitasSwiper', {
            modules: [Navigation, Pagination, Autoplay],
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    }
});