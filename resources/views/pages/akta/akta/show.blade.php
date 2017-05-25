@extends('templates.basic')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
@endpush

@push('styles')  
	.page-editor .wrapper {
	    margin-left: -150px;
	    margin-bottom: 10px;
	    padding-top: 10px;
	    padding-bottom: 10px;
	    border: 1px solid rgba(0,0,0,.07)!important;
	}
	.page-editor .wrapper.unlocked {
		border: 1px solid rgba(2, 117, 216, 0.58)!important;
	}
	.page-editor .wrapper:hover {
		margin-top: -1px;
		margin-bottom: 11px;
		box-shadow: 2px 2px 7px rgba(0,7,10,.2);
		cursor: default;
	}
	.page-editor .wrapper .control {
	   	width: 149px; 
	   	height: auto; 
	   	padding-left: 15px;
	   	color: #EDEDED;
	   	/* position: absolute; */ 
	}
	.page-editor .wrapper .content {
	    padding-left: 155px;
	}

	.sidebar p{
	    font-size: 0.8rem;
	}

	.sidebar h4{
	    font-size: 1rem;
	}	

	.sidebar-right {
	    padding: 0vw;
	    overflow-x: hidden;
	    width: 350px;
	}
	.sidebar ul {
		border-bottom: 1px solid rgb(2, 117, 216);
	}

	.sidebar ul li{
	    width: 33vw;
	    text-align: center;
	    font-size: 0.8rem;
	}

	.nav-tabs .nav-link{
		border: none;
		border-top-right-radius: 0px;
		border-top-left-radius: 0px;
	}

	.nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {
	    border-color: transperant;
    }

    .nav-tabs .nav-link.active{
	    color: #ffffff;
	    background-color: #0275d8;
	    border-color: transperant;
    }


@endpush  

@section('akta')
	active
@stop

@section('data-akta')
	active
@stop

@section('content')
<?php
	// dd($page_datas->datas);

	// getting status 
	$status_array = ['dalam_proses', 'draft', 'renvoi', 'minuta', 'akta']; 
	$status_doc = array_search($page_datas->datas['status'] ,$status_array);
?>
		<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">

			{{-- Predefine Sub Menu --}}
			<?php
				// dd($page_datas);
				// Status : Dalam Proses
				if(str_is($page_datas->datas['status'], 'dalam_proses')){
					$menus 		= [
						[
							"title" 			=> "Hapus",	
							"class" 			=> "text-danger",	
							"trigger_modal" 	=> "#deleteModal",
							"icon" 				=> "fa-trash",
						],
						[
							"title" 			=> "Edit",	
							"hide_on" 			=> "hidden-sm-down",	
							"route" 			=> route('akta.akta.edit', ['id' => $page_datas->datas['id']]),
							"icon" 				=> "fa-edit",
						],
						[
							"title" 			=> "Publish",	
							"route" 			=> route('akta.akta.status', ['id' => $page_datas->datas['id'], 'status' => 'draft']),
							"icon" 				=> "fa-check",
						]						
					];
				}
				// Status : Draft
				else if (str_is($page_datas->datas['status'], 'draft')) {
					// ACL
					if(str_is(acl_active_office['role'], 'notaris')){
						// menu
						$menus 		= [
							[
								"title" 			=> "History Revisi",	
								"route" 			=> route('akta.akta.versioning', ['akta_id' => $page_datas->datas['id']]),
								"icon" 				=> "fa-history",
							],
							[
								"title" 			=> "Final",	
								"trigger_modal" 	=> "#finalize",
								"icon" 				=> "fa-file",
							],
							[
								"title" 			=> "Renvoi",	
								"route" 			=> route('akta.akta.status', ['id' => $page_datas->datas['id'], 'status' => 'renvoi']),
								"icon" 				=> "fa-check",
							]							
						];
					}else{
						// menu
						$menus 		= [
							[
								"title" 			=> "History Revisi",	
								"route" 			=> route('akta.akta.versioning', ['akta_id' => $page_datas->datas['id']]),
								"icon" 				=> "fa-history",
							],
						];
					}
				}
				// Status : Renvoi
				else if(str_is($page_datas->datas['status'], 'renvoi')) {
					$menus 		= [
						[
							"title" 			=> "Hapus",	
							"class" 			=> "text-danger",	
							"trigger_modal" 	=> "#deleteModal",
							"icon" 				=> "fa-trash",
						],
						[
							"title" 			=> "Edit",	
							"hide_on" 			=> "hidden-sm-down",	
							"route" 			=> route('akta.akta.edit', ['id' => $page_datas->datas['id']]),
							"icon" 				=> "fa-edit",
						],
						[
							"title" 			=> "Publish",	
							"route" 			=> route('akta.akta.status', ['id' => $page_datas->datas['id'], 'status' => 'draft']),
							"icon" 				=> "fa-check",
						]						
					];
				}
				// Status : Akta
				else if(str_is($page_datas->datas['status'], 'akta')) {		
					$menus 		= [
						[
							"title" 			=> "Export PDF",	
							"route" 			=> route('akta.akta.pdf', ['akta_id' => $page_datas->datas['id']] ),
							"icon" 				=> "fa-file-pdf-o",
						]						
					];
				}else{
					$menus 		= [];
				}		
			?>

			@include('components.submenu', [
				'title' 		=> $page_datas->datas['judul'],
				'back_route'	=> route('akta.akta.index'),
				'menus' 		=> $menus
			])


			<div id="page" class="scrollable_panel subset-2menu full-on-mobile" style="width: calc(100vw - 350px);">
				<div id="page-breaker" class="row page-breaker"></div>
				<div class="row">
					<div class="d-flex justify-content-center mx-auto">
						<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 3cm; padding-left: 5cm; padding-right: 1cm;">
							<div class="form-group editor">

								<?php
									// dd($page_datas->datas);
								?>
								@foreach($page_datas->datas['paragraf'] as $key => $value)
									{{-- Dalam Proses --}}
									@if($page_datas->datas['status']=='dalam_proses')

									<div class="wrapper">
										<div class="control">
											<span data-toggle="tooltip" data-placement="right" title="Fitur kunci dokumen belum tersedia. Fitur ini tersedia pada status draft">
												<i class="fa fa-unlock" aria-hidden="true"></i>
											</span>
											&nbsp;|&nbsp;
											<span data-toggle="tooltip" data-placement="right" title="Fitur riwayat revisi belum tersedia. Fitur ini tersedia pada status draft">
												<i class="fa fa-history" aria-hidden="true"></i> 0
											</span>
										</div>
										<div class="content">
											{!!$value['konten']!!}
										</div>
									</div>									

									{{-- Draft --}}
									@elseif($page_datas->datas['status']=='draft')

										@if(str_is(acl_active_office['role'], 'notaris'))

											@if(!isset($value['lock']))

												{{-- UNCLOKED --}}
												<div class="wrapper unlocked">
													<div class="control">
														<a href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="#" data-animation="false" data-lock="{{ $value['key'] }}" class="lock" data-url="{{ route('akta.akta.tandai.renvoi', $page_datas->datas['id']) }}" unlocked="true">
															<i class="fa fa-unlock" aria-hidden="true"></i>
														</a>
														&nbsp;|&nbsp;
														<a href="javascript:void(0);" data-toggle="modal" data-target="#content_">
															<i class="fa fa-history" aria-hidden="true" data-url="{{ route('akta.akta.tandai.renvoi', $page_datas->datas['id']) }}" unlocked="false"></i> 0
														</a>
													</div>
													<div class="content">
														{!!$value['konten']!!}
													</div>
												</div>	
											
											@else

												{{-- LOCKED --}}
												<div class="wrapper">
													<div class="control">
														<a href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="#" data-animation="false" class="lock"  data-lock="{{ $value['key'] }}" data-url="{{ route('akta.akta.tandai.renvoi', $page_datas->datas['id']) }}" unlocked="false">
															<i class="fa fa-lock" aria-hidden="true"></i>
														</a>
														&nbsp;|&nbsp;
														<a href="javascript:void(0);" data-toggle="modal" data-target="#content_">
															<i class="fa fa-history" aria-hidden="true"></i> 0
														</a>
													</div>
													<div class="content">
														{!!$value['konten']!!}
													</div>
												</div>												

											@endif

										@else

											<div class="wrapper">
												<div class="control">
													<span href="#" data-toggle="tooltip" data-placement="right" title="#">
														<i class="fa fa-unlock" aria-hidden="true"></i>
													</span>
													&nbsp;|&nbsp;
													<span href="#" data-toggle="tooltip" data-placement="right" title="#">
														<i class="fa fa-history" aria-hidden="true"></i> 0
													</span>
												</div>
												<div class="content">
													{!!$value['konten']!!}
												</div>
											</div>

										@endif																		

									{{-- Renvoi --}}
									@elseif($page_datas->datas['status']=='renvoi')

										@if (!isset($value['lock']))

											{{-- UNLOCKED --}}
											<div class="wrapper unlocked">
												<div class="control">
													<a href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="#"
													class="lock" data-lock="{{ isset($value['key']) ? $value['key'] : null }}" data-url="{{ route('akta.akta.tandai.renvoi', $page_datas->datas['id']) }}" unlocked= "true" >
														<i class="fa fa-unlock" aria-hidden="true"></i>
													</a>
													&nbsp;|&nbsp;
													<a href="javascript:void(0);" data-toggle="modal" data-target="#content_">
														<i class="fa fa-history" aria-hidden="true" data-url="{{ route('akta.akta.tandai.renvoi', $page_datas->datas['id']) }}" unlocked="false"></i> 0
													</a>
												</div>
												<div class="content">
													<?php
														var_dump($value['konten']);
													?>
													{!!$value['konten']!!}
												</div>
											</div>	

										@else
											{{-- LOCKED --}}
											<div class="wrapper">
												<div class="control">
													<a class="lock" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="#" data-lock="{{ isset($value['key']) ? $value['key'] : null }}" data-url="{{ route('akta.akta.tandai.renvoi', $page_datas->datas['id']) }}" unlocked="false">
														<i class="fa fa-lock" aria-hidden="true"></i>
													</a>
													&nbsp;|&nbsp;
													<a href="javascript:void(0);" data-toggle="modal" data-target="#content_">
														<i class="fa fa-history" aria-hidden="true"></i> 0
													</a>
												</div>
												<div class="content">
													{!!$value['konten']!!}
												</div>
											</div>

										@endif


									{{-- Akta --}}
									@elseif($page_datas->datas['status']=='akta')
										{!!$value['konten']!!}

									{{-- Minuta --}}
									@elseif($page_datas->datas['status']=='minuta')
										{!!$value['konten']!!}

									{{-- Lainnya --}}
									@else
										{!!$value['konten']!!}
									@endif


								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="hidden-sm-down sidebar sidebar-right subset-2menu">

					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#kelengkapan" role="tab">Kelengkapan</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#info" role="tab">Info</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#status" role="tab">Status</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane active" id="kelengkapan" role="tabpanel">
							<div class="col-md-12 pt-3">
								<h5 class="text-capitalize mb-0">Deskripsi Template</h5>
								<p>ajshdajshjdkah</p>
							</div>
						</div>

						<div class="tab-pane" id="info" role="tabpanel">
							<div class="col-md-12 pt-3">
								<h5 class="text-capitalize mb-0">Deskripsi Template</h5>
								<p>ajshdajshjdkah</p>
							</div>
						</div>

						<div class="tab-pane" id="info" role="tabpanel">
							<div class="col-md-12 pt-3">
								<h5 class="text-capitalize mb-0">Deskripsi Template</h5>
								<p>ajshdajshjdkah</p>
							</div>
						</div>

						<div class="tab-pane" id="status" role="tabpanel">					
							
							<section id="cd-timeline" class="cd-container">
								<div class="cd-timeline-block">
									<div class="cd-timeline-img {{ $status_doc >= 0 ? 'cd-active' : '' }}">
									</div> <!-- cd-timeline-img -->

									<div class="cd-timeline-content {{ $status_doc >= 0 ? '' : 'disabled' }}">
										<h4>1. Dalam Proses</h4>
										<p>Published By: John Doe<br>12 Dec 2017</p>
									</div> <!-- cd-timeline-content -->
								</div> <!-- cd-timeline-block -->

								<div class="cd-timeline-block">
									<div class="cd-timeline-img {{ $status_doc >= 1 ? 'cd-active' : 'cd-disabled' }}">
									</div> <!-- cd-timeline-img -->

									<div class="cd-timeline-content {{ $status_doc >= 1 ? '' : 'disabled' }}">
										<h4>2. Draft</h4>
										<p>Published By: John Doe<br>13 Dec 2017</p>
									</div> <!-- cd-timeline-content -->
								</div> <!-- cd-timeline-block -->

								<div class="cd-timeline-block">
									<div class="cd-timeline-img {{ $status_doc >= 2 ? 'cd-active' : 'cd-disabled' }}">
									</div> <!-- cd-timeline-img -->

									<div class="cd-timeline-content {{ $status_doc >= 2 ? '' : 'disabled' }}">
										<h4>3. Renvoi</h4>
										<p>Published By: John Doe<br>16 Dec 2017</p>
									</div> <!-- cd-timeline-content -->
								</div> <!-- cd-timeline-block -->

								<div class="cd-timeline-block">
									<div class="cd-timeline-img {{ $status_doc >= 3 ? 'cd-active' : 'cd-disabled' }}">
									</div> <!-- cd-timeline-img -->

									<div class="cd-timeline-content {{ $status_doc >= 3 ? '' : 'disabled' }}">
										<h4>4. Minuta</h4>
										<p>Not Published Yet</p>
									</div> <!-- cd-timeline-content -->
								</div> <!-- cd-timeline-block -->

								<div class="cd-timeline-block">
									<div class="cd-timeline-img {{ $status_doc >= 4 ? 'cd-active' : 'cd-disabled' }}">
									</div> <!-- cd-timeline-img -->

									<div class="cd-timeline-content {{ $status_doc >= 4 ? '' : 'disabled' }}">
										<h4>5.Akta</h4>
										<p>Not Published Yet</p>
									</div> <!-- cd-timeline-content -->
								</div> <!-- cd-timeline-block -->

							</section> <!-- cd-timeline -->					

						</div>
					</div>
			
					{{--
					<div class="panel">
						<p class="text-capitalize text-muted">Status : <span>{{ str_replace('_', ' ', $page_datas->datas['status']) }}</span></p>
						<p class="text-center mb-3"><i class="fa fa-exclamation-triangle"></i> underconsturction</p>
						<ol>
							<li>Template yg dipakai</li>
							<li>tgl terakhir disunting</li>
						</ol>
					</div>
					--}}
			</div>				
		</div>

		{{-- simpanan untuk kedepan --}}
		{{-- <div style="background:transparent;">
			<div class="dropdown float-right" style="margin-right: -1.5rem;">
				<a href="#" class="dropdown-toggle unlock" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-lock="{{ $value['lock'] }}" style="text-decoration: none;">
					<i class="fa fa-lock" style=""></i>
				</a>
				<ul class="dropdown-menu pt-0 dropdown-menu-right" style="width: 340px;">
					<li class="dropdown-header pl-3 pr-3" style="font-size: 1em;">Employee</li>
					<li class="dropdown-item pl-3 pr-3">
						<input type="text" class="form-control form-control-sm" placeholder="search employee">
					</li>
					<li class="dropdown-divider"></li>
					<li class="dropdown-item pl-3 pr-3">
						Anna Wong, SH (Me) <a href="#" class="float-right mt-1"><i class="fa fa-square"></i></a>
					</li>
					<li class="dropdown-divider"></li>
					<li class="dropdown-item pl-3 pr-3">
						Sholeh Parwoto, SH <a href="#" class="float-right mt-1"><i class="fa fa-square"></i></a>
					</li> 
					<li class="dropdown-item pl-3 pr-3">
						Anton Muhammad Kalkun, SH <a href="#" class="float-right mt-1"><i class="fa fa-square"></i></a>
					</li> 
					<li class="dropdown-item pl-3 pr-3">
						Suberi Hebaton, SH <a href="#" class="float-right mt-1"><i class="fa fa-square"></i></a>
					</li> 
					<li class="dropdown-item pl-3 pr-3">
						Ahmaoo Eh Mahmed, SH <a href="#" class="float-right mt-1"><i class="fa fa-square"></i></a>
					</li> 
				</ul>
			</div>
			{!!$value['konten']!!}
		</div> --}}

	@component('components.modal', [
		'id'		=> 'finalize',
		'title'		=> 'Ubah status dokumen ke final?',
		'settings'	=> [
			'modal_class'	=> '',
			'hide_buttons'	=> 'true',
			'hide_title'	=> 'true',
		]
	])
		<form id="finalize_akta" class="form-widgets text-right form" action="{{ route('akta.akta.status', ['id' => $page_datas->datas['id'], 'status' => 'akta']) }}" method="POST">
			<fieldset class="from-group">
				<span class="label label-default" style="float: left;">Nomor Akta</span>
				<input type="text" name="nomor_akta" class="form-control parsing set-focus" required />
				<textarea class="input_akta" name="template" hidden></textarea>
			</fieldset>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button id="finalize_ok" type="button" class="btn btn-primary" data-save="true">Ok</button>
				<button id="finalize_submit" type="submit" data-save="true" hidden>save</button>
			</div>
		</form>	
	@endcomponent


	@component('components.modal', [
			'id'		=> 'content_',
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
			<div class="cd-timeline-block">
				<div class="cd-timeline-img large {{ $status_doc >= 0 ? 'cd-active' : '' }}">
				</div> 

				<div class="cd-timeline-content pt-0 {{ $status_doc >= 0 ? '' : 'disabled' }}" style="width:100%; left:35px;">
					<p>12 Dec 2017<br><small>By: John Doe</small></p>

					<div class="pb-2 pt-2">
						ini text apa aja lahha asdhashdah
					</div>

					<hr style="border-bottom: 1px solid rgba(0,0,0,.07)!important;">
				</div> 
			</div> 

			<div class="cd-timeline-block">
				<div class="cd-timeline-img large {{ $status_doc >= 0 ? 'cd-active' : '' }}">
				</div> 

				<div class="cd-timeline-content pt-0 {{ $status_doc >= 0 ? '' : 'disabled' }}" style="width:100%; left:35px;">
					<p>14 Dec 2017<br><small>By: John Doe</small></p>

					<div class="pb-2 pt-2">
						ini text apa aja lahha
					</div>

					<hr style="border-bottom: 1px solid rgba(0,0,0,.07)!important;">
				</div> 
			</div> 

		</section> 		
		</div>						
	@endcomponent		


	@include('components.deleteModal',[
		'title' => 'Menghapus Akta',
		'route' => route('akta.akta.destroy', ['id' => $page_datas->datas['id']])
	])

@stop

@push('scripts')

	/*	Call plugin */
	window.formUI.init();

	/* Finalize */ 
	$('#finalize_ok').click(function( event ) {
		event.preventDefault();

		// get original text
		$('.editor').html($('.editor-hidden').html())

		// draw stripes
	    window.stripeGenerator.init();

	    // get document
	    var target = $('#finalize_akta').find('textarea');
	    $(target).val($('.editor').html());

	    // submit
	    $('#finalize_submit').click();

	});

	/*	Start Lock */
	    window.lockedUnlockedParagraphUI.init();
	/*	End Lock */

	{{-- 
	/* Auto Page Break */
	$(document).ready(function(){
		/* Adapter */
		var editor = $('.editor');
		var page_editor = $('.page-editor');

		var ep = editorPaging;
		ep.pageHeight =  editorPaging.convertPX(29.7);
		ep.autoAdjustHeight(page_editor, editorPaging.convertPX(2), editor, 0);
	});
	--}}

	/* Script call modal delete */
	$('#deleteModal').on('shown.bs.modal', function(e) {
		window.formUI.setFocus();
	});

	/* Footer Generator */
	function drawFooter(){
		// init
		var pivot_pos = $('.page-editor').offset();
		var pivot_h = $('.page-editor').outerHeight();
		var pivot_w = $('.page-editor').width() - 4;
		var template_h = window.footerGenerator.convertPX(29.7);
		var margin_document = 47;

		var footer = window.footerGenerator;
		var ml = pivot_pos.left - margin_document - 4;
		var mr = pivot_pos.left + pivot_w - footer.convertPX(1)  + 2;
		var mt = 16 + footer.convertPX(2) - 2;
		var mb = template_h - (footer.convertPX(2) + footer.convertPX(3) - 16);

		footer.docLeft = $('.page-editor').children().offset().left;
		footer.docWidth = pivot_w;
		footer.docHeight = pivot_h;
		footer.pageHeight = template_h;

		footer.title = '{{ $page_datas->notaris["nama"] }}';
		footer.content1 = '{{"Daerah Kerja " . $page_datas->notaris["notaris"]['daerah_kerja'] }}';
		footer.content2 = '';

		footer.target = $('.editor');

		footer.display(mb);

	}	
	function reDrawFooter(){
		var footer = window.footerGenerator;
		footer.docLeft = $('.page-editor').children().offset().left;

		footer.updateDisplay();
	}

	// Tooltips
	$(document).ready(function() {
	    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
	});

@endpush 