<?php

namespace Typedin\LaravelCalendly\Organization;

use Illuminate\Support\Carbon;
use Typedin\LaravelCalendly\Exceptions\CalendlyOrganizationException;
use Typedin\LaravelCalendly\traits\HasAssignableKeys;
use Typedin\LaravelCalendly\traits\HasTimestamps;
use Typedin\LaravelCalendly\traits\HasUuid;

class CalendlyOrganization
{
    use HasUuid, HasAssignableKeys, HasTimestamps;

    /**
     *   Canonical resource reference
     *   Example:https://api.calendly.com/organizations/012345678901234567890
     *
     * @var uri<string>
     */
    public string $uri;

    /*
     * Active subscription plan or trial plan
     * Example:professional
     *
     * @var string<basic | essentials | professional | teams |enterprise >
     */
    public string $plan;

    /*
    * Current stage of organization
    * Example:paid
    * @var stage <trial | free paid>
    */
    public string $stage;

    /**
     * The unique identifier in Calendly system
     * Example:AAAA-AAAA-AAAA-AAAA
     *
     * @var string<uuid>
     */
    public string $uuid;

    public function __construct(array $args)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (! array_key_exists($key, $args)) {
                CalendlyOrganizationException::nestedKeyNotFound($key);
            }
        });

        collect($args)->each(function ($value, $key) {
            if (in_array($key, self::DATEABLE)) {
                $value = Carbon::parse($value);
            }
            $this->$key = $value;
        });

        $this->uuid = $this->extractUUID('/organizations/', $args['uri']);
    }
}
