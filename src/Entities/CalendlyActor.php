<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyActor
{
    /**
     * The type of actor
     * @var string $type
     */
    public string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }
}
