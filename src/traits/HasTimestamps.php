<?php

namespace Typedin\LaravelCalendly\traits;

use Carbon\Carbon;

trait HasTimestamps
{
    /**
     * The moment when the organization's record was created (e.g. "2020-01-02T03:04:05.678123Z")
     * Example:2019-01-02T03:04:05.678123Z
     *
     * @var Carbon<created_at>
     */
    public Carbon $created_at;

    /*
    * The moment when the organization's record was last updated (e.g. "2020-01-02T03:04:05.678123Z")
    * Example:2019-08-07T06:05:04.321123Z
    *
    * @var Carbon<updated_at>
    */
    public Carbon $updated_at;

    public const DATEABLE = ['created_at', 'updated_at'];
}
