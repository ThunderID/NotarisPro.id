<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Service\Helpers\DeskripsiTanggalService;
use App\Service\Helpers\Performance\Profiler;

class InitNewArchV2TableSeeder extends Seeder
{
	public function run()
	{
		DB::table('akta_tipe_dokumen')->truncate();
		DB::table('akta_dokumen')->truncate();
		DB::table('notaris_klien')->truncate();
		DB::table('notaris_arsip')->truncate();
		DB::table('jadwal_pertemuan')->truncate();

		$credentials[0]	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$credentials[1]	= ['email' => 'drafter@notaris.id', 'password' => 'admin'];

		$faker			= \Faker\Factory::create();

		$hari 			= ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
		$ju_akta 		= ['Akta Jual Beli', 'Akta Pemberian Hak Tanggungan', 'Akta Fidusia', 'Akta Perjanjian Sewa'];
		$je_akta 		= ['AJB', 'APHT', 'Fidusia', 'PERJANJIANSEWA'];

		$pekerjaan 		= ['Direktur ', 'Karyawan ', 'Manager ', 'Supervisor '];
		$kab 			= ['Banyuwangi', 'Gresik', 'Kediri', 'Lamongan', 'Magetan', 'Malang', 'Mojokerto', 'Pamekasan', 'Pasuruan', 'Ponorogo', 'Situbondo', 'Sumenep', 'Tuban', 'Bangkalan', 'Bondowoso', 'Jember', 'Ngawi', 'Pacitan', 'Sampang', 'Tulungagung', 'Blitar', 'Bojonegoro', 'Jombang', 'Lumajang', 'Madiun', 'Nganjuk', 'Probolinggo', 'Sidoarjo', 'Trenggalek'];

		$login 			= TAuth::login($credentials[0]);
		$active_office 	= TAuth::activeOffice();
		$notaris_aktif	=  App\Domain\Administrative\Models\Kantor::find($active_office['kantor']['id']);

		//init draft
		foreach (range(0, 19) as $key) 
		{
			$klien_1 			= [
				'nama' 				=> $faker->name($gender='male'),
				'tempat_lahir' 		=> $kab[rand(0,28)],
				'tanggal_lahir' 	=> Carbon::parse(' - '.rand(17,71).' years')->format('d/m/Y'),
				'pekerjaan' 		=> $pekerjaan[rand(0,3)],
				'alamat' 			=> $faker->address,
				'nik' 		=> $faker->ean13,
				'deskripsi' 		=> 'lorep ipsum',
			];
			$klien_2 			= [
				'nama' 				=> $faker->name($gender='female'),
				'tempat_lahir' 		=> $kab[rand(0,28)],
				'tanggal_lahir' 	=> Carbon::parse(' - '.rand(17,71).' years')->format('d/m/Y'),
				'pekerjaan' 		=> $pekerjaan[rand(0,3)],
				'alamat' 			=> $faker->address,
				'nik' 		=> $faker->ean13,
				'deskripsi' 		=> 'lorep ipsum',
			];

			$klien_2_s 			= [
				'nama' 				=> $faker->name($gender='male'),
				'tempat_lahir' 		=> $kab[rand(0,28)],
				'tanggal_lahir' 	=> Carbon::parse(' - '.rand(17,71).' years')->format('d/m/Y'),
				'pekerjaan' 		=> $pekerjaan[rand(0,3)],
				'alamat' 			=> $faker->address,
				'nik' 			=> $faker->ean13,
				'deskripsi' 		=> 'lorep ipsum',
			];

			$nomor_akta 		= $faker->ean13;
			$tgl 				= rand(1,28).'/'.rand(1,12).'/2016';
			$tlg_hadap 			= DeskripsiTanggalService::displayHariIni($tgl);
			$tlg_lengkap 		= $tgl.' 08:00';
	
			$isi 				= '<h4 class="text-center"><b style="color: rgb(41, 43, 44); font-size: 1rem;">PEJABAT PEMBUAT AKTA TANAH</b></h4><h4 class="text-center"><span class="medium-editor-mention-at">@notaris.nama@</span>&nbsp;</h4><h4 class="text-center">DAERAH KERJA <span class="medium-editor-mention-at">@notaris.daerah_kerja@</span>&nbsp;</h4><h4 class="text-center">SK. Kepala Badan Pertanahan Nasional Nomor : <span class="medium-editor-mention-at">@notaris.nomor_sk@</span>&nbsp;</h4><h4 class="text-center">Tanggal <span class="medium-editor-mention-at">@notaris.tanggal_pengangkatan@</span>&nbsp;</h4><h4 class="text-center"><span class="medium-editor-mention-at">@notaris.alamat@</span>&nbsp;<span class="medium-editor-mention-at">@notaris.telepon@</span>&nbsp;</h4><p class="text-center">------------------------------------------------------------------</p><h5 class="text-center"><b>AKTA JUAL BELI</b></h5><h5 class="text-center">Nomor <span class="medium-editor-mention-at">@akta.nomor@</span>&nbsp;</h5><h5 class="text-center"><i>Lembar Pertama / Kedua</i></h5><p style="text-align: left;">Pada hari ini <span class="medium-editor-mention-at">@akta.tanggal@</span>&nbsp;hadir dihadapan saya <span class="medium-editor-mention-at">@notaris.nama@</span>&nbsp;yang berdasarkan surat keputusan menteri Agraria / Kepala Badan Pertanahan Nasional tanggal <span class="medium-editor-mention-at">@notaris.tanggal_pengangkatan@</span>&nbsp;nomor <span class="medium-editor-mention-at">@notaris.nomor_sk@</span>&nbsp;diangkat / ditunjuk sebagai Pejabat Pembuat Akta Tanah&nbsp;, yang selanjutnya disebut PPAT, yang dimaksud dalam pasal 7 Peraturan Pemerintah Nomor 24 Tahun 1997 tentang pendaftaran tanah, dengan daerah kerja <span class="medium-editor-mention-at">@notaris.daerah_kerja@</span>&nbsp;dengan dihadiri oleh saksi - saksi yang saya kenal dan akan disebut pada bagian akhir akta ini :</p><ol><li><span class="medium-editor-mention-at">@pihak.1.ktp.pribadi.nama@</span>&nbsp;lahir di <span class="medium-editor-mention-at">@pihak.1.ktp.pribadi.tempat_lahir@</span>&nbsp;pada tanggal <span class="medium-editor-mention-at">@pihak.1.ktp.pribadi.tanggal_lahir@</span>&nbsp;Warga Negara Indonesia, <span class="medium-editor-mention-at">@pihak.1.ktp.pribadi.pekerjaan@</span>&nbsp;bertempat tinggal di <span class="medium-editor-mention-at">@pihak.1.ktp.pribadi.alamat@</span>&nbsp;pemegang kartu tanda penduduk nomor <span class="medium-editor-mention-at">@pihak.1.ktp.pribadi.nik@</span>&nbsp;<br> <span class="medium-editor-mention-at">@pihak.1.ktp.pribadi.deskripsi@</span>&nbsp;<br>Selaku penjual, yang selanjutnya disebut sebagai<br>PIHAK PERTAMA</li><li><span class="medium-editor-mention-at">@pihak.2.ktp.pribadi.nama@</span>&nbsp;lahir di <span class="medium-editor-mention-at">@pihak.2.ktp.pribadi.tempat_lahir@</span>&nbsp;, pada tanggal <span class="medium-editor-mention-at">@pihak.2.ktp.pribadi.tanggal_lahir@</span>&nbsp;Warga Negara Indonesia, <span class="medium-editor-mention-at">@pihak.2.ktp.pribadi.pekerjaan@</span>&nbsp;bertempat tinggal di <span class="medium-editor-mention-at">@pihak.2.ktp.pribadi.alamat@</span>&nbsp;pemegang kartu tanda penduduk nomor <span class="medium-editor-mention-at">@pihak.2.ktp.pribadi.nik@</span><br><span class="medium-editor-mention-at">@pihak.2.ktp.pribadi.deskripsi@</span><br>Selaku pembeli, yang selanjutnya disebut sebagai<br>PIHAK KEDUA, dalam hal ini bertindak sebagai istri dari saudara <span class="medium-editor-mention-at">@pihak.2.ktp.suami.nama@</span>pemilik nomor kartu tanda penduduk <span class="medium-editor-mention-at">@pihak.2.ktp.suami.nik@</span><br></li></ol>';

			//test buat akta baru
			$jrand 			= rand(0,3);
			$akta 			= new App\Service\Akta\BuatAktaBaru($ju_akta[$jrand], $je_akta[$jrand], $isi);
			$akta 			= $akta->save();

			$data_isi 		= [
					'@pihak.1.ktp.pribadi.nama@'			=> $klien_1['nama'],
					'@pihak.1.ktp.pribadi.tempat_lahir@'	=> $klien_1['tempat_lahir'],
					'@pihak.1.ktp.pribadi.tanggal_lahir@'	=> $klien_1['tanggal_lahir'],
					'@pihak.1.ktp.pribadi.pekerjaan@'		=> $klien_1['pekerjaan'],
					'@pihak.1.ktp.pribadi.nik@'				=> $klien_1['nik'],
					'@pihak.2.ktp.pribadi.nama@'			=> $klien_2['nama'],
					'@pihak.2.ktp.pribadi.tempat_lahir@'	=> $klien_2['tempat_lahir'],
					'@pihak.2.ktp.pribadi.tanggal_lahir@'	=> $klien_2['tanggal_lahir'],
					'@pihak.2.ktp.pribadi.pekerjaan@'		=> $klien_2['pekerjaan'],
					'@pihak.2.ktp.pribadi.nik@'				=> $klien_2['nik'],
					'@pihak.2.ktp.suami.nik@'				=> $klien_2_s['nik'],
					'@pihak.2.ktp.suami.nama@'				=> $klien_2_s['nama'],
				];

			$update_akta 	= new App\Service\Akta\UpdateAkta($akta->id, $active_office['kantor']['id']);
			$update_akta->setData($data_isi);
			$update 		= $update_akta->save();


			//test update akta dalam proses
			if(rand(0,1))
			{
				$paragraf_isi	= $isi.'<p>Berdasarkan akta nomor <span class="medium-editor-mention-at">@objek.1.shgb.pribadi.nomor@</span></p>';

				$update_akta 	= new App\Service\Akta\UpdateAkta($akta->id, $active_office['kantor']['id']);
				$update_akta->setParagraf($paragraf_isi);
				$update 		= $update_akta->save();
			}
			
			//simpan minuta
			if(rand(0,1))
			{
				$minuta_akta	= new App\Service\Akta\UpdateStatusAkta($akta->id);
				$minuta 		= $minuta_akta->toMinuta();

				//to renvoi
				if(rand(0,1))
				{
					// editable renvoi
					if(rand(0,1))
					{
						$lock_pos 		= rand(0, (count($minuta->paragraf) -1));
						$lock_akta 		= new App\Service\Akta\LockAkta($akta->id);
						$editing_r 		= $lock_akta->editable($minuta->paragraf[$lock_pos]['key']);

						$edited_things 	= '';

						foreach ($editing_r->paragraf as $key => $value) 
						{
							if($key==$lock_pos)
							{
								$value['konten']	= $value['konten'].'<strong>edited</strong>';
							}

							$edited_things	= $edited_things.$value['konten'];
						}

						$renvoi_akta 	= new App\Service\Akta\UpdateAkta($akta->id, $active_office['kantor']['id']);
						$renvoi_akta->setParagraf($edited_things);
						$renvoi 		= $renvoi_akta->save();
					
						$lock_akta 		= new App\Service\Akta\LockAkta($akta->id);
						$lock_akta->editable($minuta->renvoi[$lock_pos]['key']);
					}

					//remove renvoi
					if(rand(0,1))
					{
						$rm_pos 	= rand(1, (count($minuta->paragraf) -1));
						$lock_akta 	= new App\Service\Akta\LockAkta($akta->id);
						$akta 		= $lock_akta->removeParagrafBefore($minuta->paragraf[$rm_pos]['key']);
					} 
					//adding renvoi
					elseif(rand(0,1))
					{
						$add_pos 	= rand(1, (count($minuta->paragraf) -1));
						$lock_akta 	= new App\Service\Akta\LockAkta($akta->id);
						$adding_r 	= $lock_akta->addParagrafAfter($minuta->paragraf[$add_pos]['key']);

						$edited_things 	= '';

						foreach ($minuta->paragraf as $key => $value) 
						{
							if($add_pos+1==$key)
							{
								$edited_things 	= $edited_things.'<p>EDITINGADDED</p>';
							}
							$edited_things		= $edited_things.$value['konten'];
						}

						$renvoi_akta 	= new App\Service\Akta\UpdateAkta($akta->id, $active_office['kantor']['id']);
						$renvoi_akta->setParagraf($edited_things);
						$renvoi 		= $renvoi_akta->save();

						$lock_akta 		= new App\Service\Akta\LockAkta($akta->id);
						$lock_akta->editable($renvoi->paragraf[$add_pos]['key']);
					} 

					//to salinan
					if(rand(0,1))
					{
						$salinan_akta 	= new App\Service\Akta\UpdateStatusAkta($akta->id);
						$salinan 		= $salinan_akta->toSalinan(rand(10000000000000000, 99999999999999999));
					}
				}
			}

		}
	
	}
}
