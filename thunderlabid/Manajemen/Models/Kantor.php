<?php

namespace Thunderlabid\Manajemen\Models;

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
use Thunderlabid\Manajemen\Exceptions\AppException;

////////////
// EVENTS //
////////////
use Thunderlabid\Manajemen\Events\Kantor\KantorCreated;
use Thunderlabid\Manajemen\Events\Kantor\KantorCreating;
use Thunderlabid\Manajemen\Events\Kantor\KantorUpdated;
use Thunderlabid\Manajemen\Events\Kantor\KantorUpdating;
use Thunderlabid\Manajemen\Events\Kantor\KantorDeleted;
use Thunderlabid\Manajemen\Events\Kantor\KantorDeleting;
use Thunderlabid\Manajemen\Events\Kantor\KantorRestored;
use Thunderlabid\Manajemen\Events\Kantor\KantorRestoring;

class Kantor extends Model
{
	protected $table 	= 'm_kantor';
	protected $fillable = ['nama'];
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
			event(new KantorCreated($collection));
		});

		static::creating(function ($collection) {
			event(new KantorCreating($collection));
		});

		static::updated(function ($collection) {
			event(new KantorUpdated($collection));
		});

		static::updating(function ($collection) {
			event(new KantorUpdating($collection));
		});

		static::deleted(function ($collection) {
			event(new KantorDeleted($collection));
		});

		static::deleting(function ($collection) {
			event(new KantorDeleting($collection));
		});

		// static::restoring(function ($collection) {
		// 	event(new KantorRestoring($collection));
		// });

		// static::restored(function ($collection) {
		// 	event(new KantorRestored($collection));
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
		$rules['nama'] 		= ['required'];

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
