<?php
namespace App\Http\Middleware;

use Closure, TAuth, Exception;
use Illuminate\Http\Request;

class AuthenticatedMiddleware
{
	public function handle($request, Closure $next)
	{
		// $credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];
		// $login 			= TAuth::login($credentials);
		
		try 
		{
			TAuth::isLogged();
		} 
		catch (Exception $e) 
		{
			if(is_array($e->getMessage()))
			{
				return redirect(route('uac.login'))->with('msg', ['danger' => $e->getMessage()]);
			}
			else
			{
				return redirect(route('uac.login'))->with('msg', ['danger' => [$e->getMessage()]]);
			}
		}

		return $next($request);
	}
}