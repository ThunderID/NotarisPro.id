@extends('templates.basic')

@push('fonts')
@endpush

@push('styles')  
@endpush  

{{-- Fuze --}}
<?php
	$stat_akta_bulan_ini 	= isset($page_datas->stat_akta_bulan_ini) ? $page_datas->stat_akta_bulan_ini : 0;
	$stat_total_drafter 	= isset($page_datas->stat_total_drafter) ? $page_datas->stat_total_drafter : 0;
	$stat_total_klien_baru 	= isset($page_datas->stat_total_klien_baru) ? $page_datas->stat_total_klien_baru : 0;
	$stat_tagihan 			= isset($page_datas->stat_tagihan) ? $page_datas->stat_tagihan : 0;
?>
{{-- End of Fuze --}}

@section('content')

<div class="row">

	@include('helpers.dashboard_menu', ['active' => 'Klien'])	

	<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel pt-4">
		<div class="row">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-block">
						<div class="card-title">
							Klien Baru
						</div>
						<div class="row">
							<div class="col-sm-6 text-left">
								<h4>{{$page_datas->ongoing_klien}}</h4>
								<p><small><small>Hari Ini</small></small></p>
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->peak_klien}}</h4>
								<p><small><small>Peaked at {{$page_datas->peaked_at}}</small></small></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card">
					<div class="card-block">
						<div class="card-title">
							Overview Klien
						</div>
						<div class="row">
							<div class="col-sm-5 text-left">
								<h4>{{$page_datas->total_client}}</h4>
								<p><small><small>Total Klien</small></small></p>
							</div>
							<div class="col-sm-2 text-center">
							<h3><i class="fa fa-users"></i></h3>
							</div>
							<div class="col-sm-5 text-right">
								<h4>{{$page_datas->new_client}} % </h4>
								<p><small><small>Baru</small></small></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card">
					<div class="card-block">
						<div class="card-title">
							New vs Returning
						</div>
						<div class="row">
							<div class="col-sm-6 text-left">
								<h4>{{$page_datas->new_client}}%</h4>
								<p><small><small>New</small></small></p>
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->returning_client}}%</h4>
								<p><small><small>Returning</small></small></p>
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

						<h5 class="card-title pb-2">Sebaran Jenis Akta Berdasarkan Peminat</h5>

						<table class="table table-hover">
							<thead>
								<tr>
									<th>Judul</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
				            	@foreach($page_datas->lists_template as $value)
				            		<tr>
				            			<td>{{$value['judul']}}</td>
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

						<h5 class="card-title pb-2">Sebaran Jenis Akta Berdasarkan Waktu Pengerjaan</h5>

						<table class="table table-hover">
							<thead>
								<tr>
									<th>Dokumen</th>
									<th>Lama Pengerjaan (Hari)</th>
								</tr>
							</thead>
							<tbody>
				                @foreach($page_datas->lists_template as $value)
				            		<tr>
				            			<td>{{$value['judul']}}</td>
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
