<?php

namespace Thunderlabid\Akta;

use Illuminate\Support\ServiceProvider;
use Event;

class AktaServiceProvider extends ServiceProvider
{
	public function boot()
	{
		////////////////
		// Parse Text //
		////////////////
		Event::listen('Thunderlabid\Akta\Events\Akta\AktaCreating', 'Thunderlabid\Akta\Listeners\ParseDataAkta');
		Event::listen('Thunderlabid\Akta\Events\Akta\AktaUpdating', 'Thunderlabid\Akta\Listeners\ParseDataAkta');
		Event::listen('Thunderlabid\Akta\Events\Akta\AktaCreating', 'Thunderlabid\Akta\Listeners\ParseTextParagraf');
		Event::listen('Thunderlabid\Akta\Events\Akta\AktaUpdating', 'Thunderlabid\Akta\Listeners\ParseTextParagraf');

		////////////////
		// Validation //
		////////////////
		Event::listen('Thunderlabid\Akta\Events\Akta\AktaCreating', 'Thunderlabid\Akta\Listeners\Saving');
		Event::listen('Thunderlabid\Akta\Events\Akta\AktaUpdating', 'Thunderlabid\Akta\Listeners\Saving');
		Event::listen('Thunderlabid\Akta\Events\Akta\AktaDeleting', 'Thunderlabid\Akta\Listeners\Deleting');

		Event::listen('Thunderlabid\Akta\Events\Versi\VersiCreating', 'Thunderlabid\Akta\Listeners\Saving');
		Event::listen('Thunderlabid\Akta\Events\Versi\VersiUpdating', 'Thunderlabid\Akta\Listeners\Saving');
		Event::listen('Thunderlabid\Akta\Events\Versi\VersiDeleting', 'Thunderlabid\Akta\Listeners\Deleting');
	}

	public function register()
	{
		
	}
}