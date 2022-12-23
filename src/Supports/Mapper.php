<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;

class Mapper
{
    public const LOOKUP = [
        'Data Compliance' => 'data_compliance',
        'Event Types' => 'event_types',
        'Organizations' => 'organizations',
        'Routing Forms' => 'routing_forms',
        'Scheduled Events' => 'scheduled_events',
        'Scheduling Links' => 'scheduled_links',
        'Users' => 'users',
        'Webhooks' => 'webhook_subscriptions',
    ];

    /**
     * @var Collection<TKey,TValue>
     */
    private Collection $paths;

    public function __construct(private array $data, private string $tag)
    {
        $this->paths = collect($this->data['paths']);
    }

    public function handle(): Collection
    {
        return $this->endpoints()
               ->mapWithKeys(fn ($value) => [$value['uri'] => [
                   'uri' => $value['uri'],
                   'methods' => $this->getMethodsForEndpoint($value['uri']),
               ]]);
    }

    private function endpoints(): Collection
    {
        return $this->paths
                ->keys()
                ->filter(fn ($ke) => $this->findEndpointForTag($ke))
                ->map(fn ($uri) => ['uri' => $uri]);
    }

    private function findEndpointForTag($key): bool
    {
        return explode('/', $key)[1] == self::LOOKUP[$this->tag];
    }

    private function getMethodsForEndpoint($uri): array
    {
        return collect($this->paths->get($uri))
                ->filter(fn ($value, $key) => in_array($key, ['get', 'post', 'delete']))
                ->all();
    }
}
