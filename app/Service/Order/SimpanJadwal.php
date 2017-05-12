<?php

namespace App\Service\Order;

use App\Domain\Order\Models\Jadwal;

use Exception, TAuth, Carbon\Carbon;

class SimpanJadwal
{
	protected $id;
	protected $judul;
	protected $waktu;
	protected $tempat;
	protected $agenda;

	/**
	 * Create a new job instance.
	 *
	 * @param  $jadwal
	 * @return void
	 */
	public function __construct($id, $judul, $waktu, $tempat, $agenda)
	{
		$this->id			= $id;
		$this->judul		= $judul;
		$this->waktu		= $waktu;
		$this->tempat		= $tempat;
		$this->agenda		= $agenda;
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
			//1. jika jadwal sudah pernah ada, update data jadwal
			$jadwal 		= jadwal::findorfail($this->id);

			//1a. pastikan akta tersebut milik kantor notaris yang sedang aktif 
			if(!in_array(TAuth::activeOffice()['kantor']['id'], $akta->pembuat['kantor']['id']))
			{
				throw new Exception("Anda tidak memiliki akses untuk jadwal ini", 1);
			}

			//2. fill data
			$jadwal->judul	= $this->judul;
			$jadwal->waktu	= $this->waktu;
			$jadwal->tempat	= $this->tempat;
			$jadwal->agenda	= $this->agenda;

			//3. simpan jadwal
			$jadwal->save();

			return $jadwal->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}