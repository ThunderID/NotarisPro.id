<?php

namespace App\Service\Admin;

use App\Domain\Admin\Models\Pengguna;

use Exception;

class RemoveVisa
{
	protected $id;
	protected $visa_id;

	/**
	 * Create a new job instance.
	 *
	 * @param  $id
	 * @return void
	 */
	public function __construct($id, $visa_id)
	{
		$this->id		= $id;
		$this->visa_id	= $visa_id;
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
			$pengguna		= Pengguna::findorfail($this->id);
			$pengguna		= $pengguna->removeVisa($this->visa_id);
			$pengguna->save();

			return $pengguna->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
			
		}
	}
}