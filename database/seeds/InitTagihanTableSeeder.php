<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Domain\Order\Models\HeaderTransaksi;
use App\Domain\Order\Models\DetailTransaksi;
use App\Domain\Order\Models\Klien;

class InitTagihanTableSeeder extends Seeder
{
	public function run()
	{
		DB::connection('mysql')->table('header_transaksi')->truncate();
		DB::connection('mysql')->table('detail_transaksi')->truncate();

		$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$login 			= TAuth::login($credentials);

		$faker			= \Faker\Factory::create();

		$deskripsi 		= ['Akta Jual Beli', 'Akta Pemberian Hak Tanggungan', 'Akta Fidusia', 'Akta Perjanjian Sewa'];
		$harga_satuan 	= [1000000,1500000,2000000,3000000];

		//init transaksi
		foreach (range(0, 19) as $key) 
		{
			$klien 		= Klien::kantor(TAuth::activeOffice()['kantor']['id'])->skip(rand(0,19))->first()->toArray();

			$parse_month 	= rand(-12, -2);
			$data 			= [
				'klien_id'				=> $klien['id'],
				'klien_nama'			=> $klien['nama'],
				'kantor_id'				=> TAuth::activeOffice()['kantor']['id'],
				'nomor_transaksi'		=> rand(234289849248924,999999999999999),
				'tipe'					=> 'billing_out',
				'tanggal_dikeluarkan'	=> Carbon::parse($parse_month.' months')->format('Y-m-d H:i:s'),
				'tanggal_jatuh_tempo'	=> Carbon::parse($parse_month.' months')->addMonths(1)->format('Y-m-d H:i:s'),
			];

			$tagihan 	= new HeaderTransaksi;
			$tagihan->fill($data);
			$tagihan->save();

			//details
			$data_detail 			= [
				'header_transaksi_id'		=> $tagihan->id,
				'item'						=> 'Jasa Pembuatan Akta',
				'deskripsi'					=> $deskripsi[rand(0,3)],
				'kuantitas'					=> 1,
				'harga_satuan'				=> $harga_satuan[rand(0,3)],
				'diskon_satuan'				=> $harga_satuan[rand(0,3)] *0.25,
			];

			$tdetail 	= new DetailTransaksi;
			$tdetail->fill($data_detail);
			$tdetail->save();
		}
	}
}
