@extends('templates.basic')

@push('fonts')
@endpush

@push('styles')  
@endpush  

@section('content')
	<div class="row">
		<div class="col-sm-12 col-sm-12 col-md-12 col-lg-12">
			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-sm-3">
					<div class="card card-inverse card-success mb-3 text-center">
						<div class="card-block">
							<blockquote class="card-blockquote">
								<h1>{{$page_datas->stat_akta_bulan_ini}}</h1>
								<footer>Total Akta Bulan Ini</footer>
							</blockquote>
						</div>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="card card-inverse card-info mb-3 text-center">
						<div class="card-block">
							<blockquote class="card-blockquote">
								<h1>{{$page_datas->stat_total_drafter}}</h1>
								<footer>Total drafter</footer>
							</blockquote>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="card card-inverse card-warning mb-3 text-center">
						<div class="card-block">
							<blockquote class="card-blockquote">
								<h1>{{$page_datas->stat_total_klien_baru}}</h1>
								<footer>Total Klien Baru</footer>
							</blockquote>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="card card-inverse card-danger text-center">
						<div class="card-block">
							<blockquote class="card-blockquote">
								<h1>{{$page_datas->stat_tagihan}}</h1>
								<footer>Tagihan</footer>
							</blockquote>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="card">
						<div class="card-block">
							<h4 class="card-title">Akta Menunggu Untuk di Cek</h4>
							<ul class="list-group list-group-flush">
								@foreach($page_datas->lists_to_check as $key => $value)
									<li class="list-group-item">
										<a href="{{route('akta.akta.show', $value['id'])}}" style="text-decoration: none;">
											{{$value['judul']}} 
											@if(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_pembuatan'])->diffInDays(Carbon\Carbon::now()) > 0)
												<span class="badge badge-info">
											@elseif(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_pembuatan'])->diffInDays(Carbon\Carbon::now()) == 0)
												<span class="badge badge-warning">
											@else
												<span class="badge badge-danger">
											@endif
												<small>{{$value['tanggal_pembuatan']}}</small>
											</span>
										</a>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>


				<div class="col-sm-6">
					<div class="card">
						<div class="card-block">
							<h4 class="card-title">Akta Published Terbaru</h4>
							<ul class="list-group list-group-flush">
								@foreach($page_datas->lists_akta as $key => $value)
									<li class="list-group-item">
										<a href="{{route('akta.akta.show', $value['id'])}}" style="text-decoration: none;">
											{{$value['judul']}} 
											@if(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_pembuatan'])->diffInDays(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_sunting'])) > 0)
												<span class="badge badge-info">
											@elseif(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_pembuatan'])->diffInDays(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_sunting'])) == 0)
												<span class="badge badge-warning">
											@else
												<span class="badge badge-danger">
											@endif
												<small>{{$value['tanggal_sunting']}}</small>
											</span>
										</a>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
		</div>
	</div>
@stop

@push('scripts')  
@endpush 
