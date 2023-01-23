#!/usr/bin/env php

<?php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Typedin\LaravelCalendly\Commands\GenerateFiles;

$application = new Application();
$command = new GenerateFiles();

$application->add($command);
$application->run();
