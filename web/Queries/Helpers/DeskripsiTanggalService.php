<?php

namespace TQueries\Helpers;

use Carbon\Carbon;

/**
 * Kelas Navbar
 *
 * Digunakan generate Navbar berdasarkan policy.
 *
 * @author     Chelsy M <chelsy@thunderlab.id>
 */
class DeskripsiTanggalService 
{
	/**
	 * Membuat object asset baru dari data array
	 *
	 * @return array $nav
	 */
	public static function displayHariIni($tanggal = null)
	{
		if(is_null($tanggal))
		{
			$tanggal 	= date('d/m/Y');
		}
		
		//===================================
		//Buat daftar nama bulan
		$bulan 		= ["January","Pebruary","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember"];

		//Buat daftar nama hari dalam bahasa indonesia
		$hari  		= ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];

		$today		= Carbon::createFromFormat('d/m/Y', $tanggal);
		$month 		= intval($today->format('m')) - 1;

		$days  		= $today->format('w');

		$tg_angka 	= $today->format('d');

		$year  		= $today->format('Y');

		return $hari[$days].' Tanggal '.$tg_angka.' ('.self::terbilang($tg_angka).' ) '.$bulan[$month].' '.$year. ' ('.self::terbilang($year).' )';
		//===================================
	}

	/**
	 * Membuat object asset baru dari data array
	 *
	 * @return array $nav
	 */
	public static function convertBulan($tanggal = null)
	{
		if(is_null($tanggal))
		{
			$tanggal 	= date('d/m/Y');
		}
		
		//===================================
		//Buat daftar nama bulan
		$bulan 	= ["January","Pebruary","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember"];

		$date	= Carbon::createFromFormat('d/m/Y', $tanggal);
		$month 		= intval($today->format('m')) - 1;
		$tg_angka 	= $today->format('d');
		$year  		= $today->format('Y');

		return $tg_angka.' '.$bulan[$month].' '.$year;
		//===================================
	}

	private static function terbilang($x)
	{
		$abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		if ($x < 12)
		return " " . $abil[$x];
		elseif ($x < 20)
		return self::terbilang($x - 10) . " belas";
		elseif ($x < 100)
		return self::terbilang($x / 10) . " puluh" . self::terbilang($x % 10);
		elseif ($x < 200)
		return " seratus" . self::terbilang($x - 100);
		elseif ($x < 1000)
		return self::terbilang($x / 100) . " ratus" . self::terbilang($x % 100);
		elseif ($x < 2000)
		return " seribu" . self::terbilang($x - 1000);
		elseif ($x < 1000000)
		return self::terbilang($x / 1000) . " ribu" . self::terbilang($x % 1000);
		elseif ($x < 1000000000)
		return self::terbilang($x / 1000000) . " juta" . self::terbilang($x % 1000000);
	}
}