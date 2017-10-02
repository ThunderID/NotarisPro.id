<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;

use Route, TAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $page_attributes;
    protected $page_datas;
    protected $base_view = 'apps.';

    function __construct ()
    {
        // \DB::connection('mongodb')->enableQueryLog();

        // sets params
		$this->page_attributes 	= new \Stdclass;
		$this->page_datas 		= new \Stdclass;
    }

        
    public function generateView ()
    {
        if (!str_is('uac*', Route::currentRouteName()))
		{
			///from here to next stoppage just for the sake of performance
			// $logged_user 				= \TAuth::loggedUser();
			// $active_office 				= \TAuth::activeOffice();

			// define('acl_logged_user', $logged_user);
			// define('acl_active_office', $active_office);

            // view()->share('acl_logged_user', $logged_user);
            // view()->share('acl_active_office', $active_office);
		}
		
        view()->share('page_attributes', $this->page_attributes);
        view()->share('page_datas', $this->page_datas);

        return $this->view;
    }

    public function generateRedirect ($route_to)
    {
        // if message 'error'
		if (isset($this->page_attributes->msg['error']))
        {
			if (count($this->page_attributes->msg['error']) > 0)
            {
                return back()->withInput(request()->all())
                    ->withErrors($this->page_attributes->msg);
			}
		}
        
        // if message 'warning'
		if (isset($this->page_attributes->msg['warning']))
        {
            view()->share('msg', $this->page_attributes->msg);

            return redirect($route_to);
		}

        // if message 'info'
		if (isset($this->page_attributes->msg['info']))
        {
            view()->share('msg', $this->page_attributes->msg);

            return redirect($route_to);
		}

        // if message 'succes'
		if (isset($this->page_attributes->msg['success']))
        {
            view()->share('msg', $this->page_attributes->msg);

            return redirect($route_to);
		}

		// no message
        return redirect($route_to);
	} 

    // query string for search
    public static function getQueryString ($allowed = [])
    {
		$qs     = request()->all();
		$result = [];

		foreach ($qs as $key => $value) 
        {
			if (in_array($key, $allowed)) 
            {
				$result[$key] = $value; 
			}
		}
		return $result;
	}


    //search
	private function getSearch ()
    {
		// get all input with search input name
        $this->page_attributes->search    = request()->input('q');
	}  


   //pagination
	public function paginate ($route = null, $count = null, $take = 15)
    {
		//Page normalizer
		$page = request()->get('page');
		
        if (ceil($count/$take) < $page)
        {
			$page = 1;
		}
		// paging
		$this->page_attributes->paging = new LengthAwarePaginator($count, $count, $take, $page);
		$this->page_attributes->paging->setPath($route);
	}

}