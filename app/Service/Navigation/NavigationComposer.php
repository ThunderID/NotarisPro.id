<?php

namespace App\Service\Navigation;

use Illuminate\View\View;

class NavigationComposer
{
    /**
     * Create a new profile composer.
     *
     * @param  NavbarService  $users
     * @return void
     */
    public function __construct(NavbarService $service)
    {
        // Dependencies automatically resolved by service container...
        $this->service  = $service;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('navbars', $this->service->all());
    }
}