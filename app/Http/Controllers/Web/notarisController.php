<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Domain\Administrative\Models\Kantor as Query;

use App\Http\Controllers\Controller;

use TAuth, Exception, Response;

class notarisController extends Controller
{
	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query			= $query;
		$this->per_page 		= (int)env('DATA_PERPAGE');
	}    

	public function index(Request $request)
	{
		//0. set active office
		$this->active_office                = TAuth::activeOffice();

		// 2. call all tagihans data needed
		//2a. parse query searching
		$query                              = $request->only('cari', 'filter', 'urutkan', 'page');

		//2b. retrieve all klien
		$this->retrieveNotaris($query);

		//2c. get all filter 
		$this->page_datas->filters          = $this->retrieveNotarisFilter();
		
		//2d. get all urutan 
		$this->page_datas->urutkan          = $this->retrieveNotarisUrutkan();

		//3.initialize view
		$this->view							= view('market_web.pages.notaris');

		return $this->generateView();  
	}

	private function retrieveNotaris($query = [])
	{
		//1. pastikan berasal dari kantor yang sama
		$data		= $this->query;

		//2. cari sesuai query
		if(isset($query['cari']))
		{
			$data			= $data->where(function($q)use($query){$q->where('notaris.nama', 'like', '%'.$query['cari'].'%')->orwhere('notaris.daerah_kerja', 'like', '%'.$query['cari'].'%');});
		}

		//3. filter 
		// foreach ((array)$query['filter'] as $key => $value) 
		// {
		// 	if(in_array($key, ['jenis']))
		// 	{
		// 		$data   	= $data->where('tipe', $value);               
		// 	}
		// }

		//4. urutkan
		if(isset($query['urutkan']))
		{
			$explode        = explode('-', $query['urutkan']);
			if(in_array($explode[0], ['nama', 'daerah_kerja']) && in_array($explode[1], ['asc', 'desc']))
			{
				$data       = $data->orderby('notaris.'.$key, $value);
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
		$this->page_datas->notaris	= $data->skip($skip)->take($this->per_page)->get()->toArray();
	}

	private function retrieveNotarisFilter()
	{
		return [];
	}
	
	private function retrieveNotarisUrutkan()
	{
		//1a.cari urutan
		$sort   =   [
						'nama-desc'   			=> 'Nama A - Z',
						'nama-asc'    			=> 'Nama Z - A',
						'daerah_kerja-desc'		=> 'Daerah Kerja A - Z',
						'daerah_kerja-asc'		=> 'Daerah Kerja Z - A',
					];

		return $sort;
	}

}
