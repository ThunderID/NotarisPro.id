<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use TAuth;
use Carbon\Carbon;

use App\Http\Controllers\Controller;

use App\Domain\Akta\Models\Dokumen;

use App\Domain\Order\Models\Arsip;
use App\Domain\Order\Models\Jadwal;
use App\Domain\Admin\Models\Pengguna;
use App\Domain\Order\Models\HeaderTransaksi;

use App\Domain\Stat\Models\UserAttendance;

use MongoDB\BSON\UTCDateTime;

class dashboardController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
	}

	public function home()
	{
		$this->active_office 	= TAuth::activeOffice();

		//1. statistik jumlah akta berdasarkan
		$total_akta 	= Dokumen::kantor($this->active_office['kantor']['id'])->count();
		$jenis_akta 	= Dokumen::kantor($this->active_office['kantor']['id'])->distinct('jenis')->get()->toArray();

		$aktas 			= [];
		foreach ($jenis_akta as $k_ja => $v_ja) 
		{
			$total_dok	= Dokumen::kantor($this->active_office['kantor']['id'])->where('jenis', $v_ja[0])->count();
			$aktas[]	= ['jenis' => $v_ja[0], 'percentage' => ($total_dok/$total_akta)*100];
		}
		$stat_akta_bulan_ini	= collect($aktas)->sortByDesc('percentage');
		// $stat_main_col 			= (ceil((12/(count($aktas) + (count($aktas)/2))) * 2))%12;
		// $stat_add_col 			= floor((12 - $stat_main_col)/(count($stat_akta_bulan_ini)-1));
		$stat_main_col 			= ceil(12/max(1, count($aktas)));
		$stat_add_col 			= $stat_main_col;

		$awal_bulan_ini 		= Carbon::parse('first day of this month')->startOfDay();
		
		$awal_bulan_lalu 		= Carbon::parse('first day of last month')->startOfDay();
		$akhir_bulan_lalu 		= Carbon::parse('last day of last month')->endOfDay();

		$awal_bulan_lalu_lalu 	= $awal_bulan_lalu->submonths(1);
		$akhir_bulan_lalu_lalu 	= $akhir_bulan_lalu->submonths(1);

		//2. Riwayat akta 3 bulan terakhir
		$akta_movement 	= [];
		foreach ($jenis_akta as $k_ja => $v_ja) 
		{
			$akta_movement[$k_ja]['jenis']						=  $v_ja[0];
			$akta_movement[$k_ja]['bulan_ini']['total']			= Dokumen::kantor($this->active_office['kantor']['id'])->where('jenis', $v_ja[0])->where('created_at', '>=', new UTCDateTime($awal_bulan_ini))->count();

			$akta_movement[$k_ja]['bulan_lalu']['total']		= Dokumen::kantor($this->active_office['kantor']['id'])->where('jenis', $v_ja[0])->where('created_at', '>=', new UTCDateTime($awal_bulan_lalu))->where('created_at', '<=', new UTCDateTime($akhir_bulan_lalu))->count();
			
			$akta_movement[$k_ja]['bulan_lalu_lalu']['total']	= Dokumen::kantor($this->active_office['kantor']['id'])->where('jenis', $v_ja[0])->where('created_at', '>=', new UTCDateTime($awal_bulan_lalu_lalu))->where('created_at', '<=', new UTCDateTime($akhir_bulan_lalu_lalu))->count();

			$akta_movement[$k_ja]['bulan_ini']['compare_perc']	= (($akta_movement[$k_ja]['bulan_ini']['total'] - $akta_movement[$k_ja]['bulan_lalu']['total']) / max(1, $akta_movement[$k_ja]['bulan_lalu']['total'])) * 100;
			$akta_movement[$k_ja]['bulan_lalu']['compare_perc']	= (($akta_movement[$k_ja]['bulan_lalu']['total'] - $akta_movement[$k_ja]['bulan_lalu_lalu']['total']) / max(1, $akta_movement[$k_ja]['bulan_lalu_lalu']['total'])) * 100;
		}

		$stat_akta['dalam_proses']		= Dokumen::kantor($this->active_office['kantor']['id'])->status('dalam_proses')->count();
		$stat_akta['total_karyawan']	= Pengguna::kantor($this->active_office['kantor']['id'])->count();
		$stat_akta['jam_kerja_mingguan']= $stat_akta['total_karyawan'] * 40;

		$tagihan 			= HeaderTransaksi::kantor($this->active_office['kantor']['id'])->where('tipe', 'bukti_kas_masuk')->where('status', 'pending')->get();


		$notifikasi			= [];
		$awal_minggu_ini 	= Carbon::parse('first day of this week')->startOfDay();
		$akhir_minggu_ini 	= Carbon::parse('last day of this week')->endOfDay();

		//a. jadwal monitoring
		$jadwal_monitoring	= collect(Jadwal::kantor($this->active_office['kantor']['id'])->where('end', '>=', $awal_minggu_ini->format('Y-m-d H:i:s'))->where('end', '<=', $akhir_minggu_ini->format('Y-m-d H:i:s'))->get()->toArray());
		$notifikasi 			= $jadwal_monitoring->map(function ($bpn) {
		    return ['tanggal' => $bpn['end'], 'judul' => 'Cek '.$bpn['referensi']['judul_akta'].' nomor '.$bpn['referensi']['nomor_akta'], 'deskripsi' => 'di '.$bpn['tempat']];
		});

		//b. dokumen ditambahkan
		$doklist 			= [];
		$this->logged_user 	= TAuth::loggedUser();
		$last_logged 		= UserAttendance::where('pengguna_id', $this->logged_user['id'])->where('kantor_id', $this->active_office['kantor']['id'])->orderby('created_at', 'desc')->skip(1)->first();
		if(!$last_logged)
		{
			$dokumen 		= Arsip::kantor($this->active_office['kantor']['id'])->orderby('created_at', 'asc')->get();
			if(count($dokumen))
			{
				$doklist 	= ['tanggal' => $dokumen[0]['created_at']->format('Y-m-d H:i:s'), 'judul' => count($dokumen).' dokumen telah ditambahkan', 'deskripsi' => ''];
			}
		}
		else
		{
			$j_k 			= Carbon::createFromFormat('Y-m-d H:i:s', $last_logged->jam_keluar);
			$dokumen 		= Arsip::kantor($this->active_office['kantor']['id'])->where('created_at', '>', new UTCDateTime($j_k))->orderby('created_at', 'asc')->get();

			if(count($dokumen))
			{
				$doklist 	= ['tanggal' => $dokumen[0]['created_at']->format('Y-m-d H:i:s'), 'judul' => count($dokumen).' dokumen telah ditambahkan', 'deskripsi' => ''];
			}
		}
		if((array)$doklist)
		{
			$notifikasi->push($doklist);
		}

		//c. last login
		$loglist 			= [];
		if(!$last_logged)
		{
			$loglist 		= UserAttendance::selectraw('jam_masuk as tanggal, aktivitas as judul, deskripsi as deskripsi')->where('pengguna_id', '<>', $this->logged_user['id'])->where('kantor_id', $this->active_office['kantor']['id'])->orderby('created_at', 'desc')->get()->toArray();
		}
		else
		{
			$loglist 		= UserAttendance::selectraw('jam_masuk as tanggal, aktivitas as judul, deskripsi as deskripsi')->where('pengguna_id', '<>', $this->logged_user['id'])->where('kantor_id', $this->active_office['kantor']['id'])->orderby('created_at', 'desc')->where('jam_masuk', '>=', $last_logged->jam_keluar)->get()->toArray();
		}
		foreach ((array)$loglist as $key => $value) 
		{
			$notifikasi->push($value);
		}

		//d. user baru
		if(!$last_logged)
		{
			$user_baru 	= Pengguna::kantor($this->active_office['kantor']['id'])->get();
		}
		else
		{
			$user_baru 	= Pengguna::kantor($this->active_office['kantor']['id'])->where('visas.started_at', '>', $last_logged->jam_keluar)->get();
		}

		$userlist		= $user_baru->map(function ($user) {
		    return ['tanggal' => $user['visas'][0]['started_at'], 'judul' => $user['nama'].' ditambahkan sebagai '.$user['visas'][0]['role'], 'deskripsi' => ''];
		});

		foreach ($userlist as $key => $value) 
		{
			$notifikasi->push($value);
		}

		$notifikasi 	= $notifikasi->sortby('tanggal');

		$pesan			= null;

		if($this->active_office['type']=='trial')
		{
			$pesan		= 'Free trial only '.Carbon::now()->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', $this->active_office['expired_at'])).' day(s) ';
		}

		return view('notaris.pages.dashboard.home', compact('pesan', 'stat_akta_bulan_ini', 'stat_main_col', 'stat_add_col', 'akta_movement', 'stat_akta', 'tagihan', 'notifikasi'));
	}
}
