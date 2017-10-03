<?php

namespace Thunderlabid\Manajemen\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;

use Validator;
use InvalidArgumentException;
use Exception;
use Hash;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

///////////////
// Exception //
///////////////
use Thunderlabid\Manajemen\Exceptions\AppException;

////////////
// EVENTS //
////////////
use Thunderlabid\Manajemen\Events\User\UserCreated;
use Thunderlabid\Manajemen\Events\User\UserCreating;
use Thunderlabid\Manajemen\Events\User\UserUpdated;
use Thunderlabid\Manajemen\Events\User\UserUpdating;
use Thunderlabid\Manajemen\Events\User\UserDeleted;
use Thunderlabid\Manajemen\Events\User\UserDeleting;
use Thunderlabid\Manajemen\Events\User\UserRestored;
use Thunderlabid\Manajemen\Events\User\UserRestoring;

class User extends Model
{
	protected $table 	= 'm_user';
	protected $fillable = ['email', 'password', 'nama', 'access'];
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
			event(new UserCreated($collection));
		});

		static::creating(function ($collection) {
			event(new UserCreating($collection));
		});

		static::updated(function ($collection) {
			event(new UserUpdated($collection));
		});

		static::updating(function ($collection) {
			event(new UserUpdating($collection));
		});

		static::deleted(function ($collection) {
			event(new UserDeleted($collection));
		});

		static::deleting(function ($collection) {
			event(new UserDeleting($collection));
		});

		// static::restoring(function ($collection) {
		// 	event(new UserRestoring($collection));
		// });

		// static::restored(function ($collection) {
		// 	event(new UserRestored($collection));
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
		$rules['email'] 				= ['required', 'email'];
		$rules['password'] 				= ['max:255'];
		$rules['nama'] 					= ['max:255'];
		$rules['access.kantor.id'] 		= ['required'];
		$rules['access.kantor.nama'] 	= ['required'];
		$rules['access.role'] 			= ['required', 'in:drafter,notaris'];
		$rules['access.scopes'] 		= ['required'];

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
