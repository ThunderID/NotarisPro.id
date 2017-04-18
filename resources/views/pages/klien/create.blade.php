@extends('templates.basic')

@push('styles')  
@endpush  

@section('klien')
	active
@stop


@section('content')
	<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">

		<div class="container">

			<div class="col-6 offset-3">

				@component('components.form', [ 
					'data_id' 		=> $page_datas->id,
					'store_url' 	=> route('klien.store'), 
					'update_url' 	=> route('klien.update', ['id', $page_datas->id]), 
				])

					<div class="row">
						<h4 class="title" style="margin-left: 0px;">{{$page_attributes->title}}</h4>
					</div>

					<fieldset class="form-group">
						<label class=" control-label" for="textinput">Nama</label>  
						<div class="row">
							<div class="col-md-5">
								<input id="textinput" name="nama" class="form-control" type="text">
							</div>
						</div>
					</fieldset>					

					<div class="row">
						<div class="form-group">
							<label class=" control-label" for="textinput">Tempat Lahir</label>  
							<input id="textinput" name="tempat_lahir" class="form-control" type="text">
						</div>
					</div>		

					<div class="row">
						<div class="form-group">
							<label class=" control-label" for="textinput">Tanggal Lahir</label>  
							<input id="textinput" name="tanggal_lahir" class="form-control" type="text">
						</div>
					</div>	

					<div class="row">
						<div class="form-group">
							<label class=" control-label" for="textinput">Pekerjaan</label>  
							<input id="textinput" name="pekerjaan" class="form-control" type="text">
						</div>
					</div>	

					<div class="row">
						<div class="form-group">
							<label class=" control-label" for="textinput">Nomor KTP</label>  
							<input id="textinput" name="nomor_ktp" class="form-control" type="text">
						</div>
					</div>		

					<div class="row">
						<div class="form-group">
							<label class=" control-label" for="textinput">Alamat</label>  
							<input id="textinput" name="alamat[alamat]" class="form-control" type="text">
						</div>
					</div>	

					<div class="row">
						<div class="form-group">
							<label class=" control-label" for="textinput">RT</label>  
							<input id="textinput" name="alamat[rt]" class="form-control" type="text">
						</div>
					</div>	

					<div class="row">
						<div class="form-group">
							<label class=" control-label" for="textinput">RW</label>  
							<input id="textinput" name="alamat[rw]" class="form-control" type="text">
						</div>
					</div>		

					<div class="row">
						<div class="form-group">
							<label class=" control-label" for="textinput">Regensi</label>  
							<input id="textinput" name="alamat[regensi]" class="form-control" type="text">
						</div>
					</div>		

					<div class="row">
						<div class="form-group">
							<label class=" control-label" for="textinput">Provinsi</label>  
							<input id="textinput" name="alamat[provinsi]" class="form-control" type="text">
						</div>
					</div>										

					<div class="row">
						<div class="form-group">
							<label class=" control-label" for="textinput">Negara</label>  
							<input id="textinput" name="alamat[negara]" class="form-control" type="text">
						</div>
					</div>

					<div class="row">
						</br>
					</div>

					<div class="row">
						<div class="form-group">
								<a href="{{ isset($page_datas->id) ? route('klien.show', ['id' => $page_datas->id]) : route('klien.index') }}" type="button" class="btn btn-default">Cancel</a>
								<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</div>

				@endcomponent	

			</div>
		</div>
	</div>
@stop

@push('scripts')  
@endpush 
