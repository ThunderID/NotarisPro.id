<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Apps\helperController as Helper;

use Thunderlabid\Akta\Models\Akta;
use Thunderlabid\Arsip\Models\Arsip;

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
		$this->page_attributes->title 		= 'AKTA';
		$this->page_attributes->subtitle 	= 'Semua file Akta';

		$akta		= new Akta;
		if(request()->has('jenis') && request()->get('jenis')!='all'){
			$akta 	= $akta->where('jenis', 'like', request()->get('jenis'));
		}

		if(request()->has('q')){
			$akta 	= $akta->where('judul', 'like', '%'.request()->get('q').'%');
		}
		$akta 		= $akta->select(['versi', 'kantor', 'judul', 'jenis', 'status', 'klien', 'updated_at'])->paginate();

		// set component filter
		$filter		= Helper::aktaFilter();

		view()->share('akta', $akta);
		view()->share('filters', $filter);

		//1.initialize view
		$this->view				= view ($this->base_view . 'templates.basic');
		$this->view->sidebar	= view ($this->base_view . 'pages.akta.components.search_filter');
		$this->view->main		= view ($this->base_view . 'pages.akta.index');

		return $this->generateView();  
	}

	public function create ()
	{
		$this->page_attributes->title 	= 'Buat Akta Baru';

		$akta 							= Akta::select(['versi', 'kantor', 'judul', 'jenis', 'status'])->paginate();

		view()->share('akta', $akta);

		$this->view 					= view ($this->base_view . 'templates.blank');
		$this->view->page 				= view ($this->base_view . 'pages.akta.create_option');

		return $this->generateView();
	}	

	public function create_scratch ()
	{
		$this->page_attributes->title 	= 'Data Dokumen';

		$arsip		= $this->getArsip();
		view()->share('arsip', $arsip);

		$this->view 					= view ($this->base_view . 'templates.blank');
		$this->view->pages 				= view ($this->base_view . 'pages.akta.create_scratch');

		return $this->generateView();
	}

	public function store ($id = null)
	{
		$akta	= new Akta;
		$klien 	= [];

		foreach (request()->get('klien') as $k => $v) {
			$klien[] 	= Arsip::where('_id', $v)->first(['_id', 'pemilik'])->toArray();
		}

		try {
			$akta->judul 	= request()->get('judul');
			$akta->jenis 	= request()->get('jenis');
			$akta->klien 	= $klien;

			if(request()->has('paragraf')){
				$akta->paragraf = request()->get('paragraf');
			}
			else
			{
				$akta->paragraf = '<p></p>';
			}
			$akta->status 	= 'drafting';
			$akta->save();

			$message['success'] = ['akta berhasil disimpan'];
			$message['url'] 	= route ('akta.index');

			return redirect()->route('akta.edit', ['id' => $akta->_id]);
		} catch (Exception $e) {
			return redirect()->back()->withErrors($e->getMessage());
		}
	}

	public function show ($id)
	{
		$akta 					= Akta::findorfail($id);

		//1.initialize view
		$this->view->pages		= view ($this->base_view . 'show', compact('akta'));

		return $this->generateView();  
	}


	public function edit($id){
		$akta				= Akta::findorfail($id);
		$akta['pemilik'] 	= array_column($akta->klien, 'pemilik');

		$arsip 	= $this->getArsip();

		view()->share('akta', $akta);
		view()->share('arsip', $arsip);

		$this->view 		= view ($this->base_view . 'templates.blank');
		$this->view->pages 	= view ($this->base_view . 'pages.akta.create', compact('id'));

		return $this->generateView();
	}



	public function update  ($id)
	{
		return $this->store($id);
	}


	public function choose_akta () 
	{
		$this->page_attributes->title 	= 'Buat Akta Baru';

		$akta 							= Akta::select(['versi', 'kantor', 'judul', 'jenis', 'status'])->paginate();

		view()->share('akta', $akta);

		$this->view 					= view ($this->base_view . 'templates.blank');
		$this->view->page 				= view ($this->base_view . 'pages.akta.choose_template');

		return $this->generateView();
	}

	private function getArsip(){
		$arsip		= Arsip::select(['pemilik', 'lists']);
		if(request()->has('q')){
			$arsip 	= $arsip->where('pemilik.nama', 'like', '%'.request()->get('q').'%');
		}

		$arsip 		= $arsip->paginate();

		return response()->json($arsip);
	}
}