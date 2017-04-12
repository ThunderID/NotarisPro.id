<?php

namespace TCommands\Akta;

use TAkta\DokumenKunci\Models\Template;

use Exception, DB, TAuth, Carbon\Carbon;

class DraftingTemplateAkta
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
				$akta 		= Template::findorfail($this->akta['id']);

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
			}
			else
			{
				$akta 		= new Template;
			}

			//2. set ownership dokumen
			$this->akta['pemilik']['kantor']['id'] 		= TAuth::activeOffice()['kantor']['id'];
			$this->akta['pemilik']['kantor']['nama'] 	= TAuth::activeOffice()['kantor']['nama'];

			$this->akta['penulis']['id'] 				= TAuth::loggedUser()['id'];
			$this->akta['penulis']['nama'] 				= TAuth::loggedUser()['nama'];

			//3. simpan value yang ada
			$akta 			= $akta->fill($this->akta);

			//4. set status dokumen
			$akta->status 	= 'draft';

			//5. simpan dokumen
			$akta->save();

			return true;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}