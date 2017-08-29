<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Domain\Invoice\Models\HeaderTransaksi;
use App\Domain\Invoice\Models\DetailTransaksi;
use App\Domain\Invoice\Models\Arsip;
use App\Domain\Admin\Models\Pengguna;
use App\Infrastructure\Traits\IDRTrait;

class InitTagihanTableSeeder extends Seeder
{
	use IDRTrait;

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
		foreach (range(0, 2) as $key) 
		{
			$klien 			= Arsip::whereIn('jenis', ['akta_pendirian', 'ktp'])->kantor(TAuth::activeOffice()['kantor']['id'])->skip(rand(0,19))->first()->toArray();

			$parse_month 	= rand(-12, -2);
			$data 			= [
				'klien'					=> ['id' => $klien['id'], 'nama' => (isset($klien['isi']['nama']) ? $klien['isi']['nama'] : $klien['isi']['nama']), 'alamat' => (isset($klien['isi']['alamat']) ? $klien['isi']['alamat'] : '')],
				'kantor_id'				=> TAuth::activeOffice()['kantor']['id'],
				'nomor'					=> rand(234289849248924,999999999999999),
				'tipe'					=> 'bukti_kas_masuk',
				'tanggal_dikeluarkan'	=> Carbon::parse($parse_month.' months')->format('d/m/Y'),
				'tanggal_jatuh_tempo'	=> Carbon::parse($parse_month.' months')->addMonths(1)->format('d/m/Y'),
				'status'				=> 'pending',
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
				'harga_satuan'				=> $this->formatMoneyTo($harga_satuan[rand(0,3)]),
				'diskon_satuan'				=> $this->formatMoneyTo($harga_satuan[rand(0,3)] *0.25),
			];

			$tdetail 	= new DetailTransaksi;
			$tdetail->fill($data_detail);
			$tdetail->save();
		}

		//billing keluar
		// $data 			= [
		// 	'kantor_id'				=> TAuth::activeOffice()['kantor']['id'],
		// 	'nomor'					=> rand(234289849248924,999999999999999),
		// 	'status'				=> 'pending',
		// 	'tipe'					=> 'bukti_kas_masuk',
		// 	'tanggal_dikeluarkan'	=> Carbon::parse('first day of next month')->format('d/m/Y'),
		// 	'tanggal_jatuh_tempo'	=> Carbon::parse('first day of next month')->addMonths(1)->format('d/m/Y'),
		// ];

		// $tagihan 	= new HeaderTransaksi;
		// $tagihan->fill($data);
		// $tagihan->save();

		// $user 		= TAuth::loggedUser();

		// $user 		= Pengguna::id($user['id'])->first();

		// $biaya 		= $this->formatMoneyTo(Carbon::parse('first day of next month')->diffInDays($user->created_at) *(250000/30));

		// //details
		// $data_detail 			= [
		// 	'header_transaksi_id'		=> $tagihan->id,
		// 	'item'						=> 'Tagihan Mitra Notaris Bulan '.Carbon::now()->format('M-Y'),
		// 	'deskripsi'					=> 'Tagihan Bulanan',
		// 	'kuantitas'					=> 1,
		// 	'harga_satuan'				=> $biaya,
		// 	'diskon_satuan'				=> 'Rp 0',
		// ];

		// $tdetail 	= new DetailTransaksi;
		// $tdetail->fill($data_detail);
		// $tdetail->save();

		//bukti kas masuk
		// foreach(range(0, 5) as $key2)
		// {
		// 	$ht 		= HeaderTransaksi::where('kantor_id', TAuth::activeOffice()['kantor']['id'])->where('tipe', 'bukti_kas_keluar')->skip(rand(0,19))->first();
		// 	$td 		= DetailTransaksi::where('header_transaksi_id', $ht['id'])->get();

		// 	$bkm 		= new HeaderTransaksi;
		// 	$bkm->kantor_id				= $ht['kantor_id'];
		// 	$bkm->nomor					= rand(234289849248924,999999999999999);
		// 	// $bkm->referensi_id 			= $ht['id'];
		// 	$bkm->status 				= 'pending';
		// 	$bkm->tipe 					= 'bukti_kas_masuk';
		// 	$bkm->tanggal_dikeluarkan 	= Carbon::now()->format('d/m/Y');
		// 	$bkm->save();

		// 	foreach ($td as $key => $value) 
		// 	{
		// 		$bkm_dt 						= new DetailTransaksi;
		// 		$bkm_dt->header_transaksi_id 	= $bkm->id;
		// 		$bkm_dt->item 					= $value->item;
		// 		$bkm_dt->deskripsi 				= $value->deskripsi;
		// 		$bkm_dt->kuantitas 				= 1;
		// 		$bkm_dt->harga_satuan 			= $value->harga_satuan;
		// 		$bkm_dt->diskon_satuan 			= 'Rp 0';
				
		// 		$bkm_dt->save();
		// 	}
		// }

		// //bukti kas keluar
		// $details 			= ['Bayar Air', 'Bayar Listrik', 'Gaji Pegawai', 'Bayar Internet'];
		// $prices 			= [300000, 500000, 30000000, 500000];
		// foreach(range(0, 3) as $key2)
		// {
		// 	$bkk 						= new HeaderTransaksi;
		// 	$bkk->kantor_id				= TAuth::activeOffice()['kantor']['id'];
		// 	$bkk->nomor					= rand(234289849248924,999999999999999);
		// 	$bkk->tipe 					= 'bukti_kas_keluar';
		// 	$bkk->status 				= 'pending';
		// 	$bkk->tanggal_dikeluarkan 	= Carbon::now()->format('d/m/Y');
		// 	$bkk->save();

		// 	foreach ($td as $key => $value) 
		// 	{
		// 		$bkk_dt 			= new DetailTransaksi;
		// 		$bkk_dt->header_transaksi_id 	= $bkk->id;
		// 		$bkk_dt->item 					= $details[$key2];
		// 		$bkk_dt->deskripsi 				= $details[$key2];
		// 		$bkk_dt->kuantitas 				= 1;
		// 		$bkk_dt->harga_satuan 			= $this->formatMoneyTo($prices[$key2]);
		// 		$bkk_dt->diskon_satuan 			= 'Rp 0';
		// 		$bkk_dt->save();
		// 	}
		// }
	}
}
