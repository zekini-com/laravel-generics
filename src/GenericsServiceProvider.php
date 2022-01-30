<?php

declare(strict_types=1);

namespace Zekini\Generics;

use Illuminate\Support\ServiceProvider;

class GenericsServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     */
    public function boot()
    {

        // register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\ResetLocalPassword::class,
                Commands\MakeGenericCommand::class,
                Commands\MakeHelperCommand::class,
                Commands\StubCodeCheckersCommand::class,
            ]);
        }
    }

    public function register()
    {
    }
}
