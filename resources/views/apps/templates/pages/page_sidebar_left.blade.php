@push ('main')
	<div class="row">
		<div class="col-3">
			@stack ('page_sidebar')
		</div>
		<div class="col">
			@stack ('page_content')
		</div>
	</div>

@endpush