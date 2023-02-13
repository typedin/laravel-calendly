<?php

namespace Typedin\LaravelCalendly\Supports;

class HttpMethod
{
    public static function getRestfulControllerMethod($endpoints, $path, $method)
    {
        $responses = $endpoints[$path][$method]['responses'];

        if (in_array(200, array_keys($responses)) && array_key_exists('collection', $responses[200]['content']['application/json']['schema']['properties'])) {
            return 'index';
        }

        if (in_array(200, array_keys($responses)) && array_key_exists('resource', $responses[200]['content']['application/json']['schema']['properties'])) {
            return 'show';
        }

        if (in_array(201, array_keys($responses))) {
            return 'create';
        }

        if (in_array(204, array_keys($responses))) {
            return 'destroy';
        }

        if ($method == 'post' && in_array(202, array_keys($responses))) {
            return 'create';
        }

        throw new \Exception('Could not determine a method for the path: '.$path, 1);
    }
}
