<?php

namespace App\Domain\Akta\Models;

use App\Infrastructure\Traits\GuidTrait;

use App\Infrastructure\Models\BaseModel;
use Hash, Validator, Exception;

/**
 * Model TipeDokumen
 *
 * Digunakan untuk menyimpan data nasabah.
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class TipeDokumen extends BaseModel
{
	use GuidTrait;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'akta_tipe_dokumen';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'_id'					,
											'jenis_dokumen'			,
											'isi'					,
											'kantor'				,
										];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
										];
	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $dates				= ['created_at', 'updated_at', 'deleted_at'];

	protected $appends 				= ['id'];

	protected $hidden				= ['created_at', 'updated_at', 'deleted_at', '_id'];

	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	public function getIdAttribute($value = NULL)
	{
		return $this->attributes['_id'];
	}

	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/

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

	public function scopeKantor($model, $variable)
	{
		if(is_array($variable))
		{
			return $model->whereIn('kantor.id', $variable);
		}
	
		return $model->where('kantor.id', $variable);
	}
}
