<?php

namespace TCommands\Klien;

use TKlien\Klien\Models\Klien;

use Exception, TAuth, Carbon\Carbon;

class HapusKlien
{
	protected $klien;

	/**
	 * Create a new job instance.
	 *
	 * @param  $klien
	 * @return void
	 */
	public function __construct($klien_id)
	{
		$this->klien_id		= $klien_id;
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
			$klien 		= Klien::findorfail($this->klien_id);

			if($klien['kantor']['id']!=TAuth::activeOffice()['kantor']['id'])
			{
				throw new Exception("Anda tidak memiliki akses untuk data ini", 1);
			}

			//2. hapus klien
			$klien->delete();

			return true;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}