<?php

namespace TCommands\Akta;

use TAkta\DokumenKunci\Models\Dokumen;

use Exception, DB, TAuth, Carbon\Carbon;

class SimpanAkta
{
	protected $akta;

	/**
	 * Create a new job instance.
	 *
	 * @param  $akta
	 * @return void
	 */
	public function __construct($akta)
	{
		$this->akta		= $akta;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		try
		{
			//1. jika dokumen sudah pernah ada, pastikan ownership terhadap status
			if(isset($this->akta['id']))
			{
				//1a. pastikan akta exists
				$akta 		= Dokumen::findorfail($this->akta['id']);

				//1b. check status akta 
				if(!str_is($akta->status, 'renvoi'))
				{
					throw new Exception("Status Harus Renvoi", 1);
				}

				//1c. pastikan akta tersebut dimiliki oleh logged user / akses 
				if(!in_array(TAuth::loggedUser()['id'], [$akta->pemilik['orang'][0]['id']]))
				{
					throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
				}

				//1d. pastikan akta tersebut milik kantor notaris yang sedang aktif 
				if(!in_array(TAuth::activeOffice()['kantor']['id'], $akta->pemilik['kantor']))
				{
					throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
				}
			}
			else
			{
				$akta 		= new Dokumen;
			}

			//2. check lock
			$paragraf 		= $akta['paragraf'];
			foreach ($this->akta['paragraf'] as $key => $value) 
			{
				if(!isset($paragraf[$key]['lock']) || is_null($paragraf[$key]['lock']))
				{
					$paragraf[$key]['konten']	= $value['konten'];
				}
			}

			//3. simpan value yang ada
			$akta->paragraf = $paragraf;

			//4. simpan dokumen
			$akta->save();

			return $akta->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}