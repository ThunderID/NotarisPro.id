<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use TAuth;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Service\Subscription\GenerateTagihanSAAS;
use App\Domain\Order\Models\HeaderTransaksi;

class dashboardController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
	}

	public function home()
	{
		// $data  	= new GenerateTagihanSAAS;
		// $data->bulanan(Carbon::parse('+ 2 month')->startOfDay());

		$this->getGlobal();

		$pesan 			= null;

		if($this->active_office['type']=='trial')
		{
			$pesan		= 'Free trial only '.Carbon::now()->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', $this->active_office['expired_at'])).' day(s) ';
		}

		return view('notaris.pages.dashboard.home', compact('pesan'));
	}
}
