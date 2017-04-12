<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class uacController extends Controller
{
	public function login(){
        // init
        $this->page_attributes->title       = 'Login';

        //get data from database
        $this->page_datas->datas            = null;

        //initialize view
        $this->view                         = view('pages.uac.login');

        //function from parent to generate view
        return $this->generateView(); 
	}

	public function doLogin(){

	}

	public function logout(){

	}
}
