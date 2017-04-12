<?php

namespace TAkta\DokumenKunci\Models;

use TAkta\Infrastructures\Guid\GuidTrait;

use TAkta\UbiquitousLibraries\Datetimes\TanggalTrait;

use TAkta\Infrastructures\Models\BaseModel;

use Validator, Exception;

/**
 * Model DokumenKunci
 *
 * Digunakan untuk menyimpan data alamat
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @package    TAkta
 * @subpackage DokumenKunci
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class Dokumen extends BaseModel
{
	use GuidTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'akta_dokumen';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'_id'					,
											'judul'					,
											'paragraf'				,
											'status'				,
											// 'versi'					,
											'pemilik'				,
											'penulis'				,
										];
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'judul'					=> 'required',
											'paragraf.*.konten'		=> 'required',
											'paragraf.*.lock'		=> 'max:255',
											// 'paragraf.*.key'		=> 'max:255',
											// 'paragraf.*.padlock'	=> 'max:255',
											'status'				=> 'in:draft,pengajuan,renvoi,akta,minuta'
										];
	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $dates				= ['created_at', 'updated_at', 'deleted_at'];
	
	/**
	 * data hidden
	 *
	 * @var array
	 */
	protected $hidden				= 	[
											'_id',
											'created_at', 
											'updated_at', 
											'deleted_at', 
										];

	protected $appends 				= ['id', 'tanggal'];

	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	
	public function getIdAttribute($value = NULL)
	{
		return $this->attributes['_id'];
	}
	
	public function getTanggalAttribute($value = NULL)
	{
		return $this->formatDateTo($this->attributes['created_at']);
	}

	/* ---------------------------------------------------------------------------- FUNCTIONS ----------------------------------------------------------------------------*/

	/**
	 * boot
	 * observing model
	 *
	 */	
	public static function boot() 
	{
		parent::boot();
	}

	/* ---------------------------------------------------------------------------- SCOPES ----------------------------------------------------------------------------*/
}
