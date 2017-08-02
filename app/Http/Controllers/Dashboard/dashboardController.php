<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use TAuth;
use Carbon\Carbon;

use App\Http\Controllers\Controller;

class dashboardController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
	}

	public function home()
	{
		return view('notaris.pages.dashboard.home');
	}
}
