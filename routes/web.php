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
// 1. AKTA
Route::group(['namespace' => 'Akta\\'], function(){
	//akta
	Route::resource('/akta/akta', 'aktaController', ['names' => [
		'index' 	=> 'akta.akta.index', //get
		'create'	=> 'akta.akta.create', //get
		'store' 	=> 'akta.akta.store', //post
		'show' 		=> 'akta.akta.show', //get
		'edit' 		=> 'akta.akta.edit', //get
		'update' 	=> 'akta.akta.update', //patch
		'destroy' 	=> 'akta.akta.destroy' //post 
	]]);

	Route::any('/akta/mention/{akta_id}', 						['uses' => 'aktaController@mentionIndex', 	'as' => 'akta.mention.index']);
	Route::any('/akta/versi/{akta_id}', 						['uses' => 'aktaController@versionIndex', 	'as' => 'akta.version.index']);
	Route::any('/akta/versi/{akta_id}/compare/{version_id}', 	['uses' => 'aktaController@versionShow', 	'as' => 'akta.version.show']);
	Route::any('/akta/print/{akta_id}',	 						['uses' => 'aktaController@print', 			'as' => 'akta.akta.print']);

	Route::any('/akta/renvoi/{akta_id}/mark/{key}/{mode}', 		['uses' => 'aktaController@renvoiMark', 	'as' => 'akta.renvoi.mark']);
	Route::any('/akta/status/{akta_id}/{status}',	 			['uses' => 'aktaController@status', 		'as' => 'akta.akta.status']);
	Route::any('/akta/copy/{akta_id}',	 						['uses' => 'aktaController@copy', 			'as' => 'akta.akta.copy']);

	Route::any('/akta/required/dokumen',	 					['uses' => 'aktaController@dokumenIndex', 	'as' => 'akta.dokumen.index']);
});

// 2. TAGIHAN
Route::group(['namespace' => 'Tagihan\\'], function(){
	//tagihan
	Route::resource('/tagihan/tagihan', 'tagihanController', ['names' => [
		'index' 	=> 'tagihan.tagihan.index', //get
		'create'	=> 'tagihan.tagihan.create', //get
		'store' 	=> 'tagihan.tagihan.store', //post
		'show' 		=> 'tagihan.tagihan.show', //get
		'edit' 		=> 'tagihan.tagihan.edit', //get
		'update' 	=> 'tagihan.tagihan.update', //patch
		'destroy' 	=> 'tagihan.tagihan.destroy' //post 
	]]);

	Route::any('/tagihan/print/{tagihan_id}',	 		['uses' => 'tagihanController@print', 		'as' => 'tagihan.tagihan.print']);
	Route::any('/tagihan/status/{tagihan_id}',	 		['uses' => 'tagihanController@status', 	'as' => 'tagihan.tagihan.status']);
});

// 3. KLIEN
Route::group(['namespace' => 'Klien\\'], function(){
	//klien
	Route::resource('/klien/klien', 'klienController', ['names' => [
		'index' 	=> 'klien.klien.index', //get
		// 'create'	=> 'klien.klien.create', //get
		// 'store' 	=> 'klien.klien.store', //post
		'show' 		=> 'klien.klien.show', //get
		// 'edit' 		=> 'klien.klien.edit', //get
		// 'update' 	=> 'klien.klien.update', //patch
		'destroy' 	=> 'klien.klien.destroy' //post 
	]]);

	Route::get('/klien/orang/create',	 			['uses' => 'klienController@orangCreate', 		'as' => 'klien.orang.create']);
	Route::get('/klien/perusahaan/create',	 		['uses' => 'klienController@perusahaanCreate', 	'as' => 'klien.perusahaan.create']);

	Route::post('/klien/orang/store',	 			['uses' => 'klienController@orangStore', 		'as' => 'klien.orang.store']);
	Route::post('/klien/perusahaan/store',	 		['uses' => 'klienController@perusahaanStore', 	'as' => 'klien.perusahaan.store']);

	Route::get('/klien/orang/{id}/edit',	 		['uses' => 'klienController@orangEdit', 		'as' => 'klien.orang.edit']);
	Route::get('/klien/perusahaan/{id}/edit',		['uses' => 'klienController@perusahaanEdit', 	'as' => 'klien.perusahaan.edit']);

	Route::patch('/klien/orang/{id}/update',	 	['uses' => 'klienController@orangUpdate', 		'as' => 'klien.orang.update']);
	Route::patch('/klien/perusahaan/{id}/update',	['uses' => 'klienController@perusahaanUpdate', 	'as' => 'klien.perusahaan.update']);
});

// 4. NOTARIS
Route::group(['namespace' => 'Notaris\\'], function(){
	//notaris
	Route::get('/notaris/notaris',		['uses' => 'notarisController@index', 	'as' => 'notaris.notaris.index']);
});


// AREA PENGATURAN //
Route::group(['namespace' => 'Pengaturan\\'], function(){
	//5. Subscription
	Route::any('/pengaturan/subscription',						['uses' => 'subscriptionController@index', 		'as' => 'pengaturan.subscription.index']);
	Route::any('/pengaturan/subscription/print/{id}',			['uses' => 'subscriptionController@print', 		'as' => 'pengaturan.subscription.print']);
	Route::any('/pengaturan/subscription/recalculate/{mode}',	['uses' => 'subscriptionController@recalculate','as' => 'pengaturan.subscription.recalculate']);

	//6. User
	Route::resource('/pengaturan/user', 'userController', ['names' => [
		'index' 	=> 'pengaturan.user.index', //get
		'create'	=> 'pengaturan.user.create', //get
		'store' 	=> 'pengaturan.user.store', //post
		'show' 		=> 'pengaturan.user.show', //get
		'edit' 		=> 'pengaturan.user.edit', //get
		'update' 	=> 'pengaturan.user.update', //patch
		'destroy' 	=> 'pengaturan.user.destroy' //post 
	]]);

	//7. Kantor
	Route::get('/pengaturan/kantor',		['uses' => 'kantorController@edit', 	'as' => 'pengaturan.kantor.edit']);
	Route::patch('/pengaturan/kantor',		['uses' => 'kantorController@update', 	'as' => 'pengaturan.kantor.update']);

	//8. Akun
	Route::get('/pengaturan/akun',			['uses' => 'akunController@edit', 		'as' => 'pengaturan.akun.edit']);
	Route::patch('/pengaturan/akun',		['uses' => 'akunController@update', 	'as' => 'pengaturan.akun.update']);
});

// AREA UAC //

// 9. Login
Route::group(['namespace' => 'UAC\\'], function(){
	//Login
	Route::get('/login',		['uses' => 'loginController@create', 	'as' => 'uac.login.create']);
	Route::post('/login',		['uses' => 'loginController@store', 	'as' => 'uac.login.store']);
	Route::get('/logout',		['uses' => 'loginController@destroy', 	'as' => 'uac.login.destroy']);

	//Reset Pass
	Route::get('/reset/password',			['uses' => 'passwordController@create', 	'as' => 'uac.reset.create']);
	Route::post('/reset/password',			['uses' => 'passwordController@store',	 	'as' => 'uac.reset.store']);
	Route::get('/change/password/{token}',	['uses' => 'passwordController@edit', 		'as' => 'uac.reset.edit']);
	Route::patch('/change/password/{token}',['uses' => 'passwordController@update', 	'as' => 'uac.reset.update']);
});