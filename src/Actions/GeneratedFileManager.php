<?php

namespace Typedin\LaravelCalendly\Actions;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;

class GeneratedFileManager
{
    public static function writeAll(PhpNamespace $namespace, string $destination): void
    {
        foreach ($namespace->getClasses() as $class) {
            $content = '<?php'.PHP_EOL."\n";
            $content = $content.$class->__toString();
            // the @ suppresses the warning
            $return_value = @file_put_contents($destination.$class->getName().'.php', $content);
            if (! $return_value) {
                throw new \Exception(sprintf('Could not write file (%s) in folder: %s', $class->getName().'.php', $destination));
            }
        }
    }

    public static function write(string $path, ClassType $class, PhpNamespace $namespace): void
    {
        $content = '<?php'.PHP_EOL."\n";
        $content = $content.$namespace;
        $content = $content.$class->__toString();
        // the @ suppresses the warning
        $return_value = @file_put_contents($path.$class->getName().'.php', $content);
        if (! $return_value) {
            throw new \Exception(sprintf('Could not write file (%s) in folder: %s', $class->getName().'.php', $path));
        }
    }
}
