<?php

namespace App\Service\Subscription;

use App\Domain\Admin\Models\Kantor;
use App\Domain\Admin\Models\Pengguna;

use App\Domain\Order\Models\HeaderTransaksi;
use App\Domain\Order\Models\DetailTransaksi;

use Exception, TAuth, Carbon\Carbon;

use App\Infrastructure\Traits\GuidTrait;
use App\Infrastructure\Traits\IDRTrait;

class GenerateTagihanSAAS
{
	use GuidTrait;
	use IDRTrait;

	/**
	 * Create new instance.
	 *
	 * @param  string $judul
	 * @param  array $paragraf
	 * @return GenerateTagihanSAAS $akta
	 */
	// public function __construct()
	// {
	// }

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

			$bulan_lalu = Carbon::createFromFormat('Y-m-d H:i:s', $month->format('Y-m-d H:i:s'));
			$bulan_lalu->subMonths(1);
		}
		else
		{
			$bulan_lalu = Carbon::createFromFormat('Y-m-d H:i:s', $month->format('Y-m-d H:i:s'));
			$bulan_lalu->subMonths(1);
		}

		$kantor 		= Kantor::wherenull('deleted_at')->orwhere('deleted_at', '>', $month->format('Y-m-d H:i:s'))->get();

		//1. untuk setiap kantor
		foreach ($kantor as $k_key => $k_value) 
		{
			//2. check tagihan bulan lalu
			$prev_numb			= $this->generateNomorTagihan($k_value->id, $bulan_lalu);
			$latest_invoice 	= HeaderTransaksi::where('nomor', $prev_numb)->kantor($k_value['id'])->first();
			$total_tagihan 		= 0;
			$total_counter 		= 0;

			$joined_users 		= Pengguna::kantor($k_value['id'])->where('visas.type', 'starter')->where(function($query)use($month)
			{
			    $query->wherenull('deleted_at')
			          ->orWhere('deleted_at', '<=', $month->format('Y-m-d H:i:s'));
			})->withTrashed()->orderby('visas.started_at', 'asc')->get()->toArray();

			//2a. kalau ada transaksi sebelum
			if($latest_invoice)
			{
				//2a1. kalau transaksi sebelum + 1 bulan = today
				if($latest_invoice->tanggal_dikeluarkan == $bulan_lalu->format('d/m/Y'))
				{
					//2a1a. untuk setiap user
					foreach ($joined_users as $j_uk => $j_uv) 
					{
						//2a1a1. kalau counter <= 2
						if($total_counter < 2 && $j_uv['visas'][0]['type']=='starter')
						{
							$total_tagihan 	= 500000;
							$total_counter 	= $total_counter + 1;
						}
						//2a1a2. kalau counter <= 5
						elseif($total_counter < 5 && $j_uv['visas'][0]['type']=='starter')
						{
							//transaksi sebelum = 30 hari
							$total_hari_mulai 	= Carbon::now()->diffInDays(Carbon::parse($j_uv['visas'][0]['started_at']));
							$hari 				= min(30, $total_hari_mulai);

							if(!is_null($j_uv['deleted_at']))
							{
								$total_hari_sls	= Carbon::now()->diffInDays(Carbon::parse($j_uv['deleted_at']));
								$hari 			= $hari - $total_hari_sls;
							}
							$total_tagihan 		= $total_tagihan + ((225000/30)*$hari);
						}
						//2a1a3. kalau counter >5
						elseif($j_uv['visas'][0]['type']=='starter')
						{
							//transaksi sebelum = 30 hari
							$total_hari_mulai 	= Carbon::now()->diffInDays(Carbon::parse($j_uv['visas'][0]['started_at']));
							$hari 				= min(30, $total_hari_mulai);

							if(!is_null($j_uv['deleted_at']))
							{
								$total_hari_sls	= Carbon::now()->diffInDays(Carbon::parse($j_uv['deleted_at']));
								$hari 			= $hari - $total_hari_sls;
							}
							$total_tagihan 		= $total_tagihan + ((200000/30)*$hari);
						}
					}
				}
			}
			else
			{
				$flag 	= 0;

				//2a2. untuk setiap user
				foreach ((array)$joined_users as $j_uk => $j_uv) 
				{
					$date_diff 		= Carbon::createFromFormat('Y-m-d H:i:s', $j_uv['visas'][0]['started_at'])->diffInDays($bulan_lalu);

					//kalau user terlama sudah bekerja selama sebulan
					if((!$flag && $date_diff >= 30) || $flag)
					{
						$flag 	= 1;
	
						//2a2a. kalau counter <= 2
						if($total_counter <= 2 && $j_uv['visas'][0]['type']=='starter')
						{
							//2a2a1. check diff days
							$hari_hari_terlewati_syalalala 	= $month->diffInDays(Carbon::parse($j_uv['visas'][0]['started_at']));

							$max 			= 500000;
							if($hari_hari_terlewati_syalalala > 30)
							{
								$max 		= ceil($hari_hari_terlewati_syalalala/30) * 500000;
							}

							$total_tagihan 	= $total_tagihan + ceil($hari_hari_terlewati_syalalala/30) * 250000;
							$total_tagihan 	= max($max, $total_tagihan);

							$total_counter 	= $total_counter + 1;
						}
						//2a2b. kalau counter <= 5
						elseif($total_counter <= 5 && $j_uv['visas'][0]['type']=='starter')
						{
							//transaksi sebelum = 30 hari
							$total_hari_mulai 	= Carbon::now()->diffInDays(Carbon::parse($j_uv['visas'][0]['started_at']));
							$hari 				= min(30, $total_hari_mulai);

							if(!is_null($j_uv['deleted_at']))
							{
								$total_hari_sls	= Carbon::now()->diffInDays(Carbon::parse($j_uv['deleted_at']));
								$hari 			= $hari - $total_hari_sls;
							}
							$total_tagihan 		= $total_tagihan + (ceil($hari/30) * 225000);
						}
						//2a2c. kalau counter >5
						elseif($j_uv['visas'][0]['type']=='starter')
						{
							//transaksi sebelum = 30 hari
							$total_hari_mulai 	= Carbon::now()->diffInDays(Carbon::parse($j_uv['visas'][0]['started_at']));
							$hari 				= min(30, $total_hari_mulai);

							if(!is_null($j_uv['deleted_at']))
							{
								$total_hari_sls	= Carbon::now()->diffInDays(Carbon::parse($j_uv['deleted_at']));
								$hari 			= $hari - $total_hari_sls;
							}
							$total_tagihan 		= $total_tagihan + (ceil($hari/30) * 200000);
						}
					}
				}
			}

			if($total_tagihan > 0)
			{
				// $total_tagihan 		= max($total_tagihan, 500000);
				$input['nomor']		= $this->generateNomorTagihan($k_value->id, $month);

				$tagihan 			= HeaderTransaksi::where('nomor', $input['nomor'])->first();
				if(!$tagihan)
				{
					$tagihan 		= new HeaderTransaksi;
				}

				$input['kantor_id']	= $k_value->id;
				$input['klien']		= json_encode(['id' => $k_value->id, 'nama' => $k_value->nama, 'alamat' => $k_value->address]);
				$input['status']	= 'pending';
				$input['tipe']		= 'bukti_kas_keluar';
				$input['tanggal_dikeluarkan']	= $month->format('d/m/Y');
				$input['tanggal_jatuh_tempo']	= $month->addMonths(1)->format('d/m/Y');

				$tagihan->fill($input);
				$tagihan->save();

				foreach ($tagihan->details as $keys => $values) 
				{
					$values->delete();
				}

				$detail							= new DetailTransaksi;
				$detail->fill(['item' => 'Tagihan Bulan '.$month->format('M'), 'deskripsi' => $total_counter.' User ']);
				$detail->kuantitas 				= 1;
				$detail->harga_satuan 			= $this->formatMoneyTo($total_tagihan);
				$detail->diskon_satuan 			= $this->formatMoneyTo(0);
				$detail->header_transaksi_id 	= $tagihan->id;
				$detail->save();
			}
		}

		return true;
	}

	private function generateNomorTagihan($kantor_id, $tanggal)
	{
		return 'INVMN'.$kantor_id.$tanggal->format('m').$tanggal->format('y');
	}
}