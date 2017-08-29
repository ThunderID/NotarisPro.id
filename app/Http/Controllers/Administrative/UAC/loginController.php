<?php

namespace App\Http\Controllers\Administrative\UAC;

use TAuth, Redirect, Request, URL;

use App\Http\Controllers\Controller;

class loginController extends Controller
{
	//fungsi login
	public function create(){
		// init
		$this->page_attributes->title		= 'Sign In';
		$this->page_attributes->subtitle	= 'Silahkan isi email dan password Anda untuk mulai menggunakan system';

		//get data from database
		$this->page_datas->datas			= null;

		//initialize view
		$this->view							= view('notaris.pages.administrative.uac.login.create');

		//function from parent to generate view
		return $this->generateView(); 
	}

	public function store(){
		//get input
		$credentials				= Request::only('email', 'password');

		try
		{
			//do authenticate
			$auth					= TAuth::login($credentials);
		}
		catch(Exception $e)
		{
			if(is_array($e->getMessage()))
			{
				return Redirect::route('uac.login.create')->withErrors($e->getMessage());
			}
			else
			{
				return Redirect::route('uac.login.create')->withErrors([$e->getMessage()]);
			}
		}

		//function from parent to redirecting
		return Redirect::route('dashboard.home.index');
	}

	public function destroy(){
		//do authenticate
		$auth			= TAuth::signoff();

		//function from parent to redirecting
		return Redirect::route('uac.login.create');
	}
}
