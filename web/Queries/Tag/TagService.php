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
				'klien.nama' 			=> '@klien.nama',
				'klien.tempat_lahir' 	=> '@klien.tempat.lahir',
				'klien.tanggal_lahir' 	=> '@klien.tanggal.lahir',
				'klien.pekerjaan' 		=> '@klien.pekerjaan',
				'klien.alamat' 			=> '@klien.alamat',
				'klien.nomor_ktp' 		=> '@klien.nomor.ktp',

				'tanggal.hari.ini' 		=> '@tanggal.hari.ini',
				'tanggal.menghadap' 	=> '@tanggal.menghadap',
				'akta.nomor' 			=> '@akta.nomor',

				'notaris.nama' 			=> '@notaris.nama',
				'notaris.daerah_kerja' 	=> '@notaris.daerah_kerja',
				'notaris.nomor_sk' 		=> '@notaris.nomor_sk',
				'notaris.telepon' 		=> '@notaris.telepon',
				'notaris.fax' 			=> '@notaris.fax',
				'notaris.alamat' 		=> '@notaris.alamat',
			]; 
	}
}
