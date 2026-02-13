import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('userForm', (initial = {}) => ({
    form: {
        name: initial.name || '',
        email: initial.email || '',
        password: '',
        password_confirmation: '',
        role: initial.role || '',
    },
    touched: {},
    errors: {},
    emailCheck: {
        pending: false,
        timer: null,
    },
    userId: initial.userId || '',
    emailCheckUrl: initial.emailCheckUrl || '',
    init() {
        ['name', 'email', 'password', 'password_confirmation', 'role'].forEach((field) => {
            this.$watch(`form.${field}`, () => {
                this.touched[field] = true;
                this.validateField(field);
            });
        });
    },
    isEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    },
    validateField(field) {
        const value = this.form[field] ?? '';
        if (field === 'name') {
            this.errors.name = value.trim() ? '' : 'El nombre es obligatorio.';
        }
        if (field === 'email') {
            if (!value.trim()) {
                this.errors.email = 'El correo electrónico es obligatorio.';
            } else if (!this.isEmail(value)) {
                this.errors.email = 'El correo electrónico no es válido.';
            } else {
                this.errors.email = '';
                this.checkEmailAvailability();
            }
        }
        if (field === 'password') {
            if (!value) {
                this.errors.password = 'La contraseña es obligatoria.';
            } else if (value.length < 8) {
                this.errors.password = 'La contraseña debe tener al menos 8 caracteres.';
            } else {
                this.errors.password = '';
            }
            this.validateField('password_confirmation');
        }
        if (field === 'password_confirmation') {
            if (!this.form.password_confirmation) {
                this.errors.password_confirmation = 'La confirmación es obligatoria.';
            } else if (this.form.password_confirmation !== this.form.password) {
                this.errors.password_confirmation = 'La confirmación no coincide.';
            } else {
                this.errors.password_confirmation = '';
            }
        }
        if (field === 'role') {
            this.errors.role = value ? '' : 'El rol es obligatorio.';
        }
    },
    checkEmailAvailability() {
        if (!this.emailCheckUrl) {
            return;
        }
        if (this.emailCheck.timer) {
            clearTimeout(this.emailCheck.timer);
        }
        const email = this.form.email.trim();
        if (!email || !this.isEmail(email)) {
            return;
        }
        this.emailCheck.timer = setTimeout(async () => {
            this.emailCheck.pending = true;
            try {
                const url = new URL(this.emailCheckUrl, window.location.origin);
                url.searchParams.set('email', email);
                if (this.userId) {
                    url.searchParams.set('user_id', this.userId);
                }
                const response = await fetch(url.toString(), {
                    headers: {
                        'Accept': 'application/json',
                    },
                });
                const data = await response.json();
                if (data && data.available === false) {
                    this.errors.email = data.message || 'El correo electrónico ya está en uso.';
                }
            } catch (error) {
                // Ignore transient failures and let server validation handle it.
            } finally {
                this.emailCheck.pending = false;
            }
        }, 350);
    },
    validateAll() {
        ['name', 'email', 'password', 'password_confirmation', 'role'].forEach((f) => {
            this.touched[f] = true;
            this.validateField(f);
        });
        return Object.values(this.errors).every((msg) => !msg);
    },
}));

Alpine.data('contactForm', (initial = {}) => ({
    form: {
        name: initial.name || '',
        email: initial.email || '',
        subject: initial.subject || '',
        message: initial.message || '',
    },
    touched: {},
    errors: {},
    init() {
        ['name', 'email', 'subject', 'message'].forEach((field) => {
            this.$watch(`form.${field}`, () => {
                this.touched[field] = true;
                this.validateField(field);
            });
        });
    },
    validateField(field) {
        const value = (this.form[field] ?? '').trim();
        if (field === 'email') {
            if (!value) {
                this.errors.email = 'El correo electronico es obligatorio.';
            } else if (!value.includes('@')) {
                this.errors.email = 'El correo electronico debe contener @.';
            } else {
                this.errors.email = '';
            }
            return;
        }

        if (field === 'message') {
            if (!value) {
                this.errors.message = 'Este campo es obligatorio.';
            } else if (value.length < 10) {
                this.errors.message = 'El mensaje debe tener al menos 10 caracteres.';
            } else {
                this.errors.message = '';
            }
            return;
        }

        this.errors[field] = value ? '' : 'Este campo es obligatorio.';
    },
    validateAll() {
        ['name', 'email', 'subject', 'message'].forEach((field) => {
            this.touched[field] = true;
            this.validateField(field);
        });
        return Object.values(this.errors).every((msg) => !msg);
    },
}));

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

