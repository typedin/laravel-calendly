<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyWebExConference;

class CalendlyWebExConference
{
	/**
	 * The event location is a WebEx conference
	 * @var string<webex_conference> $type
	 */
	public string $type;

	/**
	 * Indicates the current status of the WebEx conference
	 * @var string<initiated|processing|pushed|failed> $status
	 */
	public string $status;

	/**
	 * WebEx conference meeting url
	 * @var string|null $join_url
	 */
	public string $join_url;

	/**
	 * The conference metadata supplied by GoToMeeting
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
