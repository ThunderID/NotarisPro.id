@extends('templates.basic')

@push('styles')  
@endpush  

@section('jadwal')
	active
@stop

@section('data-jadwal')
	active
@stop

@section('content')
	<div class="row">

		<div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-9">
			<h4 class="title">{{$page_attributes->title}}</h4>		
			<div id='calendar' style="padding-right:15px"></div>
		</div>	
		<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3 hide-mobile sidebar subset-menu target-menu">
			<h5 style="padding-bottom:5px;margin-bottom:5px;">Jadwal Baru</h5>
			<p style="line-height:1;"><small><small>Penambahan jadwal baru ini akan di sinkronkan dengan google calendar Anda</small></small></p>

			<form action="{{route('jadwal.bpn.store')}}" method="POST">
				<fieldset class="form-group">
					<div class="row">
						<div class="col-12">
							<label class="control-label" for="nomor_akta">Nomor Akta</label>  
							<input name="nomor_akta" value="{{$page_datas->jadwal['referensi']['nomor_akta']}}" class="form-control" type="text" required>
						</div>
					</div>
				</fieldset>

				<fieldset class="form-group">
					<div class="row">
						<div class="col-12">
							<label class="control-label" for="tanggal_mulai">Mulai</label>  
							<input name="tanggal_mulai" value="{{$page_datas->jadwal['start']}}" class="form-control" type="text" required>
						</div>
					</div>
				</fieldset>

				<fieldset class="form-group">
					<div class="row">
						<div class="col-12">
							<label class="control-label" for="tanggal_selesai">Sampai</label>  
							<input name="tanggal_selesai" value="{{$page_datas->jadwal['end']}}" class="form-control" type="text" required>
						</div>
					</div>
				</fieldset>		

				<fieldset class="form-group">
					<div class="row">
						<div class="col-12">
							<label class="control-label" for="tempat">Tempat</label>  
							<textarea name="tempat" class="form-control">{{$page_datas->jadwal['tempat']}}</textarea>
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
			</form>

		</div>	
	</div>	
@stop

@push('styles')  
</style>
<link href="{{url('/assets/kalender/fullcalendar.min.css')}}" rel='stylesheet' />
<link href="{{url('/assets/kalender/fullcalendar.print.min.css')}}" rel='stylesheet' media='print' />
<style>
@endpush 

@push('scripts')  
	$(document).ready(function() {

		$('#calendar').fullCalendar({
			defaultDate: '2017-08-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: {!!json_encode($page_datas->bpns)!!}
		});
		
	});
</script>
<script src="{{url('/assets/kalender/lib/moment.min.js')}}"></script>
<script src="{{url('/assets/kalender/lib/jquery.min.js')}}"></script>
<script src="{{url('/assets/kalender/fullcalendar.min.js')}}"></script>
<script>
@endpush 
