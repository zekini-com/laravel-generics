<?php

declare(strict_types=1);

namespace Zekini\Generics\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Zekini\Generics\Helpers\EnvironmentHelper;

class StubCodeCheckersCommand extends Command
{
    protected $signature = 'local:code-checkers:stub';

    protected $description = 'Recreates the config files for the code checkers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (EnvironmentHelper::isNotLocal()) {
            $this->error($this->signature . ' can only be run in Dev');
            return Command::FAILURE;
        }

        $configFiles = [
            'ecs.php',
            'phpstan.neon',
            'psalm.xml',
        ];

        foreach ($configFiles as $configFile) {
            $this->publishes([
                __DIR__ . '/../stubs/'. $configFile => base_path($configFile),
            ], 'stubs');
        }

        return Command::SUCCESS;
    }
}
