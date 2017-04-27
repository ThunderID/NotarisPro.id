<?php

namespace TCommands\Akta;

use TAkta\DokumenKunci\Models\Versi;
use TAkta\DokumenKunci\Models\Dokumen;
use TKlien\Klien\Models\Klien;

use TCommands\Klien\SimpanKlien;

use Exception, DB, TAuth, Carbon\Carbon;

class DraftingAkta
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
				$akta 		= Dokumen::findorfail($this->akta['id']);

				//1b. check status akta 
				if(!str_is($akta->status, 'draft'))
				{
					throw new Exception("Status Harus Draft", 1);
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
			}
			else
			{
				$akta 		= new Dokumen;
			}

			//2. set ownership dokumen
			$this->akta['pemilik']['orang'][0]['id'] 	= TAuth::loggedUser()['id'];
			$this->akta['pemilik']['orang'][0]['nama'] 	= TAuth::loggedUser()['nama'];

			$this->akta['pemilik']['kantor']['id'] 		= TAuth::activeOffice()['kantor']['id'];
			$this->akta['pemilik']['kantor']['nama'] 	= TAuth::activeOffice()['kantor']['nama'];

			// $this->akta['pemilik']['klien']['id'] 		= $this->akta['pemilik']['klien']['id'];
			// $this->akta['pemilik']['klien']['nama'] 	= $this->akta['pemilik']['klien']['nama'];

			$this->akta['penulis']['id'] 				= TAuth::loggedUser()['id'];
			$this->akta['penulis']['nama'] 				= TAuth::loggedUser()['nama'];

			if(isset($this->akta['fill_mention']) && isset($akta->fill_mention))
			{
				$this->akta['fill_mention']	= array_merge($this->akta['fill_mention'], $akta->fill_mention);
			}

			if(isset($this->akta['fill_mention']))
			{
				//simpan klien
				foreach ($this->akta['fill_mention'] as $key => $value) 
				{
					if(str_is('@klien.*.nomor_ktp', $key))
					{
						//check klien
						$klien 			= Klien::where('nomor_ktp', $value)->first();

						$klien_data 	= [];

						if($klien)
						{
							$klien 		= $klien->toArray();
							$klien_data['id']	= $klien['id'];
						}
						$middle_number	= explode('.', $key);

						foreach ($this->akta['fill_mention'] as $key2 => $value2) 
						{
							if(str_is('@klien.'.$middle_number[1].'.*', $key2))
							{
								$indexing 					= explode('@klien.'.$middle_number[1].'.', $key2);
								$klien_data[$indexing[1]] 	= $value2;
							}
						}

						$save_klien 	= new SimpanKlien($klien_data);
						$save_klien 	= $save_klien->handle();
					}
				}

				//rename mention
				foreach ($this->akta['fill_mention'] as $key => $value) 
				{
					$this->akta['fill_mention'][str_replace('.','-+',str_replace('@','', $key))] = $value;
					
					if(!str_is('*-+*', $key))
					{
						unset($this->akta['fill_mention'][$key]);
					}
				}
			}

			//3. simpan value yang ada
			$akta 					= $akta->fill($this->akta);

			//4. set status dokumen
			$akta->status 			= 'draft';

			//5. simpan dokumen
			$akta->save();

			$versi 					= Versi::where('original_id', $akta->id)->first();
			if(!$versi)
			{
				$versi 				= new Versi;
			}

			$versi 					= $versi->fill($akta->toArray());
			$versi->original_id 	= $akta->id;
			$versi->versi 			= 1;
			$versi->save();

			return $akta->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}