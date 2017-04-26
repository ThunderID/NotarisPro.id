<?php

namespace TCommands\Akta;

use TAkta\DokumenKunci\Models\Dokumen as Akta;

use Exception, TAuth, Carbon\Carbon;

class HapusAkta
{
	protected $akta;

	/**
	 * Create a new job instance.
	 *
	 * @param  $akta
	 * @return void
	 */
	public function __construct($akta_id)
	{
		$this->akta_id		= $akta_id;
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
			$akta 		= Akta::findorfail($this->akta_id);

			//1b. check status akta 
			if(!str_is($akta->status, 'draft'))
			{
				throw new Exception("Status Harus Draft", 1);
			}

			//1c. pastikan akta tersebut dimiliki oleh logged user / akses 
			if(!in_array(TAuth::loggedUser()['id'], [$akta->penulis['id']]))
			{
				throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
			}
			
			//1d. pastikan akta tersebut milik kantor notaris yang sedang aktif 
			if(!in_array(TAuth::activeOffice()['kantor']['id'], $akta->pemilik['kantor']))
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