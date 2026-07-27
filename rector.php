<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withRootFiles()
    ->withPreparedSets(
        deadCode: true,
        typeDeclarations: true,
        privatization: true,
        earlyReturn: true
    )
    ->withPhpSets()
    ->withCodeQualityLevel(20);
