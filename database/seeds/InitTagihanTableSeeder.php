<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use TKlien\Klien\Models\Klien;
use TTagihan\Tagihan\Models\Tagihan;

class InitTagihanTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('tagihan')->truncate();

		$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$login 			= TAuth::login($credentials);

		$faker			= \Faker\Factory::create();

		$deskripsi 		= ['Akta Jual Beli', 'Akta Pemberian Hak Tanggungan', 'Akta Fidusia', 'Akta Perjanjian Sewa'];

		//init draft
		foreach (range(0, 19) as $key) 
		{
			$klien 		= Klien::kantor(TAuth::activeOffice()['kantor']['id'])->skip(rand(0,19))->first();

			$data 			= [
				'nomor'					=> Tagihan::createID('nomor'),
				'tanggal_dikeluarkan'	=> Carbon::parse(rand(-15, 15).' days')->format('d/m/Y'),
				'details'				=> [[
					'deskripsi'			=> 'Pesanan '.$deskripsi[rand(0,3)],
					'harga_satuan'		=> 'Rp '.rand(1,10).'.000.000',
					'diskon_satuan'		=> 'Rp '.number_format(rand(0,250000),0, "," ,"."),
					'jumlah_item'		=> rand(1,3),
				]],
				'oleh'					=> TAuth::activeOffice()['kantor'],
				'untuk'					=> ['id' => $klien['id'], 'nama' => $klien['nama']],
			];

			$data['tanggal_jatuh_tempo']	= Carbon::createFromFormat('d/m/Y', $data['tanggal_dikeluarkan'])->addDays(rand(0,60))->format('d/m/Y');

			$tagihan 			= new \TCommands\Tagihan\BuatTagihan($data);
			$tagihan->handle();
		}
	}
}
