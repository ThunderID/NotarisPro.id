<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Versi;
use App\Domain\Akta\Models\Dokumen;

use TImmigration\Pengguna\Models\Pengguna;

use Exception, DB, TAuth, Carbon\Carbon;

class UnlockAkta
{
	protected $id;
	protected $locks;

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
	public function unlock()
	{
		try
		{
			//1a. pastikan akta exists
			$akta 		= Dokumen::findorfail($this->id);

			//1b. check status akta 
			if(!in_array($akta->status, ['draft']))
			{
				throw new Exception("Status Harus draft", 1);
			}

			//1c. pastikan akta tersebut dimiliki oleh logged user / akses 
			if(!in_array(TAuth::activeOffice()['role'], ['notaris']))
			{
				throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
			}

			//1d. pastikan akta tersebut milik kantor notaris yang sedang aktif 
			if(!in_array(TAuth::activeOffice()['kantor']['id'], $akta->pemilik['kantor']))
			{
				throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
			}

			//2. Lock semua paragraf
			$paragraf 					= $akta->paragraf;

			foreach ($akta->paragraf as $key => $value) 
			{
				if(in_array($value['lock'], $this->locks))
				{
					$paragraf[$key] 			= $value;

					if(isset($paragraf[$key]['unlock']) && $paragraf[$key]['unlock'])
					{
						$paragraf[$key]['unlock']	= false;
					}
					else
					{
						$paragraf[$key]['unlock']	= true;
					}
				}
			}
			$akta->paragraf 			= $paragraf;

			$akta->save();

			return $akta->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
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
			//1a. pastikan akta exists
			$akta 		= Dokumen::findorfail($this->id);

			//1b. check status akta 
			if(!in_array($akta->status, ['draft']))
			{
				throw new Exception("Status Harus draft", 1);
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

			//2. set status
			$akta->status 			= 'renvoi';

			//3. unlock paragraf
			$paragraf 				= [];
			foreach ($akta->paragraf as $key => $value) 
			{
				$paragraf[$key]			 	= $value;	
				if(isset($value['unlock']) && $value['unlock'])
				{
					$paragraf[$key]['lock'] = null;	
					unset($paragraf[$key]['unlock']);
				}
			}
			$akta->paragraf 			= $paragraf;

			$akta->save();

			return $akta->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}