<?php

namespace Typedin\LaravelCalendly\Entities;

use number;

class CalendlyPagination
{
    /**
     * The number of rows to return
     */
    public number $count;

    /**
     * URI to return the next page of an ordered list ("null" indicates no additional results are available)
     *
     * @var string|null
     */
    public string $next_page;

    /**
     * URI to return the previous page of an ordered list ("null" indicates no additional results are available)
     *
     * @var string|null
     */
    public string $previous_page;

    /**
     * Token to return the next page of an ordered list ("null" indicates no additional results are available)
     *
     * @var string|null
     */
    public string $next_page_token;

    /**
     * Token to return the previous page of an ordered list ("null" indicates no additional results are available)
     *
     * @var string|null
     */
    public string $previous_page_token;

    public function __construct(
        number $count,
        ?string $next_page,
        ?string $previous_page,
        ?string $next_page_token,
        ?string $previous_page_token,
    ) {
        $this->count = $count;
        $this->next_page = $next_page;
        $this->previous_page = $previous_page;
        $this->next_page_token = $next_page_token;
        $this->previous_page_token = $previous_page_token;
    }
}
