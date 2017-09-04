<div class="col-12 subset-menu" style="width:100vw;">
	<div class="row">

		@include('components.submenu', [
			'title' 		=> "Arsip",
			'menus' 		=> [		
					[
						"title" 			=> "",		
						"route" 			=> "javascript:hideArsip();",
						"icon" 				=> "fa-times",
						"class" 			=> "arsip_close"
					],
			]
		])
	</div>

	<div class="subset-2menu" style="background-color: white; height: 100%;">
		<div class="row scrollable_panel">
			<div id="page-loader" class="loader" style="overflow-x: hidden;">
				<h4 class="show-before-load">
					<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Memuat
				</h4>
				<div class="show-on-error pl-3 pt-3 col-12 col-md-6" style="display: none;">
					<h5 class="mb-0 show-on-error" style="display: none;">
						Tidak dapat mengambil data!<br><br><small>Pastikan Anda dapat terhubung dengan internet dan cobalah beberapa saat lagi. Bila masalah ini terus berlanjut, silahkan hubungi Costumer Service kami untuk mendapatkan bantuan.</small>
					</h5>
					<h5 class="pt-2 show-on-error" style="display: none;">
						<small>Kode Error: <span id="loader-error-code">500</span></small>
					</h5>
					<h5 class="pt-4">
						<a href="javascript:void(0);" onClick="retrySetArsipShow();">
							<i class="fa fa-refresh" aria-hidden="true"></i> Coba Lagi
						</a>
					</h5>
				</div>
			</div>
			<div id="arsip" class="col-12 col-sm-12 col-md-5 col-lg-4 pl-3">
				<div class="row pt-4 pb-3">
					<div class="col-12">
						<h5 id="title" class="text-uppercase"></h5>
					</div>
				</div>				
				<div id="template" class="row" hidden>
					<div class="col-4 pr-0">
						<p class="text-capitalize" id="field"></p>
					</div>
					<div class="col-1 pl-0 pr-0 text-center">
						:
					</div>
					<div class="col-7 pl-0">
						<p id="value">&nbsp;</p>
					</div>
				</div>
				<div id="content">
				</div>
			</div>
			<div class="col-12 hidden-md-up pt-3 pb-4">
				<div class="row clearfix"></div>
			</div>
			<div id="terkait" class="col-12 col-sm-12 col-md-7 col-lg-8 pt-2 pl-3 pr-3 right-panel-responsive">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs flat-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active pl-0 pb-1 pr-0 mr-3 tab-init" data-toggle="tab" href="#terkait-arsip" role="tab">Arsip Terkait</a>
					</li>
					<li class="nav-item">
						<a class="nav-link pl-0 pb-1 pr-0 mr-3" data-toggle="tab" href="#terkait-akta" role="tab">Akta Terkait</a>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content pt-4">
					<div class="tab-pane active" id="terkait-arsip" role="tabpanel">
						<p class="pb-3">Penjelasan dokumen arsip terkait
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>

						<table class="table table-hover">
							<thead>
								<tr>
									<th style="width: 25%;">Dokumen</th>
									<th style="width: 25%;">Relasi</th>
									<th style="width: 45%;">Deskripsi</th>
									<th style="width: 5%;"></th>
								</tr>
							</thead>
							<tbody id="content">
								
							</tbody>
						</table>

						<table id="template" hidden>
							<tr id="data" class="pb-0">
								<td id="jenis" class="text-capitalize">
								</td>
								<td id="relasi" class="text-capitalize">
								</td>							
								<td id="deskripsi">
									<div id='deskripsi-template' hidden>
										<p class="mb-1 text-capitalize"><span id="field"></span>&nbsp;:&nbsp;<span id="value"></span></p>
									</div>
									<div id="deskripsi-content">
									</div>
								</td>
								<td>
									<a id="link" href="#" target="blank" class="pr-2" style="float: right;">
										<i class="fa fa-external-link" aria-hidden="true"></i>
									</a>
								</td>
							</tr>						
			                <tr id="no-data">
			                    <td colspan="4" class="text-center">
			                    	Tidak ada data
			                    </td>
			                </tr>					
						</table>

					</div>
					<div class="tab-pane" id="terkait-akta" role="tabpanel">
						<p class="pb-3">Penjelasan akta terkait
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>

						<table class="table table-hover">
							<thead>
								<tr>
									<th style="width: 25%;">Jenis</th>
									<th style="width: 80%;">Judul Akta</th>
									<th style="width: 5%;"></th>
								</tr>
							</thead>
							<tbody id="content">
								
							</tbody>
						</table>

						<table id="template" hidden>
							<tr id="data" class="pb-0">
								<td id="jenis" class="text-capitalize">
								</td>
								<td id="judul" class="text-capitalize">
								</td>
								<td>
									<a id="link" href="#" target="blank" class="pr-2" style="float: right;">
										<i class="fa fa-external-link" aria-hidden="true"></i>
									</a>
								</td>
							</tr>						
			                <tr id="no-data">
			                    <td colspan="3" class="text-center">
			                    	Tidak ada data
			                    </td>
			                </tr>					
						</table>					

					</div>

				</div>
			</div>
		</div>
	</div>
</div>

@push('scripts')
	/* Start UI page */
	function showArsip(e){
		// sets history
		window.dataBox.set('url-history', window.location.href);

		// global vars
		var element_source = $(e);
		var id = element_source.attr('data_id_arsip');
		var judul = element_source.find('#judul').text();

		modulShowArsip(id, judul);
	}
	function hideArsip(e){
		$(document.getElementById('arsip_show')).fadeOut('fast', function(){
			var target = $(document.getElementById('text-editor'));
			window.history.pushState(null, null,  window.dataBox.get('url-history') == null ? '/arsip/arsip' : window.dataBox.get('url-history'));
			console.log(window.dataBox.get('url-history'));
		});		
	}	

	function modulShowArsip(id, judul){

		// reset state
		$('.loader').show();
		$('.tab-init').click();
		$('.disabled-before-load').addClass("disabled");
		$('.hide-before-load').hide();
		$('.show-before-load').show();
		$('.show-on-error').hide();		

		// sets url
		window.history.pushState(null, null, '/arsip/arsip/' + id);

		// ui display
		$(document.getElementById('arsip_show')).fadeIn('fast');

		// set val
		setArsipShow(id);
	}

	/* Start Set Akta Show */
	function setArsipShow(id_akta){
		var url = '{{route('arsip.ajax.show', ['id' => null])}}/' + id_akta;
		var ajax_arsip = window.ajax;

		ajax_arsip.defineOnSuccess(function(resp){
			// declare
			const icon_tipe_arsip = "<i class='fa fa-file-o' aria-hidden='true'></i>&nbsp;&nbsp;";

			var target = $(document.getElementById('arsip_show'));

			// arsip
			var arsip = target.find('#arsip');
			arsip.find('#title').html(icon_tipe_arsip + window.stringManipulator.toSpace(resp.jenis));
			var tmplt = arsip.find('#template');
			arsip.find('#content').empty();
			$.map(resp.isi, function(value, index) {
				var rslt = tmplt.clone().appendTo(arsip.find('#content'));
				rslt.find('#field').text(window.stringManipulator.toSpace(index));
				rslt.find('#value').text((value == '' || value == null ? '_' :  window.stringManipulator.toSpace(value)));
				rslt.removeAttr('hidden');
				rslt.addClass('arsip');
			});

			// arsip terkait
			var terkait = target.find('#terkait-arsip');
			terkait.find('#content').empty();
			if(resp.relasi && resp.relasi.dokumen){
				$.map(resp.relasi.dokumen, function(value, index) {
					var rslt = terkait.find('#template').find('#data').clone().appendTo(terkait.find('#content'));
					rslt.find('#link').attr('href' ,  '{{route('arsip.arsip.index')}}/' + value.id.$oid);
					rslt.removeAttr('id');
					rslt.find('#jenis').text(value.jenis);
					rslt.find('#relasi').text(value.relasi);

					drawDetail(rslt, value.isi);
				});

				function drawDetail(target, datas){
					var tmp = target.find('#deskripsi').find('#deskripsi-template');

					Object.keys(datas).forEach(function(element) {
						var rslt = tmp.clone().appendTo(target.find('#deskripsi-content'));
						rslt.removeAttr('id');
						rslt.removeAttr('hidden');
						rslt.find('#field').text(window.stringManipulator.toSpace(element));
						rslt.find('#value').text(datas[element]);
					});
				}
			}else{
				terkait.find('#template').find('#no-data').clone().appendTo(terkait.find('#content'));
			}

			// akta terkait
			var terkait = target.find('#terkait-akta');
			terkait.find('#content').empty();
			if(resp.relasi && resp.relasi.akta){
				$.map(resp.relasi.akta, function(value, index) {
					var rslt = terkait.find('#template').find('#data').clone().appendTo(terkait.find('#content'));
					rslt.find('#link').attr('href' ,  '{{route('akta.akta.index')}}/' + value.id.$oid);
					rslt.removeAttr('id');
					rslt.find('#jenis').text(value.jenis);
					rslt.find('#judul').text(value.judul);
				});
			}else{
				terkait.find('#template').find('#no-data').clone().appendTo(terkait.find('#content'));
			}


			// ui on complete
			$('.disabled-before-load').removeClass("disabled");
			$('.loader').fadeOut('fast', function(){

			});

									
		});
		ajax_arsip.defineOnError(function(resp){
			$('.show-before-load').hide();
			$('.show-on-error').show();
			$(document.getElementById('loader-error-code')).text(resp.status);
		});

		ajax_arsip.get(url);		
	}
	function retrySetArsipShow(){
		// sets arsip
		$('.loader').show();
		$('.disabled-before-load').addClass("disabled");
		$('.hide-before-load').hide();
		$('.show-before-load').show();
		$('.show-on-error').hide();

		// get id_akta
		var id = window.location.pathname.replace('/arsip/arsip', '');
		id_akta = id.replace('/', '');

		// retry get akta
		setArsipShow(id_akta);
	}	
	/* End Set Arsip Show */


	/* Start URL Page Manager */
	$(window).on('popstate', function() {
		managePage();
	});

	@if($page_datas->id != null)
		managePage();
	@endif

	function managePage(){
		var id = window.location.pathname.replace('/arsip/arsip', '');
		if(id != ""){
			id = id.replace('/', '');
			modulShowArsip(id, null);
		}else{
			hideArsip(null);
		}
	}
	/* End URL Page Manager */	
@endpush