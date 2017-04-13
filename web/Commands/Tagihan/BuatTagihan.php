<?php

namespace TCommands\Tagihan;

use TTagihan\Tagihan\Models\Tagihan;

use Exception, DB, TAuth, Carbon\Carbon;

class BuatTagihan
{
	protected $tagihan;

	/**
	 * Create a new job instance.
	 *
	 * @param  $tagihan
	 * @return void
	 */
	public function __construct($tagihan)
	{
		$this->tagihan		= $tagihan;
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
			//1. jika dokumen sudah pernah ada, pastikan ownership terhadap status
			if(isset($this->tagihan['id']))
			{
				//1a. pastikan tagihan exists
				$tagihan 		= Tagihan::findorfail($this->tagihan['id']);

				//1b. pastikan tagihan tersebut milik kantor notaris yang sedang aktif 
				if(!in_array(TAuth::activeOffice()['kantor']['id'], $tagihan->oleh['kantor']))
				{
					throw new Exception("Anda tidak memiliki akses untuk tagihan ini", 1);
				}
			}
			else
			{
				$tagihan 		= new Tagihan;
			}

			//2. set ownership dokumen
			$this->tagihan['oleh']['id'] 	= TAuth::activeOffice()['kantor']['id'];
			$this->tagihan['oleh']['nama'] 	= TAuth::activeOffice()['kantor']['nama'];

			//3. simpan value yang ada
			$tagihan 			= $tagihan->fill($this->tagihan);

			//4. simpan tagihan
			$tagihan->save();

			return true;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}