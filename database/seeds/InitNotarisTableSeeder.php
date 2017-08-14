<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class InitNotarisTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('immigration_pengguna')->truncate();
		DB::table('kantor_notaris')->truncate();

		$pengguna 	= [
						'email'		=> 'admin@notaris.id',
						'nama'		=> 'Ms. Notary',
						'password'	=> 'admin',
		];

		$usa 		= new App\Service\Admin\PenggunaBaru($pengguna['nama'],$pengguna['email'],$pengguna['password']);
		$usa 		= $usa->handle();
		
		$pengguna 	= App\Domain\Admin\Models\Pengguna::first();

		$visa_1 		= [
			'role'		=> 'notaris',
			'expired_at'=> Carbon::now()->addMonths(1)->format('Y-m-d H:i:s'),
			'started_at'=> Carbon::now()->format('Y-m-d H:i:s'),
			'type'		=> 'starter',
			'kantor'	=> [
				'id'	=> 'PPATANNAWONG',
				'nama'	=> 'Notaris & PPAT Anna Wong, SH'
			],
		];
		$grant_v_1 		= new App\Service\Admin\GrantVisa($pengguna->id, $visa_1['role'], $visa_1['type'], $visa_1['started_at'], $visa_1['expired_at'], $visa_1['kantor']['id'], $visa_1['kantor']['nama']);
		$grant_v_1 		= $grant_v_1->handle();



		$pengguna_2 	= [
						'email'		=> 'drafter@notaris.id',
						'nama'		=> 'Ms. Drafter',
						'password'	=> 'admin',
		];
		$usa_2 		= new App\Service\Admin\PenggunaBaru($pengguna_2['nama'],$pengguna_2['email'],$pengguna_2['password']);
		$usa_2 		= $usa_2->handle();

		$visa_2 		= [
			'role'		=> 'drafter',
			'expired_at'=> Carbon::now()->addMonths(1)->format('Y-m-d H:i:s'),
			'started_at'=> Carbon::now()->format('Y-m-d H:i:s'),
			'type'		=> 'starter',
			'kantor'	=> [
				'id'	=> 'NOTARISPAULUS',
				'nama'	=> 'Notaris Paulus Oliver Yoesoef, SH'
			],
		];

		$grant_v_2 		= new App\Service\Admin\GrantVisa($usa_2['id'], $visa_2['role'], $visa_2['type'], $visa_2['started_at'], $visa_2['expired_at'], $visa_2['kantor']['id'], $visa_2['kantor']['nama']);
		$grant_v_2 		= $grant_v_2->handle();

		$notaris_1 		= [
			'_id'						=> 'PPATANNAWONG',
			'nama'						=> 'Notaris & PPAT Anna Wong, SH',
			'notaris'					=> [
				'nama'					=> 'Anna Wong, Sarjana Hukum',
				'daerah_kerja'			=> 'Kota Jakarta Utara',
				'nomor_sk'				=> '14-X.A-2003',
				'tanggal_pengangkatan'	=> '4/12/2003',
				'alamat'				=> 'Jl Raya Mangga Dua Grand Boutique Centre Bl A/9',
				'telepon'				=> '0216018828',
				'logo_url'				=> 'https://s3.amazonaws.com/Athlete-Endeavors-Staging/athletes/signature_images/000/000/026/standard/A_Winslow_Signature_Black.png?1395846955',
				// 'fax'					=> '0216018828',
			]
		];

		$notaris_2 		= [
			'_id'						=> 'NOTARISPAULUS',
			'nama'						=> 'Notaris Paulus Oliver Yoesoef, SH',
			'notaris'					=> [
				'nama'					=> 'Paulus Oliver Yoesoef, Sarjana Hukum',
				'daerah_kerja'			=> 'Kota Malang',
				'nomor_sk'				=> '14-X.A-2000',
				'tanggal_pengangkatan'	=> '7/8/2000',
				'alamat'				=> 'Jl. Telomoyo No. 5 Malang',
				'telepon'				=> '0341-555588',
				'logo_url'				=> 'https://s3.amazonaws.com/Athlete-Endeavors-Staging/athletes/signature_images/000/000/026/standard/A_Winslow_Signature_Black.png?1395846955',
				// 'fax'					=> '0216018828',
			]
		];

		$simpan_notaris_1 	= new App\Domain\Admin\Models\Kantor;
		$simpan_notaris_1->fill($notaris_1);
		$simpan_notaris_1->save();

		$simpan_notaris_2 	= new App\Domain\Admin\Models\Kantor;
		$simpan_notaris_2->fill($notaris_2);
		$simpan_notaris_2->save();
	}

}
