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
			<hr>
			<div class="row">
				<div class="col-12">
					@include('components.alertbox')
				</div>
			</div>

			<div class="row">
				<div class="col-3">
					<p>Plan</p>
				</div>
				<div class="col-6">
					<p>{{$page_datas->total_user}} User(s)</p>
				</div>
				<div class="col-3 text-right">
					<a class="btn btn-primary" href="{{route('user.create')}}">Tambah User</a>
				</div>
			</div>
			<hr>

			<div class="row">
				<div class="col-3">
					<p>Tagihan Bulanan</p>
				</div>
				<div class="col-6">
					<p>{{$page_datas->total_tagihan}}</p>
				</div>
				<div class="col-3">
				</div>
			</div>
			<hr>

			<div class="row">
				<div class="col-3">
					<p>Tagihan Bulan Ini</p>
				</div>
				<div class="col-6">
					<p>{{$page_datas->tagihan_bulan_ini}}</p>
				</div>
				<div class="col-3">
				</div>
			</div>
			<hr>

		</div>	
	</div>	
@stop

@push('scripts')  
@endpush 
