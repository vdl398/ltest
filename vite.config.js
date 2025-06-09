import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
	    vue(),
        laravel({
            input: [
			    'resources/css/app.css', 
				'resources/js/app.js', 
				'resources/js/product_edit.js',
				'resources/js/product_ext.js',
				'resources/js/order_edit.js',
				'resources/js/basket.js',
			],
            refresh: true,
        }),
    ],
});
