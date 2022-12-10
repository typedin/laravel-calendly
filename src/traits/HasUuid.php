<?php

namespace Typedin\LaravelCalendly\traits;

trait HasUuid
{
    /**
     * The unique identifier in Calendly system
     * Example: AAAA-AAAA-AAAA-AAAA
     *
     * @var string<uuid>
     */
    public string $uuid;

    private function extractUUID(string $needle, string $haystack): string
    {
        return ltrim(stristr($haystack, $needle), $needle);
    }
}
