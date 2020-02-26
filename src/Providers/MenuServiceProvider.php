<?php

namespace CubeAgency\ArboryMenu\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    protected const MIGRATIONS_PATH = __DIR__ . '/../../database/migrations/';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(self::MIGRATIONS_PATH);
    }
}
