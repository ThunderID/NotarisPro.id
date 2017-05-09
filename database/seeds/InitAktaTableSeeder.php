<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use TQueries\Helpers\DeskripsiTanggalService;

class InitAktaTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('akta_dokumen')->truncate();

		$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$login 			= TAuth::login($credentials);

		$active_office 	= TAuth::activeOffice();

		$notaris_aktif	=  \TKantor\Notaris\Models\Notaris::find($active_office['kantor']['id']);

		$faker			= \Faker\Factory::create();

		$hari 			= ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
		$j_akta 		= ['Akta Jual Beli', 'Akta Pemberian Hak Tanggungan', 'Akta Fidusia', 'Akta Perjanjian Sewa'];

		//init draft
		foreach (range(0, 19) as $key) 
		{
			$klien_1 			= \TKlien\Klien\Models\Klien::skip(rand(0,18))->first()->toArray();
			$klien_2 			= \TKlien\Klien\Models\Klien::notid($klien_1['id'])->skip(rand(0,18))->first()->toArray();

			if(is_array($klien_1['alamat']))
			{
				$alamt_1 		= $klien_1['alamat']['alamat'];
			}
			else
			{
				$alamt_1 		= $klien_1['alamat'];
			}

			if(is_array($klien_2['alamat']))
			{
				$alamt_2 		= $klien_2['alamat']['alamat'];
			}
			else
			{
				$alamt_2 		= $klien_2['alamat'];
			}

			$nomor_akta 		= $faker->ean13;
			$tlg_hadap 			= DeskripsiTanggalService::displayHariIni(rand(1,28).'/'.rand(1,12).'/2016');
	
			$isi				= [
				'judul'			=> $j_akta[0],
				'paragraf'		=> [
					['konten' 	=> '<h4 class="text-center"><br></h4>'],
					['konten' 	=> '<h4 class="text-center"><b style="color: rgb(41, 43, 44); font-size: 1rem;">PEJABAT PEMBUAT AKTA TANAH</b></h4>'],
					['konten' 	=> '<h4 class="text-center"><b>(PPAT)</b></h4>'],
					['konten' 	=> '<h4 class="text-center"><span class="medium-editor-mention-at medium-editor-mention-at" data-mention="@notaris.nama">'.$notaris_aktif['notaris']['nama'].'</span>&nbsp;</h4>'],
					['konten' 	=> '<h4 class="text-center">DAERAH KERJA <span class="medium-editor-mention-at" data-mention="@notaris.daerah_kerja">'.$notaris_aktif['notaris']['daerah_kerja'].'</span>&nbsp;</h4>'],
					['konten' 	=> '<h4 class="text-center">SK. Kepala Badan Pertanahan Nasional Nomor : <span class="medium-editor-mention-at" data-mention="@notaris.nomor_sk">'.$notaris_aktif['notaris']['nomor_sk'].'</span>&nbsp;</h4>'],
					['konten' 	=> '<h4 class="text-center">Tanggal <span class="medium-editor-mention-at" data-mention="@notaris.tanggal_pengangkatan">'.$notaris_aktif['notaris']['tanggal_pengangkatan'].'</span>&nbsp;</h4>'],
					['konten' 	=> '<h4 class="text-center"><span class="medium-editor-mention-at" data-mention="@notaris.alamat">'.$notaris_aktif['notaris']['alamat'].'</span>&nbsp;<span class="medium-editor-mention-at" data-mention="@notaris.telepon">'.$notaris_aktif['notaris']['telepon'].'</span>&nbsp;</h4>'],
					['konten' 	=> '<p class="text-center">------------------------------------------------------------------</p>'],
					['konten' 	=> '<h5 class="text-center"><b>AKTA JUAL BELI</b></h5>'],
					['konten' 	=> '<h5 class="text-center">Nomor <span class="medium-editor-mention-at" data-mention="@akta.nomor">'.$nomor_akta.'</span>&nbsp;</h5>'],
					['konten' 	=> '<h5 class="text-center"><i>Lembar Pertama / Kedua</i></h5>'],
					['konten' 	=> '<p style="text-align: left;">Pada hari ini <span class="medium-editor-mention-at" data-mention="@tanggal.menghadap">'.$tlg_hadap.'</b>&nbsp;hadir dihadapan saya <span class="medium-editor-mention-at" data-mention="@notaris.nama">'.$notaris_aktif['notaris']['nama'].'</span>&nbsp;yang berdasarkan surat keputusan menteri Agraria / Kepala Badan Pertanahan Nasional tanggal <span class="medium-editor-mention-at" data-mention="@notaris.tanggal_pengangkatan">'.$notaris_aktif['notaris']['tanggal_pengangkatan'].'</span>&nbsp;nomor <span class="medium-editor-mention-at" data-mention="@notaris.nomor_sk">'.$notaris_aktif['notaris']['nomor_sk'].'</span>&nbsp;diangkat / ditunjuk sebagai Pejabat Pembuat Akta Tanah&nbsp;, yang selanjutnya disebut PPAT, yang dimaksud dalam pasal 7 Peraturan Pemerintah Nomor 24 Tahun 1997 tentang pendaftaran tanah, dengan daerah kerja <span class="medium-editor-mention-at" data-mention="@notaris.daerah_kerja">'.$notaris_aktif['notaris']['daerah_kerja'].'</span>&nbsp;dengan dihadiri oleh saksi - saksi yang saya kenal dan akan disebut pada bagian akhir akta ini :</p>'],
					['konten' 	=> '<ol><li><span class="medium-editor-mention-at" data-mention="@klien.1.nama">'.$klien_1['nama'].'</span>&nbsp;lahir di <span class="medium-editor-mention-at" data-mention="@klien.1.tempat_lahir">'.$klien_1['tempat_lahir'].'</span>&nbsp;pada tanggal <span class="medium-editor-mention-at" data-mention="@klien.1.tanggal_lahir">'.$klien_1['tanggal_lahir'].'</span>&nbsp;Warga Negara Indonesia, <span class="medium-editor-mention-at" data-mention="@klien.1.pekerjaan">'.$klien_1['pekerjaan'].'</span>&nbsp;bertempat tinggal di <span class="medium-editor-mention-at" data-mention="@klien.1.alamat">'.$alamt_1.'</span>&nbsp;pemegang kartu tanda penduduk nomor <span class="medium-editor-mention-at" data-mention="@klien.1.nomor_ktp">'.$klien_1['nomor_ktp'].'</span>&nbsp;<br><span class="medium-editor-mention-at medium-editor-mention-at">@klien.1.deskripsi</span>&nbsp;<br>Selaku penjual, yang selanjutnya disebut sebagai<br>PIHAK PERTAMA</li>'],
					['konten' 	=> '<li><span class="medium-editor-mention-at" data-mention="@klien.2.nama">'.$klien_2['nama'].'</span>&nbsp;lahir di <span class="medium-editor-mention-at" data-mention="@klien.2.tempat_lahir">'.$klien_2['tempat_lahir'].',</span>&nbsp;pada tanggal <span class="medium-editor-mention-at" data-mention="@klien.2.tanggal_lahir">'.$klien_2['tanggal_lahir'].'</span>&nbsp;Warga Negara Indonesia, <span class="medium-editor-mention-at" data-mention="@klien.2.pekerjaan">'.$klien_2['pekerjaan'].'</span>&nbsp;bertempat tinggal di <span class="medium-editor-mention-at" data-mention="@klien.2.alamat">'.$alamt_2.'</span>&nbsp;pemegang kartu tanda penduduk nomor <span class="medium-editor-mention-at medium-editor-mention-at" data-mention="@klien.2.nomor_ktp">'.$klien_2['nomor_ktp'].'<br></span><span class="medium-editor-mention-at medium-editor-mention-at">@klien.2.deskripsi</span><br>Selaku pembeli, yang selanjutnya disebut sebagai<br>PIHAK KEDUA<br></li></ol>'],
				],
				'mentionable'	=> [
					'@notaris.nama',
					'@notaris.daerah_kerja',
					'@notaris.nomor_sk',
					'@notaris.tanggal_pengangkatan',
					'@notaris.alamat',
					'@notaris.telepon',
					'@akta.nomor',
					'@tanggal.menghadap',
					'@klien.1.nama',
					'@klien.1.tempat_lahir',
					'@klien.1.tanggal_lahir',
					'@klien.1.pekerjaan',
					'@klien.1.alamat',
					'@klien.1.nomor_ktp',
					'@klien.1.deskripsi',
					'@klien.2.nama',
					'@klien.2.tempat_lahir',
					'@klien.2.tanggal_lahir',
					'@klien.2.pekerjaan',
					'@klien.2.alamat',
					'@klien.2.nomor_ktp',
					'@klien.2.deskripsi',
				],
				'fill_mention'	=> [
					'@notaris.nama' 					=> $notaris_aktif['notaris']['nama'],
					'@notaris.daerah_kerja'				=> $notaris_aktif['notaris']['daerah_kerja'],
					'@notaris.nomor_sk'					=> $notaris_aktif['notaris']['nomor_sk'],
					'@notaris.tanggal_pengangkatan'		=> $notaris_aktif['notaris']['tanggal_pengangkatan'],
					'@notaris.alamat' 					=> $notaris_aktif['notaris']['alamat'],
					'@notaris.telepon' 					=> $notaris_aktif['notaris']['telepon'],
					'@akta.nomor' 						=> $nomor_akta,
					'@tanggal.menghadap' 				=> $tlg_hadap,
					'@klien.1.nama' 					=> $klien_1['nama'],
					'@klien.1.tempat_lahir' 			=> $klien_1['tempat_lahir'],
					'@klien.1.tanggal_lahir' 			=> $klien_1['tanggal_lahir'],
					'@klien.1.pekerjaan' 				=> $klien_1['pekerjaan'],
					'@klien.1.alamat' 					=> $alamt_1,
					'@klien.1.nomor_ktp' 				=> $klien_1['nomor_ktp'],
					'@klien.2.nama' 					=> $klien_2['nama'],
					'@klien.2.tempat_lahir' 			=> $klien_2['tempat_lahir'],
					'@klien.2.tanggal_lahir' 			=> $klien_2['tanggal_lahir'],
					'@klien.2.pekerjaan' 				=> $klien_2['pekerjaan'],
					'@klien.2.alamat' 					=> $alamt_2,
					'@klien.2.nomor_ktp' 				=> $klien_2['nomor_ktp'],
				],
				'pemilik'		=> ['klien' => ['id' => $klien_1['id'], 'nama' => $klien_1['nama']]]
			];

			$akta 			= new \TCommands\Akta\DraftingAkta($isi);
			$akta->handle();
		}

		//init pengajuan
		$dokumen 		= TAkta\DokumenKunci\Models\Dokumen::skip(0)->take(8)->get();

		foreach ($dokumen as $key => $value) 
		{
			$akta 			= new \TCommands\Akta\AjukanAkta($value->id);
			$akta->handle();
		}

		//init renvoi
		$dokumen 			= TAkta\DokumenKunci\Models\Dokumen::skip(0)->take(3)->get();

		foreach ($dokumen as $key => $value) 
		{
			$paragraf_ids 	= [$value->paragraf[rand(8,9)]['lock']];

			$akta 			= new \TCommands\Akta\TandaiRenvoi($value->id, $paragraf_ids);
			$akta->handle();
		}
		//init update
		$dokumen 		= TAkta\DokumenKunci\Models\Dokumen::skip(0)->take(3)->get();

		foreach ($dokumen as $key => $value) 
		{
			$edited 	= $value->toArray();
			
			//1. set as renvoi
			$akta 		= new \TCommands\Akta\RenvoiAkta($edited['id']);
			$edited 	= $akta->handle();

			if(is_null($edited['paragraf'][8]['lock']))
			{
				$edited['paragraf'][8]['konten'] 	= '<p style="text-align: center; color:red"><b>REVISI</b></p>';
			}

			if(is_null($edited['paragraf'][9]['lock']))
			{
				$edited['paragraf'][9]['konten'] 	= '<p style="text-align: center; color:red"><b>REVISI</b></p>';
			}

			$akta 		= new \TCommands\Akta\SimpanAkta($edited);
			$akta->handle();
		}
	}
}
