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


// Configure Vue 3 support
mix.js('resources/js/app.js', 'public/js')
    .vue({
        version: 3,
        extractStyles: true,
        globalStyles: false
    })
    .webpackConfig({
        resolve: {
            alias: {
                vue: 'vue/dist/vue.esm-bundler.js',
            },
        },
    })
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .sourceMaps()
    .version();

// Disable success notifications
mix.disableSuccessNotifications();
