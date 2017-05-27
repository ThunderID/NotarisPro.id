<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Dokumen;
use App\Domain\Akta\Models\Versi;

use TImmigration\Pengguna\Models\Pengguna;

use Exception, TAuth, Carbon\Carbon;

/**
 * Service untuk update akta yang sudah ada
 *
 * Auth : 
 * 	1. hanya penulis @authorize
 * Validasi :
 * 	1. dapat di publish, status draft @editable
 * 	2. mentionable sudah terisi @validasi_mentionable
 * 	3. assign total perubahan @assign_total_perubahan
 * 	4. ganti kepemilikan @change_ownership
 * Smart :
 * 	1. lock all paragraf @lock_paragraph
 * 	2. versioning @versioning
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class PublishAkta
{
	protected $id;
	private $akta;
	private $loggedUser;
	private $activeOffice;

	/**
	 * Create a new job instance.
	 *
	 * @param 	string $id
	 * @return 	void
	 */
	public function __construct($id)
	{
		$this->id				= $id;
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

			//2. mentionable sudah terisi @validasi_mentionable
			$this->validasi_mentionable();

			//3. assign total perubahan @assign_total_perubahan
			$this->assign_total_perubahan();

			//4. ganti kepemilikan @change_ownership
			$this->change_ownership();

			//1. lock all paragraf @lock_paragraph
			$this->lock_paragraph();

			//1b. simpan dokumen
			if($this->akta->status == 'dalam_proses')
			{
				$this->akta->riwayat_status 	= array_merge($this->akta->riwayat_status, [['status' => 'draft', 'tanggal' => Carbon::now()->format('Y-m-d H:i:s'), 'petugas' => ['id' => $this->loggedUser['id'], 'nama' => $this->loggedUser['nama']]]]);
			}
			elseif($this->akta->status == 'renvoi')
			{
				$this->akta->riwayat_status 	= array_merge($this->akta->riwayat_status, [['status' => 'renvoi', 'tanggal' => Carbon::now()->format('Y-m-d H:i:s')], 'petugas' => ['id' => $this->loggedUser['id'], 'nama' => $this->loggedUser['nama']]]);
			}

			$this->akta->status 	= 'draft';
			$this->akta->save();

		 	// 2. versioning
			$this->versioning($this->id, $this->akta->toArray());

			$akta 		= new DaftarAkta;
			return $akta->detailed($this->id);
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
		if(!in_array($this->akta->status, ['dalam_proses', 'renvoi']))
		{
			throw new Exception("Status Harus dalam proses atau Renvoi", 1);
		}

		return true;
	}

	/**
	 * validasi mentionable
	 *
	 * @return Exception 'Data Akta belum lengkap'
	 * @return boolean true
	 */
	private function validasi_mentionable()
	{
		if(!in_array($this->akta->status, ['renvoi']))
		{
			foreach ($this->akta->mentionable as $key => $value) 
			{
				$fill 	= str_replace('@', '', $value);
				$fill 	= str_replace('.', '-+', $fill);
				
				if(!isset($this->akta->fill_mention[$fill]) && !str_is('akta-+nomor', $fill))
				{
					throw new Exception("Data Akta belum lengkap", 1);
				}
			}
		}

		return true;
	}

	/**
	 * assign total perubahan
	 *
	 * @return boolean true
	 */
	private function assign_total_perubahan()
	{
		if(str_is($this->akta->status, 'renvoi'))
		{
			$this->akta->total_perubahan	= ($this->akta->total_perubahan*1) + 1;
		}
		else
		{
			$this->akta->total_perubahan	= 0;
		}

		return true;
	}

	/**
	 * mengganti kepemilikan
	 *
	 * @return Exception 'Data Akta belum lengkap'
	 * @return boolean true
	 */
	private function change_ownership()
	{
		if(!str_is($this->activeOffice['role'], 'notaris'))
		{
			$owner 					= $this->akta->pemilik;
			foreach ($owner['orang'] as $key => $value) 
			{
				if(str_is($value['id'], $this->loggedUser['id']))
				{
					unset($owner['orang'][$key]);
				}
			}

			$lists 					= Pengguna::where('visas.kantor.id', $this->activeOffice['kantor']['id'])->where('visas.role', 'notaris')->get();

			foreach ($lists as $key => $value) 
			{
				$owner['orang'][] 	= ['id' => $value['id'], 'nama' => $value['nama']];
			}

			$this->akta->pemilik	= $owner;
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
			$paragraf[$key]['key']	= Dokumen::createID('key');
		}
		$this->akta->paragraf 			= $paragraf;

		return true;
	}

	/**
	 * fungsi untuk versioning data
	 *
	 * @return boolean true
	 */
	private function versioning($id, $akta)
	{
		$to_insert['judul'] 		= $akta['judul'];
		$to_insert['paragraf'] 		= $akta['paragraf'];
		$to_insert['status'] 		= $akta['status'];
		$to_insert['pemilik'] 		= $akta['pemilik'];
		$to_insert['penulis'] 		= $akta['penulis'];
		$to_insert['mentionable'] 	= $akta['mentionable'];
		$to_insert['fill_mention'] 	= $akta['fill_mention'];

		$versi 				= new Versi;
		$versi				= $versi->fill($to_insert);
		$versi->original_id	= $id;
		$versi->versi 		= 1;
		$versi->save();

		return true;
	}
}