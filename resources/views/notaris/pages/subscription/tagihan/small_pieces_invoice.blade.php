<div class="clearfix">&nbsp;</div>
<div class="row">
  	<div class="col-12">
		<h2 class="text-center">INVOICE</h2>
  	</div>
</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="row">
  	<div class="col-6 text-left">
  		<h4>Mitra Notaris</h4>
  		<p>Jl Raya Mangga Dua Grand Boutique Centre Bl A/9
  		<br/>Telepon: 0216018828</p>
  	</div>
  	<div class="col-6 text-right">
  		<img src="http://politicalmemorabilia.com/wp-content/uploads/2014/10/Calvin-Coolidge.png" style="max-width:200px;">
  	</div>
</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="row">
	<div class="col-6">
		<h5>{{$kantor['notaris']['nama']}}</h5>
		<h7>{{$kantor['notaris']['alamat']}}<br/>Telepon : {{$kantor['notaris']['telepon']}}</h7>
	</div>
	<div class="col-6">
		<div class="row">
		  	<div class="col-5 text-left">
		  		Tagihan
		  	</div>
		  	<div class="col-7 text-right">
		  		#{{$data['nomor']}}
		  	</div>
		</div>
		<div class="row">
		  	<div class="col-5 text-left">
		  		Tanggal
		  	</div>
		  	<div class="col-7 text-right">
		  		{{$data['tanggal_dikeluarkan']}}
		  	</div>
		</div>
		<div class="row">
		  	<div class="col-5 text-left">
		  		Jatuh Tempo
		  	</div>
		  	<div class="col-7 text-right">
		  		{{$data['tanggal_jatuh_tempo']}}
		  	</div>
		</div>

		<div class="row">
		  	<div class="col-5 text-left">
		  		Total
		  	</div>
		  	<div class="col-7 text-right">
		  		{{$data['total']}}
		  	</div>
		</div>
	</div>
</div>

<div class="clearfix">&nbsp;</div>

<div class="row" style="padding:15px;">
	<div class="col-2" style="border:1px solid;">
		Item
	</div>
	<div class="col-3" style="border:1px solid;">
		Deskripsi
	</div>
	<div class="col-2" style="border:1px solid;">
		Harga@
	</div>
	<div class="col-2" style="border:1px solid;">
		Diskon@
	</div>
	<div class="col-1" style="border:1px solid;">
		Jumlah
	</div>
	<div class="col-2" style="border:1px solid;">
		Total
	</div>
	@foreach($data['details'] as $key => $value)
		<div class="col-2" style="border:1px solid;">
			{{$value['item']}}
		</div>
		<div class="col-3" style="border:1px solid;">
			{{$value['deskripsi']}}
		</div>
		<div class="col-2 text-right" style="border:1px solid;">
			{{$value['harga_satuan']}}
		</div>
		<div class="col-2 text-right" style="border:1px solid;">
			{{$value['diskon_satuan']}}
		</div>
		<div class="col-1 text-right" style="border:1px solid;">
			{{$value['kuantitas']}}
		</div>
		<div class="col-2 text-right" style="border:1px solid;">
			{{$value['subtotal']}}
		</div>
	@endforeach
	<div class="col-10 text-right" style="border:1px solid;">
		Total
	</div>
	<div class="col-2 text-right" style="border:1px solid;">
		{{$data['total']}}
	</div>
</div>

<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>