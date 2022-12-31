<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyUserBusyTime;

class CalendlyUserBusyTime
{
	/**
	 * Indicates whether the scheduled event is internal or external
	 * @var string<calendly|external> $type
	 */
	public string $type;

	/**
	 * The start time of the scheduled event in UTC time
	 * @var string $start_time
	 */
	public string $start_time;

	/**
	 * The end time of the scheduled event in UTC time
	 * @var string $end_time
	 */
	public string $end_time;


	public function __construct(string $type, string $start_time, string $end_time)
	{
		$this->type = $type;
		$this->start_time = $start_time;
		$this->end_time = $end_time;
	}
}
