<?php
	use Illuminate\Pagination\LengthAwarePaginator;

	function generatePaginator($count = null, $take = null)
	{
		$page 				= 1;
		if(Request::get('page')){
			$page 			= Request::get('page'); 
		}

		$paginator 		= new LengthAwarePaginator($count, $count, $take, $page);
	    return $paginator->setPath(Request::url());
	}	
?>