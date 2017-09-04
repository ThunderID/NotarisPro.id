<?php

namespace App\Service\Akta\Traits;

use App\Domain\Akta\Models\TipeDokumen;
use App\Domain\Invoice\Models\Arsip;

/**
 * Trait untuk otomatis enhance klien
 *
 * @author     C Mooy <chelsymooy1108@gmail.com>
 */
trait TextParseV2Trait 
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

		//initiate paragraph's value
		$new_paragraph 					= [];
		$new_paragraph['tipe_dokumen']	= [];
		$new_paragraph['mentionable']	= [];
		$new_paragraph['dokumen']		= [];

		preg_match_all($pattern_c, $text, $out, PREG_PATTERN_ORDER);

		foreach ($out[0] as $key => $value) 
		{
			$new_paragraph['paragraf'][]	= ['konten' => $value];
		}

		//2. pattern span
		$pattern_span		= '/<span class="medium-editor-mention-at.*?">@(.*?)@<\/span>/i';

		//2a. kalau ada mention dan span
		if (preg_match_all($pattern_span, $text, $span) && count($span[1])) 
		{
			//2a1. kalau mention bernilai array
			if (is_array($span[1]))
			{
				//setiap data mention mention
				foreach ($span[1] as $key => $value) 
				{
					//2a1i. parse mentionable
					$new_paragraph['mentionable'][$value]	= null;
					
					//2a1ii. parse dokumen & tipe dokumen
					$exploded 	= str_replace('@', '', explode('.', $value));

					if(in_array($exploded[0], ['pihak', 'objek', 'saksi']))
					{
						$new_paragraph['dokumen'][$exploded[0].'[dot]'.$exploded[1]][$exploded[2].'[dot]'.$exploded[3]][$exploded[4]] = strip_tags($span[1][$key]);

						//butuh extends
						if(!isset($new_paragraph['tipe_dokumen'][$exploded[0].'.'.$exploded[2]]))
						{
							$new_paragraph['tipe_dokumen'][$exploded[0].'.'.$exploded[2]]  = ['kategori' => $exploded[0], 'jenis_dokumen' => $exploded[2], 'kepemilikan' => $exploded[3], 'isi' => [$exploded[4]]];
						}
						elseif(!in_array($exploded[4], $new_paragraph['tipe_dokumen'][$exploded[0].'.'.$exploded[2]]['isi']))
						{
							$new_paragraph['tipe_dokumen'][$exploded[0].'.'.$exploded[2]]['isi'][]	= $exploded[4];
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
			$tipe_doc		= TipeDokumen::/*where('kategori', $value['kategori'])->*/where('jenis_dokumen', $value['jenis_dokumen'])->kantor($active_office['kantor']['id'])->first();

			if(!$tipe_doc)
			{
				$new_tipe_doc 					= new TipeDokumen;
				// $new_tipe_doc->kategori 		= $value['kategori'];
				$new_tipe_doc->jenis_dokumen 	= $value['jenis_dokumen'];
				$new_tipe_doc->kepemilikan 		= [$value['kepemilikan']];
				$new_tipe_doc->isi 				= $value['isi'];
				$new_tipe_doc->kantor 			= $active_office['kantor'];
				$new_tipe_doc->save();
			}
			else
			{
				$kepemilikan 			= $tipe_doc->kepemilikan;
				$kepemilikan			= array_unique(array_merge($kepemilikan, [$value['kepemilikan']]));
				$tipe_doc->kepemilikan 	= $kepemilikan;
				$tipe_doc->save();				
			}
		}
	}

	//PENDING EDITING
	private function updateDataDokumen($array_of_docs)
	{
		//need sort
		$saved_data 		= [];
		$saved_data['pihak']= [];
		$saved_data['root']	= [];
		$root 				= [];

		foreach ($array_of_docs as $key => $value) 
		{
			foreach ($value as $key2 => $value2) 
			{
				list($jenis, $kepemilikan)	= explode('[dot]', $key2);
	
				//simpan dokumen
				$arsip 						= Arsip::where('jenis', $jenis);
	
				foreach ($value2 as $key3 => $value3) 
				{
					$arsip 					= $arsip->where('isi.'.$key3, $value3);
				}
		
				$arsip 					 	= $arsip->first();

				if(!$arsip)
				{
					$arsip 					= new Arsip;
				}

				//find tipe docs
				$tipe_doc 					= TipeDokumen::kantor($this->active_office['kantor']['id'])->where('jenis_dokumen', $jenis)->first();

				foreach ((array)$tipe_doc['isi'] as $k_td => $v_td) 
				{
					if(!isset($value2[$v_td]))
					{
						$value2[$v_td]		= null;
					}
				}

				$arsip->jenis 				= $jenis;
				$arsip->isi 				= $value2;
				$arsip->kantor 				= $this->active_office['kantor'];
				$arsip->save();
		
				if(str_is('pribadi', $kepemilikan))
				{
					$saved_data['root'][$key]		= $arsip;
				}
				else
				{
					$saved_data['relasi'][$key][] 	= ['relasi' => $kepemilikan, 'arsip' => $arsip];
				}
	
				$flag 					= 1;
				if(str_is('ktp', $jenis) || str_is('akta_pendirian', $jenis))
				{
					if(isset($saved_data['pihak']))
					{
						foreach ((array)$saved_data['pihak'] as $k => $v) 
						{
							if($v['id']!=$arsip['id'] && $flag)
							{
								$saved_data['pihak'][]	= $arsip->toArray();
							}
							else
							{
								$flag 	= 0;
							}
						}
					}
					else
					{
						$saved_data['pihak'][0]			= $arsip->toArray();
					}
				}
			}
		}

		return $saved_data;
	}

	private function syncRelatedDoc($akta, $arsip)
	{
		//for every root
		foreach ($arsip['root'] as $key => $value) 
		{
			$relasi 	= $value->relasi;
			$count 		= count($relasi);
			$count2 	= 0;

			foreach ((array)$relasi['akta'] as $k => $v) 
			{
				if(str_is($akta['id'], $v['id']))
				{
					$count 		= $k;
				}
			}

			if(isset($arsip['relasi'][$key]))
			{
				foreach ($arsip['relasi'][$key] as $key2 => $value2) 
				{
					$relasi['akta'][$count]		= ['id' => $akta['id'], 'judul' => $akta['judul'], 'jenis' => $akta['jenis']];
					$relasi['dokumen'][$count2]	= ['id' => $value2['arsip']['id'], 'jenis' => $value2['arsip']['jenis'], 'relasi' => $value2['relasi'], 'akta_id' => $akta['id']];
					$count2++;

					// if(isset($relasi['dokumen'][$count]))
					// {
					// 	foreach ((array)$relasi['dokumen'][$count] as $k2 => $v2) 
					// 	{
					// 		if(str_is($v2['id'], $value2['arsip']['id']))
					// 		{
					// 			$count2		= $k2;
					// 		}
					// 	}
					// }

					// $relasi['dokumen'][$count][$count2]		= ['id' => $value2['arsip']['id'], 'jenis' => $value2['arsip']['jenis'], 'relasi' => $value2['relasi']];
				}
			}

			$value->relasi 	= $relasi;
			$value->save();
		}

		return $arsip;
	}
}
