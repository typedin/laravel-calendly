<?php

namespace Typedin\LaravelCalendly\Actions;

use Nette\PhpGenerator\PhpNamespace;

class GeneratedFileManager
{
    /**
     * @return void
     */
    public static function writeAll(PhpNamespace $namespace, string $destination): void
    {
        foreach ($namespace->getClasses() as $class) {
            // the @ suppresses the warning
            $return_value = @file_put_contents($destination.$class->getName().'.php', $class->__toString());
            if (! $return_value) {
                throw new \Exception(sprintf('Could not write file (%s) in folder: %s', $class->getName().'.php', $destination));
            }
        }
    }
}
