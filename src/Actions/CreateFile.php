<?php

namespace Typedin\LaravelCalendly\Supports;

use Nette\PhpGenerator\PhpNamespace;

class CreateFile
{
    public function __construct(private PhpNamespace $namespace)
    {
    }

    /**
     * @return void
     */
    public function write(string $path): void
    {
        foreach ($this->namespace->getClasses() as $class) {
            file_put_contents($path.$class->getName().'.php', $class->__toString());
        }
    }
}
