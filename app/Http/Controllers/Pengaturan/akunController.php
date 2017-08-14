<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Domain\Admin\Models\Pengguna as Query;

use App\Service\Helpers\JSend;

use Illuminate\Http\Request;

use TAuth, Exception;

class akunController extends Controller
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
	public function edit(Request $request)
	{
		$this->active_office 				= TAuth::activeOffice();

		// 1. set page attributes
		$this->page_attributes->title		= 'User';

		// 2. call all users data needed
		//2a. get all filter 
		$this->page_datas->id 				= TAuth::loggedUser()['id'];
		$this->page_datas->akun 			= TAuth::loggedUser();
		
		//3.initialize view
		$this->view							= view('notaris.pages.pengaturan.akun.create');

		return $this->generateView();  
	}
}
