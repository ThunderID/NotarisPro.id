@push ('header')
	<nav class="navbar navbar-dark navbar-expand-md bg-primary text default-primary-color d-flex align-items-center" style="height: 150px;">
		<a class="navbar-brand text-center text-lg-left text-xl-left" href="">
			<h2 class="text-primary-color mb-0">{{ $akta['judul'] }}</h2>
		</a>
		<a class="btn btn-outline-light ml-auto mr-3 bg" href="{{ route('akta.index') }}" onclick="javascript:sidebarManagement();" style="font-weight: 100; background-color: transparent">
			Kembali
		</a>
	</nav>
@endpush

@push ('main')
	<div class="row bg-secondary d-flex align-items-stretch" style="width:100vw;">
		<div class="col-9 bg-secondary pt-0">
			<div class="page bg-white mx-auto" style="width: 21cm; min-height: 29.7cm;"> 
				<div id="page-content" class="form mt-3 mb-3 font-editor page-editor" style="padding-top: 2cm; padding-bottom: 3cm; padding-left: 5cm; padding-right: 1cm;">
					@foreach ($akta['paragraf'] as $index => $value)
						<div id="content" class="hidden-print">
							<div>
								<div class="wrapper unlocked">
									<div class="control">
										<a href="javascript:void(0);" class="lock hold-on-load disabled" id="lock" unlocked="true">
											<i class="fa fa-fw fa-unlock" aria-hidden="true"></i>
										</a>
										<a href="javascript:void(0);" class="newline hold-on-load disabled" id="newline">
											<i class="fa fa-fw fa-plus" aria-hidden="true"></i>
										</a>
										<a href="javascript:void(0);" class="remove text-danger hold-on-load disabled" id="remove">
											<i class="fa fa-fw fa-times" aria-hidden="true"></i>
										</a>									
										<a href="javascript:void(0);" id="revise" class="revise active" data-toggle="modal" data-target="" data-idx="0">
											<i class="fa fa-fw fa-history" aria-hidden="true"></i><span id="ctr">1</span>
										</a>
									</div>
									<div id="narasi" class="content">
										{!! $value['konten'] !!}
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
		<div class="col-3 pr-0 bg-light">
			<div id="sidebar-info" class="sidebar sidebar-right subset-2menu">
				<div id="sidebar-header" class="col-12 pt-3 pb-2">
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
									Edit
								</a>
							</h6>
							<h6>
								<a id="link-edit-as-copy" href="javascript:void(0);" onClick="triggerOpenWindow(this);" data-url="#" class="text-primary disabled">
									<span class="fa-stack">
										<i class="fa fa-copy"></i>
									</span>
									Salin & Edit
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
								<h6 id="status_akta">{{ $akta['status'] }}</h6>
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
								<h6 id="tanggal_pembuatan">{{ $akta['created_at'] }}</h6>
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
								<h6 id="tanggal_sunting">{{ $akta['updated_at'] }}</h6>
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
						{{-- untuk data arsip--}}
						<p>Untuk arsip</p>
						{{-- <h5>
							<b>Kelengkapan Dokumen Akta</b>
						</h5> --}}

						{{-- <div hidden>
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
						</div>	 --}}			
{{-- 
						<div id="content" class="row">
						</div> --}}

					</div>

					<div id="riwayat_status" class="col-12 pt-3 pb-2">
						<h5 class="mb-0">
							<b>Histori Status</b>
						</h5>

						<div hidden>
							{{-- histori status --}}
							<p>untuk histori status</p>
							{{-- <div class="row">
								<div class="col-12" id="template-riwayat-status">
									<h7 id="template-tanggal" class="text-muted"></h7>
									<h6 id="template-status" class="mb-1"></h6>
									<h6 id="template-editor" style="font-weight: 100;"></h6>
								</div>
							</div> --}}
						</div>		
					</div>
					<div class="clearfix">&nbsp;</div>
				</div>	
			</div>
		</div>
	</div>
@endpush



{{-- use tag <script></script> --}}
@push('scripts')
	<script type="text/javascript">
		/* Start Set Akta Show */
		// function setAktaShow(id_akta){
		// 	var url = '/' + id_akta;
		// 	var ajax_akta = window.ajax;

		// 	ajax_akta.defineOnSuccess(function(resp){
		// 		// console.log(resp);
		// 		try {

		// 			// reloaded or from index
		// 			if($(document.getElementById('sidebar-header')).find('#title').text() == '...'){
		// 				// re-set actions
		// 				// setEdit(id_akta);

		// 				let display_keterangan = false;

		// 				//edit as copy
		// 				// if(canEditAsCopy(resp.status)){
		// 				// 	// setEditAsCopy(id_akta);
		// 				// 	$(document.getElementById('link-edit-as-copy')).removeClass('disabled');
		// 				// }else{
		// 				// 	display_keterangan = true;
		// 				// }

		// 				// policy print
		// 				// if(canPrint(resp.status)){
		// 				// 	$(document.getElementById('link-print')).removeClass('disabled');
		// 				// }else{
		// 				// 	display_keterangan = true;
		// 				// }

		// 				// policy Global
		// 				// if(display_keterangan == true){
		// 				// 	$(document.getElementById('menu-keterangan')).removeAttr('hidden');
		// 				// }else{
		// 				// 	$(document.getElementById('menu-keterangan')).attr('hidden', true);
		// 				// }					

		// 				$(document.getElementById('deleteModal')).find('form').attr('action', window.location.href );

		// 				// re-set judul
		// 				$(document.getElementById('sidebar-header')).find('#title').text(resp.judul);
		// 				$(document.getElementById('akta_show')).find('#title').text(resp.judul);
		// 			}


		// 			// sidebar-content			
		// 			var sc = $(document.getElementById('sidebar-content'));
		// 			sc.find('#status_akta').text(window.stringManipulator.toDefaultReadable(resp.status));
		// 			var tmplt = sc.find('#pihak').find('#template');
		// 			$('.pihak').remove(); 
		// 			if(resp.pemilik.klien){
		// 				resp.pemilik.klien.forEach(function(element) {
		// 					rslt = tmplt.clone().appendTo(sc.find('#pihak'));
		// 					rslt.text(element.nama);
		// 					rslt.removeAttr('hidden id');
		// 					rslt.addClass('pihak');
		// 				});
		// 			}else{
		// 				rslt = $(tmplt).clone().appendTo(sc.find('#pihak'));
		// 				rslt.text('Belum ada data');
		// 				rslt.removeAttr('hidden id');
		// 				rslt.addClass('pihak');
		// 			}

		// 			sc.find('#tanggal_pembuatan').text(resp.tanggal_pembuatan);
		// 			sc.find('#penulis').text(resp.penulis.nama);
		// 			sc.find('#tanggal_sunting').text(resp.tanggal_sunting);
		// 			sc.find('#versi').text(resp.versi);


		// 			// kelengkapan dokumen
		// 			var k = $(document.getElementById('kelengkapan'));
		// 			k.find('#content').empty();

		// 			if(resp.incomplete.pihak){
		// 				$.map(resp.incomplete.pihak, function(value, index) {
		// 					tmp = k.find('#template-judul');
		// 					target = tmp.clone().appendTo(k.find('#content'));
		// 					target.find('#title').text(tmp.find('#title').text() + ' ' + index);
		// 					target.removeAttr('id');

		// 					$.map(value, function(val, key) {
		// 						if(val == false){
		// 							tmp = k.find('#template-dokumen-not-ok');
		// 							target = tmp.clone().appendTo(k.find('#content'));
		// 							target.find('#dokumen').text(key);
		// 							target.removeAttr('id');
		// 						}else{
		// 							tmp = k.find('#template-dokumen-ok');
		// 							target = tmp.clone().appendTo(k.find('#content'));
		// 							target.find('#dokumen').text(key);
		// 							target.removeAttr('id');
		// 						}
		// 					});

		// 					tmp = k.find('#template-spacer');
		// 					target = tmp.clone().appendTo(k.find('#content'));
		// 					target.removeAttr('id');				
		// 				});
		// 			}else{
		// 				tmp = k.find('#template-judul');
		// 				target = tmp.clone().appendTo(k.find('#content'));
		// 				target.find('#title').text('Belum ada data');
		// 				target.removeAttr('id');
		// 			}


		// 			// history status
		// 			var rs = $(document.getElementById('riwayat_status'));
		// 			rs.find('#content').empty();

		// 			if(resp.riwayat_status){
		// 				resp.riwayat_status.forEach(function(element) {
		// 					tmp = rs.find('#template-riwayat-status');
		// 					target = tmp.clone().appendTo(rs.find('#content'));
		// 					target.find('#template-tanggal').text(element.tanggal);
		// 					target.find('#template-status').text(window.stringManipulator.toDefaultReadable(element.status));
		// 					target.find('#template-editor').text(element.editor.nama);
		// 					target.removeAttr('id');
		// 				});
		// 			}else{
		// 				tmp = rs.find('#template-riwayat-status');
		// 				target = tmp.clone().appendTo(rs.find('#content'));
		// 				target.find('#template-status').text('Belum ada data');
		// 				target.removeAttr('id');
		// 			}


		// 			// editor
		// 			let feature_lockUnlock = defaultLockUnlock(resp.status);
		// 			let feature_lockDisplayRevision = defaultDisplayRevision(resp.status);

		// 			window.dataBox.set('paragraf',resp.paragraf);
		// 			var tmp_ctr = [];
		// 			resp.paragraf.forEach(function(element, idx) {
		// 				// list or paragraph
		// 				var open_tag = element.konten.substring(0, 4);


		// 				// reader mode
		// 				if(element.konten){
		// 					var rslt = $(element.konten).appendTo($(document.getElementById('text-editor')).find('#reader'));

		// 					if(open_tag == '<ol>' || open_tag == '<ul>'){
		// 						tmp_ctr.push('list-' + tmp_ctr.length);
		// 						rslt.attr('id', 'reader-' + tmp_ctr[tmp_ctr.length - 1]);
		// 						rslt.children().attr('id', element.key);;
		// 					}else if(open_tag == '<li>'){
		// 						// move to proper place
		// 						var list_target = $('#reader-' + tmp_ctr[tmp_ctr.length - 1]);
		// 						var tmp_element = rslt.detach();
		// 						list_target.append(tmp_element);
		// 						rslt.attr('id', element.key);
		// 					}else{
		// 					}
		// 				}else{
		// 					var rslt = $('<p>&nbsp;</p>').appendTo($(document.getElementById('text-editor')).find('#reader'));
		// 					rslt.attr('id', element.key);
		// 				}
						
		// 				// display + feature bundle
		// 				var editor = $(document.getElementById('page')).find('#text-editor');
		// 				tmp = editor.find('#template');
		// 				var target = tmp.clone().appendTo(editor.find('#content'));
		// 				target.removeAttr('hidden');
		// 				target.removeAttr('id');


		// 				// list or paragraph
		// 				if(open_tag == '<ol>' || open_tag == '<ul>'){
		// 					// open
		// 					target.wrap(open_tag + open_tag.substring(0,1) + '/' + open_tag.substring(1,4));
		// 					var parent = target.closest(element.konten.substring(1,3));
		// 					parent.attr('id', 'list-' + (tmp_ctr.length - 1));
		// 					parent.attr('list-type', open_tag);
		// 					target.attr('data-index', '1');
		// 					target.addClass('list-data');
		// 					target.find('#narasi').append(element.konten.substring(4));
		// 				}else if(open_tag == '<li>'){
		// 					// list
		// 					list_target = $('#' + tmp_ctr[tmp_ctr.length - 1]);
		// 					target.find('#narasi').append(element.konten);
		// 					target.attr('data-index', list_target.children.length);
		// 					target.addClass('list-data');

		// 					// move to parent wrapper
		// 					var tmp_element = target.detach();
		// 					list_target.append(tmp_element);

		// 					//close
		// 					var closing_tag = element.konten.substr(element.konten.length - 5); 
		// 					if(closing_tag == "</ol>" || closing_tag == "</ul>"){
		// 						tmp_ctr.pop();
		// 					}
		// 				}else{
		// 					target.find('#narasi').append(element.konten);
		// 				}

		// 				// set status lock/unlock
		// 				wrapper = target.find('.wrapper');
		// 				lock = target.find('#lock');

		// 				if(element.lock){
		// 					wrapper.removeClass('unlocked');
		// 					wrapper.addClass('locked');
		// 					lock.find('.fa').removeClass('fa-unlock');
		// 					lock.find('.fa').addClass('fa-lock');
		// 					lock.attr('unlocked', 'false');
		// 				}else{
		// 					wrapper.removeClass('locked');
		// 					wrapper.addClass('unlocked');
		// 					lock.find('.fa').addClass('fa-unlock');
		// 					lock.find('.fa').removeClass('fa-lock');
		// 					lock.attr('unlocked', 'true');
		// 				}

		// 				lock.attr('key', element.key);
		// 				lock.attr('lock', element.lock);

		// 				lock.addClass(feature_lockUnlock);

		// 				// set add paragraph
		// 				newline = target.find('#newline');
		// 				newline.attr('key', element.key);
		// 				newline.addClass(feature_lockUnlock);

		// 				// set remove element
		// 				remove = target.find('#remove');
		// 				remove.attr('key', element.key);
		// 				remove.addClass(feature_lockUnlock);

		// 				// set status displayRevision
		// 				if(element.revisi){
		// 					// target.find('#revise').addClass(feature_lockDisplayRevision);
		// 					target.find('#revise').addClass('active');
		// 					target.find('#revise').attr('data-idx', idx);
		// 					target.find('#revise').find('#ctr').text(element.revisi.length);
		// 				}else{
		// 					target.find('#revise').addClass('disabled');
		// 				}

		// 			});
		// 			$(document.getElementById('page')).scrollTop(0);


		// 			// ui on complete
		// 			$('.disabled-before-load').removeClass("disabled");
		// 			$('.loader').fadeOut('fast', function(){
		// 				$('.hide-before-load').fadeIn();
		// 			});

		// 		}
		// 		catch(err){
		// 		console.log(err);
		// 			$('.show-before-load').hide();
		// 			$('.show-on-error').show();
		// 			$(document.getElementById('loader-error-code')).text('422');
		// 		}
		// 	});
		// 	ajax_akta.defineOnError(function(resp){
		// 		$('.show-before-load').hide();
		// 		$('.show-on-error').show();
		// 		$(document.getElementById('loader-error-code')).text(resp.status);
		// 	});

		// 	ajax_akta.get(url);
		// }
	</script>
@endpush