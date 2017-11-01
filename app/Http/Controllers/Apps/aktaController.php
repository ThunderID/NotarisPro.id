<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Apps\ArsipController as Arsip;
use App\Http\Controllers\Apps\helperController as Helper;

use Thunderlabid\Akta\Models\Akta;
use Thunderlabid\Arsip\Models\Arsip as Klien;

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

	public function index ($id = null)
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
		view()->share('id', $id);

		//1.initialize view
		$this->view				= view ($this->base_view . 'templates.basic');
		$this->view->sidebar	= view ($this->base_view . 'pages.akta.components.search_filter');
		$this->view->main		= view ($this->base_view . 'pages.akta.index');

		return $this->generateView();  
	}

	public function show ($id)
	{
		$akta 					= Akta::findorfail($id)->toArray();

		view()->share('akta', $akta);
		// view()->share('status_akta', $akta['status']);

		//1.initialize view
		$this->view 			= view ($this->base_view . 'templates.basic');
		$this->view->main		= view ($this->base_view . 'pages.akta.show');

		return $this->generateView();
		// return $this->index($id);
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
		$akta				= Akta::findorfail($id);
		$akta['pemilik'] 	= array_column($akta->klien, 'pemilik');

		$arsip 		= new Arsip;
		$arsip 		= $arsip->index();

		view()->share('akta', $akta);
		view()->share('arsip', $arsip);

		$this->view 		= view ($this->base_view . 'templates.blank');
		$this->view->pages 	= view ($this->base_view . 'pages.akta.create');

		return $this->generateView();
	}

	//data input
	//pemilik[0][id] 	= '23546546s51df23w1frw'
	//pemilik[0][nama] 	= 'Chelsy'
	//judul 			= 'Akta Jual Beli Tanah di Mengwi'
	//jenis 			= 'AJB'
	public function store ($id = null)
	{
		$akta	= new Akta;
		$klien 	= [];

		foreach (request()->get('klien') as $k => $v) {
			$klien[] 	= Klien::where('_id', $v)->first(['_id', 'pemilik'])->toArray();
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
			$akta->status 	= 'draft';
			$akta->save();

			$message['success'] = ['akta berhasil disimpan'];
			$message['url'] 	= route ('akta.akta.index');

			return redirect()->route('akta.akta.edit', ['id' => $akta->_id]);
		} catch (Exception $e) {
			return redirect()->back()->withErrors($e->getMessage());
		}
	}

	public function update  ($id)
	{
		return $this->store($id);
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

	public function ajax_show ($id)
	{
		if ($id)
		{
			$akta 				= Akta::findorfail($id);

			//1f. generate checker
			// $akta['incomplete']	= $this->checkInclompeteData($akta['dokumen']);

			$paragraf 			= collect($akta['paragraf']);
			$akta['paragraf'] 	= $paragraf->map(function ($single_p) 
			{
				$single_p['revisi'][]	= ['tanggal' => Carbon::now()->format('d/m/Y'), 'isi' => $single_p['konten']];
			    return $single_p;
			});

			// returning akta data
			return Response::json($akta);
		}
		else
		{
			//return 404
			return App::abort(404);
		}
	}
}