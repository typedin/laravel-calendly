<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyActor
{
    /**
     * The type of actor
     * @var string
     */
    public string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }
}
