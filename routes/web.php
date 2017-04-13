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

Route::get('/test', function () 
{
	$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];

	$login 			= TAuth::login($credentials);

	$jadwal 		= new TQueries\Jadwal\DaftarJadwal;
	$jadwal 		= $jadwal->get();
	dd($jadwal);

	$template 		= new TQueries\Akta\DaftarTemplateAkta;
	$template 		= $template->get();
	dd($template);

	$akta 			= new TQueries\Akta\DaftarAkta;
	$akta 			= $akta->get($filter);
	dd($akta);

	$klien 			= new TQueries\Klien\DaftarKlien;
	$klien 			= $klien->get();
	dd($klien);
});


// UAC
Route::get('/login', ['uses' => 'uacController@login', 'as' => 'uac.login']);
Route::post('/login', ['uses' => 'uacController@doLogin', 'as' => 'uac.login.post']);
Route::any('/logout', ['uses' => 'uacController@logout', 'as' => 'uac.logout.post']);

Route::group(['middleware' => ['authenticated']], function()
{
	// general
	Route::get('/', ['uses' => 'homeController@dashboard', 'as' => 'home.dashboard']);

	// Akta
	Route::group(['namespace' => 'Akta\\'], function(){
		//template akta
		Route::resource('/akta/template', 'templateController', ['names' => [
			'index' 	=> 'akta.template.index', //get
			'create'	=> 'akta.template.create', //get
			'store' 	=> 'akta.template.store', //post
			'show' 		=> 'akta.template.show', //get
			'edit' 		=> 'akta.template.edit', //get
			'update' 	=> 'akta.template.update', //patch
			'destroy' 	=> 'akta.template.destroy' //post 
		]]);

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
	});

	// Jadwal
	Route::group(['namespace' => 'Jadwal\\'], function(){
		//bpn
		Route::resource('/jadwal/bpn', 'bpnJadwalController', ['names' => [
			'index' 	=> 'jadwal.bpn.index', //get
			'create'	=> 'jadwal.bpn.create', //get
			'store' 	=> 'jadwal.bpn.store', //post
			'show' 		=> 'jadwal.bpn.show', //get
			'edit' 		=> 'jadwal.bpn.edit', //get
			'update' 	=> 'jadwal.bpn.update', //patch
			'destroy' 	=> 'jadwal.bpn.destroy' //post 
		]]);

		//klien
		Route::resource('/jadwal/klien', 'klienJadwalController', ['names' => [
			'index' 	=> 'jadwal.klien.index', //get
			'create'	=> 'jadwal.klien.create', //get
			'store' 	=> 'jadwal.klien.store', //post
			'show' 		=> 'jadwal.klien.show', //get
			'edit' 		=> 'jadwal.klien.edit', //get
			'update' 	=> 'jadwal.klien.update', //patch
			'destroy' 	=> 'jadwal.klien.destroy' //post 
		]]);	
	});
});
