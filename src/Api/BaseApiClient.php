<?php

namespace Typedin\LaravelCalendly\Api;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Exceptions\ApiClientException;

class BaseApiClient implements CalendlyApiInterface
{
    /**
     * @var string API Key.
     */
    private readonly string $apiKey;

    /**
     * @var string endpoint
     */
    private readonly string $endpoint;

    public function __construct()
    {
        if (! config('laravel-calendly.api.key')) {
            throw ApiClientException::ApiKeyNotFound();
        }
        $this->apiKey = config('laravel-calendly.api.key');

        if (! config('laravel-calendly.api.endpoint')) {
            throw ApiClientException::ApiEndpointNotFound();
        }
        $this->endpoint = config('laravel-calendly.api.endpoint');
    }

    /**
     * Gets base API url.
     */
    public function endpoint(): string
    {
        return $this->endpoint;
    }

    public function get(string $url_path, $args = null): Response
    {
        return Http::withToken($this->apiKey)
            ->get(
                $this->endpoint().'/'.$url_path,
                $args
            );
    }

    public function post(string $url_path, $args = null): Response
    {
        return Http::withToken($this->apiKey)
            ->get(
                $this->endpoint().'/'.$url_path,
                $args
            );
    }

    public function delete(string $url_path, $args = null): Response
    {
        return Http::withToken($this->apiKey)
            ->get(
                $this->endpoint().'/'.$url_path,
                $args
            );
    }
}
