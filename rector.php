<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/config',
        __DIR__.'/src',
        __DIR__.'/tests',
    ]);

    $rectorConfig->skip([
        __DIR__.'/tests/fakes',
        __DIR__.'/tests/CalendlyTestCase.php',
    ]);
    // register a single rule
    /* $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class); */
    $rectorConfig->skip([
        InlineConstructorDefaultToPropertyRector::class => [
            __DIR__.'/src/Entities/*',
        ],
    ]);

    // define sets of rules
    $rectorConfig->sets([
        SetList::EARLY_RETURN,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        LevelSetList::UP_TO_PHP_82,
    ]);
};
