<?php

namespace TCommands\Kantor;

use TKantor\Notaris\Models\Notaris;

use Exception, TAuth, Carbon\Carbon;

class SimpanNotaris
{
	protected $notaris;

	/**
	 * Create a new job instance.
	 *
	 * @param  $notaris
	 * @return void
	 */
	public function __construct($notaris)
	{
		$this->notaris		= $notaris;
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
			//1. check auth
			if(!str_is(TAuth::activeOffice()['role'], 'notaris'))
			{
				throw new Exception("Tidak dapat mengubah informasi notaris", 1);
			}

			//2. jika Notaris sudah pernah ada, update data Notaris
			if(isset($this->notaris['id']) && str_is(TAuth::activeOffice()['kantor']['id'], $this->notaris['id']))
			{
				$notaris 		= Notaris::findorfail($this->notaris['id']);
			}
			else
			{
				$notaris 		= Notaris::findorfail(TAuth::activeOffice()['kantor']['id']);
			}

			//3. fill data
			$notaris 					= $notaris->fill($this->notaris);

			//4. simpan Notaris
			$notaris->save();

			return true;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}