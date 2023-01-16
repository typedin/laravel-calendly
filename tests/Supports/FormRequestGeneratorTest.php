<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\FormRequestGenerator;

class FormRequestGeneratorTest extends TestCase
{
    /**
     * @return array<TKey,TValue>
     */
    private function schema($filter): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/api.json');

        return collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR)['components']['schemas'][$filter])->all();
    }

    /**
     * @test
     */
    public function it_generates_controller_name_and_namespace(): void
    {
        $generated_class = ( new FormRequestGenerator('EventType', $this->schema('EventType')) )->validator;

        $this->assertEquals('EventTypeRequest', $generated_class->getName());
    }

    /**
     * @dataProvider ruleProvider
     *
     * @test
     */
    public function it_generates_rules($a, $b): void
    {
        $rules = ( new FormRequestGenerator('EventType', $this->schema('EventType')) )->validator->getMethod('rules');


        $this->assertStringContainsString('return [', $rules->getBody());
        $this->assertStringContainsString('];', $rules->getBody());

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $a, $b), $rules->getBody());
    }
    
    public function ruleProvider(): array {
        return [
            [ 'name' , "required,string" ],
            [ 'slug' , "required,string" ] ,
            [ 'kind_description', "required,in:Collective,Group,One-on-One,Round Robin"],
            [ 'color', "required,regex:^#[a-f\\d]{6}$"],
            /* "kind", => enum */
            /* "pooling_type",=> enum  */
            /* "type", => enum */
            /* "kind", => enum */
            /* "pooling_type",=> enum  */
            /* "type", => enum */
            /* "booking_method", */
            /* "custom_questions", */
            /* "deleted_at", */
            /* "kind_description", */
            /* 'active', */
            /* "admin_managed" */
            /* "secret", => boolean*/
            /* 'uri', */
            /* 'scheduling_url', */
            /* "duration", */
            /* "created_at", */
            /* "updated_at", */
            /* "internal_note", */
            /* "description_plain", */
            /* "description_html", */
            /* "profile", */
            /* "custom_questions", => array */
            /* "deleted_at", */
            /* "admin_managed" */
        ];
    }
}
