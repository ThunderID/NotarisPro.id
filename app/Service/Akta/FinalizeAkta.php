<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Dokumen;
use App\Domain\Akta\Models\Versi;
use App\Domain\Akta\Models\ReadOnlyAkta;

use TImmigration\Pengguna\Models\Pengguna;

use App\Events\AktaUpdated;
use Exception, TAuth, Carbon\Carbon;

/**
 * Service untuk update akta yang sudah ada
 *
 * Auth : 
 * 	1. hanya penulis @authorize
 * Validasi :
 * 	1. dapat di publish, status draft @editable
 * Smart :
 * 	1. lock all paragraf @lock_paragraph
 * 	2. fill nomor akta @fill_nomor_akta
 * 	3. versioning @versioning
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class FinalizeAkta
{
	protected $id;
	protected $nomor_akta;
	protected $content_stripes;

	private $akta;
	private $loggedUser;
	private $activeOffice;

	/**
	 * Create a new job instance.
	 *
	 * @param 	string $id
	 * @return 	void
	 */
	public function __construct($id, $nomor_akta, $content_stripes)
	{
		$this->id				= $id;
		$this->nomor_akta		= $nomor_akta;
		$this->content_stripes	= $content_stripes;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function save()
	{
		try
		{
			// Auth : 
			// 1. hanya penulis @authorize
			$this->authorize();
			
			// Validasi :
			// 	1. dapat diedit, status draft @editable
			$this->editable();

			// Smart :
			//1. lock all paragraf @lock_paragraph
			$this->lock_paragraph();

			//2. fill nomor akta @fill_nomor_akta
			$this->fill_nomor_akta();

			//2b. simpan dokumen
			$this->akta->riwayat_status 	= array_merge($this->akta->riwayat_status, [['status' => 'akta', 'tanggal' => Carbon::now()->format('Y-m-d H:i:s'), 'petugas' => ['id' => $this->loggedUser['id'], 'nama' => $this->loggedUser['nama']]]]);
			$this->akta->status 	= 'akta';
			$this->akta->save();

		 	//3. versioning
			$this->versioning($this->id, $this->akta->toArray());

			$akta 		= new DaftarAkta;
			$akta 		= $akta->detailed($this->id);
			
			event(new AktaUpdated($akta));

			return $akta;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

	/**
	 * Authorization user
	 *
	 * MELALUI HTTP
	 * 1. User harus login
	 *
	 * MELALUI CONSOLE
	 * belum ada
	 *
	 * @return Exception 'Invalid User'
	 * @return boolean true
	 */
	private function authorize()
	{
		//MELALUI HTTP
		
		//demi menghemat resource
		$this->loggedUser 	= TAuth::loggedUser();
		$this->activeOffice = TAuth::activeOffice();

		//1a. pastikan akta exists
		$this->akta 		= Dokumen::id($this->id)->where('pemilik.orang.id', $this->loggedUser['id'])->kantor($this->activeOffice['kantor']['id'])->first();

		if(!$this->akta)
		{
			throw new Exception("Akta tidak ditemukan", 1);
		}

		return true;
	
		//MELALUI CONSOLE
	}

	/**
	 * editable content
	 *
	 * hanya status dalam_proses dan renvoi
	 *
	 * @return Exception 'Status Harus dalam proses atau Renvoi'
	 * @return boolean true
	 */
	private function editable()
	{
		//1. check status akta 
		if(!in_array($this->akta->status, ['draft']))
		{
			throw new Exception("Status Harus draft", 1);
		}

		return true;
	}

	/**
	 * konci semua paragraf
	 *
	 * @return boolean true
	 */
	private function lock_paragraph()
	{
		$paragraf 					= [];
		foreach ($this->akta->paragraf as $key => $value) 
		{
			$paragraf[$key] 		= $value;
			$paragraf[$key]['lock']	= Dokumen::createID('lock');
		}
		$this->akta->paragraf 			= $paragraf;

		return true;
	}

	/**
	 * isi nomor akta
	 *
	 * @return boolean true
	 */
	private function fill_nomor_akta()
	{
		if(in_array('@akta.nomor', $this->akta->mentionable)) 
		{
			$fill_mention					= $this->akta->fill_mention;
			$fill_mention['akta-+nomor']	= $this->nomor_akta;
			$this->akta->fill_mention		= $fill_mention;
		}

		$this->content_stripes	= str_replace('@akta.nomor', $this->nomor_akta, $this->content_stripes);

		return true;
	}

	/**
	 * fungsi untuk versioning data
	 *
	 * @return boolean true
	 */
	private function versioning($id, $akta)
	{
		$versi 				= new Versi;
		$versi				= $versi->fill($akta);
		$versi->original_id	= $id;
		$versi->versi 		= 1;
		$versi->save();

		$ro_akta				= new ReadOnlyAkta;
		$ro_akta->paragraf		= $this->content_stripes;
		$ro_akta->original_id 	= $id;
		$ro_akta->save();

		return true;
	}
}