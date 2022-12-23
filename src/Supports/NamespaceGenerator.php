<?php

namespace Typedin\LaravelCalendly\Supports;

use Nette\PhpGenerator\PhpNamespace;

class NamespaceGenerator
{
    public static function generate(array $array): PhpNamespace
    {
        $namespace = new PhpNamespace("Typedin\LaravelCalendly\Api");

        collect(array_keys(Mapper::LOOKUP))->each(function ($tag) use ($array, $namespace) {
            $mapped = (new Mapper($array, $tag))->handle();
            $class = ClassGenerator::generate($tag, $mapped->all());

            $namespace->add($class);
        });

        return $namespace;
    }
}
