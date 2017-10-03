<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Thunderlabid\Akta\Models\Akta;

use TAuth, Response, App, Session, Exception, Carbon\Carbon;

class aktaController extends Controller
{
	function __construct ()
	{
		parent::__construct();
		
		$this->view 		= view ($this->base_view . 'templates.basic');
		$this->base_view 	= $this->base_view . 'pages.akta.';
	}

	public function index ()
	{
		$akta 					= Akta::select(['versi', 'kantor', 'judul', 'jenis', 'status'])->paginate();

		//1.initialize view
		$this->view->pages		= view ($this->base_view . 'index', compact('akta'));

		return $this->generateView();  
	}

	public function show ($id)
	{
		$akta 					= Akta::findorfail($id);

		//1.initialize view
		$this->view->pages		= view ($this->base_view . 'show', compact('akta'));

		return $this->generateView();  
	}
}