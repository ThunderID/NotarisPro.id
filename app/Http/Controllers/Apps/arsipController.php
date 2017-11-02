<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Thunderlabid\Akta\Models\Akta;
use Thunderlabid\Arsip\Models\Arsip;

use TAuth, Response, App, Session, Exception, Carbon\Carbon;

class arsipController extends Controller
{
	function __construct (){
		parent::__construct();
	}

	public function index (){
		$arsip		= Arsip::select(['pemilik', 'lists']);
		if(request()->has('q')){
			$arsip 	= $arsip->where('pemilik.nama', 'like', '%'.request()->get('q').'%');
		}

		if(request()->has('akta_id')){
			$akta 	= Akta::findorfail(request()->get('akta_id'))->toArray();
			$ids 	= array_column($akta['klien'], '_id');
			$arsip 	= $arsip->whereIn('_id', $ids);
		}

		$arsip 		= $arsip->paginate();

		//if request ajax
		if(request()->ajax()){
			return response()->json($arsip);
		}

		$this->page_attributes->title 		= 'ARSIP';
		$this->page_attributes->subtitle 	= 'Arsip data klien';

		//1.initialize view
		$this->view				= view ($this->base_view . 'templates.basic');
		$this->view->main		= view ($this->base_view . 'pages.arsip.index');

		return $this->generateView();  
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

		if(request()->has('jenis')){
			$dokumen['id']		= str_replace('0.','',str_replace(' ','',microtime().'01'));
			$dokumen['jenis']	= str_replace(' ', '_', strtolower(request()->get('jenis')));
			$value 				= request()->get('value');
			foreach (request()->get('field') as $k => $v) {
				$dokumen[str_replace(' ', '_', strtolower($v))] = $value[$k];
			}
			$arsip->dokumen 	= $dokumen;
		}

		$arsip->save();

		if(request()->has('akta_id')){
			$akta 			= Akta::findorfail(request()->get('akta_id'));
			$klien 			= array_merge($akta->klien, ['_id' => $arsip->id, 'pemilik' => $arsip->pemilik]);
			$akta->klien 	= $klien;
			// $ak
		}

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