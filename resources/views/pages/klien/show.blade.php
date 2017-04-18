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
			@include('components.sidebarmenu',[
				'title' => 'Menu',
				'lists' => [
					'Kembali'		=>[
						'url' 	=> route('klien.index'),
						'icon' 	=> 'fa-undo'
					],
					'edit data' 	=> [
						'url' 	=> route('klien.edit', ['id' => $page_datas->id]),
						'icon' 	=> 'fa-pencil'
					],
					'hapus data' 	=> [
						'url' 	=>  null,
						'icon' 	=> 'fa-trash',
						'attr'	=> 	[
										'data-toggle' 	=> 'modal',
										'data-target' 	=> '#deleteModal'
									]
					]					
				]
			])
		</div>	
	</div>
	<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-10 scrollable_panel">
		<div class="row">
			<div class="col-12">
				<h4 class="title">{{$page_attributes->title}}</h4>		
			</div>
		</div>	
		<div class="row">
			<div class="col-12">
				<table class="table">
					<tbody>
						<tr>
							<th class="vertical-header">Nama Lengkap</th>
							<td>{{ ucWords($page_datas->datas['nama']) }}</td>
						</tr>
						<tr>
							<th class="vertical-header">Tempat Tanggal Lahir</th>
							<td>{{ ucWords($page_datas->datas['tempat_lahir']) }}, {{$page_datas->datas['tanggal_lahir']}}</td>
						</tr>
						<tr>
							<th class="vertical-header">Nomor KTP</th>
							<td>{{ ucWords($page_datas->datas['nomor_ktp']) }}</td>
						</tr>
						<tr>
							<th class="vertical-header">Pekerjaan</th>
							<td>{{ ucWords($page_datas->datas['pekerjaan']) }}</td>
						</tr>
						<tr>
							<th class="vertical-header">Alamat</th>
							<td>
								<!-- alamat -->
								{{ $page_datas->datas['alamat']['alamat'] }}
								</br>

								<!-- RT, RW, Residen -->
								<strong>RT </strong>{{ !is_null($page_datas->datas['alamat']['rt']) ? $page_datas->datas['alamat']['rt'] : '...' }} / 
								<strong>RW </strong>{{ !is_null($page_datas->datas['alamat']['rw']) ? $page_datas->datas['alamat']['rw'] : '...' }},  
								{{ ucWords($page_datas->datas['alamat']['regensi']) }}
								</br>

								<!-- provinsi, negara -->
								{{ ucWords($page_datas->datas['alamat']['provinsi']) }},
								{{ ucWords($page_datas->datas['alamat']['negara']) }}

							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>	

	@include('components.deleteModal',[
		'title' => 'Menghapus Data Klien',
		'route' => route('klien.destroy', ['id' => $page_datas->id])
	])
@stop
