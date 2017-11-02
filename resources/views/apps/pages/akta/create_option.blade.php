@push ('main')
	<div class="row d-flex align-items-center justify-content-center">
		<div class="col-12">
			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-12 text-center">
					<h3 class="pb-0 mb-0" style="padding-top: 150px;">AKTA BARU</h3>
					<img class="pt-0 pb-2" src="{{url('/images/splash.png')}}" style="max-height: 20px;">
					<!-- <hr class="m-0"> -->
				</div>
			</div>
			<ul style="height: calc(100vh - 275px) !important;">
				<li class="h-100">
					<div class="first h-100">
						<img src="https://cfl.dropboxstatic.com/static/images/business/homepage/standard-vflAOtdVl.png" class="img img-fluid">
						<br/>
						<br/>
						<a href="{{ route('akta.create.scratch') }}" class="btn default-primary-color text-primary-color btn-block">Dokumen Kosong</a>
					</div>
					<div class="second">
						<img src="https://cfl.dropboxstatic.com/static/images/business/homepage/advanced-vflZIPcG1.png" class="img img-fluid">
						<br/>
						<br/>
						<a href="#" class="btn default-primary-color text-primary-color btn-block" data-toggle="modal" data-target="#choose-modal">Salin Akta Sebelumnya</a>
					</div>
				</li>
			</ul>
		</div>
	</div>

	@component ('bootstrap.modal', [
		'id' 	=> 'choose-modal',
		'size'	=> 'modal-lg'
	])
		@slot ('title')
			Daftar akta
		@endslot

		@slot ('body')
			<div class="row">
				<div class="col">
					<div class="input-group">
						{!! Form::text('cari', null, ['class' => 'form-control', 'placeholder' => 'Judul akta / nama pihak']) !!}
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button">&nbsp; <i class="fa fa-search"></i>&nbsp;Cari akta &nbsp;</button>
						</span>
					</div>
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			@include ('apps.pages.akta.components.table', ['mode' => 'choose'])
		@endslot

		@slot ('footer')
		@endslot
	@endcomponent
@endpush

@push('styles')
	<link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">

	<style type="text/css">
		* {
			box-sizing: border-box;
		}

		ul {
			margin: 0;
			padding: 0;
			list-style-type: none;
		}

		ul li div {
			width: 50%;
			float: left;
			padding-top: 8%;
			padding-right: 15%;
			padding-left: 15%;
			text-align: center;
			background: #fff;
		}

		ul li .first {
			/*border-right: 1px solid #ccc;*/
			position: relative;
		}

		ul li .first::after {
			font-family: 'Satisfy', cursive;
			content: 'atau';
			font-size:36px;
			padding-top: 15px;
			position: absolute;
			bottom: 50%;
			right: -51px;
			width: 100px;
			height: 76px;
			background: inherit;
		}
	</style>
@endpush