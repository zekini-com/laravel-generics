
# Introduction

  

The **zekini/laravel-generics** package allows us to store our generic classes in a package so we can reuse them

  

**Installation**

    composer require zekini/laravel-generics



**Usage**

To reset password in a local database environment


    ./vendor/bin/sail artisan local:password-reset --password=password


To add another generic command

    ./vendor/bin/sail artisan generic:command TestCommand

To add another generic helper

    ./vendor/bin/sail artisan generic:helper TestHelper

**Available Helpers**

    use Zekini\Generics\Helpers\EnvironmentHelper;

**Standard Packages**

    https://github.com/spatie/laravel-backup

    https://github.com/spatie/laravel-schedule-monitor

    https://github.com/ARCANEDEV/LogViewer


**Removed to be re-added once conflict is resolved**
        "spatie/laravel-backup"