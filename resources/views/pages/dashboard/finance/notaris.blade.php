@extends('templates.basic')

@push('fonts')
@endpush

@push('styles')  
@endpush  

@section('content')

<div class="row">

	@include('helpers.dashboard_menu', ['active' => 'Keuangan'])	

	<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel pt-4" style="background-color: rgba(0, 0, 0, 0);align-items: center;display: flex;justify-content: center;height: 90vh;position: relative;">
			<div style="font-size: 84px;text-align: center;">
				UNDER<br/>CONSTRUCTION
			</div>
		</div>
	</div>
@stop

@push('scripts')  
@endpush 
