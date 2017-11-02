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
	Route::resource('/akta', 'aktaController');
	Route::any('akta/create/scratch',	['uses' => 'aktaController@create_scratch',		'as' => 'akta.create.scratch']);

	// 2. ARSIP
	Route::resource('/arsip', 'arsipController');

	// Route for ajax
	Route::any('arsip/dokumen/store',					['uses' => 'arsipController@store',				'as' => 'arsip.arsip.ajax.store']);
	Route::any('arsip/{id}/dokumen/update',				['uses' => 'arsipController@update',			'as' => 'arsip.arsip.ajax.update']);
});
