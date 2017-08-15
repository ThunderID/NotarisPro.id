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

	Route::any('/akta/mention/{akta_id}', 					['uses' => 'aktaController@mentionIndex', 	'as' => 'akta.mention.index']);
	Route::any('/akta/versi/{akta_id}', 					['uses' => 'aktaController@versionIndex', 	'as' => 'akta.version.index']);
	Route::any('/akta/versi/{akta_id}/compare/{version_id}',['uses' => 'aktaController@versionShow', 	'as' => 'akta.version.show']);
	Route::any('/akta/print/{akta_id}',	 					['uses' => 'aktaController@print', 			'as' => 'akta.akta.print']);

	Route::any('/akta/renvoi/{akta_id}/mark/{key}/{mode}', 	['uses' => 'aktaController@renvoiMark', 	'as' => 'akta.renvoi.mark']);
	Route::any('/akta/status/{akta_id}/{status}',	 		['uses' => 'aktaController@status', 		'as' => 'akta.akta.status']);
	Route::any('/akta/copy/{akta_id}',	 					['uses' => 'aktaController@copy', 			'as' => 'akta.akta.copy']);
	Route::any('/akta/trashed',	 							['uses' => 'aktaController@trashed', 		'as' => 'akta.akta.trash']);

	Route::any('/akta/required/dokumen',	 				['uses' => 'aktaController@dokumenIndex', 	'as' => 'akta.dokumen.index']);


	Route::any('/akta/dropbox/{id}/store',	 				['uses' => 'aktaController@dropboxStore', 	'as' => 'akta.dropbox.store']);
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

	Route::any('/tagihan/print/{tagihan_id}',	 		['uses' => 'tagihanController@print',	'as' => 'tagihan.tagihan.print']);
	Route::any('/tagihan/status/{tagihan_id}/{status}',	['uses' => 'tagihanController@status', 	'as' => 'tagihan.tagihan.status']);
});

// 2A. JADWAL
Route::group(['namespace' => 'Jadwal\\'], function(){
	//tagihan
	Route::resource('/jadwal/bpn', 'bpnController', ['names' => [
		'index' 	=> 'jadwal.bpn.index', //get
		'create'	=> 'jadwal.bpn.create', //get
		'store' 	=> 'jadwal.bpn.store', //post
		'show' 		=> 'jadwal.bpn.show', //get
		'edit' 		=> 'jadwal.bpn.edit', //get
		'update' 	=> 'jadwal.bpn.update', //patch
		'destroy' 	=> 'jadwal.bpn.destroy' //post 
	]]);
});


// 3. KLIEN
Route::group(['namespace' => 'Klien\\'], function(){
	//klien
	Route::resource('/klien/klien', 'klienController', ['names' => [
		'index' 	=> 'klien.klien.index', //get
		'create'	=> 'klien.klien.create', //get
		'store' 	=> 'klien.klien.store', //post
		'show' 		=> 'klien.klien.show', //get
		'edit' 		=> 'klien.klien.edit', //get
		'update' 	=> 'klien.klien.update', //patch
		'destroy' 	=> 'klien.klien.destroy' //post 
	]]);

	Route::any('/klien/document/{id}/add',		 		['uses' => 'klienController@addDokumen', 		'as' => 'klien.dokumen.add']);
	Route::any('/klien/document/{id}/remove/{doc_id}',	['uses' => 'klienController@removeDokumen', 	'as' => 'klien.dokumen.remove']);
});

// 4. NOTARIS
Route::group(['namespace' => 'Notaris\\'], function(){
	//notaris
	Route::get('/notaris/notaris',		['uses' => 'notarisController@index', 	'as' => 'notaris.notaris.index']);
});


// AREA PENGATURAN //
Route::group(['namespace' => 'Pengaturan\\'], function(){
	//5. Subscription
	Route::any('/pengaturan/tagihan',					['uses' => 'tagihanController@index', 		'as' => 'pengaturan.tagihan.index']);
	Route::any('/pengaturan/tagihan/print/{id}',		['uses' => 'tagihanController@print', 		'as' => 'pengaturan.tagihan.print']);
	Route::any('/pengaturan/tagihan/recalculate/{mode}',['uses' => 'tagihanController@recalculate',	'as' => 'pengaturan.tagihan.recalculate']);

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

	//8b. Developer
	Route::get('/pengaturan/developer',		['uses' => 'developerController@edit', 	'as' => 'pengaturan.developer.edit']);
	Route::patch('/pengaturan/developer',	['uses' => 'developerController@update','as' => 'pengaturan.developer.update']);
});

// AREA UAC //
Route::group(['namespace' => 'UAC\\'], function(){
	// 9. Login
	Route::get('/login',		['uses' => 'loginController@create', 	'as' => 'uac.login.create']);
	Route::post('/login',		['uses' => 'loginController@store', 	'as' => 'uac.login.store']);
	Route::get('/logout',		['uses' => 'loginController@destroy', 	'as' => 'uac.login.destroy']);

	//10. Reset Pass
	Route::get('/reset/password',			['uses' => 'passwordController@create', 	'as' => 'uac.reset.create']);
	Route::any('/reset/password/store',		['uses' => 'passwordController@store',	 	'as' => 'uac.reset.store']);
	// Route::get('/reset/password/success',	['uses' => 'passwordController@show',	 	'as' => 'uac.reset.show']);
	Route::get('/change/password/{rtoken}',		['uses' => 'passwordController@edit', 		'as' => 'uac.reset.edit']);
	Route::post('/change/password/{rtoken}',	['uses' => 'passwordController@update', 		'as' => 'uac.reset.update']);

	// 11. Register free trial
	Route::group(['prefix' => 'trial'], function(){
		Route::get('/signup',		['uses' => 'signupController@trialCreate', 	'as' => 'uac.tsignup.create']);
		Route::post('/signup',		['uses' => 'signupController@trialStore', 	'as' => 'uac.tsignup.store']);
		Route::post('/upgrade',		['uses' => 'signupController@trialUpdate', 	'as' => 'uac.tsignup.update']);
	});

	//12. Register with plan
	Route::group(['prefix' => 'subscription'], function(){
		Route::get('/signup',		['uses' => 'signupController@create', 	'as' => 'uac.signup.create']);
		Route::post('/signup',		['uses' => 'signupController@store', 	'as' => 'uac.signup.store']);
	});
});

//AREA DASHBOARD//
Route::group(['namespace' => 'Dashboard\\', 'prefix' => 'dashboard'], function(){
	//13. DASHBOARD
	Route::get('/',					['uses' => 'dashboardController@home',	'as' => 'dashboard.home.index']);
});

//AREA WEB//
Route::group(['namespace' => 'Web\\', 'prefix' => 'market/web'], function(){
	// 14. Home
	Route::get('/',					['uses' => 'webController@home', 		'as' => 'web.home.index']);
	Route::get('/service',			['uses' => 'webController@service', 	'as' => 'web.service.index']);
	Route::get('/pricing',			['uses' => 'webController@pricing', 	'as' => 'web.pricing.index']);
	Route::get('/tutorial',			['uses' => 'webController@tutorial', 	'as' => 'web.tutorial.index']);
});

// Route::get('/market/web', function () { return view('market_web.pages.home'); });

