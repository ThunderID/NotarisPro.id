@extends('templates.basic')

@push('fonts')
@endpush

@push('styles')  
@endpush  

@section('content')
	<div class="row">
		@include('helpers.dashboard_menu', ['active' => 'Worksheet'])	
		<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel pt-4">
			<!-- Here is stat Area -->
			<div class="row">
				<div class="col-sm-4">
					<div class="card">
						<div class="card-block">
							<div class="card-title">
								Template
							</div>
							<div class="row">
								<div class="col-sm-12 text-right">
									<h4>{{$page_datas->stat_template}}</h4>
									<p><small><small>Pekerjaan Belum Terselesaikan</small></small></p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-4">
					<div class="card">
						<div class="card-block">
							<div class="card-title">
								Akta
							</div>
							<div class="row">
								<div class="col-sm-12 text-right">
									<h4>{{$page_datas->stat_akta}}</h4>
									<p><small><small>Pekerjaan Belum Terselesaikan</small></small></p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-4">
					<div class="card">
						<div class="card-block">
							<div class="card-title">
								Tagihan
							</div>
							<div class="row">
								<div class="col-sm-12 text-right">
									<h4>{{$page_datas->stat_billing}}</h4>
									<p><small><small>Pekerjaan Belum Terselesaikan</small></small></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End of stat Area -->

			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-block">
							<h5 class="card-title pb-2">Akta Yang Perlu Di Cek</h5>
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Judul</th>
										<th>Tanggal</th>
									</tr>
								</thead>
								<tbody>
									@foreach($page_datas->akta_to_check as $key => $value)
										<tr>
											<a href="{{route('akta.akta.show', $value['id'])}}" style="text-decoration: none;">
												<td>{{$value['judul']}}</td>
												<td> 
												@if(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_pembuatan'])->diffInDays(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_sunting'])) > 0)
													<span class="badge badge-info">
												@elseif(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_pembuatan'])->diffInDays(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_sunting'])) == 0)
													<span class="badge badge-warning">
												@else
													<span class="badge badge-danger">
												@endif
													<small>{{$value['tanggal_sunting']}}</small>
												</span>
												</td>
											</a>
										</tr>
									@endforeach
									@if($page_datas->stat_akta > 10)
										<tr>
											<td colspan="2" class="text-right"><a href="{{route('akta.akta.index', ['status' => 'draft'])}}">Lihat Lainnya</a></td>
										</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-block">
							<h5 class="card-title pb-2">Template Yang Harus Diubah</h5>
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Judul</th>
										<th>Total Perubahan</th>
										<th>Drafter</th>
									</tr>
								</thead>
								<tbody>
									@foreach($page_datas->template_to_check as $key => $data)
										<tr>
											<a href="{{route('akta.template.show', $data['id'])}}" style="text-decoration: none;">
												<td>{{$data['judul']}}</td>
												<td> 
													<ol style="padding-left: 5px;margin-bottom: 0px;">
														<li> {{ $value['penambahan_paragraf'] }} <small>penambahan</small></li>
														<li> {{ $value['pengurangan_paragraf'] }} <small>pengurangan</small></li>
														<li> {{ $value['perubahan_paragraf'] }} <small>perubahan</small></li>
													</ol>
												</td>
												<td> 
													{{$data['penulis']['nama']}} <small>({{$data['tanggal_sunting']}})</small>
												</td>
											</a>
										</tr>
									@endforeach
									@if($page_datas->stat_template > 10)
										<tr>
											<td colspan="2" class="text-right"><a href="{{route('akta.template.index')}}">Lihat Lainnya</a></td>
										</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-block">
							<h5 class="card-title pb-2">Tagihan Yang Belum Lunas</h5>
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Nama Klien</th>
										<th>Tanggal Jatuh Tempo</th>
									</tr>
								</thead>
								<tbody>
									@foreach($page_datas->billing_to_check as $key => $data)
										<tr>
											<a href="{{route('pos.billing.show', $data['id'])}}" style="text-decoration: none;">
												<td>{{$data['klien_nama']}}</td>
												<td> 
													{{$data['tanggal_jatuh_tempo']}}
												</td>
											</a>
										</tr>
									@endforeach
									@if($page_datas->stat_billing > 10)
										<tr>
											<td colspan="2" class="text-right"><a href="{{route('pos.billing.index')}}">Lihat Lainnya</a></td>
										</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
	
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
		</div>
	</div>

@stop

@push('scripts')  
@endpush 
