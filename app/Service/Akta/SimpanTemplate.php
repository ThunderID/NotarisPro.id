<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Template;

use Exception, DB, TAuth, Carbon\Carbon;

class SimpanTemplate
{
	protected $id;
	protected $isi_template;
	protected $mentionable;

	/**
	 * Create a new job instance.
	 *
	 * @param  $id
	 * @return void
	 */
	public function __construct($id, array $isi_template, array $mentionable)
	{
		$this->id			= $id;
		$this->isi_template	= $isi_template;
		$this->mentionable	= $mentionable;
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
			$akta 			= Template::findorfail($this->id);

			//1b. check status akta 
			if(!str_is($akta->status, 'draft'))
			{
				throw new Exception("Status Harus draft", 1);
			}

			//1c. pastikan akta tersebut dimiliki oleh logged user / akses 
			if(!in_array(TAuth::loggedUser()['id'], [$akta->penulis['id']]))
			{
				throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
			}

			// 1d. pastikan akta tersebut milik kantor notaris yang sedang aktif 
			if(!in_array(TAuth::activeOffice()['kantor']['id'], $akta->pemilik['kantor']))
			{
				throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
			}

			//2. simpan value yang ada
			$akta->paragraf				= $this->isi_template;
			$akta->mentionable			= $this->mentionable;

			//3. simpan dokumen
			$akta->save();

			return $akta->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}