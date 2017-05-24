<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Dokumen;
use TImmigration\Pengguna\Models\Pengguna;

use Exception, TAuth;

/**
 * Service untuk unlock akta yang sudah ada
 *
 * Auth : 
 * 	1. hanya penulis @authorize
 * Validasi :
 * 	1. dapat diedit, status draft, atau renvoi @editable
 * Policy : 
 * 	1.Unlock Paragraf @unlock
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class UnlockAkta
{
	protected $id;
	protected $locks;
	private $akta;
	private $loggedUser;
	private $activeOffice;

	/**
	 * Create a new job instance.
	 *
	 * @param  $id
	 * @return void
	 */
	public function __construct($id, array $locks)
	{
		$this->id		= $id;
		$this->locks	= $locks;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function save()
	{
		try
		{
			// Auth : 
			// 1. hanya penulis @authorize
			$this->authorize();
			
			// Validasi :
			// 	1. dapat diedit, status draft @editable
			$this->editable();

			// Smart :
			//1. mentionable sudah terisi @unlock
			$this->unlock();

			//2. simpan dokumen
			$this->akta->status 	= 'renvoi';
			$this->akta->save();

			$akta 		= new DaftarAkta;
			return $akta->detailed($this->id);
		}
		catch(Exception $e)
		{
			throw $e;
		}
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
		$this->loggedUser 	= TAuth::loggedUser();
		$this->activeOffice = TAuth::activeOffice();

		//1a. pastikan akta exists
		$this->akta 		= Dokumen::id($this->id)->where('penulis.id', $this->loggedUser['id'])->kantor($this->activeOffice['kantor']['id'])->first();

		if(!$this->akta)
		{
			throw new Exception("Akta tidak ditemukan", 1);
		}

		return true;
	
		//MELALUI CONSOLE
	}

	/**
	 * Editable content
	 *
	 * hanya status dalam_proses, renvoi yang tidak di lock
	 *
	 * @return Exception 'Invalid User'
	 * @return boolean true
	 */
	private function editable()
	{
		//1. check status akta 
		if(!in_array($this->akta->status, ['draft', 'renvoi']))
		{
			throw new Exception("Dokumen tidak bisa unlock", 1);
		}

		return true;
	}

	/**
	 * Unlock editable
	 *
	 * @return boolean true
	 */
	private function unlock()
	{
		//1. check status akta 
		$paragraf 						= [];
		foreach ($this->akta->paragraf as $key => $value) 
		{
			$paragraf[$key]				= $value;	
			if(!isset($value['unlock']) && in_array($value['lock'], $this->locks))
			{
				$paragraf[$key]['unlock']	= true;
				$paragraf[$key]['revise']	= (isset($paragraf[$key]['revise']) ? $paragraf[$key]['revise'] : 0) + 1;
				// unset($paragraf[$key]['lock']);
			}
			elseif(isset($value['unlock']))
			{
				unset($paragraf[$key]['unlock']);
				$paragraf[$key]['revise']	= (isset($paragraf[$key]['revise']) ? $paragraf[$key]['revise'] : 1) - 1;
				// $paragraf[$key]['lock']	= Dokumen::createID('lock');
			}
		}

		$this->akta->paragraf 			= $paragraf;

		return true;
	}
}