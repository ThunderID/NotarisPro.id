@extends('templates.basic')

@push('styles')  
@endpush  

@section('klien')
	active
@stop


@section('content')
<div class="row">

	<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 sidebar">
		<div class="panel">
			@include('components.search',[
				'qs'	=> [ 'status','urutkan' ],
				'action_url' => route(Route::currentRouteName(), Request::only('status','sort'))
			])
		</div>

		<div class="panel">
			@include('components.sidebarmenu',[
				'title' => 'Menu',
				'lists' => [
					'tambah data' 	=> [
						'url' 	=> route('klien.create'),
						'icon' 	=> 'fa-plus'
					]
				]
			])
		</div>	

	</div>

	<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-10 scrollable_panel">
		<div class="row">
			<div class="col-6">
				<h4 class="title">Data Klien</h4>		
			</div>
			<div class="col-6 text-right">
				@include('components.sort',[
					'alias' => 'urutkan',
					'qs'	=> [ 'q' ],
					'lists' => [
						'nama a - z' 	=> null,
						'nama z - a' 	=> 'nama-desc',
					]
				])
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover">
					<thead>
						<tr>
							<th style="width: 15%""> Nomor KTP </th>
							<th style="width: 30%;"">Nama</th>
							<th style="width: 20%;">TTL</th>
							<th style="width: 25%;">Pekerjaan</th>
						</tr>
					</thead>
					<tbody>
		                @forelse((array)$page_datas->datas as $key => $data)
						<tr class="clickable-row" data-href="{{ route('klien.show', ['id' => $data['id']]) }}">
							<td>
								{{ $data['nomor_ktp'] }}
							</td>
							<td>
								{{ $data['nama'] }}
							</td>
							<td>
								{{ $data['tempat_lahir'] }} , {{ $data['tanggal_lahir'] }} 
							</td>
							<td>
								{{ $data['pekerjaan'] }}
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
