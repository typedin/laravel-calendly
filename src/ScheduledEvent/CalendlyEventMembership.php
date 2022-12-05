<?php

namespace Typedin\LaravelCalendly\ScheduledEvent;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Typedin\LaravelCalendly\CalendlyUser;
use Typedin\LaravelCalendly\Exceptions\CalendlyOrganizationMembershipException;

class CalendlyEventMembership
{
    /**
     * Canonical reference (unique identifier) for the membership
     * Example:https://api.calendly.com/organization_membership/AAAAAAAAAAAAAAAA
     *
     * @var string<uri>
     */
    public string $uri;

    /**
     * The membership's role in the organization
     * Example: admin
     *
     * @var string<admin|membership|owner>
     */
    public string $role;

    /**
     * Canonical reference (unique identifier) for the membership
     *Example: https://api.calendly.com/organization_memberships/AAAAAAAAAAAAAAAA
     *
     * @var string<uri>
     */
    public string $organization;

    /**
     * @var membership<CalendlyUser>
     */
    public CalendlyUser $membership;

    /**
     * The moment when the membership's record was created (e.g. "2020-01-02T03:04:05.678123Z")
     * Example:2019-01-02T03:04:05.678123Z
     *
     * @var Carbon<created_at>
     */
    public Carbon $created_at;

    /**
     * The moment when the membership's record was last updated (e.g. "2020-01-02T03:04:05.678123Z")
     * Example:2019-08-07T06:05:04.321123Z
     *
     * @var Carbon<updated_at>
     */
    public Carbon $updated_at;

    public const DATEABLE = ['created_at', 'updated_at'];

    public function __construct($args)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (! array_key_exists($key, $args)) {
                CalendlyOrganizationMembershipException::nestedKeyNotFound($key);
            }
        });

        collect($args)->each(function ($value, $key) use ($args) {
            if (in_array($key, self::DATEABLE)) {
                $value = Carbon::parse($value);
            }
            if ($key == 'user') {
                $value = new CalendlyUser(array_merge($value, ['current_organization' => $args['organization']]));
            }
            $this->$key = $value;
        });
    }

    /**
     * @return Collection<TKey,TValue>
     */
    private function keys(): Collection
    {
        return collect([
            'uri',
            'role',
            'user',
            'organization',
            'created_at',
            'updated_at',
        ]);
    }
}
