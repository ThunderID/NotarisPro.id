<table class="table table-responsive">
	<thead>
		<tr>
			<th>Dokumen</th>
			<th>Jenis</th>
			<th>Pihak</th>
			<th>Status</th>
			<th>Tgl Pembuatan</th>
		</tr>
	</thead>
	@isset ($page_datas->akta)
		<tbody>
			@foreach ($page_datas->akta as $k => $v)
				<tr id="{{ $v['id'] }}">
					<td><i class="fa fa-file"></i> {{ $v['judul'] }}</td>
					<td>
						@isset ($v['pemilik']['klien'])
							<ol>
								@foreach ($v['pemilik']['klien'] as $k2 => $v2)
									<li>{{ $v2['nama'] }}</li>
								@endforeach
							</ol>
						@endisset
					</td>
					<td>{{ str_replace('_', ' ', $v['jenis']) }}</td>
					<td>{{ str_replace('_', ' ', $v['status']) }}</td>
					<td>{{ $v['tangal_pembuatan'] }}</td>
				</tr>
			@endforeach
		</tbody>
	@endisset

	@empty ($page_datas->akta)
		<tbody>
			<tr>
				<td class="text-center" colspan="5">tidak ada dokumen</td>
			</tr>
		</tbody>
	@endempty
</table>