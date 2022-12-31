<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyOrganizationMembership;

class CalendlyOrganizationMembership
{
	/**
	 * Canonical reference (unique identifier) for the membership
	 * @var string $uri
	 */
	public string $uri;

	/**
	 * The user's role in the organization
	 * @var string<user|admin|owner> $role
	 */
	public string $role;

	/**
	 * Information about the user.
	 * @var object $user
	 */
	public object $user;

	/**
	 * A unique reference to the organization
	 * @var string $organization
	 */
	public string $organization;

	/**
	 * The moment when the membership record was last updated (e.g. "2020-01-02T03:04:05.678123Z")
	 * @var string $updated_at
	 */
	public string $updated_at;

	/**
	 * The moment when the membership record was created (e.g. "2020-01-02T03:04:05.678123Z")
	 * @var string $created_at
	 */
	public string $created_at;


	public function __construct(
		string $uri,
		string $role,
		object $user,
		string $organization,
		string $updated_at,
		string $created_at,
	) {
		$this->uri = $uri;
		$this->role = $role;
		$this->user = $user;
		$this->organization = $organization;
		$this->updated_at = $updated_at;
		$this->created_at = $created_at;
	}
}
