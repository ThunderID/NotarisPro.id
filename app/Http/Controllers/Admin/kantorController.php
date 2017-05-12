<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Service\Admin\DaftarKantor as Query;

use App\Http\Controllers\Controller;

use Exception;

class kantorController extends Controller
{
	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query            = $query;
	}    

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{

		$this->page_datas->id				= $id;
		$this->page_datas->datas			= $this->query->detailed($id);
		$this->page_attributes->title		= $this->page_datas->datas['nama'];

        $this->view                         = view('pages.kantor.create');

		return $this->generateView();  
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		return $this->store($id, $request);
	}
}
