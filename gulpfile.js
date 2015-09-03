var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less');
    mix.less('login.less', './public/css/login.css');

    mix.scripts([
    	'jquery-1.8.3.js',
    	'bootstrap.min.js',
    	'vue.min.js',
    	'sb-admin-2.js',
    	'metisMenu.min.js',
    	'jquery-ui-1.9.2.custom.min.js',
    	'jquery.validate.min.js',
    	'datepicker-es.js',
    	'calendarios.js',
        'sweetalert-dev.js'
    ], './public/js/all.js');

    mix.scripts([
        'jquery-1.8.3.js',
        'bootstrap.min.js',
        'jquery.validate.min.js'
        
    ], './public/js/login.js');
});

