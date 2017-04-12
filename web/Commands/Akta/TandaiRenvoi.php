<?php

namespace TCommands\Akta;

use TAkta\DokumenKunci\Models\Dokumen;
use TImmigration\Pengguna\Models\Pengguna;

use Exception, DB, TAuth, Carbon\Carbon;

class TandaiRenvoi
{
	protected $akta_id;

	/**
	 * Create a new job instance.
	 *
	 * @param  $akta_id
	 * @return void
	 */
	public function __construct($akta_id, $renvoi_ids)
	{
		$this->akta_id		= $akta_id;
		$this->renvoi_ids	= $renvoi_ids;
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

			//2. Lock semua paragraf
			$paragraf 					= $akta->paragraf;
			foreach ($akta->paragraf as $key => $value) 
			{
				if(in_array($value['lock'], $this->renvoi_ids))
				{
					$paragraf[$key] 		= $value;
					$paragraf[$key]['lock']	= null;
				}
			}
			$akta->paragraf 			= $paragraf;

			//3. Ganti kepemilikan
			$owner 					= $akta->pemilik;
			$owner['orang'][] 		= ['id' => $akta->penulis['id'], 'nama' => $akta->penulis['nama']];
			$akta->pemilik 			= $owner;

			//4. Ganti Status
			$akta->status 			= 'renvoi';
			
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