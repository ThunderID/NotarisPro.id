@extends('templates.basic')

@push('fonts')
@endpush

@push('styles')  
@endpush  

@section('content')

<div class="row">

	@include('helpers.dashboard_menu', ['active' => 'HR'])	

	<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel pt-4">
		<!-- Area turnover -->
		<div class="row">
			<div class="col-sm-5">
				<div class="card">
					<div class="card-block">
						<div class="row" style="padding-top:15px;padding-bottom:10px;">
							<div class="col-sm-6 text-left">
								<h4>{{$page_datas->stat_total_akta}}</h4>
								<p><small><small>Total Akta</small></small></p>
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->stat_longest_streak}}</h4>
								<p><small><small>Longest Streak (at {{$page_datas->stat_longest_at}})</small></small></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-7">
				<div class="card">
					<div class="card-block">
						<div class="row">
							<div class="col-sm-4 text-left">
								Aktif Drafter
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->stat_active_drafter}}
									@php 
										$selisih = $page_datas->stat_active_drafter - $page_datas->stat_active_drafter_lm;
										$percent = round(($selisih / max($page_datas->stat_active_drafter_lm, 1)) * 100);
									@endphp
								</h4>
							</div>
							<div class="col-sm-2 text-left">
								@if($selisih >= 0)
									<span class="text-success"><small><small><i class="fa fa-arrow-up"></i>{{abs($percent)}}%</small></small></span>
								@else
									<span class="text-danger"><small><small><i class="fa fa-arrow-down"></i>{{abs($percent)}}%</small></small></span>
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 text-left">
								Drafter Baru
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->stat_drafter_baru}}
									@php 
										$selisih = $page_datas->stat_drafter_baru - $page_datas->stat_drafter_baru_lm;
										$percent = round(($selisih / max($page_datas->stat_drafter_baru_lm, 1)) * 100);
									@endphp
								</h4>
							</div>
							<div class="col-sm-2 text-left">
								@if($selisih >= 0)
									<span class="text-success"><small><small><i class="fa fa-arrow-up"></i>{{abs($percent)}}%</small></small></span>
								@else
									<span class="text-danger"><small><small><i class="fa fa-arrow-down"></i>{{abs($percent)}}%</small></small></span>
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 text-left">
								Drafter Keluar
							</div>
							<div class="col-sm-6 text-right">
								<h4>{{$page_datas->stat_drafter_keluar}}
									@php 
										$selisih = $page_datas->stat_drafter_keluar - $page_datas->stat_drafter_keluar_lm;
										$percent = round(($selisih / max($page_datas->stat_drafter_keluar_lm, 1)) * 100);
									@endphp
								</h4>
							</div>
							<div class="col-sm-2 text-left">
								@if($selisih >= 0)
									<span class="text-success"><small><small><i class="fa fa-arrow-up"></i>{{abs($percent)}}%</small></small></span>
								@else
									<span class="text-danger"><small><small><i class="fa fa-arrow-down"></i>{{abs($percent)}}%</small></small></span>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End of Area turnover -->

		<div class="clearfix">&nbsp;</div>
		

		<!-- Area Performance -->
		<div class="row">
			<div class="col-12 col-md-12 pb-4">
				<div class="card">
					<div class="card-block">

						<h5 class="card-title pb-2">Performance Drafter Bulan Ini</h5>

						<table class="table table-hover">
							<thead>
								<tr>
									<th>Nama
										<br/><span><small>Drafter</small></span>
									</th>
									<th>Kehadiran Bulan Ini
										<br/><span><small>(hari)</small></span>
									</th>
									<th>Akta yang Dibuat
										<br/><span><small>(final)</small></span>
									</th>
									<th>Effective Rate Hour 
										<br/><span><small>Akta Yang Diketik Selama Jam Kerja Aktif</small></span>
									</th>
								</tr>
							</thead>
							<tbody>
				            	@foreach($page_datas->performance_drafter as $value)
				            		<tr>
				            			<td>
				            				<p>
					            				{{$value['nama']}}
				            				</p>
				            			</td>
				            			<td>
					            			<p>
					            				{{$value['hari_hadir']}}
						            			@php 
													$selisih = $value['hari_hadir'] - $value['hari_hadir_lm'];
													$percent = round(($selisih / max($value['hari_hadir_lm'], 1)) * 100);
												@endphp
												@if($selisih >= 0)
													<span class="text-success"><small><small><i class="fa fa-arrow-up"></i>{{abs($percent)}}%</small></small></span>
												@else
													<span class="text-danger"><small><small><i class="fa fa-arrow-down"></i>{{abs($percent)}}%</small></small></span>
												@endif
											</p>
				            			</td>
				            			<td>
				            				<p>
				            					{{$value['akta_published']}}
												@php 
													$selisih = $value['akta_published'] - $value['akta_published_lm'];
													$percent = round(($selisih / max($value['akta_published_lm'], 1)) * 100);
												@endphp
												@if($selisih >= 0)
													<span class="text-success"><small><small><i class="fa fa-arrow-up"></i>{{abs($percent)}}%</small></small></span>
												@else
													<span class="text-danger"><small><small><i class="fa fa-arrow-down"></i>{{abs($percent)}}%</small></small></span>
												@endif
				            				</p>
				            			</td>
				            			<td>
				            				<p>
				            					{{$value['effective_rate']}}%
												@php 
													$selisih = $value['effective_rate'] - $value['effective_rate_lm'];
													$percent = round(($selisih / max($value['effective_rate_lm'], 1)) * 100);
												@endphp
												@if($selisih >= 0)
													<span class="text-success"><small><small><i class="fa fa-arrow-up"></i>{{abs($percent)}}%</small></small></span>
												@else
													<span class="text-danger"><small><small><i class="fa fa-arrow-down"></i>{{abs($percent)}}%</small></small></span>
												@endif
				            					<br/>
				            					@php
				            						list($h, $i)	= explode(':', gmdate('H:i', $value['performance']))
				            					@endphp
				            					{{$h}} jam, {{$i}} menit / akta
				            				</p>
				            			</td>
				            		</tr>
				            	@endforeach
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>	
		<!-- End Area Performance -->

	</div>	
</div>

@stop

@push('scripts')  
@endpush 
