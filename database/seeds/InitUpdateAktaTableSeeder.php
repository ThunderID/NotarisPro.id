<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class InitUpdateAktaTableSeeder extends Seeder
{
	public function run()
	{
		$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$login 			= TAuth::login($credentials);

		$dokumen 		= TAkta\DokumenKunci\Models\Dokumen::skip(0)->take(3)->get();

		foreach ($dokumen as $key => $value) 
		{
			$paragraf_ids 	= [$value->paragraf[rand(0,1)]['lock']];

			$akta 			= new \TCommands\Akta\TandaiRenvoi($value->id, $paragraf_ids);
			$akta->handle();
		}
	}
}
