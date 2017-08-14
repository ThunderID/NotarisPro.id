@extends('templates.basic')

@push('styles')  
@endpush  

@section('content')
	<div class="row">

		@include('helpers.company_sidebar', ['active' => 'Tagihan'])

		<div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel">
			<div class="row">
				<div class="col-12">
					<h4 class="title">{{$page_attributes->title}}</h4>		
				</div>
			</div>	
			<hr>
			<div class="row">
				<div class="col-12">
					@include('components.alertbox')
				</div>
			</div>

			<div class="row">
				<div class="col-3">
					<p>Plan</p>
				</div>
				<div class="col-6">
					<p>0 User(s)</p>
				</div>
				<div class="col-3 text-right">
					<a class="btn btn-sm btn-primary" href="{{route('pengaturan.user.create')}}">
						<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
						Tambah User
					</a>
				</div>
			</div>
			<hr>

			<div class="row">
				<div class="col-3">
					<p>Tagihan Harus Dibayarkan</p>
				</div>
				<div class="col-6">
					<p>Rp 0</p>
				</div>
				<div class="col-3 text-right">
					<a class="btn btn-sm btn-primary" href="{{route('pengaturan.user.create')}}">
						<i class="fa fa-money" aria-hidden="true"></i>&nbsp;
						Bayar
					</a>
				</div>
			</div>
			<hr>

			<div class="row">
				<div class="col-12">

					<div id="accordion" role="tablist" aria-multiselectable="true">
						@foreach($page_datas->tagihans as $key => $value)
							<div class="card">
								<div class="card-header" role="tab" id="heading{{$key}}">
									<h5 class="mb-0">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
											#{{$value['nomor']}} / 
											@if(str_is($value['status'], 'pending'))
												<span class="badge badge-success">{{$value['status']}}</span>
											@else
												<span class="badge badge-success">{{$value['status']}}</span>
											@endif
										</a>
									</h5>
								</div>

								<div id="collapse{{$key}}" class="collapse " role="tabpanel" aria-labelledby="heading{{$key}}">
									<div class="card-block">
										<div class="row">
											<div class="col-12 text-right">
												<a href="{{route('pengaturan.tagihan.print', ['id' => $value['id']])}}" class="btn btn-secondary" target="__blank"> <i class="fa fa-print"></i> Print </a>
											</div>
										</div>
										@include('notaris.pages.pengaturan.tagihan.small_pieces_invoice', ['data' => $value, 'kantor' => $page_datas->active_office['kantor']])
									</div>
								</div>
							</div>
						@endforeach

						<div class="clearfix">&nbsp;</div>
						<div class="clearfix">&nbsp;</div>
						<div class="clearfix">&nbsp;</div>
						<div class="clearfix">&nbsp;</div>
					</div>
				</div>
			</div>

		</div>	
	</div>	
	
@stop

@push('scripts')  
@endpush 
