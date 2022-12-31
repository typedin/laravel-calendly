<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyPagination;

class CalendlyPagination
{
    /**
     * The number of rows to return
     */
    public \number $count;

    public function __construct(
        \number $count,
        /**
         * URI to return the next page of an ordered list ("null" indicates no additional results are available)
         */
        public ?string $next_page,
        /**
         * URI to return the previous page of an ordered list ("null" indicates no additional results are available)
         */
        public ?string $previous_page,
        /**
         * Token to return the next page of an ordered list ("null" indicates no additional results are available)
         */
        public ?string $next_page_token,
        /**
         * Token to return the previous page of an ordered list ("null" indicates no additional results are available)
         */
        public ?string $previous_page_token,
    ) {
        $this->count = $count;
    }
}
