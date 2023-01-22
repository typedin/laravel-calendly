<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyUserBusyTime
{
    /**
     * Indicates whether the scheduled event is internal or external
     * @var string<calendly|external>
     */
    public string $type;

    /**
     * The start time of the scheduled event in UTC time
     * @var string
     */
    public string $start_time;

    /**
     * The end time of the scheduled event in UTC time
     * @var string
     */
    public string $end_time;

    public function __construct(string $type, string $start_time, string $end_time)
    {
        $this->type = $type;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
    }
}
