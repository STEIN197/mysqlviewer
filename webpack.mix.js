const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
	.scripts([
		// 'resources/js/jquery-3.5.1.min.js',
		// 'resources/js/bootstrap-4.1.3.min.js',
		// 'resources/js/vue.js',
		'resources/js/app.js'
	], 'public/js/app.min.js')
	.styles([
		// 'resources/css/bootstrap-4.1.3.min.css',
		'resources/css/template.min.css'
	], "public/css/template.min.css")
    .sass('resources/css/app.scss', 'public/css', {
		sassOptions: {
			outputStyle: "compressed"
		}
	}).version();
