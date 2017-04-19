<?php
namespace TQueries\Tags;

/**
 * Kelas Navbar
 *
 * Digunakan generate Navbar berdasarkan policy.
 *
 * @author     Chelsy M <chelsy@thunderlab.id>
 */
class TranslateMentionService 
{
	/**
	 *
	 * @return array $konten
	 */
	public static function notaris($konten)
	{
		$kantor_id 		= \TAuth::activeOffice()['kantor']['id'];
		$kantor 		= \TKantor\Notaris\Models\Notaris::id($kantor_id)->first();
		
		$konten	= str_replace('@notaris.nama', $kantor['notaris']['nama'], $konten);
		$konten	= str_replace('@notaris.tanggal_pengangkatan', $kantor['notaris']['tanggal_pengangkatan'], $konten);
		$konten	= str_replace('@notaris.daerah_kerja', $kantor['notaris']['daerah_kerja'], $konten);
		$konten	= str_replace('@notaris.nomor_sk', $kantor['notaris']['nomor_sk'], $konten);
		$konten	= str_replace('@notaris.telepon', $kantor['notaris']['telepon'], $konten);
		$konten	= str_replace('@notaris.alamat', $kantor['notaris']['alamat'], $konten);

		return $konten; 
	}

	/**
	 *
	 * @return array $konten
	 */
	public static function klien($konten, array $klien_ids)
	{
		$i 			= count($klien_ids);
		
		foreach (range(1, $i) as $key) 
		{
			$klien 		= \TKlien\Klien\Models\Klien::id($klien_ids[$key-1])->first();

			$konten		= str_replace("@klien.$key.nama", $klien['nama'], $konten);
			$konten		= str_replace("@klien.$key.tempat_lahir", $klien['tempat_lahir'], $konten);
			$konten		= str_replace("@klien.$key.tanggal_lahir", $klien['tanggal_lahir'], $konten);
			$konten		= str_replace("@klien.$key.pekerjaan", $klien['pekerjaan'], $konten);
			$konten		= str_replace("@klien.$key.alamat", implode(' ', $klien['alamat']), $konten);
			$konten		= str_replace("@klien.$key.nomor_ktp", $klien['nomor_ktp'], $konten);
		}

		return $konten; 
	}

	/**
	 *
	 * @return array $konten
	 */
	public static function tanggal($konten, $tanggal = null)
	{
		if(is_null($tanggal))
		{
			$tanggal 	= date('d/m/Y');
		}
		$tanggal 	= \TQueries\Helpers\DeskripsiTanggalService::displayHariIni($tanggal);
		$konten		= str_replace('@tanggal.menghadap', $tanggal, $konten);

		return $konten; 
	}
}
