<?php

namespace App\Http\Controllers\Kantor;

use TQueries\Kantor\DaftarNotaris as Query;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use TAuth, Redirect, URL;

class KantorController extends Controller
{
	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query            = $query;
	}  

	public function edit($kantor_id){
		// init
		$this->page_attributes->title	= 'Kantor';

		//get data from database
		$this->page_datas->id			= $kantor_id;
		$this->page_datas->datas		= $this->query->detailed($kantor_id);

		//initialize view
		$this->view						= view('pages.kantor.create');

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
