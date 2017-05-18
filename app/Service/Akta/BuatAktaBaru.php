<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Versi;
use App\Domain\Akta\Models\Dokumen;

use App\Domain\Order\Models\Klien;
use App\Domain\Order\Models\Jadwal;

use App\Domain\Admin\Models\Kantor;

use Exception, DB, TAuth, Carbon\Carbon;

class BuatAktaBaru
{
	protected $klien_id;
	protected $klien_nama;
	protected $klien_telepon;
	protected $tanggal_pertemuan;
	protected $judul;
	protected $isi_akta;
	protected $mentionable;
	protected $template_id;

	/**
	 * Create a new job instance.
	 *
	 * @param  $klien_id
	 * @param  $klien_nama
	 * @param  $klien_telepon
	 * @param  $tanggal_pertemuan
	 * @param  $judul
	 * @param  $isi_akta
	 * @param  $mentionable
	 * @param  $template_id
	 *
	 * @return void
	 */
	public function __construct($tanggal_pertemuan, $judul, array $isi_akta, array $mentionable, $template_id)
	{
		$this->tanggal_pertemuan	= $tanggal_pertemuan;
		$this->judul				= $judul;
		$this->isi_akta				= $isi_akta;
		$this->mentionable			= $mentionable;
		$this->template_id			= $template_id;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		try
		{
			//0. get logged data
			$loggedUser 		= TAuth::loggedUser();
			$activeOffice 		= TAuth::activeOffice();
			$notaris 			= Kantor::find($activeOffice['kantor']['id']);

			//1. simpan klien

			//2. simpan akta
			$call				= new DaftarTemplateAkta;
			$template			= $call->detailed($this->template_id);

			$akta['pemilik']['orang'][0]['id'] 		= $loggedUser['id'];
			$akta['pemilik']['orang'][0]['nama'] 	= $loggedUser['nama'];

			$akta['pemilik']['kantor']['id'] 		= $activeOffice['kantor']['id'];
			$akta['pemilik']['kantor']['nama'] 		= $activeOffice['kantor']['nama'];

			$akta['penulis']['id'] 					= $loggedUser['id'];
			$akta['penulis']['nama'] 				= $loggedUser['nama'];

			$akta['mentionable']					= $template['mentionable'];
			$akta['judul']							= $this->judul;

			$akta['jumlah_pihak']					= $template['jumlah_pihak'];
			$akta['jumlah_saksi']					= $template['jumlah_saksi'];
			$akta['dokumen_objek']					= $template['dokumen_objek'];
			$akta['dokumen_pihak']					= $template['dokumen_pihak'];
			$akta['dokumen_saksi']					= $template['dokumen_saksi'];
			$akta['total_perubahan']				= 0;
			
			$akta['template']['id']					= $template_id;

			$pihak 									= [];

			foreach($akta['mentionable'] as $key => $value)
			{
				if(isset($this->mentionable[$value]))
				{
					$akta['fill_mention'][str_replace('.','-+',str_replace('@','', $value))] = $this->mentionable[$value];
					if(str_is('@pihak.*.ktp.*', $value))
					{
						$pihaks 		= str_replace('@', '', $value);
						$pihaks 		= explode('.', $pihaks);

						$pihak[$pihaks[1]][$pihaks[3]]	= $this->mentionable[$value];
					}
				}

			}
			foreach ($pihak as $key => $value) 
			{
				$new_pihak 				= Klien::where('nomor_ktp', $value['nomor_ktp'])->first();

				if(!$new_pihak)
				{
					$new_pihak 			= new Klien;
				}

				$new_pihak 				= $new_pihak->fill($value);
				$new_pihak->save();

				$new_pihak 				= $new_pihak->toArray();

				$akta['pemilik']['klien'][$key]['id'] 		= $new_pihak['id'];
				$akta['pemilik']['klien'][$key]['nama'] 	= $new_pihak['nama'];
			}

			//2b. akta mentionable
			if(in_array('@notaris.nama', $akta['mentionable']))
			{
				$akta['fill_mention']['notaris-+nama'] 					= $notaris['notaris']['nama'];
			}
			if(in_array('@notaris.daerah_kerja', $akta['mentionable']))
			{
				$akta['fill_mention']['notaris-+daerah_kerja'] 			= $notaris['notaris']['daerah_kerja'];
			}
			if(in_array('@notaris.nomor_sk', $akta['mentionable']))
			{
				$akta['fill_mention']['notaris-+nomor_sk'] 				= $notaris['notaris']['nomor_sk'];
			}
			if(in_array('@notaris.tanggal_pengangkatan', $akta['mentionable']))
			{
				$akta['fill_mention']['notaris-+tanggal_pengangkatan'] 	= $notaris['notaris']['tanggal_pengangkatan'];
			}
			if(in_array('@notaris.alamat', $akta['mentionable']))
			{
				$akta['fill_mention']['notaris-+alamat'] 				= $notaris['notaris']['alamat'];
			}
			if(in_array('@notaris.telepon', $akta['mentionable']))
			{
				$akta['fill_mention']['notaris-+telepon'] 				= $notaris['notaris']['telepon'];
			}

			$akta['paragraf']	= $this->isi_akta;
			$akta['status']		= 'dalam_proses';

			$dokumen 			= new Dokumen;
			$dokumen 			= $dokumen->fill($akta);
			$dokumen->save();

			//3. simpan jadwal pertemuan
			$jadwal 			= new Jadwal;
			$jadwal->fill([
					'judul'			=> 'Deadline '.$this->judul,
					'waktu'			=> $this->tanggal_pertemuan,
					'pembuat'		=> ['kantor' => ['id' => $activeOffice['kantor']['id'],'nama' => $activeOffice['kantor']['nama']]],
					// 'peserta'		=> $akta['pemilik']['klien'],
					'referensi_id'	=> $dokumen->_id,
				]);
			if(isset($akta['pemilik']['klien']))
			{
				$jadwal->peserta 	= $akta['pemilik']['klien'];
			}
			$jadwal 			= $jadwal->save();

			//4. simpan versi
			$versi 				= new Versi;
			$versi				= $versi->fill($akta);
			$versi->original_id	= $dokumen->_id;
			$versi->versi 		= 1;
			$versi->save();

			return $dokumen->toArray();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}