<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use DestroyWebhookSubscriptionRequest;
use JsonResponse;
use ShowWebhookSubscriptionRequest;
use StoreWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Entities\CalendlyWebhookSubscription;

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
            'webhook_subscription' => new CalendlyWebhookSubscription($response),
        ]);
    }

    public function show(ShowWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->get("/webhook_subscriptions/{$request->safe()->only(['webhook_uuid'])}/", $request);

        return response()->json([
            'webhook_subscription' => new CalendlyWebhookSubscription($response),
        ]);
    }

    public function destroy(DestroyWebhookSubscriptionRequest $request): JsonResponse
    {
        $this->api->delete("/webhook_subscriptions/{$request->safe()->only(['webhook_uuid'])}/");

        return response()->noContent();
    }
}
