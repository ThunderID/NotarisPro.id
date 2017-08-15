<div class="col-12 subset-menu" style="width:100vw;">
	<div class="row">

		@include('components.submenu', [
			'title' 		=> "Judul Akta",
			'back_route'	=> route('akta.akta.index'),
			'menus' 		=> [
					[
						"title" 			=> "",		
						"route" 			=> "javascript:hideAkta();",
						"icon" 				=> "fa-times",
						"class" 			=> "akta_close"
					]				
			]
		])
	</div>

	<div class="row subset-2menu full-on-mobile" style="background-color: rgba(0, 0, 0, 0.075);">

		<div id="page" class="scrollable_panel" style="width: calc(100vw - 297px); float: right;">
			<div id="page-breaker" class="row page-breaker"></div>
				<div class="d-flex justify-content-center mx-auto">
					<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 3cm; padding-left: 5cm; padding-right: 1cm;">
						<div class="form-group editor">	
					</div>
				</div>
			</div>			
		</div>

		<div class="hidden-sm-down sidebar sidebar-right subset-2menu">

				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#kelengkapan" role="tab">Kelengkapan</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#info" role="tab">Info</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#status" role="tab">Status</a>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">

				</div>
			
			</div>	

	</div>
</div>

