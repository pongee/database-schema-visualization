<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/test',
    ])
    ->withPreparedSets(
        typeDeclarations: true,
        privatization: true,
        earlyReturn: true
    )
    ->withPhpSets(php85: true)
    ->withDeadCodeLevel(30)
    ->withCodeQualityLevel(20);
