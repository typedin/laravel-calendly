<?php

namespace Typedin\LaravelCalendly\Supports;

use Exception;
class HttpMethod
{
    public static function getRestfulControllerMethod(array $endpoints, string $path, string $method): string
    {
        $responses = $endpoints[$path][$method]['responses'];

        if (array_key_exists(200, $responses) && array_key_exists('collection', $responses[200]['content']['application/json']['schema']['properties'])) {
            return 'index';
        }

        if (array_key_exists(200, $responses) && array_key_exists('resource', $responses[200]['content']['application/json']['schema']['properties'])) {
            return 'show';
        }

        if (array_key_exists(201, $responses)) {
            return 'create';
        }

        if (array_key_exists(204, $responses)) {
            return 'destroy';
        }

        if ($method == 'post' && array_key_exists(202, $responses)) {
            return 'create';
        }

        throw new Exception('Could not determine a method for the path: '.$path, 1);
    }

    public static function hasIndex(array $endpoints): bool
    {
        if (! isset($endpoints['get'])) {
            return false;
        }

        $responses = $endpoints['get']['responses'];

        return   array_key_exists(200, $responses) && array_key_exists('collection', $responses[200]['content']['application/json']['schema']['properties']);
    }

    public static function hasShow(array $endpoints): bool
    {
        if (! isset($endpoints['get'])) {
            return false;
        }

        $responses = $endpoints['get']['responses'];

        return array_key_exists(200, $responses) && array_key_exists('resource', $responses[200]['content']['application/json']['schema']['properties']);
    }

    public static function hasCreate(array $endpoints): bool
    {
        if (! isset($endpoints['post'])) {
            return false;
        }

        $responses = $endpoints['post']['responses'];

        return array_key_exists(201, $responses);
    }

    public static function hasCreateWithNoContent(array $endpoints): bool
    {
        if (! isset($endpoints['post'])) {
            return false;
        }

        $responses = $endpoints['post']['responses'];

        return array_key_exists(202, $responses);
    }

    public static function hasDestroy(array $endpoints): bool
    {
        if (! isset($endpoints['delete'])) {
            return false;
        }
        $responses = $endpoints['delete']['responses'];

        return  array_key_exists(204, $responses);
    }
}
