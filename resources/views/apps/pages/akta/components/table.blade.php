<table class="table table-hover table-responsive table-action">
	<thead>
		<tr>
			<th>Dokumen</th>
			<th>Jenis</th>
			<th>Pihak</th>
			<th>Status</th>
			<th>Tgl Pembuatan</th>
			@if (isset($mode))
				<th></th>
			@endif
		</tr>
	</thead>
	@isset ($akta)
		<tbody>
			@foreach ($akta as $k => $v)
				<tr id="{{ $v['id'] }}" @if (!isset($mode)) style="cursor: pointer" data-url="{{ route('akta.akta.ajax.show', ['id' => $v['id']]) }}" @endif>
					<td><i class="fa fa-file-o"></i> {{ $v['judul'] }}</td>
					<td>{{ str_replace('_', ' ', $v['jenis']) }}</td>
					<td>
						@isset ($v['pemilik']['klien'])
							<ol>
								@foreach ($v['pemilik']['klien'] as $k2 => $v2)
									<li>{{ $v2['nama'] }}</li>
								@endforeach
							</ol>
						@endisset
					</td>
					<td>{{ str_replace('_', ' ', $v['status']) }}</td>
					<td>{{ $v['tangal_pembuatan'] }}</td>
					@if (isset($mode))
						<th><a href="{{ route('akta.akta.data.choose', ['id' => $v['id']]) }}" class="btn btn-sm btn-primary">Pilih</a></th>
					@endif
				</tr>
			@endforeach
		</tbody>
	@endisset

	@empty ($akta)
		<tbody>
			<tr>
				<td class="text-center" colspan="5">tidak ada dokumen</td>
			</tr>
		</tbody>
	@endempty
</table>