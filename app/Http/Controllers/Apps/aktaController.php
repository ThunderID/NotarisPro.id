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
}