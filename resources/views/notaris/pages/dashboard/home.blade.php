<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Logged</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
		
		<link rel="stylesheet" href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{url('/assets/stat/css/jquery.circliful.css')}}">

		<!-- Styles -->
		<style>
			html, body {
				background-color: #fff;
				color: #636b6f;
				font-family: 'Raleway', sans-serif;
				font-weight: 100;
				height: 100vh;
				margin: 0;
			}

			.full-height {
				height: 100vh;
			}

			.flex-center {
				align-items: center;
				display: flex;
				justify-content: center;
			}

			.position-ref {
				position: relative;
			}

			.top-right {
				position: absolute;
				right: 10px;
				top: 18px;
			}

			.content {
				text-align: center;
			}

			.title {
				font-size: 84px;
			}

			.links > a {
				color: #636b6f;
				padding: 0 25px;
				font-size: 12px;
				font-weight: 600;
				letter-spacing: .1rem;
				text-decoration: none;
				text-transform: uppercase;
			}

			.m-b-md {
				margin-bottom: 30px;
			}
		</style>
	</head>
	<body>
		<section class="container">

			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-sm-8">
					<h3>MITRA NOTARIS</h3>
				</div>
				<div class="col-sm-4 text-right">
					<a href="{{route('uac.login.destroy')}}">LOGOUT</a>
				</div>
			</div>
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
						<div class="col-sm-{{$stat_main_col}}" style="padding:0px;">
						@php $flag = 1 @endphp
					@else
						<div class="col-sm-{{$stat_add_col}}">
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
									@foreach($akta_movement as $key => $value)
										<tr>
											<td>{{$value['jenis']}}</td>
											<td>{{$value['bulan_lalu_lalu']['total']}}</td>
											<td>@if($value['bulan_lalu']['compare_perc'] > 0) <i class="fa fa-arrow-up text-success"></i> @elseif($value['bulan_lalu']['compare_perc'] < 0) <i class="fa fa-arrow-down text-danger"></i> @endif {{$value['bulan_lalu']['total']}}</td>
											<td>@if($value['bulan_ini']['compare_perc'] > 0) <i class="fa fa-arrow-up text-success"></i> @elseif($value['bulan_ini']['compare_perc'] < 0) <i class="fa fa-arrow-down text-danger"></i> @endif {{$value['bulan_ini']['total']}}</td>
										</tr>
									@endforeach
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
									@foreach($tagihan as $key => $value)
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
									@endforeach
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
								@foreach($notifikasi as $key => $value)
									<div class="row" style="padding:15px;">
										<div class="col-6">
											{{$value['judul']}}<br/>
											<small>{{$value['deskripsi']}}</small>
										</div>
										<div class="col-6 text-right">
											<span class="badge badge-warning">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$value['tanggal'])->format('d/m/Y H:i')}}</span>
										</div>
									</div>
								@endforeach
							</div>
						</div>
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
		</section>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
		<script src="https://v4-alpha.getbootstrap.com/dist/js/bootstrap.min.js"></script>
		<script src="{{url('/assets/stat/js/jquery.circliful.js')}}"></script>
		<script>
			$( document ).ready(function() { // 6,32 5,38 2,34
				@foreach($stat_akta_bulan_ini as $key => $value)
				$(".test-circle{{$key}}").circliful({
					// animation: 1,
					// animationStep: 6,
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
					animationStep: 6,
					foregroundBorderWidth: 5,
					backgroundBorderWidth: 5,
					textBelow:true,
					percent: {{$value['percentage']}},
					textSize: 20,
					textStyle: 'font-size: 12px;',
					textColor: '#000',
					text: "{{$value['jenis']}}"

				});
				@endforeach
			});
		</script>
	</body>
</html>
