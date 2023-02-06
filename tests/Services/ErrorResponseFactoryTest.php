<?php

namespace Typedin\LaravelCalendly\Tests\Services;

use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase;
use Typedin\LaravelCalendly\Http\Errors\NotFoundError;
use Typedin\LaravelCalendly\Http\Errors\PermissionDeniedError;
use Typedin\LaravelCalendly\Http\Errors\UnauthenticatedError;
use Typedin\LaravelCalendly\Http\Errors\UnknownError;
use Typedin\LaravelCalendly\Models\ErrorResponse;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class ErrorResponseFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_for_401(): void
    {
        $params = [
            'title' => 'Unauthenticated',
            'message' => 'The access token is invalid',
            'details' => [
                [
                    'parameter' => 'string',
                    'message' => 'string',
                ],
            ],
        ];
        $error_response = ( new ErrorResponseFactory($this->response($params, 401)) )->errorResponse;

        $this->assertInstanceOf(UnauthenticatedError::class, $error_response);
        $this->assertArrayHasKey('title', json_decode($error_response->toJson()->getContent(), true));
        $this->assertArrayHasKey('message', json_decode($error_response->toJson()->getContent(), true));
        $this->assertArrayHasKey('details', json_decode($error_response->toJson()->getContent(), true));
    }

    /**
     * @test
     */
    public function it_returns_for_403(): void
    {
        $params = [
            'title' => 'Permission Denied',
            'message' => 'You do not have permission to access this resource.',
            'details' => [
                'parameter' => 'string',
                'message' => 'string',
            ],
        ];
        $error_response = ( new ErrorResponseFactory($this->response($params, 403)) )->errorResponse;

        $this->assertInstanceOf(PermissionDeniedError::class, $error_response);
        $this->assertArrayHasKey('title', json_decode($error_response->toJson()->getContent(), true));
        $this->assertArrayHasKey('message', json_decode($error_response->toJson()->getContent(), true));
        $this->assertArrayHasKey('details', json_decode($error_response->toJson()->getContent(), true));
    }

    /**
     * @test
     */
    public function it_returns_for_404(): void
    {
        $params = [
            'title' => 'Resource Not Found',
            'message' => 'The server could not find the requested resource.',
            'details' => [
                'parameter' => 'string',
                'message' => 'string',
            ],
        ];
        $error_response = ( new ErrorResponseFactory($this->response($params, 404)) )->errorResponse;

        $this->assertInstanceOf(NotFoundError::class, $error_response);
        $this->assertArrayHasKey('title', json_decode($error_response->toJson()->getContent(), true));
        $this->assertArrayHasKey('message', json_decode($error_response->toJson()->getContent(), true));
        $this->assertArrayHasKey('details', json_decode($error_response->toJson()->getContent(), true));
    }

    /**
     * @test
     */
    public function it_returns_for_500(): void
    {
        $params = [
            'title' => 'Internal Server Error',
            'message' => 'The server encountered an unexpected condition that prevented it from fulfilling the request.',
            'details' => [
                'parameter' => 'string',
                'message' => 'string',
            ],
        ];

        $error_response = ( new ErrorResponseFactory($this->response($params, 500)) )->errorResponse;

        $this->assertInstanceOf(UnknownError::class, $error_response);
        $this->assertArrayHasKey('title', json_decode($error_response->toJson()->getContent(), true));
        $this->assertArrayHasKey('message', json_decode($error_response->toJson()->getContent(), true));
        $this->assertArrayHasKey('details', json_decode($error_response->toJson()->getContent(), true));
    }

    /**
     * @test
     */
    public function it_returns_for_unknown_errors_codes(): void
    {
        $params = [
            'title' => "I'm a teapot",
            'message' => 'Any attempt to brew coffee with a teapot should result in the error code “418 I’m a teapot”. The resulting entity body MAY be short and stout.',
        ];

        $error_response = ( new ErrorResponseFactory($this->response($params, 418)) )->errorResponse;

        $this->assertInstanceOf(ErrorResponse::class, $error_response);
        $this->assertArrayHasKey('title', json_decode($error_response->toJson()->getContent(), true));
        $this->assertArrayHasKey('message', json_decode($error_response->toJson()->getContent(), true));
        $this->assertArrayHasKey('details', json_decode($error_response->toJson()->getContent(), true));
    }

    private function response($params, $code)
    {
        Http::fake(['' => Http::response($params, $code, [])]);

        return Http::get('');
    }
}
