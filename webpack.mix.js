const mix = require('laravel-mix');


 mix.js('resources/js/app.js', 'public/js').vue();
 mix.js('resources/js/bootstrap.js', 'public/js');
 mix.sass('resources/sass/app.scss', 'public/css');
 mix.postCss('resources/css/placeholder.css', 'public/css');


