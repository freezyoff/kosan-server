const mix = require('laravel-mix');

if (mix.inProduction()) {
	const JavaScriptObfuscator = require('webpack-obfuscator');
	mix.webpackConfig({
		plugins: [
			new JavaScriptObfuscator ({
				deadCodeInjection: true,
				deadCodeInjectionThreshold: 0.4,
				//debugProtectionInterval: false,
				disableConsoleOutput: true,
				identifierNamesGenerator: 'hexadecimal',
				renameGlobals: true,
				rotateStringArray: true,
				shuffleStringArray: true,
				splitStrings: true,
				splitStringsChunkLength: 10,
				stringArray: true,
				stringArrayEncoding: 'base64',
				stringArrayThreshold: 0.75,
				unicodeEscapeSequence: false,
				//debugProtection: true,
				compact: true,
				controlFlowFlattening: true,
				controlFlowFlatteningThreshold: 0.75,
				selfDefending: true,
				transformObjectKeys: true,
				log: false,
				rotateUnicodeArray: true
			}, [
				//exclude obfuscator
			]
			)
		]
	});
}

/*

*/

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

mix.sass('resources/sass/app.scss', 					'public/css/app.css')
	.sass('resources/sass/brand.scss', 					'public/css/brand.css')
	.sass('resources/sass/circular-progressbar.scss', 	'public/css/circular-progressbar.css')
	.sass('resources/sass/spinner.scss', 				'public/css/spinner.css')
	.copy('resources/img', 'public/img');
	
//
// Material Dashboard
//
mix.copy('node_modules/material-dashboard/assets/js', 'public/vendor/material-dashboard/js')
	.copy('node_modules/material-dashboard/assets/css', 'public/vendor/material-dashboard/css')
	.copy('node_modules/material-dashboard/assets/img', 'public/vendor/material-dashboard/img')
	.sass('resources/sass/material-dashboard.scss', 'public/vendor/material-dashboard/css/material-dashboard.min.css');

//
// Kosan
//
mix.js('resources/js/kosan/server-message-listener.js', 'public/js/kosan/server-message-listener.js');

//
//domain: service
//
mix.js('resources/js/app.js', 'public/js')
	.js('resources/js/service-auth.js', 'public/js')
	.js('resources/js/region-service.js', 'public/js');
	
//
//domain: Owner
//
mix.js('resources/js/http/owner/profile.js', 		'public/js/http/owner/profile.js')
	.js('resources/js/http/owner/device-info.js', 	'public/js/http/owner/device-info.js')
   .js('resources/js/http/owner/devices.js', 		'public/js/http/owner/devices.js')
   .js('resources/js/http/owner/access-control.js', 'public/js/http/owner/access-control.js')
   .js('resources/js/http/owner/rooms.js', 			'public/js/http/owner/rooms.js')
   .js('resources/js/http/owner/rooms-access.js', 	'public/js/http/owner/rooms-access.js');

//
//domain: My
//
mix.js('resources/js/http/my/dashboard.js', 		'public/js/http/my/dashboard.js');

mix.version();