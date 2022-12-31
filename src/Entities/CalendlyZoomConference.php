<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyZoomConference;

class CalendlyZoomConference
{
	/**
	 * The event location is a Zoom conference
	 * @var string<zoom_conference> $type
	 */
	public string $type;

	/**
	 * Indicates the current status of the Zoom conference
	 * @var string<initiated|processing|pushed|failed> $status
	 */
	public string $status;

	/**
	 * Zoom meeting url
	 * @var string|null $join_url
	 */
	public string $join_url;

	/**
	 * The conference metadata supplied by Zoom
	 * @var object|null $data
	 */
	public object $data;


	public function __construct(string $type, string $status, ?string $join_url, ?object $data)
	{
		$this->type = $type;
		$this->status = $status;
		$this->join_url = $join_url;
		$this->data = $data;
	}
}
