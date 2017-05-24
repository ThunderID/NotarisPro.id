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
		$akta['pemilik']				= [];
		
		foreach ((array)$pihak as $key => $value) 
		{
			$is_new 					= false;

			$new_pihak 					= Klien::where('nomor_ktp', $value['nomor_ktp'])->first();

			if(!$new_pihak)
			{
				$new_pihak 				= new Klien;
				$is_new 				= true;
			}

			$new_pihak 					= $new_pihak->fill($value);
			$new_pihak['kantor']		= ['id' => $this->activeOffice['kantor']['id'],'nama' => $this->activeOffice['kantor']['nama']];
			$new_pihak->save();

			$akta['pemilik']['klien'][$key]['id'] 		= $new_pihak['id'];
			$akta['pemilik']['klien'][$key]['nama'] 	= $new_pihak['nama'];
		}

		return $akta['pemilik'];
	}
}