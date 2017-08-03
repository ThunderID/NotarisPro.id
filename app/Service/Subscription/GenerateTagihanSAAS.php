<?php

namespace App\Service\Subscription;

use App\Domain\Admin\Models\Kantor;
use App\Domain\Admin\Models\Pengguna;

use App\Domain\Order\Models\HeaderTransaksi;
use App\Domain\Order\Models\DetailTransaksi;

use Exception, TAuth, Carbon\Carbon;

use App\Infrastructure\Traits\GuidTrait;

class GenerateTagihanSAAS
{
	use GuidTrait;

	/**
	 * Create new instance.
	 *
	 * @param  string $judul
	 * @param  array $paragraf
	 * @return GenerateTagihanSAAS $akta
	 */
	public function __construct()
	{
	}

	/**
	 * Simpan akta baru
	 *
	 * @return array $akta
	 */
	public function bulanan($month = null)
	{
		if(is_null($month))
		{
			$month 		= Carbon::now()->startOfDay();
		}

		$kantor 		= Kantor::wherenull('deleted_at')->orwhere('deleted_at', '>', $month->format('Y-m-d H:i:s'))->get();

		foreach ($kantor as $k_key => $k_value) 
		{
			$total_counter 	= 0;
			$total_tagihan 	= 0;
			$user 			= Pengguna::where('visas.kantor.id', $k_value['id'])->where('visas.started_at', 'like', '%'.$month->format('-d ').'%')->get();

			foreach ($user as $u_key => $u_value) 
			{
				foreach ($u_value['visas'] as $v_key => $v_value) 
				{
					if(in_array($v_value['type'], ['starter']) && $v_value['expired_at'] > $month->format('Y-m-d') && $v_value['kantor']['id'] == $k_value['id'])
					{
						$day_range 		= Carbon::parse($v_value['started_at'])->diffInDays($month);
						$awal_bulan 	= Carbon::parse('first day of '.$month->format('M Y'))->startOfDay();
						$akhir_bulan 	= Carbon::parse('first day of '.$month->addMonths(1)->format('M Y'))->startOfDay();

						$that_day 		= $awal_bulan->diffInDays($akhir_bulan);
						$day_range 		= min($day_range, $that_day);

						$total_counter 	= $total_counter + 1;
						if($total_counter <= 2)
						{
							$total_tagihan 	= $total_tagihan + ((250000/$that_day) * $day_range);
						}
						elseif($total_counter > 2 && $total_counter <= 5)
						{
							$total_tagihan 	= $total_tagihan + ((200000/$that_day) * $day_range);
						}
						elseif($total_counter > 5)
						{
							$total_tagihan 	= $total_tagihan + ((150000/$that_day) * $day_range);
						}
					}
				}
			}
			$total_tagihan 	= max($total_tagihan, 500000);

			$tagihan 		= new HeaderTransaksi;

			$input['klien']		= json_encode(['id' => $k_value->id, 'nama' => $k_value->nama, 'alamat' => $k_value->address]);
			$input['nomor']		= self::createID('billing');
			$input['status']	= 'pending';
			$input['tipe']		= 'bukti_kas_keluar';
			$input['tanggal_dikeluarkan']		= Carbon::now()->format('Y-m-d H:i:s');
			$input['tanggal_jatuh_tempo']		= Carbon::now()->addMonths(1)->format('Y-m-d H:i:s');

			$tagihan->fill($input);
			$tagihan->save();

			$detail 							= new DetailTransaksi;
			$detail->fill(['item' => 'Tagihan Bulan '.$month->format('M'), 'deskripsi' => count($total_counter).' User ']);
			$detail->kuantitas 					= 1;
			$detail->harga_satuan 				= $total_tagihan;
			$detail->diskon_satuan 				= 0;
			$detail->header_transaksi_id 		= $tagihan->id;
			$detail->save();
		}

		return true;
	}
}