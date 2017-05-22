<?php

namespace App\Domain\Stat\Models;

use App\Infrastructure\Traits\GuidTrait;
use App\Infrastructure\Traits\TanggalTrait;

use Illuminate\Database\Eloquent\Model;

use Validator, Exception;

/**
 * Model KlienProgress
 *
 * Digunakan untuk menyimpan data alamat
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class KlienProgress extends Model
{
    protected $connection 			= 'mysql';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'klien_progress';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'klien_id'				,
											'akta_id'				,
											'template_id'			,
											'kantor_id'				,
											'completed_at'			,
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
	
	/**
	 * data hidden
	 *
	 * @var array
	 */
	protected $hidden				= 	[
											'created_at', 
											'updated_at', 
											'deleted_at', 
										];


	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/

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
			return $query->whereIn('kantor_id', $value);
		}

		return $query->where('kantor_id', $value);
	}

	public function scopeOngoing($query, $value, $group = 'akta_id')
	{
		return $query->selectRaw(\DB::raw('COUNT(*) as total'))->where('kantor_id', $value)->wherenull('completed_at')->groupby($group)->get();
	}

	public function scopeNewCustomer($query, $variable = 1)
	{
		return $query->selectRaw(\DB::raw('COUNT(*) as total'))->havingRaw('COUNT(*) <= '.$variable)->groupby('klien_id');
	}

	public function scopeReturningCustomer($query, $variable = 1)
	{
		return $query->selectRaw(\DB::raw('COUNT(*) as total'))->havingRaw('COUNT(*) > '.$variable)->groupby('klien_id');
	}
}
