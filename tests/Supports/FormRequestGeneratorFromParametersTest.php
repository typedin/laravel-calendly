<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\DTO\DestroyFormRequestDTO;
use Typedin\LaravelCalendly\Supports\DTO\IndexFormRequestDTO;
use Typedin\LaravelCalendly\Supports\DTO\ShowFormRequestDTO;
use Typedin\LaravelCalendly\Supports\DTO\StoreFormRequestDTO;
use Typedin\LaravelCalendly\Supports\FormRequestGeneratorFromParameters;

class FormRequestGeneratorFromParametersTest extends TestCase
{
    /**
     * @return array<TKey,TValue>
     */
    private function path(mixed $filter): array
    {
        $content = file_get_contents(__DIR__.'/../__fixtures__/api.json');

        return collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR)['paths'][$filter])->all();
    }

    /**
     * @dataProvider ScheduledEventsProvider
     *
     * @test
     */
    public function it_generates_rules_for_index_form_request($property, $expected_rules): void
    {
        $validator = ( new FormRequestGeneratorFromParameters(new IndexFormRequestDTO(path: '/scheduled_events', name:'ScheduledEvents', value: $this->path('/scheduled_events'))) )->validator;

        $this->assertEquals('Illuminate\Foundation\Http\FormRequest', $validator->getExtends());
        $this->assertEquals('IndexScheduledEventsRequest', $validator->getName());

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $validator->getMethod('rules')->getBody());
    }

    public function ScheduledEventsProvider(): array
    {
        return [
            ['user', 'url'],
            ['organization', 'url'],
            ['invitee_email', 'email'],
            ['status', 'in:active,canceled'],
            ['sort', 'string'],
            ['max_start_time', 'date'],
            ['min_start_time', 'date'],
        ];
    }

    /**
     * @dataProvider EventTypesProvider
     *
     * @test
     */
    public function it_generates_rules_for_event_types($property, $expected_rules): void
    {
        $validator = ( new FormRequestGeneratorFromParameters(new IndexFormRequestDTO(path: '/event_types', name:'EventTypes', value: $this->path('/event_types'))) )->validator;

        $this->assertEquals('Illuminate\Foundation\Http\FormRequest', $validator->getExtends());
        $this->assertEquals('IndexEventTypesRequest', $validator->getName());

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $validator->getMethod('rules')->getBody());
    }

    public function EventTypesProvider(): array
    {
        return [
            ['active', 'boolean'],
            ['organization', 'url'],
            ['user', 'url'],
            ['sort', 'string'],
        ];
    }

    /**
     * @dataProvider ScheduledEventInviteesProvider
     *
     * @test
     */
    public function it_generates_show_form_request($property, $expected_rules): void
    {
        $dto = new ShowFormRequestDTO(path: '/scheduled_events/{event_uuid}/invitees/{invitee_uuid}', name: 'ScheduledEvents', value: $this->path('/scheduled_events/{event_uuid}/invitees/{invitee_uuid}'));
        $sut = ( new FormRequestGeneratorFromParameters($dto) );

        $this->assertEquals('Illuminate\Foundation\Http\FormRequest', $sut->validator->getExtends());
        $this->assertEquals('ShowScheduledEventRequest', $sut->validator->getName());
        $rules = $sut->validator->getMethod('rules');

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $rules->getBody());
    }

    public function ScheduledEventInviteesProvider(): array
    {
        return [
            ['event_uuid', 'required,string'],
            ['invitee_uuid', 'required,string'],
        ];
    }

    /**
     * @test
     */
    public function it_generates_post_form_request(): void
    {
        $dto = new StoreFormRequestDTO(path: '/organizations/{uuid}/invitations', name: 'OrganizationInviations', value: $this->path('/organizations/{uuid}/invitations'));

        $sut = ( new FormRequestGeneratorFromParameters($dto) );
        $this->assertEquals('Illuminate\Foundation\Http\FormRequest', $sut->validator->getExtends());

        $this->assertEquals('StoreOrganizationInviationRequest', $sut->validator->getName());
        $rules = $sut->validator->getMethod('rules');

        $this->assertStringContainsString("'uuid' => 'required,string", $rules);
        $this->assertStringContainsString("'email' => 'required,email", $rules);
    }

    /**
     * @dataProvider DestroyOrganizationMembershipRequestsProvider
     *
     * @test
     */
    public function it_generates_destroy_form_request($property, $expected_rules): void
    {
        $dto = new DestroyFormRequestDTO(path: '/organization_memberships/{uuid}', name: 'OrganizationMemberships', value: $this->path('/organization_memberships/{uuid}'));
        $sut = ( new FormRequestGeneratorFromParameters($dto) );
        $this->assertEquals('Illuminate\Foundation\Http\FormRequest', $sut->validator->getExtends());

        $this->assertEquals('DestroyOrganizationMembershipRequest', $sut->validator->getName());
        $rules = $sut->validator->getMethod('rules');

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $rules->getBody());
    }

    public function DestroyOrganizationMembershipRequestsProvider(): array
    {
        return [
            ['uuid', 'required,string'],
        ];
    }
}
