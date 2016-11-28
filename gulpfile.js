var elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

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

elixir(function (mix) {
    // mix.copy(
    //     'node_modules/jquery-locationpicker/dist/locationpicker.jquery.js',
    //     'resources/assets/js');

    mix.sass('app.scss', 'resources/css')
        .webpack('app.js');

    mix.styles([
        'libs/bootstrap.min.css',
        'libs/font-awesome.min.css',
        'libs/select2.min.css',
        'libs/AdminLTE.min.css',
        'libs/_all-skins.min.css',
        'libs/typeahead.css',
        'libs/ionicons.min.css',
        '../../../public/css/app.css'
    ]);

    mix.scripts([
        'public/js/app.js',
        'resources/assets/js/requirejs.js',
        'resources/assets/js/jquery.js',
        'resources/assets/js/select2.min.js',
        'resources/assets/js/app.js',
        'resources/assets/js/bootstrap.js',
        'resources/assets/js/locationpicker.jquery.js',
        'resources/assets/js/foundation_calendar-min.js',
        'resources/assets/js/typeahead.bundle.min.js'
        ], 'public/js', './');

    mix.copy('node_modules/Font-Awesome/fonts', 'public/fonts');
    mix.copy('public/bootstrap/dist/fonts', 'public/fonts');
});
