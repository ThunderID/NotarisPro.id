<?php

namespace App\Service\Admin;

use App\Domain\Admin\Models\Pengguna;

use Exception, Validator;

class UbahPassword
{
	protected $id;
	protected $email;
	protected $password;
	protected $konfirmasi_password;

	/**
	 * Create a new job instance.
	 *
	 * @param  $email
	 * @return voemail
	 */
	public function __construct($id, $email, $password, $konfirmasi_password)
	{
		$this->id					= $id;
		$this->email				= $email;
		$this->password				= $password;
		$this->konfirmasi_password	= $konfirmasi_password;
	}

	/**
	 * Execute the job.
	 *
	 * @return voemail
	 */
	public function handle()
	{
		try
		{
			$pengguna		= Pengguna::findorfail($this->id);

			$validating 	= Validator::make(['password' => $this->password, 'password_confirmation' => $this->konfirmasi_password], ['password' => 'min:8|confirmed']);

			if(!$validating->passes())
			{
				throw new Exception("Password tidak sama", 1);
			}

			$pengguna->email 		= $this->email;
			$pengguna->password 	= $this->password;

			$pengguna->save();

			return $pengguna->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
			
		}
	}
}