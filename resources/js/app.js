import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Función para el carrusel de productos
window.productCarousel = function() {
    return {
        currentImage: 0,
        images: [],
        
        init() {
            this.$watch('currentImage', () => {
                this.updateDisplay();
            });
            // Obtener las imágenes de los data-image-container
            const containers = this.$el.querySelectorAll('[data-image-container]');
            this.images = Array.from(containers).map(() => null); // Array para contar elementos
            this.updateDisplay();
        },
        
        updateDisplay() {
            const containers = this.$el.querySelectorAll('[data-image-container]');
            containers.forEach((el, idx) => {
                el.style.display = idx === this.currentImage ? 'block' : 'none';
            });
        }
    };
};

Alpine.start();

