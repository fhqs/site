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
    mix.sass('app.scss')
    	.browserify('app.js')
    	.stylesIn('public/css')
    	.scriptsIn("public/js");

 	// concat all style sheets
	mix.styles([
		"app.css",
		"style.css",
		],
		'public/css/app.css' ,'public/css');

	mix.version('public/css/app.css');

	mix.scripts([
        "app.js",
        "custom.js"
    ],
	'public/js/app.js' ,'public/js');
});
