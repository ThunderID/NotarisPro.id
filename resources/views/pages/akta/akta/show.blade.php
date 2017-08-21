<div class="col-12 subset-menu" style="width:100vw;">
	<div class="row">

		@include('components.submenu', [
			'title' 		=> "Judul Akta",
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
			
			<div id="page-loader" class="loader" style="width: calc(100vw - 297px); background: #000;opacity: 0.8; height:100%; position: absolute;">
				<h4 style=" width: 272px;height: 57px;position: absolute;top: 50%;left: 50%;margin: -28px 0 0 -25px;transform:translateX(-20%);"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Memuat</h4>'
			</div>
			<div class="d-flex justify-content-center mx-auto">
				<div id="page-content" class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 3cm; padding-left: 5cm; padding-right: 1cm;">
					<div id="text-editor" class="form-group editor">	
					</div>
				</div>
			</div>			
		</div>

		<div class="hidden-sm-down sidebar sidebar-right subset-2menu" style="width: 297px;">

			<div id="sidebar-header" class="col-12 pt-2 pb-2">
				<h5 id="title">
					<b>Judul Akta</b>
				</h5>

				<div class="row">
					<div class="col-12">
						<h6>
							<a href="#" class="text-primary">
								<span class="fa-stack">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</span>
								Sunting
							</a>
						</h6>
						<h6>
							<a href="#" class="text-primary">
								<span class="fa-stack">
									<i class="fa fa-copy"></i>
								</span>
								Salin & Sunting
							</a>
						</h6>
						<h6>
							<a href="#" class="text-primary disabled-before-load disabled">
								<span class="fa-stack">
									<i class="fa fa-print" aria-hidden="true"></i>
								</span>
								Cetak
							</a>							
						</h6>
						<h6>
							<a href="#" data-toggle="modal" data-target="#deleteModal" class="text-danger">
								<span class="fa-stack">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</span>
								Hapus
							</a>				
						</h6>
					</div>
				</div>
			</div>

			<div id="sidebar-loader" class="col-12 pt-3 pb-2 loader">
				<h6 class="mb-0">
					<i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;<b>Memuat</b>
				</h6>
			</div>

			<div id="sidebar-content" class="hide-before-load" style="display: none;">
				<div class="col-12 pt-3 pb-2" >
					<h5 class="mb-0">
						<b>Informasi</b>
					</h5>

					<div class="row">
						<div class="col-12">
							<h7 class="text-muted">Status Akta</h7>
							<h6 id="status_akta">_</h6>
						</div>
					</div>				

					<div class="row">
						<div class="col-12">
							<h7 class="text-muted">Pihak</h7>
							<div id="pihak">
									<h6 id="template" hidden></h6>
							</div>
						</div>
					</div>	

					<div class="row">
						<div class="col-12">
							<h7 class="text-muted">Dibuat Pada</h7>
							<h6 id="tanggal_pembuatan">17 Agustus 2016</h6>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<h7 class="text-muted">Oleh</h7>
							<h6 id="penulis">John Dai</h6>
						</div>
					</div>								

					<div class="row">
						<div class="col-12">
							<h7 class="text-muted">Sunting Terakhir</h7>
							<h6 id="tanggal_sunting">17 Agustus 2016</h6>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<h7 class="text-muted">Versi Akta</h7>
							<h6 id="versi">1</h6>
						</div>
					</div>
				</div>

				<div id="kelengkapan" class="col-12 pt-3 pb-0">
					<h5>
						<b>Kelengkapan Dokumen Akta</b>
					</h5>

					<div hidden>
						<div id="template-judul" class="col-12">
							<h6 id="title" class="mb-1" style='font-weight: 100;'>
								Pihak 
							</h6>
						</div>					
						<div id="template-dokumen-ok" class="col-12">
							<h6 class="mb-0">
								<span class="fa-stack">
									<i class="fa fa-check-square-o" aria-hidden="true"></i>
								</span>
								<span id="dokumen">
									_
								</span>
							</h6>
						</div>
						<div id="template-dokumen-not-ok" class="col-12">
							<h6 class="mb-0">
								<span class="fa-stack">
									<i class="fa fa-square-o" aria-hidden="true"></i>
								</span>
								<span id="dokumen">
									_
								</span>
							</h6>
						</div>	
						<div id="template-spacer" class="col-12 mb-1 mt-1">
							<div class="row clearfix">
							</div>
						</div>
					</div>				

					<div id="content" class="row">
					</div>

				</div>

				<div class="col-12 pt-3 pb-2">
					<h5 class="mb-0">
						<b>Histori Status</b>
					</h5>

					<div class="row">
						<div class="col-12">
							<h7 class="text-muted">12 Agustus 2017</h7>
							<h6 class="mb-1">Renvoi</h6>
							<h6>Mr. Bo</h6>
						</div>
					</div>	

					<div class="row">
						<div class="col-12">
							<h7 class="text-muted">10 Agustus 2017</h7>
							<h6 class="mb-1">Draft</h6>
							<h6>Mr. Dal</h6>
						</div>
					</div>				

				</div>	

				<div class="col-12 pt-3 pb-2">

					<div class="row clearfix"></div>

				</div>
			</div>	
		</div>

	</div>
</div>

@section('modal')
	@include('components.deleteModal',[
		'title' => 'Menghapus Akta',
		'route' => route('akta.akta.index')
	])
@stop


@push('scripts')

	/* Start UI page */
	function showAkta(e){
		// global vars
		var element_source = $(e);
		var id = element_source.attr('data_id_akta');
		var judul = element_source.find('#judul').text(); 

		modulShowAkta(id, judul);
	}

	function hideAkta(e){
		$('#akta_show').fadeOut('fast', function(){
			$('#text-editor').empty();
			window.history.pushState(null, null, '/akta/akta');
		});		
	}

	function modulShowAkta(id, judul){
		// fuse
		if(judul == null){
			judul = 'Loading ...';
		}

		// sets url
		window.history.pushState(null, null, '/akta/akta/' + id);

		// set val
		setAktaShow(id);

		/* re-init */
		// sidebar-header
		var sh = $(document.getElementById('sidebar-header'));
		sh.find('#title').text(judul);

		// reset state
		$('.loader').show();
		$('.disabled-before-load').addClass("disabled");
		$('.hide-before-load').hide();

		// ui display
		$('#akta_show').fadeIn('fast');
		$('#akta_show').find('#judul_akta').text(judul);
	}

	/* End UI page */


	/* Start Set Akta Show */
	function setAktaShow(id_akta){
		var url = '{{route('akta.ajax.show', ['id' => null])}}/' + id_akta;
		var ajax_akta = window.ajax;

		ajax_akta.defineOnSuccess(function(resp){
			console.log(resp);
			// re-set judul
			$(document.getElementById('sidebar-header')).find('#title').text(resp.judul);
			$('#akta_show').find('#judul_akta').text(resp.judul);

			// sidebar-content			
			var sc = $(document.getElementById('sidebar-content'));
			sc.find('#status_akta').text(window.stringManipulator.toDefaultReadable(resp.status));
			var tmplt = sc.find('#pihak').find('#template');
			$('.pihak').remove();
			resp.pemilik.klien.forEach(function(element) {
				rslt = $(tmplt).clone().appendTo(sc.find('#pihak'));
				rslt.text(element.nama);
				rslt.removeAttr('hidden');
				rslt.addClass('pihak');
			});
			sc.find('#tanggal_pembuatan').text(resp.tanggal_pembuatan);
			sc.find('#penulis').text(resp.penulis.nama);
			sc.find('#tanggal_sunting').text(resp.tanggal_sunting);
			sc.find('#versi').text(resp.versi);

			// kelengkapan dokumen
			var k = $(document.getElementById('kelengkapan'));
			k.find('#content').empty();

			$.map(resp.incomplete.pihak, function(value, index) {
				tmp = k.find('#template-judul');
				target = tmp.clone().appendTo(k.find('#content'));
				target.find('#title').text(tmp.find('#title').text() + ' ' + index);
				target.removeAttr('id');

				$.map(value, function(val, key) {
					if(val == false){
						tmp = k.find('#template-dokumen-not-ok');
						target = tmp.clone().appendTo(k.find('#content'));
						target.find('#dokumen').text(key);
						target.removeAttr('id');
					}else{
						tmp = k.find('#template-dokumen-ok');
						target = tmp.clone().appendTo(k.find('#content'));
						target.find('#dokumen').text(key);
						target.removeAttr('id');
					}
				});

				tmp = k.find('#template-spacer');
				target = tmp.clone().appendTo(k.find('#content'));
				target.removeAttr('id');				
			});

			// editor
			resp.paragraf.forEach(function(element) {
				$('#text-editor').append(element.konten);
			});
			$('#page').scrollTop(0);

			// ui on complete
			$('.disabled-before-load').removeClass("disabled");
			$('.loader').fadeOut('fast', function(){
				$('.hide-before-load').fadeIn();
			});

		});
		ajax_akta.defineOnError(function(resp){
			console.log("Can't get akta data. Retrying");
			setAktaShow(id_akta);
		});

		ajax_akta.get(url);
	}
	/* End Get Akta Data */

	/* Start URL Page Manager */
	$(window).on('popstate', function() {
		managePage();
	});

	@if($page_datas->id != null)
		managePage();
	@endif

	function managePage(){
		var id = window.location.pathname.replace('/akta/akta', '');
		if(id != ""){
			id = id.replace('/', '');
			modulShowAkta(id, null);
		}else{
			hideAkta(null);
		}
	}

	/* End URL Page Manager */

@endpush