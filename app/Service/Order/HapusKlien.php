<?php

namespace App\Service\Order;

use App\Domain\Order\Models\Klien;

use Exception, TAuth, Carbon\Carbon;

class HapusKlien
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
			$klien 		= Klien::findorfail($this->id);

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