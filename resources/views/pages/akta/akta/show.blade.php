<div class="col-12 subset-menu" style="width:100vw;">
	<div class="row">

		@include('components.submenu', [
			'title' 		=> "...",
			'menus' 		=> [
					[
						"title" 			=> "",		
						"route" 			=> "javascript:sidebarManagement();",
						"class" 			=> "akta_close mr-2 show-smaller-paper disabled",
						"icon"				=> "fa-info",
						"id" 				=> "trigger-info-sidebar"
					],			
					[
						"title" 			=> "",		
						"route" 			=> "javascript:hideAkta();",
						"icon" 				=> "fa-times",
						"class" 			=> "akta_close"
					],
			]
		])
	</div>

	<div class="row subset-2menu full-on-mobile" style="background-color: rgba(0, 0, 0, 0.075);">


		<div id="page" class="scrollable_panel">
			
			<div id="page-loader" class="loader">
				<h4 class="show-before-load">
					<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Memuat
				</h4>
				<h4 class="show-on-error" style="display: none;">
					<a href="javascript:void(0);" onClick="retrySetAktaShow();">
						<i class="fa fa-refresh" aria-hidden="true"></i> Coba Lagi
					</a>
				</h4>
			</div>
			<div class="d-flex justify-content-center mx-auto page-frame">
				<div id="page-content" class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 3cm; padding-left: 5cm; padding-right: 1cm;">
					<div id="text-editor" class="form-group editor">

						<div id="template" hidden>
							<div class="wrapper unlocked">
								<div class="control">
									<a href="javascript:void(0);" class="lock" id="lock">
										<i class="fa fa-unlock" aria-hidden="true"></i>
									</a>
									&nbsp;|&nbsp;
									<a href="javascript:void(0);" id="revise" class="" data-toggle="modal" data-target="">
										<i class="fa fa-history" aria-hidden="true"></i>1
									</a>
								</div>
								<div id="narasi" class="content">
								</div>
							</div>
						</div>

						<div id="content" class="hidden-print">
						</div>

						<div id="reader" class="show-print" style="display: none;">
						</div>

					</div>
				</div>
			</div>			
		</div>

		<div id="sidebar-info" class="sidebar sidebar-right subset-2menu" style="width: 297px;">

			<div id="sidebar-header" class="col-12 pt-2 pb-2">
				<h5>
					<b id="title">...</b>
					<span class="float-right pr-1 show-smaller-paper">
						<small>
							<a href="javascript:void(0);" onclick="javascript:sidebarManagement();" style="font-weight: 100;">
								<span aria-hidden="true" style="font-size: 20px;">&times;</span>
							</a>
						</small>
					</span>
				</h5>

				<div class="row">
					<div class="col-12">
						<h6>
							<a id="link-reader" href="javascript:void(0);" onClick="triggerReaderMode(this);" data-url="#" class="text-primary disabled-before-load disabled">
								<span class="fa-stack">
									<i class="fa fa-bullseye" aria-hidden="true"></i>
								</span>
								Mode Baca : 
								<span id="status">Tidak Aktif</span>
							</a>
						</h6>					
						<h6>
							<a id="link-edit" href="javascript:void(0);" onClick="triggerOpenWindow(this);" data-url="#" class="text-primary">
								<span class="fa-stack">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</span>
								Sunting
							</a>
						</h6>
						<h6>
							<a id="link-edit-as-copy" href="javascript:void(0);" onClick="triggerOpenWindow(this);" data-url="#" class="text-primary disabled">
								<span class="fa-stack">
									<i class="fa fa-copy"></i>
								</span>
								Salin & Sunting
							</a>
						</h6>
						<h6>
							<a id="link-print" href="javascript:void(0);" onclick="triggerPrint();" class="text-primary disabled">
								<span class="fa-stack">
									<i class="fa fa-print" aria-hidden="true"></i>
								</span>
								Cetak
							</a>							
						</h6>
						<h6>
							<a href="javascript:void(0);" link="link-delete" data-url="#" data-toggle="modal" data-target="#deleteModal" class="text-danger">
								<span class="fa-stack">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</span>
								Hapus
							</a>
						</h6>
					</div>
				</div>
				<div id="menu-keterangan" class="row" hidden>
					<div class="col-12">
						<h7>* Beberapa menu tidak tersedia pada akta dengan status ini.</h7>
					</div>				
				</div>				
			</div>

			<div id="sidebar-loader" class="col-12 pt-3 pb-2 loader">
				<h6 class="mb-0 show-before-load">
					<i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;<b>Memuat</b>
				</h6>
				<h6 class="mb-0 show-on-error" style="display: none;">
					Tidak dapat mengambil data!<br><br><small>Pastikan Anda dapat terhubung dengan internet dan cobalah beberapa saat lagi. Bila masalah ini terus berlanjut, silahkan hubungi Costumer Service kami untuk mendapatkan bantuan.</small>
				</h6>
				<h6 class="pt-2 show-on-error" style="display: none;">
					<small>Kode Error: <span id="loader-error-code">500</span></small>
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

				<div id="kelengkapan" class="col-12 pt-3 pb-1">
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
								</span>
							</h6>
						</div>
						<div id="template-dokumen-not-ok" class="col-12">
							<h6 class="mb-0">
								<span class="fa-stack">
									<i class="fa fa-square-o" aria-hidden="true"></i>
								</span>
								<span id="dokumen">
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

				<div id="riwayat_status" class="col-12 pt-3 pb-2">
					<h5 class="mb-0">
						<b>Histori Status</b>
					</h5>

					<div hidden>
						<div class="row">
							<div class="col-12" id="template-riwayat-status">
								<h7 id="template-tanggal" class="text-muted"></h7>
								<h6 id="template-status" class="mb-1"></h6>
								<h6 id="template-editor" style="font-weight: 100;"></h6>
							</div>
						</div>
					</div>

					<div id="content" class="row">
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
		// init template
		//sidebar
		if($( window ).width() > '793'){
			showSidebar();
			$(document.getElementById('trigger-info-sidebar')).addClass('disabled');
		}

		// global vars
		var element_source = $(e);
		var id = element_source.attr('data_id_akta');
		var judul = element_source.find('#judul').text();

		// sets action 
		setEdit(element_source.attr('data_id_akta'));
		$(document.getElementById('deleteModal')).find('form').attr('action', window.location.href + '/' + element_source.attr('data_id_akta'));

		var status = element_source.find('#status').text();

		// policy edit as copy
		var display_keterangan = false;
		if(canEditAsCopy(status)){
			setEditAsCopy(element_source.attr('data_id_akta'));
			$(document.getElementById('link-edit-as-copy')).removeClass('disabled');
		}else{
			$(document.getElementById('link-edit-as-copy')).addClass('disabled');
			display_keterangan = true;
		}

		// policy print
		if(canPrint(status)){
			$(document.getElementById('link-print')).removeClass('disabled');
		}else{
			$(document.getElementById('link-print')).addClass('disabled');
			display_keterangan = true;
		}

		// policy Global
		if(display_keterangan == true){
			$(document.getElementById('menu-keterangan')).removeAttr('hidden');
		}else{
			$(document.getElementById('menu-keterangan')).attr('hidden', true);
		}

		modulShowAkta(id, judul);
	}

	function hideAkta(e){
		$(document.getElementById('akta_show')).fadeOut('fast', function(){
			var target = $(document.getElementById('text-editor'));
			target.find('#reader').empty();
			target.find('#content').empty();
			window.history.pushState(null, null, '/akta/akta');
		});		
	}

	function modulShowAkta(id, judul){
		// fuse
		if(judul == null){
			judul = '...';
		}

		// sets url
		window.history.pushState(null, null, '/akta/akta/' + id);

		// set val
		setAktaShow(id);

		/* re-init */
		// sidebar-header
		sh = $(document.getElementById('sidebar-header'));
		sh.find('#title').text(judul);

		// reset state
		$('.loader').show();
		$('.disabled-before-load').addClass("disabled");
		$('.hide-before-load').hide();
		$('.show-before-load').show();
		$('.show-on-error').hide();

		// ui display
		$(document.getElementById('akta_show')).fadeIn('fast');
		$(document.getElementById('akta_show')).find('#title').text(judul);
	}
	/* End UI page */


	/* Start Set Akta Show */
	function setAktaShow(id_akta){
		var url = '{{route('akta.ajax.show', ['id' => null])}}/' + id_akta;
		var ajax_akta = window.ajax;

		ajax_akta.defineOnSuccess(function(resp){
			//console.log(resp);
			try {

				// reloaded or from index
				if($(document.getElementById('sidebar-header')).find('#title').text() == '...'){
					// re-set actions
					setEdit(id_akta);

					let display_keterangan = false;

					//edit as copy
					if(canEditAsCopy(resp.status)){
						setEditAsCopy(id_akta);
						$(document.getElementById('link-edit-as-copy')).removeClass('disabled');
					}else{
						display_keterangan = true;
					}

					// policy print
					if(canPrint(resp.status)){
						$(document.getElementById('link-print')).removeClass('disabled');
					}else{
						display_keterangan = true;
					}

					// policy Global
					if(display_keterangan == true){
						$(document.getElementById('menu-keterangan')).removeAttr('hidden');
					}else{
						$(document.getElementById('menu-keterangan')).attr('hidden', true);
					}					

					$(document.getElementById('deleteModal')).find('form').attr('action', window.location.href );

					// re-set judul
					$(document.getElementById('sidebar-header')).find('#title').text(resp.judul);
					$(document.getElementById('akta_show')).find('#title').text(resp.judul);
				}


				// sidebar-content			
				var sc = $(document.getElementById('sidebar-content'));
				sc.find('#status_akta').text(window.stringManipulator.toDefaultReadable(resp.status));
				var tmplt = sc.find('#pihak').find('#template');
				$('.pihak').remove(); 
				if(resp.pemilik.klien){
					resp.pemilik.klien.forEach(function(element) {
						rslt = tmplt.clone().appendTo(sc.find('#pihak'));
						rslt.text(element.nama);
						rslt.removeAttr('hidden id');
						rslt.addClass('pihak');
					});
				}else{
					rslt = $(tmplt).clone().appendTo(sc.find('#pihak'));
					rslt.text('Belum ada data');
					rslt.removeAttr('hidden id');
					rslt.addClass('pihak');
				}

				sc.find('#tanggal_pembuatan').text(resp.tanggal_pembuatan);
				sc.find('#penulis').text(resp.penulis.nama);
				sc.find('#tanggal_sunting').text(resp.tanggal_sunting);
				sc.find('#versi').text(resp.versi);


				// kelengkapan dokumen
				var k = $(document.getElementById('kelengkapan'));
				k.find('#content').empty();

				if(resp.incomplete.pihak){
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
				}else{
					tmp = k.find('#template-judul');
					target = tmp.clone().appendTo(k.find('#content'));
					target.find('#title').text('Belum ada data');
					target.removeAttr('id');
				}


				// history status
				var rs = $(document.getElementById('riwayat_status'));
				rs.find('#content').empty();

				if(resp.riwayat_status){
					resp.riwayat_status.forEach(function(element) {
						tmp = rs.find('#template-riwayat-status');
						target = tmp.clone().appendTo(rs.find('#content'));
						target.find('#template-tanggal').text(element.tanggal);
						target.find('#template-status').text(window.stringManipulator.toDefaultReadable(element.status));
						target.find('#template-editor').text(element.editor.nama);
						target.removeAttr('id');
					});
				}else{
					tmp = rs.find('#template-riwayat-status');
					target = tmp.clone().appendTo(rs.find('#content'));
					target.find('#template-status').text('Belum ada data');
					target.removeAttr('id');
				}


				// editor
				let feature_lockUnlock = defaultLockUnlock(resp.status);
				let feature_lockDisplayRevision = defaultDisplayRevision(resp.status);

				resp.paragraf.forEach(function(element) {
					// reader mode
					$(document.getElementById('text-editor')).find('#reader').append(element.konten);
					
					// display + feature bundle
					var editor = $(document.getElementById('page')).find('#text-editor');
					tmp = editor.find('#template');
					var target = tmp.clone().appendTo(editor.find('#content'));
					target.removeAttr('hidden');
					target.removeAttr('id');
					target.find('#narasi').append(element.konten);

					// set status lock/unlock
					wrapper = target.find('.wrapper');
					lock = target.find('#lock');

					if(element.lock){
						wrapper.removeClass('unlocked');
						wrapper.addClass('locked');
						lock.find('.fa').removeClass('fa-unlock');
						lock.find('.fa').addClass('fa-lock');
						lock.attr('unlocked', 'false');
						lock.attr('id', element.lock);
					}else{
						wrapper.removeClass('locked');
						wrapper.addClass('unlocked');
						lock.find('.fa').addClass('fa-unlock');
						lock.find('.fa').removeClass('fa-lock');
						lock.attr('unlocked', 'true');
						lock.attr('id', null);
					}

					lock.addClass(feature_lockUnlock);

					// set status displayRevision

					target.find('#revise').addClass(feature_lockDisplayRevision);

				});
				$(document.getElementById('page')).scrollTop(0);


				// ui on complete
				$('.disabled-before-load').removeClass("disabled");
				$('.loader').fadeOut('fast', function(){
					$('.hide-before-load').fadeIn();
				});

			}
			catch(err){
				$('.show-before-load').hide();
				$('.show-on-error').show();
				$(document.getElementById('loader-error-code')).text('422');
			}
		});
		ajax_akta.defineOnError(function(resp){
			$('.show-before-load').hide();
			$('.show-on-error').show();
			$(document.getElementById('loader-error-code')).text(resp.status);
		});

		ajax_akta.get(url);
	}
	function retrySetAktaShow(){
		// sets ui
		$('.loader').show();
		$('.disabled-before-load').addClass("disabled");
		$('.hide-before-load').hide();
		$('.show-before-load').show();
		$('.show-on-error').hide();

		// get id_akta
		var id = window.location.pathname.replace('/akta/akta', '');
		id_akta = id.replace('/', '');

		// retry get akta
		setAktaShow(id_akta);
	}
	/* End Get Akta Data */


	/* Start Set Akta Feature */
	function defaultLockUnlock(val){
		var feature_status = 'disabled';
		if(canLockUnlock(val)){
			feature_status = 'active';
		}
		return feature_status;
	}
	function defaultDisplayRevision(val){
		var feature_status = 'disabled';
		if(canDisplayRevision(val)){
			feature_status = 'active';
		}
		return feature_status;
	}

	// manage lock unlock
	$(document).on('click', 'a.lock', function(){
		// do ajax save
		console.log($(this));
		handleState($(this));

		function handleState(e){
			if(e.attr('unlocked') == 'true'){
				console.log(1);
				e.closest('a.lock').attr('unlocked','false');
				e.closest('.wrapper').removeClass('unlocked');
				e.closest('.wrapper').addClass('locked');
				e.find('i').removeClass('fa-unlock');
				e.find('i').addClass('fa-lock');
			}else{
				console.log(2);
				e.closest('a.lock').attr('unlocked','true');
				e.closest('.wrapper').removeClass('locked');
				e.closest('.wrapper').addClass('unlocked');
				e.find('i').removeClass('fa-lock');
				e.find('i').addClass('fa-unlock');
			}
		}
	})
	/* End Get Akta Feature */


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


	/* Set Action Links */
	function  triggerReaderMode(e){
		var target = $(document.getElementById('page')).find('#text-editor');

		if($(e).find('#status').text() == 'Tidak Aktif'){
			$(e).find('#status').text('Aktif');
			target.find('#content').fadeOut('fast', function(){
				target.find('#reader').fadeIn('fast');
				$(document.getElementById('page')).scrollTop(0);
			});
		}else{
			$(e).find('#status').text('Tidak Aktif');
			target.find('#reader').fadeOut('fast', function(){
				target.find('#content').fadeIn('fast');
				$(document.getElementById('page')).scrollTop(0);
			});
		}
	}
	function setEdit(id_akta){
		var url = "{{ route('akta.akta.show', ['id' => null]) }}/" + id_akta + "/edit";
		$(document.getElementById('link-edit')).attr('data-url', url);
	}
	function setEditAsCopy(id_akta){
		var url = "{{ route('akta.akta.copy', ['id' => null]) }}/" + id_akta;
		$(document.getElementById('link-edit-as-copy')).attr('data-url', url);
	}
	function triggerOpenWindow(e){
		window.open( $(e).attr('data-url') , 'newwindow', 'width=1024,height=768');
	}
	function triggerPrint(){
		window.printElement.setElementPrint(document.getElementById('page-content'));
		window.printElement.print();
	}
	/* EndAction Links */


	/* Start Policies */
	// policy edit as copy
	function canEditAsCopy(val){
		if(val == 'salinan'){
			return true;
		}
		return false;
	}
	// policy print
	function canPrint(val){
		if(val == 'minuta' || val == 'salinan'){
			return true;
		}
		return false;
	}
	// policy lockUnlock
	function canLockUnlock(val){
		if(val == 'minuta'){
			return true;
		}
		return false;
	}
	// policy Revision
	function canDisplayRevision(val){
		if(val == 'minuta' || val == 'salinan'){
			return true;
		}
		return false;
	}	

	/* End Policies */


	/* Start Sidebar Function */
	function hideSidebar(){
		$(document.getElementById('sidebar-info')).attr('hidden','true');
	}
	function showSidebar(){
		$(document.getElementById('sidebar-info')).removeAttr('hidden');
	}
	function sidebarManagement(){
		if($(document.getElementById('sidebar-info')).attr('hidden')){
			$(document.getElementById('trigger-info-sidebar')).addClass('disabled');
			showSidebar();
		}else{
			$(document.getElementById('trigger-info-sidebar')).removeClass('disabled');
			hideSidebar();
		}
	}

	/* End Sidebar Function */

@endpush