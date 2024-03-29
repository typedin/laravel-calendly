<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/routes',
        __DIR__.'/config',
        __DIR__.'/src',
        __DIR__.'/tests',
    ]);

    $rectorConfig->skip([
        ClassPropertyAssignToConstructorPromotionRector::class,
        __DIR__.'/tests/fakes',
    ]);
    $rectorConfig->importNames();
    // define sets of rules
    $rectorConfig->sets([
        SetList::EARLY_RETURN,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        LevelSetList::UP_TO_PHP_82,
    ]);
};
