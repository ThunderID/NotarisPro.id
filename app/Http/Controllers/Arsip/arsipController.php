<?php

namespace App\Http\Controllers\Arsip;

use Illuminate\Http\Request;
use App\Domain\Invoice\Models\Arsip as Query;
use App\Domain\Akta\Models\TipeDokumen;

use App\Http\Controllers\Controller;

use App\Infrastructure\Traits\GuidTrait;

use TAuth, Response, Exception;

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
		$this->middleware('scope:read_archive');

		//0. set active office
		$this->active_office			= TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title	= 'Arsip';
		$this->page_datas->id			= null;

		// 2. call all tagihans data needed
		//2a. parse query searching
		$query							= $request->only('cari', 'filter', 'urutkan', 'page');

		//2b. retrieve all Arsip
		$this->retrieveArsip($query);

		//2c. get all filter 
		$this->page_datas->filters		= $this->retrieveArsipFilter();

		//2d. get all urutan 
		$this->page_datas->urutkan		= $this->retrieveArsipUrutkan();

		$this->retrieveArsipConfig();

		//3.initialize view
		$this->view						= view('pages.arsip.arsip.index');

		return $this->generateView();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{
		$this->middleware('scope:read_archive');
		
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

		$this->retrieveArsipConfig();

		$this->page_datas->arsip 		= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->first();

		//3.initialize view
		$this->view						= view('pages.arsip.arsip.show');
		
		return $this->generateView();  
	}

	private function retrieveArsipConfig()
	{
		$tipe							= TipeDokumen::kantor($this->active_office['kantor']['id'])->get()->toArray();
 		$this->page_datas->config 		= null;
		foreach ($tipe as $key => $value) 
		{
			$this->page_datas->config[$value['jenis_dokumen']]	= [(isset($value['isi'][0]) ? $value['isi'][0] : null ), (isset($value['isi'][1]) ? $value['isi'][1] : null )];
		}
	}

	/**
	 * Display a listing of the resource.
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function ajaxShow(Request $request, $id)
	{	
		$this->middleware('scope:read_archive');
		$this->active_office = TAuth::activeOffice();
        //1. get show document
        $arsip                   = $this->query->id($id)->kantor($this->active_office['kantor']['id'])->first();

        if($arsip)
        {
            $arsip               = $arsip->toArray();
            // returning arsip data
	        return Response::json($arsip);
        }
        else
        {
            //return 404
			return App::abort(404);
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
				$data       = $data->orderby('akta_pendirian.nama', $explode[1])->orderby('ktp.nama', $explode[1]);
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
		$jenis					= $this->query->distinct('jenis')->get();

		$filter['jenis']		= [];
		foreach ($jenis as $key => $value) 
		{
			foreach ($value['attributes'] as $k => $v) 
			{
				$filter['jenis'][$v]	= $v;
			}
		}

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
