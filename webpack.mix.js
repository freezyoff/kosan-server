const mix = require('laravel-mix');

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

$_js = "";

mix.js('resources/js/app.js', 'public/js')
	.js('resources/js/dashboard.js', 'public/js')
	
	//service
	.js('resources/js/service-auth.js', 'public/js')
	.js('resources/js/region-service.js', 'public/js');
	

mix.sass('resources/sass/app.scss', 'public/css/app.css');