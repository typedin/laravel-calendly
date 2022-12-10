<?php

namespace Typedin\LaravelCalendly\Organization;

use Carbon\Carbon;
use Typedin\LaravelCalendly\CalendlyUser;
use Typedin\LaravelCalendly\Exceptions\CalendlyOrganizationMembershipException;
use Typedin\LaravelCalendly\traits\HasAssignableKeys;
use Typedin\LaravelCalendly\traits\HasTimestamps;

class CalendlyOrganizationMembership
{
    use  HasTimestamps, HasAssignableKeys;

    /**
     * Canonical reference (unique identifier) for the membership
     * Example: https://api.calendly.com/organization_membership/AAAAAAAAAAAAAAAA
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
     * @var user<CalendlyUser>
     */
    public CalendlyUser $user;

    /**
     * Canonical reference (unique identifier) for the membership
     * Example: https://api.calendly.com/organization_memberships/AAAAAAAAAAAAAAAA
     *
     * @var string<uri>
     */
    public string $organization;

    public function __construct(array $args)
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
}
