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
			//latest invoice
			$prev_numb			= $this->generateNomorTagihan($k_value->id, $month->subMonths('1'));
			$latest_invoice 	= HeaderTransaksi::where('nomor', $prev_numb)->first();
			$total_tagihan 		= 0;
			$month->addMonths('1');

			$user 				= Pengguna::where('visas.kantor.id', $k_value['id'])->where('visas.expired_at', '>=', '%'.$month->format('Y-m-d H:i:s'))->get();

			$total_counter 		= 0;
			$total_tagihan 		= 0;
			if($latest_invoice)
			{
				foreach ($user as $u_key => $u_value) 
				{
					foreach ($u_value['visas'] as $v_key => $v_value) 
					{
						if(in_array($v_value['type'], ['starter']) && $v_value['kantor']['id'] == $k_value['id'])
						{
							$total_counter 	= $total_counter+1;
						
							if($v_value['started_at'] > $latest_invoice->tanggal_dikeluarkan->format('Y-m-d H:i:s'))
							{
								if($total_counter <=2)
								{
									$total_tagihan  = 500000;
								}
								elseif($total_counter <=5)
								{
									$total_tagihan 	= $total_tagihan + 200000;
								}
								else
								{
									$total_tagihan 	= $total_tagihan + 150000;
								}
							}
							else
							{
								if($total_counter <=2)
								{
									$total_tagihan  = 500000;
								}
								elseif($total_counter <=5)
								{
									$diff_days 		= Carbon::createFromFormat('Y-m-d H:i:s', $v_value['started_at'])->diffInDays($month);
									$total_tagihan 	= $total_tagihan + ((200000/30) * $diff_days);
								}
								else
								{
									$diff_days 		= Carbon::createFromFormat('Y-m-d H:i:s', $v_value['started_at'])->diffInDays($month);
									$total_tagihan 	= $total_tagihan + ((150000/30) * $diff_days);
								}

							}
						}
					} 
				}
			}

			// $total_tagihan 		= max($total_tagihan, 500000);

			$input['nomor']		= $this->generateNomorTagihan($k_value->id, $month);

			$tagihan 			= HeaderTransaksi::where('nomor', $input['nomor'])->first();
			if(!$tagihan)
			{
				$tagihan 		= new HeaderTransaksi;
			}

			$input['klien']		= json_encode(['id' => $k_value->id, 'nama' => $k_value->nama, 'alamat' => $k_value->address]);
			$input['status']	= 'pending';
			$input['tipe']		= 'bukti_kas_keluar';
			$input['tanggal_dikeluarkan']	= $month->format('Y-m-d H:i:s');
			$input['tanggal_jatuh_tempo']	= $month->addMonths(1)->format('Y-m-d H:i:s');

			$tagihan->fill($input);
			$tagihan->save();

			$detail							= new DetailTransaksi;
			$detail->fill(['item' => 'Tagihan Bulan '.$month->format('M'), 'deskripsi' => count($total_counter).' User ']);
			$detail->kuantitas 				= 1;
			$detail->harga_satuan 			= $total_tagihan;
			$detail->diskon_satuan 			= 0;
			$detail->header_transaksi_id 	= $tagihan->id;
			$detail->save();
		}

		return true;
	}

	private function generateNomorTagihan($kantor_id, $tanggal)
	{
		return 'INVMN'.$kantor_id.$tanggal->format('m').$tanggal->format('y');
	}
}