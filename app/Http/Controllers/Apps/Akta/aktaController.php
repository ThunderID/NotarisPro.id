<?php

namespace App\Http\Controllers\Apps\Akta;

use App\Http\Controllers\Controller;

use TAuth, Response, App, Session, Exception, Carbon\Carbon;

class aktaController extends Controller
{
	function __construct ()
	{
		parent::__construct();
		
		// $this->query            = $query;
		// $this->per_page 		= (int)env('DATA_PERPAGE');

		view()->share('active_menu', 'akta');
		
		$this->view 		= view ($this->base_view . 'templates.basic'); 
	}

	public function index ($id = null)
	{
		// $this->middleware('scope:read_akta');

		// $this->active_office 				= TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title		= 'Akta Dokumen';
		$this->page_datas->id 				= $id;

		// 2. call all aktas data needed
		//2a. parse query searching
		$query 								= request()->only('cari', 'status', 'jenis', 'urutkan', 'page');

		//2b. retrieve all akta
		// $this->retrieveAkta($query);

		//2c. get all filter 
		// $this->page_datas->filters 			= $this->retrieveAktaFilter();
		
		//2d. get all urutan 
		// $this->page_datas->urutkan 			= $this->retrieveAktaUrutkan();

		//3.initialize view
		$this->view->page 					= view ($this->base_view . 'templates.pages.page_sidebar_left');
		$this->view->page->sidebar 			= view ($this->base_view . 'pages.akta.components.search_filter');
		$this->view->page->main				= view ($this->base_view . 'pages.akta.index');

		return $this->generateView();  
	}
}