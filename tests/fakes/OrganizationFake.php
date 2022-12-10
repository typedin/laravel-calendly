<?php

namespace Typedin\LaravelCalendly\Tests\fakes;

use Faker\Factory;
use Typedin\LaravelCalendly\Entities\Organization\CalendlyOrganization;

class OrganizationFake
{
    /**
     * @return CalendlyOrganization
     */
    public function __invoke(): CalendlyOrganization
    {
        $faker = Factory::create();

        return new CalendlyOrganization([
            'uri' => 'https://api.calendly.com/organizations/'.$faker->uuid(),
            'plan' => array_rand(['basic ', 'essentials', 'professional', 'teams', 'enterprise']),
            'stage' => array_rand(['trial', 'free', 'paid']),
            'created_at' => $faker->dateTime(),
            'updated_at' => $faker->dateTime(),
        ]);
    }
}
