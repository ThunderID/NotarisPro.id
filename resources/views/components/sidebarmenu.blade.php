<h5>{{ isset($title) ? $title : '' }}</h5>

<div class="filter">
	<ul>
		@foreach($lists as $key => $list)
		<a href="{{ $list['url'] }}">
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