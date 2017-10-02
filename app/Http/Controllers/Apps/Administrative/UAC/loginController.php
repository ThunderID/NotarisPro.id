<?php

namespace App\Http\Controllers\Apps\Administrative\UAC;

use App\Http\Controllers\Controller;
use TAuth;

class loginController extends Controller
{
	protected $view;

	function __construct () 
	{
		parent::__construct();

		$this->view 		= view ($this->base_view . 'templates.blank');
		$this->base_view 	= $this->base_view . 'pages.administrative.uac.login.';
	}
	
	//fungsi login
	public function create ()
	{
		// init
		$this->page_attributes->title		= 'Sign In';
		$this->page_attributes->subtitle	= 'Silahkan isi email dan password Anda untuk mulai menggunakan system';

		//get data from database
		// $this->page_datas->datas			= null;

		//initialize view
		$this->view->pages 					= view ($this->base_view . 'login');

		//function from parent to generate view
		return $this->generateView(); 
	}

	public function store ()
	{
		//get input
		$credentials				= request()->only(['email', 'password']);

		try
		{
			//do authenticate
			$auth					= TAuth::login($credentials);
		}
		catch (Exception $e)
		{
			if (is_array($e->getMessage()))
			{
				return redirect()->route('uac.login.create')->withErrors($e->getMessage());
			}
			else
			{
				return redirect()->route('uac.login.create')->withErrors([$e->getMessage()]);
			}
		}

		//function from parent to redirecting
		return redirect()->route('dashboard.home.index');
	}

	public function destroy ()
	{
		//do authenticate
		$auth			= TAuth::signoff();

		//function from parent to redirecting
		return redirect()->route('uac.login.create');
	}
}