const { mix } = require('laravel-mix');

mix.autoload({
	jquery: ['$', 'window.jQuery', 'jQuery']
});
mix.sass('resources/assets/sass/app.scss', 'public/css/app.css')
	.js('resources/assets/js/app.js', 'public/js/app.js')
	.version()
	// .copy('resources/assets/font', 'public/font/')
	// .autoload({ 
	// 	'jquery': ['window.$', 'window.jQuery'],
	// })
	;
