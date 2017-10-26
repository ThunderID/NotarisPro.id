<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Apps\ArsipController as Arsip;
use App\Http\Controllers\Apps\helperController as Helper;

use Thunderlabid\Akta\Models\Akta;

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

		$akta		= new Akta;
		if(request()->has('jenis') && request()->get('jenis')!='all'){
			$akta 	= $akta->where('jenis', 'like', request()->get('jenis'));
		}

		if(request()->has('q')){
			$akta 	= $akta->where('judul', 'like', '%'.request()->get('q').'%');
		}
		$akta 		= $akta->select(['versi', 'kantor', 'judul', 'jenis', 'status', 'pihak', 'updated_at'])->paginate();
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

		$akta['dokumen']['ktp']	=	['nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'pekerjaan', 'alamat'];

		$arsipList = new Arsip;
		$arsipList = $arsipList->index();

		view()->share('akta', $akta);
		view()->share('arsip', $arsipList);

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
	public function store ($id = null)
	{
		$akta 			= new Akta;

		try {
			$akta->pemilik 	= request()->get('pemilik');
			$akta->judul 	= request()->get('judul');
			$akta->jenis 	= request()->get('jenis');
			$akta->paragraf = request()->get('paragraf');
			$akta->status 	= 'draft';

			$akta->save();

			$message['success'] = ['akta berhasil disimpan'];
			$message['url'] 	= route ('akta.akta.index');

			return response()->json($message);
		} catch (Exception $e) {
			$message['error']	= ['gagal menyimpan akta'];
			$message['url']		= route ('akta.akta.create');

			return response()->json($message);
		}
	}

	public function update  ($id)
	{

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

		$akta 							= Akta::select(['versi', 'kantor', 'judul', 'jenis', 'status'])->paginate();

		view()->share('akta', $akta);

		$this->view 					= view ($this->base_view . 'templates.blank');
		$this->view->page 				= view ($this->base_view . 'pages.akta.choose_template');

		return $this->generateView();
	}
}