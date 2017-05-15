<?php

namespace App\Service\Admin;

use App\Domain\Admin\Models\Pengguna as Model;

use Exception;

class PenggunaBaru
{
	protected $nama;
	protected $email;
	protected $password;

	/**
	 * Create a new job instance.
	 *
	 * @param  $email
	 * @return void
	 */
	public function __construct($nama, $email, $password)
	{
		$this->nama		= $nama;
		$this->email	= $email;
		$this->password	= $password;
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
			$pengguna			= new Model;
			$pengguna->nama		= $this->nama;
			$pengguna->email	= $this->email;
			$pengguna->password	= $this->password;
			$pengguna->save();

			return $pengguna->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
			
		}
	}
}