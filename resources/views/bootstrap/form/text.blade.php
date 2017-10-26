<div class="form-group">
	@if ($label)
		{!! Form::label('', $label, ['class' => 'text-uppercase']) !!}
	@endif

	@if ($addon)
		<div class='input-group'>
		@if(isset($attributes['class']) && str_is('*inline-edit*', $attributes['class']))
			<div class="input-group-addon" style="border:none !important;background:none !important">{!! $addon !!}</div>
		@else
			<div class="input-group-addon">{!! $addon !!}</div>
		@endif
	@endif
	
		@if($errors->has($name)  && $show_error && isset($attributes['class']))
			@php
				$attributes['class'] 	= $attributes['class'].' is-invalid';
			@endphp
		@endif

			{!! Form::text($name, $value, array_merge(['class' => 'form-control ' . ($errors->has($name)  && $show_error ? 'is-invalid' : '')], ($attributes ? $attributes : []))) !!}
			
	@if ($addon)
		</div>
	@endif

	@if ($errors->has($name) && $show_error)
		<div class="invalid-feedback" style="display:inherit !important">
			@foreach ($errors->get($name) as $v)
				{{ $v }}<br>
			@endforeach
		</div>
	@endif
</div>