<?php

namespace App\Service\Order;

use App\Domain\Order\Models\Klien;

use Exception, TAuth, Carbon\Carbon;

class SimpanKlien
{
	protected $id;
	protected $nama;
	protected $tempat_lahir;
	protected $tanggal_lahir;
	protected $pekerjaan;
	protected $alamat;
	protected $nomor_ktp;

	/**
	 * Create a new job instance.
	 *
	 * @param  $nama
	 * @return void
	 */
	public function __construct($id, $nama, $tempat_lahir, $tanggal_lahir, $pekerjaan, $alamat, $nomor_ktp)
	{
		$this->id				= $id;
		$this->nama				= $nama;
		$this->tempat_lahir		= $tempat_lahir;
		$this->tanggal_lahir	= $tanggal_lahir;
		$this->pekerjaan		= $pekerjaan;
		$this->alamat			= $alamat;
		$this->nomor_ktp		= $nomor_ktp;
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
			$klien 				= Klien::findorfail($this->id);
		
			if($klien['kantor']['id']!=TAuth::activeOffice()['kantor']['id'])
			{
				throw new Exception("Anda tidak memiliki akses untuk data ini", 1);
			}
			
			//2. fill data
			$klien->nama			= $this->nama;
			$klien->tempat_lahir	= $this->tempat_lahir;
			$klien->tanggal_lahir	= $this->tanggal_lahir;
			$klien->pekerjaan		= $this->pekerjaan;
			$klien->alamat			= $this->alamat;
			$klien->nomor_ktp		= $this->nomor_ktp;

			//2. simpan klien
			$klien->save();

			return $klien->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}