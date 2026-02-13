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

Alpine.data('accessibilityPanel', () => ({
    open: false,
    settings: {
        fontFamily: 'default',
        fontSize: '100%',
        filter: 'none',
        contrast: false,
        reduceMotion: false,
    },
    init() {
        const saved = localStorage.getItem('a11y-settings');
        if (saved) {
            try {
                this.settings = { ...this.settings, ...JSON.parse(saved) };
            } catch (error) {
                // Ignore invalid storage values.
            }
        }
        ['fontFamily', 'fontSize', 'filter', 'contrast', 'reduceMotion'].forEach((key) => {
            this.$watch(`settings.${key}`, () => {
                this.applyAndSave();
            });
        });
        this.apply();
    },
    toggle() {
        this.open = !this.open;
    },
    close() {
        this.open = false;
    },
    setFontFamily(value) {
        this.settings.fontFamily = value;
        this.applyAndSave();
    },
    setFontSize(value) {
        this.settings.fontSize = value;
        this.applyAndSave();
    },
    toggleContrast() {
        this.settings.contrast = !this.settings.contrast;
        this.applyAndSave();
    },
    toggleReduceMotion() {
        this.settings.reduceMotion = !this.settings.reduceMotion;
        this.applyAndSave();
    },
    reset() {
        this.settings = {
            fontFamily: 'default',
            fontSize: '100%',
            filter: 'none',
            contrast: false,
            reduceMotion: false,
        };
        this.applyAndSave();
    },
    buttonClass(active) {
        return active
            ? 'rounded-md border border-gold bg-gold text-ebony px-3 py-2 text-sm font-semibold'
            : 'rounded-md border border-gold/30 bg-ebony px-3 py-2 text-sm text-silver hover:border-gold';
    },
    toggleClass(active) {
        return active
            ? 'flex h-6 w-11 items-center rounded-full bg-gold p-0.5'
            : 'flex h-6 w-11 items-center rounded-full bg-ebony border border-gold/30 p-0.5';
    },
    applyAndSave() {
        this.apply();
        localStorage.setItem('a11y-settings', JSON.stringify(this.settings));
    },
    apply() {
        const root = document.documentElement;
        const fontMap = {
            default: 'Figtree, system-ui, sans-serif',
            hyper: 'Atkinson Hyperlegible, Figtree, system-ui, sans-serif',
        };

        root.style.fontSize = this.settings.fontSize;
        root.style.setProperty('--a11y-font-family', fontMap[this.settings.fontFamily] || fontMap.default);

        root.classList.toggle('a11y-font-hyper', this.settings.fontFamily === 'hyper');
        root.classList.toggle('a11y-contrast', this.settings.contrast);
        root.classList.toggle('a11y-reduce-motion', this.settings.reduceMotion);

        root.classList.remove('a11y-filter-deuteranopia', 'a11y-filter-protanopia', 'a11y-filter-tritanopia');
        if (this.settings.filter !== 'none') {
            root.classList.add(`a11y-filter-${this.settings.filter}`);
        }
    },
}));

Alpine.data('dashboardApi', () => ({
    status: 'Cargando datos desde la API...',
    summary: {
        page_visits_total: 0,
        checkout_clicks: 0,
    },
    topFavorites: [],
    topViewed: [],
    topPages: [],
    async load() {
        try {
            const response = await fetch('/api/admin/dashboard/overview', {
                headers: {
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('API no disponible');
            }

            const data = await response.json();
            this.summary = data.summary || { page_visits_total: 0, checkout_clicks: 0 };
            this.topFavorites = data.top_favorites || [];
            this.topViewed = data.top_viewed || [];
            this.topPages = data.top_pages || [];
            this.status = `Actualizado: ${data.generated_at || 'justo ahora'}`;
        } catch (error) {
            this.status = 'No se pudieron cargar los datos de la API.';
            this.summary = { page_visits_total: 0, checkout_clicks: 0 };
            this.topFavorites = [];
            this.topViewed = [];
            this.topPages = [];
        }
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

