<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyWebhookPayload
{
    /**
     * The event that caused the webhook to fire
     * @var string<invitee.created|invitee.canceled|routing_form_submission.created>
     */
    public string $event;

    /**
     * The moment when the event was created (e.g. "2020-01-02T03:04:05.678123Z")
     * @var string
     */
    public string $created_at;

    /**
     * The user who created the webhook
     * @var string
     */
    public string $created_by;

    /**
     * The payload for the webhook event. The data in the payload depends on the event.
     *
     * For example, an `invitee.*` event produces an `Invitee` object in the payload.
     */
    public $payload;

    public function __construct(string $event, string $created_at, string $created_by, $payload)
    {
        $this->event = $event;
        $this->created_at = $created_at;
        $this->created_by = $created_by;
        $this->payload = $payload;
    }
}
