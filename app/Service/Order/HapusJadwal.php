<?php

namespace App\Service\Order;

use App\Domain\Order\Models\Jadwal;

use Exception, TAuth, Carbon\Carbon;

class HapusJadwal
{
	protected $id;

	/**
	 * Create a new job instance.
	 *
	 * @param  $id
	 * @return void
	 */
	public function __construct($id)
	{
		$this->id		= $id;
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
			$jadwal 		= Jadwal::findorfail($this->id);

			if($jadwal['pembuat']['kantor']['id']!=TAuth::activeOffice()['kantor']['id'])
			{
				throw new Exception("Anda tidak memiliki akses untuk data ini", 1);
			}

			//2. hapus id
			$jadwal->delete();

			return true;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}