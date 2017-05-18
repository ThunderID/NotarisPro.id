<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class InitTipeDokumenTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('akta_tipe_dokumen')->truncate();

		$credentials[0]	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		$credentials[1]	= ['email' => 'drafter@notaris.id', 'password' => 'admin'];

		//1. dokumen pihak
		$dok_mention	= [
			'ktp'				=> ['nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'status_pernikahan', 'pekerjaan', 'kewarganegaraan', 'alamat'],
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
			'bpkb'				=> ['nomor', 'nomor_polisi', 'merek', 'tipe', 'jenis', 'model', 'tahun_pembuatan', 'tahun_perakitan', 'isi_silinder', 'warna', 'nomor_rangka', 'nomor_mesin', 'jumlah_sumbu', 'jumlah_roda', 'bahan_bakar', 'dikeluarkan_tanggal', 'nama_pemilik', 'alamat_pemilik'],
			'stnk'				=> ['nomor', 'nomor_polisi', 'merek', 'tipe', 'jenis', 'model', 'tahun_pembuatan', 'tahun_perakitan', 'isi_silinder', 'warna', 'nomor_rangka', 'nomor_mesin', 'jumlah_sumbu', 'jumlah_roda', 'bahan_bakar', 'dikeluarkan_tanggal', 'nama_pemilik', 'alamat_pemilik'],
		];

		$jenis_dokumen 	= 	[
								'ktp' => ['tags' => ['pihak', 'saksi']], 
								'kk' => ['tags' => ['pihak', 'saksi']], 
								'paspor' => ['tags' => ['pihak']], 
								'akta_lahir' => ['tags' => ['pihak']], 
								'akta_ganti_nama' => ['tags' => ['pihak']], 
								'akta_nikah' => ['tags' => ['pihak']], 
								'akta_cerai' => ['tags' => ['pihak']], 
								'akta_kematian' => ['tags' => ['pihak']], 
								'akta_waris' => ['tags' => ['pihak']], 
								'akta_pendirian' => ['tags' => ['pihak']], 
								'pengesahan_depkumham' => ['tags' => ['pihak']], 
								'akta_perubahan_terakhir' => ['tags' => ['pihak']], 
								'shgb' => ['tags' => ['objek']], 
								'shm' => ['tags' => ['objek']], 
								'imb' => ['tags' => ['objek']], 
								'pbb' => ['tags' => ['objek']], 
								'hpl' => ['tags' => ['objek']], 
								'bpkb' => ['tags' => ['objek']], 
								'stnk' => ['tags' => ['objek']]
							];

		$login 			= TAuth::login($credentials[0]);
		$active_office 	= TAuth::activeOffice();
		$notaris_aktif	=  App\Domain\Admin\Models\Kantor::find($active_office['kantor']['id']);

		$kantor 		= ['id' => $notaris_aktif->_id, 'nama' => $notaris_aktif->nama];

		$tipe_dokumen					= new App\Domain\Akta\Models\TipeDokumen;
		$tipe_dokumen->jenis_dokumen 	= $jenis_dokumen;
		$tipe_dokumen->isi 				= $dok_mention;
		$tipe_dokumen->kantor 			= $kantor;

		$tipe_dokumen->save();

		$login 			= TAuth::login($credentials[1]);
		$active_office 	= TAuth::activeOffice();
		$notaris_aktif	=  App\Domain\Admin\Models\Kantor::find($active_office['kantor']['id']);

		$kantor 		= ['id' => $notaris_aktif->_id, 'nama' => $notaris_aktif->nama];

		$tipe_dokumen					= new App\Domain\Akta\Models\TipeDokumen;
		$tipe_dokumen->jenis_dokumen 	= $jenis_dokumen;
		$tipe_dokumen->isi 				= $dok_mention;
		$tipe_dokumen->kantor 			= $kantor;

		$tipe_dokumen->save();
	}
}
