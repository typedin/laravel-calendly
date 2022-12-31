<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyWebhookSubscriptionsController;

class CalendlyWebhookSubscriptionsController extends Illuminate\Routing\Controller
{
	public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
	{
		$this->api = $api;
	}


	public function post(\Typedin\LaravelCalendly\Http\PostWebhookSubscriptionRequest $request)
	{
		$this->api->post("/webhook_subscriptions/", $request);
	}


	public function show(\Typedin\LaravelCalendly\Http\GetWebhookSubscriptionRequest $request)
	{
		$response = $this->api->get("/webhook_subscriptions/{$webhook_uuid}/", $request);
		return response()->json([
		"webhooksubscription" => new \Typedin\LaravelCalendly\Entities\WebhookSubscription($response),
		]);
	}


	public function destroy(\Typedin\LaravelCalendly\Http\DeleteWebhookSubscriptionRequest $request)
	{
		$this->api->delete("/webhook_subscriptions/{$webhook_uuid}/");
	}
}
