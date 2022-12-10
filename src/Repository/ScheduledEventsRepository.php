<?php

namespace Typedin\LaravelCalendly\Repository;

use Facades\Typedin\LaravelCalendly\Api\BaseApiClient;
use Illuminate\Support\Collection;
use Typedin\LaravelCalendly\Entities\Organization\CalendlyOrganization;
use Typedin\LaravelCalendly\Entities\ScheduledEvent\CalendlyScheduledEvent;
use Typedin\LaravelCalendly\Entities\User\CalendlyUser;

class ScheduledEventsRepository
{
    public static function list(CalendlyUser $user, CalendlyOrganization $organization, $args = []): Collection
    {
        $response = BaseApiClient::get('scheduled_events', array_merge(
            [
                'user' => $user->uri,
                'organization' => $organization->uri,
            ],
            self::parseOptionalArguments($args)
        ));

        return collect($response->json('collection'))
            ->map(fn ($args) => new CalendlyScheduledEvent($args));
    }

    private static function parseOptionalArguments($args): array
    {
        $result = [];
        if (array_key_exists('min_start_time', $args)) {
            $date = $args['min_start_time'];
            $result['min_start_time'] = $date->toISOString();
        }
        if (array_key_exists('max_start_time', $args)) {
            $date = $args['max_start_time'];
            $result['max_start_time'] = $date->toISOString();
        }

        return array_merge($args, $result);
    }
}
