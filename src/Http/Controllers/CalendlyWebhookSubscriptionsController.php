<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DestroyWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Http\Requests\StoreWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Models\WebhookSubscription;

class CalendlyWebhookSubscriptionsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(StoreWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->post('/webhook_subscriptions/', $request);

        return response()->json([
            'webhook_subscription' => new WebhookSubscription(...$response->json('resource')),
        ]);
    }

    public function show(ShowWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->get("/webhook_subscriptions/{$request->validated('webhook_uuid')}/", $request);

        return response()->json([
            'webhook_subscription' => new WebhookSubscription(...$response->json('resource')),
        ]);
    }

    public function destroy(DestroyWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->delete("/webhook_subscriptions/{$request->validated('webhook_uuid')}/");

        return response()->noContent();
    }
}
