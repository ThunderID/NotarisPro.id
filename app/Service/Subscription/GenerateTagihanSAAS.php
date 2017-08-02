<?php

namespace App\Service\Subscription;

use App\Domain\Admin\Models\Kantor;
use App\Domain\Admin\Models\Pengguna;

use App\Domain\Order\Models\HeaderTransaksi;
use App\Domain\Order\Models\DetailTransaksi;

use Exception, TAuth, Carbon\Carbon;

class GenerateTagihanSAAS
{
	use TextParseTrait;
	use AssignAktaTrait;

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
	public function bulanan($month = Carbon::parse('- 1 month')->startOfDay())
	{
		$kantor 		= Kantor::wherenull('deleted_at')->orwhere('deleted_at', '>' $month->format('Y-m-d H:i:s'));

		foreach ($kantor as $k_key => $k_value) 
		{
			$total_counter 	= 0;
			$total_tagihan 	= 0;
			$user 		= Pengguna::where('visas.kantor.id', $value['id'])->get();

			foreach ($user as $u_key => $u_value) 
			{
				foreach ($u_value['visas'] as $v_key => $v_value) 
				{
					if(in_array($v_value['type'], ['starter']) && $v_value['expired_at'] > $month->format('Y-m-d') && $v_value['kantor']['id'] == $k_value['id'])
					if(in_array($v_value['type'], ['starter']) && $v_value['expired_at'] > $month->format('Y-m-d'))
					{
						$day_range 		= Carbon::parse($v_value['started_at'])->diffInDays($month);
						$that_day 		= cal_days_in_month(CAL_GREGORIAN,$month->format('m'),$month->format('Y'));

						$day_range 		= min($day_range, $that_day);

						$total_counter 	= $total_counter + 1;
						if($total_counter < = 2)
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

			$input['klien']		= json_encode(['nama' => $kantor->nama, 'alamat' => $kantor->address]);
			$input['nomor']		= self::createID('billing');
			$input['status']	= 'pending';
			$input['tipe']		= 'bukti_kas_keluar';
			$input['tanggal_dikeluarkan']		= '2017-01-01 00:00:00';
			$input['tanggal_jatuh_tempo']		= '2017-04-01 00:00:00';

			$tagihan->fill($input);
			$tagihan->save();

			$detail 		= new DetailTransaksi;
			$detail->fill(['item' => 'Tagihan Bulan '.$month->format('M'), 'deskripsi' => count($total_counter).' User ']);
			$detail->kuantitas 		= 1;
			$detail->harga_satuan 	= $total_tagihan;
			$detail->diskon_satuan 	= 0;
			$detail->header_transaksi_id 	= $tagihan->id;
			$detail->save():
		}

		return true;
	}
}