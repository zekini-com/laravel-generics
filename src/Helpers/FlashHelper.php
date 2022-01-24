<?php
declare(strict_types=1);

namespace Zekini\Generics\Helpers;

class FlashHelper extends BaseHelper
{


    public static function success(string $msg, object $object): void
    {
        /**
         * @psalm-suppress UndefinedMethod
         * @psalm-suppress InvalidArgument
         */
        flash($msg)->success()->livewire($object);
    }


    public static function successRedirect(string $msg):void
    {
        /**
         * @psalm-suppress UndefinedMethod
         */
        flash($msg)->success();
    }
}