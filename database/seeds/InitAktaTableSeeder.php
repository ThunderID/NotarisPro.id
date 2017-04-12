<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class InitAktaTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('immigration_pengguna')->truncate();
		DB::table('akta_dokumen')->truncate();

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
				'nama'	=> 'Kantor Pejabat Pembuat Akta Tanah Anna Wong'
			],
		];
		$visa_2 		= [
			'role'		=> 'drafter',
			'kantor'	=> [
				'id'	=> 'NOTARISPAULUS',
				'nama'	=> 'Kantor Notaris Paulus Oliver'
			],
		];
		dispatch(new TCommands\ACL\GrantVisa($pengguna->_id, $visa_1));
		dispatch(new TCommands\ACL\GrantVisa($pengguna->_id, $visa_2));

		$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$login 			= TAuth::login($credentials);

		$faker			= \Faker\Factory::create();

		$hari 			= ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
		$j_akta 		= ['Akta Jual Beli', 'Akta Pemberian Hak Tanggungan', 'Akta Fidusia', 'Akta Perjanjian Sewa'];

		//init draft
		foreach (range(0, 19) as $key) 
		{
			$isi				= [
				'judul'			=> $j_akta[rand(0,3)],
				'paragraf'		=> [
					['konten' 	=> 'Pada hari ini '.$hari[rand(0,6)].' tanggal .... Hadir dihadapan saya '.$faker->name.' '.$faker->text],
					['konten' 	=> 'Pada hari ini '.$hari[rand(0,6)].' tanggal .... Hadir dihadapan saya '.$faker->name.' '.$faker->text],
				],
				'pemilik'		=> ['klien' => ['id' => $faker->ean13, 'nama' => $faker->name]]
			];

			$akta 			= new \TCommands\Akta\DraftingAkta($isi);
			$akta->handle();
		}

		//init pengajuan
		$dokumen 		= TAkta\DokumenKunci\Models\Dokumen::skip(0)->take(8)->get();

		foreach ($dokumen as $key => $value) 
		{
			$akta 			= new \TCommands\Akta\AjukanAkta($value->id);
			$akta->handle();
		}

		//init renvoi
		$dokumen 		= TAkta\DokumenKunci\Models\Dokumen::skip(0)->take(3)->get();

		foreach ($dokumen as $key => $value) 
		{
			$paragraf_ids 	= [$value->paragraf[rand(0,1)]['lock']];

			$akta 			= new \TCommands\Akta\TandaiRenvoi($value->id, $paragraf_ids);
			$akta->handle();
		}

		//init update
		$dokumen 		= TAkta\DokumenKunci\Models\Dokumen::skip(0)->take(3)->get();

		foreach ($dokumen as $key => $value) 
		{
			$edited 	= $value->toArray();

			if(is_null($edited['paragraf'][0]['lock']))
			{
				$edited['paragraf'][0]['konten'] 	= 'edited '.$edited['paragraf'][0]['konten'];
			}

			if(is_null($edited['paragraf'][1]['lock']))
			{
				$edited['paragraf'][1]['konten'] 	= 'edited '.$edited['paragraf'][1]['konten'];
			}

			$akta 		= new \TCommands\Akta\SimpanAkta($edited);
			$akta->handle();
		}
	}
}
