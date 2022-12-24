<?php

namespace Typedin\LaravelCalendly\Supports;

use Nette\PhpGenerator\ClassType;

class ClassGenerator
{
    private ClassType $class;

    private function __construct(private string $tag, private array $array)
    {
    }

    public static function generate(string $tag, array $array): ClassType
    {
        $generator = new self($tag, $array);
        $generator->class = new ClassType($generator->classname());

        collect($array)->each(fn ($value) => $generator->generateMethodsForUri($value['methods']));

        return $generator->class;
    }

    private function classname(): string
    {
        return  implode(explode(' ', $this->tag)).'ApiClient';
    }

    private function generateMethodsForUri($methods): void
    {
        collect($methods)->each(fn ($method, $key) => $this->class->addMember(MethodGenerator::generate($key, $method)));
    }
}
