<?php

namespace Typedin\LaravelCalendly\Models;

class Cancellation
{
    /**
     * Name of the person whom canceled
     * @var string $canceled_by
     */
    public string $canceled_by;

    /**
     * Reason that the cancellation occurred
     * @var string $reason
     */
    public ?string $reason;

    /** @var string $canceler_type */
    public string $canceler_type;

    public function __construct(string $canceled_by, ?string $reason, string $canceler_type)
    {
        $this->canceled_by = $canceled_by;
        $this->reason = $reason;
        $this->canceler_type = $canceler_type;
    }
}
