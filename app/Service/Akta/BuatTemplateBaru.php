<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Template;
use App\Domain\Akta\Models\TipeDokumen;

use Exception, TAuth;

/**
 * Service untuk membuat template baru
 *
 * Auth : 
 * 	1. Siapa pun yang teregistrasi dalam sistem @authorize
 * Policy : 
 * 	1. Validasi Judul @validasi_judul
 * 	2. Validasi Regulasi Pihak @regulasi_pihak
 * 	3. Validasi Regulasi Saksi @regulasi_saksi
 * 	4. Validasi Dokumen Saksi @validasi_dokumen_saksi
 * 	5. Validasi Dokumen Pihak @validasi_dokumen_pihak
 * 	6. Validasi Dokumen Objek @validasi_dokumen_objek
 * 	7. Restorasi Isi Paragraf @restorasi_isi_template
 * 	8. Restorasi Data mention @restorasi_isi_mentionable
 * Smart System : 
 * 	1. Auto Assign Writer @assign_writer
 * 	2. Auto Assign Owner @assign_owner
 * 	3. Update Mentionable Lists @enhance_mention
 * 	4. Watermarking @watermarking
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class BuatTemplateBaru
{
	protected $judul;
	protected $deskripsi;
	protected $isi_template;
	protected $mentionable;
	protected $jumlah_pihak;
	protected $jumlah_saksi;
	protected $dokumen_objek;
	protected $dokumen_pihak;
	protected $dokumen_saksi;
	private $kantor;

	/**
	 * Create new instance.
	 *
	 * @param  string $judul
	 * @param  string $deskripsi
	 * @param  array $isi_template
	 * @param  array $mentionable
	 * @param  string $jumlah_pihak
	 * @param  string $jumlah_saksi
	 * @param  array $dokumen_objek
	 * @param  array $dokumen_pihak
	 * @param  array $dokumen_saksi
	 * @return BuatTemplateBaru $template
	 */
	public function __construct($judul, $deskripsi, array $isi_template, array $mentionable, $jumlah_pihak, $jumlah_saksi, array $dokumen_objek, array $dokumen_pihak, array $dokumen_saksi)
	{
		$this->judul			= $judul;
		$this->deskripsi		= $deskripsi;
		$this->isi_template		= $isi_template;
		$this->mentionable		= $mentionable;
		$this->jumlah_pihak		= $jumlah_pihak;
		$this->jumlah_saksi		= $jumlah_saksi;
		$this->dokumen_objek	= $dokumen_objek;
		$this->dokumen_pihak	= $dokumen_pihak;
		$this->dokumen_saksi	= $dokumen_saksi;
	}

	/**
	 * Simpan template baru
	 *
	 * @return array $template
	 */
	public function save()
	{
		try
		{
			// Auth : 
		 	// 1. Siapa pun yang teregistrasi dalam sistem @authorize
			$this->authorize();

			// Policy : 
			// 1. Validasi Judul @validasi_judul
			$this->validasi_judul();

		 	// 2. Validasi Regulasi Pihak @regulasi_pihak
		 	$this->regulasi_pihak();

		 	// 3. Validasi Regulasi Saksi @regulasi_saksi
		 	$this->regulasi_saksi();

		 	// 4. Validasi Dokumen Saksi @validasi_dokumen_saksi
		 	$variable['dokumen_saksi']	= $this->validasi_dokumen_saksi();

		 	// 5. Validasi Dokumen Pihak @validasi_dokumen_pihak
		 	$variable['dokumen_pihak']	= $this->validasi_dokumen_pihak();

		 	// 6. Validasi Dokumen Objek @validasi_dokumen_objek
		 	$variable['dokumen_objek']	= $this->validasi_dokumen_objek();

		 	// 7. Restorasi Isi Paragraf @restorasi_isi_template
		 	$variable['paragraf']		= $this->restorasi_isi_template();

		 	// 8. Restorasi Data mention @restorasi_isi_mentionable
		 	$variable['mentionable']	= $this->restorasi_isi_mentionable();

			// Smart System : 
			// 1. Auto Assign Writer @assign_writer
			$variable['penulis'] 		= $this->assign_writer();

		 	// 2. Auto Assign Owner @assign_owner
			$variable['pemilik'] 		= $this->assign_owner();

		 	// 3. Update Mentionable Lists @enhance_mention
			$this->enhance_mention();

		 	// 4. Watermarking @watermarking
			$variable['watermarking']	= $this->watermarking();

			// STORE
			//1. init template
			$template 					= new Template;

			//2. parse variable
			$variable['judul']			= $this->judul;
			$variable['deskripsi']		= $this->deskripsi;
			$variable['jumlah_pihak']	= $this->jumlah_pihak;
			$variable['jumlah_saksi']	= $this->jumlah_saksi;
		
			//3. simpan value yang ada
			$template					= $template->fill($variable);

			//4. set status template
			$template->status 			= 'draft';

			//5. simpan template
			$template->save();

			$daftar_template 			= new DaftarTemplateAkta;

			return $daftar_template->detailed($template->_id);
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
		$this->kantor 			= TAuth::activeOffice();

		return true;
	
		//MELALUI CONSOLE
	}

	/**
	 * Validasi Judul
	 *
	 * 1. Judul harus unique
	 *
	 * @return Exception 'Judul sudah pernah dipakai'
	 * @return boolean true
	 */
	private function validasi_judul()
	{
		$judul		= Template::where('judul', $this->judul)->kantor($this->kantor['kantor']['id'])->first();
		
		if($judul)
		{
			throw new Exception("Judul sudah pernah dipakai", 1);
		}

		return true;
	}

	/**
	 * Regulasi Pihak
	 *
	 * 1. Jumlah pihak harus lebih dari 2 menurut UUD
	 *
	 * @return Exception 'Jumlah pihak minimal 2'
	 * @return boolean true
	 */
	private function regulasi_pihak()
	{
		if($this->jumlah_saksi < 2)
		{
			throw new Exception("Jumlah pihak minimal 2", 1);
		}
		return true;
	}

	/**
	 * Regulasi saksi
	 *
	 * 1. Jumlah Saksi harus lebih dari 2 menurut UUD
	 *
	 * @return Exception 'Jumlah saksi minimal 2'
	 * @return boolean true
	 */
	private function regulasi_saksi()
	{
		if($this->jumlah_saksi < 2)
		{
			throw new Exception("Jumlah saksi minimal 2", 1);
		}
		return true;
	}

	/**
	 * Validasi Dokumen Saksi
	 *
	 * 1. Jumlah dokumen dan jumlah saksi harus sama
	 *
	 * @return Exception 'Dokumen saksi ... belum ada '
	 * @return array $akta['dokumen_saksi']
	 */
	private function validasi_dokumen_saksi()
	{
		$akta['dokumen_saksi']				= [];

		foreach (range(1, $this->jumlah_saksi) as $key) 
		{
			$akta['dokumen_saksi'][$key]	= $this->dokumen_saksi[$key];
		}

		if(count($akta['dokumen_saksi'])!= $this->jumlah_saksi)
		{
			throw new Exception("Dokumen saksi tidak lengkap", 1);
		}

		return $akta['dokumen_saksi'];
	}

	/**
	 * Validasi Dokumen pihak
	 *
	 * 1. Jumlah dokumen dan jumlah pihak harus sama
	 *
	 * @return Exception 'Dokumen pihak ... belum ada '
	 * @return array $akta['dokumen_pihak']
	 */
	private function validasi_dokumen_pihak()
	{
		$akta['dokumen_pihak']				= [];

		foreach (range(1, $this->jumlah_pihak) as $key) 
		{
			$akta['dokumen_pihak'][$key]	= $this->dokumen_pihak[$key];
		}

		if(count($akta['dokumen_pihak'])!= $this->jumlah_pihak)
		{
			throw new Exception("Dokumen pihak tidak lengkap", 1);
		}
		
		return $akta['dokumen_pihak'];
	}

	/**
	 * Validasi Dokumen objek
	 *
	 * @return array $dokumen_objek
	 */
	private function validasi_dokumen_objek()
	{
		return $this->dokumen_objek;
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
	 * assign writer
	 *
	 * @return array $writer
	 */
	private function assign_writer()
	{
		$akta['penulis']['id'] 				= TAuth::loggedUser()['id'];
		$akta['penulis']['nama'] 			= TAuth::loggedUser()['nama'];

		return $akta['penulis'];
	}

	/**
	 * assign owner
	 *
	 * @return array $owner
	 */
	private function assign_owner()
	{
		$akta['pemilik']['kantor']['id'] 	= $this->kantor['kantor']['id'];
		$akta['pemilik']['kantor']['nama'] 	= $this->kantor['kantor']['nama'];

		return $akta['pemilik'];
	}

	/**
	 * enhance mention
	 * learn new type of document
	 *
	 * @return array $tag
	 */
	private function enhance_mention()
	{
		$tipe_dok 			= TipeDokumen::kantor($this->kantor['kantor']['id'])->first();
		$isi_doks 			= $tipe_dok['isi'];
		$jenis_doks 		= $tipe_dok['jenis_dokumen'];
		$jenis 				= array_keys($jenis_doks);

		//check dokumen pihak
		foreach ($this->dokumen_pihak as $key => $value) 
		{
			foreach ($value as $key3 => $value3) 
			{
				if(!in_array($key3, $jenis))
				{
					$jenis_doks 		= array_merge($jenis_doks, [$key3 => ['tags' => 'pihak']]);

					$isi_doks[$key3]	= [];

					//check isi dokumen baru
					foreach ($this->mentionable as $key2 => $value2) 
					{
						if(str_is('*'.$key3.'*', $value2))
						{
							$new_content 				= explode('.'.$key3.'.', $value2);
							$isi_doks[$key3]			= array_merge($isi_doks[$key3], [$new_content[1]]);
						}
					}
				}
			}
		}

		//check dokumen objek
		foreach ($this->dokumen_objek as $key => $value) 
		{
			foreach ($value as $key3 => $value3) 
			{
				if(!in_array($key3, $jenis))
				{
					$jenis_doks 		= array_merge($jenis_doks, [$key3 => ['tags' => 'objek']]);

					$isi_doks[$key3]	= [];

					//check isi dokumen baru
					foreach ($this->mentionable as $key2 => $value2) 
					{
						if(str_is('*'.$key3.'*', $value2))
						{
							$new_content 				= explode('.'.$key3.'.', $value2);
							$isi_doks[$key3]			= array_merge($isi_doks[$key3], [$new_content[1]]);
						}
					}
				}
			}
		}

		//check dokumen saksi
		foreach ($this->dokumen_saksi as $key => $value) 
		{
			foreach ($value as $key3 => $value3) 
			{
				if(!in_array($key3, $jenis))
				{
					$jenis_doks 		= array_merge($jenis_doks, [$key3 => ['tags' => 'saksi']]);

					$isi_doks[$key3]	= [];

					//check isi dokumen baru
					foreach ($this->mentionable as $key2 => $value2) 
					{
						if(str_is('*'.$key3.'*', $value2))
						{
							$new_content 				= explode('.'.$key3.'.', $value2);
							$isi_doks[$key3]			= array_merge($isi_doks[$key3], [$new_content[1]]);
						}
					}
				}
			}
		}

		$tipe_dok->isi 				= $isi_doks;
		$tipe_dok->jenis_dokumen	= $jenis_doks;

		$tipe_dok->save();

		return DaftarTag::all();
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