import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { VitePWA } from 'vite-plugin-pwa'; // <-- TAMBAHKAN INI

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        // TAMBAHKAN SELURUH BLOK DI BAWAH INI
        VitePWA({
            registerType: 'autoUpdate',
            manifest: {
                name: 'Laporan Keuangan',
                short_name: 'LapKeu',
                description: 'Aplikasi untuk mencatat laporan keuangan pribadi.',
                theme_color: '#1f2937', // Warna tema (gelap)
                background_color: '#111827',
                display: 'standalone',
                scope: '/',
                start_url: '/admin', // Halaman pertama yang dibuka
                icons: [
                    {
                        src: 'public/images/icons/icon-192x192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: 'public/images/icons/icon-512x512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    }
                ]
            }
        })
    ],
});