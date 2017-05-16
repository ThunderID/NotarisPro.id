<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\Akta\DaftarAkta as Query;
use App\Service\Akta\DaftarTemplateAkta;

use App\Service\Admin\DaftarPengguna;
use App\Service\Order\DaftarKlien;

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
		$this->page_attributes->title	= 'Dashboard';
    	
    	if($role['role']=='notaris')
    	{
			$this->page_datas->lists_to_check			= $this->query->get(['status' => 'draft']);
			
			$this->page_datas->lists_akta				= $this->query->get(['created' => Carbon::parse('first day of this month')->format('Y-m-d H:i:s'), 'status' => 'akta']);

			$this->page_datas->stat_akta_bulan_ini		= $this->query->count(['created' => Carbon::parse('first day of this month')->format('Y-m-d H:i:s'), 'status' => 'akta']);

			$this->page_datas->stat_total_drafter		= $this->user->count();

			$this->page_datas->stat_total_klien_baru	= $this->klien->count(['created' => Carbon::parse('first day of this month')->format('Y-m-d H:i:s')]);
			$this->page_datas->stat_tagihan				= $this->totalTagihan($this->user->get());

			//initialize view
			$this->view		= view('pages.dashboard.notaris');
    	}
    	else
    	{
    		$this->page_datas->lists_to_check			= $this->query->get(['status' => 'renvoi']);
    		$this->page_datas->draft_to_check			= $this->query->get(['status' => 'dalam_proses']);
			
			$this->page_datas->stat_draft_akta			= $this->query->count(['status' => 'dalam_proses']);
			$this->page_datas->stat_renvoi_akta			= $this->query->count(['status' => 'renvoi']);
			$this->page_datas->stat_template			= $this->template->count(['status' => 'draft']);

			$this->page_datas->stat_total_klien_baru	= $this->klien->count(['created' => Carbon::parse('first day of this month')->format('Y-m-d H:i:s')]);

			$this->view		= view('pages.dashboard.drafter');
    	}

		//get data from database
		$this->page_datas->datas            = null;
		
		//function from parent to generate view
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
