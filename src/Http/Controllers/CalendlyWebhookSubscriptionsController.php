<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DestroyWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Http\Requests\IndexWebhookSubscriptionsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Http\Requests\StoreWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Models\Pagination;
use Typedin\LaravelCalendly\Models\WebhookSubscription;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class CalendlyWebhookSubscriptionsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexWebhookSubscriptionsRequest $request): JsonResponse
    {
        $response = $this->api->get('/webhook_subscriptions/', $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->map(fn ($args) => new WebhookSubscription(...$args));
        $pagination = new Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'webhook_subscriptions' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function create(StoreWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->post('/webhook_subscriptions/', $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'webhook_subscription' => new WebhookSubscription(...$response->json('resource')),
        ]);
    }

    public function show(ShowWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->get("/webhook_subscriptions/{$request->validated('webhook_uuid')}/", $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'webhook_subscription' => new WebhookSubscription(...$response->json('resource')),
        ]);
    }

    public function destroy(DestroyWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->delete("/webhook_subscriptions/{$request->validated('webhook_uuid')}/");
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return \Illuminate\Support\Facades\Response::json([], 204);
    }
}
