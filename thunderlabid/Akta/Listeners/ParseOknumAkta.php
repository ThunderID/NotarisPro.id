<?php

namespace Thunderlabid\Akta\Listeners;

///////////////
// Exception //
///////////////
use Thunderlabid\Akta\Exceptions\AppException;

use Thunderlabid\Arsip\Models\Arsip;

class ParseOknumAkta
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
		$model 			= $event->data;
		$model->pihak 	= $this->parse_pihak($model->data);
	}

	private function parse_pihak($data)
	{
		$new_data 	= [];
		$pihak 		= [];

		foreach ($data as $key => $value) {
			$key 		= explode('[dot]', $key);

			if(!str_is('notaris', $key[0]) && !str_is('akta', $key[0])){
				$owner	= Arsip::where('dokumen.id', $key[0])->first();
				if(!in_array($owner['_id'], $pihak)){
					$pihak[] 	= $owner['_id'];
					$new_data[]	= $owner['pemilik'];
				}
			}
		}

		return $new_data;
	}
}