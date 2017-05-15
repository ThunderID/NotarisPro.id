@extends('templates.basic')

@push('styles')  
@endpush  

@section('content')
	<div class="row">

		<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3 sidebar">
			<div class="panel">
				@include('helpers.setting_sidebar')
			</div>	
		</div>
		<div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-9">
			<div class="row">
				<div class="col-12">
					<h4 class="title">{{$page_attributes->title}}</h4>		
				</div>
			</div>	
			<div class="row">
				<div class="col-12">
					@include('components.alertbox')
				</div>
			</div>
			<div class="row">
				<div class="col-8">
					@component('components.form', [ 
						'data_id' 		=> $page_datas->id,
						'store_url' 	=> route('user.store'), 
						'update_url' 	=> route('user.update', ['id' => $page_datas->id]), 
					])

						<div class="row">
							<div class="col-12">
								@include('components.alertbox')
							</div>
						</div>					

						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="nama">Nama</label>  
									<input name="akun_nama" value="{{ old('nama') ? old('nama') : '' }}" class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>

						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="email">Email</label>  
									<input name="akun_email" value="{{ old('email') ? old('email') : '' }}" class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>

						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="role">Role</label>  
									<select name="akun_role" value="{{ old('role') ? old('role') : '' }}" class="form-control">
										<option value="drafter">Drafter</option>
										<option value="notaris">Notaris</option>
									</select>
								</div>
							</div>
						</fieldset>

						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="password">Password</label>  
									<input name="akun_password" class="form-control" type="password" required>
								</div>
							</div>
						</fieldset>	
					
						<fieldset class="form-group">
							<div class="row">
								<div class="col-6">
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>
							</div>
						</fieldset>	
							
						<fieldset class="form-group">
							</br>
							</br>
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
