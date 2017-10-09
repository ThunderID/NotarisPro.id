<?php

namespace Thunderlabid\Arsip\Listeners;

///////////////
// Exception //
///////////////
use Thunderlabid\Arsip\Exceptions\AppException;

///////////////
// Framework //
///////////////
use Hash;

class Saving
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle event
	 * @param  UserCreated $event [description]
	 * @return [type]             [description]
	 */
	public function handle($event)
	{
		$model = $event->data;

		$lists 			= [];
		foreach ($model->dokumen as $k => $v) {
			$lists[] 	= $v['jenis'];
		}
		$model->lists 	= $lists;

		if (!$model->is_savable) 
		{
			throw new AppException($model->errors, AppException::DATA_VALIDATION);
		}
	}
}