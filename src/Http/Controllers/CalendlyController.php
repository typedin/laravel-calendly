<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyController;

class CalendlyController extends Illuminate\Routing\Controller
{
	private Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;


	public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
	{
		$this->api = $api;
	}


	public function show(\Typedin\LaravelCalendly\Http\GetRequest $request)
	{
		$response = $this->api->get("/organization_memberships/{$uuid}/", $request);
		return response()->json([
		"" => new \Typedin\LaravelCalendly\Entities\($response),
		]);
	}


	public function destroy(\Typedin\LaravelCalendly\Http\DeleteRequest $request)
	{
		$this->api->delete("/organization_memberships/{$uuid}/");
	}


	public function index(\Typedin\LaravelCalendly\Http\IndexRequest $request)
	{
		$response = $this->api->get("/organization_memberships/", $request);

		$all = collect($response["collection"])
		->mapInto(::class)->all();
		return response()->json([
		"" => $all,
		]);
	}
}
