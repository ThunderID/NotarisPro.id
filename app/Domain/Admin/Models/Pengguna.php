<?php

namespace App\Domain\Admin\Models;

use App\Infrastructure\Traits\GuidTrait;

use App\Infrastructure\Models\BaseModel;
use Hash, Validator, Exception;

/**
 * Model Pengguna
 *
 * Digunakan untuk menyimpan data nasabah.
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class Pengguna extends BaseModel
{
	use GuidTrait;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'immigration_pengguna';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'_id'					,
											'email'					,
											'password'				,
											'nama'					,
											'visas'					,
											'reset_token'			,
										];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'email'					=> 'required|email',
											'password'				=> 'min:6',
											'nama'					=> 'max:255',
											'visas.*.type'			=> 'max:255',
											'visas.*.expired_at'	=> 'max:255',
											'visas.*.started_at'	=> 'max:255',
											'visas.*.role'			=> 'max:255',
											'visas.*.kantor.id'		=> 'max:255',
											'visas.*.kantor.nama'	=> 'max:255',
										];
	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $dates				= ['created_at', 'updated_at', 'deleted_at'];

	protected $appends 				= ['id'];

	protected $hidden				= ['created_at', 'updated_at', 'deleted_at'];

	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	public function getIdAttribute($value = NULL)
	{
		return $this->attributes['_id'];
	}

	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/
	protected function setPasswordAttribute($value)
	{
		if(Hash::needsRehash($value))
		{
			$value 					= Hash::make($value);
		}

		$this->attributes['password'] = $value;
	}

	protected function setEmailAttribute($value)
	{
		$exists 					= Pengguna::email($value)->notid($this->id)->first();
		if($exists)
		{
			throw new Exception("Duplikasi email", 1);
		}

		$this->attributes['email'] 	= $value;
	}
	
	/* ---------------------------------------------------------------------------- FUNCTIONS ----------------------------------------------------------------------------*/

	public function grantVisa($visa)
	{
		//1. validating visa
		//1a. Validating if visa contain valid variable
		$rules 						= [
			'kantor.id'		=> 'required|max:255',
			'kantor.nama'	=> 'required|max:255',
			'role'			=> 'required|max:255',
		];
		$validator			= Validator::make($visa, $rules);
		if(!$validator->passes())
		{
			throw new Exception($validator->messages()->toJson(), 1);
		}

		//2. parse visa id
		$visa['id']			= $this->createID(null);

		//3. simpan visa
		$this->attributes['visas'][]	= $visa;

		//it's a must to return value
		return $this;
	}

	public function removeVisa($visa_id)
	{
		foreach ($this->visas as $key => $value) 
		{
			if(str_is($value['id'], $visa_id))
			{
				unset($this->attributes['visas'][$key]);
			}
		}

		return $this;
	}

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

	public function scopeEmail($model, $variable)
	{
		return $model->where('email', $variable);
	}

	public function scopeKantor($model, $variable)
	{
		if(is_array($variable))
		{
			return $model->whereIn('visas.kantor.id', $variable);
		}
	
		return $model->where('visas.kantor.id', $variable);
	}
}
