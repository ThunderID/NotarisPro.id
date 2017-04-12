<?php

namespace TCommands\Klien;

use TKlien\Klien\Models\Klien;

use Exception, TAuth, Carbon\Carbon;

class SimpanKlien
{
	protected $klien;

	/**
	 * Create a new job instance.
	 *
	 * @param  $klien
	 * @return void
	 */
	public function __construct($klien)
	{
		$this->klien		= $klien;
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
			//1. jika klien sudah pernah ada, update data klien
			if(isset($this->klien['id']))
			{
				$klien 		= Klien::findorfail($this->klien['id']);
			}
			else
			{
				$klien 		= new Klien;
			}

			//2. parse data kantor
			$this->klien['kantor']	= TAuth::activeOffice()['kantor'];

			//3. fill data
			$klien 			= $klien->fill($this->klien);

			//4. simpan klien
			$klien->save();

			return true;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}