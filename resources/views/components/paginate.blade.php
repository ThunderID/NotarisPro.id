<div class="col-md-12">
	@if(isset($page_attributes->paging))
		{!! $page_attributes->paging->appends(Request::all())->render() !!}
	@else
		{!! $page_datas->datas->appends(Request::all())->render() !!}
	@endif
</div>