<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Parser;

use Override;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;

final class MariadbParser extends MysqlParser
{
    #[Override]
    public function run(
        string $nativeSqlSchema,
        ConnectionCollectionInterface $forcedConnectionCollection
    ): SchemaInterface {
        $nativeSqlSchema = preg_replace(
            '/\bCREATE\s+OR\s+REPLACE\s+TABLE\b/i',
            'CREATE TABLE',
            $nativeSqlSchema
        );

        return parent::run($nativeSqlSchema, $forcedConnectionCollection);
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
