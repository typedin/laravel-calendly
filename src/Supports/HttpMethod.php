<?php

namespace Typedin\LaravelCalendly\Supports;

class HttpMethod
{
    public static function getRestfulControllerMethod(array $endpoints, string $path, string $method): string
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

    /**
     * @param  array  $value
     */
    private function getResponseType(array $endpoints): array
    {
        return $endpoints['get']['responses']['200']['content']['application/json']['schema']['properties'];
    }

    public static function hasIndex(array $endpoints): bool
    {
        if (! isset($endpoints['get'])) {
            return false;
        }

        $responses = $endpoints['get']['responses'];

        return   in_array(200, array_keys($responses)) && array_key_exists('collection', $responses[200]['content']['application/json']['schema']['properties']);
    }

    public static function hasShow(array $endpoints): bool
    {
        if (! isset($endpoints['get'])) {
            return false;
        }

        $responses = $endpoints['get']['responses'];

        return in_array(200, array_keys($responses)) && array_key_exists('resource', $responses[200]['content']['application/json']['schema']['properties']);
    }

    public static function hasCreate(array $endpoints): bool
    {
        if (! isset($endpoints['post'])) {
            return false;
        }

        $responses = $endpoints['post']['responses'];

        return in_array(201, array_keys($responses));
    }

    public static function hasDestroy(array $endpoints): bool
    {
        if (! isset($endpoints['delete'])) {
            return false;
        }
        $responses = $endpoints['delete']['responses'];

        return  in_array(204, array_keys($responses));
    }
}
