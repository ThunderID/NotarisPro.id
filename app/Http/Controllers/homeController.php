<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\Akta\DaftarAkta as Query;
use App\Service\Akta\DaftarTemplateAkta;

use App\Service\Admin\DaftarPengguna;
use App\Service\Order\DaftarKlien;

use App\Domain\Stat\Models\KlienProgress;
use App\Domain\Stat\Models\UserAttendance;

use App\Domain\Invoice\Models\Klien;

use App\Domain\Akta\Models\Template;
use App\Domain\Akta\Models\Dokumen;

use App\Domain\Admin\Models\Pengguna;

use App\Domain\Invoice\Models\HeaderTransaksi;

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
    		//area stat 
    		$this->page_datas->stat_template 	= Template::where('penambahan_paragraf', '>', 10)->orwhere('pengurangan_paragraf', '>', 10)->orwhere('perubahan_paragraf', '>', 10)->kantor($role['kantor']['id'])->count();
    		$this->page_datas->stat_akta 		= $this->query->count(['status' => 'draft']);
    		$this->page_datas->stat_billing 	= HeaderTransaksi::where('sudah_dibayar', false)->where('tipe', 'billing_out')->kantor($role['kantor']['id'])->count();


    		$this->page_datas->akta_to_check 		= $this->query->get(['status' => 'draft', 'per_page' => 10]);
    		$this->page_datas->template_to_check 	= Template::where('penambahan_paragraf', '>', 10)->orwhere('pengurangan_paragraf', '>', 10)->orwhere('perubahan_paragraf', '>', 10)->kantor($role['kantor']['id'])->take(10)->get();
    		$this->page_datas->billing_to_check 	= HeaderTransaksi::where('sudah_dibayar', false)->where('tipe', 'billing_out')->kantor($role['kantor']['id'])->take(10)->get();

			//initialize view
			$this->view		= view('pages.dashboard.notaris');
    	}
    	else
    	{
	  		//area stat 
    		$this->page_datas->stat_template 	= Template::where('penambahan_paragraf', '>', 10)->orwhere('pengurangan_paragraf', '>', 10)->orwhere('perubahan_paragraf', '>', 10)->kantor($role['kantor']['id'])->count();
    		$this->page_datas->stat_akta 		= $this->query->count(['status' => 'draft']);
    		$this->page_datas->stat_billing 	= HeaderTransaksi::where('sudah_dibayar', false)->kantor($role['kantor']['id'])->count();


    		$this->page_datas->akta_to_check 		= $this->query->get(['status' => 'draft', 'per_page' => 10]);
    		$this->page_datas->template_to_check 	= Template::where('penambahan_paragraf', '>', 10)->orwhere('pengurangan_paragraf', '>', 10)->orwhere('perubahan_paragraf', '>', 10)->kantor($role['kantor']['id'])->take(10)->get();
    		$this->page_datas->billing_to_check 	= HeaderTransaksi::where('sudah_dibayar', false)->kantor($role['kantor']['id'])->take(10)->get();

			$this->view		= view('pages.dashboard.drafter');
    	}

		//get data from database
		$this->page_datas->datas            = null;
		
		//function from parent to generate view
		return $this->generateView();  
    }

    public function market()
    {
    	$role 				= TAuth::activeOffice();

		// init
		$this->page_attributes->title			= 'Dashboard';
    	
    	if($role['role']=='notaris')
    	{
    		//area stat klien
    		$this->getStatKlien($role);

    		//area net retention
    		$this->getNetRetention($role);

    		//sebaran berdasarkan peminat
    		$this->statPeminat($role);

			//initialize view
			$this->view		= view('pages.dashboard.market.notaris');
    	}
    	else
    	{
			$this->view		= view('pages.dashboard.market.drafter');
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

		$this->getStatDrafter($role);
		
		$this->getStatStreak($role);
	
		$this->getPerformance($role);
		
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

	private function getStatKlien($role)
	{
		$query[]	= 	[
		'$match' 					=> 	[
			'kantor.id' 			=> 	['$eq' => $role['kantor']['id']],
			'deleted_at' 			=> 	['$eq' => null]
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
		
		$this->page_datas->stat_new_today	= (int)$data_client->where('created_at', '>=', new UTCDateTime(strtotime(Carbon::now()->startOfDay()->format('Y-m-d H:i:s'))))->first()['numbers'];

		$this->page_datas->stat_peak_amount	= (int)$data_client->max('numbers');
		$this->page_datas->stat_peaked_at 	= $data_client->where('numbers', $this->page_datas->stat_peak_amount)->first()['tanggal']->toDateTime()->format('d/m/Y');

		$this->page_datas->stat_total_client= Klien::kantor($role['kantor']['id'])->count();

		$this->page_datas->stat_new			= round(count(KlienProgress::kantor($role['kantor']['id'])->NewCustomer(1)->get())/ max(1,$this->page_datas->stat_total_client) * 100);

		$this->page_datas->stat_returning	= round(count(KlienProgress::kantor($role['kantor']['id'])->ReturningCustomer(1)->get())/ max(1,$this->page_datas->stat_total_client) * 100);

		return true;
	}

	private function getNetRetention($role)
	{
		$query[]	= 	[
		'$match' 						=> 	[
			'pemilik.kantor.id' 		=> 	['$eq' => $role['kantor']['id']]
			]
		];

		$query[]	= 	[
			'$group'					=> 	[
				"_id" 					=> 	'$status',
				"numbers" 				=> 	[
					'$sum'				=> 	1
				],
			]
		];

		$data_dokumen 					= collect(Dokumen::raw(function ($collection) use ($query)
				    						{ 
				    							return $collection->aggregate($query); 
				    						}));

		$this->page_datas->net_retent_ongoing 	= 0;
		$this->page_datas->net_retent_completed = 0;
		
		$total_akta 					= 0;

		foreach ($data_dokumen as $key => $value) 
		{
			if(str_is('akta', $value['_id']))
			{
				$this->page_datas->net_retent_completed = $this->page_datas->net_retent_completed + $value['numbers'];
			}
			else
			{
				$this->page_datas->net_retent_ongoing 	= $this->page_datas->net_retent_ongoing + $value['numbers'];
			}

			$total_akta 								= $total_akta + $value['numbers'];
		}

		$this->page_datas->net_retent_canceled			= Dokumen::kantor($role['kantor']['id'])->onlyTrashed()->count();

		$total_akta 					= $total_akta + $this->page_datas->net_retent_canceled;

		$this->page_datas->net_retent_ongoing_percentage 	= round($this->page_datas->net_retent_ongoing / max($total_akta, 1) * 100);
		$this->page_datas->net_retent_completed_percentage 	= round($this->page_datas->net_retent_completed / max($total_akta, 1) * 100);
		$this->page_datas->net_retent_canceled_percentage 	= round($this->page_datas->net_retent_canceled / max($total_akta, 1) * 100);
		return true;
	}

	private function statPeminat($role)
	{
		$lists_template			= Template::kantor($role['kantor']['id'])->where('status', 'publish')->get(['judul', 'created_at', 'updated_at'])->toArray();

		//get lists last 3 months
		// $month[]		= Carbon::now()->format('M`y');
		$month[]		= Carbon::parse('-2 months');//->format('M`y');
		$month[]		= Carbon::parse('-1 month');//->format('M`y');

		$now 			= new UTCDateTime(strtotime(Carbon::parse('first day of this month')->startOfDay()));

		foreach ($lists_template as $key => $value) 
		{

			foreach ($month as $key2 => $value2) 
			{
				$lists_template[$key]['compare'][$value2->format('M`y')]['total']['published']	= Dokumen::kantor($role['kantor']['id'])->where('template.id', $value['id'])->where('status', 'akta')->where('updated_at', '>=', new UTCDateTime(strtotime($value2)))->where('updated_at', '<', $now)->count();

				$lists_template[$key]['compare'][$value2->format('M`y')]['total']['drafted']	= Dokumen::kantor($role['kantor']['id'])->where('template.id', $value['id'])->whereIn('status', ['draft', 'dalam_proses', 'renvoi'])->where('updated_at', '>=', new UTCDateTime(strtotime($value2)))->where('updated_at', '<', $now)->count();

				$lists_template[$key]['compare'][$value2->format('M`y')]['total']['trashed']	= Dokumen::kantor($role['kantor']['id'])->where('template.id', $value['id'])->onlyTrashed()->where('deleted_at', '>=', new UTCDateTime(strtotime($value2)))->where('deleted_at', '<', $now)->count();

				$lists_template[$key]['compare'][$value2->format('M`y')]['total']['all']		= $lists_template[$key]['compare'][$value2->format('M`y')]['total']['published'] + $lists_template[$key]['compare'][$value2->format('M`y')]['total']['drafted'] + $lists_template[$key]['compare'][$value2->format('M`y')]['total']['trashed'];

				$input_data 					= Dokumen::kantor($role['kantor']['id'])->where('template.id', $value['id'])->where('status', 'akta')->orderby('created_at', 'desc')->first();
			}

			$lists_template[$key]['pivot']['total']['published']= Dokumen::kantor($role['kantor']['id'])->where('template.id', $value['id'])->where('status', 'akta')->where('updated_at', '>=', $now)->count();

			$lists_template[$key]['pivot']['total']['drafted']	= Dokumen::kantor($role['kantor']['id'])->where('template.id', $value['id'])->whereIn('status', ['draft', 'dalam_proses', 'renvoi'])->where('updated_at', '>=', $now)->count();

			$lists_template[$key]['pivot']['total']['trashed']	= Dokumen::kantor($role['kantor']['id'])->where('template.id', $value['id'])->onlyTrashed()->where('deleted_at', '>=', $now)->count();


			$lists_template[$key]['pivot']['total']['all']		= $lists_template[$key]['pivot']['total']['published'] + $lists_template[$key]['pivot']['total']['drafted'] + $lists_template[$key]['pivot']['total']['trashed'];

			$input_data 					= Dokumen::kantor($role['kantor']['id'])->where('template.id', $value['id'])->where('status', 'akta')->orderby('created_at', 'desc')->first();
		}

		$this->page_datas->sebaran_peminat 	= $lists_template;
		$this->page_datas->sebaran_bulan 	= $month;

		return true;
	}

	private function getStatDrafter($role)
	{
		$now 		= new UTCDateTime(strtotime(Carbon::parse('first day of this month')->startOfDay()));
		$lmonth 	= new UTCDateTime(strtotime(Carbon::parse('first day of last month')->startOfDay()));

		$this->page_datas->stat_active_drafter		= Pengguna::kantor($role['kantor']['id'])->where('visas.role', 'drafter')->count();

		$this->page_datas->stat_drafter_baru		= Pengguna::kantor($role['kantor']['id'])->where('visas.role', 'drafter')->where('created_at', '>=',$now)->count();

		$this->page_datas->stat_drafter_keluar		= Pengguna::kantor($role['kantor']['id'])->where('visas.role', 'drafter')->where('deleted_at', '>=', $now)->onlyTrashed()->count();
	
		$this->page_datas->stat_active_drafter_lm	= Pengguna::kantor($role['kantor']['id'])->where('visas.role', 'drafter')->withTrashed()->where('created_at', '<', $now)->count();
	
		$this->page_datas->stat_drafter_baru_lm		= Pengguna::kantor($role['kantor']['id'])->where('visas.role', 'drafter')->where('created_at', '>=',$lmonth)->where('created_at', '<', $now)->count();

		$this->page_datas->stat_drafter_keluar_lm	= Pengguna::kantor($role['kantor']['id'])->where('visas.role', 'drafter')->where('deleted_at', '>=', $lmonth)->where('deleted_at', '<', $now)->onlyTrashed()->count();
	}

	public function getStatStreak($role)
	{
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

		$this->page_datas->stat_total_akta		= $dokumen->sum('numbers');
		$this->page_datas->stat_longest_streak	= $dokumen->max('numbers');
		if($this->page_datas->stat_longest_streak)
		{
			$this->page_datas->stat_longest_at		= $dokumen->where('numbers', $this->page_datas->stat_longest_streak)->first()['tanggal']->toDateTime()->format('d/m/Y');
		}
		else
		{
			$this->page_datas->stat_longest_streak	= 0;
			$this->page_datas->stat_longest_at		= Carbon::now()->format('d/m/Y');
		}

		$aktas 									= Dokumen::kantor($role['kantor']['id'])->where('status', 'akta')->get(['created_at', 'updated_at']);

		$rerata 			= 0;
		foreach ($aktas as $key => $value) 
		{
			$rerata 		= ($rerata + $value['created_at']->diffInHours($value['updated_at']) + 1)/($key + 1);
		}

		$this->page_datas->stat_average_streak	= $rerata;

		return true;
	}

	private function getPerformance($role)
	{
		$lists_drafter	= Pengguna::kantor($role['kantor']['id'])->where('visas.role', 'notaris')->get(['nama'])->toArray();

		$start_of_month	= Carbon::parse('first day of this month')->startOfDay();
		$end_of_month	= Carbon::parse('last day of this month')->endOfDay();
	
		$start_of_lm	= Carbon::parse('first day of last month')->startOfDay();
		$end_of_lm		= Carbon::parse('last day of last month')->endOfDay();

		$som 			= new UTCDateTime(strtotime($start_of_month));
		$eom 			= new UTCDateTime(strtotime($end_of_month));

		$som_lm 		= new UTCDateTime(strtotime($start_of_lm));
		$eom_lm 		= new UTCDateTime(strtotime($end_of_lm));

		$ideal_rate 	= 8 * 60 *60; 
		foreach ($lists_drafter as $key => $value) 
		{
			//hadir monthly
			$lists_drafter[$key]['hari_hadir'] 		= UserAttendance::kantor($role['kantor']['id'])->where('pengguna_id', $value['id'])->where('jam_masuk', '>=', $start_of_month)->where('jam_masuk', '<=', $end_of_month)->count();

			$lists_drafter[$key]['akta_published']	= Dokumen::kantor($role['kantor']['id'])->where('penulis.id', $value['id'])->where('status', 'akta')->where('updated_at', '>=', $som)->count();

			$lists_drafter[$key]['performance']		= UserAttendance::selectRaw(\DB::raw("SUM(TIME_TO_SEC(TIMEDIFF( jam_keluar, jam_masuk))) as total"))->kantor($role['kantor']['id'])->where('jam_masuk', '>=', $start_of_month)->where('jam_masuk', '<=', $end_of_month)->where('pengguna_id', $value['id'])->first()['total'];

			$lists_drafter[$key]['hari_hadir_lm'] 		= UserAttendance::kantor($role['kantor']['id'])->where('pengguna_id', $value['id'])->where('jam_masuk', '>=', $start_of_lm)->where('jam_masuk', '<=', $end_of_lm)->count();

			$lists_drafter[$key]['akta_published_lm']	= Dokumen::kantor($role['kantor']['id'])->where('penulis.id', $value['id'])->where('status', 'akta')->where('updated_at', '>=', $som_lm)->where('updated_at', '<', $som)->count();
			
			$lists_drafter[$key]['performance_lm']		= UserAttendance::selectRaw(\DB::raw("SUM(TIME_TO_SEC(TIMEDIFF( jam_keluar, jam_masuk))) as total"))->kantor($role['kantor']['id'])->where('jam_masuk', '>=', $start_of_lm)->where('jam_masuk', '<=', $end_of_lm)->where('pengguna_id', $value['id'])->first()['total'];

			$lists_drafter[$key]['hour_perakta']		= round($lists_drafter[$key]['akta_published'] / max(1, $lists_drafter[$key]['performance']));

			$lists_drafter[$key]['hour_perakta_lm']		= round($lists_drafter[$key]['akta_published_lm'] / max(1, $lists_drafter[$key]['performance_lm']));

			$lists_drafter[$key]['effective_rate']		= round($ideal_rate / max($lists_drafter[$key]['hour_perakta'],$ideal_rate)) * 100;	
			$lists_drafter[$key]['effective_rate_lm']	= round($ideal_rate / max($lists_drafter[$key]['hour_perakta_lm'],$ideal_rate)) * 100;
		}

		$this->page_datas->performance_drafter 		= $lists_drafter;

		return true;
	}
}
