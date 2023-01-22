<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyInvitee
{
    /**
     * Canonical reference (unique identifier) for the invitee
     *
     * @var string
     */
    public string $uri;

    /**
     * The invitee’s email address
     *
     * @var string
     */
    public string $email;

    /**
     * The first name of the invitee who booked the event when the event type is configured to use separate fields for first name and last name. Null when event type is configured to use a single field for name.
     *
     * @var string|null
     */
    public string $first_name;

    /**
     * The last name of the invitee who booked the event when the event type is configured to use separate fields for first name and last name. Null when event type is configured to use a single field for name.
     *
     * @var string|null
     */
    public string $last_name;

    /**
     * The invitee’s name (in human-readable format)
     *
     * @var string
     */
    public string $name;

    /**
     * Indicates if the invitee is "active" or "canceled"
     *
     * @var string<active|canceled>
     */
    public string $status;

    /**
     * A collection of the invitee's responses to questions on the event booking confirmation form
     *
     * @var array
     */
    public array $questions_and_answers;

    /**
     * Time zone to use when displaying time to the invitee
     *
     * @var string|null
     */
    public string $timezone;

    /**
     * A reference to the event
     *
     * @var string
     */
    public string $event;

    /**
     * The moment when the event was created (e.g. "2020-01-02T03:04:05.678123Z")
     *
     * @var string
     */
    public string $created_at;

    /**
     * The moment when the event was last updated (e.g. "2020-01-02T03:04:05.678123Z")
     *
     * @var string
     */
    public string $updated_at;

    public $tracking;

    /**
     * The phone number to use when sending text (SMS) reminders
     *
     * @var string|null
     */
    public string $text_reminder_number;

    /**
     * Indicates if this invitee has rescheduled. If `true`, a reference to the new Invitee instance is provided in the `new_invitee` field.
     *
     * @var bool
     */
    public bool $rescheduled;

    /**
     * Reference to old Invitee instance that got rescheduled
     *
     * @var string|null
     */
    public string $old_invitee;

    /**
     * Link to new invitee, after reschedule
     *
     * @var string|null
     */
    public string $new_invitee;

    /**
     * Link to cancelling the event for the invitee
     *
     * @var string
     */
    public string $cancel_url;

    /**
     * Link to rescheduling the event for the invitee
     *
     * @var string
     */
    public string $reschedule_url;

    /**
     * Reference to a routing form submission that redirected the invitee to a booking page.
     *
     * @var string|null
     */
    public string $routing_form_submission;

    /**
     * Invitee payment
     *
     * @var object|null
     */
    public object $payment;

    /**
     * Provides data pertaining to the associated no show for the Invitee
     *
     * @var object|null
     */
    public object $no_show;

    /**
     * Assuming reconfirmation is enabled for the event type, when reconfirmation is requested this object is present with a `created_at` that reflects when the reconfirmation notification was sent. Once the invitee has reconfirmed the `confirmed_at` attribute will change from `null` to a timestamp that reflects when they took action.
     *
     * @var object|null
     */
    public object $reconfirmation;

    public function __construct(
        string $uri,
        string $email,
        ?string $first_name,
        ?string $last_name,
        string $name,
        string $status,
        array $questions_and_answers,
        ?string $timezone,
        string $event,
        string $created_at,
        string $updated_at,
        $tracking,
        ?string $text_reminder_number,
        bool $rescheduled,
        ?string $old_invitee,
        ?string $new_invitee,
        string $cancel_url,
        string $reschedule_url,
        ?string $routing_form_submission,
        ?object $payment,
        ?object $no_show,
        ?object $reconfirmation,
    ) {
        $this->uri = $uri;
        $this->email = $email;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->name = $name;
        $this->status = $status;
        $this->questions_and_answers = $questions_and_answers;
        $this->timezone = $timezone;
        $this->event = $event;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->tracking = $tracking;
        $this->text_reminder_number = $text_reminder_number;
        $this->rescheduled = $rescheduled;
        $this->old_invitee = $old_invitee;
        $this->new_invitee = $new_invitee;
        $this->cancel_url = $cancel_url;
        $this->reschedule_url = $reschedule_url;
        $this->routing_form_submission = $routing_form_submission;
        $this->payment = $payment;
        $this->no_show = $no_show;
        $this->reconfirmation = $reconfirmation;
    }
}
