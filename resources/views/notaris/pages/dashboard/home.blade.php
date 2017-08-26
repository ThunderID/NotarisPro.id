@extends('templates.basic')

@section('content')

	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="card card-inverse card-primary mb-3 text-center">
				<div class="card-block">
					<blockquote class="card-blockquote">
						<h1>{{$stat_akta['dalam_proses']}}</h1>
						<footer>Total Akta Dalam Proses</footer>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="card card-inverse card-primary mb-3 text-center">
				<div class="card-block">
					<blockquote class="card-blockquote">
						<h1>{{$stat_akta['total_karyawan']}}</h1>
						<footer>Total Karyawan</footer>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="card card-inverse card-primary mb-3 text-center">
				<div class="card-block">
					<blockquote class="card-blockquote">
						<h1>{{$stat_akta['jam_kerja_mingguan']}}</h1>
						<footer>Total Jam Kerja Per Minggu</footer>
					</blockquote>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	@php $flag = 0 @endphp
	<div class="row">
		<div class="col-12 text-center">
			<h5 style="margin:0px;">
				<strong>
					PERSENTASI PESANAN AKTA BULAN INI<br/>BERDASARKAN JENIS
				</strong>
			</h5>
		</div>
	</div>
	<div class="row">
		@foreach($stat_akta_bulan_ini as $key => $value)
			@if(!$flag)
				<div class="col-sm-{{$stat_main_col}} p-0">
				@php $flag = 1 @endphp
			@else
				<div class="col-sm-{{$stat_add_col}} p-0">
			@endif
			<div class="test-circle{{$key}}"></div>
			<!-- <div class="text-center"><strong>{{$value['jenis']}}</strong></div> -->
		</div>
		@endforeach
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-7">
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-striped">
						<thead>
							<tr>
								<th colspan="4">
									<h5 style="margin:5px;">
										<strong>
											PESANAN AKTA BERDASARKAN JENIS
										</strong>
									</h5>
								</th>
							</tr>
							<tr>
								<th>Jenis Akta</th>
								<th>2 Bulan Lalu</th>
								<th>Bulan Lalu</th>
								<th>Bulan Ini</th>
							</tr>
						</thead>
						<tbody>
							@forelse($akta_movement as $key => $value)
								<tr>
									<td>{{$value['jenis']}}</td>
									<td>{{$value['bulan_lalu_lalu']['total']}}</td>
									<td>@if($value['bulan_lalu']['compare_perc'] > 0) <i class="fa fa-arrow-up text-success"></i> @elseif($value['bulan_lalu']['compare_perc'] < 0) <i class="fa fa-arrow-down text-danger"></i> @endif {{$value['bulan_lalu']['total']}}</td>
									<td>@if($value['bulan_ini']['compare_perc'] > 0) <i class="fa fa-arrow-up text-success"></i> @elseif($value['bulan_ini']['compare_perc'] < 0) <i class="fa fa-arrow-down text-danger"></i> @endif {{$value['bulan_ini']['total']}}</td>
								</tr>
							@empty
								<tr>
									<td colspan="4">
										Belum ada data
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-striped">
						<thead>
							<tr>
								<th colspan="2">
									<h5 style="margin:5px;">
										<strong>
											PIUTANG BERJALAN
										</strong>
									</h5>
								</th>
							</tr>
							<tr>
								<th style="vertical-align:middle;">Nama Klien</th>
								<th class="text-right">Tanggal Jatuh Tempo<br>Jumlah</th>
							</tr>
						</thead>
						<tbody>
							@forelse($tagihan as $key => $value)
								<tr>
									<td>
										{{$value['klien']['nama']}}
									</td>
									<td class="text-right">
										<span class="badge badge-danger">{{$value['tanggal_jatuh_tempo']}}</span>
										<br/>
										{{$value->getTotal()}}
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="2">
										Belum ada data
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-sm-5">
			<div class="card card-warning mb-3" style="background-color:#fff;">
				<div class="card-header" style="border-bottom:1px solid #f0ad4e;">
					<h5 style="margin:5px;">
						<strong>
							NOTIFIKASI
						</strong>
					</h5>
				</div>
					<div class="card-body" style="margin:5px;">
						@forelse($notifikasi as $key => $value)
							<div class="row" style="padding:15px;">
								<div class="col-6">
									{{$value['judul']}}<br/>
									<small>{{$value['deskripsi']}}</small>
								</div>
								<div class="col-6 text-right">
									<span class="badge badge-warning">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$value['tanggal'])->format('d/m/Y H:i')}}</span>
								</div>
							</div>
						@empty
							<div class="row" style="padding:15px;">
								<div class="col-12">
									Belum ada data
								</div>
							</div>						
						@endforelse
					</div>
				</div>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>

@stop()

@push('plugins')
	<script src="{{url('/assets/stat/js/jquery.circliful.js')}}"></script>
@endpush()

@push('scripts')
	$( document ).ready(function() { // 6,32 5,38 2,34
		@foreach($stat_akta_bulan_ini as $key => $value)
		$(".test-circle{{$key}}").circliful({
			// animation: 1,
			// animationStep: 1,
			// foregroundBorderWidth: 5,
			// backgroundBorderWidth: 1,
			// percent: {{$value['percentage']}},
			
			// iconColor: '#3498DB',
			// iconSize: '10',
			// iconPosition: 'middle',

			// // animationStep: 10,
			// // foregroundBorderWidth: 5,
			// // backgroundBorderWidth: 5,
			// // percent: {{$value['percentage']}},

			// textSize: 30,
			// textStyle: 'font-size: 10px;',
			// textColor: '#000',
			// text: "{{$value['jenis']}}"
			animation: 1,
			animationStep: 3,
			foregroundBorderWidth: 5,
			backgroundBorderWidth: 5,
			textBelow:true,
			percent: {{$value['percentage']}},
			textSize: 20,
			textStyle: 'font-size: 12px;',
			textColor: '#000',
			text: "{{$value['jenis']}}",
		});
		@endforeach
	});
@endpush