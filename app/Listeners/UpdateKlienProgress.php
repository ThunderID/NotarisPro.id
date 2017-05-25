<?php

namespace App\Listeners;

use App\Events\AktaUpdated;

use App\Domain\Stat\Models\KlienProgress;
use Carbon\Carbon;

class UpdateKlienProgress
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
	 * Handle the event.
	 *
	 * @param  AktaUpdated  $akta
	 * @return void
	 */
	public function handle(AktaUpdated $akta)
	{
		if(in_array($akta->akta['status'], ['dalam_proses', 'draft', 'renvoi']) && isset($akta->akta['pemilik']['klien']))
		{
			foreach ($akta->akta['pemilik']['klien'] as $key => $value) 
			{
				$klien						= KlienProgress::where('klien_id', $value['id'])->where('akta_id', $akta->akta['id'])->where('kantor_id', $akta->akta['pemilik']['kantor']['id'])->first();

				if(!$klien)
				{
					$klienz					= new KlienProgress;
					$klienz->klien_id		= $value['id'];
					$klienz->akta_id		= $akta->akta['id'];
					$klienz->template_id	= $akta->akta['template']['id'];
					$klienz->kantor_id		= $akta->akta['pemilik']['kantor']['id'];
					$klienz->penulis_id		= $akta->akta['penulis']['id'];
					$klienz->save();
				}

			}
		}

		if(in_array($akta->akta['status'], ['akta']))
		{
			$kliens	= KlienProgress::where('akta_id', $akta->akta['id'])->where('kantor_id', $akta->akta['pemilik']['kantor']['id'])->get();

			foreach ($kliens as $key => $value) 
			{
				$value->completed_at 		= Carbon::now()->format('Y-m-d H:i:s');
				$value->save();
			}

		}

		return true;
	}
}

