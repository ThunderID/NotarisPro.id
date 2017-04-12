<?php

namespace TWeb;

use Illuminate\Support\ServiceProvider;

class WebServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the Web services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the Web services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
		$this->app->bind('TAuth', 'TQueries\ACL\SessionBasedAuthenticator');
	}
}
