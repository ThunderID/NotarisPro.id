<?php

namespace App\Domain\Order\Models;

use App\Infrastructure\Traits\GuidTrait;
use App\Infrastructure\Traits\TanggalTrait;

use App\Infrastructure\Models\BaseModel;

use Validator, Exception;

/**
 * Model Entity
 *
 * Digunakan untuk menyimpan data alamat
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class Entity extends BaseModel
{
	use GuidTrait;
	use TanggalTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'notaris_entity';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'_id'					,
											'type'					,
											'dokumen'				,
											'relasi'				,
										];
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'type'					=> 'required|max:255',
											'dokumen.*'				=> 'required',
											'relasi.*'				=> 'required',
										];

	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $dates				= ['created_at', 'updated_at', 'deleted_at', 'tanggal_lahir'];
	
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

	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	
	public function getIdAttribute($value = NULL)
	{
		return $this->attributes['_id'];
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

	public function tambahKTP($parameter)
	{
		$required 	= 	[
							'nik' 				=> 'required|max:255',
							'nama'				=> 'required|max:255',
							'tempat_lahir'		=> 'required|max:255',
							'tanggal_lahir'		=> 'required|max:255',
							'jenis_kelamin' 	=> 'required|max:255',
							'status_pernikahan'	=> 'required|max:255',
							'pekerjaan'			=> 'required|max:255',
							'kewarganegaraan'	=> 'required|max:255',
						]
	}

	public function tambahKTP($parameter)
	{
		$required 	= 	[
							'nik' 				=> 'required|max:255',
							'nama'				=> 'required|max:255',
							'tempat_lahir'		=> 'required|max:255',
							'tanggal_lahir'		=> 'required|max:255',
							'jenis_kelamin' 	=> 'required|max:255',
							'status_pernikahan'	=> 'required|max:255',
							'pekerjaan'			=> 'required|max:255',
							'kewarganegaraan'	=> 'required|max:255',
						]
	}
	
	/* ---------------------------------------------------------------------------- SCOPES ----------------------------------------------------------------------------*/

	public function scopeNama($query, $value)
	{
		return $query->where('nama', 'like', '%'.$value.'%');
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
