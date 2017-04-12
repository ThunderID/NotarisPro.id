<?php

namespace TKredit\DokumenKunci\Services;

use TKredit\DokumenKunci\Models\DokumenKunci;
use TKredit\DokumenKunci\Models\AsetKendaraan_A as Value;

use DB, Exception;

/**
 * Service SimpanDokumenKunci
 *
 * Digunakan untuk menyimpan data alamat
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @package    TKredit
 * @subpackage DokumenKunci
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class SimpanDokumenKunci
{
	protected $value;
	protected $dokumen_kunci;

	function __construct($dokumen_kunci, $value)
	{
		$this->value 				= $value;
		$this->dokumen_kunci 		= $dokumen_kunci;
	}

	public function handle()
	{
		DB::beginTransaction();

		try
		{
			//1. simpan dokumen draft
			//1. simpan survey
			if(isset($this->dokumen_kunci['id']) && empty($this->dokumen_kunci['id']) && is_null($this->dokumen_kunci['id']))
			{
				$dokumen_kunci 		= DokumenKunci::findorfail($this->dokumen_kunci['id']);
			}
			else
			{
				$dokumen_kunci 		= new DokumenKunci;
			}
			
			$dokumen_kunci 			= $dokumen_kunci->fill($this->dokumen_kunci);
			$dokumen_kunci->save();

			DB::commit();
		}
		catch(Exception $e)
		{
			DB::rollback();

			throw $e;
		}

		return true;
	}
}
