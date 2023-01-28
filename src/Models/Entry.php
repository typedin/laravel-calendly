<?php

namespace Typedin\LaravelCalendly\Models;

use Actor;

class Entry
{
    /**
     * The date and time of the entry (format: "2020-01-02T03:04:05.678Z").
     */
    public string $occurred_at;

    /**
     * The Calendly actor that took the action creating the activity log entry
     *
     * Specific actors:
     *
     * <details>
     * <summary>Calendly System</summary>
     *
     * Used when an action is performed by the Calendly system and not triggered directly by a user interaction.
     *
     * Example:
     * ```json
     * {
     *     "display_name": "Calendly System",
     *     "type": "System"
     * }
     * ```
     *
     * </details>
     *
     * <br />
     *
     * <details>
     * <summary>Calendly Support</summary>
     * Used when an action is performed by Calendly support.
     *
     * Example:
     * ```json
     * {
     *   "display_name": "Calendly Support",
     *   "organization": {
     *     "uri": "https://api.calendly.com/organizations/AAAAAAAAAAAAAAAA"
     *   },
     *   "type": "User",
     *   "uri": "https://api.calendly.com/users/AAAAAAAAAAAAAAAA"
     * }
     * ```
     * </details>
     */
    public ?Actor $actor;

    public object $details;

    public string $fully_qualified_name;

    public string $uri;

    public string $namespace;

    public string $action;

    public string $organization;

    public function __construct(
        string $occurred_at,
        ?Actor $actor,
        object $details,
        string $fully_qualified_name,
        string $uri,
        string $namespace,
        string $action,
        string $organization,
    ) {
        $this->occurred_at = $occurred_at;
        $this->actor = $actor;
        $this->details = $details;
        $this->fully_qualified_name = $fully_qualified_name;
        $this->uri = $uri;
        $this->namespace = $namespace;
        $this->action = $action;
        $this->organization = $organization;
    }
}
