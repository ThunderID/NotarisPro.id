<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Domain\Admin\Models\Kantor as Query;

use App\Service\Helpers\JSend;

use Illuminate\Http\Request;

use TAuth, Exception;

class developerController extends Controller
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
		$this->page_attributes->title		= 'Developer';

		// 2. call all users data needed
		//2a. get all filter 
		$this->page_datas->id 				= TAuth::loggedUser()['id'];
		$this->page_datas->akun 			= TAuth::activeOffice();

		if(!isset($this->page_datas->akun['kantor']['thirdparty']))
		{
			$this->page_datas->akun['kantor']['thirdparty']	= null;
		}

		if(!isset($this->page_datas->akun['kantor']['thirdparty']['gcal']))
		{
			$this->page_datas->akun['kantor']['thirdparty']['gcal']	= null;
		}

		if(!isset($this->page_datas->akun['kantor']['thirdparty']['dbox']))
		{
			$this->page_datas->akun['kantor']['thirdparty']['dbox']	= null;
		}

		if(!isset($this->page_datas->akun['kantor']['thirdparty']['smtp']))
		{
			$this->page_datas->akun['kantor']['thirdparty']['smtp']	= null;
		}

		//3.initialize view
		$this->view							= view('notaris.pages.pengaturan.developer.create');

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

			$kantor 				= Query::findorfail($this->active_office['kantor']['id']);
			$tparty['dbox']['token']= $request->get('developer_dbox_token'); 
			$kantor->thirdparty 	= $tparty;
			$kantor->save();

			// 'thirdparty.gcal.key'				=> 'max:255',
			// 'thirdparty.gcal.secret'			=> 'max:255',
			// 'thirdparty.smtp.email'				=> 'max:255',
			// 'thirdparty.smtp.password'			=> 'max:255'

			$this->page_attributes->msg['success']		= ['Pengaturan Berhasil Disimpan'];
			return $this->generateRedirect(route('pengaturan.developer.edit', $this->active_office['kantor']['id']));
		} catch (Exception $e) {
			dd($e);
			$this->page_attributes->msg['error']		= $e->getMessage();
			return $this->generateRedirect(route('pengaturan.developer.edit', $this->active_office['kantor']['id']));
		}
	}
}
