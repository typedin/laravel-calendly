<?php

use Illuminate\Support\Facades\Route;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyActivityLogEntriesController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyDataComplianceInviteesController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyEventTypeAvailableTimesController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyEventTypesController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyInviteeNoShowsController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyOrganizationInvitationsController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyOrganizationMembershipsController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyRoutingFormsController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyRoutingFormSubmissionsController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyScheduledEventCancellationsController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyScheduledEventInviteesController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyScheduledEventsController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlySchedulingLinksController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyUserAvailabilitySchedulesController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyUserBusyTimesController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyUsersController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyWebhookSubscriptionsController;

Route::get('/activity_log_entries', [CalendlyActivityLogEntriesController::class, 'index']);
Route::post('/data_compliance/deletion/invitees', [CalendlyDataComplianceInviteesController::class, 'create']);
Route::get('/event_type_available_times', [CalendlyEventTypeAvailableTimesController::class, 'index']);
Route::get('/event_types', [CalendlyEventTypesController::class, 'index']);
Route::get('/event_types/{uuid}', [CalendlyEventTypesController::class, 'show']);
Route::post('/invitee_no_shows', [CalendlyInviteeNoShowsController::class, 'create']);
Route::get('/invitee_no_shows/{uuid}', [CalendlyInviteeNoShowsController::class, 'show']);
Route::delete('/invitee_no_shows/{uuid}', [CalendlyInviteeNoShowsController::class, 'destroy']);
Route::get('/organization_memberships', [CalendlyOrganizationMembershipsController::class, 'index']);
Route::get('/organization_memberships/{uuid}', [CalendlyOrganizationMembershipsController::class, 'show']);
Route::delete('/organization_memberships/{uuid}', [CalendlyOrganizationMembershipsController::class, 'destroy']);
Route::delete('/organizations/{org_uuid}/invitations/{uuid}', [CalendlyOrganizationInvitationsController::class, 'destroy']);
Route::get('/organizations/{org_uuid}/invitations/{uuid}', [CalendlyOrganizationInvitationsController::class, 'show']);
Route::get('/organizations/{uuid}/invitations', [CalendlyOrganizationInvitationsController::class, 'index']);
Route::post('/organizations/{uuid}/invitations', [CalendlyOrganizationInvitationsController::class, 'create']);
Route::get('/routing_form_submissions', [CalendlyRoutingFormSubmissionsController::class, 'index']);
Route::get('/routing_form_submissions/{uuid}', [CalendlyRoutingFormSubmissionsController::class, 'show']);
Route::get('/routing_forms', [CalendlyRoutingFormsController::class, 'index']);
Route::get('/routing_forms/{uuid}', [CalendlyRoutingFormsController::class, 'show']);
Route::get('/scheduled_events', [CalendlyScheduledEventsController::class, 'index']);
Route::get('/scheduled_events/{event_uuid}/invitees/{invitee_uuid}', [CalendlyScheduledEventInviteesController::class, 'show']);
Route::get('/scheduled_events/{uuid}', [CalendlyScheduledEventsController::class, 'show']);
Route::post('/scheduled_events/{uuid}/cancellation', [CalendlyScheduledEventCancellationsController::class, 'create']);
Route::get('/scheduled_events/{uuid}/invitees', [CalendlyScheduledEventInviteesController::class, 'index']);
Route::post('/scheduling_links', [CalendlySchedulingLinksController::class, 'create']);
Route::get('/user_availability_schedules', [CalendlyUserAvailabilitySchedulesController::class, 'index']);
Route::get('/user_availability_schedules/{uuid}', [CalendlyUserAvailabilitySchedulesController::class, 'show']);
Route::get('/user_busy_times', [CalendlyUserBusyTimesController::class, 'index']);
Route::get('/users/me', [CalendlyUsersController::class, 'show']);
Route::get('/users/{uuid}', [CalendlyUsersController::class, 'show']);
Route::post('/webhook_subscriptions', [CalendlyWebhookSubscriptionsController::class, 'create']);
Route::get('/webhook_subscriptions', [CalendlyWebhookSubscriptionsController::class, 'index']);
Route::get('/webhook_subscriptions/{webhook_uuid}', [CalendlyWebhookSubscriptionsController::class, 'show']);
Route::delete('/webhook_subscriptions/{webhook_uuid}', [CalendlyWebhookSubscriptionsController::class, 'destroy']);
