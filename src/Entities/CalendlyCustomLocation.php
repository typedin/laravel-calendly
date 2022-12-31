<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyCustomLocation;

class CalendlyCustomLocation
{
	/**
	 * The event location doesn't fall into a standard category defined by the event host (publisher)
	 * @var string<custom> $type
	 */
	public string $type;

	/**
	 * The location description provided by the event host (publisher)
	 * @var string|null $location
	 */
	public string $location;


	public function __construct(string $type, ?string $location)
	{
		$this->type = $type;
		$this->location = $location;
	}
}
