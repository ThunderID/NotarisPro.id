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

		dispatch(new TCommands\ACL\DaftarkanPengguna($pengguna));
		
		$pengguna 	= TImmigration\Pengguna\Models\Pengguna::first();

		$visa_1 		= [
			'role'		=> 'notaris',
			'kantor'	=> [
				'id'	=> 'PPATANNAWONG',
				'nama'	=> 'Notaris & PPAT Anna Wong, SH'
			],
		];
		$visa_2 		= [
			'role'		=> 'drafter',
			'kantor'	=> [
				'id'	=> 'NOTARISPAULUS',
				'nama'	=> 'Notaris Paulus Oliver Yoesoef, SH'
			],
		];
		dispatch(new TCommands\ACL\GrantVisa($pengguna->_id, $visa_1));
		dispatch(new TCommands\ACL\GrantVisa($pengguna->_id, $visa_2));

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
				// 'fax'					=> '0216018828',
			]
		];

		$simpan_notaris_1 	= new \TKantor\Notaris\Models\Notaris;
		$simpan_notaris_1->fill($notaris_1);
		$simpan_notaris_1->save();

		$simpan_notaris_2 	= new \TKantor\Notaris\Models\Notaris;
		$simpan_notaris_2->fill($notaris_2);
		$simpan_notaris_2->save();
	}

}
