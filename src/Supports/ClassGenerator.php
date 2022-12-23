<?php

namespace Typedin\LaravelCalendly\Supports;

use Nette\PhpGenerator\ClassType;

class ClassGenerator
{
    public static function generate(array $array): ClassType
    {
        $class = new ClassType('ScheduledEventsApiClient');

        foreach ($array as $key => $value) {
            foreach ($value['methods'] as $key => $fuck) {
                $class->addMember(MethodGenerator::generate($key, $fuck));
            }
        }

        return $class;
    }
}
