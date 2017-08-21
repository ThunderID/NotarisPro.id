<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Dokumen;
use App\Domain\Admin\Models\Kantor;

use App\Service\Akta\Traits\TextParseTrait;

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
 * 	1. simpan prev / next version
 * 	2. simpan new detected doc type
 * 	3. simpan new detected klien/objek/saksi
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class UpdateAkta
{
	use TextParseTrait;

	protected $id;
	protected $akta;
	protected $changed_paragraph;
	protected $variable;

	/**
	 * Create new instance.
	 *
	 * @param  string $id
	 */
	public function __construct($id)
	{
		$this->id					= $id;
		$this->akta 				= Dokumen::id($id)->wherenull('next')->firstorfail();
		$this->changed_paragraph	= [];
		$this->variable				= [];
	}

	//need enhance
	public function setParagraf($paragraf_baru)
	{
		$this->setParagrafParameter($paragraf_baru);
			
		$this->variable = $this->parseText();

		//1. Compare original paragraph and changes if it's allowed to edit
		if(in_array($this->akta->status, ['minuta', 'salinan']) && count($this->variable['paragraf']) == count($this->akta->paragraf))
		{
			foreach ($this->variable['paragraf'] as $key => $value) 
			{
				$temp_context 	= $value['konten'];
				$this->variable['paragraf'][$key]			= $this->akta->paragraf[$key];
				$this->variable['paragraf'][$key]['konten']	= $temp_context;

				similar_text($this->akta->paragraf[$key]['konten'], $value['konten'], $bobot); 
				
				if($bobot < 100 && $this->akta->paragraf[$key]['lock'] == null)
				{
					$this->variable['paragraf'][$key]['revisi'][]	= ['tanggal' => Carbon::now()->format('d/m/Y'), 'isi' => $this->akta->paragraf[$key]['konten']];
				}
				elseif($bobot < 100 && $this->akta->paragraf[$key]['lock'] != null)
				{
					throw new Exception("Ada kesalahan dalam perubahan!", 1);
				}
			}
		}
		elseif(in_array($this->akta->status, ['minuta', 'salinan']) && count($this->variable['paragraf']) != count($this->akta->paragraf))
		{
			throw new Exception("Ada kesalahan dalam perubahan!", 1);
		}
	}

	public function setJudul($judul)
	{
		$this->akta->judul 		= $judul;
	}

	public function setJenis($jenis)
	{
		$this->akta->jenis 		= $jenis;
	}

	/**
	 * update akta
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
			// 1. simpan prev / next version
			if(in_array($this->akta->status, ['minuta', 'salinan']) && (array)$this->changed_paragraph)
			{
				// 1a. save current version
				$current_version 						= new Dokumen;
				$current_version->judul 				= $this->akta->judul;
				$current_version->jenis 				= $this->akta->jenis;
				$current_version->paragraf 				= $this->akta->paragraf;
				$current_version->status 				= $this->akta->status;
				$current_version->versi 				= $this->akta->versi;
				$current_version->penulis 				= $this->akta->penulis;
				$current_version->pemilik 				= $this->akta->pemilik;
				$current_version->mentionable 			= $this->akta->mentionable;
				$current_version->prev 					= $this->akta->prev;
				$current_version->next 					= $this->akta->id;
				$current_version->required_documents 	= $this->akta->required_documents;
				$current_version->save();

				// 1b. update next from prev version
				$find_prev 		= Dokumen::where('next', $this->akta->id)->first();
				if($find_prev)
				{
					$find_prev->next 	= $current_version->id;
					$find_prev->save();
				}

				// 1c. update prev from current version
				$this->akta->prev 			= $current_version->id;
				$this->akta->versi 			= (int)$this->akta->versi + 1;

				$riwayat_status 			= $this->akta->riwayat_status;
				$riwayat_status[]			= [
					'status' 	=> $this->akta->status, 
					'editor' 	=> ['id' => $this->logged_user['id'], 'nama' => $this->logged_user['nama']], 
					'tanggal' 	=> Carbon::now()->format('Y-m-d H:i:s'),
					'versi'		=> $this->akta->versi,
				];
				$this->akta->riwayat_status = $riwayat_status;
			}

			if((array)$this->variable)
			{
				$this->akta->paragraf 		= $this->variable['paragraf'];
				$this->akta->dokumen 		= $this->variable['dokumen'];
				$this->akta->mentionable 	= $this->variable['mentionable'];
	
				//4. simpan new detected doc type
				$this->simpanTipeDokumen($this->variable['tipe_dokumen'], $this->active_office);

				//5. simpan new detected klien/objek/saksi
				$potential_owner 			= $this->updateDataDokumen($this->variable['dokumen']);
				// $this->updateDataDokumen($this->variable['dokumen']);
			}
	
			$this->akta->save();

			$sync 							= $this->syncRelatedDoc($this->akta, $potential_owner);

			return $this->akta;
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
}