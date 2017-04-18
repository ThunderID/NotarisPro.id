<h5>{{ isset($title) ? $title : '' }}</h5>

<div class="filter">
	<ul>
		@foreach($lists as $key => $list)
		<a 
			href="{{ is_null($list['url']) ? 'javascript:void(0);' : $list['url'] }}" 
			class="{{ isset($list['class']) ? $list['class'] : '' }}"
			@if(isset($list['attr']))
				@foreach($list['attr'] as $attr => $value)
					{{$attr}} = {{$value}}
				@endforeach
			@endif
		>
			<li>
				{{ ucWords($key) }}
				<span class="indicator float-right">
					<i class="fa {{ $list['icon']}}"></i>
				</span>
			</li>
		</a>	
		@endforeach			
	</ul>
</div>