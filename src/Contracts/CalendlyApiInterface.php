<?php

namespace Typedin\LaravelCalendly\Contracts;

use Illuminate\Http\Client\Response;

interface CalendlyApiInterface
{
    /**
     * Gets base API url.
     *
     * @return string
     */
    public function endpoint(): string;

    /**
     * @return Response
     */
    public function get(string $url_path, $args = null): Response;

    /**
     * @return Response
     */
    public function post(string $url_path, $args = null): Response;

    /**
     * @return Response
     */
    public function delete(string $url_path, $args = null): Response;
}
