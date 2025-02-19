const mix = require('laravel-mix');
// const webpack = require('webpack');

// mix.js('resources/js/app.js', 'public/js')
//     .autoload({
//         jquery: ['$', 'window.jQuery'], 
//     });

mix.js('resources/js/app.js', 'public/js')
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery']
    })
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
