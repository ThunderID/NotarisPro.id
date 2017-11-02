@push ('main')
	<div class="row justify-content-center">
		<div class="col-6">
			<div class="row">
				<div class="col-12 mt-5">
					<h3 class="text-center">AKTA BARU</h3>
					<p class="text-center text-secondary">Silahkan lengkapi data berikut untuk melanjutkan</p>
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-12">
					{!! Form::open(['url' => route('akta.store'), 'method' => 'POST']) !!}
						{!! Form::bsText('judul akta', 'judul', null, ['class' => 'form-control', 'placeholder' => 'Akta Jual Beli Tanah di Mengwi']) !!}
						{!! Form::bsSelect('jenis akta', 'jenis', [
							'' => 'Pilih', 
							'akta_fidusia' => 'Akta fidusia', 
							'akta_jual_beli' => 'Akta jual beli', 
							'akta_pendirian' => 'Akta pendirian'
						], null, ['class' => 'custom-select form-control']) !!}
						{!! Form::bsSelect('klien', 'klien[]', [], null, ['class' => 'form-control custom-select select2', 'multiple' => 'multiple', 'data-container' => '.pihak-selected']) !!}
						<div class="form-group text-right">
							<button type="submit" class="btn default-primary-color text-primary-color text-right"><i class="fa fa-gears"></i> Buat akta</button>
						</div>
					{!! Form::close() !!}

					<button type="button" id="olay" class="btn btn-info btn-lg" data-toggle="modal" data-target="#choose-data-modal" style="display: none;">Open Modal</button>

				</div>
			</div>
		</div>
	</div>

	{{-- call component modal for detail list data --}}
	@component ('bootstrap.modal', [
		'id' 	=> 'choose-data-modal',
	])
		@slot ('title')
			DATA KLIEN
		@endslot

		@slot ('body')
			{!! Form::open(['url' => route('arsip.store'), 'class' => 'form', 'id' => 'form-arsip']) !!}
				<div class="content-data-dokumen"></div>
				<div class="clearfix">&nbsp;</div>
				{!! Form::bsText('Nama', 'nama', null, ['class' => 'form-control', 'placeholder' => 'Chelsy Mooy']) !!}
				{!! Form::bsText('Telepon', 'telepon', null, ['class' => 'form-control', 'placeholder' => '0899 4545 2100']) !!}
				<div class="clearfix">&nbsp;</div>
				<div class="form-group text-right">
					<button type="submit" class="btn default-primary-color text-primary-color">Simpan</button>
				</div>
			{!! Form::close() !!}
		@endslot

	@endcomponent
@endpush

@push('styles')
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
	<script type="text/javascript">
	var flag = null;

	$(".select2").select2({
		ajax: {
			url: "{{route('arsip.index')}}",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
			},
			processResults: function (data, params) {
				// parse the results into the format expected by Select2
				// since we are using custom formatting functions we do not need to
				// alter the remote JSON data, except to indicate that infinite
				// scrolling can be used
				params.page = params.page || 1;

				return {
					results:  $.map(data.data, function (tlab) {
						return {
							telepon: tlab.pemilik.telepon,
							text: tlab.pemilik.nama,
							id: tlab._id
						}
					}),
					pagination: {
						more: (params.page * 30) < data.total_count
					}		
				};
			},
			cache: true
		},
		tags: true,
		tokenSeparators: [","],
		createTag: function (tag) {
			return {
				id: tag.term,
					text: tag.term+' (...tambahkan...)',
					isNew : true
				};
		},
		placeholder: 'Search for a repository',
		escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
		minimumInputLength: 1,
		templateResult: formatRepo,
		templateSelection: formatRepoSelection
	}).on("select2:select", function(e) {
		if(e.params.data.isNew){
			$('#olay').trigger('click');
			// $('.select2').append('<code>New tag: {"' + e.params.data.id + '":"' + e.params.data.text + '"}</code><br>');
			$(this).find('[value="'+e.params.data.id+'"]').replaceWith('<option selected value="'+e.params.data.id+'">'+e.params.data.text+'</option>');
			flag 	= e.params.data.id;
		}
	});

	function formatRepo (repo) {
		if (repo.loading) {
			return repo.text;
		}
		var markup = "<span style='width:80px;'><img src='"+"{{url('/images/me.jpg')}}"+"' style='width:80px;'/></span><span style='width:120px;'>"+repo.text+"  (<i class='fa fa-phone'></i> &nbsp;"+repo.telepon+")</span><span style='width:120px;'></span>";
		return markup;
	}

	function formatRepoSelection (repo) {
		return repo.text;
	}

	$('#form-arsip').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			type     : "POST",
			cache    : false,
			url      : $(this).attr('action'),
			data     : $(this).serialize(),
			success  : function(data) {
				$('.select2').find('[value="'+flag+'"]').replaceWith('<option selected value="'+data._id+'">'+data.pemilik.nama+'</option>');
				$('.close').trigger('click');
			}
		});

	});
	</script>
@endpush