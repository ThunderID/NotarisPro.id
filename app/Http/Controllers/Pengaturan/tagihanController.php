<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Domain\Order\Models\HeaderTransaksi as Query;

use App\Service\Helpers\JSend;

use Illuminate\Http\Request;

use TAuth, Exception;

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
		$this->view							= view('pages.pengaturan.tagihan.index');

		return $this->generateView();  
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

		// 2. call all tagihans data needed
		//2a. parse query searching
		$this->page_datas->tagihan 			= $this->query->id($id)->kantor($this->active_office['kantor']['id'])->with('details')->first();

		//3.initialize view
		$this->view							= view('pages.pengaturan.tagihan.print');

		return $this->generateView();  
	}

	public function recalculate(Request $request, $mode)
	{
		switch (strtolower($mode)) 
		{
			case 'add':
				$biaya 	= $this->adding();
				# code...
				break;
			case 'remove':
				$biaya 	= $this->remove($request->get('id'));
				# code...
				break;
			case 'replace':
				$biaya 	= $this->replace();
				# code...
				break;
		}

		return Response::json($biaya);
	}

	private function countCurrent($users, $month)
	{
		$total_counter 	= 0;
		$total_tagihan 	= 0;

		foreach ($users as $u_key => $u_value) 
		{
			foreach ($u_value['visas'] as $v_key => $v_value) 
			{
				if(in_array($v_value['type'], ['starter']) && $v_value['expired_at'] > $month->format('Y-m-d') && $v_value['kantor']['id'] == $this->active_office['kantor']['id'])
				{
					$day_range 		= Carbon::parse($v_value['started_at'])->diffInDays($month);
					$that_day 		= cal_days_in_month(CAL_GREGORIAN, $month->format('m'),$month->format('Y'));

					$day_range 		= min($day_range, $that_day);

					$total_counter 	= $total_counter + 1;
					if($total_counter < = 2)
					{
						$total_tagihan 	= $total_tagihan + ((250000/$that_day) * $day_range);
					}
					elseif($total_counter > 2 && $total_counter <= 5)
					{
						$total_tagihan 	= $total_tagihan + ((200000/$that_day) * $day_range);
					}
					elseif($total_counter > 5)
					{
						$total_tagihan 	= $total_tagihan + ((150000/$that_day) * $day_range);
					}
				}
			}
		}
		$total_tagihan 	= max($total_tagihan, 500000);
	
		return $total_tagihan;
	}

	private function adding($month = Carbon::parse('last day of this month')->endofTheDay())
	{
		$users 				= Pengguna::where('visas.kantor.id', $this->active_office['kantor']['id'])->get();
		$total_tagihan 	= $this->countCurrent($users, $month);

		if(count($users) >= 2)
		{
			$day_range 		= Carbon::now()->diffInDays($month);
			$that_day 		= cal_days_in_month(CAL_GREGORIAN,$month->format('m'),$month->format('Y'));

			$day_range 		= min($day_range, $that_day);

			if(count($users) >= 2 && count($users) < 5)
			{
				$total_tagihan 	= $total_tagihan + ((200000/$that_day) * $day_range);
			}
			elseif(count($users) >= 5)
			{
				$total_tagihan 	= $total_tagihan + ((150000/$that_day) * $day_range);
			}
		}
		return $total_tagihan;
	}

	private function remove($month = Carbon::parse('last day of this month')->endofTheDay(), $id)
	{
		$users 				= Pengguna::where('visas.kantor.id', $this->active_office['kantor']['id'])->notID($id)->get();
		$total_tagihan 		= $this->countCurrent($users, $month);

		if(count($users) > 2)
		{
			$user 			= Pengguna::find($id);
			foreach ($user['visa'] as $key => $value) 
			{
				if($value['kantor']['id'] == $this->active_office['kantor']['id'])
				{
					$day_range 		= Carbon::parse($value['started_at'])->diffInDays($month);
					$that_day 		= cal_days_in_month(CAL_GREGORIAN,$month->format('m'),$month->format('Y'));

					$day_range 		= min($day_range, $that_day);

					if(count($users) >= 2 && count($users) < 5)
					{
						$total_tagihan 	= $total_tagihan + ((200000/$that_day) * $day_range);
					}
					elseif(count($users) >= 5)
					{
						$total_tagihan 	= $total_tagihan + ((150000/$that_day) * $day_range);
					}
				}
			}
		}

		return $total_tagihan;
	}

	private function retrieveTagihan($query)
	{
		//1. pastikan berasal dari kantor yang sama
		$data 	 	= $this->query->kantor($this->active_office['kantor']['id'])->tipe('bukti_kas_keluar');

		//2. cari sesuai query
		if(isset($query['cari']))
		{
			$data 	= $data->where(function($q)use($query){$q->where('klien_nama', 'like', '%'.$query['cari'].'%')->orwhere('nomor_transaksi', 'like', '%'.$query['cari'].'%');});
		}

		//3. filter 
		foreach ((array)$query['filter'] as $key => $value) 
		{
			if(in_array($key, ['status']))
			{
				$data 		= $data->where($key, $value);				
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
