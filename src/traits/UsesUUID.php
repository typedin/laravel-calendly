<?php

namespace Typedin\LaravelCalendly\traits;

trait UsesUUID
{
    private function extractUUID(string $needle, string $haystack): string
    {
        return ltrim(stristr($haystack, $needle), $needle);
    }
}
