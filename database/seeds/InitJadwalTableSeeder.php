<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use TKlien\Klien\Models\Klien;

class InitJadwalTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('jadwal_pertemuan')->truncate();

		$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$login 			= TAuth::login($credentials);

		$faker			= \Faker\Factory::create();

		$hari 			= ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
		$j_jadwal 		= ['Akta Jual Beli', 'Akta Pemberian Hak Tanggungan', 'Akta Fidusia', 'Akta Perjanjian Sewa'];
		$aktivitas 		= ['Penandatanganan', 'Pengambilan', 'Pengambilan Minuta', 'Pengajuan', 'Drafting'];

		//init draft
		foreach (range(0, 19) as $key) 
		{
			$client_1 		= Klien::kantor(TAuth::activeOffice()['kantor']['id'])->skip(rand(0,19))->first();
			$client_2 		= Klien::notid($client_1['id'])->kantor(TAuth::activeOffice()['kantor']['id'])->skip(rand(0,18))->first();

			$data 			= [
				'judul'		=> $aktivitas[rand(0,4)].' '.$j_jadwal[rand(0,3)],
				'waktu'		=> Carbon::parse('+ '.rand(2,60).' days')->format('d/m/Y H:i'),
				'pembuat'		=> [
					'kantor'	=> TAuth::activeOffice()['kantor']
				],
				'peserta'	=> [
					[
						'id'	=> $client_1['id'],
						'nama'	=> $client_1['nama'],
					],
					[
						'id'	=> $client_2['id'],
						'nama'	=> $client_2['nama'],
					],
				],
				'tempat'	=> $faker->address,
			];

			$data['agenda']	= $data['judul'];

			$Jadwal 			= new \TCommands\Jadwal\BuatJadwalPertemuan($data);
			$Jadwal->handle();
		}
	}
}
