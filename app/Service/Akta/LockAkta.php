<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Dokumen;
use App\Domain\Admin\Models\Kantor;

use App\Infrastructure\Traits\GuidTrait;

use Exception, TAuth, Carbon\Carbon;

/**
 * Service untuk membuat akta baru
 *
 * Auth : 
 * 	1. Siapa pun yang teregistrasi dalam sistem @authorize
 * Policy : 
 * 	1. Restorasi Isi Paragraf @restorasi_isi_akta
 * 	2. Restorasi Data mention @restorasi_isi_mentionable
 * 	3. Validate template @validasi_template
 * Smart System : 
 * 	1. simpan prev / next version
 * 	2. simpan new detected doc type
 * 	3. simpan new detected klien/objek/saksi
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class LockAkta
{
	use GuidTrait;

	protected $id;
	protected $akta;

	/**
	 * Create new instance.
	 *
	 * @param  string $id
	 */
	public function __construct($id)
	{
		$this->id		= $id;
		$this->akta 	= Dokumen::id($id)->wherenull('next')->firstorfail();
	}

	//check perlu versioning
	public function editable($key_lock)
	{
		$this->authorize();

		$paragraf		= $this->akta->paragraf;

		foreach ($this->akta->paragraf as $key => $value) 
		{
			if($value['key'] == $key)
			{
				if(is_null($value['lock']))
				{
					$paragraf[$key]['lock']	= self::createID('lock');
				}
				else
				{
					$paragraf[$key]['lock']	= null;
				}
			}
		}

		$this->akta->paragraf 	= $paragraf;
		$this->akta->save();

		return $this->akta;
	}

	//check perlu versioning
	public function addParagrafAfter($key_lock)
	{
		$paragraf						= $this->akta->paragraf;

		//jika penambahan pada awal paragraf
		if(is_null($key_lock))
		{
			foreach ($this->akta->paragraf as $key => $value) 
			{
				$paragraf[$key + 1] 	= $value;
			}
			$paragraf[0]				= ['konten' => null, 'key' => self::createID('key'), 'lock' => null];
		}
		else
		{
			$idx 		= 0;
			foreach ($this->akta->paragraf as $key => $value) 
			{
				if(str_is($value['key'], $key_lock))
				{
					$idx 				= $key;
				}

				if($idx > 0)
				{
					$paragraf[$key + 1] = $value;
				}
			}

			if($idx > 0)
			{
				$paragraf[$idx]			= ['konten' => null, 'key' => self::createID('key'), 'lock' => null];
			}
		}

		$this->akta->paragraf 			= $paragraf;
		$this->akta->save();

		return $this->akta;
	}

	//check perlu versioning
	public function removeParagrafBefore($key_lock)
	{
		$paragraf						= $this->akta->paragraf;

		//jika penghapusan pada paragraf terakhir
		if(is_null($key_lock))
		{
			unset($paragraf[count($paragraf)-1]);
		}
		else
		{
			$flag 			= 0;
			foreach ($this->akta->paragraf as $key => $value) 
			{
				if(str_is($value['key'], $key_lock))
				{
					$flag  = 1;
					unset($paragraf[$key]);
				}

				if($flag)
				{
					$paragraf[$key - 1]	= $value;
				}
			}
			
			if($flag)
			{
				unset($paragraf[count($paragraf)-1]);
			}
				
		}

		ksort($paragraf);

		$this->akta->paragraf 			= $paragraf;
		$this->akta->save();

		return $this->akta;
	}

	/**
	 * Authorization user
	 *
	 * MELALUI HTTP
	 * 1. User harus login
	 *
	 * MELALUI CONSOLE
	 * belum ada
	 *
	 * @return Exception 'Invalid User'
	 * @return boolean true
	 */
	private function authorize()
	{
		//MELALUI HTTP

		//demi menghemat resource
		$this->active_office 	= TAuth::activeOffice();
		$this->logged_user 		= TAuth::loggedUser();

		return true;
	
		//MELALUI CONSOLE
	}
}