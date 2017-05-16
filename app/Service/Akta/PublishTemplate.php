<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Template;

use Exception, DB, TAuth, Carbon\Carbon;

class PublishTemplate
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
	public function handle()
	{
		try
		{
			//1a. pastikan akta exists
			$akta 		= Template::findorfail($this->id);

			//1b. check status akta 
			if(!in_array($akta->status, ['draft']))
			{
				throw new Exception("Status Harus draft", 1);
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

			//2. set status
			$akta->status 			= 'publish';

			$akta->save();

			return true;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}