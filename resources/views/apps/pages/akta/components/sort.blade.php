<?php


	if(!isset($alias)){
		$alias = 'sort';
	}
	if(isset($qs)){
		$data_qs = Request::only($qs);
	}else{
		$data_qs = null;
	}	
?>


<h5 class="d-inline mb-0 pr-2">{{ isset($title) ? $title : 'Urutan' }}</h5>
<div class="dropdown d-inline">
	<button id="dropdownMenuSort" class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		{{ ucwords(array_search(request()->get($alias), $lists)) }}
	</button>
	<div class="dropdown-menu" aria-labelledby="dropdownMenuSort">
		@isset ($lists)
			@foreach ($lists as $k => $v)
				@php 
					$route = route('akta.akta.index', $data_qs);
					$count = (count(request()->all()) && ($v != null) > 0) ? '&' : '';
					$list = ($v != null) ? $alias . '=' . $v : '';
				@endphp
				<a href="{{ $route . $count . $list }}" class="dropdown-item {{ (request()->get($alias) == $v) ? 'active' : ''  }}">{{ ucwords($k) }}</a>
			@endforeach
		@endisset
	</div>
</div>