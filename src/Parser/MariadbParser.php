<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Parser;

use Override;

final class MariadbParser extends MysqlParser
{
    /**
     * @return list<string>
     */
    #[Override]
    protected function getColumnTypes(): array
    {
        return [
            ...parent::getColumnTypes(),
            'UUID',
            'INET4',
            'INET6',
        ];
    }
}
