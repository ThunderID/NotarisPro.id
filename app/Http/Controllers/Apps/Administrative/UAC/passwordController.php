<?php

namespace App\Http\Controllers\Apps\Administrative\UAC;

use App\Http\Controllers\Controller;
// use App\Infrastructure\Traits\GuidTrait;
use App\Mail\SendResetPasswordToken;

// use App\Domain\Administrative\Models\Pengguna;

use TAuth, Redirect, URL, Mail;

class passwordController extends Controller
{
	// use GuidTrait;

	function __construct ()
	{
		parent::__construct();

		$this->view 		= view ($this->base_view . 'templates.blank');
		$this->base_view 	= $this->base_view . 'pages.administrative.uac.password.';
	}

	//fungsi get mail
	public function create ()
	{
		// init
		$this->page_attributes->title		= 'Password';

		//get data from database
		$this->page_datas->datas			= null;
		$this->page_datas->datas['email']	= request()->get('email');

		//initialize view
		$this->view->pages					= view ($this->base_view . 'create');

		//function from parent to generate view
		return $this->generateView(); 
	}

	public function store (Request $request)
	{
		$email 		= $request->get('email');
		$pengguna 	= Pengguna::email($email)->first();
		
		if ($pengguna)
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
		$this->view							= view('notaris.pages.administrative.uac.password.show');

		//function from parent to generate view
		return $this->generateView(); 
	}

	//fungsi get mail
	public function edit($token)
	{
		// init
		$this->page_attributes->title		= 'Password';

		//get data from database
		$this->page_datas->datas			= null;
		$this->page_datas->datas['token']	= $token;

		//initialize view
		$this->view->pages					= view ($this->base_view . 'edit');

		//function from parent to generate view
		return $this->generateView(); 
	}

	public function update(Request $request, $token)
	{
		$pengguna 			= Pengguna::where('reset_token', $token)->first();
		
		if (!$pengguna)
		{
			return back()->withErrors(['Link tidak valid']);
		}

		$pengguna->password = request()->get('password');
		$pengguna->save();

		view()->share('pesan', 'Password berhasil di ubah. Silahkan login menggunakan password baru');

		return redirect()->route('uac.login.create');
	}
}