<?php

namespace Typedin\LaravelCalendly\Entities\CalendlySubmissionExternalUrlResult;

class CalendlySubmissionExternalUrlResult
{
    /**
     * @param  mixed  $type
     */
    public function __construct(
     /**
      * Indicates that the routing form submission resulted in a redirect to an external URL.
      */
     public string $type,
     /**
      * The external URL the respondent were redirected to.
      */
     public string $value
    ) {
    }
}
