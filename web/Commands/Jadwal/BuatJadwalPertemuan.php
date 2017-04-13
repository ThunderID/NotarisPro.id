<?php

namespace TCommands\Jadwal;

use TJadwal\JadwalPertemuan\Models\JadwalPertemuan;

use Exception, DB, TAuth, Carbon\Carbon;

class BuatJadwalPertemuan
{
	protected $jadwal;

	/**
	 * Create a new job instance.
	 *
	 * @param  $jadwal
	 * @return void
	 */
	public function __construct($jadwal)
	{
		$this->jadwal		= $jadwal;
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
			if(isset($this->jadwal['id']))
			{
				//1a. pastikan jadwal exists
				$jadwal 		= JadwalPertemuan::findorfail($this->jadwal['id']);

				//1b. check status jadwal 
				if(!str_is($jadwal->status, 'draft'))
				{
					throw new Exception("Status Harus Draft", 1);
				}

				//1c. pastikan jadwal tersebut milik kantor notaris yang sedang aktif 
				if(!in_array(TAuth::activeOffice()['kantor']['id'], $jadwal->pembuat['kantor']))
				{
					throw new Exception("Anda tidak memiliki akses untuk jadwal ini", 1);
				}
			}
			else
			{
				$jadwal 		= new JadwalPertemuan;
			}

			//2. set ownership dokumen
			$this->jadwal['pembuat']['kantor']['id'] 	= TAuth::activeOffice()['kantor']['id'];
			$this->jadwal['pembuat']['kantor']['nama'] 	= TAuth::activeOffice()['kantor']['nama'];

			//3. simpan value yang ada
			$jadwal 			= $jadwal->fill($this->jadwal);

			//4. simpan jadwal
			$jadwal->save();

			return true;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}