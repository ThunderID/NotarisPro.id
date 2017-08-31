<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Dokumen as Akta;

use Exception, TAuth, Carbon\Carbon;

class HapusAkta
{
	protected $id;

	/**
	 * Create a new job instance.
	 *
	 * @param  $id
	 * @return void
	 */
	public function __construct($id)
	{
		$this->id		= $id;
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
			//1a. pastikan akta exists
			$akta 		= Akta::findorfail($this->id);

			//1b. check status akta 
			if(!str_is($akta->status, 'dalam_proses'))
			{
				throw new Exception("Status Harus dalam proses", 1);
			}

			//1c. pastikan akta tersebut dimiliki oleh logged user / akses 
			if(!in_array(TAuth::loggedUser()['id'], [$akta->penulis['id']]))
			{
				throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
			}
			
			//1d. pastikan akta tersebut milik kantor notaris yang sedang aktif 
			if(!str_is(TAuth::activeOffice()['kantor']['id'], $akta->pemilik['kantor']['id']))
			{
				throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
			}

			//2. hapus Akta
			$akta->delete();

			return true;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}