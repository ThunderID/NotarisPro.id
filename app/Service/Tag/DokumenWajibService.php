<?php

namespace App\Service\Tag;

/**
 * Kelas Navbar
 *
 * Digunakan generate Navbar berdasarkan policy.
 *
 * @author     Chelsy M <chelsy@thunderlab.id>
 */
class DokumenWajibService 
{
	/**
	 * Membuat object asset baru dari data array
	 *
	 * @return array $nav
	 */
	public static function objek()
	{
		return [
			'shgb',
			'shm',
			'imb',
			'pbb',
			'hpl',
			'lain_lain'
		];
	}

	public static function pihak()
	{
		return [
			'ktp',
			'kk',
			'akta_lahir',
			'akta_ganti_nama',
			'wni',
			'akta_nikah',
			'akta_cerai',
			'akta_kematian',
			'akta_waris',
			'akta_pendirian',
			'pengesahan_depkumham',
			'akta_perubahan_terakhir',
			'ktp_direksi',
			'ktp_komisaris',
			'persetujuan_komisaris',
			'penerima_kuasa'
		];
	}

	public static function saksi()
	{
		return [
			'ktp'
		];
	}
}