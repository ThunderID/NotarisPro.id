<?php

namespace App\Http\Controllers\Administrative;

use App\Http\Controllers\Controller;
use App\Domain\Administrative\Models\Pengguna as Query;

use App\Service\Helpers\JSend;

use Illuminate\Http\Request;

use TAuth, Exception, Validator;

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
		$this->page_attributes->title		= 'Akun';

		// 2. call all users data needed
		//2a. get all filter 
		$this->page_datas->id 				= TAuth::loggedUser()['id'];
		$this->page_datas->akun 			= TAuth::loggedUser();
		
		//3.initialize view
		$this->view							= view('notaris.pages.administrative.akun.create');

		return $this->generateView();  
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		try {
			$this->active_office 	= TAuth::activeOffice();
			$this->logged_user 		= TAuth::loggedUser();

			$rule['password']		= 'required|min:8|confirmed';

			$validator 				= Validator::make($request->all(), $rule);

			if(!$validator->passes())
			{
				throw new Exception($validator->messages()->toJson(), 1);
			}

			$akun 					= $this->query->findorfail($this->logged_user['id']);
			$akun->password 		= $request->get('password');

			$akun->save();

			$this->page_attributes->msg['success']		= ['Pengaturan Berhasil Disimpan'];
			return $this->generateRedirect(route('administrative.akun.edit', $this->logged_user['id']));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();
			return $this->generateRedirect(route('administrative.akun.edit', $this->logged_user['id']));
		}
	}
}
