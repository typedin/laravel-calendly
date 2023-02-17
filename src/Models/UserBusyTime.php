<?php

namespace Typedin\LaravelCalendly\Models;

class UserBusyTime
{
    /**
     * Indicates whether the scheduled event is internal or external
     * @var string $type
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

    /**
     * The start time of the calendly event, as calculated by any "before" buffer set by the user
     * @var string $buffered_start_time
     */
    public ?string $buffered_start_time;

    /**
     * The end time of the calendly event, as calculated by any "after" buffer set by the user
     * @var string $buffered_end_time
     */
    public ?string $buffered_end_time;

    /** @var object $event */
    public ?object $event;

    public function __construct(
        string $type,
        string $start_time,
        string $end_time,
        ?string $buffered_start_time,
        ?string $buffered_end_time,
        ?object $event,
    ) {
        $this->type = $type;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->buffered_start_time = $buffered_start_time;
        $this->buffered_end_time = $buffered_end_time;
        $this->event = $event;
    }
}
