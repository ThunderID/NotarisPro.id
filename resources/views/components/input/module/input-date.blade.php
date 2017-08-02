<?php
	// init component
	
	//visibility
	if(isset($data['visible']) && $data['visible'] == false){
		return false;
	}

	// UI
	$ui_label 		= isset($style['label']) ? $style['label'] : str_replace("_", " ", $name);
	$ui_class 		= isset($style['class']) ? $style['class'] : '';
	$ui_placeholder = isset($style['placeholder']) ? $style['placeholder'] : '';
	$ui_default 	= isset($style['default']) ? $style['default'] : true;
	$ui_style		= 'mask';

	// Data
	if(is_null($data['gmt'])){
		$value 		= $data['value'];
		$time 		= null;
	}else{
		//convert to GMT
		$value 		= $data['value'];
		$time 		=  ' (' . $data['gmt']['timezone'] . ')';
	}
?>

<div class="form-group">
	<label 
		for="{{ $name }}"
		class="thunder_input_label"
	>
		{{ $ui_label . $time }}
	</label>
	<input 
		id="{{ 'thunder_input_string_' . $name .'_'. $index }}" 
		name="{{ $name }}" 
		value="{{ $value }}" 
		class="form-control thunder_input {{ $ui_class }} {{ $ui_default == true ? 'comp_input_' . $ui_style : '' }}"  
		placeholder="{{ $ui_placeholder }}"
		type="text" 
		data-inputmask="'alias': '{{ $data['format'] }}'"
	>
</div>