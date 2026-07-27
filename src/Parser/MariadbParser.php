<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Parser;

use Override;

final class MariadbParser extends MysqlParser
{
    #[Override]
    protected function getCreateTableConditions(string $schema): array
    {
        $schema = preg_replace(
            '/\bCREATE\s+OR\s+REPLACE\s+TABLE\b/i',
            'CREATE TABLE',
            $schema
        );

        return parent::getCreateTableConditions($schema);
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
