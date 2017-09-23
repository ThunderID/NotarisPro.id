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

//A. AREA PENGATURAN ADMINISTRATIVE //
Route::group(['namespace' => 'Administrative\\'], function(){
	// AREA UAC //
	Route::group(['namespace' => 'UAC\\'], function(){
		//A1. REGISTER TRIAL
		Route::group(['prefix' => 'trial'], function(){
			Route::get('/signup',		['uses' => 'signupController@trialCreate', 	'as' => 'uac.tsignup.create']);
			Route::post('/signup',		['uses' => 'signupController@trialStore', 	'as' => 'uac.tsignup.store']);
			Route::get('/edit',			['uses' => 'signupController@trialEdit', 	'as' => 'uac.tsignup.edit']);
			Route::post('/update',		['uses' => 'signupController@trialUpdate', 	'as' => 'uac.tsignup.update']);
		});

		//A2. REGISTER STARTER
		Route::group(['prefix' => 'subscription'], function(){
			Route::get('/signup',		['uses' => 'signupController@create', 	'as' => 'uac.signup.create']);
			Route::post('/signup',		['uses' => 'signupController@store', 	'as' => 'uac.signup.store']);
		});

		//A3. LOGIN
		Route::get('/',				['uses' => 'loginController@create',	'as' => 'uac.login.create']);
		Route::get('/login',		['uses' => 'loginController@create', 	'as' => 'uac.login.create']);
		Route::post('/login',		['uses' => 'loginController@store', 	'as' => 'uac.login.store']);
		Route::get('/logout',		['uses' => 'loginController@destroy', 	'as' => 'uac.login.destroy']);

		//A4. RESET PASSWORD
		Route::get('/reset/password',				['uses' => 'passwordController@create', 'as' => 'uac.reset.create']);
		Route::any('/reset/password/store',			['uses' => 'passwordController@store',	'as' => 'uac.reset.store']);
		Route::get('/change/password/{rtoken}',		['uses' => 'passwordController@edit', 	'as' => 'uac.reset.edit']);
		Route::post('/change/password/{rtoken}',	['uses' => 'passwordController@update', 'as' => 'uac.reset.update']);
	});

	// AREA SETTING //
	Route::group(['middleware' => 'whitelists_notaris'], function(){
		//A5. SETTING OFFICE
		Route::get('/administrative/kantor',		['uses' => 'kantorController@edit', 	'as' => 'administrative.kantor.edit', 'middleware' => 'scopes:office_setting']);
		Route::patch('/administrative/kantor',		['uses' => 'kantorController@update', 	'as' => 'administrative.kantor.update', 'middleware' => 'scopes:office_setting']);

		Route::get('/administrative/developer',		['uses' => 'developerController@edit', 	'as' => 'administrative.developer.edit', 'middleware' => 'scopes:developer_setting']);
		Route::patch('/administrative/developer',	['uses' => 'developerController@update','as' => 'administrative.developer.update', 'middleware' => 'scopes:developer_setting']);

		//A7. SETTING USER
		Route::resource('/administrative/user', 'userController', ['names' => [
			'index' 	=> 'administrative.user.index', //get
			'create'	=> 'administrative.user.create', //get
			'store' 	=> 'administrative.user.store', //post
			'show' 		=> 'administrative.user.show', //get
			'edit' 		=> 'administrative.user.edit', //get
			'update' 	=> 'administrative.user.update', //patch
			'destroy' 	=> 'administrative.user.destroy' //post 
		], 'middleware' => 'scopes:user_setting']);

		//A8. SETTING ACCOUNT
		Route::get('/administrative/akun',			['uses' => 'akunController@edit', 		'as' => 'administrative.akun.edit', 'middleware' => 'scopes:personal_setting']);
		Route::patch('/administrative/akun',		['uses' => 'akunController@update', 	'as' => 'administrative.akun.update', 'middleware' => 'scopes:personal_setting']);
	});
});

// AREA SUBSCRIPTION //
Route::group(['namespace' => 'Subscription\\', 'middleware' => ['whitelists_notaris','scope:subscription_setting']], function(){
	//B1. Subscription
	Route::any('/subscription/tagihan',						['uses' => 'tagihanController@index', 		'as' => 'subscription.tagihan.index']);
	Route::any('/subscription/tagihan/print/{id}',			['uses' => 'tagihanController@print', 		'as' => 'subscription.tagihan.print']);
	Route::any('/subscription/tagihan/recalculate/{mode}',	['uses' => 'tagihanController@recalculate',	'as' => 'subscription.tagihan.recalculate']);
	Route::any('/subscription/tagihan/bayar/{nomor}',		['uses' => 'tagihanController@payCreate',	'as' => 'subscription.tagihan.bayar']);
});

// AREA TAGIHAN //
Route::group(['namespace' => 'Tagihan\\', 'middleware' => ['whitelists_notaris']], function(){
	// C1. TAGIHAN
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

// AREA JADWAL //
Route::group(['namespace' => 'Jadwal\\', 'middleware' => ['whitelists_notaris']], function(){
	// C1. JADWAL
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

//AREA DASHBOARD//
Route::group(['namespace' => 'Dashboard\\', 'prefix' => 'dashboard', 'middleware' => ['whitelists_notaris']], function(){
	//D1. DASHBOARD
	Route::get('/',		['uses' => 'dashboardController@home',	'as' => 'dashboard.home.index']);
});


Route::group(['middleware' => 'trial'], function(){

	// 1. AKTA - ACL DONE
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

		Route::any('/akta/akta/store', 							['uses' => 'aktaController@store', 			'as' => 'akta.akta.store.test']);
		Route::any('/akta/akta/{id}',							['uses' => 'aktaController@update',			'as' => 'akta.akta.update.ajax']);

		Route::any('/akta/mention/all', 						['uses' => 'aktaController@mentionIndex', 	'as' => 'akta.mention.index']);
		Route::any('/akta/mention/all/store', 					['uses' => 'aktaController@mentionStore', 	'as' => 'akta.mention.store']);
		
		Route::any('/akta/mention/prefix', 						['uses' => 'aktaController@mentionPrefixIndex', 	'as' => 'akta.mention_prefix.index']);
		Route::any('/akta/mention/prefix/store', 				['uses' => 'aktaController@mentionPrefixStore', 	'as' => 'akta.mention_prefix.store']);

		Route::any('/akta/versi/{akta_id}', 					['uses' => 'aktaController@versionIndex', 	'as' => 'akta.version.index']);
		Route::any('/akta/versi/{akta_id}/compare/{version_id}',['uses' => 'aktaController@versionShow', 	'as' => 'akta.version.show']);
		Route::any('/akta/print/{akta_id}',	 					['uses' => 'aktaController@print', 			'as' => 'akta.akta.print']);

		Route::any('/akta/renvoi/{akta_id}/mark/{key}/{mode}', 	['uses' => 'aktaController@renvoiMark', 	'as' => 'akta.renvoi.mark']);
		Route::any('/akta/status/{akta_id}/{status}',	 		['uses' => 'aktaController@status', 		'as' => 'akta.akta.status']);
		Route::any('/akta/copy/{akta_id}',	 					['uses' => 'aktaController@copy', 			'as' => 'akta.akta.copy']);
		Route::any('/akta/trashed',	 							['uses' => 'aktaController@trashed', 		'as' => 'akta.akta.trash']);
		Route::any('/akta/chooseTemplate',	 					['uses' => 'aktaController@chooseTemplate', 		'as' => 'akta.akta.choooseTemplate']);

		Route::any('/akta/required/dokumen',	 				['uses' => 'aktaController@dokumenIndex', 	'as' => 'akta.dokumen.index']);

		Route::any('/akta/dropbox/{id}/store',	 				['uses' => 'aktaController@dropboxStore', 	'as' => 'akta.dropbox.store']);

		Route::get('/akta/ajax/{id}', 							['uses' => 'aktaController@ajaxShow', 		'as' => 'akta.ajax.show']);
	});

	// 3. ARSIP
	Route::group(['namespace' => 'Arsip\\'], function(){
		//arsip
		Route::resource('/arsip/arsip', 'arsipController', ['names' => [
			'index' 	=> 'arsip.arsip.index', //get
			'create'	=> 'arsip.arsip.create', //get
			'store' 	=> 'arsip.arsip.store', //post
			'show' 		=> 'arsip.arsip.show', //get
			'edit' 		=> 'arsip.arsip.edit', //get
			'update' 	=> 'arsip.arsip.update', //patch
			'destroy' 	=> 'arsip.arsip.destroy' //post 
		]]);
		Route::get('/arsip/ajax/{id}', 							['uses' => 'arsipController@ajaxShow', 		'as' => 'arsip.ajax.show']);

	});

	//AREA DASHBOARD//
	Route::group(['namespace' => 'Dashboard\\', 'prefix' => 'dashboard'], function(){
		//13. DASHBOARD
		Route::get('/',					['uses' => 'dashboardController@home',	'as' => 'dashboard.home.index']);
	});
});

//AREA WEB//
Route::group(['namespace' => 'Web\\', 'prefix' => 'market/web'], function(){
	// 14. Home
	Route::get('/',					['uses' => 'webController@home', 		'as' => 'web.home.index']);
	Route::get('/service',			['uses' => 'webController@service', 	'as' => 'web.service.index']);
	Route::get('/pricing',			['uses' => 'webController@pricing', 	'as' => 'web.pricing.index']);
	Route::get('/tutorial',			['uses' => 'webController@tutorial', 	'as' => 'web.tutorial.index']);
	Route::get('/notaris',			['uses' => 'notarisController@index', 	'as' => 'web.notaris.index']);
});
