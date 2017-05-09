@extends('templates.blank')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
@endpush

@push('styles')  
	body {
		font-family: 'Inconsolata', monospace;
	}
	p, ul, ol, h5 {
		margin-top: 0;
		margin-bottom: 0;
	}
@endpush  

@section('akta')
	active
@stop

@section('data-akta')
	active
@stop

@section('content')
		<div id="page" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subset-2menu">
			<div id="page-breaker" class="row page-breaker"></div>
			<div class="row">
				<div class="d-flex justify-content-center mx-auto">
					<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 0cm; padding-left: 5cm; padding-right: 1cm;">
						<div class="form-group editor">
							<p>----------------------------------------------------------------------</p>
							<p>----------------------------------------------------------------------</p>
							<p>
								Pada hari ini tanggal @tanggal.menghadap pukul @waktu.menghadap Waktu-<br>
								Indonesia @waktu.indonesia.bagian .-----------------------------------
							</p>
							<p>
								Menghadap kepada saya,Notaris berkedudukan di Jl Raya Mangga Dua Grand<br>
								Boutique Centre Bl A/9 Wilayah Jabatan Provinsi Kota Jakarta Utara ---<br>
								dengan dihadiri oleh para saksi yang saya, Notaris kenal yang --------<br>
								sama-sama namanya disebutkan pada bagian akhir akta ini.--------------<br>
							</p>
							<p>----------------------------------------------------------------------</p>
							<ul>
								<li>
									Tuan/Nyonya @klien.1.nama ---------------------------------------<br>
									dilahirkan diMalang tanggal 22-08-1990 Warga Negara Indonesia, --<br>
									Swasta, bertempat tinggal di Jln. Mataram pemegang kartu tanda --<br>
									penduduk (KTP) 201.1802.1101010 ---------------------------------<br>
								</li>
								<li>
									Tuan/Nyonya @klien.2.nama ---------------------------------------<br>
									dilahirkan di@klien.2.tempat_lahir tanggal @klien.2.tanggal_lahir<br>
									Warga Negara Indonesia, Swasta, bertempat tinggal di ------------<br>
									@klien.2.alamat pemegang kartu tanda penduduk (KTP) -------------<br>
									@klien.2.nomor_ktp ----------------------------------------------<br>
								</li>
							</ul>
							<p>----------------------------------------------------------------------</p>
							<p>
								Para penghadap telah saya, Notaris kenal berdasarkan identitasnya yang<br>
								diperlihatkan kepada saya, Notaris.-----------------------------------<br>
								Para penghadap menerangkan terlebih dahulu:---------------------------<br>
								Para penghadap dalam kedudukannya sebagaimana tersebut di atas, dengan<br>
								ini menyatakan mendirikan Yayasan dengan anggaran dasar sebagai ------<br>
								berikut: -------------------------------------------------------------<br>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="pdf"></div>
	@include('components.deleteModal',[
		'title' => 'Menghapus Draft Akta',
		'route' => route('akta.akta.destroy', ['id' => $page_datas->datas['id']])
	])
@stop

@push('plugins')
	<script type="text/javascript" src="/plugins/jspdf.debug.js"></script>
	<script type="text/javascript" src="/plugins/html2pdf.js"></script>
@endpush

@push('scripts')
	// $(value).find('span').each(function (key2, value2) {
	// 	if ($(value2).length !== 0) {
	// 		if ($(value).is('ol, ul')) {
	// 			$('li').unwrap();
	// 		} else {
	// 			$('p').unwrap();
	// 		}
	// 	}
	// });
	$(document).ready(function(){
		var pdf = new jsPDF();
		$('.editor').children().each(function (key, value) {
			// console.log($(this));
			// textTemp.replace(/<span (.+?)>(.*?)<\/span>/i, '$1');
			
		});

		var element = {
			'#pdf': function (el, render) {
				return true;
			}
		};

		pdf.fromHTML($('.editor').get(0), 20, 10, {
			'elementHandlers': element,
		});
		pdf.output('dataurlnewwindow');
	});
@endpush 