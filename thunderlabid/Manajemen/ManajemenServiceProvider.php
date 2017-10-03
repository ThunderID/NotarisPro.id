<?php

namespace Thunderlabid\Manajemen;

use Illuminate\Support\ServiceProvider;
use Event;

class ManajemenServiceProvider extends ServiceProvider
{
	public function boot()
	{
		/////////////////////////////
		//   Auto Creating Kantor  //
		/////////////////////////////
		Event::listen('Thunderlabid\Manajemen\Events\User\UserCreating', 'Thunderlabid\Manajemen\Listeners\AutoCreatingKantor');
		Event::listen('Thunderlabid\Manajemen\Events\User\UserUpdating', 'Thunderlabid\Manajemen\Listeners\AutoCreatingKantor');

		////////////////
		// Validation //
		////////////////
		Event::listen('Thunderlabid\Manajemen\Events\User\UserCreating', 'Thunderlabid\Manajemen\Listeners\Saving');
		Event::listen('Thunderlabid\Manajemen\Events\User\UserUpdating', 'Thunderlabid\Manajemen\Listeners\Saving');
		Event::listen('Thunderlabid\Manajemen\Events\User\UserDeleting', 'Thunderlabid\Manajemen\Listeners\Deleting');

		////////////////
		//   Encrypt  //
		////////////////
		Event::listen('Thunderlabid\Manajemen\Events\User\UserCreating', 'Thunderlabid\Manajemen\Listeners\EncryptPassword');
		Event::listen('Thunderlabid\Manajemen\Events\User\UserUpdating', 'Thunderlabid\Manajemen\Listeners\EncryptPassword');
	}

	public function register()
	{
		
	}
}