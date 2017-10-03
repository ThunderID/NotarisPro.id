<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Thunderlabid\Arsip\Models\Arsip;
use Thunderlabid\Manajemen\Models\User;

class ArsipTableSeeder extends Seeder
{
	public function run()
	{
		DB::collection('ar_arsip')->truncate();

		$user 	= User::first();

		Arsip::create([
			'pemilik'   => ['nama' => 'John Doe'], 
			'kantor'   	=> ['id' => $user['access']['kantor']['id'], 'nama' => $user['access']['kantor']['nama']], 
			'dokumen' 	=> [[
								'id' => '00010001',
						 		'nama' => 'John Doe',
						 		'tempat_lahir' => 'Surabaya',
						 		'tanggal_lahir' => '12 Januari 1990',
						 		'pekerjaan' => 'Karyawan Swasta',
						 		'alamat' => 'Ruko Puri Niaga A10, Araya',
						 		'jenis'	=> 'ktp'
						 	],
						 	[
								'id' => '00010002',
						 		'nomor' => '504',
						 		'alamat' => ['provinsi' => 'Bali', 'kabupaten' => 'Badung', 'kecamatan' => 'Mengwi', 'kelurahan' => 'Gulingan', 'jalan' => 'Sadewo nomor 3'],
						 		'tanggal' => '10-07-1993 (Sepuluh Juli Seribu Sembilan Ratus Sembilan Puluh Tiga)',
						 		'nomor_gambar' => '660/93',
						 		'luas' => '400 M2',
						 		'nib' => '11.10.01.08.049',
						 		'nop' => '51.71.050.002.046-0061.0',
						 		'harga_jual' => 'Rp 2.000.000.000 (Dua Milyar Rupiah)',
						 		'jenis'	=> 'sertifikat'
						 	]
				]
		]);

		Arsip::create([
			'pemilik'   => ['nama' => 'Jane Doe'], 
			'kantor'   	=> ['id' => $user['access']['kantor']['id'], 'nama' => $user['access']['kantor']['nama']], 
			'dokumen' 	=> [[
								'id' => '00020001',
						 		'nama' => 'Jane Doe',
						 		'tempat_lahir' => 'Surabaya',
						 		'tanggal_lahir' => '3 Juli 1992',
						 		'pekerjaan' => 'Karyawan Swasta',
						 		'alamat' => 'Jl Letjen Sutoyo 102A, Blimbing',
						 		'jenis'	=> 'ktp'
						 	]]
		]);

		Arsip::create([
			'pemilik'   => ['nama' => 'Christian Doe'], 
			'kantor'   	=> ['id' => $user['access']['kantor']['id'], 'nama' => $user['access']['kantor']['nama']], 
			'dokumen' 	=> [[
								'id'	=> '00030001',
						 		'nama' => 'Christian Doe',
						 		'kewarganegaraan' => 'Indonesia',
						 		'jenis'	=> 'ktp'
						 	]]
		]);

		Arsip::create([
			'pemilik'   => ['nama' => 'Christine Doe'], 
			'kantor'   	=> ['id' => $user['access']['kantor']['id'], 'nama' => $user['access']['kantor']['nama']], 
			'dokumen' 	=> [[
								'id'	=> '00040001',
						 		'nama' => 'Christine Doe',
						 		'kewarganegaraan' => 'Indonesia',
						 		'jenis'	=> 'ktp'
							]]
		]);
	}
}