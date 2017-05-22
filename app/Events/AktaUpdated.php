<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class AktaUpdated
{
    use SerializesModels;

    public $akta;

    /**
     * Update instance.
     *
     * @param  akta  $akta
     * @return void
     */
    public function __construct(array $akta)
    {
        $this->akta     = $akta;
    }
}