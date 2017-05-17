<?php

namespace App\Domain\Order\Models;

use App\Infrastructure\Traits\GuidTrait;
use App\Infrastructure\Traits\TanggalTrait;

use App\Infrastructure\Models\BaseModel;

use Validator, Exception;

/**
 * Model Klien
 *
 * Digunakan untuk menyimpan data alamat
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class Klien extends BaseModel
{
	use GuidTrait;
	use TanggalTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'notaris_klien';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'_id'					,
											'nama'					,
											'telepon'				,
											'tempat_lahir'			,
											'tanggal_lahir'			,
											'pekerjaan'				,
											'alamat'				,
											'nomor_ktp'				,
											'kantor'				,
										];
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'nama'					=> 'max:255',
											'tempat_lahir'			=> 'max:255',
											// 'tanggal_lahir'			=> 'date_format:"Y-m-d"',
											'pekerjaan'				=> 'max:255',
											'alamat.alamat'			=> 'max:255',
											'alamat.rt'				=> 'max:255',
											'alamat.rw'				=> 'max:255',
											'alamat.desa'			=> 'max:255',
											'alamat.distrik'		=> 'max:255',
											'alamat.regensi'		=> 'max:255',
											'alamat.provinsi'		=> 'max:255',
											'alamat.negara'			=> 'max:255',
											'nomor_ktp'				=> 'max:255',
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
	public function setTanggalLahirAttribute($value)
	{
		$this->attributes['tanggal_lahir'] = $this->formatDateFrom($value);
	}

	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	
	public function getIdAttribute($value = NULL)
	{
		return $this->attributes['_id'];
	}

	public function getTanggalLahirAttribute($value = NULL)
	{
		return $this->formatCarbonDateTo($this->attributes['tanggal_lahir']);
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
