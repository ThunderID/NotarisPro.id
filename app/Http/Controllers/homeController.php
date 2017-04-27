<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeController extends Controller
{

    public function dashboard(){
		// init
		$this->page_attributes->title       = 'Data Member';

		//get data from database
		$this->page_datas->datas            = null;

		//initialize view
		$this->view                         = view('pages.dashboard.dashboard');
		
		//function from parent to generate view
		return $this->generateView();  
    }
}
