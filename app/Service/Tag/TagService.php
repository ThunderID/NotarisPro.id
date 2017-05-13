<?php

namespace App\Service\Tag;

/**
 * Kelas Navbar
 *
 * Digunakan generate Navbar berdasarkan policy.
 *
 * @author     Chelsy M <chelsy@thunderlab.id>
 */
class TagService 
{
	/**
	 * Membuat object asset baru dari data array
	 *
	 * @return array $nav
	 */
	public static function all($number_of_client = 1)
	{
		//1. dokumen pihak
		$dok_pihak	= [
			'ktp'				=> ['nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'status_pernikahan', 'pekerjaan', 'kewarganegaraan'],
			'kk'				=> ['nomor', 'nama_kepala_keluarga', 'alamat', 'dikeluarkan_tanggal'],
			'akta_lahir'		=> ['nomor', 'nama_kepala_keluarga', 'alamat', 'dikeluarkan_tanggal'],
		];
	}
}