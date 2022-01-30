
# Introduction

  

The **zekini/laravel-generics** package allows us to store our generic classes in a package so we can reuse them

  

**Installation**

    composer require zekini/laravel-generics

    sail artisan vendor:publish --tag=code-checkers-config

**Usage**

To reset password in a local database environment


    sail artisan local:password-reset --password=password


To generate or update the code checkers config files:


    sail artisan local:code-checkers:stub


To add another generic command

    sail artisan generic:command TestCommand

To add another generic helper

    sail artisan generic:helper TestHelper

**Available Helpers**

    use Zekini\Generics\Helpers\ArrayHelper;
    use Zekini\Generics\Helpers\ArrayToObjectHelper;
    use Zekini\Generics\Helpers\CsvHelper;
    use Zekini\Generics\Helpers\EnvironmentHelper;
    use Zekini\Generics\Helpers\FileHelper;
    use Zekini\Generics\Helpers\FlashHelper;
    use Zekini\Generics\Helpers\ForeignKeyHelper;
    use Zekini\Generics\Helpers\HttpHelper;
    use Zekini\Generics\Helpers\LoggingHelper;
    use Zekini\Generics\Helpers\StringHelper;
    use Zekini\Generics\Helpers\UIHelper;

**Standard Packages**

    https://github.com/spatie/laravel-backup

    https://github.com/spatie/laravel-schedule-monitor

    https://github.com/ARCANEDEV/LogViewer


**Removed to be re-added once conflict is resolved**
        "spatie/laravel-backup"
        "spatie/laravel-schedule-monitor"
        