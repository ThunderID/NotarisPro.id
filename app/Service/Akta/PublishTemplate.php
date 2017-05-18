<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Template;

use Exception, TAuth;

/**
 * Service untuk update template yang sudah ada
 *
 * Auth : 
 * 	1. hanya penulis @authorize
 * Validasi :
 * 	1. dapat di publish, status draft @editable
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class PublishTemplate
{
	protected $id;
	private $template;
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

			//2. simpan dokumen
			$this->template->status 	= 'publish';
			$this->template->save();

			$template 		= new DaftarTemplateAkta;
			return $template->detailed($this->id);
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

		return true;
	
		//MELALUI CONSOLE
	}


	/**
	 * publishable content
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
}