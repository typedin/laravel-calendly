<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyGoogleConference;

class CalendlyGoogleConference
{
	/**
	 * The event location is a Google Meet or Hangouts conference
	 * @var string<google_conference> $type
	 */
	public string $type;

	/**
	 * Indicates the current status of the Google conference
	 * @var string<initiated|processing|pushed|failed> $status
	 */
	public string $status;

	/**
	 * Google conference meeting url
	 * @var string|null $join_url
	 */
	public string $join_url;


	public function __construct(string $type, string $status, ?string $join_url)
	{
		$this->type = $type;
		$this->status = $status;
		$this->join_url = $join_url;
	}
}
