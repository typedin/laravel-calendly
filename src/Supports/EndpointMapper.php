<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EndpointMapper
{
    public static function fullname(string $input): string
    {
        return collect(array_values(array_filter(explode('/', $input))))
                    ->filter(fn ($part) => ! Str::contains($part, ['me', 'deletion', 'uuid']))
                    ->map(fn ($part) => ucfirst(Str::camel($part)))
                    ->implode('');
    }

    public static function toControllerName(array $array): Collection
    {
        return collect(array_keys($array))->flatMap(fn ($applesauce) => [$applesauce => self::fullname($applesauce)]
        );
    }
}
