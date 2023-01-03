<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyInvitee
{
    /**
     * @param  mixed  $status
     */
    public function __construct(
        /**
         * Canonical reference (unique identifier) for the invitee
         */
        public string $uri,
        /**
         * The invitee’s email address
         */
        public string $email,
        /**
         * The first name of the invitee who booked the event when the event type is configured to use separate fields for first name and last name. Null when event type is configured to use a single field for name.
         */
        public ?string $first_name,
        /**
         * The last name of the invitee who booked the event when the event type is configured to use separate fields for first name and last name. Null when event type is configured to use a single field for name.
         */
        public ?string $last_name,
        /**
         * The invitee’s name (in human-readable format)
         */
        public string $name,
        /**
         * Indicates if the invitee is "active" or "canceled"
         */
        public string $status,
        /**
         * A collection of the invitee's responses to questions on the event booking confirmation form
         */
        public array $questions_and_answers,
        /**
         * Time zone to use when displaying time to the invitee
         */
        public ?string $timezone,
        /**
         * A reference to the event
         */
        public string $event,
        /**
         * The moment when the event was created (e.g. "2020-01-02T03:04:05.678123Z")
         */
        public string $created_at,
        /**
         * The moment when the event was last updated (e.g. "2020-01-02T03:04:05.678123Z")
         */
        public string $updated_at,
        public $tracking,
        /**
         * The phone number to use when sending text (SMS) reminders
         */
        public ?string $text_reminder_number,
        /**
         * Indicates if this invitee has rescheduled. If `true`, a reference to the new Invitee instance is provided in the `new_invitee` field.
         */
        public bool $rescheduled,
        /**
         * Reference to old Invitee instance that got rescheduled
         */
        public ?string $old_invitee,
        /**
         * Link to new invitee, after reschedule
         */
        public ?string $new_invitee,
        /**
         * Link to cancelling the event for the invitee
         */
        public string $cancel_url,
        /**
         * Link to rescheduling the event for the invitee
         */
        public string $reschedule_url,
        /**
         * Reference to a routing form submission that redirected the invitee to a booking page.
         */
        public ?string $routing_form_submission,
        /**
         * Invitee payment
         */
        public ?object $payment,
        /**
         * Provides data pertaining to the associated no show for the Invitee
         */
        public ?object $no_show,
        /**
         * Assuming reconfirmation is enabled for the event type, when reconfirmation is requested this object is present with a `created_at` that reflects when the reconfirmation notification was sent. Once the invitee has reconfirmed the `confirmed_at` attribute will change from `null` to a timestamp that reflects when they took action.
         */
        public ?object $reconfirmation
    ) {
    }
}
