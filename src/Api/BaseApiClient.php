<?php

namespace Typedin\LaravelCalendly\Api;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class BaseApiClient
{
    /**
     * @var string API Key.
     */
    private string $apiKey;

    /**
     * @var string Base API URI.
     */
    private string $baseUri;

    public function __construct(string $apiKey, string $baseUri)
    {
        $this->apiKey = $apiKey;
        $this->baseUri = $baseUri;
    }

    /**
     * Gets base API url.
     *
     * @return string
     */
    public function baseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * @return Response
     */
    public function get(string $string): Response
    {
        $response = Http::withToken($this->apiKey)->get(
            $this->baseUri().'/'.$string,
        );

        return $response;
    }
}
