<?php

namespace TJadwal\JadwalPertemuan\Models;

use TJadwal\Infrastructures\Guid\GuidTrait;

use TJadwal\UbiquitousLibraries\Datetimes\WaktuTrait;

use TJadwal\Infrastructures\Models\BaseModel;

use Validator, Exception;

/**
 * Model JadwalPertemuan
 *
 * Digunakan untuk menyimpan data alamat
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @package    TJadwal
 * @subpackage JadwalPertemuan
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class JadwalPertemuan extends BaseModel
{
	use GuidTrait;
	use WaktuTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'jadwal_pertemuan';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'_id'					,
											'judul'					,
											'waktu'					,
											'pembuat'				,
											'peserta'				,
											'tempat'				,
											'agenda'				,
										];
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'judul'					=> 'max:255',
											'waktu'					=> 'date_format:"Y-m-d H:i:s"',
											'pembuat.kantor.id'		=> 'required',
											'pembuat.kantor.nama'	=> 'required',
											'peserta.*.id'			=> 'required',
											'peserta.*.nama'		=> 'required',
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
	
	public function setWaktuAttribute($value)
	{
		$this->attributes['waktu'] = $this->formatDateTimeFrom($value);
	}

	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	
	public function getIdAttribute($value = NULL)
	{
		return $this->attributes['_id'];
	}
	
	public function getWaktuAttribute($value = NULL)
	{
		return $this->formatDateTimeTo($this->attributes['waktu']);
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

	public function scopeKantor($query, $value)
	{
		if(is_array($value))
		{
			return $query->whereIn('pembuat.kantor.id', $value);
		}

		return $query->where('pembuat.kantor.id', $value);
	}
}
