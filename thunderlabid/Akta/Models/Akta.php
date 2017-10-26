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
use Thunderlabid\Akta\Events\Akta\AktaCreated;
use Thunderlabid\Akta\Events\Akta\AktaCreating;
use Thunderlabid\Akta\Events\Akta\AktaUpdated;
use Thunderlabid\Akta\Events\Akta\AktaUpdating;
use Thunderlabid\Akta\Events\Akta\AktaDeleted;
use Thunderlabid\Akta\Events\Akta\AktaDeleting;
use Thunderlabid\Akta\Events\Akta\AktaRestored;
use Thunderlabid\Akta\Events\Akta\AktaRestoring;

class Akta extends Model
{
	protected $table 	= 'a_akta';
	protected $fillable = ['paragraf', 'versi', 'drafter', 'data', 'kantor', 'judul', 'jenis', 'status'];
	protected $hidden 	= [];
	// protected $appends	= ['is_savable', 'is_deletable'];

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
			event(new AktaCreated($collection));
		});

		static::creating(function ($collection) {
			event(new AktaCreating($collection));
		});

		static::updated(function ($collection) {
			event(new AktaUpdated($collection));
		});

		static::updating(function ($collection) {
			event(new AktaUpdating($collection));
		});

		static::deleted(function ($collection) {
			event(new AktaDeleted($collection));
		});

		static::deleting(function ($collection) {
			event(new AktaDeleting($collection));
		});

		// static::restoring(function ($collection) {
		// 	event(new AktaRestoring($collection));
		// });

		// static::restored(function ($collection) {
		// 	event(new AktaRestored($collection));
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
		$rules['paragraf'] 			= ['required', 'array'];

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
