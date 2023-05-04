import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
            'resources/js/app.js',
          ],
            refresh: true,
        }),
    ],
    resolve: {
      alias: {
        '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
      }
    },
    server: {
      host: "192.168.10.10",
      watch: {
        usePolling: true,
      }
    }
});
