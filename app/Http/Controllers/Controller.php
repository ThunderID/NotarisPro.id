<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Pagination\LengthAwarePaginator;

use Request, Redirect, App, Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	//public page data
	protected $page_attributes;
	protected $page_datas;

	function __construct() 
	{
		\DB::connection('mongodb')->enableQueryLog();

		// sets params
		$this->page_attributes 			= new \Stdclass;
		$this->page_datas 				= new \Stdclass;
	}   

	public function generateView()
	{
		$logged_user 					= \TAuth::loggedUser();
		$active_office 					= \TAuth::activeOffice();
		
		\View::share('acl_logged_user', $logged_user);
		\View::share('acl_active_office', $active_office);

		//temporary line can be removed anytime
		//this one to display underconstruction
		$this->underConstruction();

		return $this->view
            ->with('page_attributes', $this->page_attributes)
			->with('page_datas', $this->page_datas)
			;
	} 

	public function generateRedirect($route_to){

		if(isset($this->page_attributes->msg['error'])){
			if(count($this->page_attributes->msg['error']) > 0){
				// return Redirect::back()
				return Redirect::back()
						->withInput(Request::all())
						->withErrors($this->page_attributes->msg['error'])
						;
			}
		}

		if(isset($this->page_attributes->msg['warning'])){
			return Redirect::to($route_to)
					->with('msg', $this->page_attributes->msg)
					;
		}

		if(isset($this->page_attributes->msg['info'])){
			return Redirect::to($route_to)
					->with('msg', $this->page_attributes->msg)
					;
		}

		if(isset($this->page_attributes->msg['success'])){
			return Redirect::to($route_to)
					->with('msg', $this->page_attributes->msg)
					;
		}

		// no message
		return Redirect::to($route_to);
	} 

	//pagination
	public function paginate($route = null, $count = null, $take = 15){
		//Page normalizer
		$page = Request::get('page');
		if(ceil($count/$take) < $page){
			$page = 1;
		}

		// paging
		$this->page_attributes->paging = new LengthAwarePaginator($count, $count, $take, $page);
	    $this->page_attributes->paging->setPath($route);
	}

	//search
	private function getSearch(){
		// get all input with search input name
        $this->page_attributes->search    = Request::input('q');
	}  

	public static function getQueryString($allowed = []){
		$qs = Request::all();
		$result = [];

		foreach ($qs as $key => $value) {
			if (in_array($key, $allowed)) {
				$result[$key] = $value; 
			}
		}

		return $result;
	}


	//this is temporary function
	//only for displaying construction site. cool?
	private function underConstruction()
	{
		if(in_array(Route::currentRouteName(), ['home.dashboard']) || str_is('jadwal.*', Route::currentRouteName()) || str_is('klien.*', Route::currentRouteName()))
		{
			$this->view 				= view('pages.developer.under_construction');
		}
	}
}
