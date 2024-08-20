import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.jsx',

                // Custom for mib
                'resources/sass/app.scss',
                'resources/sass/admins/admin.scss',
                'resources/sass/editor/theme.scss',
                'resources/js/app.js',
                'resources/js/builder/builder.js',
                'resources/js/builder/inventory.js',
                'resources/js/admins/admin.js',
                'resources/js/editor/editor.js',
                'resources/js/userautocomplete.js',
                'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
                'node_modules/bootstrap-icons/font/bootstrap-icons.css'
            ],
            refresh: true,
        }),
        react(),
    ],
});
