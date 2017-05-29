<?php

namespace App\Service\Akta\Traits;

use App\Domain\Order\Models\Klien;

/**
 * Trait untuk otomatis enhance klien
 *
 * @author     C Mooy <chelsymooy1108@gmail.com>
 */
trait EnhanceKlienTrait {
 	

	/**
	 * Simpan Data Klien Berdasarkan mention pihak
	 *
	 * @return array $pemilik
	 */
	private function enhance_klien($pihak)
	{
		$akta['klien']				= [];
		
		foreach ((array)$pihak as $key => $value) 
		{
			if(isset($value['ktp']['nomor_ktp']))
			{
				$new_pihak 					= Klien::where('ktp.nomor_ktp', $value['ktp']['nomor_ktp'])->kantor($this->activeOffice['kantor']['id'])->first();

				if(!$new_pihak)
				{
					$new_pihak 				= new Klien;
					$is_new 				= true;
				}
			}
			elseif(isset($value['akta_pendirian']['nomor']))
			{
				$new_pihak 					= Klien::where('akta_pendirian.nomor', $value['akta_pendirian']['nomor'])->kantor($this->activeOffice['kantor']['id'])->first();

				if(!$new_pihak)
				{
					$new_pihak 				= new Klien;
					$is_new 				= true;
				}
			}
			else
			{
				$new_pihak 					= new Klien;
			}

			$new_pihak 						= $new_pihak->fill($value);

			$new_pihak->kantor				= ['id' => $this->activeOffice['kantor']['id'],'nama' => $this->activeOffice['kantor']['nama']];
			$new_pihak->save();

			$akta['klien'][$key]['id']	= $new_pihak['id'];
			$akta['klien'][$key]['nama']= $new_pihak['nama'];
		}

		return $akta['klien'];
	}
}