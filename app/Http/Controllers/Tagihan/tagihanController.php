<?php

namespace App\Http\Controllers\Tagihan;

use App\Http\Controllers\Controller;
use App\Domain\Order\Models\HeaderTransaksi as Query;
use App\Domain\Order\Models\DetailTransaksi;

use App\Service\Helpers\JSend;

use Illuminate\Http\Request;

use TAuth, Exception, Carbon\Carbon;

class tagihanController extends Controller
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
	public function index(Request $request)
	{
		$this->active_office 				= TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title		= 'Tagihan';

		// 2. call all tagihans data needed
		//2a. parse query searching
		$query 								= $request->only('cari', 'filter', 'urutkan', 'page');

		//2b. retrieve all tagihan
		$this->retrieveTagihan($query);

		//2c. get all filter 
		$this->page_datas->filters 			= $this->retrieveTagihanFilter();
		
		//2d. get all urutan 
		$this->page_datas->urutkan 			= $this->retrieveTagihanUrutkan();

		//3.initialize view
		$this->view							= view('pages.pos.billing.index');

		return $this->generateView();  
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{
		$this->active_office 				= TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title		= 'Tagihan';

		// 2. call all tagihans data needed
		//2a. parse query searching
		// $query 								= $request->only('cari', 'filter', 'urutkan', 'page');

		// //2b. retrieve all tagihan
		// $this->retrieveTagihan($query);

		//2c. get all filter 
		$this->page_datas->filters 			= $this->retrieveTagihanFilter();
		
		//2d. get all urutan 
		$this->page_datas->urutkan 			= $this->retrieveTagihanUrutkan();

		//2e. get show document
		$this->page_datas->tagihan 			= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->with('details')->first();

		$this->page_datas->id 				= $id;
		$this->page_datas->active_office	= $this->active_office;
		
		//3.initialize view
		$this->view							= view('pages.pos.billing.show');
		
		return $this->generateView();  
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request, $id = null)
	{
		$this->active_office 				= TAuth::activeOffice();

		//2. init akta as null
		$this->page_datas->tagihan 			= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->with('details')->first();

		if(!$this->page_datas->tagihan)
		{
			$this->page_datas->tagihan 							= null;
			$this->page_datas->tagihan['status'] 				= 'pending';
			$this->page_datas->tagihan['klien'] 				= ['nama' => 'Bapak Tukimin', 'alamat' => 'Ruko Puri Niaga'];
			$this->page_datas->tagihan['nomor'] 				= Query::generateNomorTransaksiKeluar($this->active_office['kantor'], Carbon::now());
			$this->page_datas->tagihan['tanggal_dikeluarkan'] 	= Carbon::now()->format('d/m/Y');
			$this->page_datas->tagihan['total'] 				= 'Rp 50000';
			$this->page_datas->tagihan['details'][0]['item'] 			= 'Cetak Akta';
			$this->page_datas->tagihan['details'][0]['deskripsi'] 		= 'Cetak Salinan Akta dan Dibukukan';
			$this->page_datas->tagihan['details'][0]['harga_satuan'] 	= 'Rp 50000';
			$this->page_datas->tagihan['details'][0]['kuantitas'] 		= '1';
			$this->page_datas->tagihan['details'][0]['subtotal'] 		= 'Rp 50000';
		}

		$this->page_datas->id 				= $id;
		$this->page_datas->active_office	= $this->active_office;

		//2. set page attributes
		$this->page_attributes->title		= 'Tagihan';

		//3.initialize view
		$this->view							= view('pages.pos.billing.create');

		return $this->generateView();  
	}

	public function edit(Request $request, $id)
	{
		return $this->create($request, $id);
	}

	public function store(Request $request, $id = null, $status = 'pending')
	{
		try {

			$this->active_office 	= TAuth::activeOffice();
			
			//store header transaksi
			$tagihan		= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->with('details')->first();
			if(!is_null($id))
			{
				$status 	= $tagihan['status'];
			}
			else
			{
				$tagihan 	= new $this->query;
			}

			// $klien 			= Klien::findorfail($input['klien_id']);

			$input 			= $request->only('tanggal', 'details', 'nomor', 'klien', 'item');

			$tagihan->tanggal_dikeluarkan 	= Carbon::createFromFormat('d/m/Y', $input['tanggal'])->format('d/m/Y');
			$tagihan->tanggal_jatuh_tempo 	= Carbon::createFromFormat('d/m/Y', $input['tanggal'])->addMonths(3)->format('d/m/Y');
			$tagihan->status 				= $status;
			$tagihan->nomor 				= $input['nomor'];
			$tagihan->tipe 					= 'bukti_kas_masuk';
			$tagihan->kantor_id				= $this->active_office['kantor']['id'];
			$tagihan->klien 				= $input['klien'];
			$tagihan->save();

			$tagihan->details()->delete();

			foreach ($input['item'] as $key => $value) 
			{
				$t_detail 						= new DetailTransaksi;
				$t_detail->item 				= $value;
				$t_detail->deskripsi 			= $request->get('deskripsi')[$key];
				$t_detail->kuantitas 			= $request->get('kuantitas')[$key];
				$t_detail->harga_satuan 		= $request->get('harga')[$key];
				$t_detail->diskon_satuan 		= 'Rp 0';
				$t_detail->header_transaksi_id 	= $tagihan->id;
				$t_detail->save();
			}

			$this->page_attributes->msg['success']		= ['Tagihan Berhasil Disimpan'];
			return $this->generateRedirect(route('tagihan.tagihan.edit', $tagihan->id));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();
			return $this->generateRedirect(route('tagihan.tagihan.create', ['id' => $id]));
		}
	}

	public function update(Request $request, $id)
	{
		return $this->store($request, $id);
	}

	public function destroy(Request $request, $id)
	{
		$this->active_office 	= TAuth::activeOffice();
		
		try {
			//store header transaksi
			$tagihan		= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->with('details')->firstorfail();
			$tagihan->details->delete();
			$tagihan->delete();

			$this->page_attributes->msg['success']		= ['Tagihan Berhasil Dihapus'];
			return $this->generateRedirect(route('tagihan.tagihan.index'));

		} catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();
			return $this->generateRedirect(route('tagihan.tagihan.edit', $id));
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function print(Request $request, $id)
	{
		$this->active_office 				= TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title		= 'Tagihan';

		//2. get show document
		$this->page_datas->tagihan 			= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->with('details')->first();

		$this->page_datas->id 				= $id;
		$this->page_datas->active_office	= $this->active_office;
		
		//3.initialize view
		$this->view							= view('pages.pos.billing.print');
		
		return $this->generateView();  
	}

	public function status(Request $request, $id, $status)
	{
		try {
			//1. get active office
			$this->active_office 	= TAuth::activeOffice();

			//2. get show document
			$tagihan 				= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->with('details')->first();

			//3. update status
			$tagihan->status 		= $status;

			//4. simpan tagihan
			$tagihan->save();

			$this->page_attributes->msg['success']		= ['Tagihan Berhasil Dihapus'];
			
			return $this->generateRedirect(route('tagihan.tagihan.edit', $id));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();

			return $this->generateRedirect(route('tagihan.tagihan.edit', $id));
		}
	}

	private function retrieveTagihan($query)
	{
		//1. pastikan berasal dari kantor yang sama
		$data 	 	= $this->query->kantor($this->active_office['kantor']['id'])->where('tipe', 'bukti_kas_masuk');

		//2. cari sesuai query
		if(isset($query['cari']))
		{
			$data 	= $data->where(function($q)use($query){$q->where('klien', 'like', '%'.$query['cari'].'%')->orwhere('nomor_transaksi', 'like', '%'.$query['cari'].'%');});
		}

		//3. filter 
		foreach ((array)$query['filter'] as $key => $value) 
		{
			if(in_array($key, ['status']))
			{
				$data 	= $data->where($key, $value);				
			}
		}

		//4. urutkan
		if(isset($query['urutkan']))
		{
			$explode 		= explode('-', $query['urutkan']);
			if(in_array($explode[0], ['tanggal_dikeluarkan', 'tanggal_jatuh_tempo', 'status', 'nama_klien']) && in_array($explode[1], ['asc', 'desc']))
			{
				$data 		= $data->orderby($key, $value);
			}
		}

		//5. page
		$skip 		= 0;
		if(isset($query['page']))
		{
			$skip 	= ((1 * $query['page']) - 1) * $this->per_page;
		}
		//set datas
		$this->paginate(null, $data->count(), $this->per_page);
		$this->page_datas->tagihans 		= $data->skip($skip)->take($this->per_page)->with(['details'])->get();
	}

	private function retrieveTagihanFilter()
	{
		//1a. cari jenis
		// $filter['jenis']	= $this->query->distinct('jenis')->get();

		//2a. status
		$filter['status']	= ['pending', 'lunas'];
	
		return $filter;
	}

	private function retrieveTagihanUrutkan()
	{
		//1a.cari urutan
		$sort	= 	[
						'created_at-desc' 	=> 'Terbaru dibuat',
						'created_at-asc' 	=> 'Terlama dibuat',
						'updated_at-desc' 	=> 'Terbaru diupdate',
						'updated_at-asc' 	=> 'Terlama diupdate',
					];

		return $sort;
	}
}
