const mix = require('laravel-mix');
const path = require("path");
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .webpackConfig({
            resolve: {
                extensions: [".ts", ".tsx", ".js", ".jsx", ".vue", "*"],
                alias: {
                    '@': path.resolve(__dirname, 'resources/js/'),
                },
            },
        }
    )
    .sass('resources/sass/app.scss', 'public/css')
    .css('resources/css/app.css','public/css')
    .sourceMaps();

