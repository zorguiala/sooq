const elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;

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

elixir(mix => {
    mix.styles([
            'header3.css',
            'switcher.css',
            'color4.css',
            '/icons/tonicons/style.css',
            '/icons/material/css/materialdesignicons.min.css',
            'bootstrap-rtl.css',
            'core-rtl.css',
            'semantic.css',
            'style-rtl.css',
            'stylesheet.css',
            'header1.css',
            
        ], 'public/css/front.css')
        .scripts([
            
            '/core/libraries/jquery_ui/core.min.js',
            '/core/app.js',
            '/plugins/ui/ripple.min.js',
            '/plugins/ui/ripple.min.js',
            '/plugins/forms/styling/uniform.min.js',
            '/plugins/forms/validation/validate.min.js',
            '/plugins/forms/selects/select2.min.js',
            '/core/libraries/bootstrap.min.js',

        ], 'public/js/front.js');
});

