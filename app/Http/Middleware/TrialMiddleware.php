<?php
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure, TAuth, Exception, Redirect, Carbon\Carbon, Session;

class TrialMiddleware
{
	public function handle($request, Closure $next)
	{
		$active_o	= TAuth::activeOffice();

		if($active_o['type']=='trial' && $active_o['expired_at'] < Carbon::now()->format('Y-m-d H:i:s'))
		{
			return Redirect::route('uac.tsignup.edit');
		}
		elseif($active_o['type']=='trial')
		{
			Session::put('msg_global', 'Akun trial Anda akan berakhir dalam '.Carbon::createfromFormat('Y-m-d H:i:s', $active_o['expired_at'])->diffInDays(Carbon::now()).' hari');
		}

		return $next($request);
	}
}