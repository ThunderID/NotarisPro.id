<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Thunderlabid\Arsip\Models\Arsip;

use TAuth, Response, App, Session, Exception, Carbon\Carbon;

class arsipController extends Controller
{
	function __construct ()
	{
		parent::__construct();
		
		$this->view 		= view ($this->base_view . 'templates.basic');
		$this->base_view 	= $this->base_view . 'pages.arsip.';
	}

	public function index ()
	{
		$arsip 					= Arsip::select(['pemilik', 'lists'])->paginate();

		//1.initialize view
		$this->view->pages		= view ($this->base_view . 'index', compact('arsip'));

		return $this->generateView();  
	}

	public function show ($id)
	{
		$arsip 					= Arsip::findorfail($id);

		//1.initialize view
		$this->view->pages		= view ($this->base_view . 'show', compact('arsip'));

		return $this->generateView();  
	}
}