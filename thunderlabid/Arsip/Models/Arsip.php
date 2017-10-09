<?php

namespace Thunderlabid\Arsip\Models;

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
use Thunderlabid\Arsip\Exceptions\AppException;

////////////
// EVENTS //
////////////
use Thunderlabid\Arsip\Events\Arsip\ArsipCreated;
use Thunderlabid\Arsip\Events\Arsip\ArsipCreating;
use Thunderlabid\Arsip\Events\Arsip\ArsipUpdated;
use Thunderlabid\Arsip\Events\Arsip\ArsipUpdating;
use Thunderlabid\Arsip\Events\Arsip\ArsipDeleted;
use Thunderlabid\Arsip\Events\Arsip\ArsipDeleting;
use Thunderlabid\Arsip\Events\Arsip\ArsipRestored;
use Thunderlabid\Arsip\Events\Arsip\ArsipRestoring;

class Arsip extends Model
{
	protected $table 	= 'ar_arsip';
	protected $fillable = ['pemilik', 'kantor', 'dokumen', 'lists'];
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
			event(new ArsipCreated($collection));
		});

		static::creating(function ($collection) {
			event(new ArsipCreating($collection));
		});

		static::updated(function ($collection) {
			event(new ArsipUpdated($collection));
		});

		static::updating(function ($collection) {
			event(new ArsipUpdating($collection));
		});

		static::deleted(function ($collection) {
			event(new ArsipDeleted($collection));
		});

		static::deleting(function ($collection) {
			event(new ArsipDeleting($collection));
		});

		// static::restoring(function ($collection) {
		// 	event(new ArsipRestoring($collection));
		// });

		// static::restored(function ($collection) {
		// 	event(new ArsipRestored($collection));
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
		return true;
		//////////////////
		// Create Rules //
		//////////////////
		$rules['dokumen'] 			= ['required', 'array'];

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
