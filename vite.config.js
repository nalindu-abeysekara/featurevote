import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            input: {
                main: resolve(__dirname, 'resources/js/app.js'),
                styles: resolve(__dirname, 'resources/css/app.css')
            }
        }
    },
    server: {
        origin: 'http://localhost:5173',
        cors: true
    }
});
