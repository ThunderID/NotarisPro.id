<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Service\Admin\DaftarPengguna as Query;
use App\Service\Admin\UbahPassword;

use App\Http\Controllers\Controller;

use Exception, Redirect;

class akunController extends Controller
{
	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query			= $query;
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
		$this->page_attributes->title		= 'Akun Anda';

		$this->view                         = view('pages.akun.create');

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
		$input 	= $request->only('akun_email', 'akun_password', 'akun_password_confirmation');

		$data 	= new UbahPassword($id, $input['akun_email'], $input['akun_password'], $input['akun_password_confirmation']);

		$data 	= $data->handle();

		return Redirect::route('akun.edit', $id);
	}
}
