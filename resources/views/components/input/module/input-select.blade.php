<?php
	// init component
	
	//enable
	if(isset($data['enabled']) && $data['enabled'] == false){
		$ui_enable = 'disabled';
	}else{
		$ui_enable = null;
	}

	// UI
	$ui_label 		= isset($style['label']) ? $style['label'] : str_replace("_", " ", $name);
	$ui_class 		= isset($style['class']) ? $style['class'] : '';
	$ui_placeholder = isset($style['placeholder']) ? $style['placeholder'] : 'Select your option';
	$ui_default 	= isset($style['default']) ? $style['default'] : true;
	$ui_style		= 'mask';

	// Data
	$value 			= isset($data['value']) ? $data['value'] : str_replace("_", " ", $name);
	$select 		= isset($data['options']) ? $data['options'] : null;
?>

<div class="form-group">
	<label 
		for="{{ $name }}"
		class="thunder_input_label"
	>
		{{ $ui_label }}
	</label>
	<select
		id="{{ 'thunder_input_string_' . $name .'_'. $index }}" 
		name="{{ $name }}" 
		value="{{ $value }}" 
		class="form-control thunder_input {{ $ui_class }} {{ $ui_default == true ? 'comp_input_' . $ui_style : '' }}"  
		placeholder="{{ $ui_placeholder }}"		
		>
			<option value="" disabled selected>
				{{ $ui_placeholder }}
			</option>
			@foreach($select as $key => $s)
				<option value="{{$key}}">
					{{ $s }}
				</option>
			@endforeach
	</select>
</div>