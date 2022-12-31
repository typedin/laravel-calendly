<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyOrganization;

class CalendlyOrganization
{
    /**
     * @param  mixed  $plan
     * @param  mixed  $stage
     */
    public function __construct(
     /**
      * Canonical resource reference
      */
     public string $uri,
     /**
      * Active subscription plan or trial plan
      */
     public string $plan,
     /**
      * Current stage of organization
      */
     public string $stage,
     /**
      * Timestamp of when the organization was created.
      */
     public string $created_at,
     /**
      * Timestamp of when the organization was created or updated.
      */
     public string $updated_at
 ) {
    }
}
