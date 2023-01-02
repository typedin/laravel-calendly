<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyWebhookSubscriptionsController;

use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\DeleteWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Http\GetWebhookSubscriptionRequest;
use Typedin\LaravelCalendly\Http\PostWebhookSubscriptionRequest;

class CalendlyWebhookSubscriptionsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function post(PostWebhookSubscriptionRequest $request)
    {
        $this->api->post("/webhook_subscriptions/", $request);
    }

    public function show(GetWebhookSubscriptionRequest $request)
    {
        $response = $this->api->get("/webhook_subscriptions/{$webhook_uuid}/", $request);
        return response()->json([
        "webhooksubscription" => new \Typedin\LaravelCalendly\Entities\WebhookSubscription($response),
        ]);
    }

    public function destroy(DeleteWebhookSubscriptionRequest $request)
    {
        $this->api->delete("/webhook_subscriptions/{$webhook_uuid}/");
    }
}
