<?php

namespace App\Http\Controllers;

use TAuth, Redirect, Request, URL;

class uacController extends Controller
{
	public function login()
	{
		// init
		$this->page_attributes->title	= 'Login';

		//get data from database
		$this->page_datas->datas		= null;

		//initialize view
		$this->view						= view('pages.uac.login');

		//function from parent to generate view
		return $this->generateView(); 
	}

	public function doLogin(){
		//get input
		$credentials				= Request::only('email', 'password');

		try
		{
			//do authenticate
			$auth					= TAuth::login($credentials);
		}
		catch(Exception $e)
		{
			if(is_array($e->getMessage()))
			{
				return Redirect::route('uac.login')->withErrors($e->getMessage());
			}
			else
			{
				return Redirect::route('uac.login')->withErrors([$e->getMessage()]);
			}
		}

		//function from parent to redirecting
		return Redirect::route('home.dashboard');
	}

	public function logout(){
		//do authenticate
		$auth			= TAuth::signoff();

		//function from parent to redirecting
		return Redirect::route('uac.login');
	}

	/**
	 * setting which office should be activate
	 *
	 * @return Response
	 */
	public function activateOffice($idx)
	{
		try
		{
			//do authenticate
			$auth			= TAuth::setOffice($idx);
		}
		catch(Exception $e)
		{
			if(is_array($e->getMessage()))
			{
				$this->page_attributes->msg['error'] 	= $e->getMessage();
			}
			else
			{
				$this->page_attributes->msg['error'] 	= [$e->getMessage()];
			}

			return Redirect::back()
					->with('msg', $this->page_attributes->msg)
					;
		}

		//function from parent to redirecting
		return redirect(URL::previous());
	}

	public function doSendEmailResetPassword(Request $request){
		$input			= $request::only('email');

		// service reset
		try
		{
			//do service reset password

			// send email
		}
		catch(Exception $e)
		{
			if(is_array($e->getMessage()))
			{
				$this->page_attributes->msg['error'] 	= $e->getMessage();
			}
			else
			{
				$this->page_attributes->msg['error'] 	= [$e->getMessage()];
			}
		}

		//return view
		$this->page_attributes->msg['success']		= ['Email reset password telah dikirimkan ke email Anda'];
		return $this->generateRedirect(route('uac.login'));
	}

	public function resetPassword($token){

		$this->page_datas->datas		= null;
		$this->page_datas->token		= $token;

		// validate token reset password
		$result = true;

		if($result == true){
			// display reset password form
			$this->page_attributes->title	= 'Reset Password';
			
			$this->view						= view('pages.uac.reset');
		}else{
			// display invalid token
			$this->page_attributes->title	= 'Invalid Token';

			$this->view						= view('pages.uac.invalid');
		}

		// return view
		return $this->generateView(); 
	}


	public function doResetPassword($token, Request $request){
		$input			= $request::only('password', 'confirm_password');

		// validation
		if($input['password'] == $input['confirm_password']){
			// service reset
			try
			{
				//do service reset password

				// send email
			}
			catch(Exception $e)
			{
				if(is_array($e->getMessage()))
				{
					$this->page_attributes->msg['error'] 	= $e->getMessage();
				}
				else
				{
					$this->page_attributes->msg['error'] 	= [$e->getMessage()];
				}
			}
		}else{
			$this->page_attributes->msg['error'] 	= ['Password dan konfirmasi password tidak cocok'];
		}


		//return view
		$this->page_attributes->msg['success']		= ['Password telah diganti'];
		return $this->generateRedirect(route('uac.login'));
	}
}
