@extends('templates.blank')

@section('content')
{{--
	<div id="loader" class="row">
		<div class="col-md-12" style="position:absolute; height: 100vh; overflow-y: hidden; background-color: rgba(0,0,0,.8); z-index: 7;">
		</div>
	</div>

	<div class="row" style="position:absolute; width: 100%; height: 100vh;">
		<div class="col-md-12" style="overflow-y: scroll;">

		</div>
	</div>
--}}


	<div class="row">
		<div class="col-md-12">

			<div class="row pt-3">
				<div class="col-md-12">
					<h4>{{ $page_attributes->title }}</h4>
				</div>
			</div>
			<div class="row pt-3 pb-3">
				<div class="col-md-12">
					<h5 class="">Buat Baru</h5>
					<a href="javascript:void(0);" data-toggle="modal" data-target="#setTitleAkta" class="btn btn-sm btn-primary">
						<i class="fa fa-file-o" aria-hidden="true"></i> &nbsp; Buat Akta Kosong
					</a>
				</div>
			</div>
			<div class="row pt-3 pb-3">
				<div class="col-md-12">
					<h5 class="pb-1">Buat Dari Akta Tersimpan</h5>
					<form action="{{ route('akta.akta.choooseTemplate') }}" onSubmit="showLoader();" method="GET">
						<div class="row pb-4">
							<div class="col-md-12">
								<div class="input-group">
									<input type="text" name="cari" id="cari" class="form-control" placeholder="Judul akta / nama pihak" required>
									<span class="input-group-btn">
										<button class="btn btn-secondary" type="submit" style="color: #0275d8;">
											<i class="fa fa-search" aria-hidden="true"></i> &nbsp; Cari Akta
										</button>
									</span>
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-12 mb-2">
							@include('components.filterIndicator',[
								'lists' => 	[
									'cari' 		=> 'Cari Data',
									'status' 	=> 'Status Data'
								]
							])
						</div>
					</div>					
					{{--
					<div class="row">
						<div class="col-md-12">
							<div class="row" style="padding-left: 15px; padding-right: 15px;">
								<div class="col-md-12">
									<i class="fa fa-file-o fa-2x" aria-hidden="true"></i>
									<span>
										<p>Judul Artikel</p>
										<small>Author</small>
									</span>
								</div>
							</div>
						</div>
					</div>
					--}}
					<div class="row">
						<div class="col-md-12">
							<table class="table">
								<thead>
									<tr>
										<th>Dokumen</th>
										<th style="width: 20%;">Pihak</th>
										<th style="width: 15%;"">Status</th>
										<th style="width: 15%;">Tanggal Buat</th>
										<th style="width: 5%;"></th>
									</tr>
								</thead>
								<tbody>
								@forelse((array)$page_datas->aktas as $key => $data)
									<tr>
										<td>
											<i class="fa fa-file"></i>
											&nbsp;
											{{ $data['judul'] }}
										</td>
										<td>
											@if(isset($data['pemilik']['klien']))
												<ol style="padding-left: 5px;margin-bottom: 0px;">
													@foreach($data['pemilik']['klien'] as $key => $value)
														<li> {{ $value['nama'] }} </li>
													@endforeach
												</ol>
											@endif
										</td>
										<td>
											{{ str_replace('_', ' ', $data['status']) }}
										</td>
										<td>
											{{ $data['tanggal_pembuatan'] }}
										</td>
										<td style="float: right;">
											<a href="javascript:void(0);" data-toggle="modal" data-target="#setTitleAkta" class="btn btn-sm btn-primary" akta_id="{{ $data['id'] }}" akta_judul="{{ $data['judul'] }}">Pilih</a>
										</td>						
									</tr>
					                @empty
					                <tr>
					                    <td colspan="5" class="text-center">
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
		</div>
	</div>


	@component('components.modal', [
		'id'		=> 'setTitleAkta',
		'title'		=> 'Masukkan Judul Akta',
		'settings'	=> [
			'modal_class'	=> '',
			'hide_buttons'	=> 'true',
			'hide_title'	=> 'false',
		]
	])
		<form id="finalize_akta" class="form-widgets text-right form" action="{{ route('akta.akta.create') }}" onSubmit="showLoader();" method="GET">
			<input type="hidden" id="id_akta" name="id_akta" value="null"/>

			<fieldset class="from-group pb-2">
				<span class="label label-default" style="float: left;">Judul Akta</span>
				<input type="text" name="judul_akta" class="form-control parsing set-focus" value="{{ isset($page_datas->search) ? $page_datas->search : '' }}"  required />
			</fieldset>
			{{--
			<fieldset class="from-group pb-2">
				<label for="kop_akta" style="float: left;">Kop Akta</label>
				<select class="form-control" id="kop_akta" nama="kop_akta">
					<option>Tidak Menggunakan Kop Akta</option>
					<option>Gunakan Kop Akta Standar</option>
				</select>
			</fieldset>			
			--}}
			<fieldset class="from-group pb-2 pt-3">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-primary" data-save="true">Buat Akta</button>
			</fieldset>
		</form>	
	@endcomponent	
@stop

@push('scripts')
	// showing loader
	function showLoader(){
		window.loader.show('body');
	}

	// events
	$('#setTitleAkta').on('shown.bs.modal', function (e) {
		$(this).find('#id_akta').val($(e.relatedTarget).attr('akta_id'));
		$(this).find('[name="judul_akta"]').val($(e.relatedTarget).attr('akta_judul'));
	});

	$(document).on('click', "ul.pagination a", function(e) {
		showLoader();
	});

	$(document).on('click', ".badge-notif a", function(e) {
		showLoader();
	});

	$('#setTitleAkta').on('shown.bs.modal', function(e) {
		$('.set-focus').focus();
	});
@endpush