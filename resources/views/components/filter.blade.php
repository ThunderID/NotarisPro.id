<?php
	if(!isset($alias)){
		$alias = 'filter';
	}
	if(isset($qs)){
		$data_qs = Request::only($qs);
	}else{
		$data_qs = null;
	}	
?>


<h5>{{ isset($title) ? $title : 'Filter Data' }}</h5>

<div class="filter">
	<ul>
		@foreach($lists as $key => $list)
		<a href="
			{{ route(Route::currentRouteName(), $data_qs) }}
			{{ count(Request::all()) && $list != null> 0 ? '&' : '' }}
			{{ $list != null ? $alias . '=' . $list : '' }}">
			<li class="{{ Request::get($alias) == $list ? 'active' : '' }}">
				{{ ucWords($key) }}
				<span class="indicator float-right">
					@if(Request::get($alias) == $list)
						<i class="fa fa-circle"></i>
					@else
						<i class="fa fa-circle-o"></i>
					@endif
				</span>
			</li>
		</a>	
		@endforeach			
	</ul>
</div>