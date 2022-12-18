## users 
    - /users/me: Retrieve the authenticated user's profile information.
    - /users/{uuid}: Retrieve the profile information for a specific user.
    - /users/{uuid}/event_types: Retrieve the event types for a specific user.
    - /users/{uuid}/invitees: Retrieve the invitees for a specific user.
    - /users/{uuid}/scheduled_events: Retrieve the scheduled events for a specific user.
    - /users/{uuid}/webhook_subscriptions: Retrieve the webhook subscriptions for a specific user.

## events
    - /events: Retrieve a list of events.
    - /events/{uuid}: Retrieve the details of a specific event.
    - /event_types: Retrieve a list of event types.
    - /event_types/{uuid}: Retrieve the details of a specific event type.
    - /event_types/{uuid}/availability: Retrieve the availability for a specific event type.

## invitees
    - /invitees: Retrieve a list of invitees.
    - /invitees/{uuid}: Retrieve the details of a specific invitee.
    - /invitees/{uuid}/events: Retrieve the events for a specific invitee.

## organizations
    - /organizations: Retrieve a list of organizations.
    - /organizations/{uuid}: Retrieve the details of a specific organization.
    - /organizations/{uuid}/users: Retrieve the users for a specific organization.
    - /organizations/{uuid}/event_types: Retrieve the event types for a specific organization.
    - /organizations/{uuid}/webhook_subscriptions: Retrieve the webhook subscriptions for a specific organization.

## scheduled events 
    - /users/{uuid}/scheduled_events: Retrieve the scheduled events for a specific user.
    - /scheduled_events: Retrieve a list of scheduled events.
    - /scheduled_events/{uuid}: Retrieve the details of a specific scheduled event.

## availability
    - /user_availability_schedules Returns the availability schedules of the given user.
    - /user_availability_schedules/{uuid} This will return the availability schedule of the given UUID.
    - /user_busy_times Returns an ascending list of user internal and external scheduled events within a specified date range.

## all rest api endpoints
    GET /v1/users/me: Retrieve the authenticated user's profile information.
    GET /v1/users/{id}: Retrieve the profile information for a specific user.
    GET /v1/users/{id}/event_types: Retrieve the event types for a specific user.
    GET /v1/users/{id}/invitees: Retrieve the invitees for a specific user.
    GET /v1/users/{id}/scheduled_events: Retrieve the scheduled events for a specific user.
    GET /v1/users/{id}/webhook_subscriptions: Retrieve the webhook subscriptions for a specific user.
    GET /v1/events: Retrieve a list of events.
    GET /v1/events/{id}: Retrieve the details of a specific event.
    GET /v1/event_types: Retrieve a list of event types.
    GET /v1/event_types/{id}: Retrieve the details of a specific event type.
    GET /v1/event_types/{id}/availability: Retrieve the availability for a specific event type.
    GET /v1/invitees: Retrieve a list of invitees.
    GET /v1/invitees/{id}: Retrieve the details of a specific invitee.
    GET /v1/invitees/{id}/events: Retrieve the events for a specific invitee.

    POST /v1/users: Create a new user.
    POST /v1/users/{id}/event_types: Create a new event type for a specific user.
    POST /v1/users/{id}/webhook_subscriptions: Create a new webhook subscription for a specific user.
    POST /v1/events: Create a new event.
    POST /v1/event_types: Create a new event type.
    POST /v1/invitees: Create a new invitee.

    PATCH /v1/users/{id}: Update the profile information for a specific user.
    PATCH /v1/users/{id}/event_types/{event_type_id}: Update the details of a specific event type for a specific user.
    PATCH /v1/users/{id}/webhook_subscriptions/{subscription_id}: Update the details of a specific webhook subscription for a specific user.
    PATCH /v1/events/{id}: Update the details of a specific event.
    PATCH /v1/event_types/{id}: Update the details of a specific event type.
    PATCH /v1/invitees/{id}: Update the details of a specific invitee.

    DELETE /v1/users/{id}: Delete a specific user.
    DELETE /v1/users/{id}/event_types/{event_type_id}: Delete a specific event type for a specific
