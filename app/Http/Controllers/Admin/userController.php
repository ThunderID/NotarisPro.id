<?php

namespace App\Http\Controllers\Admin;

use App\Service\Admin\DaftarPengguna as Query;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use TAuth, Redirect, URL;

class userController extends Controller
{
	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query            = $query;
	}  

	public function index(){
		// init
		$this->page_attributes->title	= 'User';

		//get data from database
		$this->page_datas->datas		= $this->query->get(['per_page' => (int)env('DATA_PERPAGE')]);

		$this->paginate(null, $this->query->count(), (int)env('DATA_PERPAGE'));

		//initialize view
		$this->view						= view('pages.user.index');

		//function from parent to generate view
		return $this->generateView(); 
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update($id = null, Request $request)
	{
		try {
			// get data
			$input		= $request->only(
											'nama', 
											'notaris'
										);
			//is edit?
			if(!is_null($id)){
				$input['id']                     = $id;
			}

			// save
			$data                               = new \TCommands\Kantor\SimpanNotaris($input);
			$data->handle();            
		} catch (Exception $e) {
			$this->page_attributes->msg['error']       = $e->getMessage();
		}

		$this->page_attributes->msg['success']	= ['Data kantor notaris telah diperbarui'];

		return $this->generateRedirect(route('notaris.kantor.edit', ['id' => $id]));
	}
}
