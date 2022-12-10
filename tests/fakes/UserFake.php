<?php

namespace Typedin\LaravelCalendly\Tests\fakes;

use Faker\Factory;
use Typedin\LaravelCalendly\Entities\User\CalendlyUser;

class UserFake
{
    /**
     * @return CalendlyUser
     */
    public function __invoke(): CalendlyUser
    {
        $faker = Factory::create();

        return new CalendlyUser([
            'uri' => 'https://api.calendly.com/users/'.$faker->uuid(),
            'name' => $faker->name(),
            'slug' => $faker->slug(),
            'email' => $faker->email(),
            'scheduling_url' => $faker->url(),
            'timezone' => $faker->timezone(),
            'avatar_url' => 'https://01234567890.cloudfront.net/uploads/user/avatar/0123456/a1b2c3d4.png',
            'created_at' => $faker->dateTime(),
            'updated_at' => $faker->dateTime(),
            'current_organization' => 'https://api.calendly.com/organizations/'.$faker->uuid(),
        ]);
    }
}
