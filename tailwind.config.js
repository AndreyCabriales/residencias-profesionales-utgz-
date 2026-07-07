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
                'utgz-bg': '#F8FAFC', // Slate 50 (SaaS light background)
                'utgz-primary': '#047857', // Emerald 600 (Elegant UTGZ Green)
                'utgz-accent': '#10B981', // Emerald 500 (Vibrant Green for highlights)
                'utgz-sidebar': '#022C22', // Emerald 950 (Very deep green, almost black for sidebar)
                'utgz-text': '#0F172A', // Slate 900 (Dark text)
                'utgz-subtext': '#64748B', // Slate 500 (Muted text)
                'utgz-success': '#10B981', 
                'utgz-error': '#E11D48', // Rose 600 (Elegant UTGZ Red)
                'utgz-warning': '#F59E0B',
            }
        },
    },

    plugins: [forms],
};
