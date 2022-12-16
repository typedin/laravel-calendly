<?php

namespace Typedin\LaravelCalendly\Entities\ScheduledEvent;

use Carbon\Carbon;
use Typedin\LaravelCalendly\Entities\User\CalendlyUser;
use Typedin\LaravelCalendly\Exceptions\CalendlyOrganizationMembershipException;
use Typedin\LaravelCalendly\traits\HasTimestamps;

class CalendlyEventMembership extends CalendlyUser
{
    use HasTimestamps;

    /**
     *
     * Canonical reference (unique identifier) for the user
     * Example:https://api.calendly.com/users/GBGBDCAADAEDCRZ2
     *
     * @var string<user>
     */
    public string $user;


    public function __construct(array $args)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (!array_key_exists($key, $args)) {
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
