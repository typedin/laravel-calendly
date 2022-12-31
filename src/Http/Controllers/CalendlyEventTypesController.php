<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyEventTypesController;

class CalendlyEventTypesController extends Illuminate\Routing\Controller
{
	public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
	{
		$this->api = $api;
	}


	public function index(\Typedin\LaravelCalendly\Http\IndexEventTypeRequest $request)
	{
		$response = $this->api->get("/event_types/", $request);

		$all = collect($response["collection"])
		->mapInto(EventType::class)->all();
		return response()->json([
		"event_types" => $all,
		]);
	}


	public function show(\Typedin\LaravelCalendly\Http\GetEventTypeRequest $request)
	{
		$response = $this->api->get("/event_types/{$uuid}/", $request);
		return response()->json([
		"eventtype" => new \Typedin\LaravelCalendly\Entities\EventType($response),
		]);
	}
}
