@extends('templates.basic')

@push('styles')  
@endpush  

@section('content')
	<div class="row">

		@include('helpers.company_sidebar', ['active' => 'User'])
	
		<div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel">
			<div class="row">
				<div class="col-6">
					<h4 class="title">{{$page_attributes->title}}</h4>		
				</div>
				<div class="col-6 hidden-md-up text-right mobile-toggle-search">
					<a href="javascript:void(0);" class="btn btn-outline-primary btn-default btn-toggle-menu-on">
						<i class="fa fa fa-ellipsis-v" aria-hidden="true"></i>
					</a>
				</div>					
			</div>	
			<div class="row">
				<div class="col-12">
					@include('components.alertbox')
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-sm btn-primary" href="{{route('pengaturan.user.create')}}">Tambah User</a>
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-hover">
						<thead>
							<tr>
								<th style="width: 30%;">Nama</th>
								<th style="width: 30%;">Email</th>
								<th style="width: 20%;">Role</th>
								<th style="width: 20%;">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@forelse($page_datas->users as $key => $data)
							<tr class="clickable-row" data-href="{{route('pengaturan.user.edit', ['id' => $data['id']])}}">
								<td>
									{{ $data['nama'] }}
								</td>
								<td>
									{{ $data['email'] }}
								</td>
								<td>
									@foreach($data['visas'] as $value)
										@if($value['kantor']['id']==$acl_active_office['kantor']['id'])
											{{ $value['role'] }}
										@endif
									@endforeach
								</td>
								<td>
									
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="4" class="text-center">
									Tidak Ada Data
								</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				@include('components.paginate')
			</div>
		</div>	
	</div>	
@stop

@push('scripts')  
@endpush 
