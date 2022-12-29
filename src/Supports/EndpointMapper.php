<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EndpointMapper
{
    public static function fullname(string $input): string
    {
        $local = collect(array_values(array_filter(explode('/', $input))))
                    ->filter(fn ($part) => ! Str::contains($part, ['me', 'deletion', 'uuid']))
                    ->values()
                    ->map(fn($part): string => ucfirst(Str::camel($part)));

        return $local->map(function ($part, $key) use ($local) {
            if ($key < count($local) - 1) {
                return  Str::singular($part);
            }

            return Str::plural($part);
        })->implode('');
    }

    public static function toControllerName(array $array): Collection
    {
        return collect(array_keys($array))
                    ->flatMap(fn ($applesauce) => [$applesauce => self::fullname($applesauce)]);
    }
}
