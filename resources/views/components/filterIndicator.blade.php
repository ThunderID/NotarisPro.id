<?php
	/*
	===================================================================
	Readme
	===================================================================
	Component Name 	:  Filter Indicator
	Author  		:  Budi - budi-purnomo@outlook.com
	Description 	:  Detect activated filter using query string 
	Requirement 	:  This component only works on laravel 5.4 
	===================================================================
	Usage
	===================================================================
	to use this component, simply include this component.
	===================================================================
	Parameters
	===================================================================
	Pass this parameter inside an array. Some parameters are required 
	and some not. Make sure that you always pass required one.

	List of parameter:
	1. 	lists
		required 	: yes (or will be fall back to less secure filter)
		value 		: array of allowed list as key, and the value as
					  display name
		description : lists of watched key in query string
	===================================================================
	*/


	// strict mode?
	if(!isset($lists)){
		$strict_mode = false;
	}else{
		$strict_mode = true;
	}

	// get all activated filters
	$qs = Request::all();

	// generate URL
	function generateUrl($key){
		// get current url
		$qs = Request::fullUrl();

		// stripe off qs and remove this key 
		$url	 	= parse_url($qs);
		parse_str($url['query'], $arr_qs);
		unset($arr_qs[$key]);

		//rebuild qs and return 
		return  $url['scheme'] . "://" . $url['host'] . $url['path'] . "?" . http_build_query($arr_qs, '', '&amp;');
	}
?>

<div style="margin-top: -1.3rem;">
	@foreach ($qs as $key => $value)
		@if($strict_mode == true)
			@if(array_key_exists($key, $lists))
				<span class="badge badge-notif">{{$lists[$key]}} : {{$value}} <a href="{{ generateUrl($key) }}">x</a></span>
			@endif
		@else
			<span class="badge badge-notif">{{$key}} : {{$value}} <a href="{{ generateUrl($key) }}">x</a></span>
		@endif
	@endforeach
</div>