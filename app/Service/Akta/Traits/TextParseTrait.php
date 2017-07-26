<?php

namespace App\Service\Akta\Traits;

use App\Domain\Akta\Models\TipeDokumen;
use App\Domain\Order\Models\Klien;
use App\Domain\Order\Models\Objek;

/**
 * Trait untuk otomatis enhance klien
 *
 * @author     C Mooy <chelsymooy1108@gmail.com>
 */
trait TextParseTrait 
{
	public function setParagrafParameter($paragraf)
	{
		$this->parse_paragraf = $paragraf;
	}

	private function getParagrafParameter()
	{
		return $this->parse_paragraf;
	}

	/**
	 * Extract/Parsing 1 text ke pecahan data
	 *
	 * @return 	array 	['paragraf' 			=> ['konten' => 'blablabla', 'konten' => 'blablabla2', 'konten' => 'blablabla3']],
	 * 					['mentionable' 			=> ['@notaris.nama@' => 'ABC', '@pihak.1.ktp.nama@' => 'NAMA'],
	 * 					['dokumen'				=> ['pihak' => [1 => ['ktp' => ['nama' => 'ABC'], 'kk' => ['nomor' => '1283']]]]],
	 * 					['tipe_dokumen'			=> ['pihak.ktp' => ['kategori' => 'pihak', 'jenis_dokumen' => 'ktp', 'isi' => ['nama', 'nik']]],
	 */
	private function parseText()
	{
		$text 				= $this->getParagrafParameter();

		//1. pattern content
		$pattern_c			= "/\/t.*?<h.*?>(.*?)<\/h.*?>|\/t.*?<p.*?>(.*?)<\/p>|\/t.*?(<(ol|ul).*?><li>(.*?)<\/li>)|\/t.*?(<li>(.*?)<\/li><\/(ol|ul)>)|<h.*?>(.*?)<\/h.*?>|<p.*?>(.*?)<\/p>|(<(ol|ul).*?><li>(.*?)<\/li>)|(<li>(.*?)<\/li><\/(ol|ul)>)/i";

		$new_paragraph 		= [];
		preg_match_all($pattern_c, $text, $out, PREG_PATTERN_ORDER);

		foreach ($out[0] as $key => $value) 
		{
			$new_paragraph['paragraf'][]	= ['konten' => $value];
		}

		//2. pattern span
		$pattern_span		= '/<span class="medium-editor-mention-at.*?data-mention="@.*?@">(.*?)<\/span>/i';
		$pattern_mention 	= '/@.*?@/i';

		//2a. kalau ada mention dan span
		if (preg_match_all($pattern_mention, $text, $mention) && preg_match_all($pattern_span, $text, $span) && count($mention[0]) == count($span[1])) 
		{
			//2a1. kalau mention bernilai array
			if (is_array($mention[0]) && is_array($span[1]))
			{
				//setiap data mention mention
				foreach ($mention[0] as $key => $value) 
				{
					//2a1i. parse mentionable
					$new_paragraph['mentionable'][str_replace('@', '[at]', str_replace('.', '[dot]', $value))]	= strip_tags($span[1][$key]);
					
					//2a1ii. parse dokumen & tipe dokumen
					$exploded 	= str_replace('@', '', explode('.', $value));

					if(in_array($exploded[0], ['pihak', 'objek', 'saksi']))
					{
						$new_paragraph['dokumen'][$exploded[0]][$exploded[1]][$exploded[2]][$exploded[3]] = strip_tags($span[1][$key]);

						//butuh extends
						if(!isset($new_paragraph['tipe_dokumen'][$exploded[0].'.'.$exploded[2]]))
						{
							$new_paragraph['tipe_dokumen'][$exploded[0].'.'.$exploded[2]]  = ['kategori' => $exploded[0], 'jenis_dokumen' => $exploded[2], 'isi' => [$exploded[3]]];
						}
						else
						{
							$new_paragraph['tipe_dokumen'][$exploded[0].'.'.$exploded[2]]['isi'][]	= $exploded[3];
						}
					}
				}
			}
		}

		return $new_paragraph;
	}

	private function simpanTipeDokumen($array_of_doc_type, $active_office)
	{
		foreach ($array_of_doc_type as $key => $value) 
		{
			$tipe_doc		= TipeDokumen::where('kategori', $value['kategori'])->where('jenis_dokumen', $value['jenis_dokumen'])->kantor($active_office['kantor']['id'])->first();

			if(!$tipe_doc)
			{
				$new_tipe_doc 					= new TipeDokumen;
				$new_tipe_doc->kategori 		= $value['kategori'];
				$new_tipe_doc->jenis_dokumen 	= $value['jenis_dokumen'];
				$new_tipe_doc->isi 				= $value['isi'];
				$new_tipe_doc->kantor 			= $active_office['kantor'];
				$new_tipe_doc->save();
			}
		}
	}

	private function updateDataDokumen($array_of_docs)
	{
		$saved_data 	= [];
		foreach ($array_of_docs as $key => $value) 
		{
			//$key 		= 'saksi'
			//$value 	= ['1' => ['ktp']]
			if(in_array($key, ['saksi', 'pihak']))
			{
				foreach ($value as $key2 => $value2) 
				{
					//$key2 		= '1'
					//$value 	= ['ktp' => ['nama']]
					if(isset($value2['ktp']))
					{
						$klien	= Klien::where('ktp.nik', $value2['ktp']['nik'])->first();
						if(!$klien)
						{
							$klien 	= new Klien;
						}
						$klien->tipe 			= 'perorangan';
						$klien->ktp 			= $value2['ktp'];
						$klien->kantor 			= $this->active_office['kantor'];
						unset($value2['ktp']);
						$klien->dokumen 		= $value2;
						$klien->save();

						$saved_data['pihak'][]	= $klien;
					}
					elseif(isset($value2['akta_pendirian']))
					{
						$klien	= Klien::where('akta_pendirian.nomor_akta', $value2['akta_pendirian']['nomor_akta'])->first();
						if(!$klien)
						{
							$klien 	= new Klien;
						}
						$klien->tipe 			= 'perusahaan';
						$klien->akta_pendirian 	= $value2['akta_pendirian'];
						$klien->kantor 			= $this->active_office['kantor'];
						unset($value2['akta_pendirian']);
						$klien->dokumen 		= $value2;
						$klien->save();
					
						$saved_data['pihak'][]	= $klien;
					}
				}
			}
			elseif(in_array($key, ['objek']))
			{
				foreach ($value as $key2 => $value2) 
				{
					//$key2 	= '1'
					//$value 	= ['bpkb' => ['nama']]
					if(isset($value3['bpkb']))
					{
						$objek	= Objek::where('bpkb.nomor_bpkb', $value3['bpkb']['nomor_bpkb'])->first();
						if(!$objek)
						{
							$objek 	= new Objek;
						}
						$klien->tipe 			= 'kendaraan';
						$objek->bpkb 			= $value3['bpkb'];
						$objek->kantor 			= $this->active_office['kantor'];
						unset($value3['bpkb']);
						$objek->dokumen 		= $value3;
						$objek->save();
					
						$saved_data['objek'][]	= $objek;
					}
					elseif(isset($value3['shm']))
					{
						$objek	= Objek::where('shm.nomor_akta', $value3['shm']['nomor_akta'])->first();
						if(!$objek)
						{
							$objek 	= new Objek;
						}
						$klien->tipe 			= 'tanah_bangunan';
						$objek->shm 			= $value3['shm'];
						$objek->kantor 			= $this->active_office['kantor'];
						unset($value3['shm']);
						$objek->dokumen 		= $value3;
						$objek->save();
					
						$saved_data['objek'][]	= $objek;
					}
					elseif(isset($value3['shgb']))
					{
						$objek	= Objek::where('shgb.nomor_akta', $value3['shgb']['nomor_akta'])->first();
						if(!$objek)
						{
							$objek 	= new Objek;
						}
						$klien->tipe 			= 'bangunan';
						$objek->shgb 			= $value3['shgb'];
						$objek->kantor 			= $this->active_office['kantor'];
						unset($value3['shgb']);
						$objek->dokumen 		= $value3;
						$objek->save();
					
						$saved_data['objek'][]	= $objek;
					}
				}
			}
		}

		return $saved_data;
	}
}