<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyGotoMeetingConference;

class CalendlyGotoMeetingConference
{
	/**
	 * The event location is a GoToMeeting conference
	 * @var string<gotomeeting> $type
	 */
	public string $type;

	/**
	 * Indicates the current status of the GoToMeeting conference
	 * @var string<initiated|processing|pushed|failed> $status
	 */
	public string $status;

	/**
	 * GoToMeeting conference meeting url
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
