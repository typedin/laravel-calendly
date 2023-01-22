<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyWebhookSubscription
{
    /**
     * Canonical reference (unique identifier) for the webhook
     * @var string
     */
    public string $uri;

    /**
     * The callback URL to use when the event is triggered
     * @var string
     */
    public string $callback_url;

    /**
     * The moment when the webhook subscription was created (e.g. "2020-01-02T03:04:05.678123Z")
     * @var string
     */
    public string $created_at;

    /**
     * The moment when the webhook subscription was last updated (e.g. "2020-01-02T03:04:05.678123Z")
     * @var string
     */
    public string $updated_at;

    /**
     * The date and time the webhook subscription is retried
     * @var string|null
     */
    public string $retry_started_at;

    /**
     * Indicates if the webhook subscription is "active" or "disabled"
     * @var string<active|disabled>
     */
    public string $state;

    /**
     * A list of events to which the webhook is subscribed
     * @var array
     */
    public array $events;

    /**
     * The scope of the webhook subscription
     * @var string<user|organization>
     */
    public string $scope;

    /**
     * The URI of the organization that's associated with the webhook subscription
     * @var string
     */
    public string $organization;

    /**
     * The URI of the user that's associated with the webhook subscription
     * @var string|null
     */
    public string $user;

    /**
     * The URI of the user who created the webhook subscription
     * @var string|null
     */
    public string $creator;

    public function __construct(
        string $uri,
        string $callback_url,
        string $created_at,
        string $updated_at,
        ?string $retry_started_at,
        string $state,
        array $events,
        string $scope,
        string $organization,
        ?string $user,
        ?string $creator,
    ) {
        $this->uri = $uri;
        $this->callback_url = $callback_url;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->retry_started_at = $retry_started_at;
        $this->state = $state;
        $this->events = $events;
        $this->scope = $scope;
        $this->organization = $organization;
        $this->user = $user;
        $this->creator = $creator;
    }
}
