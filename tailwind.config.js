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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'utgz-bg': '#F0F4F8',
                'utgz-primary': '#1A3A6B',
                'utgz-accent': '#2D7DD2',
                'utgz-sidebar': '#0D1B2A',
                'utgz-text': '#1C1C1E',
                'utgz-subtext': '#6B7280',
                'utgz-success': '#10B981',
                'utgz-error': '#EF4444',
                'utgz-warning': '#F59E0B',
            }
        },
    },

    plugins: [forms],
};
