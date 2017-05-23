<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\Akta\DaftarAkta as Query;
use App\Service\Akta\DaftarTemplateAkta;

use App\Service\Admin\DaftarPengguna;
use App\Service\Order\DaftarKlien;

use App\Domain\Stat\Models\KlienProgress;

use App\Domain\Order\Models\Klien;

use App\Domain\Akta\Models\Template;
use App\Domain\Akta\Models\Dokumen;

use App\Domain\Admin\Models\Pengguna;

use MongoDB\BSON\UTCDateTime;

use TAuth;
use Carbon\Carbon;

class homeController extends Controller
{
	public function __construct(Query $query, DaftarPengguna $user, DaftarKlien $klien, DaftarTemplateAkta $template)
	{
		parent::__construct();
		
		$this->query		= $query;
		$this->user			= $user;
		$this->klien		= $klien;
		$this->template		= $template;
	}

    public function dashboard()
    {
    	$role 				= TAuth::activeOffice();

		// init
		$this->page_attributes->title			= 'Dashboard';
    	
    	if($role['role']=='notaris')
    	{
			$query[]	= 	[
			'$match' 					=> 	[
				'kantor.id' 			=> 	['$eq' => $role['kantor']['id']]
				]
			];

			$query[]	= 	[
				'$group'					=> 	[
					"_id" 					=> 	[
						'$dayOfYear'		=> 	'$created_at'
					],
					"numbers" 				=> 	[
						'$sum'				=> 	1
					],
					"tanggal"				=> ['$min'	=> '$created_at']
				]
			];

    		$data_client 					= collect(Klien::raw(function ($collection) use ($query)
					    						{ 
					    							return $collection->aggregate($query); 
					    						})->toArray());
    		
    		$this->page_datas->ongoing_klien	= (int)$data_client->where('created_at', '>=', new UTCDateTime(strtotime(Carbon::now()->startOfDay()->format('Y-m-d H:i:s'))))->first()['numbers'];

    		$this->page_datas->peak_klien		= (int)$data_client->max('numbers');
    		$this->page_datas->peaked_at 		= $data_client->where('numbers', $this->page_datas->peak_klien)->first()['tanggal']->toDateTime()->format('d/m/Y');

    		$this->page_datas->total_client		= Klien::kantor($role['kantor']['id'])->count();

    		$this->page_datas->new_client		= count(KlienProgress::kantor($role['kantor']['id'])->NewCustomer(1)->get())/ max(1,$this->page_datas->total_client) * 100;

    		$this->page_datas->returning_client	= count(KlienProgress::kantor($role['kantor']['id'])->ReturningCustomer(1)->get())/ max(1,$this->page_datas->total_client) * 100;

    		$lists_template						= Template::kantor($role['kantor']['id'])->where('status', 'publish')->get(['judul', 'created_at', 'updated_at'])->toArray();

    		foreach ($lists_template as $key => $value) 
    		{
    			$lists_template[$key]['total']['published']	= Dokumen::kantor($role['kantor']['id'])->where('template.id', $value['id'])->where('status', 'akta')->count();
    			$lists_template[$key]['total']['drafted']	= Dokumen::kantor($role['kantor']['id'])->where('template.id', $value['id'])->whereIn('status', ['draft', 'dalam_proses', 'renvoi'])->count();

    			$lists_template[$key]['total']['trashed']	= Dokumen::kantor($role['kantor']['id'])->where('template.id', $value['id'])->onlyTrashed()->count();
    			$lists_template[$key]['total']['all']		= $lists_template[$key]['total']['published'] + $lists_template[$key]['total']['drafted'] + $lists_template[$key]['total']['trashed'];

    			$input_data 					= Dokumen::kantor($role['kantor']['id'])->where('template.id', $value['id'])->where('status', 'akta')->orderby('created_at', 'desc')->first();

    			if($input_data)
    			{
	    			$lists_template[$key]['pengerjaan']['total']= max(Carbon::createFromFormat('d/m/Y', $input_data['tanggal_pembuatan'])->diffInDays(Carbon::createFromFormat('d/m/Y', $input_data['tanggal_sunting'])), 1);
    			}
    			else
    			{
	    			$lists_template[$key]['pengerjaan']['total']= 0;
    			}
    		}

    		$this->page_datas->lists_template 	= $lists_template;

			//initialize view
			$this->view		= view('pages.dashboard.notaris');
    	}
    	else
    	{
			$this->view		= view('pages.dashboard.drafter');
    	}

		//get data from database
		$this->page_datas->datas            = null;
		
		//function from parent to generate view
		return $this->generateView();  
    }

    public function kpi()
    {
    	$role				= TAuth::activeOffice();

		// init
		$this->page_attributes->title		= 'Dashboard';
    	
		$this->page_datas->active_drafter	= Pengguna::kantor($role['kantor']['id'])->count();
    	
    	$query[]	= 	[
			'$match' 					=> 	[
				'pemilik.kantor.id' 	=> 	['$eq' => $role['kantor']['id']],
				'status' 				=> 	['$eq' => 'akta'],
				]
			];

		$query[]	= 	[
			'$group'					=> 	[
				"_id" 					=> 	[
					'$dayOfYear'		=> 	'$updated_at'
				],
				"numbers" 				=> 	[
					'$sum'				=> 	1
				],
				"tanggal"				=> ['$min'	=> '$updated_at']
			]
		];

		$dokumen 						= collect(Dokumen::raw(function ($collection) use ($query)
				    						{ 
				    							return $collection->aggregate($query); 
				    						}));

		$this->page_datas->longest_streak	= $dokumen->max('numbers');
		$this->page_datas->longest_at		= $dokumen->where('numbers', $this->page_datas->longest_streak)->first()['tanggal']->toDateTime()->format('d/m/Y');

		$this->page_datas->baru_turnover	= Pengguna::kantor($role['kantor']['id'])->where('created_at', '>=', new UTCDateTime(strtotime(Carbon::parse('first day of this month')->startOfDay()->format('Y-m-d H:i:s'))))->count();
		$this->page_datas->keluar_turnover	= Pengguna::kantor($role['kantor']['id'])->where('deleted_at', '>=', new UTCDateTime(strtotime(Carbon::parse('first day of this month')->startOfDay()->format('Y-m-d H:i:s'))))->onlyTrashed()->count();

		$aktas 								= Dokumen::kantor($role['kantor']['id'])->where('status', 'akta')->get(['created_at', 'updated_at']);

		$rerata 			= 0;
		foreach ($aktas as $key => $value) 
		{
			$rerata 		= ($rerata + $value['created_at']->diffInHours($value['updated_at']) + 1)/($key + 1);
		}
		$this->page_datas->rerata		= $rerata;

		//Akta Yang di selesaikan
		$lists_karyawan					= Pengguna::kantor($role['kantor']['id'])->get(['nama'])->toArray();

		foreach ($lists_karyawan as $key => $value) 
		{
			$lists_karyawan[$key]['total']['published']	= Dokumen::kantor($role['kantor']['id'])->where('penulis.id', $value['id'])->where('status', 'akta')->count();
			$lists_karyawan[$key]['total']['drafted']	= Dokumen::kantor($role['kantor']['id'])->where('penulis.id', $value['id'])->whereIn('status', ['draft', 'dalam_proses', 'renvoi'])->count();

			$lists_karyawan[$key]['total']['trashed']	= Dokumen::kantor($role['kantor']['id'])->where('penulis.id', $value['id'])->onlyTrashed()->count();
			$lists_karyawan[$key]['total']['all']		= $lists_karyawan[$key]['total']['published'] + $lists_karyawan[$key]['total']['drafted'] + $lists_karyawan[$key]['total']['trashed'];

			$input_data 					= Dokumen::kantor($role['kantor']['id'])->where('penulis.id', $value['id'])->where('status', 'akta')->orderby('created_at', 'desc')->first();

			if($input_data)
			{
    			$lists_karyawan[$key]['pengerjaan']['total']= collect(KlienProgress::kantor($role['kantor']['id'])->where('penulis_id', $value['id'])->selectRaw(\DB::raw('SUM(UNIX_TIMESTAMP(updated_at) - UNIX_TIMESTAMP(created_at)) as time_milis'))->groupby('akta_id')->get())->avg('time_milis');
			}
			else
			{
    			$lists_karyawan[$key]['pengerjaan']['total']= 0;
			}
		}

		$this->page_datas->lists_karyawan 	= $lists_karyawan;
		
		$this->view			= view('pages.dashboard.kpi.notaris');
		return $this->generateView();  
    }

    public function finance()
    {
		$role				= TAuth::activeOffice();

		// init
		$this->page_attributes->title		= 'Dashboard';
    	
		$this->page_datas->female_drafter	= Pengguna::kantor($role['kantor']['id'])->count();
		$this->page_datas->male_drafter		= Pengguna::kantor($role['kantor']['id'])->count();
    	
		$this->page_datas->female_drafter_turnover		= Pengguna::kantor($role['kantor']['id'])->count();
		$this->page_datas->male_drafter_turnover		= Pengguna::kantor($role['kantor']['id'])->count();

		$this->view			= view('pages.dashboard.finance.notaris');
		return $this->generateView();  
    }

	public function totalTagihan($users)
	{
		if(count($users)<=2)
		{
			return 'Rp 500,000';
		}

		$billing 	= 250000;

		$total 		= $billing * count($users);

		return 'Rp '.number_format($total);
	}
}
