<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Versi;
use App\Domain\Akta\Models\Dokumen;

use App\Domain\Order\Models\Klien;
use App\Domain\Order\Models\Jadwal;

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
	public function __construct($klien_id, $klien_nama, $klien_telepon, $tanggal_pertemuan, $judul, array $isi_akta, array $mentionable, $template_id)
	{
		$this->klien_id				= $klien_id;
		$this->klien_nama			= $klien_nama;
		$this->klien_telepon		= $klien_telepon;
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

			//1. simpan klien
			if(is_null($this->klien_id))
			{
				$klien 			= new Klien;
			}
			else
			{
				$klien 			= Klien::find($this->klien_id);
			}

			$klien->fill(['nama' => $this->klien_nama, 'kantor' => ['id' => $activeOffice['kantor']['id'], 'nama' => $activeOffice['kantor']['nama'], 'telepon' => $this->klien_telepon]]);
			$klien->save();

			//2. simpan akta
			$call				= new DaftarTemplateAkta;
			$template			= $call->detailed($this->template_id);

			$akta['pemilik']['orang'][0]['id'] 		= $loggedUser['id'];
			$akta['pemilik']['orang'][0]['nama'] 	= $loggedUser['nama'];

			$akta['pemilik']['kantor']['id'] 		= $activeOffice['kantor']['id'];
			$akta['pemilik']['kantor']['nama'] 		= $activeOffice['kantor']['nama'];

			$akta['pemilik']['klien']['id'] 		= $klien['id'];
			$akta['pemilik']['klien']['nama'] 		= $klien['nama'];
			$akta['pemilik']['klien']['telepon'] 	= $klien['telepon'];

			$akta['penulis']['id'] 					= $loggedUser['id'];
			$akta['penulis']['nama'] 				= $loggedUser['nama'];

			$akta['mentionable']					= $template['mentionable'];
			$akta['judul']							= $this->judul;

			$akta['jumlah_pihak']					= $template['jumlah_pihak'];
			$akta['dokumen_objek']					= $template['dokumen_objek'];
			$akta['dokumen_pihak']					= $template['dokumen_pihak'];
			$akta['dokumen_saksi']					= $template['dokumen_saksi'];

			foreach($akta['mentionable'] as $key => $value)
			{
				if(isset($this->mentionable[$value]))
				{
					$akta['fill_mention'][str_replace('.','-+',str_replace('@','', $value))] = $this->mentionable[$value];
				}
			}

			$akta['paragraf']	= $this->isi_akta;
			$akta['status']		= 'draft';

			$dokumen 			= new Dokumen;
			$dokumen 			= $dokumen->fill($akta);
			$dokumen->save();

			//3. simpan jadwal pertemuan
			$jadwal 			= new Jadwal;
			$jadwal->fill([
					'judul'			=> 'Deadline '.$this->judul,
					'waktu'			=> $this->tanggal_pertemuan,
					'pembuat'		=> ['kantor' => ['id' => $activeOffice['kantor']['id'],'nama' => $activeOffice['kantor']['nama']]],
					'peserta'		=> [['id' => $klien->id,'nama' => $klien->nama]],
					'referensi_id'	=> $dokumen->_id,
				]);
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