<?php

namespace Typedin\LaravelCalendly\Supports;

class TypeHandler
{
    /**
     * @param  mixed  $argument
     */
    public static function getType($argument): string
    {
        if (! isset($argument['type'])) {
            return '';
        }
        if (str_contains((string) $argument['type'], 'bool')) {
            return 'bool';
        }
        if (str_contains((string) $argument['type'], 'number')) {
            return 'float';
        }

        return $argument['type'];
    }

    /**
     * @param  mixed  $argument
     */
    public static function isEnum($argument): bool
    {
        return isset($argument['enum']);
    }

    /**
     * @param  array<int,mixed>  $property
     * @param  array<int,mixed>  $required_lookup
     */
    public static function isNullable(array $property, array $required_lookup, string $property_name): bool
    {
        if (isset($property['nullable'])) {
            return $property['nullable'];
        }
        if (! isset($required_lookup['required'])) {
            return true;
        }

        return ! in_array($property_name, $required_lookup['required']);
    }
}
