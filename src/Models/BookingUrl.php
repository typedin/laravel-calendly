<?php

namespace Typedin\LaravelCalendly\Models;

class BookingUrl
{
    public function __construct(public string $booking_url, public string $owner, public EventType $owner_type)
    {
    }
}
