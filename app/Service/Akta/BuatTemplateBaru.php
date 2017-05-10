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
	public function __construct(array $isi_template, array $mentionable)
	{
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

			$akta['paragraf']					= $this->isi_template;
			$akta['mentionable']				= $this->mentionable;

			//3. simpan value yang ada
			$dokumen			= $dokumen->fill($akta);

			//4. set status dokumen
			$dokumen->status 	= 'draft';

			//5. simpan dokumen
			$dokumen->save();

			return $dokumen->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}