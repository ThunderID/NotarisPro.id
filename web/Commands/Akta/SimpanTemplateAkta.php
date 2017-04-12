<?php

namespace TCommands\Akta;

use TAkta\DokumenKunci\Models\Template;

use Exception, DB, TAuth, Carbon\Carbon;

class SimpanTemplateAkta
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
			//1a. pastikan akta exists
			$akta 		= Template::findorfail($this->akta['id']);

			//1b. check status akta 
			if(!str_is($akta->status, 'publish'))
			{
				throw new Exception("Status Harus publish", 1);
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

			//2. simpan value yang ada
			$akta->paragraf = $this->akta['paragraf'];

			//3. simpan dokumen
			$akta->save();

			return true;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}