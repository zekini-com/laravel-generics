<?php

declare(strict_types=1);

namespace Zekini\Generics;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class GenericsServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../stubs/ecs.php' => base_path('ecs.php'),
            __DIR__ . '/../stubs/phpstan.neon' => base_path('phpstan.neon'),
            __DIR__ . '/../stubs/psalm.xml' => base_path('psalm.xml'),
        ], 'zekini-config');

        $this->publishSpatiePermissionVendor();

        $this->publishSpatieActivitylogVendor();

        // register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\ResetLocalPassword::class,
                Commands\MakeGenericCommand::class,
                Commands\MakeHelperCommand::class,
            ]);
        }
    }

    protected function publishSpatiePermissionVendor(): void
    {
        self::undoPreviousMigrations([
            'model_has_permissions',
            'role_has_permissions',
            'permissions',
            'model_has_roles',
            'roles',
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\Permission\\PermissionServiceProvider',
            '--tag' => 'zekini-config'
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\Permission\\PermissionServiceProvider',
            '--tag' => 'zekini-config'
        ]);
    }

    protected function publishSpatieActivitylogVendor(): void
    {
        self::undoPreviousMigrations(['activity_logs']);

        $this->call('vendor:publish', [
            '--provider' => "Spatie\Activitylog\ActivitylogServiceProvider",
            '--tag' => 'zekini-config'
        ]);

        $this->call('vendor:publish', [
            '--provider' => "Spatie\Activitylog\ActivitylogServiceProvider",
            '--tag' => 'zekini-config'
        ]);
    }

    private static function undoPreviousMigrations(array $tablesArray): void
    {
        foreach ($tablesArray as $table) {
            // Schema::dropIfExists($table);
            // DB::table('migrations')->where('migration', 'like', '%' . $table . '%')->delete();
        }
    }

    public function register()
    {
    }
}
