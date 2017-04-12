<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class InitRenvoiAktaTableSeeder extends Seeder
{
	public function run()
	{
		$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$login 			= TAuth::login($credentials);

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
