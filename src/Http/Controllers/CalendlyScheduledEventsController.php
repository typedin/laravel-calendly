<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyScheduledEventsController;

class CalendlyScheduledEventsController extends Illuminate\Routing\Controller
{
	public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
	{
		$this->api = $api;
	}


	public function index(\Typedin\LaravelCalendly\Http\IndexScheduledEventRequest $request)
	{
		$response = $this->api->get("/scheduled_events/", $request);

		$all = collect($response["collection"])
		->mapInto(ScheduledEvent::class)->all();
		return response()->json([
		"scheduled_events" => $all,
		]);
	}


	public function show(\Typedin\LaravelCalendly\Http\GetScheduledEventRequest $request)
	{
		$response = $this->api->get("/scheduled_events/{$uuid}/", $request);
		return response()->json([
		"scheduledevent" => new \Typedin\LaravelCalendly\Entities\ScheduledEvent($response),
		]);
	}
}
