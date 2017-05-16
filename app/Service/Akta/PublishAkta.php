<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Versi;
use App\Domain\Akta\Models\Dokumen;
use TImmigration\Pengguna\Models\Pengguna;

use Exception, DB, TAuth, Carbon\Carbon;

class PublishAkta
{
	protected $id;

	/**
	 * Create a new job instance.
	 *
	 * @param  $id
	 * @return void
	 */
	public function __construct($id)
	{
		$this->id		= $id;
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
			//1a. pastikan akta exists
			$akta 		= Dokumen::findorfail($this->id);

			//1b. check status akta 
			if(!in_array($akta->status, ['draft', 'renvoi']))
			{
				throw new Exception("Status Harus Draft atau Renvoi", 1);
			}

			//1c. pastikan akta tersebut dimiliki oleh logged user / akses 
			if(!in_array(TAuth::loggedUser()['id'], [$akta->pemilik['orang'][0]['id']]))
			{
				throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
			}

			//1d. pastikan akta tersebut milik kantor notaris yang sedang aktif 
			if(!in_array(TAuth::activeOffice()['kantor']['id'], $akta->pemilik['kantor']))
			{
				throw new Exception("Anda tidak memiliki akses untuk akta ini", 1);
			}

			//2. Lock semua paragraf
			$paragraf 					= [];
			foreach ($akta->paragraf as $key => $value) 
			{
				$paragraf[$key] 		= $value;
				$paragraf[$key]['lock']	= Dokumen::createID('lock');
			}
			$akta->paragraf 			= $paragraf;

			//3. Ganti kepemilikan
			if(!str_is(TAuth::activeOffice()['role'], 'notaris'))
			{
				$owner 					= $akta->pemilik;
				foreach ($owner['orang'] as $key => $value) 
				{
					if(str_is($value['id'], TAuth::loggedUser()['id']))
					{
						unset($owner['orang'][$key]);
					}
				}

				$lists 					= Pengguna::where('visas.kantor.id', TAuth::activeOffice()['kantor']['id'])->where('visas.role', 'notaris')->get();

				foreach ($lists as $key => $value) 
				{
					$owner['orang'][] 	= ['id' => $value['id'], 'nama' => $value['nama']];
				}

				$akta->pemilik 			= $owner;
			}

			//4a. check status renvoi
			if(str_is($akta->status, 'renvoi'))
			{
				$akta->total_perubahan	= ($akta->total_perubahan*1) + 1;
			}
			else
			{
				$akta->total_perubahan	= 0;
			}

			//4. check mentionable
			if(!in_array($akta->status, ['renvoi']))
			{
				foreach ($akta->mentionable as $key => $value) 
				{
					$fill 	= str_replace('@', '', $value);
					$fill 	= str_replace('.', '-+', $fill);
					
					if(!isset($akta->fill_mention[$fill]))
					{
						throw new Exception("Data Akta belum lengkap", 1);
					}
				}
			}

			//5. set status
			$akta->status 			= 'pengajuan';

			$akta->save();

			$akta 						= $akta->toArray();
			$to_insert['judul'] 		= $akta['judul'];
			$to_insert['paragraf'] 		= $akta['paragraf'];
			$to_insert['status'] 		= $akta['status'];
			$to_insert['pemilik'] 		= $akta['pemilik'];
			$to_insert['penulis'] 		= $akta['penulis'];
			$to_insert['mentionable'] 	= $akta['mentionable'];
			$to_insert['fill_mention'] 	= $akta['fill_mention'];

			//6. simpan versi
			$prev_versi 			= Versi::where('original_id', $akta['id'])->orderby('created_at', 'desc')->first();
			$versi 					= new Versi;
			$versi 					= $versi->fill($to_insert);
			$versi->original_id 	= $akta['id'];
			$versi->versi 			= ($prev_versi->versi*1) + 1;
			$versi->save();

			return $akta;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}