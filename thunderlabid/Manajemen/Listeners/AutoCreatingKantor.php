<?php

namespace Thunderlabid\Manajemen\Listeners;

///////////////
// Exception //
///////////////
use Thunderlabid\Manajemen\Exceptions\AppException;

///////////////
//   MODELS  //
///////////////
use Thunderlabid\Manajemen\Models\Kantor;

class AutoCreatingKantor
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
	 * @param  UserCreating $event [description]
	 * @return [type]             [description]
	 */
	public function handle($event)
	{
		$model 	= $event->data;

		$kantor	= Kantor::where('id', $model->access['kantor']['id'])->first();

		if(!$kantor)
		{
			$kantor 		= new Kantor;
			$kantor->nama 	= $model->access['kantor']['nama'];
			$kantor->save();
		}

		$access 	= $model->access;
		$access['kantor']['id']		= $kantor['id'];
		$access['kantor']['nama']	= $kantor['nama'];
		$model->access				= $access;
	}
}