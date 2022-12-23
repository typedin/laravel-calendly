<?php

namespace Typedin\LaravelCalendly\Supports;

use Nette\PhpGenerator\PhpNamespace;

class CreateFile
{
    public function __construct(private PhpNamespace $namespace)
    {
    }

    public function write()
    {
        foreach ($this->namespace->getClasses() as $class) {
            file_put_contents(__DIR__.'/../../tests/output/'.$class->getName().'.php', $class->__toString());
        }
    }
}
