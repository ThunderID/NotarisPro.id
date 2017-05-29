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
				<div class="col-sm-6">
					<div class="card">
						<div class="card-block">
							<h4 class="card-title">Akta Yang Perlu Di Cek</h4>
							<ul class="list-group list-group-flush">
								@foreach($page_datas->draft_to_check as $key => $value)
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
