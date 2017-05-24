@extends('templates.basic')

@push('fonts')
@endpush

@push('styles')  
@endpush  

@section('content')

<div class="row">

	@include('helpers.dashboard_menu', ['active' => 'KPI'])	

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
								<h4>{{$page_datas->active_drafter}}</h4>
								<p><small><small>Aktif Drafter</small></small></p>
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->longest_streak}}</h4>
								<p><small><small>Longest Streak at {{$page_datas->longest_at}}</small></small></p>
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
								<h4>{{$page_datas->baru_turnover}}</h4>
								<p><small><small>Baru</small></small></p>
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->keluar_turnover}}</h4>
								<p><small><small>Keluar</small></small></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card">
					<div class="card-block">
						<div class="card-title">
							Rerata Waktu Pengerjaan Akta
						</div>
						<div class="row">
							<div class="col-sm-12 text-center">
								<h4>{{$page_datas->baru_turnover}}</h4>
								<p><small><small>Jam/Akta</small></small></p>
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

						<h5 class="card-title pb-2">Akta Yang di selesaikan Bulan Ini</h5>

						<table class="table table-hover">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
				            	@foreach($page_datas->lists_karyawan as $value)
				            		<tr>
				            			<td>{{$value['nama']}}</td>
				            			<td>
				            				<div class="progress">
												<div class="progress-bar bg-error" role="progressbar" style="width: {{$value['total']['trashed']/max($value['total']['all'], 1) * 100}}%" aria-valuenow=" {{$value['total']['trashed']/max($value['total']['all'], 1) * 100}}" aria-valuemin="0" aria-valuemax="100"></div>
												<div class="progress-bar bg-success" role="progressbar" style="width: {{$value['total']['published']/max($value['total']['all'], 1) * 100}}%" aria-valuenow="{{$value['total']['published']/max($value['total']['all'], 1) * 100}}" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
				            			</td>
				            		</tr>
				            	@endforeach
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
									<th>Lama Pengerjaan (Hari)</th>
								</tr>
							</thead>
							<tbody>
				            	@foreach($page_datas->lists_karyawan as $value)
				            		<tr>
				            			<td>{{$value['nama']}}</td>
				            			<td class="text-right">{{$value['pengerjaan']['total']}}</td>
				            		</tr>
				            	@endforeach
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
