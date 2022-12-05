<?php

namespace Typedin\LaravelCalendly\Api;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Typedin\LaravelCalendly\CalendlyUser;
use Typedin\LaravelCalendly\ScheduledEvent\CalendlyScheduledEvent;

class CalendlyApi extends Factory
{
    private const USER_URL = 'users';

    private const SCHEDULED_EVENTS_URL = 'scheduled_events';

    private string $apiKey;

    private string $api_endpoint;

    public function __construct(string $apiKey, string $api_endpoint)
    {
        parent::__construct();

        $this->apiKey = $apiKey;
        $this->api_endpoint = $api_endpoint;
    }

    /**
     * @return PendingRequest
     */
    protected function newPendingRequest(): PendingRequest
    {
        return parent::newPendingRequest()
            ->withToken($this->apiKey)
            ->baseUrl($this->api_endpoint)
            ->acceptJson()
            ->asJson();
    }

    /**
     * @return CalendlyUser
     */
    public function getUser($user = 'me'): CalendlyUser
    {
        $user = $this->newPendingRequest()
            ->get(self::USER_URL . "/{$user}")
            ->json('resource');

        return new CalendlyUser($user, $this->api_endpoint);
    }

    /**
     * @return Collection<CalendlyScheduledEvent>
     */
    public function listScheduledEvents(CalendlyUser $user): Collection
    {
        $events = $this->newPendingRequest()
            ->get(self::SCHEDULED_EVENTS_URL, [
                'user' => $user->uri,
            ])
            ->json('collection');

        return collect($events)->map(fn ($event) => new CalendlyScheduledEvent($event, $this->api_endpoint));
    }
}
