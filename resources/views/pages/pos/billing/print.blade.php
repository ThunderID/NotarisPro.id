<!DOCTYPE html>
<html>
<head>
	<title>PRINT INVOICE</title>

	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />

	<!-- Fa Icon -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

	<!-- Font -->
	<link href="https://fonts.googleapis.com/css?family=Muli:200,400,600" rel="stylesheet">

	<link rel="stylesheet" href="{{url('/assets/tagihan/invoice/css/style.css')}}">
	<link rel="stylesheet" href="{{url('/assets/tagihan/invoice/css/print.css')}}">
</head>
<body>
	<div id="page-wrap">
		<div class="clearfix">&nbsp;</div>
		<h2 class="text-center" style="padding-top:35px;padding-bottom:25px;">INVOICE</h2>
		
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>
		
		<div id="identity">
			<div class="row">
				<div class="col-sm-6">
					<h4>{{$page_datas->active_office['kantor']['notaris']['nama']}}</h4>
					<p>{{$page_datas->active_office['kantor']['notaris']['alamat']}} &#13;&#10;Telepon: {{$page_datas->active_office['kantor']['notaris']['telepon']}}</p>
				</div>
				<div class="col-sm-6">
					<!-- <div id="logo"> -->

					  <!-- <div id="logoctr">
						<a href="javascript:;" id="change-logo" title="Change logo">Change Logo</a>
						<a href="javascript:;" id="save-logo" title="Save changes">Save</a>
						|
						<a href="javascript:;" id="delete-logo" title="Delete logo">Delete Logo</a>
						<a href="javascript:;" id="cancel-logo" title="Cancel changes">Cancel</a>
					  </div> -->

					  <!-- <div id="logohelp">
						<input id="imageloc" type="text" size="50" value="" /><br />
						(max width: 540px, max height: 100px)
					  </div> -->
					  <img src="{{$page_datas->active_office['kantor']['notaris']['logo_url']}}" alt="logo" style="max-height: 100px;text-align:right;float:right" />
					<!-- </div> -->
				</div>
			</div>
		</div>
		
		<div class="clearfix">&nbsp;</div>
		
		<div id="customer">
			<div class="row">
				<div class="col-sm-6">
					<p id="customer-title" name="klien[nama]" style="width: 100%;">{{$page_datas->tagihan['klien']['nama']}}</p>
					<p name="klien[alamat]" style="width: 100%;">{{$page_datas->tagihan['klien']['alamat']}}</p>
				</div>
				<div class="col-sm-6">

					<table id="meta">
						<tr>
							<td class="meta-head">Tagihan #</td>
							<td><p name="nomor" style="font-size:10px;padding-top:7px;">{{$page_datas->tagihan['nomor']}}</p></td>
						</tr>
						<tr>

							<td class="meta-head">Tanggal
							<td><p id="date" name="tanggal">{{$page_datas->tagihan['tanggal_dikeluarkan']}}</p></td>
						</tr>
						<tr>
							<td class="meta-head">Total</td>
							<td><div class="due">{{$page_datas->tagihan['total']}}</div></td>
						</tr>

					</table>
		
				</div>
			</div>
		</div>
		
		<table id="items">
		
		  <tr>
			  <th>Item</th>
			  <th>Deskripsi</th>
			  <th>Harga@</th>
			  <th>Jumlah</th>
			  <th>Total</th>
		  </tr>
		  @forelse($page_datas->tagihan['details'] as $key => $value)
			  <tr class="item-row">
				  <td class="item-name"><p name="item[]">{{$value['item']}}</p></td>
				  <td class="description"><p name="deskripsi[]">{{$value['deskripsi']}}</p></td>
				  <td><p class="cost" name="harga[]">{{$value['harga_satuan']}}</p></td>
				  <td><p class="qty" name="kuantitas[]">{{$value['kuantitas']}}</p></td>
				  <td><span class="price">{{$value['subtotal']}}</span></td>
			  </tr>
			  
		<!-- 	  <tr class="item-row">
				  <td class="item-name"><div class="delete-wpr"><p name="item[]">Cetak Akta</p><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>

				  <td class="description"><p name="deskripsi[]">Cetak Salinan Akta dan Dibukukan</p></td>
				  <td><p class="cost" name="harga[]">Rp 25000</p></td>
				  <td><p class="qty" name="kuantitas[]">3</p></td>
				  <td><span class="price">Rp 75000</span></td>
			  </tr> -->
		@empty
		@endforelse
		  
		   <tr id="hiderow">
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="blank"> </td>
				<td colspan="2" class="total-line balance">Total</td>
				<td class="total-value balance"><div class="due">{{$page_datas->tagihan['total']}}</div></td>
			</tr>
		
		</table>
		
		<div id="terms">
			<h5>Terms</h5>
			<p name="catatan">Tagihan harus dilunasi sebelum tanggal {{Carbon\Carbon::createFromFormat('d/m/Y', $page_datas->tagihan['tanggal_dikeluarkan'])->addMonths(1)->format('d/m/Y')}}</p>
		</div>
	</div>
</body>
</html>
