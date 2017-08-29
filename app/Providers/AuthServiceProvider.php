<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Policies\ReadAkta;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		// 'App\Service' => 'App\Policies\ServicePolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();

		//
	}

	// public function registerPolicies()
	// {
	// 	Gate::define('read_akta', function (ReadAkta $akta) {
	// 		return $akta->hasAccess(['read_akta']);
	// 	});
	// }
}
