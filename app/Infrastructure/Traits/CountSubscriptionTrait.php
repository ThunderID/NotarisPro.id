<?php

namespace App\Infrastructure\Traits;

use Carbon\Carbon;

/**
 * @author     C Mooy <chelsymooy1108@gmail.com>
 */
trait CountSubscriptionTrait 
{
	private function hitungBiayaSubscribe(array $users, Carbon $since)
	{
		if($total_user <= 2)
		{
			return 500000;
		}
		elseif ($total_user <= 5) 
		{
			$additional 	= $total_user - 2;
			$bayar 			= 500000 + ($additional * 225000);
			return $bayar;
		}
		else 
		{
			$additional_1 	= $total_user - 5;

			$bayar 			= 500000 + (225000 * 3) + ($additional_1 * 200000);
			return $bayar;
		}
	}
}