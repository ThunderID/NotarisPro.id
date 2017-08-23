<?php

namespace App\Http\Controllers\Akta;

use App\Http\Controllers\Controller;
use App\Domain\Akta\Models\Dokumen as Query;
use App\Domain\Akta\Models\TipeDokumen;

use App\Service\Akta\BuatAktaBaru;
use App\Service\Akta\UpdateAkta;
use App\Service\Akta\UpdateStatusAkta;
use App\Service\Akta\HapusAkta;
use App\Service\Akta\DuplikasiAkta;
use App\Service\Akta\LockAkta;

use App\Service\Helpers\JSend;

use PulkitJalan\Google\Client;

use Illuminate\Http\Request;

use TAuth, Response, App;

class aktaController extends Controller
{
	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query            = $query;
		$this->per_page 		= (int)env('DATA_PERPAGE');
	}   

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request, $id = null)
	{
		$this->active_office 				= TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title		= 'Akta Dokumen';
		$this->page_datas->id 				= $id;

		// 2. call all aktas data needed
		//2a. parse query searching
		$query 								= $request->only('cari', 'status', 'jenis', 'urutkan', 'page');

		//2b. retrieve all akta
		$this->retrieveAkta($query);

		//2c. get all filter 
		$this->page_datas->filters 			= $this->retrieveAktaFilter();
		
		//2d. get all urutan 
		$this->page_datas->urutkan 			= $this->retrieveAktaUrutkan();

		//3.initialize view
		$this->view							= view('pages.akta.akta.index');

		return $this->generateView();  
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function trashed(Request $request)
	{
		$this->active_office 				= TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title		= 'Akta Dokumen';

		// 2. call all aktas data needed
		//2a. parse query searching
		$query 								= $request->only('cari', 'status', 'jenis', 'filter', 'urutkan', 'page');
		$query['trash']						= true;

		//2b. retrieve all akta
		$this->retrieveAkta($query);

		//2c. get all filter 
		$this->page_datas->filters 			= $this->retrieveAktaFilter();
		
		//2d. get all urutan 
		$this->page_datas->urutkan 			= $this->retrieveAktaUrutkan();

		//3.initialize view
		$this->view							= view('pages.akta.akta.index');

		return $this->generateView();  
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{	
		/*
		return $this->index($request, $id);
		$this->active_office 					= TAuth::activeOffice();

		//1. call all aktas data needed
		//1a. parse query searching
		$query 									= $request->only('cari', 'filter', 'urutkan', 'page');

		//1b. retrieve all akta
		$this->retrieveAkta($query);

		//1c. get all filter 
		$this->page_datas->filters 				= $this->retrieveAktaFilter();
		
		//1d. get all urutan 
		$this->page_datas->urutkan 				= $this->retrieveAktaUrutkan();

		//1e. get show document
		$this->page_datas->akta 				= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->first()->toArray();

		//1f. generate checker
		$this->page_datas->akta['incomplete']	= $this->checkInclompeteData($this->page_datas->akta['dokumen']);

		//2. set page attributes
		$this->page_attributes->title			= 'Akta Dokumen';

		//3.initialize view
		$this->view								= view('pages.akta.akta.show');

		return $this->generateView();  
		*/

		return $this->index($request, $id);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		// blank or copy
		$input 								= $request->only('id_akta','judul_akta');
		


		$this->active_office 				= TAuth::activeOffice();

		//1. parse data needed based on category
		$this->page_datas->dokumen_lists	= TipeDokumen::kantor($this->active_office['kantor']['id'])->get();

		//2. init akta as null
		// some logic here
		if (is_null($input['id_akta'])){
			// blank here
			$this->page_datas->judul_akta = $input['judul_akta'];
		}else{
			// copy
			// open akta and  return to akta
			$this->page_datas->judul_akta = $input['judul_akta'];
			$this->page_datas->akta 		= $this->query->id($input['id_akta'])->kantor($this->active_office['kantor']['id'])->first()->toArray();
		}
		
		//3. set page attributes
		$this->page_attributes->title		= 'Akta Dokumen';

		//4.initialize view
		$this->view					= view('pages.akta.akta.create');

		return $this->generateView();  
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function chooseTemplate(Request $request)
	{

		$this->active_office 			= TAuth::activeOffice();

		//1. init akta as null
		$this->page_datas->akta 			= null;

		//2. set page attributes
		$this->page_attributes->title		= 'Buat Akta Baru';

		//3. initialize view
		$this->view					= view('pages.akta.akta.aktanew');

		//4. get data akta
		$query 						= $request->only('cari', 'page');
		$query['trash']				= false;
		$this->retrieveAkta($query);		

		return $this->generateView();  
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		$this->active_office 				= TAuth::activeOffice();

		//1. parse data needed based on category
		// $this->page_datas->dokumen_lists 	= TipeDokumen::kantor($this->active_office['kantor']['id'])->get();

		//2. init akta as null
		//1e. get show document
		$this->page_datas->akta 				= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->first()->toArray();

		//1f. generate checker
		$this->page_datas->akta['incomplete']	= $this->checkInclompeteData($this->page_datas->akta['dokumen']);

		//2. set page attributes
		$this->page_attributes->title		= 'Akta Dokumen';

		//3.initialize view
		$this->view							= view('pages.akta.akta.create');

		return $this->generateView();  
	}

	public function store(Request $request)
	{
		try {
			$akta 		= new BuatAktaBaru($request->get('judul'), $request->get('jenis'), $request->get('paragraf'));
			$akta 		= $akta->save();

			$this->page_attributes->msg['success']		= ['Akta Berhasil di Simpan'];
			return $this->generateRedirect(route('akta.akta.show', $akta['id']));
		} 
		catch (Exception $e) {
			$this->page_attributes->msg['error']       = $e->getMessage();
			return $this->generateRedirect(route('akta.akta.create'));
		}
	}


	public function update(Request $request, $id)
	{
		try {
			$akta 		= new UpdateAkta($id);

			if($request->has('judul'))
			{
				$akta->setJudul($request->get('judul'));
			}

			if($request->has('jenis'))
			{
				$akta->setJenis($request->get('jenis'));
			}

			if($request->has('paragraf'))
			{
				$akta->setParagraf($request->get('paragraf'));
			}

			$akta 		= $akta->save();

			$this->page_attributes->msg['success']		= ['Akta Berhasil di Ubah'];
			return $this->generateRedirect(route('akta.akta.show', $akta['id']));
		} 
		catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();
			return $this->generateRedirect(route('akta.akta.edit', $id));
		}
	}

	public function destroy(Request $request, $id)
	{
		try {
			$akta 		= new HapusAkta($id);
			$akta 		= $akta->save();

			$this->page_attributes->msg['success']		= ['Akta Berhasil di Hapus'];
			return $this->generateRedirect(route('akta.akta.index'));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();
			return $this->generateRedirect(route('akta.akta.show', $id));
		}
	}

	public function mentionIndex(Request $request)
	{
		$this->active_office	= TAuth::activeOffice();
	
		$tipe					= TipeDokumen::kantor($this->active_office['kantor']['id'])->get()->toArray();

		return $tipe;
	}

	public function mentionStore(Request $request)
	{
		$this->active_office	= TAuth::activeOffice();

		$exploded 				= explode('.', str_replace('@', '', $request->get('mention')));

		$tipe 					= TipeDokumen::/*where('kategori', $exploded[0])->*/where('jenis_dokumen', $exploded[0])->where('kepemilikan', $exploded[1])->kantor($this->active_office['kantor']['id'])->first();

		if(!$tipe)
		{
			$tipe 					= new TipeDokumen;
			// $tipe->kategori 		= $exploded[0];
			$tipe->jenis_dokumen 	= $exploded[0];
			$tipe->kepemilikan 		= $exploded[1];
		}

		$isi 					= $tipe->isi;
		if(empty($isi) || is_null($isi))
		{
			$isi 				= [];
		}
		$isi 					= array_unique(array_merge($isi, [$exploded[2]]));
		$tipe->isi 				= $isi;
		$tipe->kantor 			= $this->active_office['kantor'];
		$tipe->save();

		return JSend::success(['tersimpan']);

	}
	
	public function versionIndex(Request $request, $id)
	{
		$this->active_office	= TAuth::activeOffice();
		$key 					= 0;
		$versi 					= [];

		do {
			$versi[$key]		= $this->query->notid($id)->kantor($this->active_office['kantor']['id'])->where('prev', $id)->first();
			$id 				= $versi[$key]['id'];
		} while (isset($versi[$key]) && $versi[$key]['prev'] != null);	

		return $versi;
	}

	public function versionShow(Request $request, $akta_id, $version_id)
	{
		$this->active_office	= TAuth::activeOffice();

		$akta['original']		= $this->query->id($akta_id)->kantor($this->active_office['kantor']['id'])->first()->toArray();
		$akta['versioning']		= $this->query->id($version_id)->kantor($this->active_office['kantor']['id'])->first()->toArray();

		return $akta;
	}

	public function print(Request $request, $akta_id)
	{
		$this->active_office	= TAuth::activeOffice();

		$akta					= $this->query->id($akta_id)->kantor($this->active_office['kantor']['id'])->first()->toArray();

		return $akta;
	}

	public function renvoiMark(Request $request, $akta_id, $key, $mode)
	{
		$this->active_office	= TAuth::activeOffice();

		$akta 					= new LockAkta($akta_id);

		try {
			switch (strtolower($mode)) 
			{
				case 'add':
				$akta 	= $akta->addParagrafAfter($key);
					break;
				case 'delete':
				$akta 	= $akta->removeParagrafBefore($key);
					break;
				case 'edit':
				$akta 	= $akta->editable($key);
					break;
				default :
					throw new Exception("Not listed ", 1);
					break;
			}
		} catch (Exception $e) {
			return JSend::error($akta, $e->getMessage());
		}

		return JSend::success($akta);
	}

	public function status(Request $request, $akta_id, $status)
	{
		$this->active_office	= TAuth::activeOffice();

		$akta 					= new UpdateStatusAkta($akta_id);

		try {
			switch (strtolower($status)) 
			{
				case 'minuta':
				$akta 	= $akta->toMinuta($key);
					break;
				case 'salinan':
				$akta 	= $akta->toSalinan($key);
					break;
				default :
					throw new Exception("Not listed ", 1);
					break;
			}
		} catch (Exception $e) {
			return JSend::error($akta, $e->getMessage());
		}

		return JSend::success($akta);
	}

	public function copy(Request $request, $akta_id)
	{
		$this->active_office	= TAuth::activeOffice();

		$akta 					= new DuplikasiAkta($akta_id);

		try {
			$akta 				= $akta->save();

			$this->page_attributes->msg['success']		= ['Akta Berhasil di duplikasi'];
			return $this->generateRedirect(route('akta.akta.edit', $akta['id']));
		} 
		catch (Exception $e) {
			$this->page_attributes->msg['error']       = $e->getMessage();
			return $this->generateRedirect(route('akta.akta.edit', $akta_id));
		}
	}

	public function dropboxStore(Request $request, $id)
	{
		$active_office 	= TAuth::activeOffice();

		$akta 			= $this->query->id($id)->kantor($active_office['kantor']['id'])->first()->toArray();
		$this->FromTextToPDF($akta, $active_office);
		
		return $this->generateRedirect(route('akta.akta.show', $id));
	}

	/**
	 * Display a listing of the resource.
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function ajaxShow(Request $request, $id)
	{	
		$this->active_office = TAuth::activeOffice();
        //1. get show document
        $akta                   = $this->query->id($id)->kantor($this->active_office['kantor']['id'])->first();
        if($akta)
        {
            $akta               = $akta->toArray();
            //1f. generate checker
            $akta['incomplete']     = $this->checkInclompeteData($akta['dokumen']);
	        
            // returning akta data
	        return Response::json($akta);
        }
        else
        {
            //return 404
			return App::abort(404);
        }
	}

	//!UNFINISHED! Using an Example
	private function fromTextToPDF($akta, $office)
	{
		//1. file naming
		$namafile 	= 	$akta['judul'].'[Versi '.$akta['versi'].'].pdf';

		//2. rendering pdf
		$pdf 		= \PDF::loadView('market_web.thirdparty.aktapdf', $akta);
		$data 		= $pdf->output();

		//3. initiate path
		$dbox_api 	= 	['path' => "/Akta/".\Carbon\Carbon::now()->format('Y/m/d')."/$namafile", 'mode' => 'add', 'autorename' => true, 'mute' => false];

		//4. execute curl
		$headers 	= 	['Authorization: Bearer '.$office['kantor']['thirdparty']['dbox']['token'], "Content-Type: application/octet-stream", 'Dropbox-API-Arg: '.json_encode($dbox_api)
						];

		$ch = curl_init('https://content.dropboxapi.com/2/files/upload');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);

		curl_close($ch);
		$returned 	= json_decode($response, true);

		return $returned;
	}

	public function dokumenIndex(Request $request)
	{
		$this->active_office	= TAuth::activeOffice();

		$lists 					= TipeDokumen::kantor($this->active_office['kantor']['id'])->orderby('kategori', 'desc')->get()->toArray();

		return JSend::success($lists);
	}

	/**
	 * Highly dependant on UI
	 *
	 * @param array ['cari' => 'string judul / nama klien', 'filter' => ['jenis' => 'AJB|Fidusia|...', 'status' => 'drafting|minuta'], 'urutkan' => 'created_at-desc', 'page' => 1];
	 */
	private function retrieveAkta($query = null)
	{
		//1. pastikan berasal dari kantor yang sama
		$data 	 	= $this->query->kantor($this->active_office['kantor']['id']);

		//2. cari sesuai query
		if(isset($query['cari']))
		{
			$data 	= $data->where(function($q)use($query){$q->where('judul', 'like', '%'.$query['cari'].'%')->orwhere('pemilik.klien.nama', 'like', '%'.$query['cari'].'%');});
		}

		//3. filter jenis
		if(isset($query['jenis'])){
			$data 	= $data->where('jenis', $query['jenis']);				
		}
		if(isset($query['status'])){
			$data 	= $data->where('status', $query['status']);				
		}		

		//4. urutkan
		if(isset($query['urutkan']))
		{
			$explode 		= explode('-', $query['urutkan']);
			if(in_array($explode[0], ['updated_at', 'created_at', 'status', 'jenis']) && in_array($explode[1], ['asc', 'desc']))
			{
				$data 		= $data->orderby($explode[0], $explode[1]);
			}
		}

		//5. page
		$skip 		= 0;
		if(isset($query['page']))
		{
			$skip 	= ((1 * $query['page']) - 1) * $this->per_page;
		}

		//6. trash
		if(isset($query['trashed']))
		{
			$data 	= $data->onlyTrashed();
		}

		//set datas
		$this->paginate(null, $data->count(), $this->per_page);
		$this->page_datas->aktas 		= $data->skip($skip)->take($this->per_page)->get(['_id', 'judul', 'jenis', 'status', 'versi', 'penulis', 'pemilik', 'created_at', 'updated_at'])->toArray();

		return $this->page_datas;
	}

	///check
	private function retrieveAktaFilter()
	{
		//1a. cari jenis
		$jenis 					= $this->query->distinct('jenis')->get();

		$filter['jenis']		= [];
		foreach ($jenis as $key => $value) 
		{
			foreach ($value['attributes'] as $k => $v) 
			{
				$filter['jenis'][$v]	= $v;
			}
		}

		//2a. status
		$status 				= $this->query->distinct('status')->get();

		$filter['status']		= [];
		foreach ($status as $key => $value) 
		{
			foreach ($value['attributes'] as $k => $v) 
			{
				$filter['status'][$v]	= $v;
			}
		}

		return $filter;
	}

	private function retrieveAktaUrutkan()
	{
		//1a.cari urutan
		$sort	= 	[
						'created_at-desc' 	=> 'Terbaru dibuat',
						'created_at-asc' 	=> 'Terlama dibuat',
						'updated_at-desc' 	=> 'Terbaru diupdate',
						'updated_at-asc' 	=> 'Terlama diupdate',
						'status-asc' 		=> 'Status A - Z',
						'status-desc' 		=> 'Status Z - A',
						'jenis-asc' 		=> 'Jenis A - Z',
						'jenis-desc' 		=> 'Jenis Z - A',
					];

		return $sort;
	}

	private function checkInclompeteData($document)
	{
		//nge bug
		$required 			= [];
		//1. incomplete document

		foreach ($document as $key => $value) 
		{
			list($tipe, $nomor)			= explode('[dot]', $key);
			foreach ($value as $key2 => $value2) 
			{
				$jenis_doc 				= str_replace('[dot]', ' ', $key2);

				$required[$tipe][$nomor][$jenis_doc]			= true;

				foreach ($value2 as $key3 => $value3) 
				{
					if(empty($value3))
					{
						$required[$tipe][$nomor][$jenis_doc]	= false;
					}
				} 
			}
		}

		return $required;
	}
}
