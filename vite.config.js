import { defineConfig } from 'vite';

/*
 |--------------------------------------------------------------------------
 | Vite Asset Management
 |--------------------------------------------------------------------------
 |
 | Compiles the Sass entry point to public/css/style.css. The filename is
 | fixed (no hash) because the templates reference /css/style.css directly
 | with a ?v= query string for cache busting.
 |
 */

export default defineConfig(({ mode }) => ({
    // Vite's static-copy feature is unused; public/ is the web root here.
    publicDir: false,
    build: {
        outDir: 'public',
        emptyOutDir: false,
        minify: mode === 'production',
        rollupOptions: {
            input: 'resources/sass/style.scss',
            output: {
                assetFileNames: 'css/style[extname]',
            },
        },
    },
}));
