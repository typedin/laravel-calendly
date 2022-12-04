<?php

namespace Typedin\LaravelCalenly;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Typedin\LaravelCalenly\Organization\CalendlyOrganization;
use Typedin\LaravelCalenly\ScheduledEvent\CalendlyScheduledEvent;

class LaravelCalenly
{
    private String $token;

    public const BASE_URL = 'https://api.calendly.com';

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return CalendlyUser
     */
    public function getCurrentUser(): CalendlyUser
    {
        return $this->getUser('me');
    }

    /**
     * @return CalendlyUser
     */
    public function getUser(string $uuid): CalendlyUser
    {
        $user = Http::withToken($this->token)
            ->get(self::BASE_URL . '/users/' . $uuid)
            ->json('resource');

        return new CalendlyUser($user);
    }

    /**
     * @return CalendlyOrganization
     */
    public function getOrganization(CalendlyUser $user): CalendlyOrganization
    {
        $organization = Http::withToken($this->token)
            ->get(self::BASE_URL . '/organizations/' . $user->current_organization)
            ->json('resource');

        return new CalendlyOrganization($organization);
    }

    /**
     * @return Collection [CalendlyEvent]
     */
    public function getUserEventsForOrganization(CalendlyUser $user, CalendlyOrganization $organization): Collection
    {
        $events = Http::withToken($this->token)
            ->get(self::BASE_URL . '/scheduled_events', [
                'organization' => $organization->uri,
                'user' => $user->uri,
            ])
            ->json('collection');

        return collect($events)->map(fn ($event) => new CalendlyScheduledEvent($event));
    }
}
