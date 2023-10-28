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
            },
            colors: {
                pink: {
                    '50': '#fce4ec',
                    '100': '#f8bbd0',
                    '200': '#f48fb1',
                    '300': '#f06292',
                    '400': '#ec407a',
                    '500': '#e91e63',
                    '600': '#d81b60',
                    '700': '#c2185b',
                    '800': '#ad1457',
                    '900': '#880e4f',
                },
            },
        },
    },

    plugins: [forms],
};
