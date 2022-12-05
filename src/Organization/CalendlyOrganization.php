<?php

namespace Typedin\LaravelCalendly\Organization;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Typedin\LaravelCalendly\Exceptions\CalendlyOrganizationException;

class CalendlyOrganization
{
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

    /**
     * The moment when the organization's record was created (e.g. "2020-01-02T03:04:05.678123Z")
     * Example:2019-01-02T03:04:05.678123Z
     *
     * @var Carbon<created_at>
     */
    public Carbon $created_at;

    /*
    * The moment when the organization's record was last updated (e.g. "2020-01-02T03:04:05.678123Z")
    * Example:2019-08-07T06:05:04.321123Z
    *
    * @var Carbon<updated_at>
    */
    public Carbon $updated_at;

    public const DATEABLE = ['created_at', 'updated_at'];

    public function __construct(array $args, string $base_url)
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

        $this->uuid = str_replace($base_url.'/organizations/', '', $args['uri']);
    }

    /**
     * @return Collection<TKey,TValue>
     */
    private function keys(): Collection
    {
        return collect([
            'uri',
            'plan',
            'stage',
            'created_at',
            'updated_at',
        ]);
    }
}
