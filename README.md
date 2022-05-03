
# Introduction

  

The **zekini/laravel-generics** package allows us to store our generic classes in a package so we can reuse them

  

**Installation**

    composer require zekini/laravel-generics

    sail artisan vendor:publish --tag=zekini-config
    sail artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
    sail artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-config"
    sail artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

    sail artisan migrate

**Usage**

To reset password in a local database environment

    sail artisan local:password-reset --password=password

To generate or update the code checkers config files:

    sail artisan vendor:publish --tag=zekini-config --force

To add another generic command

    sail artisan generic:command TestCommand

To add another generic helper

    sail artisan generic:helper TestHelper

To use the pdf mergeer


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
    use Zekini\Generics\Helpers\TimezoneHelper;
    use Zekini\Generics\Helpers\PDFMergeHelper;

**Standard Packages**

    https://github.com/arcanedev/log-viewer
    https://github.com/barryvdh/laravel-dompdf
    https://github.com/laravel/jetstream
    https://github.com/livewire/livewire
    https://github.com/mediconesystems/livewire-datatables
    https://github.com/spatie/laravel-activitylog
    https://github.com/spatie/laravel-permission
    https://github.com/maatwebsite/excel
    https://github.com/spatie/laravel-backup
    https://github.com/spatie/laravel-schedule-monitor
    https://github.com/Webklex/laravel-pdfmerger
    https://github.com/barryvdh/laravel-snappy
    https://github.com/h4cc/wkhtmltoimage-amd64
    https://github.com/h4cc/wkhtmltopdf-amd64

**Standard Dev Packages**

    https://github.com/barryvdh/laravel-debugbar
    https://github.com/nunomaduro/larastan
    https://github.com/protoqol/prequel
    https://github.com/symplify/easy-coding-standard
    https://github.com/vimeo/psalm

**Removed to be re-added once conflict is resolved**
        "spatie/laravel-backup"
        "spatie/laravel-schedule-monitor"
        "arcanedev/log-viewer"

## Snappy config 
The main change to this config file (config/snappy.php) will be the path to the binaries.

For example, when loaded with composer, the line should look like:

`'binary' => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64')`

For windows users you'll have to add double quotes to the bin path for wkhtmltopdf:

`'binary' => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf"'`

For mac users what i simply did was install the macos executables for both libraries

