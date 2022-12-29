<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyCancellation;

class CalendlyCancellation
{
    /**
     * Name of the person whom canceled
     *
     * @var string
     */
    public string $canceled_by;

    /**
     * Reason that the cancellation occurred
     *
     * @var string|null
     */
    public string $reason;

    /** @var string<host|invitee> */
    public string $canceler_type;

    public function __construct(string $canceled_by, ?string $reason, string $canceler_type)
    {
        $this->canceled_by = $canceled_by;
        $this->reason = $reason;
        $this->canceler_type = $canceler_type;
    }
}