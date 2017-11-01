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

	Route::any('akta/ajax/{id}',				['uses' => 'aktaController@ajax_show',				'as' => 'akta.akta.ajax.show']);
	Route::any('akta/create/choose/',			['uses' => 'aktaController@choose_akta', 			'as' => 'akta.akta.choose']);
	Route::any('akta/data-dokumen/choose',		['uses' => 'aktaController@choose_data_dokumen',	'as' => 'akta.akta.data.choose']);
	Route::any('akta/akta/store/new',			['uses' => 'aktaController@store',					'as' => 'akta.akta.ajax.store']);
	
	Route::any('akta/akta/update/{id}',			['uses' => 'aktaController@update',					'as' => 'akta.akta.update.ajax']);

	// 2. ARSIP
	Route::resource('/arsip', 'arsipController');

	// Route for ajax
	Route::any('arsip/dokumen/store',					['uses' => 'arsipController@store',				'as' => 'arsip.arsip.ajax.store']);
	Route::any('arsip/{id}/dokumen/update',				['uses' => 'arsipController@update',			'as' => 'arsip.arsip.ajax.update']);
});
