<?php
	if(!isset($title)){
		$title = "";
	}

	if(!isset($route)){
		$route = "";
	}	
?>

@component('components.modal', [
		'id'			=> 'deleteModal',
		'title'			=> $title,
		'settings'		=> [
			'hide_buttons'	=> true
		]
	])
	<div id="list-koperasi">
		<form action="{{ $route }}" method="post">

			{{ method_field('DELETE') }}
			<div class="form-group has-feedback">
				<label for="password">Masukkan password Anda untuk konfirmasi</label>
				<input type="password" name="password" class="form-control" placeholder="Password Anda" required>
			</div>

			<hr/>	

			<div class="form-group text-right">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
		</form>
	</div>
	
@endcomponent	