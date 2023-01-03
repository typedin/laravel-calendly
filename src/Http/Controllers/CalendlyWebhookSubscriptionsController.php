<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyWebhookSubscription;
use Typedin\LaravelCalendly\Http\DeleteWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Http\GetWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Http\PostWebhookSubscriptionRequest;

class CalendlyWebhookSubscriptionsController extends Controller
{
    public function __construct(private readonly CalendlyApiInterface $api)
    {
    }

    public function create(PostWebhookSubscriptionRequest $request): JsonResponse
    {
        $response = $this->api->post('/webhook_subscriptions/', $request);

        return response()->json([
            'webhook_subscription' => new CalendlyWebhookSubscription($response),
        ]);
    }

    public function show(GetWebhookSubscriptionRequest $request): JsonResponse
    {
        $webhook_uuid = null;
        $response = $this->api->get("/webhook_subscriptions/{$webhook_uuid}/", $request);

        return response()->json([
            'webhook_subscription' => new CalendlyWebhookSubscription($response),
        ]);
    }

    public function destroy(DeleteWebhookSubscriptionRequest $request): JsonResponse
    {
        $webhook_uuid = null;
        $this->api->delete("/webhook_subscriptions/{$webhook_uuid}/");

        return response()->noContent();
    }
}
