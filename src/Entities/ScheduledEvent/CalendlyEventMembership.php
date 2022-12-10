<?php

namespace Typedin\LaravelCalendly\Entities\ScheduledEvent;

use Carbon\Carbon;
use Typedin\LaravelCalendly\Entities\CalendlyBaseClass;
use Typedin\LaravelCalendly\Entities\User\CalendlyUser;
use Typedin\LaravelCalendly\Exceptions\CalendlyOrganizationMembershipException;
use Typedin\LaravelCalendly\traits\HasTimestamps;

class CalendlyEventMembership extends CalendlyBaseClass
{
    use HasTimestamps;

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
     * @var string<organization>
     */
    public string $organization;

    /**
     * @var membership<CalendlyUser>
     */
    public CalendlyUser $membership;

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
                $value = new CalendlyUser(
                    array_merge($value, ['current_organization' => $args['organization']]),
                );
            }
            $this->$key = $value;
        });
    }
}
