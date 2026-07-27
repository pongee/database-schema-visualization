<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Parser;

use Override;

final class MariadbParser extends MysqlParser
{
    #[Override]
    protected function getCreateTablePattern(): string
    {
        return 'CREATE\s+(?:OR\s+REPLACE\s+)?TABLE';
    }

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
