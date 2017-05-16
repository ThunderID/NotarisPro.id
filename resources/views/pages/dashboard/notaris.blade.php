@extends('templates.basic')

@push('fonts')
@endpush

@push('styles')  
@endpush  

{{-- Fuze --}}
<?php
	$stat_akta_bulan_ini = isset($page_datas->stat_akta_bulan_ini) ? $page_datas->stat_akta_bulan_ini : 0;
	$stat_total_drafter = isset($page_datas->stat_total_drafter) ? $page_datas->stat_total_drafter : 0;
	$stat_total_klien_baru = isset($page_datas->stat_total_klien_baru) ? $page_datas->stat_total_klien_baru : 0;
	$stat_tagihan = isset($page_datas->stat_tagihan) ? $page_datas->stat_tagihan : 0;
?>

@section('content')
	<div class="row">
		<div class="col-sm-12 col-sm-12 col-md-12 col-lg-12">
			<div class="clearfix">&nbsp;</div>
			<div class="row pt-3">

				@include('components.dashboardCard', [
					'value'	=> $stat_akta_bulan_ini,
					'title'	=> 'Total Akta Bulan Ini'
				])

				@include('components.dashboardCard', [
					'value'	=> $stat_total_drafter,
					'title'	=> 'Total Drafter'
				])					

				@include('components.dashboardCard', [
					'value'	=> $stat_total_klien_baru,
					'title'	=> 'Total Klien Baru'
				])

				@include('components.dashboardCard', [
					'value'	=> $stat_tagihan,
					'title'	=> 'Total Tagihan'
				])	

			</div>

			<div class="row">

				<div class="col-12 col-md-6 pb-4">
					<div class="card">
						<div class="card-block">

							<h5 class="card-title pb-2">Akta Menunggu Untuk di Cek</h5>

							<table class="table table-hover">
								<thead>
									<tr>
										<th>Dokumen</th>
										<th>Deadline</th>
									</tr>
								</thead>
								<tbody>
					                @forelse($page_datas->lists_to_check as $key => $value)
									<tr class="clickable-row" data-href="{{route('akta.akta.show', $value['id'])}}">
										<td>
											<i class="fa fa-file"></i>
											&nbsp;
											{{ $value['judul'] }}
										</td>
										<td>
											@if(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_pembuatan'])->diffInDays(Carbon\Carbon::now()) > 0)
												<span class="badge badge-info">
											@elseif(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_pembuatan'])->diffInDays(Carbon\Carbon::now()) == 0)
												<span class="badge badge-warning">
											@else
												<span class="badge badge-danger">
											@endif
												<small>{{$value['tanggal_pembuatan']}}</small>
											</span>
										</td>					
									</tr>
					                @empty
					                <tr>
					                    <td colspan="2" class="text-center">
					                        Tidak Ada Data
					                    </td>
					                </tr>
					                @endforelse
								</tbody>
							</table>

						</div>
					</div>
				</div>


				<div class="col-12 col-md-6 pb-4">
					<div class="card">
						<div class="card-block">

							<h5 class="card-title pb-2">Akta Published Terbaru</h5>

							<table class="table table-hover">
								<thead>
									<tr>
										<th>Dokumen</th>
										<th>Deadline</th>
									</tr>
								</thead>
								<tbody>
					                @forelse($page_datas->lists_akta as $key => $value)
									<tr class="clickable-row" data-href="{{route('akta.akta.show', $value['id'])}}">
										<td>
											<i class="fa fa-file"></i>
											&nbsp;
											{{ $value['judul'] }}
										</td>
										<td>
											@if(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_pembuatan'])->diffInDays(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_sunting'])) > 0)
												<span class="badge badge-info">
											@elseif(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_pembuatan'])->diffInDays(Carbon\Carbon::createFromFormat('d/m/Y', $value['tanggal_sunting'])) == 0)
												<span class="badge badge-warning">
											@else
												<span class="badge badge-danger">
											@endif
												<small>{{$value['tanggal_sunting']}}</small>
											</span>
										</td>					
									</tr>
					                @empty
					                <tr>
					                    <td colspan="2" class="text-center">
					                        Tidak Ada Data
					                    </td>
					                </tr>
					                @endforelse
								</tbody>
							</table>							

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@push('scripts')  
@endpush 
