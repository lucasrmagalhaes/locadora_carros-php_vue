const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('node_modules/popper.js/dist/popper.js', 'public/js').sourceMaps()
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
