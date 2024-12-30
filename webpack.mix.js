const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('autoprefixer'),
        require('tailwindcss'), // Tailwind CSS を導入
    ]);
