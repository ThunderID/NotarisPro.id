<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class UserLogged
{
    use SerializesModels;

    public $user;

    /**
     * Update instance.
     *
     * @param  user  $user
     * @return void
     */
    public function __construct(array $user)
    {
        $this->user     = $user;
    }
}