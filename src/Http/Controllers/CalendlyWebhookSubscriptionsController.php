<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DestroyWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Http\Requests\StoreWebhookSubscriptionRequest;

class CalendlyWebhookSubscriptionsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(StoreWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->post('/webhook_subscriptions/', $request);

        return response()->json([
            'webhook_subscription' => new \Typedin\LaravelCalendly\Entities\CalendlyWebhookSubscription($response),
        ]);
    }

    public function show(ShowWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->get("/webhook_subscriptions/{$webhook_uuid}/", $request);

        return response()->json([
            'webhook_subscription' => new \Typedin\LaravelCalendly\Entities\CalendlyWebhookSubscription($response),
        ]);
    }

    public function destroy(DestroyWebhookSubscriptionRequest $request): JsonResponse
    {
        $this->api->delete("/webhook_subscriptions/{$webhook_uuid}/");

        return response()->noContent();
    }
}
