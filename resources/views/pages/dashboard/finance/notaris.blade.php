@extends('templates.basic')

@push('fonts')
@endpush

@push('styles')  
@endpush  

@section('content')

<div class="row">

	@include('helpers.dashboard_menu', ['active' => 'Keuangan'])	

	<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel pt-4">
		<div class="row">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-block">
						<div class="card-title">
							Drafter {{Carbon\Carbon::now()->format('Y')}}
						</div>
						<div class="row">
							<div class="col-sm-6 text-left">
								<h4>{{$page_datas->female_drafter}}</h4>
								<p><small><small>Female Drafter</small></small></p>
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->male_drafter}}</h4>
								<p><small><small>Male Drafter</small></small></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card">
					<div class="card-block">
						<div class="card-title">
							Turnover Drafter Bulan Ini
						</div>
						<div class="row">
							<div class="col-sm-6 text-left">
								<h4>{{$page_datas->female_drafter_turnover}}</h4>
								<p><small><small>Female Drafter</small></small></p>
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->male_drafter_turnover}}</h4>
								<p><small><small>Male Drafter</small></small></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card">
					<div class="card-block">
						<div class="card-title">
							Rata - Rata Waktu Pengerjaan Akta
						</div>
						<div class="row">
							<div class="col-sm-6 text-left">
								<h4>{{$page_datas->female_drafter_turnover}}</h4>
								<p><small><small>Female Drafter</small></small></p>
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->male_drafter_turnover}}</h4>
								<p><small><small>Male Drafter</small></small></p>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="clearfix">&nbsp;</div>

		<div class="row">
			<div class="col-12 col-md-6 pb-4">
				<div class="card">
					<div class="card-block">

						<h5 class="card-title pb-2">Akta Bulan Yang diSelesaikan Bulan Ini</h5>

						<table class="table table-hover">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
				            	
							</tbody>
						</table>

					</div>
				</div>
			</div>

			<div class="col-12 col-md-6 pb-4">
				<div class="card">
					<div class="card-block">

						<h5 class="card-title pb-2">Rerata Waktu Pengerjaan Akta</h5>

						<table class="table table-hover">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
				            	
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>	
	</div>	
</div>

@stop

@push('scripts')  
@endpush 
