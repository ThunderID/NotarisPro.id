@extends('templates.basic')

@push('styles')  
@endpush  

@section('akta')
	active
@stop

@section('data-akta')
	active
@stop

@section('content')
	
		<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				{{-- COMPONENT MENUBAR --}}
				<div class="row bg-faded">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pl-0">
						<ul class="nav menu-content justify-content-start">
							<li class="nav-item">
								<a class="nav-link" href="{{ route('akta.akta.index') }}"><i class="fa fa-angle-left"></i> &nbsp;Kembali</a>
							</li>
							@if(str_is($page_datas->datas['status'], 'pengajuan'))
								@if($page_datas->datas['total_perubahan'] * 1 == 0)
									<li class="nav-item">
										<span class="nav-link">Status : Menunggu Renvoi</span>
									</li>
								@else
									<li class="nav-item">
										<span class="nav-link">Status : Renvoi ke - {{$page_datas->datas['total_perubahan']}}</span>
									</li>
								@endif
							@endif
						</ul>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pr-0">
						<ul class="nav menu-content justify-content-end">
							@if(str_is($page_datas->datas['status'], 'draft'))
							<li class="nav-item">
								<a class="nav-link text-danger" href="" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Hapus</a>
							</li>
						
							<li class="nav-item">
								<a class="nav-link" href="{{route('akta.akta.edit', ['id' => $page_datas->datas['id']])}}" ><i class="fa fa-pencil"></i> Edit</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="{{route('akta.akta.status', ['id' => $page_datas->datas['id'], 'status' => 'pengajuan'])}}" ><i class="fa fa-check"></i> Publish</a>
							</li>
							@elseif(str_is($page_datas->datas['status'], 'pengajuan'))
							<li class="nav-item">
								<a class="nav-link" href="{{route('akta.akta.versioning', ['akta_id' => $page_datas->datas['id']])}}" ><i class="fa fa-history"></i> History Revisi</a>
							</li>
								@if(str_is(acl_active_office['role'], 'notaris'))
								<li class="nav-item">
									<a class="nav-link" href="{{route('akta.akta.status', ['id' => $page_datas->datas['id'], 'status' => 'akta'])}}" ><i class="fa fa-file"></i> Final</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="{{route('akta.akta.status', ['id' => $page_datas->datas['id'], 'status' => 'renvoi'])}}" ><i class="fa fa-check"></i> Renvoi</a>
								</li>
								@endif
							@elseif(str_is($page_datas->datas['status'], 'renvoi'))
							<li class="nav-item">
								<a class="nav-link" href="{{route('akta.akta.edit', ['id' => $page_datas->datas['id']])}}" ><i class="fa fa-pencil"></i> Edit</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="{{route('akta.akta.status', ['id' => $page_datas->datas['id'], 'status' => 'pengajuan'])}}" ><i class="fa fa-check"></i> Publish</a>
							</li>							
							@endif
						</ul>
					</div>
				</div>
				{{-- END COMPONENT MENUBAR --}}
			</div>
			<div id="page" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scrollable_panel subset-2menu">
				<div id="page-breaker" class="row page-breaker"></div>
				<div class="row">
					<div class="d-flex justify-content-center" style="margin: 0 auto;">
						<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 0cm; padding-left: 5cm; padding-right: 1cm;">
							<div class="form-group editor">
								@foreach($page_datas->datas['paragraf'] as $key => $value)
									@if(str_is(acl_active_office['role'], 'notaris') && $page_datas->datas['status']=='pengajuan')
										@if(isset($value['unlock']) && $value['unlock'])
											<div id="lock-div-{{$value['lock']}}" class="bg-success-shade">
												<a href="#" style="text-decoration:none; color:inherit;" class="lock" data-lock="{{$value['lock']}}">
												<i id="{{$value['lock']}}" class="fa fa-unlock-alt text-success" style="float:right;"></i>
												{!!$value['konten']!!}
												</a>
											</div>
										@else
											<div id="lock-div-{{$value['lock']}}" >
												<a href="#" style="text-decoration:none; color:inherit;" class="lock" data-lock="{{$value['lock']}}">
													<i id="{{$value['lock']}}" class="fa fa-lock" style="float:right;"></i>
													{!!$value['konten']!!}
												</a>
											</div>
										@endif
									@else
										{!!$value['konten']!!}
									@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>
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

	@include('components.deleteModal',[
		'title' => 'Menghapus Draft Akta',
		'route' => route('akta.akta.destroy', ['id' => $page_datas->datas['id']])
	])
@stop

@push('styles')
	.bg-success-shade {
		background-color: #EAFFEA;
	}
@endpush 

@push('scripts')
	/*	Start Lock */
	$(function () {
	    $('.lock').on('click', function () {
	        var lock = $(this).attr("data-lock");
	        $.ajax({
	            url: "{{route('akta.akta.tandai.renvoi', $page_datas->datas['id'])}}",
	            data: {
	                lock: lock
	            },
	            dataType : 'json'
	        });

		    if ( document.getElementById(lock).classList.contains('fa-lock') )
		    {
			    document.getElementById(lock).classList.remove('fa-lock');
				document.getElementById(lock).classList.add('fa-unlock-alt');
				document.getElementById(lock).classList.add('text-success');
				document.getElementById('lock-div-'+lock).classList.add('bg-success-shade');
		    }
			else	    
		    {
				document.getElementById(lock).classList.remove('fa-unlock-alt');
				document.getElementById(lock).classList.remove('text-success');
			    document.getElementById(lock).classList.add('fa-lock');
				document.getElementById('lock-div-'+lock).classList.remove('bg-success-shade');
		    }
	    });

	});
	/*	End Lock */

	/*	Call plugin */
	window.formUI.init();

	/* Auto Page Break */
	$(document).ready(function(){
		/* Adapter */
		var editor = $('.editor');
		var page_editor = $('.page-editor');

		var ep = editorPaging;
		ep.pageHeight =  editorPaging.convertPX(29.7);
		ep.autoAdjustHeight(page_editor, editorPaging.convertPX(2), editor, 0);
	});

	/* Script call modal delete */
	$('#deleteModal').on('shown.bs.modal', function(e) {
		window.formUI.setFocus();
	});
@endpush 