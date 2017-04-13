@extends('templates.basic')

@push('styles')  
@endpush  

@section('akta')
	active
@stop

@section('template-akta')
	active
@stop

@section('content')
<div class="row">

	<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 sidebar">
		<div class="panel">
			@include('components.search',[
				'qs'	=> [ 'status','sort' ],
				'action_url' => route(Route::currentRouteName(), Request::only('status','sort'))
			])		
		</div>

		<div class="panel">
			@include('components.filter',[
				'alias' => 'status',
				'qs'	=> [ 'q','sort' ],
				'lists' => [
					'semua status' 	=> null,
					'draft' 		=> 'draft', 
					'publish' 		=> 'publish',
				]
			])
		</div>
	</div>

	<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-10 scrollable_panel">
		<h4 class="title">Data Template Akta</h4>		
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Dokumen</th>
					<th style="width: 15%;"">Status</th>
					<th style="width: 20%;">Tanggal Sunting</th>
					<th style="width: 20%;">Tanggal Pembuatan</th>
				</tr>
			</thead>
			<tbody>
                @forelse((array)$page_datas->datas as $key => $data)
				<tr>
					<td>
						<i class="fa fa-file"></i>
						&nbsp;
						{{ $data['judul'] }}
					</td>
					<td>
						{{ $data['status'] }}
					</td>
					<td>
						{{ $data['tanggal_sunting'] }}
					</td>
					<td>
						{{ $data['tanggal_pembuatan'] }}
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
        @include('components.paginate')
	</div>

<!-- 	<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2" style="height: calc(100% - 54px); background-color: #ddd; ">
		<h5 style="padding-top: 2rem; padding-bottom: 0.5rem;">Cari Data</h5>

		<div class="search">
			<form class="form" action="" data-pjax=true data-ajax-submit=false>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Cari" aria-describedby="basic-addon1" name="q">
					<span class="input-group-addon" id="basic-addon1">
						<i class="fa fa-search" aria-hidden="true"></i>
					</span>
				</div>
			</form>
		</div>
	</div>	 -->

</div>
@stop

@push('scripts')  
@endpush 
