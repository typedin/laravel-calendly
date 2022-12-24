<?php

namespace Typedin\LaravelCalendly\Supports;

use Nette\PhpGenerator\ClassType;

class ClassGenerator
{
    private ClassType $class;

    private function __construct(private readonly string $tag)
    {
    }

    public static function generate(string $tag, array $array): ClassType
    {
        $generator = new self($tag, $array);
        $generator->class = new ClassType($generator->entityName().'ApiClient');

        collect($array)->each(fn ($value) => $generator->generateMethodsForUri($value['methods']));

        return $generator->class;
    }

    private function entityName(): string
    {
        return implode(explode(' ', $this->tag));
    }

    private function generateMethodsForUri($methods): void
    {
        collect($methods)
                ->each(fn ($method, $key) => $this->class->addMember(MethodGenerator::generate($key, $method, $this->entityName())));
    }
}
