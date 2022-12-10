<?php

namespace Typedin\LaravelCalendly\Entities\User;

use Carbon\Carbon;
use Typedin\LaravelCalendly\Entities\CalendlyBaseClass;
use Typedin\LaravelCalendly\Exceptions\CalendlyUserException;
use Typedin\LaravelCalendly\traits\HasTimestamps;
use Typedin\LaravelCalendly\traits\HasUuid;

class CalendlyUser extends CalendlyBaseClass
{
    use HasUuid, HasTimestamps;

    /**
     * The URL of the user's avatar (image)
     * Example: https://01234567890.cloudfront.net/uploads/user/avatar/0123456/a1b2c3d4.png
     *
     * @var string or null
     */
    public string $avatar_url;

    /**
     * A unique reference to the user's current organization
     * Example: https://api.calendly.com/organizations/AAAAAAAAAAAAAAAA
     *
     * @var
     */
    public string $current_organization;

    /**
     * The user's email address
     * Example: test@example.com
     *
     * @var string<email>
     */
    public string $email;

    /**
     * The user's name (human-readable format)
     * Example: John Doe
     *
     * @var string<name>
     */
    public string $name;

    /**
     * The URL of the user's Calendly landing page (that lists all the user's event types)
     * Example: https://calendly.com/acmesales
     *
     * @var string<scheduling_url>
     */
    public string $scheduling_url;

    /**
     * The portion of URL for the user's scheduling page (where invitees book sessions), rendered in a human-readable format
     * Example: acmesales
     *
     * @var string<slug>
     */
    public string $slug;

    /**
     * The time zone to use when presenting time to the user
     * Example: America/New York
     *
     * @var string<timezone>
     */
    public string $timezone;

    /**
     * Canonical reference (unique identifier) for the user
     * Example: https://api.calendly.com/users/AAAAAAAAAAAAAAAA
     *
     * @var string<uri>
     */
    public string $uri;

    public function __construct(array $args)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (! array_key_exists($key, $args)) {
                CalendlyUserException::nestedKeyNotFound($key);
            }
        });

        collect($args)->each(function ($value, $key) {
            if (in_array($key, self::DATEABLE)) {
                $value = Carbon::parse($value);
            }
            $this->$key = $value;
        });

        $this->uuid = $this->extractUUID('/users/', $args['uri']);

        $this->current_organization = $this->extractUUID('/organizations/', $args['current_organization']);
    }
}
