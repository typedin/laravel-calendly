<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DestroyWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Http\Requests\IndexWebhookSubscriptionsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Http\Requests\StoreWebhookSubscriptionRequest;

class CalendlyWebhookSubscriptionsController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexWebhookSubscriptionsRequest $request): JsonResponse
    {
        $response = $this->api->get('/webhook_subscriptions/', $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->map(fn ($args) => new \Typedin\LaravelCalendly\Models\WebhookSubscription(...$args));
        $pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'webhook_subscriptions' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function create(StoreWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->post('/webhook_subscriptions/', $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'webhook_subscription' => new \Typedin\LaravelCalendly\Models\WebhookSubscription(...$response->json('resource')),
        ]);
    }

    public function show(ShowWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->get("/webhook_subscriptions/{$request->validated('webhook_uuid')}/", $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'webhook_subscription' => new \Typedin\LaravelCalendly\Models\WebhookSubscription(...$response->json('resource')),
        ]);
    }

    public function destroy(DestroyWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->delete("/webhook_subscriptions/{$request->validated('webhook_uuid')}/");
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }

        return \Illuminate\Support\Facades\Response::json([], 204);
    }
}
