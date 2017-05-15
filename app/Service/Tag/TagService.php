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
		$dok_mention	= [
			'ktp'				=> ['nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'status_pernikahan', 'pekerjaan', 'kewarganegaraan'],
			'kk'				=> ['nomor', 'nama_kepala_keluarga', 'alamat', 'dikeluarkan_tanggal'],
			'paspor'			=> ['nomor', 'stbld', 'nama_semula', 'nama_sekarang', 'tempat_ganti_nama', 'tanggal_ganti_nama'],
			'akta_lahir'		=> ['nomor', 'stbld', 'nama', 'nama_ayah', 'nama_ibu', 'tempat_lahir', 'tanggal_lahir'],
			'akta_ganti_nama'	=> ['nomor', 'stbld', 'nama_semula', 'nama_sekarang', 'tempat_ganti_nama', 'tanggal_ganti_nama'],
			'akta_nikah'		=> ['nomor', 'stbld', 'tanggal_pencatatan', 'tanggal_pernikahan', 'nama_suami', 'nama_istri', 'agama', 'pemuka_agama', 'tempat_upacara_pernikahan', 'nama_notaris', 'nomor_sk_notaris'],
			'akta_cerai'		=> ['nomor', 'stbld', 'tempat_cerai', 'tanggal_cerai', 'nama_suami', 'nama_istri', 'nomor_akta_perkawinan', 'tanggal_perkawinan'],
			'akta_kematian'		=> ['nomor', 'stbld', 'tempat_kematian', 'tanggal_kematian', 'nama', 'tempat_lahir', 'tanggal_lahir', 'alamat_terakhir', 'nama_ibu'],
			'akta_waris'		=> ['nomor', 'stbld', 'nama_ahli_waris', 'tanggal_lahir'],
			'akta_pendirian'	=> ['nomor', 'stbld', 'nama_pihak'],
			'pengesahan_depkumham'		=> ['nomor', 'ditetapkan_di', 'ditetapkan_tanggal'],
			'akta_perubahan_terakhir'	=> ['nomor'],
			'shgb'				=> ['nomor', 'alamat', 'atas_nama'],
			'shm'				=> ['nomor', 'alamat', 'atas_nama'],
			'imb'				=> ['nomor', 'alamat', 'atas_nama'],
			'pbb'				=> ['nomor', 'alamat', 'nama_wajib_pajak'],
			'hpl'				=> ['nomor'],
		];

		return $dok_mention;
	}

	public static function fill_mention($dokumen_objek, $dokumen_pihak, $dokumen_saksi)
	{
		$doks 			= self::all();

		//generate docs
		$dok['objek']	= [];
		$dok['pihak_1']	= [];
		$dok['saksi']	= [];

		//@shgb.nomor
		foreach ($dokumen_objek as $key => $value) 
		{
			if(isset($doks[$value]))
			{
				foreach ($doks[$value] as $key2 => $value2) 
				{
					$dok['objek'][$key][$key2]	= '@'.$value.'.'.$value2;
				}
			}
		}

		//@ktp.nik
		foreach ($dokumen_saksi as $key => $value) 
		{
			if(isset($doks[$value]))
			{
				foreach ($doks[$value] as $key2 => $value2) 
				{
					$dok['saksi'][$key][$key2]	= '@'.$value.'.'.$value2;
				}
			}
		}

		//@pihak.1.ktp.nik
		foreach ($dokumen_pihak as $key => $value) 
		{
			foreach ($value as $key2 => $value2) 
			{
				if(isset($doks[$value2]))
				{
					foreach ($doks[$value2] as $key3 => $value3) 
					{
						$dok["pihak_$key"][$key2][$key3]	= '@pihak.'.$key.'.'.$value2.'.'.$value3;
					}
				}
				elseif(str_is('ktp_*', $value2))
				{
					foreach ($doks['ktp'] as $key3 => $value3) 
					{
						$dok["pihak_$key"][$key2][$key3]	= '@pihak.'.$key.'.'.$value2.'.'.$value3;
					}
				}
			}
		}

		return $dok;
	}
}
