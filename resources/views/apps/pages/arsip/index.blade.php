@push ('main')
	<div class="row">
		<div class="col-12">
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="row mt-3">
		<div class="col-8">
			{!!Form::open(['method' => 'GET', 'class' => 'form-inline'])!!}
				{!! Form::bsSelect(null, 'jenis', $filters['jenis'], null, ["style" => "font-size:10pt !important;border-radius:0px;border-color:#868e96;"]) !!}&emsp;
				{!! Form::bsText(null, 'q', null, ['placeholder' => "Jual beli rumah di mengwi", "style" => "font-size:10pt !important;width:500px;max-width:100%;padding:10px;border-color:#868e96;"]) !!}&emsp;
				{!! Form::bsSubmit('&nbsp;<i class="fa fa-search"></i>&nbsp;', ['class' => 'btn btn btn-outline-secondary float-right', "style" => "font-size:10pt !important;padding:10px;"]) !!}
			{!!Form::close()!!}
		</div>
		<div class="col-4 text-right">
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div id="akta_index" class="row mt-3">
		<div class="col-12">
		</div>
	</div>
@endpush
