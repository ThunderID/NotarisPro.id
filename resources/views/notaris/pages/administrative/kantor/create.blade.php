@extends('templates.basic')

@push('styles')  
@endpush  

@section('content')
	<div class="row">

		@include('helpers.company_sidebar', ['active' => 'Profil Kantor'])

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
				<div class="col-12 col-lg-10 col-xl-8">
					@component('components.form', [ 
						'data_id' 		=> $page_datas->id,
						'store_url' 	=> route('administrative.kantor.update', ['id' => $page_datas->id]), 
						'update_url' 	=> route('administrative.kantor.update', ['id' => $page_datas->id]), 
					])

						<div class="row">
							<div class="col-12">
								@include('components.alertbox')
							</div>
						</div>					

						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="nama">Nama Kantor Notaris</label>  
									<input name="nama" value="{{ old('nama') ? old('nama') : $page_datas->kantor['nama'] }}" class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>

						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="notaris[nama]">Nama Notaris</label>  
									<input name="notaris[nama]" value="{{ old('notaris[nama]') ? old('notaris[nama]') : $page_datas->kantor['notaris']['nama'] }}" class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>	

						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="notaris[email]">Email Notaris</label>  
									<input name="notaris[email]" value="{{ old('notaris[email]') ? old('notaris[email]') : $page_datas->kantor['notaris']['email'] }}" class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>	
						
						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="notaris[daerah_kerja]">Daerah Kerja</label>  
									<input name="notaris[daerah_kerja]" value="{{ old('notaris[daerah_kerja]') ? old('notaris[daerah_kerja]') : $page_datas->kantor['notaris']['daerah_kerja'] }}" class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>	
						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="notaris[nomor_sk]">Nomor SK Notaris</label>  
									<input name="notaris[nomor_sk]" value="{{ old('notaris[nomor_sk]') ? old('notaris[nomor_sk]') : $page_datas->kantor['notaris']['nomor_sk'] }}" class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>	
						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="notaris[tanggal_pengangkatan]">Tanggal Pengangkatan</label>  
									<input name="notaris[tanggal_pengangkatan]" value="{{ old('notaris[tanggal_pengangkatan]') ? old('notaris[tanggal_pengangkatan]') : $page_datas->kantor['notaris']['tanggal_pengangkatan'] }}" class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>	

						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class=" control-label" for="alamat[alamat]">Alamat</label>  
									<input name="notaris[alamat]" value="{{ old('alamat.alamat') ? old('alamat.alamat') : $page_datas->kantor['notaris']['alamat'] }}"  class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>		

						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="notaris[telepon]">Nomor Telepon</label>  
									<input name="notaris[telepon]" value="{{ old('notaris[telepon]') ? old('notaris[telepon]') : $page_datas->kantor['notaris']['telepon'] }}" class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>

						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="notaris[logo_url]">Cap URL (Skala 5:2)</label>  
									<input name="notaris[logo_url]" value="{{ old('notaris[logo_url]') ? old('notaris[logo_url]') : $page_datas->kantor['notaris']['logo_url'] }}" class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>

						<fieldset class="form-group">
							</br>
						</fieldset>

						<fieldset class="form-group">
							<div class="row">
								<div class="col-6">
									<button type="submit" class="btn btn-primary">Update</button>
								</div>
							</div>
						</fieldset>	

						<fieldset class="form-group">
							</br>
						</fieldset>						
							
					@endcomponent	
				</div>
			</div>
		</div>	
	</div>	
@stop

@push('scripts')  
@endpush 
