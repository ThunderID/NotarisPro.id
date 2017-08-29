<?php

namespace App\Http\Controllers\Administrative;

use App\Http\Controllers\Controller;
use App\Domain\Administrative\Models\Kantor as Query;

use App\Service\Helpers\JSend;

use Illuminate\Http\Request;

use TAuth, Exception;

class kantorController extends Controller
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
		$this->page_attributes->title		= 'Kantor';

		// 2. call all users data needed
		//2a. get all filter 
		$this->page_datas->id 				= $this->active_office['kantor']['id'];
		$this->page_datas->kantor 			= $this->active_office['kantor'];
		
		//3.initialize view
		$this->view							= view('notaris.pages.administrative.kantor.create');

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
			$kantor->fill($request->all());
			$kantor->save();

			$this->page_attributes->msg['success']		= ['Kantor Berhasil Disimpan'];
			return $this->generateRedirect(route('administrative.kantor.edit', $this->active_office['kantor']['id']));
		} catch (Exception $e) {
			$this->page_attributes->msg['error']		= $e->getMessage();
			return $this->generateRedirect(route('administrative.kantor.edit', $this->active_office['kantor']['id']));
		}
	}
}
