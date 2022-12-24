<?php

namespace Typedin\LaravelCalendly\Supports;

use Nette\PhpGenerator\ClassType;

class ClassGenerator
{
    public static function generate(string $tag, array $array): ClassType
    {
        $classname = implode(explode(' ', $tag)).'ApiClient';
        $class = new ClassType($classname);
        // TODO clean this
        foreach ($array as $key => $value) {
            foreach ($value['methods'] as $key => $fuck) {
                $class->addMember(MethodGenerator::generate($key, $fuck));
            }
        }

        return $class;
    }
}
