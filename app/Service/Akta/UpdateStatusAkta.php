<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Dokumen;
use App\Domain\Admin\Models\Kantor;

use App\Infrastructure\Traits\GuidTrait;

use Exception, TAuth, Carbon\Carbon;

/**
 * Service untuk update status akta
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class UpdateStatusAkta
{
	use GuidTrait;

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
		$this->akta		= Dokumen::id($id)->wherenull('next')->firstorfail();
	}

	public function toMinuta()
	{
		//AUTH
		//1. Authorize who can access this thing
		$this->authorize();

		//SMART
		//1. lock all paragraf
		$paragraf 		= $this->akta->paragraf;
		foreach ($this->akta->paragraf as $key => $value) 
		{
			$paragraf[$key]['key']	= self::createID('key');
			$paragraf[$key]['lock']	= self::createID('lock');
		}

		$this->akta->status 		= 'minuta';
		$this->akta->paragraf 		= $paragraf;
		
		$riwayat_status 			= $this->akta->riwayat_status;
		$riwayat_status[]			= [
			'status' 	=> $this->akta->status, 
			'editor' 	=> ['id' => $this->logged_user['id'], 'nama' => $this->logged_user['nama']], 
			'tanggal' 	=> Carbon::now()->format('Y-m-d H:i:s'),
			'versi'		=> $this->akta->versi,
		];
		$this->akta->riwayat_status = $riwayat_status;

		$this->akta->save();


		return $this->akta;
	}

	//need test
	public function toSalinan($nomor)
	{
		//AUTH
		//1. Authorize who can access this thing
		$this->authorize();

		//SMART
		//1. ganti nomor
		$mentionable 	= $this->akta->mentionable;
		foreach ($mentionable as $key => $value) 
		{
			if(str_is($key, '@nomor.akta@'))
			{
				$mentionable[$key]		= $nomor;
			}
		}

		//2. lock all paragraf & insert nomor akta
		$paragraf 		= $this->akta->paragraf;
		foreach ($this->akta->paragraf as $key => $value) 
		{
			//2a. lock all para
			$paragraf[$key]['key']		= self::createID('key');
			$paragraf[$key]['lock']		= self::createID('lock');

			//2b. insert nomor akta
			if(str_is('*@akta.nomor@*', $paragraf[$key]['konten']))
			{
				$pattern 					= '/<(.+) data-mention="(.*)"(.*?)>(.*?)<\/(.+)>/';
				$paragraf[$key]['konten'] 	= preg_replace_callback($pattern, function($matches) use($nomor){
						$rplace 	= [
							'@akta.nomor@' => $nomor,
						];
						return '<'.$matches[1].' data-mention="'.$matches[2].'"'.$matches[3].'>'.$rplace[$matches[2]].'</'.$matches[5].'>';
					}, $paragraf[$key]['konten']);
			}
		}

		$this->akta->status 		= 'salinan';
		$this->akta->paragraf 		= $paragraf;
		
		$riwayat_status 			= $this->akta->riwayat_status;
		$riwayat_status[]			= [
			'status' 	=> $this->akta->status, 
			'editor' 	=> ['id' => $this->logged_user['id'], 'nama' => $this->logged_user['nama']], 
			'tanggal' 	=> Carbon::now()->format('Y-m-d H:i:s'),
			'versi'		=> $this->akta->versi,
		];
		$this->akta->riwayat_status = $riwayat_status;

		$this->akta->save();

		return $this->akta;
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