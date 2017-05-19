<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\TipeDokumen;

use TAuth;

/**
 * Kelas DaftarTag
 *
 * Digunakan untuk menampilkan semua data tag.
 *
 * @author     Chelsy M <chelsy@thunderlab.id>
 */
class DaftarTag 
{
	/**
	 * menampilkan data tag untuk kantor tersebut dari model tipe dokumen
	 *
	 * @return array $isi
	 */
	public static function all()
	{
		$tag 	= TipeDokumen::kantor(TAuth::activeOffice()['kantor']['id'])->first();

		return $tag['isi'];
	}

	/**
	 * digunakan untuk  mengubah data array tag menjadi mentionable syntax
	 * 'pihak_1' => ['ktp' => 'nama'] ===> @pihak.1.ktp.nama
	 *
	 * @param array $dokumen_objek
	 * @param array $dokumen_pihak
	 * @param array $dokumen_saksi
	 * @return array $mentionable
	 */
	public static function fill_mention(array $dokumen_objek, array $dokumen_pihak, array $dokumen_saksi)
	{
		$doks 			= self::all();

		//generate docs
		$dok['akta']['akta']		= ['@akta.nomor', '@akta.tanggal'];
		$dok['notaris']['notaris']	= ['@notaris.nama', '@notaris.daerah_kerja', '@notaris.nomor_sk', '@notaris.tanggal_pengangkatan', '@notaris.alamat', '@notaris.telepon'];

		$dok['objek']	= [];
		//@shgb.nomor
		foreach ($dokumen_objek as $key => $value) 
		{
			if(isset($doks[$value]))
			{
				foreach ($doks[$value] as $key2 => $value2) 
				{
					$dok['objek'][$value][$key2]	= '@objek.'.$value.'.'.$value2;
				}
			}
		}

		$dok['saksi_1']	= [];
		//@saksi.1.ktp.nik
		foreach ($dokumen_saksi as $key => $value) 
		{
			foreach ($value as $key2 => $value2) 
			{
				if(isset($doks[$key2]))
				{
					foreach ($doks[$key2] as $key3 => $value3) 
					{
						$dok["saksi_$key"][$key2][$key3]	= '@saksi.'.$key.'.'.$key2.'.'.$value3;
					}
				}
				elseif(str_is('ktp_*', $key2))
				{
					foreach ($doks['ktp'] as $key3 => $value3) 
					{
						$dok["saksi_$key"][$key2][$key3]	= '@saksi.'.$key.'.'.$key2.'.'.$value3;
					}
				}
			}
		}

		$dok['pihak_1']	= [];
		//@pihak.1.ktp.nik
		foreach ($dokumen_pihak as $key => $value) 
		{
			foreach ($value as $key2 => $value2) 
			{
				if(isset($doks[$key2]))
				{
					foreach ($doks[$key2] as $key3 => $value3) 
					{
						$dok["pihak_$key"][$key2][$key3]	= '@pihak.'.$key.'.'.$key2.'.'.$value3;
					}
				}
				elseif(str_is('ktp_*', $key2))
				{
					foreach ($doks['ktp'] as $key3 => $value3) 
					{
						$dok["pihak_$key"][$key2][$key3]	= '@pihak.'.$key.'.'.$key2.'.'.$value3;
					}
				}
			}
		}

		return $dok;
	}

	/**
	 * Menampilkan semua data objek
	 *
	 * @return array $objek
	 */
	public static function objek()
	{
		$tag 	= TipeDokumen::kantor(TAuth::activeOffice()['kantor']['id'])->where('jenis_dokumen.tags', 'objek')->first();

		return $tag['isi'];
	}

	/**
	 * Menampilkan semua data pihak
	 *
	 * @return array $pihak
	 */
	public static function pihak()
	{
		$tag 	= TipeDokumen::kantor(TAuth::activeOffice()['kantor']['id'])->where('jenis_dokumen.tags', 'pihak')->first();

		return $tag['isi'];
	}

	/**
	 * Menampilkan semua data saksi
	 *
	 * @return array $saksi
	 */
	public static function saksi()
	{
		$tag 	= TipeDokumen::kantor(TAuth::activeOffice()['kantor']['id'])->where('jenis_dokumen.tags', 'saksi')->first();

		return $tag['isi'];
	}
}
