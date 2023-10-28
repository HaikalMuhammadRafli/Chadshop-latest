import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/sass/style-1.scss',
                'resources/sass/style-2.scss',
                'resources/sass/style-3.scss',
                'resources/sass/style-dashboard.scss',
                'resources/sass/style-admin.scss',
            ],
            refresh: true,
        }),
    ],
});
