import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['public/css/app.css', 'public/css/sweetalert.minimal.css', 'public/js/app.js', 'public/js/pusher.js', 'public/js/sweetalert.js'],
            refresh: true,
        }),
    ],
});
