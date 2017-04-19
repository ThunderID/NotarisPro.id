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
	public static function all($number_of_client = 1)
	{
		$array 			= [];
		foreach (range(1, $number_of_client) as $key)
		{
			$array["klien.$key.nama"]			= "@klien.$key.nama";
			$array["klien.$key.tempat_lahir"]	= "@klien.$key.tempat_lahir";
			$array["klien.$key.tanggal_lahir"]	= "@klien.$key.tanggal_lahir";
			$array["klien.$key.pekerjaan"]		= "@klien.$key.pekerjaan";
			$array["klien.$key.alamat"]			= "@klien.$key.alamat";
			$array["klien.$key.nomor_ktp"]		= "@klien.$key.nomor_ktp";
		}

		$array['notaris.nama']					= '@notaris.nama';
		$array['notaris.daerah_kerja']			= '@notaris.daerah_kerja';
		$array['notaris.nomor_sk']				= '@notaris.nomor_sk';
		$array['notaris.tanggal_pengangkatan']	= '@notaris.tanggal_pengangkatan';
		$array['notaris.telepon']				= '@notaris.telepon';
		$array['notaris.fax']					= '@notaris.fax';
		$array['notaris.alamat']				= '@notaris.alamat';
		
		$array['tanggal.menghadap']				= '@tanggal.menghadap';
		$array['akta.nomor']					= '@akta.nomor';
		
		return $array; 
	}
}
