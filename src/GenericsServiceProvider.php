<?php
namespace Zekini\Generics;

use Illuminate\Support\ServiceProvider;

class GenericsServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        
        // register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\ResetLocalPassword::class,
                Commands\MakeGenericCommand::class
            ]);
        }
        
    }

    public function register()
    {

    }
}