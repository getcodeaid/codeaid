var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass([
        'app.scss'
    ]);
    mix.styles([
        'vendor/whiteplum.css'
    ]);
    mix.scripts(['app.js', 'renderSnip.js'], 'public/js/app.js');
    mix.scripts('createSnip.js', 'public/js/createSnip.js');
    mix.version(['public/js/app.js', 'public/css/app.css', 'public/css/all.css', 'public/js/createSnip.js']);
});
