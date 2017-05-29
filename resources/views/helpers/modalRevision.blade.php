@component('components.modal', [
		'id'		=> 'content_' . $id,
		'title'		=> 'Detail Histori Revisi',
		'large'		=> true,
		'settings'	=> [
			'modal_class'	=> '',
			'hide_buttons'	=> 'true',
			'hide_title'	=> 'true',
		]
	])
	<div class="col-12">
		<section id="cd-timeline" class="cd-container large">

		@foreach($value['version'] as $val_key => $data_value)

			<div class="cd-timeline-block">
				<div class="cd-timeline-img cd-active large">
				</div> 

				<div class="cd-timeline-content pt-0" style="width:100%; left:35px;">
					{{-- <p>12 Dec 2017<br><small>By: John Doe</small></p> --}}
					<p>{{ $data_value['tanggal'] }}</p>

					<div class="pb-2 pt-2">
						{!! $data_value['konten'] !!}
					</div>

					<hr style="border-bottom: 1px solid rgba(0,0,0,.07)!important;">
				</div> 
			</div> 

		@endforeach	

		</section> 		
	</div>						
@endcomponent