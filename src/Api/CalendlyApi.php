<?php

namespace Typedin\LaravelCalendly\Api;

use Illuminate\Http\Client\Factory;

class CalendlyApi extends Factory
{
    private string $apiKey;

    private string $apiUrl;

    public function __construct(string $apiKey, string $apiUrl)
    {
        parent::__construct();

        $this->apiKey = $apiKey;

        $this->apiUrl = $apiUrl;
    }
}
