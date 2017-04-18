@extends('templates.basic')

@push('styles')  
@endpush  

@section('klien')
	active
@stop


@section('content')
	<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">

		<div class="container">

			<div class="col-12 col-sm-10 col-md-8 col-xl-6 offset-sm-1 offset-md-2 offset-xl-3 input_panel">

				@component('components.form', [ 
					'data_id' 		=> $page_datas->id,
					'store_url' 	=> route('klien.store'), 
					'update_url' 	=> route('klien.update', ['id', $page_datas->id]), 
				])

					<div class="row">
						<div class="col-12">
							<h4 class="title" style="margin-left: 0px;">{{$page_attributes->title}}</h4>
						</div>
					</div>

					<fieldset class="form-group">
						<div class="row">
							<div class="col-12">
								<label class="control-label" for="nama">Nama</label>  
								<input id="textinput" name="nama" class="form-control" type="text">
							</div>
						</div>
					</fieldset>

					<fieldset class="form-group">
						<div class="row">
							<div class="col-7">
								<label class="control-label" for="tempat_lahir">Tempat Lahir</label>  
								<input id="textinput" name="tempat_lahir" class="form-control" type="text">
							</div>
							<div class="col-5">
								<label class="control-label" for="tanggal_lahir">Tanggal Lahir</label>  
								<input id="textinput" name="tanggal_lahir" class="form-control" type="text">
							</div>
						</div>
					</fieldset>	

					<fieldset class="form-group">
						<div class="row">
							<div class="col-8">
								<label class=" control-label" for="pekerjaan">Pekerjaan</label>  
								<input id="textinput" name="pekerjaan" class="form-control" type="text">
							</div>
						</div>
					</fieldset>

					<fieldset class="form-group">
						<div class="row">
							<div class="col-6">
								<label class=" control-label" for="nomor_ktp">Nomor KTP</label>  
								<input id="textinput" name="nomor_ktp" class="form-control" type="text">
							</div>
						</div>
					</fieldset>					

					<fieldset class="form-group">
						<div class="row">
							<div class="col-12">
								<label class=" control-label" for="alamat[alamat]">Alamat</label>  
								<input id="textinput" name="alamat[alamat]" class="form-control" type="text">
							</div>
						</div>
					</fieldset>		

					<fieldset class="form-group">
						<div class="row">
							<div class="col-3">
								<label class=" control-label" for="alamat[rt]">RT</label>  
								<input id="textinput" name="alamat[rt]" class="form-control" type="text">
							</div>
							<div class="col-3">
								<label class=" control-label" for="alamat[rw]">RW</label>  
								<input id="textinput" name="alamat[rw]" class="form-control" type="text">
							</div>	
							<div class="col-6">
								<label class=" control-label" for="alamat[regensi]">Regensi</label>  
								<input id="textinput" name="alamat[regensi]" class="form-control" type="text">
							</div>
						</div>
					</fieldset>		

					<fieldset class="form-group">
						<div class="row">
							<div class="col-8">
								<label class=" control-label" for="alamat[provinsi]">Provinsi</label>  
								<input id="textinput" name="alamat[provinsi]" class="form-control" type="text">
							</div>
						</div>
					</fieldset>		

					<fieldset class="form-group">
						<div class="row">
							<div class="col-6">
								<label class=" control-label" for="alamat[negara]">Negara</label>  
								<input id="textinput" name="alamat[negara]" class="form-control" type="text">
							</div>
						</div>
					</fieldset>		

					<fieldset class="form-group">
						</br>
					</fieldset>


					<fieldset class="form-group">
						<div class="row">
							<div class="col-6">
								<a href="{{ isset($page_datas->id) ? route('klien.show', ['id' => $page_datas->id]) : route('klien.index') }}" type="button" class="btn btn-secondary">Cancel</a>
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
						</div>
					</fieldset>		

				@endcomponent	

			</div>
		</div>
	</div>
@stop

@push('scripts')  
@endpush 
