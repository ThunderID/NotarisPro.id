@push ('main')
	<div class="row">
		<div class="col-12 col-sm-12 col-md-3 sidebar">
			@stack ('page_sidebar')
		</div>
		<div class="col-12 col-sm-12 col-md-9">
			@stack ('page_content')
		</div>
	</div>

@endpush