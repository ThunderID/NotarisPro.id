<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class InitTemplateTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('akta_template')->truncate();

		$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$login 			= TAuth::login($credentials);

		$faker			= \Faker\Factory::create();

		$hari 			= ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
		$j_akta 		= ['Akta Jual Beli Perorangan 2 Pihak', 'Akta Pemberian Hak Tanggungan 3 Pihak Perorangan', 'Akta Fidusia 2 Pihak Perorangan', 'Akta Perjanjian Sewa Persero dengan Persero'];

		//drafting
		foreach (range(0, 19) as $key) 
		{
			$isi				= [
				'judul'			=> $j_akta[0],
				'paragraf'		=> [
					['konten' 	=> '<h4 class="text-center"><br></h4>'],
					['konten' 	=> '<h4 class="text-center"><b style="color: rgb(41, 43, 44); font-size: 1rem;">PEJABAT PEMBUAT AKTA TANAH</b></h4>'],
					['konten' 	=> '<p style="text-align: center;"><b>(PPAT)</b></p>'],
					['konten' 	=> '<p style="text-align: center;"><b class="medium-editor-mention-at medium-editor-mention-at">@notaris.nama</b>&nbsp;</p>'],
					['konten' 	=> '<p style="text-align: center;">DAERAH KERJA <b class="medium-editor-mention-at">@notaris.daerah_kerja</b>&nbsp;</p>'],
					['konten' 	=> '<p style="text-align: center;">SK. Kepala Badan Pertanahan Nasional Nomor : <b class="medium-editor-mention-at">@notaris.nomor_sk</b>&nbsp;</p>'],
					['konten' 	=> '<p style="text-align: center;">Tanggal <b class="medium-editor-mention-at">@notaris.tanggal_pengangkatan</b>&nbsp;</p>'],
					['konten' 	=> '<p style="text-align: center;"><b class="medium-editor-mention-at">@notaris.alamat</b>&nbsp;<b class="medium-editor-mention-at">@notaris.telepon</b>&nbsp;</p>'],
					['konten' 	=> '<p style="text-align: center;">------------------------------------------------------------------</p>'],
					['konten' 	=> '<p style="text-align: center;"><b>AKTA JUAL BELI</b></p>'],
					['konten' 	=> '<p style="text-align: center;">Nomor <b class="medium-editor-mention-at">@akta.nomor</b>&nbsp;</p>'],
					['konten' 	=> '<p style="text-align: center;"><i>Lembar Pertama / Kedua</i></p>'],
					['konten' 	=> '<p style="text-align: left;">Pada hari ini <b class="medium-editor-mention-at">@tanggal.menghadap</b>&nbsp;hadir dihadapan saya <b class="medium-editor-mention-at">@notaris.nama</b>&nbsp;yang berdasarkan surat keputusan menteri Agraria / Kepala Badan Pertanahan Nasional tanggal <b class="medium-editor-mention-at">@notaris.tanggal_pengangkatan</b>&nbsp;nomor <b class="medium-editor-mention-at">@notaris.nomor_sk</b>&nbsp;diangkat / ditunjuk sebagai Pejabat Pembuat Akta Tanah&nbsp;, yang selanjutnya disebut PPAT, yang dimaksud dalam pasal 7 Peraturan Pemerintah Nomor 24 Tahun 1997 tentang pendaftaran tanah, dengan daerah kerja <b class="medium-editor-mention-at">@notaris.daerah_kerja</b>&nbsp;dengan dihadiri oleh saksi - saksi yang saya kenal dan akan disebut pada bagian akhir akta ini :</p>'],
					['konten' 	=> '<ol><li><b class="medium-editor-mention-at">@klien.1.nama</b>&nbsp;lahir di <b class="medium-editor-mention-at">@klien.1.tempat_lahir</b>&nbsp;pada tanggal <b class="medium-editor-mention-at">@klien.1.tanggal_lahir</b>&nbsp;Warga Negara Indonesia, <b class="medium-editor-mention-at">@klien.1.pekerjaan</b>&nbsp;bertempat tinggal di <b class="medium-editor-mention-at">@klien.1.alamat</b>&nbsp;pemegang kartu tanda penduduk nomor <b class="medium-editor-mention-at">@klien.1.nomor_ktp</b>&nbsp;<br><b class="medium-editor-mention-at medium-editor-mention-at">@klien.1.deskripsi</b>&nbsp;<br>Selaku penjual, yang selanjutnya disebut sebagai<br>PIHAK PERTAMA</li>'],
					['konten' 	=> '<li><b class="medium-editor-mention-at">@klien.2.nama</b>&nbsp;lahir di <b class="medium-editor-mention-at">@klien.2.tempat_lahir,</b>&nbsp;pada tanggal <b class="medium-editor-mention-at">@klien.2.tanggal_lahir</b>&nbsp;Warga Negara Indonesia, <b class="medium-editor-mention-at">@klien.2.pekerjaan</b>&nbsp;bertempat tinggal di <b class="medium-editor-mention-at">@klien.2.alamat</b>&nbsp;pemegang kartu tanda penduduk nomor <b class="medium-editor-mention-at medium-editor-mention-at">@klien.2.nomor_ktp<br></b><b class="medium-editor-mention-at medium-editor-mention-at">@klien.2.deskripsi</b><br>Selaku pembeli, yang selanjutnya disebut sebagai<br>PIHAK KEDUA<br></li></ol>'],
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
			];

			$akta 			= new \TCommands\Akta\DraftingTemplateAkta($isi);
			$akta->handle();
		}

		//init publish
		$dokumen 			= TAkta\DokumenKunci\Models\Template::skip(0)->take(8)->get();

		foreach ($dokumen as $key => $value) 
		{
			$akta 			= new \TCommands\Akta\PublishTemplateAkta($value->id);
			$akta->handle();
		}

		//init update
		$dokumen 		= TAkta\DokumenKunci\Models\Template::skip(0)->take(3)->get();

		foreach ($dokumen as $key => $value) 
		{
			$edited 	= $value->toArray();

			$edited['paragraf'][0]['konten'] 	= ''.$edited['paragraf'][0]['konten'];
			$edited['paragraf'][1]['konten'] 	= ''.$edited['paragraf'][1]['konten'];

			$akta 		= new \TCommands\Akta\SimpanTemplateAkta($edited);
			$akta->handle();
		}
	}
}
