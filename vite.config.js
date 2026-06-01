import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // 'resources/css/app-main.css',
                // 'resources/js/app.js',

                'resources/assets/admin/app-style.css',
                'resources/assets/admin/app-style-rtl.css',
                'resources/assets/admin/data-tables.css',

                'resources/assets/admin/app-script.js',
                'resources/assets/admin/data-tables.js',

                // 'resources/assets/admin/app-charts.js',

                'resources/assets/site/app.css',
                'resources/assets/site/app_en.css',
                'resources/assets/site/app.js',
            ],
            refresh: true,
        }),
    ],
});