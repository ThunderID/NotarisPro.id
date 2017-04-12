<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class InitKlienTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('notaris_klien')->truncate();

		$pekerjaan 	= ['Direktur ', 'Karyawan ', 'Manager ', 'Supervisor '];
		$kab 		= ['Banyuwangi', 'Gresik', 'Kediri', 'Lamongan', 'Magetan', 'malang', 'Mojokerto', 'Pamekasan', 'Pasuruan', 'Ponorogo', 'Situbondo', 'Sumenep', 'Tuban', 'Bangkalan', 'Bondowoso', 'Jember', 'Ngawi', 'Pacitan', 'Sampang', 'tulungagung', 'Blitar', 'Bojonegoro', 'Jombang', 'Lumajang', 'Madiun', 'Nganjuk', 'Probolinggo', 'Sidoarjo', 'Trenggalek'];
		
		$faker			= \Faker\Factory::create();
		
		$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$login 			= TAuth::login($credentials);
		
		foreach (range(0, 19) as $key) 
		{
			$data 	= [
				'nama'				=> $faker->name,
				'tempat_lahir'		=> $kab[rand(0,28)],
				'tanggal_lahir'		=> Carbon::parse(' - '.rand(17,71).' years')->format('d/m/Y'),
				'pekerjaan'			=> $pekerjaan[rand(0,3)].$faker->company,
				'alamat'			=> [
					'alamat'			=> $faker->address,
					'rt'				=> '00'.rand(0,9),
					'rw'				=> '00'.rand(0,9),
					'regensi'			=> $kab[rand(0,28)],
					'provinsi'			=> 'Jawa Timur',
					'negara'			=> 'Indonesia',
				],
				'nomor_ktp'			=> $faker->ean13,
			];

			$akta 			= new \TCommands\Klien\SimpanKlien($data);
			$akta->handle();
		}
	}
}
