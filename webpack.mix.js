const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// Combine JavaScript files into one
mix.combine([
    'public/assets/js/main.js',
    'public/assets/js/cart-laravel.js',
    'public/assets/js/effects.js',
    'public/assets/js/form-validation.js'
], 'public/js/app.min.js')
    // Combine CSS files into one
    .styles([
        'public/assets/css/styles.css',
        'public/assets/css/responsive.css',
        'public/assets/css/notifications.css',
        'public/assets/css/cart.css'
    ], 'public/css/app.min.css')
    .options({
        processCssUrls: false
    })
    .version();
