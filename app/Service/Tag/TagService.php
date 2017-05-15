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
			'akta_lahir'		=> ['nomor', 'stbld', 'nama', 'nama_ayah', 'nama_ibu', 'tempat_lahir', 'tanggal_lahir'],
			'akta_ganti_nama'	=> ['nomor', 'stbld', 'nama_semula', 'nama_sekarang', 'tempat_ganti_nama', 'tanggal_ganti_nama'],
			'akta_kawin'		=> ['nomor', 'stbld', 'tanggal_pencatatan', 'tanggal_pernikahan', 'nama_suami', 'nama_istri', 'agama', 'pemuka_agama', 'tempat_upacara_pernikahan', 'nama_notaris', 'nomor_sk_notaris'],
			'akta_cerai'		=> ['nomor', 'stbld', 'tempat_cerai', 'tanggal_cerai', 'nama_suami', 'nama_istri', 'nomor_akta_perkawinan', 'tanggal_perkawinan'],
			'akta_kematian'		=> ['nomor', 'stbld', 'tempat_kematian', 'tanggal_kematian', 'nama', 'tempat_lahir', 'tanggal_lahir', 'alamat_terakhir', 'nama_ibu'],
			'akta_waris'		=> ['nomor', 'stbld', 'nama_ahli_waris', 'tanggal_lahir'],
			'akta_pendirian'	=> ['nomor', 'stbld', 'nama_pihak'],
		];

		$dok_objek	= [
			'shgb'				=> ['nomor', 'alamat', 'atas_nama'],
			'shm'				=> ['nomor', 'alamat', 'atas_nama'],
			'imb'				=> ['nomor', 'alamat', 'atas_nama'],
			'pbb'				=> ['nomor', 'alamat', 'nama_wajib_pajak'],
			'hpl'				=> ['nomor'],
		];

		return array_merge(['pihak' => $dok_pihak], ['objek' => $dok_objek]);
	}
}