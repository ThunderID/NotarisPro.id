<?php

namespace App\Service\Akta\Traits;

/**
 * Trait untuk assign log user dkk
 *
 * need to make independent from variable tauth
 * @author     C Mooy <chelsymooy1108@gmail.com>
 */
trait AssignAktaTrait 
{
	/**
	 * assign writer
	 *
	 * @return array $writer
	 */
	private function assignWriter()
	{
		$akta['penulis']['id'] 					= $this->logged_user['id'];
		$akta['penulis']['nama'] 				= $this->logged_user['nama'];

		return $akta['penulis'];
	}

	/**
	 * assign owner
	 *
	 * @return array $owner
	 */
	private function assignOwner($potential_owner = null)
	{
		$akta['pemilik']['orang'][0]['id'] 		= $this->logged_user['id'];
		$akta['pemilik']['orang'][0]['nama'] 	= $this->logged_user['nama'];

		foreach ((array)$potential_owner as $key => $value) 
		{
			$akta['pemilik']['klien'][$key]['id'] 		= $value['id'];

			if(str_is($value['jenis'], 'ktp'))
			{
				$akta['pemilik']['klien'][$key]['nama'] 	= $value['isi']['nama'];
			}
			elseif(str_is($value['jenis'], 'akta_pendirian'))
			{
				$akta['pemilik']['klien'][$key]['nama'] 	= $value['isi']['nama'];
			}
		}

		$akta['pemilik']['kantor']['id'] 		= $this->active_office['kantor']['id'];
		$akta['pemilik']['kantor']['nama'] 		= $this->active_office['kantor']['nama'];

		return $akta['pemilik'];
	}
}