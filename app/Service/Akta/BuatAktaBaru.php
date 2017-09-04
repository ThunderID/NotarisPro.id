<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Dokumen;
use App\Domain\Admin\Models\Kantor;

use App\Domain\Akta\Models\TipeDokumen;
use App\Domain\Invoice\Models\Klien;
use App\Domain\Invoice\Models\Objek;

use App\Service\Akta\Traits\TextParseV2Trait;
use App\Service\Akta\Traits\AssignAktaTrait;

use App\Events\AktaUpdated;

use Exception, TAuth, Carbon\Carbon;

/**
 * Service untuk membuat akta baru
 *
 * Auth : 
 * 	1. Siapa pun yang teregistrasi dalam sistem @authorize
 * Policy : 
 * 	1. Restorasi Isi Paragraf @restorasi_isi_akta
 * 	2. Restorasi Data mention @restorasi_isi_mentionable
 * 	3. Validate template @validasi_template
 * Smart System : 
 *  1. parsing Isi Paragraf @parseText
 * 	2. Auto Assign Writer @assignWriter
 * 	3. Auto Assign Owner @assignOwner
 * 	4. simpan new detected doc type
 * 	5. simpan new detected klien/objek/saksi
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class BuatAktaBaru
{
	use TextParseV2Trait;
	use AssignAktaTrait;

	protected $judul;
	protected $jenis;

	/**
	 * Create new instance.
	 *
	 * @param  string $judul
	 * @param  array $paragraf
	 * @return BuatAktaBaru $akta
	 */
	public function __construct($judul, $jenis, $paragraf)
	{
		$this->judul		= $judul;
		$this->jenis		= $jenis;
		$this->setParagrafParameter($paragraf);
	}

	/**
	 * Simpan akta baru
	 *
	 * @return array $akta
	 */
	public function save()
	{
		try
		{
			// Auth : 
		 	// 1. Siapa pun yang teregistrasi dalam sistem @authorize
			$this->authorize();

			// Smart System : 
		 	// 1. parsing Isi Paragraf @parseText
		 	$variable					= $this->parseText();

			// 2. Auto Assign Writer @assignWriter
			$variable['penulis'] 		= $this->assignWriter();

			// 3. parse inisialisasi dokumen akta
			$variable['status']			= 'dalam_proses';
			$variable['versi']			= '1';
			$variable['judul']			= $this->judul;
			$variable['jenis']			= $this->jenis;
			$variable['prev']			= null;
			$variable['next']			= null;
			$variable['riwayat_status'][0]	= [
				'status' 	=> $variable['status'], 
				'editor' 	=> ['id' => $this->logged_user['id'], 'nama' => $this->logged_user['nama']], 
				'tanggal' 	=> Carbon::now()->format('Y-m-d H:i:s'),
				'versi'		=> $variable['versi'],
			];

			// STORE
			//1. simpan new detected doc type
			$this->simpanTipeDokumen($variable['tipe_dokumen'], $this->active_office);

			//2. simpan new detected klien/objek/saksi
			//not exists yet
			// $potential_owner 			= $this->updateDataDokumen($variable['dokumen']);

		 	//3. Sisipan Assign Owner @assignOwner
			// $variable['pemilik'] 		= $this->assignOwner($potential_owner['pihak']);
			$variable['pemilik'] 		= $this->assignOwner(null);

			//3. init akta
			$akta 						= new Dokumen;

			//4. simpan value yang ada
			$akta						= $akta->fill($variable);

			//5. simpan akta
			$akta->save();

			//not needed yet
			// $sync 						= $this->syncRelatedDoc($akta, $potential_owner);

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
		$this->active_office 	= TAuth::activeOffice();
		$this->logged_user 		= TAuth::loggedUser();

		return true;
	
		//MELALUI CONSOLE
	}

	/**
	 * fungsi untuk watermarking data
	 *
	 * @return string watermark
	 */
	private function watermarking()
	{
		return env('APP_WATERMARK', 'APP_WATERMARK');
	}
}