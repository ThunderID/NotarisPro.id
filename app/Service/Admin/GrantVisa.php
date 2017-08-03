<?php

namespace App\Service\Admin;

use App\Domain\Admin\Models\Pengguna;

use Exception;
use Carbon\Carbon;

class GrantVisa
{
	protected $id;
	protected $role;
	protected $kantor_id;
	protected $kantor_nama;

	/**
	 * Create a new job instance.
	 *
	 * @param  $id
	 * @return void
	 */
	public function __construct($id, $role, $type, $started_at = null, $expired_at = null, $kantor_id, $kantor_nama)
	{
		$this->id			= $id;
		$this->role			= $role;
		$this->type			= $type;
		$this->started_at	= $started_at;
		$this->expired_at	= $expired_at;
	
		if(is_null($started_at))
		{
			$this->started_at 	= Carbon::now()->format('Y-m-d H:i:s');			
		}

		if(is_null($expired_at))
		{
			if(str_is($type, 'starter'))
			{
				$this->expired_at 	= Carbon::now()->addmonths(1)->format('Y-m-d H:i:s');
			}
			else
			{
				$this->expired_at 	= Carbon::now()->adddays(14)->format('Y-m-d H:i:s');
			}
		}

		$this->kantor_id	= $kantor_id;
		$this->kantor_nama	= $kantor_nama;
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
			$visa 			= [
				'role'			=> $this->role,
				'type'			=> $this->type,
				'started_at'	=> $this->started_at,
				'expired_at'	=> $this->expired_at,
				'kantor'		=> ['id' => $this->kantor_id, 'nama' => $this->kantor_nama],
			];

			$pengguna		= Pengguna::findorfail($this->id);
			$pengguna		= $pengguna->grantVisa($visa);
			$pengguna->save();

			return $pengguna->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
			
		}
	}
}