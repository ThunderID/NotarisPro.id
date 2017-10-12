
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// plugins
// plugin ajax from @budipurnomo
require ('./plugins/ajax');
// plugin data to send ajax
require ('./plugins/dataBox');
// plugin for editor Quilljs
require ('./plugins/editorQuill');
// plugin select2
require ('./plugins/select2');



// ===================================


// module init
require ('./modules/module');