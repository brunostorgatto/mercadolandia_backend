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
                // ✅ COR DA MARCA CENTRALIZADA (Verde Emerald do seu layout)
                brand: {
                    50:  '#ecfdf5',
                    100: '#d1fae5',
                    500: '#10b981',
                    600: '#059669', // Verde principal dos botões e do logo
                    700: '#047857',
                    900: '#064e3b',
                }
            }
        },
    },

    plugins: [forms],
};