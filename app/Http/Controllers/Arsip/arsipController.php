<?php

namespace App\Http\Controllers\Arsip;

use Illuminate\Http\Request;
use App\Domain\Order\Models\Arsip as Query;

use App\Http\Controllers\Controller;

use App\Infrastructure\Traits\GuidTrait;

use TAuth, Exception;

class arsipController extends Controller
{
	use GuidTrait;

	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query			= $query;
		$this->per_page 		= 36;
	}    

	public function index(Request $request)
	{
		//0. set active office
		$this->active_office			= TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title	= 'Arsip';

		// 2. call all tagihans data needed
		//2a. parse query searching
		$query							= $request->only('cari', 'filter', 'urutkan', 'page');

		//2b. retrieve all Arsip
		$this->retrieveArsip($query);

		//2c. get all filter 
		$this->page_datas->filters		= $this->retrieveArsipFilter();

		//2d. get all urutan 
		$this->page_datas->urutkan		= $this->retrieveArsipUrutkan();

		//3.initialize view
		$this->view						= view('notaris.pages.arsip.arsip.index');

		return $this->generateView();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{
		$this->active_office 			= TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title	= 'Arsip';

		// 2. call all tagihans data needed
		//2a. parse query searching
		$query 							= $request->only('cari', 'filter', 'urutkan', 'page');

		//2b. retrieve all Arsip
		$this->retrieveArsip($query);

		//2c. get all filter 
		$this->page_datas->filters 		= $this->retrieveArsipFilter();
		
		//2d. get all urutan 
		$this->page_datas->urutkan 		= $this->retrieveArsipUrutkan();

		//2e. get show document
		$this->page_datas->arsip 		= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->first();

		//3.initialize view
		$this->view						= view('notaris.pages.arsip.arsip.show');
		
		return $this->generateView();  
	}

	public function create(Request $request, $id = null)
	{
		//set this function
		$this->active_office 			= TAuth::activeOffice();

		//1. set page attributes
		$this->page_attributes->title 	= 'Arsip';

		//2. get show document
		$this->page_datas->arsip		= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->firstornew();

		$this->view						= view('pages.arsip.arsip.create');
		
		return $this->generateView();  
	}

	public function store(Request $request, $id)
	{
		try {
			//set this function
			$this->active_office 				= TAuth::activeOffice();

			//2. get store document
			$Arsip				= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->firstornew();
			
			if($request->has('ktp'))
			{
				$Arsip->tipe 	= 'perorangan';
				$Arsip->ktp 	= $request->get('ktp');
			}

			if($request->has('akta_pendirian'))
			{
				$Arsip->tipe			= 'perusahaan';
				$Arsip->akta_pendirian	= $request->get('akta_pendirian');
			}

			if($request->has('dokumen'))
			{
				$adding_doc 			= $request->get('dokumen');
				foreach ($adding_doc as $key => $value) 
				{
					$adding_doc[$key]['id']		= self::createID('doku'); 
				}
				$dokumen 				= $Arsip->dokumen;
				$dokumen 				= array_merge($dokumen, $adding_doc);
				$Arsip->dokumen 		= $dokumen;
			}

			$Arsip->save();

			$this->page_attributes->msg['success']		= ['Arsip Berhasil Disimpan'];
	
			return $this->generateRedirect(route('arsip.arsip.show', $Arsip->id));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();
	
			return $this->generateRedirect(route('arsip.arsip.create', ['id' => $id]));
		}
	}

	public function edit(Request $request, $id)
	{
		return $this->create($request, $id);
	}

	public function update(Request $request, $id)
	{
		return $this->store($request, $id);
	}

	public function destroy(Request $request, $id)
	{
		try {
			//set this function
			$this->active_office	= TAuth::activeOffice();

			//2. get store document
			$Arsip					= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->firstornew();

			$Arsip->delete();

			$this->page_attributes->msg['success']		= ['Arsip Berhasil Dihapus'];
	
			return $this->generateRedirect(route('arsip.arsip.index'));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();
	
			return $this->generateRedirect(route('arsip.arsip.show', ['id' => $id]));
		}	
	}

	public function addDokumen(Request $request, $id)
	{
		try {
			//set this function
			$this->active_office	= TAuth::activeOffice();

			//2. get store document
			$Arsip					= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->firstorfail();
			$dokumen 				= $Arsip->dokumen;

			if(isset($request->get('dokumen')['id']))
			{
				foreach ($dokumen as $key => $value) 
				{
					if($value['id'] == $request->get('dokumen')['id'])
					{
						$dokumen[$key]	= $request->get('dokumen');
					}
				}
			}
			else
			{
				$add_doku 			= $request->get('dokumen');
				$add_doku['id']		= self::createID('doku');
				$dokumen[]			= $add_doku;
			}

			$Arsip->dokumen 		= $dokumen;

			$Arsip->save();

			$this->page_attributes->msg['success']		= ['Dokumen Berhasil Disimpan'];
	
			return $this->generateRedirect(route('arsip.arsip.index'));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();
	
			return $this->generateRedirect(route('arsip.arsip.show', ['id' => $id]));
		}	
	}

	public function removeDokumen(Request $request, $id, $dokumen_id)
	{
		try {
			//set this function
			$this->active_office	= TAuth::activeOffice();

			//2. get store document
			$Arsip					= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->firstorfail();
			$dokumen 				= $Arsip->dokumen;

			foreach ($dokumen as $key => $value) 
			{
				if($value['id'] == $dokumen_id)
				{
					unset($dokumen[$key]);
				}
			}

			$Arsip->dokumen 		= $dokumen;
			$Arsip->save();

			$this->page_attributes->msg['success']		= ['Dokumen Berhasil Disimpan'];
	
			return $this->generateRedirect(route('arsip.arsip.index'));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();
	
			return $this->generateRedirect(route('arsip.arsip.show', ['id' => $id]));
		}	
	}

	private function retrieveArsip($query = [])
	{
		//1. pastikan berasal dari kantor yang sama
		$data		= $this->query->kantor($this->active_office['kantor']['id']);

		//2. cari sesuai query
		if(isset($query['cari']))
		{
			$data			= $data->where(function($q)use($query){$q->where('isi.nama', 'like', '%'.$query['cari'].'%');});
		}

		//3. filter 
		foreach ((array)$query['filter'] as $key => $value) 
		{
			if(in_array($key, ['jenis']))
			{
				$data   	= $data->where('tipe', $value);               
			}
		}

		//4. urutkan
		if(isset($query['urutkan']))
		{
			$explode        = explode('-', $query['urutkan']);
			if(in_array($explode[0], ['nama']) && in_array($explode[1], ['asc', 'desc']))
			{
				$data       = $data->orderby('akta_pendirian.nama', $value)->orderby('ktp.nama', $value);
			}
		}

		//5. page
		$skip				= 0;
		if(isset($query['page']))
		{
			$skip			= ((1 * $query['page']) - 1) * $this->per_page;
		}
		//set datas
		$this->paginate(null, $data->count(), $this->per_page);
		$this->page_datas->arsips	= $data->skip($skip)->take($this->per_page)->get()->toArray();
	}

	private function retrieveArsipFilter()
	{
		//1. jenis
		$filter['jenis']	= $this->query->distinct('jenis')->get();

		return $filter;
	}
	
	private function retrieveArsipUrutkan()
	{
		//1a.cari urutan
		$sort   =   [
						'nama-desc'   => 'Nama A - Z',
						'nama-asc'    => 'Nama Z - A',
					];

		return $sort;
	}

}
