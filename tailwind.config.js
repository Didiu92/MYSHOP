import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['"Cormorant Garamond"', 'serif'],
                display: ['"Playfair Display"', 'serif'],
            },
            colors: {
                gold: '#D4AF37',
                silver: '#E8E8E8',
                copper: '#B87333',
                ebony: '#0A0A0A',
                graphite: '#1F1F1F',
                primary: {
                    50: '#FFF8E6',
                    100: '#FCEFC2',
                    200: '#F7E59E',
                    300: '#F0D97A',
                    400: '#E8CB56',
                    500: '#D4AF37',
                    600: '#B9912C',
                    700: '#9E7523',
                    800: '#825A1B',
                    900: '#6A4515',
                },
            },
        },
    },

    plugins: [forms],
};
