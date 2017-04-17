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

<div class="sort">
	<div class="btn-group menu-dropdown" role="group" aria-label="Button group with nested dropdown">
		<div class="caption">
			<h5>{{ isset($title) ? $title : 'Urutan' }}</h5>
		</div>
		<div class="btn-group menu-dropdown" role="group">
			<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				{{ ucWords(array_search(Request::get($alias), $lists)) }}
			</button>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
			@foreach($lists as $key => $list)
				<a class="dropdown-item {{ Request::get($alias) == $list ? 'active' : '' }}" href="
					{{ route(Route::currentRouteName(), $data_qs) }}
					{{ count(Request::all()) && $list != null> 0 ? '&' : '' }}
					{{ $list != null ? $alias . '=' . $list : '' }}">
					{{ ucWords($key) }}
				</a>
			@endforeach
			</div>
		</div>
	</div>
</div>