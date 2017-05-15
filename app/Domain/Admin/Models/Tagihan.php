<?php

namespace App\Domain\Admin\Models;

use App\Infrastructure\Traits\GuidTrait;

use App\Infrastructure\Models\BaseModel;
use Hash, Validator, Exception;

/**
 * Model Tagihan
 *
 * Digunakan untuk menyimpan data nasabah.
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class Tagihan extends BaseModel
{
	use GuidTrait;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'admin_tagihan';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'_id'					,
											'bulan'					,
											'total'					,
											'is_paid'				,
											'kantor'				,
											'issued_at'				,
										];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'bulan'					=> 'required|numeric',
											'total'					=> 'numeric',
											'is_paid'				=> 'boolean',
										];
	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $dates				= ['created_at', 'updated_at', 'deleted_at', 'issued_at'];

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
