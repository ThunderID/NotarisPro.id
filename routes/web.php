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
    //A. AREA PENGATURAN ADMINISTRATIVE //
    Route::namespace('Administrative')->group( function (){
        // AREA UAC //
        Route::namespace('UAC')->group( function () {

            //A1. REGISTER TRIAL
            // Route::group(['prefix' => 'trial'], function(){
            // 	Route::get('/signup',		            ['uses' => 'signupController@trialCreate', 	'as' => 'uac.tsignup.create']);
            // 	Route::post('/signup',		            ['uses' => 'signupController@trialStore', 	'as' => 'uac.tsignup.store']);
            // 	Route::get('/edit',			            ['uses' => 'signupController@trialEdit', 	'as' => 'uac.tsignup.edit']);
            // 	Route::post('/update',		            ['uses' => 'signupController@trialUpdate', 	'as' => 'uac.tsignup.update']);
            // });

            //A2. REGISTER STARTER
            Route::prefix('subscription')->group( function() {
            	Route::get('/signup',		            ['uses' => 'signupController@create', 	'as' => 'uac.signup.create']);
            // 	Route::post('/signup',		            ['uses' => 'signupController@store', 	'as' => 'uac.signup.store']);
            });

            //A3. LOGIN
            Route::get('/',				                ['uses' => 'loginController@create',	'as' => 'uac.login.create']);
            Route::get('/login',		                ['uses' => 'loginController@create', 	'as' => 'uac.login.create']);
            Route::post('/login',		                ['uses' => 'loginController@store', 	'as' => 'uac.login.store']);
            Route::get('/logout',		                ['uses' => 'loginController@destroy', 	'as' => 'uac.login.destroy']);

            //A4. RESET PASSWORD
            Route::get('/reset/password',				['uses' => 'passwordController@create', 'as' => 'uac.reset.create']);
            Route::any('/reset/password/store',			['uses' => 'passwordController@store',	'as' => 'uac.reset.store']);
            Route::get('/change/password/{token}',		['uses' => 'passwordController@edit', 	'as' => 'uac.reset.edit']);
            Route::post('/change/password/{token}',	    ['uses' => 'passwordController@update', 'as' => 'uac.reset.update']);
        });
    });

    Route::group([], function(){
        
        // 1. AKTA - ACL DONE
        Route::namespace('Akta')->group( function(){
            //akta
            Route::resource('/akta', 'aktaController', ['names' => [
                'index' 	=> 'akta.akta.index', //get
                'create'	=> 'akta.akta.create', //get
                'store' 	=> 'akta.akta.store', //post
                'show' 		=> 'akta.akta.show', //get
                'edit' 		=> 'akta.akta.edit', //get
                'update' 	=> 'akta.akta.update', //patch
                'destroy' 	=> 'akta.akta.destroy' //post 
            ]]);
    
            // Route::any('/akta/akta/store', 							['uses' => 'aktaController@store', 			'as' => 'akta.akta.store.test']);
            // Route::any('/akta/akta/{id}',							['uses' => 'aktaController@update',			'as' => 'akta.akta.update.ajax']);
        
            // Route::any('/akta/mention/default',						['uses' => 'aktaController@mentionDefault',	'as' => 'akta.mention.default.ajax']);
    
            // Route::any('/akta/mention/all', 						['uses' => 'aktaController@mentionIndex', 	'as' => 'akta.mention.index']);
            // Route::any('/akta/mention/all/store', 					['uses' => 'aktaController@mentionStore', 	'as' => 'akta.mention.store']);
            
            // Route::any('/akta/mention/prefix', 						['uses' => 'aktaController@mentionPrefixIndex', 	'as' => 'akta.mention_prefix.index']);
            // Route::any('/akta/mention/prefix/store', 				['uses' => 'aktaController@mentionPrefixStore', 	'as' => 'akta.mention_prefix.store']);
    
            // Route::any('/akta/versi/{akta_id}', 					['uses' => 'aktaController@versionIndex', 	'as' => 'akta.version.index']);
            // Route::any('/akta/versi/{akta_id}/compare/{version_id}',['uses' => 'aktaController@versionShow', 	'as' => 'akta.version.show']);
            // Route::any('/akta/print/{akta_id}',	 					['uses' => 'aktaController@print', 			'as' => 'akta.akta.print']);
    
            // Route::any('/akta/renvoi/{akta_id}/mark/{key}/{mode}', 	['uses' => 'aktaController@renvoiMark', 	'as' => 'akta.renvoi.mark']);
            // Route::any('/akta/status/{akta_id}/{status}',	 		['uses' => 'aktaController@status', 		'as' => 'akta.akta.status']);
            // Route::any('/akta/copy/{akta_id}',	 					['uses' => 'aktaController@copy', 			'as' => 'akta.akta.copy']);
            // Route::any('/akta/trashed',	 							['uses' => 'aktaController@trashed', 		'as' => 'akta.akta.trash']);
            // Route::any('/akta/chooseTemplate',	 					['uses' => 'aktaController@chooseTemplate', 		'as' => 'akta.akta.choooseTemplate']);
    
            // Route::any('/akta/required/dokumen',	 				['uses' => 'aktaController@dokumenIndex', 	'as' => 'akta.dokumen.index']);
    
            // Route::any('/akta/dropbox/{id}/store',	 				['uses' => 'aktaController@dropboxStore', 	'as' => 'akta.dropbox.store']);
    
            // Route::get('/akta/ajax/{id}', 							['uses' => 'aktaController@ajaxShow', 		'as' => 'akta.ajax.show']);
        });
    
        // 3. ARSIP
        // Route::namespace('Arsip')->group( function(){
            //arsip
            // Route::resource('/arsip/arsip', 'arsipController', ['names' => [
                // 'index' 	=> 'arsip.arsip.index', //get
                // 'create'	=> 'arsip.arsip.create', //get
                // 'store' 	=> 'arsip.arsip.store', //post
                // 'show' 		=> 'arsip.arsip.show', //get
                // 'edit' 		=> 'arsip.arsip.edit', //get
                // 'update' 	=> 'arsip.arsip.update', //patch
                // 'destroy' 	=> 'arsip.arsip.destroy' //post 
            // ]]);
            // Route::get('/arsip/ajax/{id}', 							['uses' => 'arsipController@ajaxShow', 		'as' => 'arsip.ajax.show']);
    
        // });
    
        //AREA DASHBOARD//
        // Route::group(['namespace' => 'Dashboard\\', 'prefix' => 'dashboard'], function(){
            //13. DASHBOARD
            // Route::get('/',					['uses' => 'dashboardController@home',	'as' => 'dashboard.home.index']);
        // });
    });
});
