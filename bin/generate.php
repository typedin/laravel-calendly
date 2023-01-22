#!/usr/bin/env php

<?php

$root = dirname(__DIR__);

if (! is_file(sprintf('%s/vendor/autoload.php', $root))) {
    $root = dirname(__DIR__, 4);
}

require sprintf('%s/vendor/autoload.php', $root);

use Symfony\Component\Console\Application;
use Typedin\LaravelCalendly\Commands\GenerateFiles;

$command = new GenerateFiles();
$application = new Application();

$application->add($command);
$application->setDefaultCommand($command->getName());
$application->run();
