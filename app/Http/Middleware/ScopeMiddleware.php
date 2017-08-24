<?php
namespace App\Http\Middleware;

use Closure, TAuth, Exception;
use Illuminate\Http\Request;

class ScopeMiddleware
{
	public function handle($request, Closure $next, $scope)
	{
		$active_o	= TAuth::activeOffice();
		$scopes		= explode(',', $active_o['scopes']);

		if(in_array($scope, $scopes))
		{
			return $next($request);
		}

		throw new Exception("404", 404);
	}
}