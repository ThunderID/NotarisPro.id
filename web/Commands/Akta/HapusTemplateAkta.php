<?php

namespace TCommands\Akta;

use TAkta\DokumenKunci\Models\Template;

use Exception, TAuth, Carbon\Carbon;

class HapusTemplateAkta
{
	protected $template;

	/**
	 * Create a new job instance.
	 *
	 * @param  $template
	 * @return void
	 */
	public function __construct($template_id)
	{
		$this->template_id		= $template_id;
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
			$akta 		= Template::findorfail($this->template_id);

			//1b. check status akta 
			if(!str_is($akta->status, 'draft'))
			{
				throw new Exception("Status Harus Draft", 1);
			}

			//1c. pastikan akta tersebut dimiliki oleh logged user / akses 
			if(!in_array(TAuth::loggedUser()['id'], [$akta->penulis['id']]))
			{
				throw new Exception("Anda tidak memiliki akses untuk template ini", 1);
			}
			
			//1d. pastikan akta tersebut milik kantor notaris yang sedang aktif 
			if(!in_array(TAuth::activeOffice()['kantor']['id'], $akta->pemilik['kantor']))
			{
				throw new Exception("Anda tidak memiliki akses untuk template ini", 1);
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