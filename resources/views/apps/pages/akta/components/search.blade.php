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

	if (!isset($qs)) 
	{
		$qs = [];
	}

	$data_qs = Request::all();
?>

<h5>{{ isset($title) ? $title : 'Cari Data' }}</h5>


{!! Form::open(['url' => $action_url, 'class' => 'form-inline search-akta', 'method' => 'get']) !!}
	<div class="input-group">
		{!! Form::text('cari', null, ['class' => 'form-control search pr-5', 'placeholder' => isset($placehlder) ? $placehlder : 'Cari']) !!}

		@foreach ($data_qs as $key => $value )
			@if(in_array($key, $qs))
				{!! Form::hidden($key, $value) !!}
			@endif
		@endforeach
		<span class="input-group-btn">
			<button class="btn" type="submit">
				<i class="fa fa-search" aria-hidden="true"></i>
			</button>
		</span>
	</div>
{!! Form::close() !!}