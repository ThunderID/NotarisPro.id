<?php

namespace App\Http\Controllers\UAC;

use TAuth, Redirect, URL, Mail;

use App\Http\Controllers\Controller;

use App\Infrastructure\Traits\GuidTrait;

use App\Domain\Admin\Models\Pengguna;

use Illuminate\Http\Request;
use App\Mail\SendResetPasswordToken;

class passwordController extends Controller
{
	use GuidTrait;

	//fungsi get mail
	public function create(Request $request)
	{
		// init
		$this->page_attributes->title		= 'Password';

		//get data from database
		$this->page_datas->datas			= null;
		$this->page_datas->datas['email']	= $request->get('email');

		//initialize view
		$this->view							= view('market_web.pages.password.create');

		//function from parent to generate view
		return $this->generateView(); 
	}

	public function store(Request $request)
	{
		$email 		= $request->get('email');
		$pengguna 	= Pengguna::email($email)->first();
		
		if($pengguna)
		{
			$pengguna->reset_token 		= self::createID('token');
			$pengguna->save();

			Mail::to($pengguna->email)->send(new SendResetPasswordToken($pengguna));
		}

		// init
		$this->page_attributes->title		= 'Password';

		//get data from database
		$this->page_datas->datas			= $pengguna;

		//initialize view
		$this->view							= view('market_web.pages.password.show');

		//function from parent to generate view
		return $this->generateView(); 
	}

	//fungsi get mail
	public function edit(Request $request, $token)
	{
		// init
		$this->page_attributes->title		= 'Password';

		//get data from database
		$this->page_datas->datas			= null;
		$this->page_datas->datas['token']	= $token;

		//initialize view
		$this->view							= view('market_web.pages.password.edit');

		//function from parent to generate view
		return $this->generateView(); 
	}

	public function update(Request $request, $token)
	{
		$pengguna 	= Pengguna::where('reset_token', $token)->first();
		
		if(!$pengguna)
		{
			return Redirect::back()->withErrors(['Link tidak valid']);
		}

		$pengguna->password 	= $request->get('password');
		$pengguna->save();

		return Redirect::route('uac.login.create')->with('pesan', 'Password berhasil di ubah. Silahkan login menggunakan password baru.');
	}
}
