<?php
	// dd(Request::input());
?>
<div class="col-md-12" style="text-align:right;">
	@if(isset($page_attributes->paging))
		{!! $page_attributes->paging->appends(Request::all())->render() !!}
	@else
		{!! $page_datas->datas->appends(Request::all())->render() !!}
	@endif
</div>