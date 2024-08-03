import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/calendar.js',
                'resources/js/alerts.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            'bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            'aos': path.resolve(__dirname, 'node_modules/aos'),
            'glightbox': path.resolve(__dirname, 'node_modules/glightbox'),
            'swiper': path.resolve(__dirname, 'node_modules/swiper'),
        },
    },
});
