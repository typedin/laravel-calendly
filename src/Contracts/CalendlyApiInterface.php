<?php

namespace Typedin\LaravelCalendly\Contracts;

use Illuminate\Http\Client\Response;

interface CalendlyApiInterface
{
    /**
     * Gets base API url.
     */
    public function endpoint(): string;

    public function get(string $url_path, $args = null): Response;

    public function post(string $url_path, $args = null): Response;

    public function delete(string $url_path, $args = null): Response;
}
