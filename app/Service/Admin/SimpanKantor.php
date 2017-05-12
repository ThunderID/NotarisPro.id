<?php

namespace App\Service\Admin;

use App\Domain\Admin\Models\Kantor;

use Exception, DB, TAuth, Carbon\Carbon;

class SimpanKantor
{
	protected $id;
	protected $nama_kantor;
	protected $nama_notaris;
	protected $daerah_kerja;
	protected $nomor_sk;
	protected $tanggal_pengangkatan;
	protected $alamat;
	protected $telepon;
	protected $fax;

	/**
	 * Create a new job instance.
	 *
	 * @param  $id
	 * @param  $nama_kantor
	 * @param  $nama_notaris
	 * @param  $daerah_kerja
	 * @param  $nomor_sk
	 * @param  $tanggal_pengangkatan
	 * @param  $alamat
	 * @param  $telepon
	 * @param  $fax
	 * @return void
	 */
	public function __construct($id, $nama_kantor, $nama_notaris, $daerah_kerja, $nomor_sk, $tanggal_pengangkatan, $alamat, $telepon, $fax)
	{
		$this->id					= $id;
		$this->nama_kantor			= $nama_kantor;
		$this->nama_notaris			= $nama_notaris;
		$this->daerah_kerja			= $daerah_kerja;
		$this->nomor_sk				= $nomor_sk;
		$this->tanggal_pengangkatan	= $tanggal_pengangkatan;
		$this->alamat				= $alamat;
		$this->telepon				= $telepon;
		$this->fax					= $fax;
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
			//1a. pastikan kantor exists
			$kantor 		= Kantor::findorfail($this->id);

			//1b. pastikan kantor tersebut milik kantor notaris yang sedang aktif 
			if(!str_is(TAuth::activeOffice()['kantor']['id'], $this->id))
			{
				throw new Exception("Anda tidak memiliki akses untuk kantor ini", 1);
			}

			//2. check lock
			$notaris['nama']					= $this->nama_notaris;
			$notaris['daerah_kerja']			= $this->daerah_kerja;
			$notaris['nomor_sk']				= $this->nomor_sk;
			$notaris['tanggal_pengangkatan']	= $this->tanggal_pengangkatan;
			$notaris['alamat']					= $this->alamat;
			$notaris['telepon']					= $this->telepon;
			$notaris['fax']						= $this->fax;
			$kantor->nama						= $this->nama_kantor;
			$kantor->notaris					= $notaris;

			//5. simpan dokumen
			$kantor->save();

			return $kantor->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}