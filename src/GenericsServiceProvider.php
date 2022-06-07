<?php

declare(strict_types=1);

namespace Zekini\Generics;

use Livewire\Livewire;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Zekini\Generics\Components\GenericsRealtimeNotification;

class GenericsServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     */
    public function boot()
    {

        $this->registerViews();
       
       $this->registerCommands();

        $this->registerComponents();

        $this->registerPublishables();

        $this->registerNamespace();
    }

    public function register()
    {
    }

    private function registerCommands()
    {
         // register commands
         if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\ResetLocalPassword::class,
                Commands\MakeGenericCommand::class,
                Commands\MakeHelperCommand::class,
            ]);
        }
    }

    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'zekini/laravel-generics');
    }

    private function registerNamespace()
    {
        $this->app['view']->addNamespace('zekini/laravel-generics', resource_path('views/vendor/zekini/generics'));
    }

    private function registerPublishables()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../stubs/ecs.php' => base_path('ecs.php'),
                __DIR__ . '/../stubs/phpstan.neon' => base_path('phpstan.neon'),
                __DIR__ . '/../stubs/psalm.xml' => base_path('psalm.xml'),
            ], 'zekini-config');

            $this->publishes([
                __DIR__.'/../.github/workflows' => base_path('.github/workflows'),
            ], 'laravel-generics:workflows');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/zekini/generics'),
            ], 'laravel-generics:views');

            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/zekini/generics'),
            ], 'laravel-generics:public');
        }
    }

    private function registerComponents()
    {
        Livewire::component('generics-realtime-notification', GenericsRealtimeNotification::class);
    }

  
}
