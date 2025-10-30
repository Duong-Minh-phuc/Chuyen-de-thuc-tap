import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css','resources/css/headeradmin.css','resources/css/header.css','resources/css/footeradmin.css'],
            refresh: true,
        }),
    ],
});
