<?php
	/*
	===================================================================
	Readme
	===================================================================
	Component Name 	:  Search Component
	Author  		:  Budi - budi-purnomo@outlook.com
	Description 	:  Form search component 
	Requirement 	:  This component only works on laravel 5.4 
	===================================================================
	Usage
	===================================================================
	to use this component, simply include this, and passing your search
	parameters.
	===================================================================
	Parameters
	===================================================================
	Pass this parameter inside an array. Some parameters are required 
	and some not. Make sure that you always pass required one.

	List of parameter:
	1. 	title
		required 	: No
		value 		: string
		description : this form will be search section title

	2. 	action_url
		required 	: yes
		value 		: string url action
		description : this form will be send get search to this url

	3. 	placeholder
		required 	: no
		value 		: string of placeholder
		description : this will be the search placeholder

	4. 	qs
		required 	: no
		value 		: array of qs
		description : this will be the search placeholder		
	===================================================================
	*/

	if(!isset($qs)){
		$qs = [];
	}

	$data_qs = Request::all();
?>

<h5>{{ isset($title) ? $title : 'Cari Data' }}</h5>

<div class="search">
	<form class="form" action="{{ $action_url }}" method="Get">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="{{ isset($placehlder) ? $placeholder : 'Cari' }}" aria-describedby="basic-addon1" name="q">
			@foreach($data_qs as $key => $value )
				@if(in_array($key, $qs))
					<input type="hidden" name="{{$key}}" value="{{$value}}">
				@endif
			@endforeach
			<span class="input-group-btn">
		        <button class="btn btn-secondary" type="submit">
					<i class="fa fa-search" aria-hidden="true"></i>
		        </button>
			</span>
		</div>
	</form>
</div>