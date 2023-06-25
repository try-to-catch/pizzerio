const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'serif': ['Roboto Slab', 'serif'],
                'sans-serif': ['Inter', 'sans-serif'],
            },
            colors: {
                'primary': '#FF7010',
                'light-primary': '#FFEEE2',
                'gray-bg': '#F9F9F9',
                'gray-border': '#F0F0F0',
                'gray-text': '#A5A5A5',
                'black-text': '#191919',
                'red-bg': '#E23535',
            },
            animation: {
                'appear-slow': 'appear 0.3s ease',
            },
            keyframes: {
                appear: {
                    '0%': { opacity: 0 },
                    '100%': { opacity: 1 },
                },
                'emerge': {
                    '0%': { transform: 'translateY(80%)' },
                    '100%': { transform: 'translateY(0%)' },
                }
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
