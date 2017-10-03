<?php

namespace Thunderlabid\Arsip;

use Illuminate\Support\ServiceProvider;
use Event;

class ArsipServiceProvider extends ServiceProvider
{
	public function boot()
	{
		////////////////
		// Validation //
		////////////////
		Event::listen('Thunderlabid\Arsip\Events\Arsip\ArsipCreating', 'Thunderlabid\Arsip\Listeners\Saving');
		Event::listen('Thunderlabid\Arsip\Events\Arsip\ArsipUpdating', 'Thunderlabid\Arsip\Listeners\Saving');
		Event::listen('Thunderlabid\Arsip\Events\Arsip\ArsipDeleting', 'Thunderlabid\Arsip\Listeners\Deleting');
	}

	public function register()
	{
		
	}
}