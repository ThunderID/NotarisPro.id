@extends('templates.basic')

@push('styles')  
@endpush  

@section('content')
	<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">

		<div class="container">

			<div class="col-12 col-sm-10 col-md-8 col-xl-6 offset-sm-1 offset-md-2 offset-xl-3 input_panel">

				@component('components.form', [ 
					'data_id' 		=> $page_datas->id,
					'store_url' 	=> route('notaris.kantor.store'), 
					'update_url' 	=> route('notaris.kantor.update', ['id' => $page_datas->id]), 
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
								<label class="control-label" for="nama">Nama Kantor Notaris</label>  
								<input name="nama" value="{{ old('nama') ? old('nama') : $page_datas->datas['nama'] }}" class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>

					<fieldset class="form-group">
						<div class="row">
							<div class="col-12">
								<label class="control-label" for="notaris[nama]">Nama Notaris</label>  
								<input name="notaris[nama]" value="{{ old('notaris[nama]') ? old('notaris[nama]') : $page_datas->datas['notaris']['nama'] }}" class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>	
					<fieldset class="form-group">
						<div class="row">
							<div class="col-12">
								<label class="control-label" for="notaris[daerah_kerja]">Daerah Kerja</label>  
								<input name="notaris[daerah_kerja]" value="{{ old('notaris[daerah_kerja]') ? old('notaris[daerah_kerja]') : $page_datas->datas['notaris']['daerah_kerja'] }}" class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>	
					<fieldset class="form-group">
						<div class="row">
							<div class="col-12">
								<label class="control-label" for="notaris[nomor_sk]">Nomor SK Notaris</label>  
								<input name="notaris[nomor_sk]" value="{{ old('notaris[nomor_sk]') ? old('notaris[nomor_sk]') : $page_datas->datas['notaris']['nomor_sk'] }}" class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>	
					<fieldset class="form-group">
						<div class="row">
							<div class="col-12">
								<label class="control-label" for="notaris[tanggal_pengangkatan]">Tanggal Pengangkatan</label>  
								<input name="notaris[tanggal_pengangkatan]" value="{{ old('notaris[tanggal_pengangkatan]') ? old('notaris[tanggal_pengangkatan]') : $page_datas->datas['notaris']['tanggal_pengangkatan'] }}" class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>	

					<fieldset class="form-group">
						<div class="row">
							<div class="col-12">
								<label class=" control-label" for="alamat[alamat]">Alamat</label>  
								<input name="notaris[alamat]" value="{{ old('alamat.alamat') ? old('alamat.alamat') : $page_datas->datas['notaris']['alamat'] }}"  class="form-control" type="text" required>
							</div>
						</div>
					</fieldset>		

					<fieldset class="form-group">
						<div class="row">
							<div class="col-12">
								<label class="control-label" for="notaris[telepon]">Nomor Telepon</label>  
								<input name="notaris[telepon]" value="{{ old('notaris[telepon]') ? old('notaris[telepon]') : $page_datas->datas['notaris']['telepon'] }}" class="form-control" type="text" required>
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
