<?php

declare(strict_types=1);

namespace Zekini\Generics\Helpers;

use Carbon\Carbon;


class TimezoneHelper extends BaseHelper
{


    public static function convertHourToLocal($hour, $fromTimezone)
    {
        $date = Carbon::parse('', $fromTimezone);

        $date->hour($hour);

        $timezone = self::convertToTimezone($date, config('app.timezone'));

        return (int) $timezone->format('G');
    }

    public function convertHourToTimezone($hour, $toTimezone):int
    {
        $date = Carbon::parse('', config('app.timezone'));

        $date->hour($hour);

        $timezone = self::convertToTimezone($date, $toTimezone);

        return (int) $timezone->format('G');
    }

    /**
     * Converts the hour given to users timezone
     */
    public static function convertToTimezone($date=null, $timezone = null)
    {
        $timezone = $timezone ?? auth()->user()->timezone;
        $date = $date ?? Carbon::parse('', config('app.timezone'));

        date_default_timezone_set(config('app.timezone'));

        $date->setTimezone($timezone);

        return $date;
    }

    /**
     * Converts time zone to local
     */
    public static function convertToLocal($date=null, $timezone = null)
    {
        $timezone = $timezone ?? auth()->user()->timezone;
        $date = $date ?? Carbon::parse('', $timezone);

        date_default_timezone_set($timezone);

        $date->setTimezone(config('app.timezone'));

        return $date;
    }

    public static function timeAgo($date, $timezone = null)
    {
        $timezone = $timezone ?? auth()->user()->timezone;
        date_default_timezone_set(config('app.timezone'));
        $date = Carbon::parse($date, config('app.timezone'));

        $date->setTimezone($timezone);

        return $date->diffForHumans();
    }
}