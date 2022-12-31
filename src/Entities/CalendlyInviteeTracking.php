<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyInviteeTracking;

class CalendlyInviteeTracking
{
    public function __construct(
     /**
      * The UTM parameter used to track a campaign
      */
     public ?string $utm_campaign,
     /**
      * The UTM parameter that identifies the source (platform where the traffic originates)
      */
     public ?string $utm_source,
     /**
      * The UTM parameter that identifies the type of input (e.g. Cost Per Click (CPC), social media, affiliate or QR code)
      */
     public ?string $utm_medium,
     /**
      * UTM content tracking parameter
      */
     public ?string $utm_content,
     /**
      * The UTM parameter used to track keywords
      */
     public ?string $utm_term,
     /**
      * The Salesforce record unique identifier
      */
     public ?string $salesforce_uuid
    ) {
    }
}
