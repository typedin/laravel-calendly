<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyUser;

class CalendlyUser
{
	/**
	 * Canonical reference (unique identifier) for the user
	 * @var string $uri
	 */
	public string $uri;

	/**
	 * The user's name (human-readable format)
	 * @var string $name
	 */
	public string $name;

	/**
	 * The portion of URL for the user's scheduling page (where invitees book sessions), rendered in a human-readable format
	 * @var string $slug
	 */
	public string $slug;

	/**
	 * The user's email address
	 * @var string $email
	 */
	public string $email;

	/**
	 * The URL of the user's Calendly landing page (that lists all the user's event types)
	 * @var string $scheduling_url
	 */
	public string $scheduling_url;

	/**
	 * The time zone to use when presenting time to the user
	 * @var string $timezone
	 */
	public string $timezone;

	/**
	 * The URL of the user's avatar (image)
	 * @var string|null $avatar_url
	 */
	public string $avatar_url;

	/**
	 * The moment when the user's record was created (e.g. "2020-01-02T03:04:05.678123Z")
	 * @var string $created_at
	 */
	public string $created_at;

	/**
	 * The moment when the user's record was last updated (e.g. "2020-01-02T03:04:05.678123Z")
	 * @var string $updated_at
	 */
	public string $updated_at;

	/**
	 * A unique reference to the user's current organization
	 * @var string $current_organization
	 */
	public string $current_organization;


	public function __construct(
		string $uri,
		string $name,
		string $slug,
		string $email,
		string $scheduling_url,
		string $timezone,
		?string $avatar_url,
		string $created_at,
		string $updated_at,
		string $current_organization,
	) {
		$this->uri = $uri;
		$this->name = $name;
		$this->slug = $slug;
		$this->email = $email;
		$this->scheduling_url = $scheduling_url;
		$this->timezone = $timezone;
		$this->avatar_url = $avatar_url;
		$this->created_at = $created_at;
		$this->updated_at = $updated_at;
		$this->current_organization = $current_organization;
	}
}
