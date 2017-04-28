<?php

namespace TCommands\Akta;

use TAkta\DokumenKunci\Models\Versi;
use TAkta\DokumenKunci\Models\Dokumen;
use TImmigration\Pengguna\Models\Pengguna;

use Exception, DB, TAuth, Carbon\Carbon;

class FinalisasiAkta
{
	protected $akta_id;

	/**
	 * Create a new job instance.
	 *
	 * @param  $akta_id
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
			$akta 		= Dokumen::findorfail($this->akta_id);

			//1b. check status akta 
			if(!in_array($akta->status, ['pengajuan']))
			{
				throw new Exception("Status Harus Pengajuan", 1);
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

			$paragraf 					= [];
			foreach ($akta->paragraf as $key => $value) 
			{
				$paragraf[$key] 		= $value;
				$paragraf[$key]['lock']	= Dokumen::createID('lock');
			}
			$akta->paragraf 			= $paragraf;

			$akta->status 				= 'akta';

			$akta->save();


			$prev_versi 			= Versi::where('original_id', $akta->id)->orderby('created_at', 'desc')->first();
			$versi 					= new Versi;
			$versi 					= $versi->fill($akta->toArray());
			$versi->original_id 	= $akta->id;
			$versi->versi 			= ($prev_versi->versi*1) + 1;
			$versi->save();
			
			return true;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}