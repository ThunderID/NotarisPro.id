<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Thunderlabid\Billing\Models\Tagihan;

use Carbon\Carbon;

class TagihanTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('tagihan')->truncate();
		DB::table('tagihan_detail')->truncate();

		$deskripsi 		= 	[
			'Pembuatan Akta Perjanjian Pengikatan Jual Beli',
			'Pembuatan Akta Jual Beli',
			'Pembuatan Akta PPAT',
			'Pembuatan Akta Surat Kuasa Membebankan Hak Tanggungan',
			'Pembuatan Akta Notaril Objek Diluar Wilayah Kerja',
			'Pembuatan Akta Pembebankan Hak Tanggungan',
			'Pembuatan Perjanjian Fidusia',
		];

		foreach (range(0, 19) as $key) 
		{
			$faker		= \Faker\Factory::create();
			
			$tagihan	= [
					'dikeluarkan_oleh'		=> $faker->company,
					'dikeluarkan_untuk'		=> $faker->name,
					'nomor_tagihan'			=> 'S'.Carbon::parse(rand(2, 100).' days ago')->format('ymd').$key+1,
					'tanggal'				=> Carbon::parse(rand(2, 100).' days ago')->format('d/m/Y'),
			];

			$model		= new Tagihan;
			$model->fill($tagihan);

			$tdetail 	= rand(0,5);

			foreach (range(0, $tdetail) as $key) 
			{
				$t_det 	= [
					'deskripsi' 	=> $deskripsi[rand(0,6)],
					'jumlah' 		=> 'Rp '.number_format(rand(1000000,10000000),0, "," ,"."),
					'diskon' 		=> 'Rp '.number_format(rand(0,1000000),0, "," ,"."),
				];

				$model	= $model->addTagihanDetail($t_det);
			}

			$model->save();
		}
	}
}
