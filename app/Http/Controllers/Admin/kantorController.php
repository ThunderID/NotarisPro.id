<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Service\Admin\DaftarKantor as Query;
use App\Service\Admin\SimpanKantor;

use App\Http\Controllers\Controller;

use Exception, Redirect;

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
		$input 	= $request->only('nama', 'notaris');

		$data 	= new SimpanKantor($id, $input['nama'], $input['notaris']['nama'], $input['notaris']['daerah_kerja'], $input['notaris']['nomor_sk'], $input['notaris']['tanggal_pengangkatan'], $input['notaris']['alamat'], $input['notaris']['telepon'], null);

		$data 	= $data->handle();

		return Redirect::route('kantor.edit', $id);
	}
}
