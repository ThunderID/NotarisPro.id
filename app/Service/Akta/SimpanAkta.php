<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Dokumen;
use App\Domain\Akta\Models\Template;
use App\Domain\Order\Models\Klien;

use Exception, TAuth, Carbon\Carbon;

use App\Service\Akta\Traits\EnhanceKlienTrait;

use App\Events\AktaUpdated;

/**
 * Service untuk update akta yang sudah ada
 *
 * Auth : 
 * 	1. hanya penulis @authorize
 * Validasi :
 * 	1. dapat diedit, status draft, atau unlocked renvoi @editable
 * Policy : 
 * 	1. Restorasi Isi Paragraf @restorasi_isi_akta
 * Smart System : 
 * 	1. Smartly updating mentionable @parse_mentionable
 * 	2. Perubahan isi paragraf @updated_paragraf
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class SimpanAkta
{
	use EnhanceKlienTrait;
	
	protected $id;
	protected $judul;
	protected $isi_akta;
	protected $mentionable;
	private $akta;
	private $loggedUser;
	private $activeOffice;

	/**
	 * Create a new job instance.
	 *
	 * @param 	string $id
	 * @param 	array $isi_akta
	 * @param 	array $mentionable
	 * @return 	void
	 */
	public function __construct($id, $judul, array $isi_akta, array $mentionable)
	{
		$this->id				= $id;
		$this->judul			= $judul;
		$this->isi_akta			= $isi_akta;
		$this->mentionable		= $mentionable;
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
			
			// Policy : 
			// 1. Restorasi Isi Paragraf @restorasi_isi_akta
			$this->akta->paragraf 		= $this->restorasi_isi_akta();

			// Smart System : 
			// 	1. Smartly updating mentionable @parse_mentionable
			$this->akta->fill_mention	= $this->parse_mentionable();

			// 2. Perubahan isi paragraf @updated_paragraf
			$this->updated_paragraf();
			
			//3. simpan dokumen
			if(!empty($this->judul))
			{
				$this->akta->judul 			= $this->judul;
			}
			$this->akta->save();

			$akta 		= new DaftarAkta;
			$akta 		= $akta->detailed($this->id);

			event(new AktaUpdated($akta));

			return $akta;
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
		$this->akta 		= Dokumen::id($this->id)->where('penulis.id', $this->loggedUser['id'])->kantor($this->activeOffice['kantor']['id'])->first();

		if(!$this->akta)
		{
			throw new Exception("Akta tidak ditemukan", 1);
		}

		return true;
	
		//MELALUI CONSOLE
	}

	/**
	 * Editable content
	 *
	 * hanya status dalam_proses, renvoi yang tidak di lock
	 *
	 * @return Exception 'Invalid User'
	 * @return boolean true
	 */
	private function editable()
	{
		//1. check status akta 
		if(!in_array($this->akta->status, ['dalam_proses', 'renvoi']))
		{
			throw new Exception("Dokumen tidak bisa diubah", 1);
		}

		//2. check lock
		foreach ($this->isi_akta as $key => $value) 
		{
			if(isset($this->akta['paragraf'][$key]['lock']))
			{
				throw new Exception("Dokumen tidak bisa diubah", 1);
			}


			//demi menghemat resource, versioning lies here
			$para_lama 		= strip_tags($value['konten']);
			$para_baru 		= strip_tags($this->akta['paragraf'][$key]['konten']);
			similar_text($para_lama, $para_baru, $percent);

			if($percent > 0)
			{
				if(isset($this->akta['paragraf'][$key]['version']))
				{
					$this->isi_akta[$key]['version']	= $this->akta['paragraf'][$key]['version'];
				}

				$this->isi_akta[$key]['version'][]	= ['konten' => $this->akta['paragraf'][$key]['konten'], 'tanggal' => Carbon::now()->format('Y-m-d H:i:s')];
			}

		}

		return true;
	}

	/**
	 * restorasi isi akta
	 *
	 * @return array $isi_akta
	 */
	private function restorasi_isi_akta()
	{
		return $this->isi_akta;
	}

	/**
	 * restorasi isi mentionable
	 *
	 * @return array $mentionable
	 */
	private function restorasi_isi_mentionable()
	{
		return $this->mentionable;
	}

	/**
	 * smartly parse mentionable
	 * 1. parse new param
	 * 2. update data klien (if exists)
	 * 3. update data pemilik as new pihak defined
	 *
	 * @return array $fill_mention
	 */
	private function parse_mentionable()
	{
		$fill_mention 				= $this->akta->fill_mention;
		$pihak 						= [];
		foreach($this->akta->mentionable as $key => $value)
		{
			if(isset($this->mentionable[$value]))
			{
				//here is where parse new param happen
				$fill_mention[str_replace('.','-+',str_replace('@','', $value))] = $this->mentionable[$value];

				//here is how we defining data
				if(str_is('@pihak.*.ktp.*', $value))
				{
					$pihaks 		= str_replace('@', '', $value);
					$pihaks 		= explode('.', $pihaks);

					$pihak[$pihaks[1]][$pihaks[3]]	= $this->mentionable[$value];
				}
			}
		}

		if((array)$pihak)
		{
			$pemilik 				= $this->akta->pemilik;

			$klien					= $this->enhance_klien($pihak);

			if((array)$klien)
			{
				$pemilik['klien']	= $klien;
			}
			$this->akta->pemilik 	= $pemilik;
		}

		return $fill_mention;
	}

	/**
	 * check edited paragraf
	 * untuk stat template
	 *
	 * @return boolean true
	 */
	private function updated_paragraf()
	{
		$this->template 				= new DaftarTemplateAkta;
		$this->template 				= $this->template->detailed($this->akta->template['id']);

		$jumlah_paragraf				= count($this->template['paragraf'])-1;
		$jumlah_paragraf_baru			= count($this->isi_akta)-1;
		
		//6a. perubahan paragraf
		//check lokasi pengurangan
		$cg_para 				= [];
		if($jumlah_paragraf_baru == $jumlah_paragraf)
		{
			foreach (range(0, $jumlah_paragraf) as $key) 
			{
				$para_baru 		= strip_tags($this->isi_akta[$key]['konten']);
				$para_lama		= strip_tags($this->template['paragraf'][$key]['konten']);

				similar_text($para_baru, $para_lama, $percent);

				if(100 - $percent > 0)
				{
					$cg_para 				= ['akta_id' => $this->id, 'paragraf' => $key, 'persentasi' => 100 - $percent];
					if(isset($this->template['paragraf'][$key]['changed']))
					{
						$this->template['paragraf'][$key]['changed']	= array_merge($this->template['paragraf'][$key]['changed'], [$cg_para]);
					}
					else
					{
						$this->template['paragraf'][$key]['changed']	= [$cg_para];
					}
				}
			}
		}

		//6b. ada penambahan paragraf
		//check lokasi penambahan
		$add_para 				= [];
		$find_add 				= 0;
		if($jumlah_paragraf_baru > $jumlah_paragraf)
		{
			foreach (range(0, $jumlah_paragraf_baru) as $key) 
			{
				$para_baru 		= strip_tags($this->isi_akta[$key]['konten']);
				
				if(isset($this->template['paragraf'][$key-$find_add]))
				{
					$para_lama	= strip_tags($this->template['paragraf'][$key-$find_add]['konten']);
				}
				else
				{
					$para_lama 	= '';
				}

				similar_text($para_baru, $para_lama, $percent);

				if(100 - $percent > 50)
				{
					$find_add 			= $find_add + 1; 
					$add_para 			= ['akta_id' => $this->id];
	
					if(isset($this->template['paragraf'][$key]['added']))
					{
						$this->template['paragraf'][$key]['added']		= array_merge($this->template['paragraf'][$key]['added'], [$add_para]);
					} 
					else
					{
						$this->template['paragraf'][$key]['added']		= [$add_para];
					}
				} 
			}
		}

		//6c. ada pengurangan paragraf			
		//check lokasi pengurangan
		$rm_para 				= [];
		$find_rm 				= 0;
		if($jumlah_paragraf_baru < $jumlah_paragraf)
		{
			foreach (range(0, $jumlah_paragraf) as $key) 
			{
				$para_baru 		= strip_tags($this->template['paragraf'][$key]['konten']);
				
				if(isset($this->isi_akta[$key - $find_rm]))
				{
					$para_lama	= strip_tags($this->isi_akta[$key - $find_rm]['konten']);
				}
				else
				{
					$para_lama 	= '';
				}

				similar_text($para_baru, $para_lama, $percent);

				if(100 - $percent > 50)
				{
					$find_rm 		= $find_rm + 1;
					$rm_para 		= ['akta_id' => $this->id];

					if(isset($this->template['paragraf'][$key]['removed']))
					{
						$this->template['paragraf'][$key]['removed']	= array_merge($this->template['paragraf'][$key]['removed'], [$rm_para]);
					} 
					else
					{
						$this->template['paragraf'][$key]['removed']	= [$rm_para];
					}

				} 
			}
		}

		$template 				= Template::id($this->akta->template['id'])->kantor($this->activeOffice['kantor']['id'])->first();
		$template->paragraf 	= $this->template['paragraf'];
		$template->save();

		return true;
	}
}