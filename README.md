
# Introduction

  

The **zekini/laravel-generics** package allows us to store our generic classes in a package so we can reuse them

  

**Installation**

    composer require --dev zekini/laravel-generics



**Usage**

To reset password in a local database environment


    php artisan local:password-reset --password=password


To add another generic command

    php artisan generic:command TestCommand

To add another generic helper

    php artisan generic:helper TestHelper
