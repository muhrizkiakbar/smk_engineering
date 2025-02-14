import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~@fortawesome': path.resolve(__dirname, 'node_modules/@fortawesome/fontawesome-free/css/all.css'),
        }
    },
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'jaldis_kab_banjar.test'
        }
    }
});
