<?php

namespace TKantor\Notaris\Models;

use TKantor\Infrastructures\Guid\GuidTrait;

use TKantor\UbiquitousLibraries\Datetimes\TanggalTrait;

use TKantor\Infrastructures\Models\BaseModel;

use Validator, Exception;

/**
 * Model Notaris
 *
 * Digunakan untuk menyimpan data alamat
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @package    TKantor
 * @subpackage Notaris
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class Notaris extends BaseModel
{
	use GuidTrait;
	use TanggalTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'kantor_notaris';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'_id'					,
											'nama'					,
											'notaris'				,
										];
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'nama'								=> 'required|max:255',
											'notaris.nama'						=> 'required|max:255',
											'notaris.daerah_kerja'				=> 'required|max:255',
											'notaris.nomor_sk'					=> 'required|max:255',
											'notaris.tanggal_pengangkatan '		=> 'date_format:"Y-m-d"',
											'notaris.alamat'					=> 'required|max:255',
											'notaris.telepon'					=> 'required|max:255',
											'notaris.fax'						=> 'max:255',
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

	protected $appends 				= ['id'];

	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/
	public function setNotarisAttribute($value)
	{
		$value['tanggal_pengangkatan'] 		= $this->formatDateFrom($value['tanggal_pengangkatan']);
		$this->attributes['notaris']		= $value;
	}

	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	
	public function getIdAttribute($value = NULL)
	{
		return $this->attributes['_id'];
	}

	public function getNotarisAttribute($value = NULL)
	{
		$value['tanggal_pengangkatan'] 		= $this->formatDateTo($value['tanggal_pengangkatan']);
		return $value;
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

	public function scopeNama($query, $value)
	{
		return $query->where('notaris.nama', 'like', '%'.$value.'%');
	}

	public function scopeKantor($query, $value)
	{
		if(is_array($value))
		{
			return $query->whereIn('kantor.id', $value);
		}

		return $query->where('kantor.id', $value);
	}
}
