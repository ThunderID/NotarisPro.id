<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class InitPengajuanAktaTableSeeder extends Seeder
{
	public function run()
	{
		$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$login 			= TAuth::login($credentials);

		$dokumen 		= TAkta\DokumenKunci\Models\Dokumen::skip(0)->take(8)->get();

		foreach ($dokumen as $key => $value) 
		{
			$akta 			= new \TCommands\Akta\AjukanAkta($value->id);
			$akta->handle();
		}
	}
}
