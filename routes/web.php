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

//paragraph things
Route::get('/paragraph/buat',		['uses' => 'temporaryParagraphController@form', 		'as' => 'temp.graph.form']);
Route::post('/paragraph/simpan',	['uses' => 'temporaryParagraphController@post', 		'as' => 'temp.graph.post']);
Route::get('/paragraph/lihat',		['uses' => 'temporaryParagraphController@get',	 		'as' => 'temp.graph.get']);
Route::any('/mentioned/lists',		['uses' => 'temporaryParagraphController@mentioning', 	'as' => 'temp.mention']);

Route::get('/test', function () 
{

	return view('thunder');
	return view('test');
	$akta 			= '<span class="medium-editor-mention-at text-danger">@notaris.nama</span> Notaris di <span class="medium-editor-mention-at medium-editor-mention-at-active text-danger">@notaris.alamat</span>. Dengan dihadiri saksi-saksi yang saya, Notaris kenal dan akan disebut bagian akhir akta ini.</span>';

	$pattern3 		= "/<span.*?>|<\/span>/i";
 
	$replace 		= preg_replace($pattern3, '', $akta);

// 	$klien 			= new TQueries\Klien\DaftarKlien;
// 	$klien 			= $klien->get();
// 	dd($klien);
});


// UAC
Route::get('/login',			['uses' => 'uacController@login', 			'as' => 'uac.login']);
Route::post('/login', 			['uses' => 'uacController@doLogin', 		'as' => 'uac.login.post']);

Route::group(['middleware' => ['authenticated']], function()
{
	//uac after logged in
	Route::any('/logout', 					['uses' => 'uacController@logout', 			'as' => 'uac.logout.any']);
	Route::get('activate/{idx}', 			['uses' => 'uacController@activateOffice', 	'as' => 'uac.office.activate']);
	
	Route::group(['namespace' => 'Kantor\\'], function(){
		Route::resource('/notaris/kantor', 'KantorController', ['names' => [
				'index' 	=> 'notaris.kantor.index', //get
				'create'	=> 'notaris.kantor.create', //get
				'store' 	=> 'notaris.kantor.store', //post
				'show' 		=> 'notaris.kantor.show', //get
				'edit' 		=> 'notaris.kantor.edit', //get
				'update' 	=> 'notaris.kantor.update', //patch
				'destroy' 	=> 'notaris.kantor.destroy' //post 
			]]);
	});

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
		Route::get('/akta/template/publish/{id}', 		['uses' => 'templateController@publish', 'as' => 'akta.template.publish']);

		Route::any('/akta/template/auto/save/{id}',		['uses' => 'templateController@automatic_store', 'as' => 'akta.template.automatic.store']);

		Route::get('/akta/template/initial/new',		['uses' => 'templateController@initial', 'as' => 'akta.template.initial']);

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

		Route::any('/akta/akta/status/{id}/{status}', 		['uses' => 'aktaController@status', 'as' => 'akta.akta.status']);
		
		// get list widget template in for akta
		Route::any('/akta/akta/list/mentionable', 			['uses' => 'aktaController@list_widgets', 'as' => 'akta.akta.list.mentionable']);

		// choose template for akta
		Route::get('/akta/akta/pilih/template', 			['uses' => 'aktaController@choose_template', 'as' => 'akta.akta.choose.template']);

		Route::any('/akta/akta/simpan/mention/{akta_id}', 	['uses' => 'aktaController@mention', 'as' => 'akta.akta.simpan.mention']);

		// tandai renvoi
		Route::any('/akta/akta/tandai/renvoi/{akta_id}', 	['uses' => 'aktaController@tandai_renvoi', 'as' => 'akta.akta.tandai.renvoi']);
		
		Route::any('/akta/akta/{id}/edit/renvoi',			['uses'	=> 'aktaController@renvoi', 'as' => 'akta.akta.edit.renvoi']);


		// auto save
		Route::any('/akta/akta/auto/save/{id}',				['uses'	=> 'aktaController@automatic_store', 'as' => 'akta.akta.automatic.store']);

		// versioning akta
		Route::get('/akta/akta/{akta_id}/versioning', 		['uses' => 'aktaController@versioning', 'as' => 'akta.akta.versioning']);

		Route::get('/akta/akta/{akta_id}/pdf',				['uses' => 'aktaController@pdf', 'as' => 'akta.akta.pdf']);

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

	//klien
	Route::group(['namespace' => 'Klien\\'], function(){
		Route::resource('/klien', 'klienController', ['names' => [
			'index' 	=> 'klien.index', //get
			'create'	=> 'klien.create', //get
			'store' 	=> 'klien.store', //post
			'show' 		=> 'klien.show', //get
			'edit' 		=> 'klien.edit', //get
			'update' 	=> 'klien.update', //patch
			'destroy' 	=> 'klien.destroy' //post 
		]]);
	});
});
