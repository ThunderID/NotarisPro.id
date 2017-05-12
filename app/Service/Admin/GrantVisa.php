<?php

namespace App\Service\Admin;

use App\Domain\Admin\Models\Pengguna;

use Exception;

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
	public function __construct($id, $role, $kantor_id, $kantor_nama)
	{
		$this->id			= $id;
		$this->role			= $role;
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
				'role'		=> $this->role,
				'kantor'	=> ['id' => $this->kantor_id, 'nama' => $this->kantor_nama],
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