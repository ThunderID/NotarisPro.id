<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use TAuth;
use Carbon\Carbon;

use App\Http\Controllers\Controller;

class webController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
	}

	public function home()
	{
		return view('market_web.pages.home');
	}

	public function service()
	{
		return view('market_web.pages.service');
	}

	public function pricing()
	{
		return view('market_web.pages.pricing');
	}

	public function tutorial()
	{
		return view('market_web.pages.tutorial');
	}
}
