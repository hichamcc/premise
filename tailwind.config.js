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
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                blue: {
                    // Custom blue shades
                    '50': '#f1f9fa',
                    '100': '#dcf0f1',
                    '200': '#bee1e3',
                    '300': '#91cbcf',
                    '400': '#91cbcf',
                    '500': '#8bc2c8',  // Default blue change
                    '600': '#67b2b9',
                    '700': '#54a1a8',
                    '800': '#4f96a7',
                    '900': '#2c5965',
                },
            },
        },
    },

    plugins: [forms],
};
