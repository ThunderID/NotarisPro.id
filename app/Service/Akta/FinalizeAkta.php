<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Versi;
use App\Domain\Akta\Models\Dokumen;
use App\Domain\Akta\Models\ReadOnlyAkta;
use TImmigration\Pengguna\Models\Pengguna;

use Exception, DB, TAuth, Carbon\Carbon;

class FinalizeAkta
{
	protected $id;
	protected $content_stripes;

	/**
	 * Create a new job instance.
	 *
	 * @param  $id
	 * @return void
	 */
	public function __construct($id, $content_stripes)
	{
		$this->id				= $id;
		$this->content_stripes	= $content_stripes;
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

			//2. simpan versi
			$prev_versi 			= Versi::where('original_id', $akta->id)->orderby('created_at', 'desc')->first();
			$versi 					= new Versi;
			$versi 					= $versi->fill($akta->toArray());
			$versi->original_id 	= $akta->id;
			$versi->versi 			= ($prev_versi->versi*1) + 1;
			$versi->save();

			//3. simpan read only
			$ro_akta				= new ReadOnlyAkta;
			$ro_akta->paragraf		= $this->content_stripes;
			$ro_akta->original_id 	= $akta->id;
			$ro_akta->save();
			
			return true;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}