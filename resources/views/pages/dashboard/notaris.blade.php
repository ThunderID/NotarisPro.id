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

	@include('helpers.dashboard_menu', ['active' => 'Market'])	

	<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel pt-4">
		<!-- Here is stat Area -->
		<div class="row">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-block">
						<div class="card-title">
							Klien Baru
						</div>
						<div class="row">
							<div class="col-sm-6 text-left">
								<h4>{{$page_datas->stat_new_today}}</h4>
								<p><small><small>Hari Ini</small></small></p>
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->stat_peak_amount}}</h4>
								<p><small><small>Peaked at {{$page_datas->stat_peaked_at}}</small></small></p>
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
							<div class="col-sm-12 text-center">
								<h4>{{$page_datas->stat_total_client}}</h4>
								<p><small><small>Total Klien</small></small></p>
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
								<h4>{{$page_datas->stat_new}}%</h4>
								<p><small><small>New</small></small></p>
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->stat_returning}}%</h4>
								<p><small><small>Returning</small></small></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End of stat Area -->

		<div class="clearfix">&nbsp;</div>

		<!-- Here is retention Area -->
		<div class="row">
			<div class="col-12 col-md-12 pb-4">
				<div class="card">
					<div class="card-block">

						<h5 class="card-title pb-2">Akta Net Retention (Total)</h5>

						<div class="progress">
							<div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: {{$page_datas->net_retent_ongoing_percentage}}%" aria-valuenow="$page_datas->net_retent_ongoing_percentage " aria-valuemin="0" aria-valuemax="100">{{$page_datas->net_retent_ongoing_percentage}} % Ongoing</div>
							<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$page_datas->net_retent_completed_percentage}}%" aria-valuenow="$page_datas->net_retent_completed_percentage " aria-valuemin="0" aria-valuemax="100">{{$page_datas->net_retent_completed_percentage}} % Complete</div>
							<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: {{$page_datas->net_retent_canceled_percentage}}%" aria-valuenow="$page_datas->net_retent_canceled_percentage " aria-valuemin="0" aria-valuemax="100">{{$page_datas->net_retent_canceled_percentage}} % Cancel</div>
						</div>

						<span class="badge badge-info">Ongoing</span>
						<span class="badge badge-success">Complete</span>
						<span class="badge badge-danger">Cancel</span>
					</div>
				</div>
			</div>
		</div>
		<!-- Here end of retention -->

		<div class="row">
			<div class="col-12 col-md-12 pb-4">
				<div class="card">
					<div class="card-block">

						<h5 class="card-title pb-2">Sebaran Akta Dibuat Berdasarkan Jenis Akta (3 Bulan Terakhir)</h5>

						<table class="table table-hover">
							<thead>
								<tr>
									<th>Judul</th>
									@foreach($page_datas->sebaran_bulan as $key => $value)
										<th>{{$value->format('M`y')}}</th>
									@endforeach
									<th>{{Carbon\Carbon::now()->format('M`y')}}</th>
								</tr>
							</thead>
							<tbody>
				            	@foreach($page_datas->sebaran_peminat as $value)
				            		<tr>
				            			<td>{{$value['judul']}}</td>
				            			@php
				            				$prev 	= 0;
				            			@endphp

					            		@foreach($value['compare'] as $key2 => $value2)
											<td>
					            				{{$value2['total']['published']}}
					            				@php
					            					$selisih 	= $value2['total']['published'] - $prev;
					            					$persentasi = round(($selisih / max($prev, 1)) * 100);
						            				$prev 		= $value2['total']['published'];
					            				@endphp

					            				@if($selisih >= 0 && $key2 > 0)
					            					<p class="text-success"><i class="fa fa-arrow-up"></i>{{abs($persentasi)}}%</p>
					            				@elseif($key2 > 0)
					            					<p class="text-danger"><i class="fa fa-arrow-down"></i>{{abs($persentasi)}}%</p>
					            				@endif
											</td>
										@endforeach	
				            			
				            			<td>
				            				{{$value['pivot']['total']['published']}}
				            				@php
				            					$selisih 	= $value['pivot']['total']['published'] - $prev;
				            					$persentasi = round(($selisih / max($prev, 1)) * 100);
					            				$prev 		= $value['pivot']['total']['published'];
				            				@endphp

				            				@if($selisih >= 0)
				            					<p class="text-success"><i class="fa fa-arrow-up"></i>{{abs($persentasi)}}%</p>
				            				@else
				            					<p class="text-danger"><i class="fa fa-arrow-down"></i>{{abs($persentasi)}}%</p>
				            				@endif
				            			</td>
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
