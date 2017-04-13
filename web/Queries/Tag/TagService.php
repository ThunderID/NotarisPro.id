<?php
namespace TQueries\Tags;

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
	public static function all()
	{
		return [
				'klien_nama' 			=> '@klien.nama',
				'klien_tempat_lahir' 	=> '@klien.tempat.lahir',
				'klien_tanggal_lahir' 	=> '@klien.tanggal.lahir',
				'klien_pekerjaan' 		=> '@klien.pekerjaan',
				'klien_alamat' 			=> '@klien.alamat',
				'klien_nomor_ktp' 		=> '@klien.nomor.ktp',

				'tanggal_hari_ini' 		=> '@tanggal.hari.ini',
			]; 
	}
}
