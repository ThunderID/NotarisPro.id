<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Service\Admin\DaftarPengguna as Query;
use App\Service\Admin\SimpanKantor;

use App\Http\Controllers\Controller;

use Exception, Redirect;

class billingController extends Controller
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
	public function index()
	{
		$this->page_attributes->title			= 'Informasi Tagihan';

		$this->page_datas->total_user			= $this->query->count();
		$this->page_datas->total_tagihan		= $this->totalTagihan($this->query->get());
		$this->page_datas->tagihan_bulan_ini	= 'Lunas';

        $this->view                         	= view('pages.billing.index');

		return $this->generateView();  
	}

	public function totalTagihan($users)
	{
		if(count($users)<=2)
		{
			return 'Rp 500,000';
		}

		$billing 	= 250000;

		$total 		= $billing * count($users);

		return 'Rp '.number_format($total);
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
		$this->page_attributes->title		= 'Profil Kantor';

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
