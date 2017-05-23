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
    		//need to re-check
    		$this->page_datas->ongoing_klien	= count(KlienProgress::ongoing($role['kantor']['id']));
    		$this->page_datas->peak_klien		= count(KlienProgress::ongoing($role['kantor']['id']));

    		$this->page_datas->total_client		= Klien::kantor($role['kantor']['id'])->count();
    		$this->page_datas->new_client_today	= Klien::kantor($role['kantor']['id'])->where('created_at', '>=', new UTCDateTime(strtotime(\Carbon\Carbon::now()->startOfDay()->format('Y-m-d H:i:s'))))->count() / max(1,$this->page_datas->total_client) * 100;

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
    		$this->page_datas->ongoing_klien	= count(KlienProgress::ongoing($role['kantor']['id']));
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
    	
		$this->page_datas->female_drafter	= Pengguna::kantor($role['kantor']['id'])->count();
		$this->page_datas->male_drafter		= Pengguna::kantor($role['kantor']['id'])->count();
    	
		$this->page_datas->female_drafter_turnover		= Pengguna::kantor($role['kantor']['id'])->count();
		$this->page_datas->male_drafter_turnover		= Pengguna::kantor($role['kantor']['id'])->count();

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
