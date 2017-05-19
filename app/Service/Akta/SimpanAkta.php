<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Dokumen;

use App\Domain\Order\Models\Klien;
use App\Domain\Order\Models\Jadwal;

use Exception, DB, TAuth, Carbon\Carbon;

class SimpanAkta
{
	protected $id;
	protected $judul;
	protected $isi_akta;
	protected $mentionable;

	/**
	 * Create a new job instance.
	 *
	 * @param  $akta
	 * @return void
	 */
	public function __construct($id, $judul, array $isi_akta, array $mentionable)
	{
		$this->id			= $id;
		$this->judul		= $judul;
		$this->isi_akta		= $isi_akta;
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
			//1a. pastikan akta exists
			$akta 		= Dokumen::findorfail($this->id);

			//1b. check status akta 
			if(!in_array($akta->status, ['renvoi', 'dalam_proses']))
			{
				throw new Exception("Status Harus Renvoi atau dalam proses", 1);
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

			//6. demi kenyamanan editing template
			//jika ada perubahan jumlah paragraf
			$template 			= Template::id($akta['template_id'])->first();
			$temp_para 			= $template->toArray();

			$jumlah_paragraf 		= count($temp_para['paragraf']);
			$jumlah_paragraf_baru  	= count($this->isi_akta);

			//6a. ada penambahan paragraf
			//check lokasi penambahan
			$add_para 				= [];
			if($jumlah_paragraf_baru > $jumlah_paragraf)
			{
				foreach ($jumlah_paragraf_baru as $key => $value) 
				{
					$para_baru 		= strip_tags($this->isi_akta[$key]);
					
					if(isset($akta['paragraf'][$key]))
					{
						$para_lama	= strip_tags($temp_para['paragraf'][$key]);
					}
					else
					{
						$para_lama 	= '';
					}

					similar_text($para_baru, $para_lama, $percent);

					if($percent > 50)
					{
						$add_para[$key-1] = ['akta_id' => $temp_para['id'], 'paragraf' => $key];
					} 
				}
			}

			//6b. ada pengurangan paragraf			
			//check lokasi pengurangan
			$rm_para 				= [];
			if($jumlah_paragraf_baru < $jumlah_paragraf)
			{
				foreach ($jumlah_paragraf as $key => $value) 
				{
					$para_baru 		= strip_tags($temp_para['paragraf'][$key]);
					
					if(isset($this->akta[$key]))
					{
						$para_lama	= strip_tags($this->akta[$key]);
					}
					else
					{
						$para_lama 	= '';
					}

					similar_text($para_baru, $para_lama, $percent);

					if($percent > 50)
					{
						$rm_para[$key+1] = ['akta_id' => $temp_para['id'], 'paragraf' => $key];
					} 
				}
			}

			//6c. perubahan paragraf
			//check lokasi pengurangan
			$cg_para 				= [];
			if($jumlah_paragraf_baru == $jumlah_paragraf)
			{
				foreach ($jumlah_paragraf as $key => $value) 
				{
					$para_baru 		= strip_tags($temp_para['paragraf'][$key]);
					$para_lama		= strip_tags($this->akta[$key]);

					similar_text($para_baru, $para_lama, $percent);

					if($percent > 0)
					{
						$cg_para[$key] = ['akta_id' => $temp_para['id'], 'paragraf' => $key];
					} 
				}
			}

			//6d. simpan perubahan template
			$template->penambahan_paragraf 	= array_merge($template->penambahan_paragraf, $add_para);
			$template->pengurangan_paragraf	= array_merge($template->pengurangan_paragraf, $rm_para);
			$template->perubahan_paragraf 	= array_merge($template->perubahan_paragraf, $cg_para);
			$template->save();

			//2. check lock
			$paragraf	= $akta['paragraf'];

			foreach ($this->isi_akta as $key => $value) 
			{
				if(!isset($paragraf[$key]['lock']) || is_null($paragraf[$key]['lock']))
				{
					$paragraf[$key]['konten']	= $value['konten'];
				}
			}

			//3. simpan value yang ada
			$akta->paragraf 		= $paragraf;

			//4. simpan mention
			$fill_mention 			= $akta->fill_mention;

			$pihak					= [];

			foreach($akta->mentionable as $key => $value)
			{
				if(isset($this->mentionable[$value]))
				{
					$fill_mention[str_replace('.','-+',str_replace('@','', $value))] = $this->mentionable[$value];

					if(str_is('@pihak.*.ktp.*', $value))
					{
						$pihaks 		= str_replace('@', '', $value);
						$pihaks 		= explode('.', $pihaks);

						$pihak[$pihaks[1]][$pihaks[3]]	= $this->mentionable[$value];
					}
				}
			}

			foreach ($pihak as $key => $value) 
			{
				$new_pihak 				= Klien::where('nomor_ktp', $value['nomor_ktp'])->first();

				if(!$new_pihak)
				{
					$new_pihak 			= new Klien;
				}

				$new_pihak 				= $new_pihak->fill($value);

				$new_pihak->save();
				$new_pihak 				= $new_pihak->toArray();
				
				$pemilik 				= $akta->pemilik;
				$pemilik['pemilik']['klien'][$key]['id'] 	= $new_pihak['id'];
				$pemilik['pemilik']['klien'][$key]['nama'] 	= $new_pihak['nama'];

				$akta->pemilik 			= $pemilik;

				$jadwal 				= Jadwal::where('original_id', $akta->_id)->first();
				if($jadwal)
				{
					$jadwal->peserta 	= $pemilik['pemilik']['klien'];
					$jadwal->save();
				}
			}

			$akta->fill_mention 		= $fill_mention;

			//5. simpan dokumen
			$akta->save();

			return $akta->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}