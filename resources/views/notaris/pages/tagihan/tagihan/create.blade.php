@extends('templates.basic')

@push('styles')  
@endpush  

@section('tagihan')
	active
@stop

@section('content')
		@component('components.form', [ 
			'data_id' 		=> $page_datas->id,
			'store_url' 	=> route('tagihan.tagihan.store'), 
			'update_url' 	=> route('tagihan.tagihan.update', ['id' => $page_datas->id]), 
		])

			<div class="row">
				<div class="col-12">
					@include('components.alertbox')
				</div>
			</div>

			<div id="page-wrap">
				<div class="clearfix">&nbsp;</div>
				<div class="row">
					<div class="col-12 text-right">
						@if(!is_null($page_datas->id))
							<a href="{{route('tagihan.tagihan.print', ['tagihan_id' => $page_datas->id])}}" class="btn btn-secondary" target="__blank"> <i class="fa fa-print"></i> Print </a>
						@endif
						@if(str_is($page_datas->tagihan['status'], 'pending') && !is_null($page_datas->id))
							<a href="{{route('tagihan.tagihan.status', ['tagihan_id' => $page_datas->id, 'status' => 'lunas'])}}" class="btn btn-primary"> {{ucwords($page_datas->tagihan['status'])}} </a>
						@else
							<span class="btn btn-info"> {{ucwords($page_datas->tagihan['status'])}} </span>
						@endif

					</div>
				</div>
				<h2 class="text-center" style="padding-top:35px;padding-bottom:25px;">INVOICE</h2>
				
				<div class="clearfix">&nbsp;</div>
				<div class="clearfix">&nbsp;</div>
				
				<div id="identity">
					<div class="row">
						<div class="col-sm-6">
							<h3>{{$page_datas->active_office['kantor']['notaris']['nama']}}</h3>
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
				
				<form action="{{route('tagihan.tagihan.store')}}" method="POST">
					<div id="customer">
						<div class="row">
							<div class="col-sm-6">
								<textarea id="customer-title" name="klien[nama]" style="width: 100%;">{{$page_datas->tagihan['klien']['nama']}}</textarea>
								<textarea name="klien[alamat]" style="width: 100%;">{{$page_datas->tagihan['klien']['alamat']}}</textarea>
							</div>
							<div class="col-sm-6">

								<table id="meta">
									<tr>
										<td class="meta-head">Tagihan #</td>
										<td><textarea name="nomor" style="font-size:10px;padding-top:7px;">{{$page_datas->tagihan['nomor']}}</textarea></td>
									</tr>
									<tr>

										<td class="meta-head">Tanggal
										<td><textarea id="date" name="tanggal">{{$page_datas->tagihan['tanggal_dikeluarkan']}}</textarea></td>
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
							  <td class="item-name"><div class="delete-wpr"><textarea name="item[]">{{$value['item']}}</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
							  <td class="description"><textarea name="deskripsi[]">{{$value['deskripsi']}}</textarea></td>
							  <td><textarea class="cost" name="harga[]">{{$value['harga_satuan']}}</textarea></td>
							  <td><textarea class="qty" name="kuantitas[]">{{$value['kuantitas']}}</textarea></td>
							  <td><span class="price">{{$value['subtotal']}}</span></td>
						  </tr>
						  
					<!-- 	  <tr class="item-row">
							  <td class="item-name"><div class="delete-wpr"><textarea name="item[]">Cetak Akta</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>

							  <td class="description"><textarea name="deskripsi[]">Cetak Salinan Akta dan Dibukukan</textarea></td>
							  <td><textarea class="cost" name="harga[]">Rp 25000</textarea></td>
							  <td><textarea class="qty" name="kuantitas[]">3</textarea></td>
							  <td><span class="price">Rp 75000</span></td>
						  </tr> -->
					@empty
					@endforelse
					  
					  <tr id="hiderow">
						<td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
					  </tr>
					  
					  <!-- <tr>
						  <td colspan="2" class="blank"> </td>
						  <td colspan="2" class="total-line">Subtotal</td>
						  <td class="total-value"><div id="subtotal">Rp 2725000</div></td>
					  </tr>
					  <tr>

						  <td colspan="2" class="blank"> </td>
						  <td colspan="2" class="total-line">Total</td>
						  <td class="total-value"><div id="total">Rp 2725000</div></td>
					  </tr>
					  <tr>
						  <td colspan="2" class="blank"> </td>
						  <td colspan="2" class="total-line">Dibayar</td>

						  <td class="total-value"><textarea id="paid" name="dibayar[]">Rp 0</textarea></td>
					  </tr> -->
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
				
					<fieldset class="form-group">
						<div class="row">
							<div class="col-6 offset-6 text-right">
								<a href="{{ isset($page_datas->id) ? route('tagihan.tagihan.edit', ['id' => $page_datas->id]) : route('tagihan.tagihan.index') }}" type="button" class="btn btn-secondary">Cancel</a>
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		@endcomponent	
@stop

@push('styles')  
	</style>
	<link rel="stylesheet" href="{{url('/assets/tagihan/invoice/css/style.css')}}">
	<link rel="stylesheet" href="{{url('/assets/tagihan/invoice/css/print.css')}}">
	<style type="text/css">
@endpush 

@push('scripts')  
	</script>
	/*<script src="{{url('/assets/tagihan/invoice/js/jquery-1.3.2.min.js')}}"></script>*/
	<script src="{{url('/assets/tagihan/invoice/js/example.js')}}"></script>
	<script type="text/javascript">
@endpush 
