<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\Akta\DaftarAkta as Query;

use TAuth;

class homeController extends Controller
{
	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query            = $query;
	}

    public function dashboard()
    {
    	$role 				= TAuth::activeOffice();

		// init
		$this->page_attributes->title	= 'Dashboard';
    	
    	if($role['role']=='notaris')
    	{
			$this->page_datas->lists_to_check			= $this->query->get(['status' => 'pengajuan']);
			$this->page_datas->lists_akta				= $this->query->get(['status' => 'akta']);

			$this->page_datas->stat_akta_bulan_ini		= $this->query->countThisMonth();
			$this->page_datas->stat_total_drafter		= $this->query->countThisMonth();
			$this->page_datas->stat_total_klien_baru	= $this->query->countThisMonth();

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
}
