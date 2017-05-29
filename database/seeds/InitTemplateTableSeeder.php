<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class InitTemplateTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('akta_template')->truncate();

		$credentials[0]	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$credentials[1]	= ['email' => 'drafter@notaris.id', 'password' => 'admin'];

		$faker			= \Faker\Factory::create();

		$hari 			= ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
		$j_akta 		= ['Akta Jual Beli Perorangan 2 Pihak', 'Akta Pemberian Hak Tanggungan 3 Pihak Perorangan', 'Akta Fidusia 2 Pihak Perorangan', 'Akta Perjanjian Sewa Persero dengan Persero'];
		$d_akta 		= ['Akta Jual Beli Mengatur Perorangan 2 Pihak', 'Akta Mengatur Pemberian Hak Tanggungan 3 Pihak Perorangan', 'Akta Mengatur Fidusia 2 Pihak Perorangan', 'Akta Mengatur Perjanjian Sewa Persero dengan Persero'];

		$login 			= TAuth::login($credentials[0]);

		//drafting
		foreach (range(0, 19) as $key) 
		{
			$isi				= [
				'judul'			=> $j_akta[0].$key,
				'deskripsi'		=> $d_akta[0],
				'paragraf'		=> [
					['konten' 	=> '<h4 class="text-center"><b style="color: rgb(41, 43, 44); font-size: 1rem;">PEJABAT PEMBUAT AKTA TANAH</b></h4>'],
					['konten' 	=> '<h4 class="text-center"><b>(PPAT)</b></h4>'],
					['konten' 	=> '<h4 class="text-center"><span class="medium-editor-mention-at">@notaris.nama</span>&nbsp;</h4>'],
					['konten' 	=> '<h4 class="text-center">DAERAH KERJA <span class="medium-editor-mention-at">@notaris.daerah_kerja</span>&nbsp;</h4>'],
					['konten' 	=> '<h4 class="text-center">SK. Kepala Badan Pertanahan Nasional Nomor : <span class="medium-editor-mention-at">@notaris.nomor_sk</span>&nbsp;</h4>'],
					['konten' 	=> '<h4 class="text-center">Tanggal <span class="medium-editor-mention-at">@notaris.tanggal_pengangkatan</span>&nbsp;</h4>'],
					['konten' 	=> '<h4 class="text-center"><span class="medium-editor-mention-at">@notaris.alamat</span>&nbsp;<span class="medium-editor-mention-at">@notaris.telepon</span>&nbsp;</h4>'],
					['konten' 	=> '<p class="text-center">------------------------------------------------------------------</p>'],
					['konten' 	=> '<h5 style="text-align: center;"><b>AKTA JUAL BELI</b></h5>'],
					['konten' 	=> '<h5 style="text-align: center;">Nomor <span class="medium-editor-mention-at">@akta.nomor</span>&nbsp;</h5>'],
					['konten' 	=> '<h5 style="text-align: center;"><i>Lembar Pertama / Kedua</i></h5>'],
					['konten' 	=> '<p style="text-align: left;">Pada hari ini <span class="medium-editor-mention-at">@akta.tanggal</span>&nbsp;hadir dihadapan saya <span class="medium-editor-mention-at">@notaris.nama</span>&nbsp;yang berdasarkan surat keputusan menteri Agraria / Kepala Badan Pertanahan Nasional tanggal <span class="medium-editor-mention-at">@notaris.tanggal_pengangkatan</span>&nbsp;nomor <span class="medium-editor-mention-at">@notaris.nomor_sk</span>&nbsp;diangkat / ditunjuk sebagai Pejabat Pembuat Akta Tanah&nbsp;, yang selanjutnya disebut PPAT, yang dimaksud dalam pasal 7 Peraturan Pemerintah Nomor 24 Tahun 1997 tentang pendaftaran tanah, dengan daerah kerja <span class="medium-editor-mention-at">@notaris.daerah_kerja</span>&nbsp;dengan dihadiri oleh saksi - saksi yang saya kenal dan akan disebut pada bagian akhir akta ini :</p>'],
					['konten' 	=> '<ol><li><span class="medium-editor-mention-at">@pihak.1.ktp.nama</span>&nbsp;lahir di <span class="medium-editor-mention-at">@pihak.1.ktp.tempat_lahir</span>&nbsp;pada tanggal <span class="medium-editor-mention-at">@pihak.1.ktp.tanggal_lahir</span>&nbsp;Warga Negara Indonesia, <span class="medium-editor-mention-at">@pihak.1.ktp.pekerjaan</span>&nbsp;bertempat tinggal di <span class="medium-editor-mention-at">@pihak.1.ktp.alamat</span>&nbsp;pemegang kartu tanda penduduk nomor <span class="medium-editor-mention-at">@pihak.1.ktp.nomor_ktp</span>&nbsp;<br><span class="medium-editor-mention-at medium-editor-mention-at">@pihak.1.ktp.deskripsi</span>&nbsp;<br>Selaku penjual, yang selanjutnya disebut sebagai<br>PIHAK PERTAMA</li>'],
					['konten' 	=> '<li><span class="medium-editor-mention-at">@pihak.2.ktp.nama</span>&nbsp;lahir di <span class="medium-editor-mention-at">@pihak.2.ktp.tempat_lahir,</span>&nbsp;pada tanggal <span class="medium-editor-mention-at">@pihak.2.ktp.tanggal_lahir</span>&nbsp;Warga Negara Indonesia, <span class="medium-editor-mention-at">@pihak.2.ktp.pekerjaan</span>&nbsp;bertempat tinggal di <span class="medium-editor-mention-at">@pihak.2.ktp.alamat</span>&nbsp;pemegang kartu tanda penduduk nomor <span class="medium-editor-mention-at medium-editor-mention-at">@pihak.2.ktp.nomor_ktp</span><span class="medium-editor-mention-at medium-editor-mention-at">@pihak.2.ktp.deskripsi</span><br>Selaku pembeli, yang selanjutnya disebut sebagai<br>PIHAK KEDUA<br></li></ol>'],
				],
				'mentionable'	=> [
					'@notaris.nama',
					'@notaris.daerah_kerja',
					'@notaris.nomor_sk',
					'@notaris.tanggal_pengangkatan',
					'@notaris.alamat',
					'@notaris.telepon',
					'@akta.nomor',
					'@akta.tanggal',
					'@pihak.1.ktp.nama',
					'@pihak.1.ktp.tempat_lahir',
					'@pihak.1.ktp.tanggal_lahir',
					'@pihak.1.ktp.pekerjaan',
					'@pihak.1.ktp.alamat',
					'@pihak.1.ktp.nomor_ktp',
					'@pihak.1.ktp.deskripsi',
					'@pihak.2.ktp.nama',
					'@pihak.2.ktp.tempat_lahir',
					'@pihak.2.ktp.tanggal_lahir',
					'@pihak.2.ktp.pekerjaan',
					'@pihak.2.ktp.alamat',
					'@pihak.2.ktp.nomor_ktp',
					'@pihak.2.ktp.deskripsi',
				],
				'dokumen_objek'	=> [],
				'dokumen_pihak'	=> [1 => ['ktp' => ['nama', 'tempat_lahir', 'tanggal_lahir', 'pekerjaan', 'alamat','nomor_ktp', 'deskripsi']], 2 => ['ktp' => ['nama', 'tempat_lahir', 'tanggal_lahir', 'pekerjaan', 'alamat','nomor_ktp', 'deskripsi']]],
				'dokumen_saksi'	=> [1 => ['ktp' => ['nama', 'tempat_lahir', 'tanggal_lahir', 'pekerjaan', 'alamat','nomor_ktp', 'deskripsi']], 2 => ['ktp' => ['nama', 'tempat_lahir', 'tanggal_lahir', 'pekerjaan', 'alamat','nomor_ktp', 'deskripsi']]]
			];

			$akta 			= new  App\Service\Akta\BuatTemplateBaru($isi['judul'], $isi['deskripsi'], $isi['paragraf'], $isi['mentionable'], 2, 2, $isi['dokumen_objek'], $isi['dokumen_pihak'], $isi['dokumen_saksi']);
			$akta 			= $akta->save();
		}

		//init publish
		$dokumen 			= App\Domain\Akta\Models\Template::skip(0)->take(8)->get();

		foreach ($dokumen as $key => $value) 
		{
			$akta 			= new App\Service\Akta\PublishTemplate($value->id);
			$akta->save();
		}



		$login 			= TAuth::login($credentials[1]);

		//drafting
		foreach (range(0, 19) as $key) 
		{
			$isi				= [
				'judul'			=> $j_akta[0].($key+20),
				'deskripsi'		=> $d_akta[0],
				'paragraf'		=> [
					['konten' 	=> '<h4 class="text-center"><b style="color: rgb(41, 43, 44); font-size: 1rem;">PEJABAT PEMBUAT AKTA TANAH</b></h4>'],
					['konten' 	=> '<h4 class="text-center"><b>(PPAT)</b></h4>'],
					['konten' 	=> '<h4 class="text-center"><span class="medium-editor-mention-at">@notaris.nama</span>&nbsp;</h4>'],
					['konten' 	=> '<h4 class="text-center">DAERAH KERJA <span class="medium-editor-mention-at">@notaris.daerah_kerja</span>&nbsp;</h4>'],
					['konten' 	=> '<h4 class="text-center">SK. Kepala Badan Pertanahan Nasional Nomor : <span class="medium-editor-mention-at">@notaris.nomor_sk</span>&nbsp;</h4>'],
					['konten' 	=> '<h4 class="text-center">Tanggal <span class="medium-editor-mention-at">@notaris.tanggal_pengangkatan</span>&nbsp;</h4>'],
					['konten' 	=> '<h4 class="text-center"><span class="medium-editor-mention-at">@notaris.alamat</span>&nbsp;<span class="medium-editor-mention-at">@notaris.telepon</span>&nbsp;</h4>'],
					['konten' 	=> '<p class="text-center">------------------------------------------------------------------</p>'],
					['konten' 	=> '<h5 style="text-align: center;"><b>AKTA JUAL BELI</b></h5>'],
					['konten' 	=> '<h5 style="text-align: center;">Nomor <span class="medium-editor-mention-at">@akta.nomor</span>&nbsp;</h5>'],
					['konten' 	=> '<h5 style="text-align: center;"><i>Lembar Pertama / Kedua</i></h5>'],
					['konten' 	=> '<p style="text-align: left;">Pada hari ini <span class="medium-editor-mention-at">@akta.tanggal</span>&nbsp;hadir dihadapan saya <span class="medium-editor-mention-at">@notaris.nama</span>&nbsp;yang berdasarkan surat keputusan menteri Agraria / Kepala Badan Pertanahan Nasional tanggal <span class="medium-editor-mention-at">@notaris.tanggal_pengangkatan</span>&nbsp;nomor <span class="medium-editor-mention-at">@notaris.nomor_sk</span>&nbsp;diangkat / ditunjuk sebagai Pejabat Pembuat Akta Tanah&nbsp;, yang selanjutnya disebut PPAT, yang dimaksud dalam pasal 7 Peraturan Pemerintah Nomor 24 Tahun 1997 tentang pendaftaran tanah, dengan daerah kerja <span class="medium-editor-mention-at">@notaris.daerah_kerja</span>&nbsp;dengan dihadiri oleh saksi - saksi yang saya kenal dan akan disebut pada bagian akhir akta ini :</p>'],
					['konten' 	=> '<ol><li><span class="medium-editor-mention-at">@pihak.1.ktp.nama</span>&nbsp;lahir di <span class="medium-editor-mention-at">@pihak.1.ktp.tempat_lahir</span>&nbsp;pada tanggal <span class="medium-editor-mention-at">@pihak.1.ktp.tanggal_lahir</span>&nbsp;Warga Negara Indonesia, <span class="medium-editor-mention-at">@pihak.1.ktp.pekerjaan</span>&nbsp;bertempat tinggal di <span class="medium-editor-mention-at">@pihak.1.ktp.alamat</span>&nbsp;pemegang kartu tanda penduduk nomor <span class="medium-editor-mention-at">@pihak.1.ktp.nomor_ktp</span>&nbsp;<br><span class="medium-editor-mention-at medium-editor-mention-at">@pihak.1.ktp.deskripsi</span>&nbsp;<br>Selaku penjual, yang selanjutnya disebut sebagai<br>PIHAK PERTAMA</li>'],
					['konten' 	=> '<li><span class="medium-editor-mention-at">@pihak.2.ktp.nama</span>&nbsp;lahir di <span class="medium-editor-mention-at">@pihak.2.ktp.tempat_lahir,</span>&nbsp;pada tanggal <span class="medium-editor-mention-at">@pihak.2.ktp.tanggal_lahir</span>&nbsp;Warga Negara Indonesia, <span class="medium-editor-mention-at">@pihak.2.ktp.pekerjaan</span>&nbsp;bertempat tinggal di <span class="medium-editor-mention-at">@pihak.2.ktp.alamat</span>&nbsp;pemegang kartu tanda penduduk nomor <span class="medium-editor-mention-at medium-editor-mention-at">@pihak.2.ktp.nomor_ktp</span><span class="medium-editor-mention-at medium-editor-mention-at">@pihak.2.ktp.deskripsi</span><br>Selaku pembeli, yang selanjutnya disebut sebagai<br>PIHAK KEDUA<br></li></ol>'],
				],
				'mentionable'	=> [
					'@notaris.nama',
					'@notaris.daerah_kerja',
					'@notaris.nomor_sk',
					'@notaris.tanggal_pengangkatan',
					'@notaris.alamat',
					'@notaris.telepon',
					'@akta.nomor',
					'@akta.tanggal',
					'@pihak.1.ktp.nama',
					'@pihak.1.ktp.tempat_lahir',
					'@pihak.1.ktp.tanggal_lahir',
					'@pihak.1.ktp.pekerjaan',
					'@pihak.1.ktp.alamat',
					'@pihak.1.ktp.nomor_ktp',
					'@pihak.1.ktp.deskripsi',
					'@pihak.2.ktp.nama',
					'@pihak.2.ktp.tempat_lahir',
					'@pihak.2.ktp.tanggal_lahir',
					'@pihak.2.ktp.pekerjaan',
					'@pihak.2.ktp.alamat',
					'@pihak.2.ktp.nomor_ktp',
					'@pihak.2.ktp.deskripsi',
				],
				'dokumen_objek'	=> [],
				'dokumen_pihak'	=> [1 => ['ktp' => ['nama', 'tempat_lahir', 'tanggal_lahir', 'pekerjaan', 'alamat','nomor_ktp', 'deskripsi']], 2 => ['ktp' => ['nama', 'tempat_lahir', 'tanggal_lahir', 'pekerjaan', 'alamat','nomor_ktp', 'deskripsi']]],
				'dokumen_saksi'	=> [1 => ['ktp' => ['nama', 'tempat_lahir', 'tanggal_lahir', 'pekerjaan', 'alamat','nomor_ktp', 'deskripsi']], 2 => ['ktp' => ['nama', 'tempat_lahir', 'tanggal_lahir', 'pekerjaan', 'alamat','nomor_ktp', 'deskripsi']]]
			];

			$akta 			= new  App\Service\Akta\BuatTemplateBaru($isi['judul'], $isi['deskripsi'], $isi['paragraf'], $isi['mentionable'], 2, 2, $isi['dokumen_objek'], $isi['dokumen_pihak'], $isi['dokumen_saksi']);
			$akta 			= $akta->save();
		}

		//init publish
		$dokumen 			= App\Domain\Akta\Models\Template::skip(20)->take(8)->get();

		foreach ($dokumen as $key => $value) 
		{
			$akta 			= new App\Service\Akta\PublishTemplate($value->id);
			$akta->save();
		}
	}
}
