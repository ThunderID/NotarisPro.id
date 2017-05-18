<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Template;
use App\Domain\Akta\Models\TipeDokumen;

use Exception, TAuth;

/**
 * Service untuk update template yang sudah ada
 *
 * Auth : 
 * 	1. hanya penulis @authorize
 * Validasi :
 * 	1. dapat diedit, status draft @editable
 * Policy : 
 * 	1. Restorasi Isi Paragraf @restorasi_isi_template
 * 	2. Restorasi Data mention @restorasi_isi_mentionable
 * Smart System : 
 * 	1. Update Mentionable Lists @enhance_mention
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class SimpanTemplate
{
	protected $id;
	protected $template;
	protected $isi_mentionable;
	private $template;
	private $loggedUser;
	private $activeOffice;

	/**
	 * Create a new job instance.
	 *
	 * @param 	string $id
	 * @param 	array $template
	 * @param 	array $isi_mentionable
	 * @return 	void
	 */
	public function __construct($id, array $template, array $isi_mentionable)
	{
		$this->id				= $id;
		$this->template			= $template;
		$this->isi_mentionable	= $isi_mentionable;
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
			
			// Policy : 
			// 1. Restorasi Isi Paragraf @restorasi_isi_template
			$this->template->paragraf 		= $this->restorasi_isi_template();
			
			// 	2. Restorasi Data mention @restorasi_isi_mentionable
			$this->template->mentionable	= $this->restorasi_isi_mentionable();
			
			// Smart System : 
			// 	1. Update Mentionable Lists @enhance_mention
			$this->enhance_mention();

			//3. simpan dokumen
			$this->template->save();

			$template 		= new DaftarTemplateAkta;
			return $template->detailed($id);
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
		$this->template 	= Template::id($this->id)->where('penulis.id', $this->loggedUser['id'])->kantor($this->activeOffice['kantor']['id'])->first();

		if(!$this->template)
		{
			throw new Exception("Template tidak ditemukan", 1);
		}

			//1b. check status akta 
			if(!str_is($akta->status, 'draft'))
			{
				throw new Exception("Status Harus draft", 1);
			}

		return true;
	
		//MELALUI CONSOLE
	}


	/**
	 * Editable content
	 *
	 * hanya status draft
	 *
	 * @return Exception 'Invalid User'
	 * @return boolean true
	 */
	private function editable()
	{
		//1. check status template 
		if(!str_is($this->template->status, 'draft'))
		{
			throw new Exception("Dokumen tidak bisa diubah", 1);
		}

		return true;
	}

	/**
	 * restorasi isi template
	 *
	 * @return array $isi_template
	 */
	private function restorasi_isi_template()
	{
		return $this->isi_template;
	}

	/**
	 * restorasi isi mentionable
	 *
	 * @return array $mentionable
	 */
	private function restorasi_isi_mentionable()
	{
		return $this->mentionable;
	}

	/**
	 * enhance mention
	 * learn new type of document
	 *
	 * @return array $tag
	 */
	private function enhance_mention()
	{
		//1. cek ada penambahan mention
		$penambahan_array 	= array_diff($this->template->mentionable, $this->mentionable);
		$jenis_dokumen 		= [];
		$isi 				= [];

		//2. ceck penambahan mention dengan data tipe dokumen
		$tipe_dok 			= TipeDokumen::kantor($this->activeOffice['kantor']['id'])->first();

		//3. cek prefix mention & dokumen
		foreach ($penambahan_array as $key => $value) 
		{
			if(in_array($value, $tipe_dok['jenis_dokumen']))
			{
				//3a. jika dokumen pihak
				if(str_is('@pihak.*', $value))
				{
					$variable 	= explode('.', $value);
					if(!isset($jenis_dokumen[$variable[2]]))
					{
						$isi[] 	= [$variable[2] => ['tags' => ['pihak']]];
					}
					
					$jenis_dokumen[$variable[2]][] = [$variable[3]];
				}

				//3b. jika dokumen saksi
				if(str_is('@saksi.*', $value))
				{
					$variable 	= explode('.', $value);
					if(!isset($jenis_dokumen[$variable[2]]))
					{
						$isi[] 	= [$variable[2] => ['tags' => ['saksi']]];
					}
					
					$jenis_dokumen[$variable[2]][] = [$variable[3]];
				}

				//3c. jika dokumen objek
				if(str_is('@objek.*', $value))
				{
					$variable 	= explode('.', $value);
					if(!isset($jenis_dokumen[$variable[1]]))
					{
						$isi[] 	= [$variable[1] => ['tags' => ['objek']]];
					}
					
					$jenis_dokumen[$variable[1]][] = [$variable[2]];
				}
			}
		}

		//4. simpan mention baru
		if(!empty($isi))
		{
			$tipe_dok->isi 				= array_merge($tipe_dok->isi, $isi);
			$tipe_dok->jenis_dokumen 	= array_merge($tipe_dok->jenis_dokumen, $jenis_dokumen);
		}

		$tipe_dok->save();

		return DaftarTag::all();
	}
}