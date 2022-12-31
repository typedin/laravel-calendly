<?php

namespace Typedin\LaravelCalendly\Entities\CalendlySubmissionEventTypeResult;

class CalendlySubmissionEventTypeResult
{
	/**
	 * Indicates that the routing form submission resulted in a redirect to an event type booking page.
	 * @var string<event_type> $type
	 */
	public string $type;

	/**
	 * A reference to the event type resource.
	 * @var string $value
	 */
	public string $value;


	public function __construct(string $type, string $value)
	{
		$this->type = $type;
		$this->value = $value;
	}
}
