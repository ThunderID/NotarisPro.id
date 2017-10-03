<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// FOR APPS

Route::namespace('Apps')->group( function (){
	// 1. AKTA
	Route::resource('/akta', 'aktaController', ['names' => [
		'index' 	=> 'akta.akta.index', //get
		'create'	=> 'akta.akta.create', //get
		'store' 	=> 'akta.akta.store', //post
		'show' 		=> 'akta.akta.show', //get
		'edit' 		=> 'akta.akta.edit', //get
		'update' 	=> 'akta.akta.update', //patch
		'destroy' 	=> 'akta.akta.destroy' //post 
	]]);

	// 2. ARSIP
	Route::resource('/arsip', 'arsipController', ['names' => [
		'index' 	=> 'arsip.arsip.index', //get
		'create'	=> 'arsip.arsip.create', //get
		'store' 	=> 'arsip.arsip.store', //post
		'show' 		=> 'arsip.arsip.show', //get
		'edit' 		=> 'arsip.arsip.edit', //get
		'update' 	=> 'arsip.arsip.update', //patch
		'destroy' 	=> 'arsip.arsip.destroy' //post 
	]]);
});
