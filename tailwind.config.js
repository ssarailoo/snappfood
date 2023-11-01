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
                red: {
                    '50': '#FFEBEE',
                    '100': '#FFCDD2',
                    '200': '#EF9A9A',
                    '300': '#E57373',
                    '400': '#EF5350',
                    '500': '#F44336',
                    '600': '#E53935',
                    '700': '#D32F2F',
                    '800': '#C62828',
                    '900': '#B71C1C',
                },
                blue: {
                    '50': '#E3F2FD',
                    '100': '#BBDEFB',
                    '200': '#90CAF9',
                    '300': '#64B5F6',
                    '400': '#42A5F5',
                    '500': '#2196F3',
                    '600': '#1E88E5',
                    '700': '#1976D2',
                    '800': '#1565C0',
                    '900': '#0D47A1',
                },
                purple: {
                    '50': '#F3E5F5',
                    '100': '#E1BEE7',
                    '200': '#CE93D8',
                    '300': '#BA68C8',
                    '400': '#AB47BC',
                    '500': '#9C27B0',
                    '600': '#8E24AA',
                    '700': '#7B1FA2',
                    '800': '#6A1B9A',
                    '900': '#4A148C',
                },
                violet: {
                    '50': '#F8BBD0',
                    '100': '#F48FB1',
                    '200': '#F06292',
                    '300': '#EC407A',
                    '400': '#E91E63',
                    '500': '#D81B60',
                    '600': '#C2185B',
                    '700': '#AD1457',
                    '800': '#880E4F',
                    '900': '#720D45',
                },


            },
        },
    },

    plugins: [forms],
};
