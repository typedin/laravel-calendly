<?php

namespace Typedin\LaravelCalendly\Api;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;

class BaseApiClient implements CalendlyApiInterface
{
    /**
     * @var string API Key.
     */
    private string $apiKey;

    /**
     * @var string endpoint
     */
    private string $endpoint;

    public function __construct(string $apiKey, string $baseUri)
    {
        $this->apiKey = $apiKey;
        $this->endpoint = $baseUri;
    }

    /**
     * Gets base API url.
     *
     * @return string
     */
    public function endpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return Response
     */
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
