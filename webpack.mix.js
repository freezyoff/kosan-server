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

//
//service
//
mix.js('resources/js/app.js', 'public/js')
	.js('resources/js/service-auth.js', 'public/js')
	.js('resources/js/region-service.js', 'public/js')
	.sass('resources/sass/app.scss', 'public/css/app.css')
	.sass('resources/sass/brand.scss', 'public/css/brand.css')
	.sass('resources/sass/circular-progressbar.scss', 'public/css/circular-progressbar.css')
	
	.copy('resources/img', 'public/img')
	 
	//
	// Material Dashboard
	//
	.copy('node_modules/material-dashboard/assets/js', 'public/vendor/material-dashboard/js')
	.copy('node_modules/material-dashboard/assets/css', 'public/vendor/material-dashboard/css')
	.copy('node_modules/material-dashboard/assets/img', 'public/vendor/material-dashboard/img')
	.sass('resources/sass/material-dashboard.scss', 'public/vendor/material-dashboard/css/material-dashboard.min.css')
	
	//
	// Kosan
	//
	.js('resources/js/kosan/server-message-listener.js', 'public/js/kosan/server-message-listener.js');
