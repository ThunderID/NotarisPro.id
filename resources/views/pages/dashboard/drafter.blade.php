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
				<div class="col-sm-4">
					<div class="card card-inverse card-success mb-3 text-center">
						<div class="card-block">
							<blockquote class="card-blockquote">
								<h1>{{$page_datas->stat_dalam_proses_akta}}</h1>
								<footer>Queue dalam_proses Akta</footer>
							</blockquote>
						</div>
					</div>
				</div>

				<div class="col-sm-4">
					<div class="card card-inverse card-danger mb-3 text-center">
						<div class="card-block">
							<blockquote class="card-blockquote">
								<h1>{{$page_datas->stat_renvoi_akta}}</h1>
								<footer>Queue Renvoi</footer>
							</blockquote>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="card card-inverse card-warning mb-3 text-center">
						<div class="card-block">
							<blockquote class="card-blockquote">
								<h1>{{$page_datas->stat_template}}</h1>
								<footer>Queue dalam_proses Template</footer>
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
							<h4 class="card-title">dalam_proses Akta Untuk di Selesaikan</h4>
							<ul class="list-group list-group-flush">
								@foreach($page_datas->dalam_proses_to_check as $key => $value)
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
				<div class="col-sm-6">
					<div class="card">
						<div class="card-block">
							<h4 class="card-title">Renvoi Akta Untuk di Selesaikan</h4>
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

			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
		</div>
	</div>
@stop

@push('scripts')  
@endpush 
