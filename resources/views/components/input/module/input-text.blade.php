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
	$ui_row 		= isset($style['attr']['row']) ? $style['attr']['row'] : '3';
?>

<div class="form-group">
	<label 
		for="{{ $name }}"
		class="thunder_input_label"
	>
		{{ $ui_label }}
	</label>
	<textarea 
		id="{{ 'thunder_input_text_' . $name .'_'. $index }}" 
		name="{{ $name }}" 
		class="form-control thunder_input {{ $ui_class }}" 
		placeholder="{{ $ui_placeholder }}"
		rows="{{ $ui_row }}"
	>{{ $data['value'] }}</textarea>
</div>
