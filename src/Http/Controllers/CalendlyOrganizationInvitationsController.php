<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyOrganizationInvitationsController;

class CalendlyOrganizationInvitationsController extends Illuminate\Routing\Controller
{
	public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
	{
		$this->api = $api;
	}


	public function post(\Typedin\LaravelCalendly\Http\PostOrganizationInvitationRequest $request)
	{
		$this->api->post("/organizations/{$uuid}/invitations/", $request);
	}


	public function show(\Typedin\LaravelCalendly\Http\GetOrganizationInvitationRequest $request)
	{
		$response = $this->api->get("/organizations/{$org_uuid}/invitations/{$uuid}/", $request);
		return response()->json([
		"organizationinvitation" => new \Typedin\LaravelCalendly\Entities\OrganizationInvitation($response),
		]);
	}


	public function destroy(\Typedin\LaravelCalendly\Http\DeleteOrganizationInvitationRequest $request)
	{
		$this->api->delete("/organizations/{$org_uuid}/invitations/{$uuid}/");
	}
}
