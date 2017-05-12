<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Dokumen;

use Exception, DB, TAuth, Carbon\Carbon;

class SimpanAkta
{
	protected $id;
	protected $judul;
	protected $isi_akta;
	protected $mentionable;

	/**
	 * Create a new job instance.
	 *
	 * @param  $akta
	 * @return void
	 */
	public function __construct($id, $judul, array $isi_akta, array $mentionable)
	{
		$this->id			= $id;
		$this->judul		= $judul;
		$this->isi_akta		= $isi_akta;
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
			$akta 		= Dokumen::findorfail($this->id);

			//1b. check status akta 
			if(!in_array($akta->status, ['renvoi', 'draft']))
			{
				throw new Exception("Status Harus Renvoi atau draft", 1);
			}

			//1c. pastikan akta tersebut dimiliki oleh logged user / akses 
			if(!in_array(TAuth::loggedUser()['id'], [$akta->pemilik['orang'][0]['id']]))
			{
				throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
			}

			//1d. pastikan akta tersebut milik kantor notaris yang sedang aktif 
			if(!in_array(TAuth::activeOffice()['kantor']['id'], $akta->pemilik['kantor']))
			{
				throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
			}

			//2. check lock
			$paragraf	= $akta['paragraf'];

			foreach ($this->isi_akta as $key => $value) 
			{
				if(!isset($paragraf[$key]['lock']) || is_null($paragraf[$key]['lock']))
				{
					$paragraf[$key]['konten']	= $value['konten'];
				}
			}

			//3. simpan value yang ada
			$akta->paragraf = $paragraf;

			//4. simpan mention
			$fill_mention 			= $akta->fill_mention;

			foreach($akta->mentionable as $key => $value)
			{
				if(isset($this->mentionable[$value]))
				{
					$fill_mention[str_replace('.','-+',str_replace('@','', $value))] = $this->mentionable[$value];
				}
			}
			$akta->fill_mention 	= $fill_mention;

			//5. simpan dokumen
			$akta->save();

			return $akta->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}