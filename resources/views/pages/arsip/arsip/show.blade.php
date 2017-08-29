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
		<div id="arsip" class="col-12 col-sm-12 col-md-6 col-lg-4 scrollable_panel pl-3">
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
		<div class="col-12 col-sm-12 col-md-6 col-lg-8" style="height: 100%; border-left: 1px solid #F7F7F7;">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#home" role="tab">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#profile" role="tab">Profile</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#messages" role="tab">Messages</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#settings" role="tab">Settings</a>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane active" id="home" role="tabpanel">...</div>
				<div class="tab-pane" id="profile" role="tabpanel">...</div>
				<div class="tab-pane" id="messages" role="tabpanel">...</div>
				<div class="tab-pane" id="settings" role="tabpanel">...</div>
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
				let ar = target.find('#arsip')
				try{
					ar.find('#title').html(icon_tipe_arsip[resp.jenis] + window.stringManipulator.toSpace(resp.jenis));
				}catch(err){
					ar.find('#title').html(icon_tipe_arsip['lainnya'] + window.stringManipulator.toSpace(resp.jenis));
				}
				let tmplt = ar.find('#template');
				ar.find('#content').empty();
				$.map(resp.isi, function(value, index) {
					var rslt = tmplt.clone().appendTo(ar.find('#content'));
					rslt.find('#field').text(window.stringManipulator.toSpace(index));
					rslt.find('#value').text(rslt.find('#value').text() + window.stringManipulator.toSpace(value));
					rslt.removeAttr('hidden');
					rslt.addClass('arsip');
				});


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