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
					'update_url' 	=> route('klien.update', ['id' => $page_datas->id]), 
				])

					<div class="row">
						<div class="col-12">
							<h4 class="title" style="margin-left: 0px;">{{$page_attributes->title}}</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							@include('components.alertbox')
						</div>
					</div>					

					<fieldset class="form-group">
						<div class="row">
							<div class="col-12">
								<label class="control-label" for="nama">Nama</label>  
								<input name="nama" value="{{ old('nama') ? old('nama') : $page_datas->datas['nama'] }}" class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>

					<fieldset class="form-group">
						<div class="row">
							<div class="col-7">
								<label class="control-label" for="tempat_lahir">Tempat Lahir</label>  
								<input name="tempat_lahir" value="{{ old('tempat_lahir') ? old('tempat_lahir') : $page_datas->datas['tempat_lahir'] }}" class="form-control" type="text" required>
							</div>
							<div class="col-5">
								<label class="control-label" for="tanggal_lahir">Tanggal Lahir</label>  
								<input name="tanggal_lahir" value="{{ old('tanggal_lahir') ? old('tanggal_lahir') : $page_datas->datas['tanggal_lahir'] }}" class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>	

					<fieldset class="form-group">
						<div class="row">
							<div class="col-8">
								<label class=" control-label" for="pekerjaan">Pekerjaan</label>  
								<input name="pekerjaan" value="{{ old('pekerjaan') ? old('pekerjaan') : $page_datas->datas['pekerjaan'] }}" class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>

					<fieldset class="form-group">
						<div class="row">
							<div class="col-6">
								<label class=" control-label" for="nomor_ktp">Nomor KTP</label>  
								<input name="nomor_ktp" value="{{ old('nomor_ktp') ? old('nomor_ktp') : $page_datas->datas['nomor_ktp'] }}"  class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>					

					<fieldset class="form-group">
						<div class="row">
							<div class="col-12">
								<label class=" control-label" for="alamat[alamat]">Alamat</label>  
								<input name="alamat[alamat]" value="{{ old('alamat.alamat') ? old('alamat.alamat') : $page_datas->datas['alamat']['alamat'] }}"  class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>		

					<fieldset class="form-group">
						<div class="row">
							<div class="col-3">
								<label class=" control-label" for="alamat[rt]">RT</label>  
								<input name="alamat[rt]" value="{{ old('alamat.rt') ? old('alamat.rt') : $page_datas->datas['alamat']['rt'] }}" class="form-control" type="text">
							</div>
							<div class="col-3">
								<label class=" control-label" for="alamat[rw]">RW</label>  
								<input name="alamat[rw]" value="{{ old('alamat.rw') ? old('alamat.rw') : $page_datas->datas['alamat']['rw'] }}" class="form-control" type="text">
							</div>	
							<div class="col-6">
								<label class=" control-label" for="alamat[regensi]">Regensi</label>  
								<input name="alamat[regensi]" value="{{ old('alamat.regensi') ? old('alamat.regensi') : $page_datas->datas['alamat']['regensi'] }}" class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>		

					<fieldset class="form-group">
						<div class="row">
							<div class="col-8">
								<label class=" control-label" for="alamat[provinsi]">Provinsi</label>  
								<input name="alamat[provinsi]" value="{{ old('alamat.provinsi') ? old('alamat.provinsi') : $page_datas->datas['alamat']['provinsi'] }}" class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>		

					<fieldset class="form-group">
						<div class="row">
							<div class="col-6">
								<label class=" control-label" for="alamat[negara]">Negara</label>  
								<input name="alamat[negara]" value="{{ old('alamat.negara') ? old('alamat.negara') : $page_datas->datas['alamat']['negara'] }}" class="form-control" type="text" required>
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
