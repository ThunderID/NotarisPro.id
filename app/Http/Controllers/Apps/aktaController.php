<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Thunderlabid\Akta\Models\Akta;

use App\Http\Controllers\Apps\ArsipController as Arsip;

use TAuth, Response, App, Session, Exception, Carbon\Carbon;

class aktaController extends Controller
{
	function __construct ()
	{
		parent::__construct();
		
		view()->share('active_menu', 'akta');

		// $this->view 			= view ($this->base_view . 'templates.basic');
		// $this->view->page->base = view
		// $this->base_view 	= $this->base_view . 'pages.akta.';
	}

	public function index ()
	{
		$this->page_attributes->title 	= 'Daftar akta dokumen';

		$akta 							= Akta::select(['versi', 'kantor', 'judul', 'jenis', 'status'])->paginate();

		view()->share('akta', $akta);

		//1.initialize view
		$this->view 					= view ($this->base_view . 'templates.basic');
		$this->view->pages 				= view($this->base_view . 'templates.pages.page');
		$this->view->pages->sidebar 	= view ($this->base_view . 'pages.akta.components.search_filter');
		$this->view->pages->main		= view ($this->base_view . 'pages.akta.index');

		return $this->generateView();  
	}

	public function show ($id)
	{
		$akta 					= Akta::findorfail($id);

		//1.initialize view
		$this->view->pages		= view ($this->base_view . 'show', compact('akta'));

		return $this->generateView();  
	}

	public function create ()
	{
		$this->page_attributes->title 	= 'Buat Akta';

		$akta['judul'] 	= request()->get('judul');
		$akta['jenis']	= request()->get('jenis');

		if (request()->has('pemilik')) {
			$tmp = [];
			foreach (request()->get('pemilik') as $k => $v) {
				$tmp[] = ['id' => $k, 'nama' => $v['nama']];
			}
			
			$akta['pemilik'] = $tmp;
		}
		
		view()->share('akta', $akta);

		$this->view 					= view ($this->base_view . 'templates.blank');
		$this->view->pages 				= view ($this->base_view . 'pages.akta.create');

		return $this->generateView();
	}	

	public function edit($id){
		$akta		= Akta::findorfail($id);
		$pemilik 	= array_column($akta->pemilik, 'id');
		$arsip 		= Arsip::select(['pemilik', 'lists'])->whereIn('id', $pemilik)->get();
	
		$this->view->pages		= view ($this->base_view . 'edit', compact('akta', 'arsip'));

		return $this->generateView();
	}

	//data input
	//pemilik[0][id] 	= '23546546s51df23w1frw'
	//pemilik[0][nama] 	= 'Chelsy'
	//judul 			= 'Akta Jual Beli Tanah di Mengwi'
	//jenis 			= 'AJB'
	public function store ()
	{
		$akta 			= new Akta;
		$akta->pemilik 	= request()->get('pemilik');
		$akta->judul 	= request()->get('judul');
		$akta->jenis 	= request()->get('jenis');
		$akta->status 	= 'draft';
		$akta->save();
	}

	public function choose_data_dokumen ()
	{
		$this->page_attributes->title 	= 'Data Dokumen';

		$arsip 							= new Arsip;
		$arsip 							= $arsip->index();

		view()->share('arsip', $arsip);

		$this->view 					= view ($this->base_view . 'templates.blank');
		$this->view->pages 				= view ($this->base_view . 'pages.akta.choose_data_dokumen');

		return $this->generateView();
	}

	public function choose_akta () 
	{
		$this->page_attributes->title 	= 'Buat Akta Baru';

		$this->view 					= view ($this->base_view . 'templates.blank');
		$this->view->page 				= view ($this->base_view . 'pages.akta.choose_template');

		return $this->generateView();
	}
}