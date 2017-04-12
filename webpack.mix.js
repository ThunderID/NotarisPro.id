const { mix } = require('laravel-mix');

mix.sass('resources/assets/sass/app.scss', 'public/css/app.css')
	.js('resources/assets/js/app.js', 'public/js/app.js')
	.version(['public/css/app.css', 'public/js/app.js'])
	// .copy('resources/assets/fonts', 'public/fonts/')
	// .autoload({ 
	// 	'jquery': ['window.$', 'window.jQuery'],
	// })
	;
