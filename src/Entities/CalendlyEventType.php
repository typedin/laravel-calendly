<?php

namespace Typedin\LaravelCalendly\Entities;

use number;

class CalendlyEventType
{
    /**
     * Canonical reference (unique identifier) for the event type
     * @var string
     */
    public string $uri;

    /**
     * The event type name (in human-readable format)
     * @var string|null
     */
    public string $name;

    /**
     * Indicates if the event is active or not.
     * @var bool
     */
    public bool $active;

    /**
     * The portion of the event type's URL that identifies a specific web page (in a human-readable format)
     * @var string|null
     */
    public string $slug;

    /**
     * The URL of the user’s scheduling site where invitees book this event type
     * @var string
     */
    public string $scheduling_url;

    /**
     * The length of sessions booked with this event type
     * @var number
     */
    public number $duration;

    /**
     * Indicates if the event type is "solo" (belongs to an individual user) or "group"
     * @var string<solo|group>
     */
    public string $kind;

    /**
     * Indicates if the event type is "round robin" (alternates between hosts) or "collective" (invitees pick a time when all participants are available) or "null" (the event type doesn’t consider the availability of a group participants)
     * @var string<round_robin|collective>
     */
    public string $pooling_type;

    /**
     * Indicates if the event type is "AdhocEventType" (ad hoc event) or "StandardEventType" (standard event type)
     * @var string<StandardEventType|AdhocEventType>
     */
    public string $type;

    /**
     * The hexadecimal color value of the event type's scheduling page
     * @var string
     */
    public string $color;

    /**
     * The moment the event type was created (e.g. "2020-01-02T03:04:05.678123Z")
     * @var string
     */
    public string $created_at;

    /**
     * The moment the event type was last updated (e.g. "2020-01-02T03:04:05.678123Z")
     * @var string
     */
    public string $updated_at;

    /**
     * Contents of a note that may be associated with the event type
     * @var string|null
     */
    public string $internal_note;

    /**
     * The event type's description (in non formatted text)
     * @var string|null
     */
    public string $description_plain;

    /**
     * The event type's description (formatted with HTML)
     * @var string|null
     */
    public string $description_html;
    public $profile;

    /**
     * Indicates if the event type is hidden on the owner's main scheduling page
     * @var bool
     */
    public bool $secret;

    /**
     * Indicates if the event type is for a poll or an instant booking
     * @var string<instant|poll>
     */
    public string $booking_method;

    /** @var array */
    public array $custom_questions;

    /**
     * The moment the event type was deleted (e.g. "2020-01-02T03:04:05.678123Z"). Since event types can be deleted but their scheduled events remain it's useful to fetch a deleted event type when you still require event type data for a scheduled event.
     * @var string|null
     */
    public string $deleted_at;

    /**
     * A formatted description of the kind of event type.
     * @var string<Collective|Group|One-on-One|Round Robin>
     */
    public string $kind_description;

    /**
     * Indicates if this event type is managed by an organization admin
     * @var bool
     */
    public bool $admin_managed;

    public function __construct(
        string $uri,
        ?string $name,
        bool $active,
        ?string $slug,
        string $scheduling_url,
        number $duration,
        string $kind,
        ?string $pooling_type,
        string $type,
        string $color,
        string $created_at,
        string $updated_at,
        ?string $internal_note,
        ?string $description_plain,
        ?string $description_html,
        $profile,
        bool $secret,
        string $booking_method,
        array $custom_questions,
        ?string $deleted_at,
        string $kind_description,
        bool $admin_managed,
    ) {
        $this->uri = $uri;
        $this->name = $name;
        $this->active = $active;
        $this->slug = $slug;
        $this->scheduling_url = $scheduling_url;
        $this->duration = $duration;
        $this->kind = $kind;
        $this->pooling_type = $pooling_type;
        $this->type = $type;
        $this->color = $color;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->internal_note = $internal_note;
        $this->description_plain = $description_plain;
        $this->description_html = $description_html;
        $this->profile = $profile;
        $this->secret = $secret;
        $this->booking_method = $booking_method;
        $this->custom_questions = $custom_questions;
        $this->deleted_at = $deleted_at;
        $this->kind_description = $kind_description;
        $this->admin_managed = $admin_managed;
    }
}
