<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Service\Helpers\DeskripsiTanggalService;

class InitAktaTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('akta_dokumen')->truncate();

		$credentials[0]	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$credentials[1]	= ['email' => 'drafter@notaris.id', 'password' => 'admin'];

		$faker			= \Faker\Factory::create();

		$hari 			= ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
		$j_akta 		= ['Akta Jual Beli', 'Akta Pemberian Hak Tanggungan', 'Akta Fidusia', 'Akta Perjanjian Sewa'];

		$pekerjaan 		= ['Direktur ', 'Karyawan ', 'Manager ', 'Supervisor '];
		$kab 			= ['Banyuwangi', 'Gresik', 'Kediri', 'Lamongan', 'Magetan', 'Malang', 'Mojokerto', 'Pamekasan', 'Pasuruan', 'Ponorogo', 'Situbondo', 'Sumenep', 'Tuban', 'Bangkalan', 'Bondowoso', 'Jember', 'Ngawi', 'Pacitan', 'Sampang', 'Tulungagung', 'Blitar', 'Bojonegoro', 'Jombang', 'Lumajang', 'Madiun', 'Nganjuk', 'Probolinggo', 'Sidoarjo', 'Trenggalek'];

		$login 			= TAuth::login($credentials[0]);
		$active_office 	= TAuth::activeOffice();
		$notaris_aktif	=  App\Domain\Admin\Models\Kantor::find($active_office['kantor']['id']);

		//init draft
		foreach (range(0, 19) as $key) 
		{
			$klien_1 			= [
				'nama' 				=> $faker->name,
				'tempat_lahir' 		=> $kab[rand(0,28)],
				'tanggal_lahir' 	=> Carbon::parse(' - '.rand(17,71).' years')->format('d/m/Y'),
				'pekerjaan' 		=> $pekerjaan[rand(0,3)],
				'alamat' 			=> $faker->address,
				'nomor_ktp' 		=> $faker->ean13,
				'deskripsi' 		=> 'lorep ipsum',
			];
			$klien_2 			= [
				'nama' 				=> $faker->name,
				'tempat_lahir' 		=> $kab[rand(0,28)],
				'tanggal_lahir' 	=> Carbon::parse(' - '.rand(17,71).' years')->format('d/m/Y'),
				'pekerjaan' 		=> $pekerjaan[rand(0,3)],
				'alamat' 			=> $faker->address,
				'nomor_ktp' 		=> $faker->ean13,
				'deskripsi' 		=> 'lorep ipsum',
			];

			$nomor_akta 		= $faker->ean13;
			$tgl 				= rand(1,28).'/'.rand(1,12).'/2016';
			$tlg_hadap 			= DeskripsiTanggalService::displayHariIni($tgl);
			$tlg_lengkap 		= $tgl.' 08:00';
	
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
					['konten' 	=> '<p style="text-align: left;">Pada hari ini <span class="medium-editor-mention-at" data-mention="@akta.tanggal">'.$tlg_hadap.'</b>&nbsp;hadir dihadapan saya <span class="medium-editor-mention-at" data-mention="@notaris.nama">'.$notaris_aktif['notaris']['nama'].'</span>&nbsp;yang berdasarkan surat keputusan menteri Agraria / Kepala Badan Pertanahan Nasional tanggal <span class="medium-editor-mention-at" data-mention="@notaris.tanggal_pengangkatan">'.$notaris_aktif['notaris']['tanggal_pengangkatan'].'</span>&nbsp;nomor <span class="medium-editor-mention-at" data-mention="@notaris.nomor_sk">'.$notaris_aktif['notaris']['nomor_sk'].'</span>&nbsp;diangkat / ditunjuk sebagai Pejabat Pembuat Akta Tanah&nbsp;, yang selanjutnya disebut PPAT, yang dimaksud dalam pasal 7 Peraturan Pemerintah Nomor 24 Tahun 1997 tentang pendaftaran tanah, dengan daerah kerja <span class="medium-editor-mention-at" data-mention="@notaris.daerah_kerja">'.$notaris_aktif['notaris']['daerah_kerja'].'</span>&nbsp;dengan dihadiri oleh saksi - saksi yang saya kenal dan akan disebut pada bagian akhir akta ini :</p>'],
					['konten' 	=> '<ol><li><span class="medium-editor-mention-at" data-mention="@pihak.1.ktp.nama">'.$klien_1['nama'].'</span>&nbsp;lahir di <span class="medium-editor-mention-at" data-mention="@pihak.1.ktp.tempat_lahir">'.$klien_1['tempat_lahir'].'</span>&nbsp;pada tanggal <span class="medium-editor-mention-at" data-mention="@pihak.1.ktp.tanggal_lahir">'.$klien_1['tanggal_lahir'].'</span>&nbsp;Warga Negara Indonesia, <span class="medium-editor-mention-at" data-mention="@pihak.1.ktp.pekerjaan">'.$klien_1['pekerjaan'].'</span>&nbsp;bertempat tinggal di <span class="medium-editor-mention-at" data-mention="@pihak.1.ktp.alamat">'.$klien_1['alamat'].'</span>&nbsp;pemegang kartu tanda penduduk nomor <span class="medium-editor-mention-at" data-mention="@pihak.1.ktp.nomor_ktp">'.$klien_1['nomor_ktp'].'</span>&nbsp;<br><span class="medium-editor-mention-at medium-editor-mention-at">@pihak.1.ktp.deskripsi</span>&nbsp;<br>Selaku penjual, yang selanjutnya disebut sebagai<br>PIHAK PERTAMA</li>'],
					['konten' 	=> '<li><span class="medium-editor-mention-at" data-mention="@pihak.2.ktp.nama">'.$klien_2['nama'].'</span>&nbsp;lahir di <span class="medium-editor-mention-at" data-mention="@pihak.2.ktp.tempat_lahir">'.$klien_2['tempat_lahir'].',</span>&nbsp;pada tanggal <span class="medium-editor-mention-at" data-mention="@pihak.2.ktp.tanggal_lahir">'.$klien_2['tanggal_lahir'].'</span>&nbsp;Warga Negara Indonesia, <span class="medium-editor-mention-at" data-mention="@pihak.2.ktp.pekerjaan">'.$klien_2['pekerjaan'].'</span>&nbsp;bertempat tinggal di <span class="medium-editor-mention-at" data-mention="@pihak.2.ktp.alamat">'.$klien_2['alamat'].'</span>&nbsp;pemegang kartu tanda penduduk nomor <span class="medium-editor-mention-at medium-editor-mention-at" data-mention="@pihak.2.ktp.nomor_ktp">'.$klien_2['nomor_ktp'].'<br></span><span class="medium-editor-mention-at medium-editor-mention-at">@pihak.2.ktp.deskripsi</span><br>Selaku pembeli, yang selanjutnya disebut sebagai<br>PIHAK KEDUA<br></li></ol>'],
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
				'fill_mention'	=> [
					'@notaris.nama' 					=> $notaris_aktif['notaris']['nama'],
					'@notaris.daerah_kerja'				=> $notaris_aktif['notaris']['daerah_kerja'],
					'@notaris.nomor_sk'					=> $notaris_aktif['notaris']['nomor_sk'],
					'@notaris.tanggal_pengangkatan'		=> $notaris_aktif['notaris']['tanggal_pengangkatan'],
					'@notaris.alamat' 					=> $notaris_aktif['notaris']['alamat'],
					'@notaris.telepon' 					=> $notaris_aktif['notaris']['telepon'],
					'@akta.nomor' 						=> $nomor_akta,
					'@akta.tanggal' 					=> $tlg_hadap,
					'@pihak.1.ktp.nama' 				=> $klien_1['nama'],
					'@pihak.1.ktp.tempat_lahir' 		=> $klien_1['tempat_lahir'],
					'@pihak.1.ktp.tanggal_lahir' 		=> $klien_1['tanggal_lahir'],
					'@pihak.1.ktp.pekerjaan' 			=> $klien_1['pekerjaan'],
					'@pihak.1.ktp.alamat' 				=> $klien_1['alamat'],
					'@pihak.1.ktp.nomor_ktp' 			=> $klien_1['nomor_ktp'],
					'@pihak.1.ktp.deskripsi'			=> $faker->ean13,
					'@pihak.2.ktp.nama' 				=> $klien_2['nama'],
					'@pihak.2.ktp.tempat_lahir' 		=> $klien_2['tempat_lahir'],
					'@pihak.2.ktp.tanggal_lahir' 		=> $klien_2['tanggal_lahir'],
					'@pihak.2.ktp.pekerjaan' 			=> $klien_2['pekerjaan'],
					'@pihak.2.ktp.alamat' 				=> $klien_2['alamat'],
					'@pihak.2.ktp.nomor_ktp' 			=> $klien_2['nomor_ktp'],
					'@pihak.2.ktp.deskripsi'			=> $faker->ean13,
				],
			];

			$tmplate 		= App\Domain\Akta\Models\Template::first();
			$akta 			= new App\Service\Akta\BuatAktaBaru(null, $klien_1['nama'], $faker->phoneNumber, $tlg_lengkap, $isi['judul'], $isi['paragraf'], $isi['mentionable'], $tmplate->_id);
			$akta 			= $akta->handle();

			$aktas 			= new App\Service\Akta\SimpanAkta($akta['id'], $akta['judul'], $akta['paragraf'], $isi['fill_mention']);
			$aktas->handle();

		}

		//init pengajuan
		$dokumen 		= App\Domain\Akta\Models\Dokumen::skip(0)->take(8)->get();

		foreach ($dokumen as $key => $value) 
		{
			$akta 			= new App\Service\Akta\PublishAkta($value->id);
			$akta->handle();
		}


		$login 			= TAuth::login($credentials[1]);
		$active_office 	= TAuth::activeOffice();
		$notaris_aktif	=  App\Domain\Admin\Models\Kantor::find($active_office['kantor']['id']);

		//init draft
		foreach (range(0, 19) as $key) 
		{
			$klien_1 			= [
				'nama' 				=> $faker->name,
				'tempat_lahir' 		=> $kab[rand(0,28)],
				'tanggal_lahir' 	=> Carbon::parse(' - '.rand(17,71).' years')->format('d/m/Y'),
				'pekerjaan' 		=> $pekerjaan[rand(0,3)],
				'alamat' 			=> $faker->address,
				'nomor_ktp' 		=> $faker->ean13,
				'deskripsi' 		=> 'lorep ipsum',
			];
			$klien_2 			= [
				'nama' 				=> $faker->name,
				'tempat_lahir' 		=> $kab[rand(0,28)],
				'tanggal_lahir' 	=> Carbon::parse(' - '.rand(17,71).' years')->format('d/m/Y'),
				'pekerjaan' 		=> $pekerjaan[rand(0,3)],
				'alamat' 			=> $faker->address,
				'nomor_ktp' 		=> $faker->ean13,
				'deskripsi' 		=> 'lorep ipsum',
			];

			$nomor_akta 		= $faker->ean13;
			$tgl 				= rand(1,28).'/'.rand(1,12).'/2016';
			$tlg_hadap 			= DeskripsiTanggalService::displayHariIni($tgl);
			$tlg_lengkap 		= $tgl.' 08:00';
	
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
					['konten' 	=> '<p style="text-align: left;">Pada hari ini <span class="medium-editor-mention-at" data-mention="@akta.tanggal">'.$tlg_hadap.'</b>&nbsp;hadir dihadapan saya <span class="medium-editor-mention-at" data-mention="@notaris.nama">'.$notaris_aktif['notaris']['nama'].'</span>&nbsp;yang berdasarkan surat keputusan menteri Agraria / Kepala Badan Pertanahan Nasional tanggal <span class="medium-editor-mention-at" data-mention="@notaris.tanggal_pengangkatan">'.$notaris_aktif['notaris']['tanggal_pengangkatan'].'</span>&nbsp;nomor <span class="medium-editor-mention-at" data-mention="@notaris.nomor_sk">'.$notaris_aktif['notaris']['nomor_sk'].'</span>&nbsp;diangkat / ditunjuk sebagai Pejabat Pembuat Akta Tanah&nbsp;, yang selanjutnya disebut PPAT, yang dimaksud dalam pasal 7 Peraturan Pemerintah Nomor 24 Tahun 1997 tentang pendaftaran tanah, dengan daerah kerja <span class="medium-editor-mention-at" data-mention="@notaris.daerah_kerja">'.$notaris_aktif['notaris']['daerah_kerja'].'</span>&nbsp;dengan dihadiri oleh saksi - saksi yang saya kenal dan akan disebut pada bagian akhir akta ini :</p>'],
					['konten' 	=> '<ol><li><span class="medium-editor-mention-at" data-mention="@pihak.1.ktp.nama">'.$klien_1['nama'].'</span>&nbsp;lahir di <span class="medium-editor-mention-at" data-mention="@pihak.1.ktp.tempat_lahir">'.$klien_1['tempat_lahir'].'</span>&nbsp;pada tanggal <span class="medium-editor-mention-at" data-mention="@pihak.1.ktp.tanggal_lahir">'.$klien_1['tanggal_lahir'].'</span>&nbsp;Warga Negara Indonesia, <span class="medium-editor-mention-at" data-mention="@pihak.1.ktp.pekerjaan">'.$klien_1['pekerjaan'].'</span>&nbsp;bertempat tinggal di <span class="medium-editor-mention-at" data-mention="@pihak.1.ktp.alamat">'.$klien_1['alamat'].'</span>&nbsp;pemegang kartu tanda penduduk nomor <span class="medium-editor-mention-at" data-mention="@pihak.1.ktp.nomor_ktp">'.$klien_1['nomor_ktp'].'</span>&nbsp;<br><span class="medium-editor-mention-at medium-editor-mention-at">@pihak.1.ktp.deskripsi</span>&nbsp;<br>Selaku penjual, yang selanjutnya disebut sebagai<br>PIHAK PERTAMA</li>'],
					['konten' 	=> '<li><span class="medium-editor-mention-at" data-mention="@pihak.2.ktp.nama">'.$klien_2['nama'].'</span>&nbsp;lahir di <span class="medium-editor-mention-at" data-mention="@pihak.2.ktp.tempat_lahir">'.$klien_2['tempat_lahir'].',</span>&nbsp;pada tanggal <span class="medium-editor-mention-at" data-mention="@pihak.2.ktp.tanggal_lahir">'.$klien_2['tanggal_lahir'].'</span>&nbsp;Warga Negara Indonesia, <span class="medium-editor-mention-at" data-mention="@pihak.2.ktp.pekerjaan">'.$klien_2['pekerjaan'].'</span>&nbsp;bertempat tinggal di <span class="medium-editor-mention-at" data-mention="@pihak.2.ktp.alamat">'.$klien_2['alamat'].'</span>&nbsp;pemegang kartu tanda penduduk nomor <span class="medium-editor-mention-at medium-editor-mention-at" data-mention="@pihak.2.ktp.nomor_ktp">'.$klien_2['nomor_ktp'].'<br></span><span class="medium-editor-mention-at medium-editor-mention-at">@pihak.2.ktp.deskripsi</span><br>Selaku pembeli, yang selanjutnya disebut sebagai<br>PIHAK KEDUA<br></li></ol>'],
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
				'fill_mention'	=> [
					'@notaris.nama' 					=> $notaris_aktif['notaris']['nama'],
					'@notaris.daerah_kerja'				=> $notaris_aktif['notaris']['daerah_kerja'],
					'@notaris.nomor_sk'					=> $notaris_aktif['notaris']['nomor_sk'],
					'@notaris.tanggal_pengangkatan'		=> $notaris_aktif['notaris']['tanggal_pengangkatan'],
					'@notaris.alamat' 					=> $notaris_aktif['notaris']['alamat'],
					'@notaris.telepon' 					=> $notaris_aktif['notaris']['telepon'],
					'@akta.nomor' 						=> $nomor_akta,
					'@akta.tanggal' 					=> $tlg_hadap,
					'@pihak.1.ktp.nama' 				=> $klien_1['nama'],
					'@pihak.1.ktp.tempat_lahir' 		=> $klien_1['tempat_lahir'],
					'@pihak.1.ktp.tanggal_lahir' 		=> $klien_1['tanggal_lahir'],
					'@pihak.1.ktp.pekerjaan' 			=> $klien_1['pekerjaan'],
					'@pihak.1.ktp.alamat' 				=> $klien_1['alamat'],
					'@pihak.1.ktp.nomor_ktp' 			=> $klien_1['nomor_ktp'],
					'@pihak.1.ktp.deskripsi'			=> $faker->ean13,
					'@pihak.2.ktp.nama' 				=> $klien_2['nama'],
					'@pihak.2.ktp.tempat_lahir' 		=> $klien_2['tempat_lahir'],
					'@pihak.2.ktp.tanggal_lahir' 		=> $klien_2['tanggal_lahir'],
					'@pihak.2.ktp.pekerjaan' 			=> $klien_2['pekerjaan'],
					'@pihak.2.ktp.alamat' 				=> $klien_2['alamat'],
					'@pihak.2.ktp.nomor_ktp' 			=> $klien_2['nomor_ktp'],
					'@pihak.2.ktp.deskripsi'			=> $faker->ean13,
				],
			];

			$tmplate 		= App\Domain\Akta\Models\Template::first();
			$akta 			= new App\Service\Akta\BuatAktaBaru(null, $klien_1['nama'], $faker->phoneNumber, $tlg_lengkap, $isi['judul'], $isi['paragraf'], $isi['mentionable'], $tmplate->_id);
			$akta 			= $akta->handle();

			$aktas 			= new App\Service\Akta\SimpanAkta($akta['id'], $akta['judul'], $akta['paragraf'], $isi['fill_mention']);
			$aktas->handle();

		}

		//init pengajuan
		$dokumen 		= App\Domain\Akta\Models\Dokumen::skip(20)->take(8)->get();

		foreach ($dokumen as $key => $value) 
		{
			$akta 			= new App\Service\Akta\PublishAkta($value->id);
			$akta->handle();
		}
	}
}
