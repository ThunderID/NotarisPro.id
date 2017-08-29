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

	<div class="row subset-2menu full-on-mobile" style="background-color: white; height: 100%;">
		<div id="page-loader" class="loader scrollable_panel">
			<h4 class="show-before-load">
				<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Memuat
			</h4>
			<h4 class="show-on-error" style="display: none;">
				<a href="javascript:void(0);" onClick="retrySetAktaShow();">
					<i class="fa fa-refresh" aria-hidden="true"></i> Coba Lagi
				</a>
			</h4>
		</div>	
		<div id="arsip" class="col-12 col-sm-12 col-md-5 col-lg-4 scrollable_panel pl-3">
			<div class="row pt-4 pb-3">
				<div class="col-12">
					<h5 id="title" class="text-uppercase"></h5>
				</div>
			</div>				
			<div id="template" class="row" hidden>
				<div class="col-4">
					<p class="text-capitalize" id="field"></p>
				</div>
				<div class="col-8">
					<p id="value">: &nbsp;</p>
				</div>
			</div>
			<div id="content">
			</div>
		</div>
		<div id="terkait" class="col-12 col-sm-12 col-md-7 col-lg-8 pt-2" style="height: 100%; border-left: 1px solid #F7F7F7;">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs flat-tabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active pl-0 pb-0" data-toggle="tab" href="#terkait-arsip" role="tab">Arsip Terkait</a>
				</li>
				<li class="nav-item">
					<a class="nav-link pl-0 pb-0" data-toggle="tab" href="#terkait-akta" role="tab">Akta Terkait</a>
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
								<th style="width: 30%;"">Jenis Arsip</th>
								<th style="width: 70%">Nama</th>
							</tr>
						</thead>
						<tbody id="content">
							
						</tbody>
					</table>

					<div id="template" hidden>
						<tr onclick="showArsip(this);" style="cursor: pointer;">
							<td id="jenis">
								<i class="fa fa-id-card" aria-hidden="true"></i>
								&nbsp;
								KTP
							</td>
							<td id="nama">
								Aldo Gidal Kebo
							</td>				
						</tr>						
		                <tr id="no-data">
		                    <td colspan="2" class="text-center">
		                        Tidak Ada Data
		                    </td>
		                </tr>					
					</div>

				</div>
				<div class="tab-pane" id="terkait-akta" role="tabpanel">
					<p class="pb-3">Penjelasan akta terkait
					Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>

				</div>

			</div>
		</div>
	</div>
</div>

@push('scripts')

	/* Start UI page */
	function showArsip(e){
		// global vars
		var element_source = $(e);
		var id = element_source.attr('data_id_arsip');
		var judul = element_source.find('#judul').text();

		modulShowArsip(id, judul);
	}
	function hideArsip(e){
		$(document.getElementById('arsip_show')).fadeOut('fast', function(){
			var target = $(document.getElementById('text-editor'));
			window.history.pushState(null, null, '/arsip/arsip');
		});		
	}	

	function modulShowArsip(id, judul){
		// reset state
		$('.loader').show();

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
			console.log(resp);
			// declare
			const icon_tipe_arsip = {
										'ktp' :  "<i class='fa fa-id-card' aria-hidden='true'></i>&nbsp;&nbsp;",
										'lainnya' :  "<i class='fa fa-file' aria-hidden='true'></i>&nbsp;&nbsp;",
									};

			try {
				let target = $(document.getElementById('arsip_show'));

				// arsip
				let arsip = target.find('#arsip');
				try{
					arsip.find('#title').html(icon_tipe_arsip[resp.jenis] + window.stringManipulator.toSpace(resp.jenis));
				}catch(err){
					arsip.find('#title').html(icon_tipe_arsip['lainnya'] + window.stringManipulator.toSpace(resp.jenis));
				}
				let tmplt = arsip.find('#template');
				arsip.find('#content').empty();
				$.map(resp.isi, function(value, index) {
					var rslt = tmplt.clone().appendTo(arsip.find('#content'));
					rslt.find('#field').text(window.stringManipulator.toSpace(index));
					rslt.find('#value').text(rslt.find('#value').text() + window.stringManipulator.toSpace(value));
					rslt.removeAttr('hidden');
					rslt.addClass('arsip');
				});

				// arsip terkait
				let terkait = target.find('#terkait-arsip');
				


				// ui on complete
				$('.disabled-before-load').removeClass("disabled");
				$('.loader').fadeOut('fast', function(){

				});

			}catch(err){
				console.log(err);
				// $('.show-before-load').hide();
				// $('.show-on-error').show();
				// $(document.getElementById('loader-error-code')).text('422');
			}									


		});
		ajax_arsip.defineOnError(function(resp){
			// $('.show-before-load').hide();
			// $('.show-on-error').show();
			// $(document.getElementById('loader-error-code')).text(resp.status);
		});

		ajax_arsip.get(url);		
	}
@endpush