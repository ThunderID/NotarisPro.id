<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Template;

use Exception, DB, TAuth, Carbon\Carbon;

class BuatTemplateBaru
{
	protected $isi_template;
	protected $mentionable;

	/**
	 * Create a new job instance.
	 *
	 * @param  $id
	 * @return void
	 */
	public function __construct($judul, array $isi_template, array $mentionable, $jumlah_pihak, array $dokumen_objek, array $dokumen_pihak, array $dokumen_saksi)
	{
		$this->judul			= $judul;
		$this->isi_template		= $isi_template;
		$this->mentionable		= $mentionable;
		$this->jumlah_pihak		= $jumlah_pihak;
		$this->dokumen_objek	= $dokumen_objek;
		$this->dokumen_pihak	= $dokumen_pihak;
		$this->dokumen_saksi	= $dokumen_saksi;
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
			//1. init template
			$template 		= new Template;

			//2. set template content
			$akta['pemilik']['kantor']['id'] 	= TAuth::activeOffice()['kantor']['id'];
			$akta['pemilik']['kantor']['nama'] 	= TAuth::activeOffice()['kantor']['nama'];

			$akta['penulis']['id'] 				= TAuth::loggedUser()['id'];
			$akta['penulis']['nama'] 			= TAuth::loggedUser()['nama'];

			$akta['judul']						= $this->judul;
			$akta['paragraf']					= $this->isi_template;
			$akta['mentionable']				= $this->mentionable;
			$akta['jumlah_pihak']				= $this->jumlah_pihak;
			$akta['dokumen_objek']				= $this->dokumen_objek;
			$akta['dokumen_saksi']				= $this->dokumen_saksi;

			foreach (range(1, $this->jumlah_pihak) as $key) 
			{
				$akta['dokumen_pihak'][$key]	= $this->dokumen_pihak[$key-1];
			}

			//3. simpan value yang ada
			$template							= $template->fill($akta);

			//4. set status template
			$template->status 					= 'draft';

			//5. simpan template
			$template->save();

			return $template->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}