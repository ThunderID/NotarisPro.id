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
	public function __construct($judul, array $isi_template, array $mentionable)
	{
		$this->judul		= $judul;
		$this->isi_template	= $isi_template;
		$this->mentionable	= $mentionable;
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

			//3. simpan value yang ada
			$template			= $template->fill($akta);

			//4. set status template
			$template->status 	= 'draft';

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