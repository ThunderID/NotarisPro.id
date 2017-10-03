<?php

namespace Thunderlabid\Akta\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

use Validator;
use InvalidArgumentException;
use Exception;
use Hash;

///////////////
// Exception //
///////////////
use Thunderlabid\Akta\Exceptions\AppException;

////////////
// EVENTS //
////////////
use Thunderlabid\Akta\Events\Versi\VersiCreated;
use Thunderlabid\Akta\Events\Versi\VersiCreating;
use Thunderlabid\Akta\Events\Versi\VersiUpdated;
use Thunderlabid\Akta\Events\Versi\VersiUpdating;
use Thunderlabid\Akta\Events\Versi\VersiDeleted;
use Thunderlabid\Akta\Events\Versi\VersiDeleting;
use Thunderlabid\Akta\Events\Versi\VersiRestored;
use Thunderlabid\Akta\Events\Versi\VersiRestoring;

class Versi extends Model
{
	protected $table 	= 'a_';
	protected $fillable = ['paragraf', 'versi', 'drafter', 'data', 'notaris', 'judul', 'jenis', 'akta_id'];
	protected $hidden 	= [];
	protected $appends	= ['is_savable', 'is_deletable'];

	protected $rules	= [];
	protected $errors;

	// ------------------------------------------------------------------------------------------------------------
	// CONSTRUCT
	// ------------------------------------------------------------------------------------------------------------

	// ------------------------------------------------------------------------------------------------------------
	// BOOT
	// ------------------------------------------------------------------------------------------------------------
	
	// ------------------------------------------------------------------------------------------------------------
	// RELATION
	// ------------------------------------------------------------------------------------------------------------

	// ------------------------------------------------------------------------------------------------------------
	// FUNCTION
	// ------------------------------------------------------------------------------------------------------------
	public static function boot()
	{
		parent::boot();

		static::created(function ($collection) {
			event(new VersiCreated($collection));
		});

		static::creating(function ($collection) {
			event(new VersiCreating($collection));
		});

		static::updated(function ($collection) {
			event(new VersiUpdated($collection));
		});

		static::updating(function ($collection) {
			event(new VersiUpdating($collection));
		});

		static::deleted(function ($collection) {
			event(new VersiDeleted($collection));
		});

		static::deleting(function ($collection) {
			event(new VersiDeleting($collection));
		});

		// static::restoring(function ($collection) {
		// 	event(new VersiRestoring($collection));
		// });

		// static::restored(function ($collection) {
		// 	event(new VersiRestored($collection));
		// });
	}
	// ------------------------------------------------------------------------------------------------------------
	// SCOPE
	// ------------------------------------------------------------------------------------------------------------

	// ------------------------------------------------------------------------------------------------------------
	// MUTATOR
	// ------------------------------------------------------------------------------------------------------------

	// ------------------------------------------------------------------------------------------------------------
	// ACCESSOR
	// ------------------------------------------------------------------------------------------------------------

	public function getIsDeletableAttribute()
	{
		return true;
	}

	public function getIsSavableAttribute()
	{
		//////////////////
		// Create Rules //
		//////////////////
		$rules['paragraf'] 			= ['required', 'integer'];

		//////////////
		// Validate //
		//////////////
		$validator = Validator::make($this->attributes, $rules);
		if ($validator->fails())
		{
			$this->errors = $validator->messages();
			return false;
		}
		
		return true;
	}

	public function getErrorsAttribute()
	{
		return $this->errors;
	}
}
