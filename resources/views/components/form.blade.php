<?php
	/*
	===================================================================
	Readme
	===================================================================
	Component Name 	:  Form Component
	Author  		:  Budi - budi-purnomo@outlook.com
	Description 	:  Form definition wrapper 
	Requirement 	:  This component only works on laravel 5.4 
	===================================================================
	Usage
	===================================================================
	to use this component, simply include this component using 
	component laravel blade direvtive, and passing your parameters and 
	your form code and the $slot section (see laravel documentation).
	===================================================================
	Parameters
	===================================================================
	Pass this parameter inside an array. Some parameters are required 
	and some not. Make sure that you always pass required one.

	List of parameter:
	1. 	store_url
		required 	: yes
		value 		: string url form post 
		description : this form will be send post request to this url

	2. 	update_url
		required 	: no
		value 		: string url form post 
		description : this form will be send patch request to this url

	3. 	data_id
		required 	: yes
		value 		: integer of edited data
		description : id of edited data, if no data set null
	===================================================================
	*/
?>


@if($data_id != null)
	<form action="{{ route($update_url, ['id' => $id]) }}" method="post">
		{{ method_field('PATCH') }}
@else
	<form action="{{ route($store_url) }}" method="post">
@endif

	<input type="hidden" name="_token" value="{{ csrf_token() }}">		

	{{ $slot }}

</form>