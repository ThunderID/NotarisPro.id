<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Dokumen;
use App\Domain\Admin\Models\Kantor;

use App\Service\Akta\Traits\TextParseTrait;
use App\Service\Akta\Traits\AssignAktaTrait;

use Exception, TAuth, Carbon\Carbon;

/**
 * Service untuk update status akta
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class DuplikasiAkta
{
	use TextParseTrait;
	use AssignAktaTrait;

	protected $id;
	protected $akta;

	/**
	 * Create new instance.
	 *
	 * @param  string $id
	 */
	public function __construct($id)
	{
		$this->id		= $id;
		$this->akta		= Dokumen::id($id)->wherenull('next')->status('salinan')->firstorfail();
	}

	public function save()
	{
		//AUTH
		//1. Authorize who can access this thing
		$this->authorize();

		$akta 			= new Dokumen;

		//SMART
		//1. CHANGE MENTIONABLE
		$mentionable 	= [];

		foreach ($this->akta->mentionable as $key => $value) 
		{
			$mentionable[$key]		= null;
		}

		//2. CHANGE DOKUMEN
		$dokumen 		= [];
		foreach ($this->akta->dokumen as $key_td => $tipe_doku) 
		{
			//key : pihak[dot]1
			//value ['ktp[dot]pribadi' => ['nama' => 'ABC'], 'kk' => ['nomor' => '1283']]]
			foreach ($tipe_doku as $key_nu => $nomor_urut) 
			{
				//key : ktp[dot]pribadi
				//value ['nama' => 'ABC']
				foreach ($nomor_urut as $key_jd => $jenis_doku) 
				{
					//key : nama
					//value ABC
					$dokumen[$key_td][$key_nu][$key_jd]	= null;
				}
			}
		}

		//3. CHANGE PARAGRAF
		// remove all lock and stuffs
		$paragraf 		= [];

		foreach ($this->akta->paragraf as $key => $value) 
		{
			$pattern_span	= '/<span class="medium-editor-mention-at.*?data-mention="@.*?@">(.*?)<\/span>/i';
			preg_match_all($pattern_span, $value['konten'], $spans);

			$paragraf[$key]['konten']		= $value['konten'];
			foreach ((array)$spans[1] as $k_span => $v_span) 
			{
				$paragraf[$key]['konten']	= str_replace($v_span, '', $paragraf[$key]['konten']);
			}
		}

		//4. ASSIGN WRITER
		$akta->penulis	= $this->assignWriter();

	 	// 5. ASSIGN OWNER
		$akta->pemilik	= $this->assignOwner();

		// 6. parse inisialisasi dokumen akta
		$akta->status	= 'dalam_proses';
		$akta->versi	= '1';
		$akta->judul	= $this->akta->judul;
		$akta->jenis	= $this->akta->jenis;
		$akta->prev		= $this->akta->id;
		$akta->next		= null;

		$akta->mentionable 		= $mentionable;
		$akta->dokumen 			= $dokumen;
		$akta->paragraf 		= $paragraf;

		$akta->save();

		return $akta;
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

		if($this->active_office['kantor']['id']!=$this->akta['pemilik']['kantor']['id'])
		{
			throw new Exception("Tidak ditemukan", 1);
		}
		
		return true;
	
		//MELALUI CONSOLE
	}
}