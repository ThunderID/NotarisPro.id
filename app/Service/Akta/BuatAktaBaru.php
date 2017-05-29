<?php

namespace App\Service\Akta;

use App\Domain\Akta\Models\Versi;
use App\Domain\Akta\Models\Dokumen;

use App\Domain\Order\Models\Klien;

use App\Domain\Admin\Models\Kantor;

use App\Service\Akta\Traits\EnhanceKlienTrait;

use App\Events\AktaUpdated;

use Exception, TAuth, Carbon\Carbon;

/**
 * Service untuk membuat akta baru
 *
 * Auth : 
 * 	1. Siapa pun yang teregistrasi dalam sistem @authorize
 * Policy : 
 * 	1. Restorasi Isi Paragraf @restorasi_isi_akta
 * 	2. Restorasi Data mention @restorasi_isi_mentionable
 * 	3. Validate template @validasi_template
 * Smart System : 
 * 	1. Auto Assign Writer @assign_writer
 * 	2. Auto Assign Owner @assign_owner
 * 	3. Auto fill mentionable notaris @fill_mention_notaris
 * 	4. parse mentionable @parse_mentionable
 * 	5. Update data klien @enhance_klien
 * 	6. Watermarking @watermarking
 * 	7. Versioning @versioning
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class BuatAktaBaru
{
	use EnhanceKlienTrait;

	public $daftar_akta;
	
	protected $judul;
	protected $isi_akta;
	protected $mentionable;
	protected $template_id;

	private $activeOffice;
	private $loggedUser;
	private $notaris;
	private $template;
	private $pihak;

	/**
	 * Create new instance.
	 *
	 * @param  string $judul
	 * @param  string $deskripsi
	 * @param  array $isi_akta
	 * @param  array $mentionable
	 * @param  string $template_id
	 * @return BuatAktaBaru $akta
	 */
	public function __construct($judul, array $isi_akta, array $mentionable, $template_id)
	{
		$this->judul			= $judul;
		$this->isi_akta			= $isi_akta;
		$this->mentionable		= $mentionable;
		$this->template_id		= $template_id;
	}

	/**
	 * Simpan akta baru
	 *
	 * @return array $akta
	 */
	public function save()
	{
		try
		{
			// Auth : 
		 	// 1. Siapa pun yang teregistrasi dalam sistem @authorize
			$this->authorize();

			// Policy : 
		 	// 1. Restorasi Isi Paragraf @restorasi_isi_akta
		 	$variable['paragraf']		= $this->restorasi_isi_akta();

		 	// 2. Restorasi Data mention @restorasi_isi_mentionable
		 	$variable['mentionable']	= $this->restorasi_isi_mentionable();

		 	// 3. Validate template @validasi_template
		 	$this->validasi_template();

			// Smart System : 
			// 1. Auto Assign Writer @assign_writer
			$variable['penulis'] 		= $this->assign_writer();

		 	// 2. Auto Assign Owner @assign_owner
			$variable['pemilik'] 		= $this->assign_owner();

		 	// 3. Parse mentionable untuk mentionable @parse_mentionable
			$variable['fill_mention'] 	= $this->parse_mentionable();

		 	// 4. auto fill mentionable notaris @fill_mention_notaris
			$variable['fill_mention'] 	= array_merge($variable['fill_mention'], $this->fill_mention_notaris());

			// 5. enhance klien @enhance_klien
			$variable['pemilik'] 		= array_merge($variable['pemilik'], $this->enhance_klien($this->pihak));

		 	// 6. Watermarking @watermarking
			$variable['watermarking']	= $this->watermarking();

			// STORE
			//1. init akta
			$akta 						= new Dokumen;

			//2. parse variable
			$variable['mentionable']	= $this->template['mentionable'];
			$variable['judul']			= $this->judul;

			$variable['jumlah_pihak']	= $this->template['jumlah_pihak'];
			$variable['jumlah_saksi']	= $this->template['jumlah_saksi'];
			$variable['dokumen_objek']	= $this->template['dokumen_objek'];
			$variable['dokumen_pihak']	= $this->template['dokumen_pihak'];
			$variable['dokumen_saksi']	= $this->template['dokumen_saksi'];
			$variable['total_perubahan']= 0;
			
			$variable['template']['id']	= $this->template_id;

			//3. simpan value yang ada
			$akta						= $akta->fill($variable);

			//4. set status akta
			$akta->status 				= 'dalam_proses';
			$akta->riwayat_status		= [['status' => 'dalam_proses', 'tanggal' => Carbon::now()->format('Y-m-d H:i:s'), 'petugas' => ['id' => $this->loggedUser['id'], 'nama' => $this->loggedUser['nama']]]];

			//5. simpan akta
			$akta->save();

		 	// 7. versioning
			$this->versioning($akta->_id, $variable);

			$daftar_akta 				= new DaftarAkta;
			$daftar_akta 				= $daftar_akta->detailed($akta->_id);

			event(new AktaUpdated($daftar_akta));
			
			$this->daftar_akta 			= $daftar_akta;

			return $daftar_akta;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

	/**
	 * Authorization user
	 *
	 * MELALUI HTTP
	 * 1. User harus login
	 *
	 * MELALUI CONSOLE
	 * belum ada
	 *
	 * @return Exception 'Invalid User'
	 * @return boolean true
	 */
	private function authorize()
	{
		//MELALUI HTTP

		//demi menghemat resource
		$this->activeOffice 	= TAuth::activeOffice();
		$this->loggedUser 		= TAuth::loggedUser();
		$this->notaris 			= Kantor::find($this->activeOffice['kantor']['id']);

		return true;
	
		//MELALUI CONSOLE
	}

	/**
	 * Validasi Judul
	 *
	 * 1. Judul harus unique
	 *
	 * @return Exception 'Judul sudah pernah dipakai'
	 * @return boolean true
	 */
	private function validasi_template()
	{
		$this->template	= new DaftarTemplateAkta;;
		$this->template = $this->template->detailed($this->template_id);

		return true;
	}

	/**
	 * restorasi isi akta
	 *
	 * @return array $isi_akta
	 */
	private function restorasi_isi_akta()
	{
		return $this->isi_akta;
	}

	/**
	 * restorasi isi mentionable
	 *
	 * @return array $mentionable
	 */
	private function restorasi_isi_mentionable()
	{
		return $this->mentionable;
	}

	/**
	 * assign writer
	 *
	 * @return array $writer
	 */
	private function assign_writer()
	{
		$akta['penulis']['id'] 					= $this->loggedUser['id'];
		$akta['penulis']['nama'] 				= $this->loggedUser['nama'];

		return $akta['penulis'];
	}

	/**
	 * assign owner
	 *
	 * @return array $owner
	 */
	private function assign_owner()
	{
		$akta['pemilik']['orang'][0]['id'] 		= $this->loggedUser['id'];
		$akta['pemilik']['orang'][0]['nama'] 	= $this->loggedUser['nama'];

		$akta['pemilik']['kantor']['id'] 		= $this->activeOffice['kantor']['id'];
		$akta['pemilik']['kantor']['nama'] 		= $this->activeOffice['kantor']['nama'];

		return $akta['pemilik'];
	}

	/**
	 * fill mention notaris
	 * learn new type of document
	 *
	 * @return array $tag
	 */
	private function fill_mention_notaris()
	{
		$akta['fill_mention']		= [];

		if(in_array('@notaris.nama', $this->template['mentionable']))
		{
			$akta['fill_mention']['notaris-+nama'] 					= $this->notaris['notaris']['nama'];
		}
		if(in_array('@notaris.daerah_kerja', $this->template['mentionable']))
		{
			$akta['fill_mention']['notaris-+daerah_kerja'] 			= $this->notaris['notaris']['daerah_kerja'];
		}
		if(in_array('@notaris.nomor_sk', $this->template['mentionable']))
		{
			$akta['fill_mention']['notaris-+nomor_sk'] 				= $this->notaris['notaris']['nomor_sk'];
		}
		if(in_array('@notaris.tanggal_pengangkatan', $this->template['mentionable']))
		{
			$akta['fill_mention']['notaris-+tanggal_pengangkatan'] 	= $this->notaris['notaris']['tanggal_pengangkatan'];
		}
		if(in_array('@notaris.alamat', $this->template['mentionable']))
		{
			$akta['fill_mention']['notaris-+alamat'] 				= $this->notaris['notaris']['alamat'];
		}
		if(in_array('@notaris.telepon', $this->template['mentionable']))
		{
			$akta['fill_mention']['notaris-+telepon'] 				= $this->notaris['notaris']['telepon'];
		}

		return $akta['fill_mention'];
	}

	/**
	 * parse mentionable 
	 *
	 * @return array $tag
	 */
	private function parse_mentionable()
	{
		$akta['fill_mention']		= [];

		foreach($this->template['mentionable'] as $key => $value)
		{
			if(isset($this->mentionable[$value]))
			{
				$akta['fill_mention'][str_replace('.','-+',str_replace('@','', $value))] = $this->mentionable[$value];

				//here is how we defining data from people
				if(str_is('@pihak.*.ktp.*', $value))
				{
					$pihaks 		= str_replace('@', '', $value);
					$pihaks 		= explode('.', $pihaks);

					$this->pihak[$pihaks[1]]['tipe']		= 'perorangan';
					$this->pihak[$pihaks[1]]['ktp'][$pihaks[3]]				= $this->mentionable[$value];
				}
				elseif(str_is('@pihak.*.akta_pendirian.*', $value))
				{
					$pihaks 		= str_replace('@', '', $value);
					$pihaks 		= explode('.', $pihaks);

					$this->pihak[$pihaks[1]]['tipe']		= 'perusahaan';
					$this->pihak[$pihaks[1]]['akta_pendirian'][$pihaks[3]]	= $this->mentionable[$value];
				}
				elseif(str_is('@pihak.*', $value))
				{
					$pihaks 		= str_replace('@', '', $value);
					$pihaks 		= explode('.', $pihaks);

					$this->pihak[$pihaks[1]]['dokumen'][$pihaks[2]][$pihaks[3]]	= $this->mentionable[$value];
				}

			}
		}

		return $akta['fill_mention'];
	}


	/**
	 * fungsi untuk watermarking data
	 *
	 * @return string watermark
	 */
	private function watermarking()
	{
		return env('APP_WATERMARK', 'APP_WATERMARK');
	}

	/**
	 * fungsi untuk versioning data
	 *
	 * @return boolean true
	 */
	private function versioning($id, $akta)
	{
		$versi 				= new Versi;
		$versi				= $versi->fill($akta);
		$versi->original_id	= $id;
		$versi->versi 		= 1;
		$versi->save();

		return true;
	}
}