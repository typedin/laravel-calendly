<?php

use Illuminate\Support\Facades\Route;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyActivityLogEntriesController;
use Typedin\LaravelCalendly\Http\Controllers\CalendlyDataComplianceDeletionInviteesController;
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
Route::post('/data_compliance/deletion/invitee', [CalendlyDataComplianceDeletionInviteesController::class, 'create']);
Route::get('/event_type_available_times', [CalendlyEventTypeAvailableTimesController::class, 'index']);
Route::get('/event_types', [CalendlyEventTypesController::class, 'index']);
Route::get('/event_type', [CalendlyEventTypesController::class, 'show']);
Route::post('/invitee_no_show', [CalendlyInviteeNoShowsController::class, 'create']);
Route::get('/invitee_no_show', [CalendlyInviteeNoShowsController::class, 'show']);
Route::delete('/invitee_no_show', [CalendlyInviteeNoShowsController::class, 'destroy']);
Route::get('/organization_memberships', [CalendlyOrganizationMembershipsController::class, 'index']);
Route::get('/organization_membership', [CalendlyOrganizationMembershipsController::class, 'show']);
Route::delete('/organization_membership', [CalendlyOrganizationMembershipsController::class, 'destroy']);
Route::delete('/organization/invitation', [CalendlyOrganizationInvitationsController::class, 'destroy']);
Route::get('/organization/invitation', [CalendlyOrganizationInvitationsController::class, 'show']);
Route::get('/organization/invitations', [CalendlyOrganizationInvitationsController::class, 'index']);
Route::post('/organization/invitation', [CalendlyOrganizationInvitationsController::class, 'create']);
Route::get('/routing_form_submissions', [CalendlyRoutingFormSubmissionsController::class, 'index']);
Route::get('/routing_form_submission', [CalendlyRoutingFormSubmissionsController::class, 'show']);
Route::get('/routing_forms', [CalendlyRoutingFormsController::class, 'index']);
Route::get('/routing_form', [CalendlyRoutingFormsController::class, 'show']);
Route::get('/scheduled_events', [CalendlyScheduledEventsController::class, 'index']);
Route::get('/scheduled_event/invitee', [CalendlyScheduledEventInviteesController::class, 'show']);
Route::get('/scheduled_event', [CalendlyScheduledEventsController::class, 'show']);
Route::post('/scheduled_event/cancellation', [CalendlyScheduledEventCancellationsController::class, 'create']);
Route::get('/scheduled_event/invitees', [CalendlyScheduledEventInviteesController::class, 'index']);
Route::post('/scheduling_link', [CalendlySchedulingLinksController::class, 'create']);
Route::get('/user_availability_schedules', [CalendlyUserAvailabilitySchedulesController::class, 'index']);
Route::get('/user_availability_schedule', [CalendlyUserAvailabilitySchedulesController::class, 'show']);
Route::get('/user_busy_times', [CalendlyUserBusyTimesController::class, 'index']);
Route::get('/user/me', [CalendlyUsersController::class, 'show']);
Route::get('/user', [CalendlyUsersController::class, 'show']);
Route::post('/webhook_subscription', [CalendlyWebhookSubscriptionsController::class, 'create']);
Route::get('/webhook_subscriptions', [CalendlyWebhookSubscriptionsController::class, 'index']);
Route::get('/webhook_subscription', [CalendlyWebhookSubscriptionsController::class, 'show']);
Route::delete('/webhook_subscription', [CalendlyWebhookSubscriptionsController::class, 'destroy']);
