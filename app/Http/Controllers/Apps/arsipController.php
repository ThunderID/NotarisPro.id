<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Thunderlabid\Arsip\Models\Arsip;

use TAuth, Response, App, Session, Exception, Carbon\Carbon;

class ArsipController extends Controller
{
	function __construct (){
		parent::__construct();
		
		$this->view 		= view ($this->base_view . 'templates.basic');
		$this->base_view 	= $this->base_view . 'pages.arsip.';
	}

	public function index (){
		$arsip		= Arsip::select(['pemilik', 'lists']);
		if(request()->has('q')){
			$arsip 	= $arsip->where('pemilik.nama', 'like', '%'.request()->get('q').'%');
		}
		
		$arsip 		= $arsip->paginate();

		return response()->json($arsip);
	}

	public function show ($id){
		$arsip 		= Arsip::findorfail($id);
		$data 		= [];

		if (request()->has('jenis') && $arsip) 
		{
			$dokumen	= collect($arsip['dokumen'])->where('jenis', request()->get('jenis'))->first();

			foreach ($dokumen as $k => $v) 
			{
				if (!in_array($k, ['id', 'jenis']))
				{
					$data['@'.$dokumen['id'].'.'.$dokumen['jenis'].'.'.$k.'@']	= $v;
				}
			}
		}

		//1.initialize view
		// $this->view->pages		= view ($this->base_view . 'show', compact('arsip', 'data'));

		// return $this->generateView();  
		return response()->json($data);
	}

	//data input
	//pemilik[nama] = 'chelsy'
	//ktp[nama] = 'chelsy'
	//ktp[nik] = '3573016108930001'
	//ktp[jenis] = 'KTP'
	public function store(){
		$arsip 				= new Arsip;
		$arsip->pemilik 	= request()->only('nama', 'telepon');
		// $arsip->dokumen 	= [request()->get('ktp')];
		$arsip->save();

		return response()->json($arsip);
	}

	//data input
	//dokumen[nama] = 'chelsy'
	//dokumen[nik] = '3573016108930001'
	//dokumen[jenis] = 'KTP'
	public function update($id){
		$arsip 		= Arsip::findorfail($id);
		$dokumens 	= $arsip->dokumen;

		try {
			//JIKA ADA DATA DOKUMEN
			if (request()->has('dokumen')){
				$dok  	= request()->get('dokumen');
				
				//JIKA TIDAK ADA DATA DOKUMEN ID
				if (!isset($dok['id'])){
					$dok['id']	= Arsip::generateDokumenID();
				}

				$key 			= array_search($dok['id'], array_column($dokumens, 'id'));

				$dokumen 			= array_merge($dokumens[$key], $dok);
				$dokumens[$key]		= $dokumen;
				$arsip->dokumen 	= $dokumens;
			}

			if (request()->has('pemilik')){
				$arsip->pemilik 	= request()->get('pemilik');
			}

			$arsip->save();

			return response()->json(['msg' => 'data dokumen berhasil disimpan']);
		} catch (Exception $e) {
			return response()->json(['msg' => $e->getMessage()]);
		}

		//RETURN DEWE
	}
}