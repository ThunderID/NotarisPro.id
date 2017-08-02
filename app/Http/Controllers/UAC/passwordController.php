<?php

namespace App\Http\Controllers\UAC;

use TAuth, Redirect, URL;

use App\Http\Controllers\Controller;

use App\Infrastructure\Traits\GuidTrait;

use Illuminate\Http\Request;

class passwordController extends Controller
{
	use GuidTrait;

	//fungsi get mail
	public function create(Request $request)
	{
		// init
		$this->page_attributes->title	= 'Password';

		//get data from database
		$this->page_datas->datas			= null;
		$this->page_datas->datas['email']	= $request->get('email');

		//initialize view
		$this->view							= view('market_web.pages.password.create');

		//function from parent to generate view
		return $this->generateView(); 
	}

	public function store()
	{
		
	}
}
