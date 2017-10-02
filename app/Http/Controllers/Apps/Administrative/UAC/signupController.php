<?php

namespace App\Http\Controllers\Apps\Administrative\UAC;

use App\Http\Controllers\Controller;

// use App\Infrastructure\Traits\IDRTrait;
// use App\Infrastructure\Traits\GuidTrait;
// use App\Infrastructure\Traits\CountSubscriptionTrait;

// use App\Domain\Administrative\Models\Kantor;
// use App\Domain\Administrative\Models\Pengguna;

use TAuth, Redirect, Carbon\Carbon, Config, Exception, Session;

class signUpController extends Controller
{
	// use GuidTrait;
	// use IDRTrait;
	// use CountSubscriptionTrait;

	function __construct ()
	{
		parent::__construct();

		$this->view 		= view ($this->base_view . 'templates.blank');
		$this->base_view 	= $this->base_view . 'pages.administrative.uac.signup.';
	}

	public function create ()
	{
		// init
		$this->page_attributes->title		= 'Daftarkan Diri Anda';
		$this->page_attributes->subtitle	= 'Isi data diri Anda untuk mendapatkan akses penuh';

		//get data from database
		$this->page_datas->datas			= null;
		$this->page_datas->datas['plan']	= 'starter';

		//initialize view
		$this->view->pages					= view ($this->base_view . 'create');

		//function from parent to generate view
		return $this->generateView(); 
	}
}