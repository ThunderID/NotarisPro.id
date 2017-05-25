<?php

namespace App\Listeners;

use App\Events\UserLogged;

use App\Domain\Stat\Models\UserAttendance;
use Carbon\Carbon;

class UpdateUserAttendance
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
	 * @param  UserLogged  $user
	 * @return void
	 */
	public function handle(UserLogged $user)
	{
		$now 		= Carbon::now();
		$now_start 	= Carbon::now()->startOfDay();
		$now_end 	= Carbon::now()->endOfDay();

		$klien						= UserAttendance::where('pengguna_id', $user->user['id'])->where('jam_masuk', '>=', $now_start->format('Y-m-d H:i:s'))->where('jam_masuk', '<=', $now_end->format('Y-m-d H:i:s'))->kantor($user->user['visas'][0]['kantor']['id'])->first();

		if(!$klien)
		{
			$klien					= new UserAttendance;
			$klien->pengguna_id		= $user->user['id'];
			$klien->kantor_id		= $user->user['visas'][0]['kantor']['id'];
			$klien->jam_masuk		= $now->format('Y-m-d H:i:s');
			$klien->jam_keluar		= $now->format('Y-m-d H:i:s');
			$klien->save();
		}
		else
		{
			$klien->jam_keluar 		= max($klien->jam_keluar, $now->format('Y-m-d H:i:s'));
		}

		$klien->save();

		return true;
	}
}

