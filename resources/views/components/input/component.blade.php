<?php
	// Component
	$c_id				= isset($component_id) ? $component_id : null;

	// Data
	$c_el_head 		 	= isset($component_data['header']) ? $component_data['header'] : null;
	$c_el_data 		 	= isset($component_data['data']) ? $component_data['data'] : null;

	// styling
	/*

	//-- component styling parameter ------//

	$component_style => [

	]

	*/

	$ui_style		 	= isset($component_style) ? $component_style : null;
	if(count($ui_style) == 0){
		$ui_style		= null;
	}


	// validation

	$component_errors 	= [];

	if($component_debug == true){
		if(is_null($c_id) || is_array($c_id) || $c_id == ''){
			array_push($component_errors, "Component_id is required, can't be empty string, and must not be array");
		}

		if(!is_null($ui_style) && !is_array($ui_style)){
			array_push($component_errors, "Component_style must be array");
		}		
	}


?>

<!-- components error checking -->
@if(count($component_errors) != 0)
	<div class="col-md-12">
		<div class="alert alert-danger">
			<H4>Error on : Table Component</H4>
			@foreach($component_errors as $key => $error)
				<p>{{ $key+1 . '. ' .$error }}</p>
			@endforeach
		</div>
	</div>

	<?php
		//break operation 
		return false; 
	?>
@endif

<!-- components code -->
@foreach($c_el_head as $key => $element_name)

	<?php
		$style = null;
		if(isset($ui_style[$element_name])){
			$style = $ui_style[$element_name];
		}	
	?>

	@if($c_el_data[$element_name]['element-class'] == 'input')
		@if($c_el_data[$element_name]['element-type'] == 'string')
			@include('components.input.module.input-string', [
				"index" => $key, 
				"name"  => $element_name,
				"data" 	=> $c_el_data[$element_name]['element-properties'], 
				"style" => $style])
		@elseif($c_el_data[$element_name]['element-type'] == 'email')
			@include('components.input.module.input-email', [
				"index" => $key, 
				"name"  => $element_name,
				"data" 	=> $c_el_data[$element_name]['element-properties'],
				"style" => $style])	
		@elseif($c_el_data[$element_name]['element-type'] == 'hidden')
			@include('components.input.module.input-hidden', [
				"index" => $key, 
				"name"  => $element_name,
				"data" 	=> $c_el_data[$element_name]['element-properties'],
				"style" => null])		
		@elseif($c_el_data[$element_name]['element-type'] == 'disabled')
			@include('components.input.module.input-disabled', [
				"index" => $key, 
				"name"  => $element_name,
				"data" 	=> $c_el_data[$element_name]['element-properties'],
				"style" => $style])		
		@elseif($c_el_data[$element_name]['element-type'] == 'password')
			@include('components.input.module.input-password', [
				"index" => $key, 
				"name"  => $element_name,
				"data" 	=> $c_el_data[$element_name]['element-properties'],
				"style" => $style])		
		@elseif($c_el_data[$element_name]['element-type'] == 'text')
			@include('components.input.module.input-text', [
				"index" => $key, 
				"name"  => $element_name,
				"data" 	=> $c_el_data[$element_name]['element-properties'],
				"style" => $style])
		@elseif($c_el_data[$element_name]['element-type'] == 'date')
			@include('components.input.module.input-date', [
				"index" => $key,
				"name"  => $element_name,
				"data" 	=> $c_el_data[$element_name]['element-properties'],
				"style" => $style])			
		@endif
	@endif
@endforeach