<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class InitTemplateTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('akta_template')->truncate();

		$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$login 			= TAuth::login($credentials);

		$faker			= \Faker\Factory::create();

		$hari 			= ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
		$j_akta 		= ['Akta Jual Beli Perorangan dan Persero', 'Akta Pemberian Hak Tanggungan 3 Pihak Perorangan', 'Akta Fidusia 2 Pihak Perorangan', 'Akta Perjanjian Sewa Persero dengan Persero'];

		//drafting
		foreach (range(0, 19) as $key) 
		{
			$isi				= [
				'judul'			=> $j_akta[rand(0,3)],
				'paragraf'		=> [
					['konten' 	=> 'Pada hari ini '.$hari[rand(0,6)].' tanggal .... Hadir dihadapan saya '.$faker->name.' '.$faker->text],
					['konten' 	=> 'Pada hari ini '.$hari[rand(0,6)].' tanggal .... Hadir dihadapan saya '.$faker->name.' '.$faker->text],
				],
			];

			$akta 			= new \TCommands\Akta\DraftingTemplateAkta($isi);
			$akta->handle();
		}

		//init publish
		$dokumen 			= TAkta\DokumenKunci\Models\Template::skip(0)->take(8)->get();

		foreach ($dokumen as $key => $value) 
		{
			$akta 			= new \TCommands\Akta\PublishTemplateAkta($value->id);
			$akta->handle();
		}

		//init update
		$dokumen 		= TAkta\DokumenKunci\Models\Template::skip(0)->take(3)->get();

		foreach ($dokumen as $key => $value) 
		{
			$edited 	= $value->toArray();

			$edited['paragraf'][0]['konten'] 	= 'edited '.$edited['paragraf'][0]['konten'];
			$edited['paragraf'][1]['konten'] 	= 'edited '.$edited['paragraf'][1]['konten'];

			$akta 		= new \TCommands\Akta\SimpanTemplateAkta($edited);
			$akta->handle();
		}
	}
}
