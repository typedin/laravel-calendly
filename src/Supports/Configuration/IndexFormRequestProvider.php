<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

class IndexFormRequestProvider extends FormRequestProvider
{
    public function httpMethod(): string
    {
        return 'get';
    }

    /**
     * @return array
     */
    public function parameters(): array
    {
        /* if (! isset($this->value['get']['parameters'])) { */
        /*     throw new  \Exception(sprintf('Error Processing %s', $this->name)); */
        /* } */

        return $this->value['get']['parameters'] ?? [];
    }
}
