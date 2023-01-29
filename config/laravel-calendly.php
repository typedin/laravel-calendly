<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'api' => [
        'key' => env('CALENDLY_API_KEY'),
        'endpoint' => env('CALENDLY_ENDPOINT', 'api.calendly.com'),
    ],
];
